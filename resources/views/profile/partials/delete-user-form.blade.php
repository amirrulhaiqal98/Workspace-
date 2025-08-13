<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Danger Zone
        </h3>
    </div>
    <div class="card-body">
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-triangle"></i> Warning: Account Deletion</h5>
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </div>

        <div class="callout callout-danger">
            <h5><i class="fas fa-info-circle"></i> What will be deleted:</h5>
            <ul class="mb-0">
                <li><i class="fas fa-folder mr-1"></i> All your workspaces ({{ Auth::user()->workspaces()->count() }} total)</li>
                <li><i class="fas fa-tasks mr-1"></i> All your tasks ({{ Auth::user()->workspaces()->withCount('tasks')->get()->sum('tasks_count') }} total)</li>
                <li><i class="fas fa-user mr-1"></i> Your profile information</li>
                <li><i class="fas fa-envelope mr-1"></i> Account settings and preferences</li>
            </ul>
        </div>

        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
            <i class="fas fa-trash mr-1"></i> Delete Account
        </button>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteAccountModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Confirm Account Deletion
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-exclamation-triangle"></i> Are you absolutely sure?</h6>
                        This action <strong>cannot be undone</strong>. This will permanently delete your account and remove all your data from our servers.
                    </div>

                    <div class="form-group">
                        <label for="delete_password">
                            <i class="fas fa-key"></i> Please enter your password to confirm <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" 
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                   id="delete_password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Enter your password to confirm deletion">
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="confirmDeletion" required>
                            <label class="custom-control-label" for="confirmDeletion">
                                <strong>I understand that this action is permanent and cannot be undone</strong>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger" id="deleteAccountBtn" disabled>
                        <i class="fas fa-trash mr-1"></i> Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Enable delete button only when checkbox is checked and password is entered
    $('#confirmDeletion, #delete_password').on('change keyup', function() {
        const checkboxChecked = $('#confirmDeletion').is(':checked');
        const passwordEntered = $('#delete_password').val().length > 0;
        
        $('#deleteAccountBtn').prop('disabled', !(checkboxChecked && passwordEntered));
    });
    
    // Show modal if there are validation errors
    @if($errors->userDeletion->isNotEmpty())
        $('#deleteAccountModal').modal('show');
    @endif
});
</script>
