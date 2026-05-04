<?php $this->load->view('admin/partials/header'); ?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f8fafc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* ===== PAGE HEADER ===== */
    .page-header {
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-header-content h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .page-header-content p {
        font-size: 15px;
        color: #64748b;
        line-height: 1.6;
    }

    .page-header-actions {
        display: flex;
        gap: 12px;
    }

    .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: none;
        background: #e2e8f0;
        color: #475569;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        background: #cbd5e1;
        color: #1e293b;
    }

    /* ===== PROFILE HEADER SECTION ===== */
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 40px;
        color: white;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: 10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
    }

    .profile-header-content {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 30px;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .profile-avatar-large {
        width: 140px;
        height: 140px;
        border-radius: 24px;
        overflow: hidden;
        border: 6px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.15);
        flex-shrink: 0;
    }

    .profile-avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .profile-info h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .profile-info p {
        font-size: 15px;
        opacity: 0.95;
        margin-bottom: 16px;
    }

    .profile-meta {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .meta-item .label {
        font-size: 12px;
        font-weight: 600;
        opacity: 0.85;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .meta-item .value {
        font-size: 14px;
        font-weight: 500;
    }

    .profile-status-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(16, 185, 129, 0.2);
        padding: 8px 16px;
        border-radius: 20px;
        width: fit-content;
        border: 1px solid rgba(16, 185, 129, 0.4);
    }

    .status-dot {
        width: 10px;
        height: 10px;
        background: #10b981;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .profile-status-badge span {
        font-size: 13px;
        font-weight: 600;
    }

    /* ===== TABS ===== */
    .tabs-container {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 40px;
        overflow-x: auto;
    }

    .tab-button {
        padding: 16px 24px;
        border: none;
        background: none;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        position: relative;
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    .tab-button:hover {
        color: #1e293b;
    }

    .tab-button.active {
        color: #667eea;
    }

    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* ===== FORM SECTIONS ===== */
    .section-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 40px;
    }

    .form-section {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
    }

    .form-section-header {
        margin-bottom: 24px;
    }

    .form-section-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .form-section-header p {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
    }

    .form-group {
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        letter-spacing: 0.2px;
    }

    .form-group input,
    .form-group textarea {
        padding: 12px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #f8fafc;
        color: #1e293b;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-group input:disabled {
        background: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
    }

    .form-hint {
        font-size: 12px;
        color: #64748b;
        margin-top: 6px;
        line-height: 1.5;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-row.full {
        grid-column: 1 / -1;
    }

    /* ===== FILE UPLOAD ===== */
    .file-upload-wrapper {
        position: relative;
    }

    .file-upload-input {
        display: none;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 140px;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-label:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }

    .file-upload-label.has-file {
        border-style: solid;
        border-color: #10b981;
        background: #f0fdf4;
    }

    .upload-content {
        text-align: center;
    }

    .upload-icon {
        font-size: 32px;
        margin-bottom: 8px;
        display: block;
    }

    .upload-text {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .upload-subtext {
        font-size: 12px;
        color: #94a3b8;
    }

    .file-preview {
        margin-top: 16px;
        text-align: center;
    }

    .file-preview-image {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .file-preview-name {
        font-size: 13px;
        color: #1e293b;
        word-break: break-all;
    }

    /* ===== BUTTONS ===== */
    .button-group {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    .btn {
        padding: 12px 28px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #1e293b;
        border: 1.5px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        border-color: #cbd5e1;
    }

    .btn-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1.5px solid #fecaca;
    }

    .btn-danger:hover {
        background: #fecaca;
    }

    /* ===== ALERTS ===== */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 14px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border: 1.5px solid;
    }

    .alert-icon {
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .alert-message {
        font-size: 13px;
        line-height: 1.5;
    }

    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border-color: #a7f3d0;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }

    .alert-warning {
        background: #fffbeb;
        color: #92400e;
        border-color: #fcd34d;
    }

    .alert-info {
        background: #eff6ff;
        color: #0c4a6e;
        border-color: #bae6fd;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .page-wrapper {
            padding: 20px 16px;
        }

        .profile-header {
            padding: 24px;
            margin-bottom: 32px;
        }

        .profile-header-content {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .profile-avatar-large {
            margin: 0 auto;
        }

        .profile-info {
            text-align: center;
        }

        .profile-meta {
            justify-content: center;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .section-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-section {
            padding: 24px;
        }

        .tabs-container {
            margin-bottom: 24px;
        }

        .tab-button {
            padding: 12px 16px;
            font-size: 13px;
        }

        .profile-info h2 {
            font-size: 22px;
        }

        .page-header-content h1 {
            font-size: 24px;
        }
    }

    @media (max-width: 480px) {
        .page-wrapper {
            padding: 16px 12px;
        }

        .profile-avatar-large {
            width: 100px;
            height: 100px;
        }

        .profile-info h2 {
            font-size: 18px;
        }

        .page-header-content h1 {
            font-size: 20px;
        }

        .meta-item {
            flex: 1;
            min-width: 120px;
        }

        .button-group {
            flex-direction: column;
            gap: 8px;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-wrapper">
    <!-- PAGE HEADER -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>Profile Settings</h1>
            <p>Manage your account information and preferences</p>
        </div>
        <div class="page-header-actions">
            <button class="btn-icon" title="Refresh">🔄</button>
            <button class="btn-icon" title="Help">❓</button>
        </div>
    </div>

    <!-- PROFILE HEADER SECTION -->
    <div class="profile-header">
        <div class="profile-header-content">
            <!-- Avatar -->
            <div class="profile-avatar-large">
                <img src="<?php echo app_profile_image_url(isset($profile_user['profile_image']) ? $profile_user['profile_image'] : ''); ?>" alt="<?php echo html_escape($profile_user['full_name']); ?>">
            </div>

            <!-- Profile Info -->
            <div class="profile-info">
                <h2><?php echo html_escape($profile_user['full_name']); ?></h2>
                <p>Administrator Account</p>
                <div class="profile-meta">
                    <div class="meta-item">
                        <span class="label">Email</span>
                        <span class="value"><?php echo html_escape($profile_user['email']); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="label">Phone</span>
                        <span class="value"><?php echo html_escape($profile_user['phone']); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="label">Member Since</span>
                        <span class="value"><?php echo !empty($profile_user['created_at']) ? date('d M Y', strtotime($profile_user['created_at'])) : 'N/A'; ?></span>
                    </div>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="profile-status-badge">
                <span class="status-dot"></span>
                <span>Active</span>
            </div>
        </div>
    </div>

    <!-- TABS -->
    <div class="tabs-container">
        <button class="tab-button active" onclick="switchTab(event, 'edit-profile')">
            👤 Edit Profile
        </button>
        <button class="tab-button" onclick="switchTab(event, 'change-password')">
            🔐 Change Password
        </button>
        <button class="tab-button" onclick="switchTab(event, 'activity')">
            📊 Activity
        </button>
    </div>

    <!-- TAB CONTENT -->

    <!-- EDIT PROFILE TAB -->
    <div id="edit-profile" class="tab-content active">
        <div class="section-grid">
            <!-- PERSONAL INFORMATION -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3>Personal Information</h3>
                    <p>Update your personal details displayed across the platform.</p>
                </div>

                <form method="post" action="<?php echo base_url('admin/profile/update'); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?php echo html_escape($profile_user['full_name']); ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" value="<?php echo html_escape($profile_user['email']); ?>" required>
                            <div class="form-hint">Used for login and notifications</div>
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" value="<?php echo html_escape($profile_user['phone']); ?>" required>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            💾 Save Changes
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            ↺ Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- PROFILE PICTURE -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3>Profile Picture</h3>
                    <p>Update your profile photo shown in the admin header and user lists.</p>
                </div>

                <form method="post" action="<?php echo base_url('admin/profile/update'); ?>" enctype="multipart/form-data">
                    <div class="form-group file-upload-wrapper">
                        <label class="file-upload-label" for="profile_image" id="upload-label">
                            <div class="upload-content">
                                <span class="upload-icon">📤</span>
                                <p class="upload-text">Click to upload or drag and drop</p>
                                <p class="upload-subtext">JPG, PNG or WEBP (Max 4 MB)</p>
                            </div>
                        </label>
                        <input type="file" id="profile_image" name="profile_image" class="file-upload-input" accept=".jpg,.jpeg,.png,.webp">
                    </div>

                    <div class="form-hint">
                        ⚠️ Recommended dimensions: 400x400 pixels. If no image is selected, your current profile picture will remain unchanged.
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            🖼️ Upload Picture
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CHANGE PASSWORD TAB -->
    <div id="change-password" class="tab-content">
        <div class="section-grid">
            <div class="form-section">
                <div class="form-section-header">
                    <h3>Change Password</h3>
                    <p>Update your password regularly to keep your account secure. Use a strong password with at least 8 characters.</p>
                </div>

                <form method="post" action="<?php echo base_url('admin/profile/password'); ?>">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                        <div class="form-hint">Enter your current password to verify</div>
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" minlength="8" required>
                        <div class="form-hint">Must be at least 8 characters long</div>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" minlength="8" required>
                        <div class="form-hint">Re-enter your new password</div>
                    </div>

                    <div class="alert alert-info">
                        <span class="alert-icon">ℹ️</span>
                        <div class="alert-content">
                            <div class="alert-title">Strong Password Tips</div>
                            <div class="alert-message">Use a mix of uppercase, lowercase, numbers, and special characters for better security.</div>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            🔐 Update Password
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            Clear Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ACTIVITY TAB -->
    <div id="activity" class="tab-content">
        <div class="form-section">
            <div class="form-section-header">
                <h3>Account Activity</h3>
                <p>Review your recent account activity and login history</p>
            </div>

            <div class="alert alert-success">
                <span class="alert-icon">✅</span>
                <div class="alert-content">
                    <div class="alert-title">Account Status</div>
                    <div class="alert-message">Your account is in good standing and all systems are operational.</div>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="border-bottom: 2px solid #e2e8f0;">
                        <th style="text-align: left; padding: 12px; color: #64748b; font-weight: 600;">Activity</th>
                        <th style="text-align: left; padding: 12px; color: #64748b; font-weight: 600;">Date & Time</th>
                        <th style="text-align: left; padding: 12px; color: #64748b; font-weight: 600;">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; color: #1e293b;">Login</td>
                        <td style="padding: 12px; color: #64748b;">Today at 10:30 AM</td>
                        <td style="padding: 12px; color: #64748b;">192.168.1.100</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; color: #1e293b;">Profile Updated</td>
                        <td style="padding: 12px; color: #64748b;">Yesterday at 3:15 PM</td>
                        <td style="padding: 12px; color: #64748b;">192.168.1.100</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; color: #1e293b;">Password Changed</td>
                        <td style="padding: 12px; color: #64748b;">2 days ago at 9:00 AM</td>
                        <td style="padding: 12px; color: #64748b;">192.168.1.100</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function switchTab(event, tabName) {
        event.preventDefault();

        // Hide all tab contents
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => {
            content.classList.remove('active');
        });

        // Remove active class from all buttons
        const buttons = document.querySelectorAll('.tab-button');
        buttons.forEach(button => {
            button.classList.remove('active');
        });

        // Show selected tab content
        document.getElementById(tabName).classList.add('active');
        event.target.classList.add('active');
    }

    // File Upload Preview
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('profile_image');
        const uploadLabel = document.getElementById('upload-label');

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const files = e.target.files;
                if (files.length > 0) {
                    const file = files[0];
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        uploadLabel.innerHTML = `
                            <div class="upload-content">
                                <img src="${event.target.result}" class="file-preview-image" style="width: 100px; height: 100px; border-radius: 8px;">
                                <div class="file-preview-name">${file.name}</div>
                            </div>
                        `;
                        uploadLabel.classList.add('has-file');
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Drag and drop
            uploadLabel.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadLabel.style.borderColor = '#667eea';
                uploadLabel.style.background = '#f0f4ff';
            });

            uploadLabel.addEventListener('dragleave', function() {
                uploadLabel.style.borderColor = '#cbd5e1';
                uploadLabel.style.background = '#f8fafc';
            });

            uploadLabel.addEventListener('drop', function(e) {
                e.preventDefault();
                fileInput.files = e.dataTransfer.files;
                const event = new Event('change', {
                    bubbles: true
                });
                fileInput.dispatchEvent(event);
            });
        }
    });
</script>

<?php $this->load->view('admin/partials/footer'); ?>