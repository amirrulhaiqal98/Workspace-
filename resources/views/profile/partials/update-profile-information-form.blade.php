<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user mr-2"></i>
            Update Profile Information
        </h3>
    </div>
    <div class="card-body">
        <p class="text-muted mb-4">
            <i class="fas fa-info-circle mr-1"></i>
            Update your account's profile information and email address.
        </p>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <!-- Profile Picture Upload -->
            <div class="form-group">
                <label for="profile_picture">
                    <i class="fas fa-camera"></i> Profile Picture
                </label>
                <div class="row">
                    <div class="col-md-4">
                        <!-- Current Profile Picture Preview -->
                        <div class="text-center mb-3">
                            <div id="current-profile-preview" style="width: 120px; height: 120px; margin: 0 auto;">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                         alt="Current Profile Picture" 
                                         class="img-circle elevation-2" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div class="img-circle elevation-2 bg-primary d-flex align-items-center justify-content-center" 
                                         style="width: 100%; height: 100%;">
                                        <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                            </div>
                            @if($user->profile_picture)
                                <small class="text-muted d-block mt-2">Current picture</small>
                            @else
                                <small class="text-muted d-block mt-2">No picture uploaded</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <!-- File Upload Input -->
                        <div class="custom-file mb-3">
                            <input type="file" 
                                   class="custom-file-input @error('profile_picture') is-invalid @enderror" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   accept="image/*">
                            <label class="custom-file-label" for="profile_picture">Choose new profile picture</label>
                            @error('profile_picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- New Picture Preview (Hidden by default) -->
                        <div id="new-picture-preview" style="display: none;">
                            <div class="text-center">
                                <div style="width: 80px; height: 80px; margin: 0 auto;">
                                    <img id="preview-image" 
                                         alt="Preview" 
                                         class="img-circle elevation-2" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <small class="text-muted d-block mt-2">New picture preview</small>
                            </div>
                        </div>
                        
                        <!-- Upload Guidelines -->
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Recommended: Square image, max 2MB. Supports JPG, PNG, GIF formats.
                        </small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="name">
                    <i class="fas fa-user"></i> Full Name <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           placeholder="Enter your full name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="username">
                    <i class="fas fa-at"></i> Username <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                    </div>
                    <input type="text" 
                           class="form-control @error('username') is-invalid @enderror" 
                           id="username" 
                           name="username" 
                           value="{{ old('username', $user->username) }}" 
                           required 
                           autocomplete="username"
                           placeholder="Enter your username">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> This will be displayed as {{ $user->username }}
                </small>
            </div>

            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           required 
                           autocomplete="email"
                           placeholder="Enter your email address">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning mt-3">
                        <h5><i class="fas fa-exclamation-triangle"></i> Email Verification Required</h5>
                        Your email address is unverified.
                        <button form="send-verification" class="btn btn-link p-0 align-baseline">
                            <i class="fas fa-paper-plane"></i> Click here to re-send the verification email.
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success mt-2">
                                <i class="fas fa-check-circle"></i> A new verification link has been sent to your email address.
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                    <div class="col-sm-6">
                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 0;">
                                <i class="fas fa-check-circle"></i>
                                <strong>Success!</strong> Profile updated successfully.
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
document.addEventListener('DOMContentLoaded', function() {
    const profilePictureInput = document.getElementById('profile_picture');
    const previewContainer = document.getElementById('new-picture-preview');
    const previewImage = document.getElementById('preview-image');
    const fileLabel = document.querySelector('.custom-file-label');

    profilePictureInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Update the file label
            fileLabel.textContent = file.name;
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file.');
                this.value = '';
                fileLabel.textContent = 'Choose new profile picture';
                previewContainer.style.display = 'none';
                return;
            }
            
            // Validate file size (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                this.value = '';
                fileLabel.textContent = 'Choose new profile picture';
                previewContainer.style.display = 'none';
                return;
            }
            
            // Create file reader for preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            // Reset if no file selected
            fileLabel.textContent = 'Choose new profile picture';
            previewContainer.style.display = 'none';
        }
    });
});
</script>
