<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="split-grid">
    <section class="section-card">
        <div class="card-head">
            <div>
                <div class="eyebrow">Customer Details</div>
                <h3>Profile information that stays current.</h3>
                <p>Keep your contact details accurate so ride updates, approvals, and admin communication reach the right person quickly.</p>
            </div>
        </div>
        <form method="post" action="<?php echo base_url('profile/update'); ?>" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="full">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?php echo html_escape($profile_user['full_name']); ?>" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo html_escape($profile_user['email']); ?>" required>
                </div>
                <div>
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo html_escape($profile_user['phone']); ?>" required>
                </div>
                <div class="full">
                    <label>Profile Image</label>
                    <input type="file" name="profile_image" accept=".jpg,.jpeg,.png,.webp">
                    <div class="helper">Accepted formats: JPG, PNG, and WEBP. Leave empty if you want to keep the current image.</div>
                </div>
            </div>
            <div class="hero-actions">
                <button class="btn" type="submit">Save Profile</button>
            </div>
        </form>
    </section>

    <div style="display:grid;gap:22px;">
        <section class="section-card accent-card">
            <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                <div class="profile-avatar" style="width:86px;height:86px;border-radius:28px;">
                    <?php if (!empty($profile_user['profile_image'])): ?>
                        <img src="<?php echo app_profile_image_url($profile_user['profile_image']); ?>" alt="<?php echo html_escape($profile_user['full_name']); ?>">
                    <?php else: ?>
                        <?php echo html_escape(app_user_initials($profile_user['full_name'])); ?>
                    <?php endif; ?>
                </div>
                <div>
                    <h3 style="margin:0;"><?php echo html_escape($profile_user['full_name']); ?></h3>
                    <p style="margin:6px 0 0;color:var(--ink-2);"><?php echo html_escape($profile_user['email']); ?></p>
                </div>
            </div>
            <div class="info-grid" style="grid-template-columns:1fr;margin-top:20px;">
                <div class="feature-card">
                    <strong>Phone</strong>
                    <span><?php echo html_escape($profile_user['phone']); ?></span>
                </div>
                <div class="feature-card">
                    <strong>Role</strong>
                    <span>Customer account</span>
                </div>
                <div class="feature-card">
                    <strong>Status</strong>
                    <span><?php echo ((int) $profile_user['status'] === 1) ? 'Active' : 'Inactive'; ?></span>
                </div>
            </div>
        </section>

        <section class="section-card">
            <div class="card-head">
                <div>
                    <div class="eyebrow">Security</div>
                    <h3>Change password.</h3>
                    <p>Use a strong password to protect your booking history and personal details.</p>
                </div>
            </div>
            <form method="post" action="<?php echo base_url('profile/password'); ?>">
                <div class="form-grid">
                    <div class="full">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div>
                        <label>New Password</label>
                        <input type="password" name="new_password" minlength="6" required>
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" minlength="6" required>
                    </div>
                </div>
                <div class="hero-actions">
                    <button class="btn" type="submit">Update Password</button>
                </div>
            </form>
        </section>
    </div>
</div>
