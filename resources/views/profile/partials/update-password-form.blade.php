<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-lock mr-2"></i>
            Update Password
        </h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-shield-alt mr-1"></i>
            <strong>Security Tip:</strong> Ensure your account is using a long, random password to stay secure.
        </div>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="current_password">
                    <i class="fas fa-key"></i> Current Password <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" 
                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                           id="current_password" 
                           name="current_password" 
                           autocomplete="current-password"
                           placeholder="Enter your current password">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-eye toggle-password" data-target="current_password" style="cursor: pointer;"></i>
                        </span>
                    </div>
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> New Password <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" 
                           class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           autocomplete="new-password"
                           placeholder="Enter your new password">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-eye toggle-password" data-target="password" style="cursor: pointer;"></i>
                        </span>
                    </div>
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="progress mt-2" style="height: 5px;">
                    <div class="progress-bar" id="password-strength" role="progressbar" style="width: 0%"></div>
                </div>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> Use at least 8 characters with a mix of letters, numbers, and symbols
                </small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    <i class="fas fa-check-double"></i> Confirm New Password <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                    </div>
                    <input type="password" 
                           class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           autocomplete="new-password"
                           placeholder="Confirm your new password">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-eye toggle-password" data-target="password_confirmation" style="cursor: pointer;"></i>
                        </span>
                    </div>
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-lock mr-1"></i> Update Password
                        </button>
                    </div>
                    <div class="col-sm-6">
                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 0;">
                                <i class="fas fa-check-circle"></i>
                                <strong>Success!</strong> Password updated successfully.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Toggle password visibility
    $('.toggle-password').click(function() {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        const icon = $(this);
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    
    // Password strength meter
    $('#password').on('input', function() {
        const password = $(this).val();
        let strength = 0;
        let color = 'danger';
        
        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]/)) strength += 25;
        if (password.match(/[A-Z]/)) strength += 25;
        if (password.match(/[0-9]/)) strength += 12.5;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 12.5;
        
        if (strength >= 75) color = 'success';
        else if (strength >= 50) color = 'warning';
        else if (strength >= 25) color = 'info';
        
        $('#password-strength')
            .removeClass('bg-danger bg-warning bg-info bg-success')
            .addClass('bg-' + color)
            .css('width', strength + '%');
    });
});
</script>
