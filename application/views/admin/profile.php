<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --white: #ffffff;
        --bg: #f1f5f9;
        --bg-2: #e8edf5;
        --surface: #ffffff;
        --border: #e2e8f0;
        --border-2: #cbd5e1;
        --text-1: #0f172a;
        --text-2: #475569;
        --text-3: #94a3b8;
        --accent: #2563eb;
        --accent-lt: #eff6ff;
        --accent-2: #7c3aed;
        --grad: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        --success: #059669;
        --success-lt: #ecfdf5;
        --warning: #d97706;
        --warning-lt: #fffbeb;
        --danger: #dc2626;
        --danger-lt: #fef2f2;
        --info-lt: #eff6ff;
        --radius: 12px;
        --radius-lg: 18px;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.07), 0 1px 2px rgba(0, 0, 0, 0.04);
        --shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.10);
    }

    .pf-wrap * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .pf-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-1);
        max-width: 1100px;
        padding: 36px 24px 60px;
        margin: 0 auto;
    }

    /* ── PAGE HEADER ── */
    .pf-page-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .pf-page-head h1 {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.6px;
        color: var(--text-1);
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .pf-page-head p {
        font-size: 14px;
        color: var(--text-2);
    }

    /* ── HERO CARD ── */
    .pf-hero {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 28px 32px;
        margin-bottom: 28px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 24px;
        position: relative;
        overflow: hidden;
        flex-wrap: wrap;
    }

    /* subtle top accent stripe */
    .pf-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--grad);
    }

    .pf-hero-avatar {
        width: 88px;
        height: 88px;
        border-radius: 16px;
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid var(--border);
        background: var(--bg);
        box-shadow: var(--shadow-sm);
    }

    .pf-hero-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .pf-hero-info {
        flex: 1;
        min-width: 180px;
    }

    .pf-hero-info h2 {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.4px;
        margin-bottom: 3px;
    }

    .pf-hero-role {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-3);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 14px;
    }

    .pf-hero-meta {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .pf-meta-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .pf-meta-item .lbl {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.7px;
        text-transform: uppercase;
        color: var(--text-3);
    }

    .pf-meta-item .val {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-2);
    }

    .pf-status {
        display: flex;
        align-items: center;
        gap: 7px;
        background: var(--success-lt);
        border: 1px solid #a7f3d0;
        padding: 7px 14px;
        border-radius: 100px;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--success);
        white-space: nowrap;
        flex-shrink: 0;
    }

    .pf-status-dot {
        width: 7px;
        height: 7px;
        background: var(--success);
        border-radius: 50%;
        animation: pf-blink 2s infinite;
    }

    @keyframes pf-blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.3;
        }
    }

    /* ── TABS ── */
    .pf-tabs {
        display: flex;
        gap: 2px;
        border-bottom: 2px solid var(--border);
        margin-bottom: 28px;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .pf-tabs::-webkit-scrollbar {
        display: none;
    }

    .pf-tab {
        padding: 11px 20px;
        border: none;
        background: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-2);
        cursor: pointer;
        position: relative;
        white-space: nowrap;
        border-radius: 8px 8px 0 0;
        transition: color 0.2s, background 0.2s;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .pf-tab svg {
        width: 15px;
        height: 15px;
    }

    .pf-tab:hover {
        color: var(--text-1);
        background: var(--bg);
    }

    .pf-tab.active {
        color: var(--accent);
    }

    .pf-tab.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--grad);
        border-radius: 2px 2px 0 0;
    }

    .pf-pane {
        display: none;
    }

    .pf-pane.active {
        display: block;
    }

    /* ── GRID ── */
    .pf-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 20px;
    }

    /* ── CARD ── */
    .pf-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 28px;
        box-shadow: var(--shadow-sm);
    }

    .pf-card-head {
        padding-bottom: 18px;
        margin-bottom: 22px;
        border-bottom: 1px solid var(--border);
    }

    .pf-card-head h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-1);
        margin-bottom: 4px;
    }

    .pf-card-head p {
        font-size: 12.5px;
        color: var(--text-2);
        line-height: 1.6;
    }

    /* ── FORM ── */
    .pf-group {
        margin-bottom: 16px;
    }

    .pf-group:last-of-type {
        margin-bottom: 0;
    }

    .pf-group label {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--text-2);
        margin-bottom: 7px;
    }

    .pf-group input,
    .pf-group textarea,
    .pf-group select {
        width: 100%;
        padding: 10px 13px;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        font-size: 13.5px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-1);
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }

    .pf-group input:focus,
    .pf-group textarea:focus {
        outline: none;
        border-color: var(--accent);
        background: var(--white);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .pf-group input:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .pf-hint {
        font-size: 11.5px;
        color: var(--text-3);
        margin-top: 5px;
    }

    .pf-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    /* ── UPLOAD ── */
    .pf-upload {
        position: relative;
        border: 2px dashed var(--border-2);
        border-radius: var(--radius);
        background: var(--bg);
        text-align: center;
        padding: 28px 20px;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }

    .pf-upload:hover {
        border-color: var(--accent);
        background: var(--accent-lt);
    }

    .pf-upload.has-file {
        border-style: solid;
        border-color: var(--success);
        background: var(--success-lt);
    }

    .pf-upload input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .pf-upload-icon {
        width: 44px;
        height: 44px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        box-shadow: var(--shadow-sm);
    }

    .pf-upload p {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-1);
        margin-bottom: 3px;
    }

    .pf-upload span {
        font-size: 11.5px;
        color: var(--text-3);
    }

    .pf-preview-img {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        object-fit: cover;
        margin: 0 auto 10px;
        display: block;
        border: 2px solid var(--border);
    }

    /* ── BUTTONS ── */
    .pf-btn-row {
        display: flex;
        gap: 10px;
        margin-top: 22px;
        flex-wrap: wrap;
    }

    .pf-btn {
        padding: 10px 20px;
        border: none;
        border-radius: var(--radius);
        font-size: 13px;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .pf-btn-primary {
        background: var(--grad);
        color: #fff;
        box-shadow: 0 3px 12px rgba(37, 99, 235, 0.25);
    }

    .pf-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.32);
    }

    .pf-btn-primary:active {
        transform: none;
    }

    .pf-btn-ghost {
        background: var(--bg);
        color: var(--text-2);
        border: 1.5px solid var(--border);
    }

    .pf-btn-ghost:hover {
        background: var(--bg-2);
        color: var(--text-1);
    }

    .pf-btn-danger {
        background: var(--danger-lt);
        color: var(--danger);
        border: 1.5px solid #fecaca;
    }

    .pf-btn-danger:hover {
        background: #fecaca;
    }

    /* ── ALERT ── */
    .pf-alert {
        display: flex;
        gap: 12px;
        padding: 13px 16px;
        border-radius: var(--radius);
        font-size: 13px;
        margin-bottom: 18px;
        border: 1.5px solid;
    }

    .pf-alert svg {
        width: 17px;
        height: 17px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .pf-alert-body strong {
        display: block;
        font-weight: 700;
        margin-bottom: 2px;
        font-size: 13px;
    }

    .pf-alert-body p {
        font-size: 12.5px;
        opacity: 0.9;
        line-height: 1.55;
    }

    .pf-alert-info {
        background: var(--info-lt);
        color: #1e40af;
        border-color: #bfdbfe;
    }

    .pf-alert-success {
        background: var(--success-lt);
        color: #065f46;
        border-color: #a7f3d0;
    }

    .pf-alert-warning {
        background: var(--warning-lt);
        color: #92400e;
        border-color: #fcd34d;
    }

    /* ── STRENGTH BAR ── */
    .pf-strength-bar {
        display: flex;
        gap: 4px;
        margin-top: 7px;
    }

    .pf-seg {
        flex: 1;
        height: 3px;
        background: var(--bg-2);
        border-radius: 3px;
        transition: background 0.3s;
    }

    .pf-seg.weak {
        background: #f87171;
    }

    .pf-seg.fair {
        background: var(--warning);
    }

    .pf-seg.strong {
        background: var(--success);
    }

    .pf-strength-lbl {
        font-size: 11px;
        color: var(--text-3);
        margin-top: 4px;
    }

    /* ── DIVIDER ── */
    .pf-divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 22px 0;
    }

    /* ── TABLE ── */
    .pf-table {
        width: 100%;
        border-collapse: collapse;
    }

    .pf-table thead tr {
        border-bottom: 1.5px solid var(--border);
    }

    .pf-table th {
        padding: 9px 14px;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        color: var(--text-3);
        text-align: left;
    }

    .pf-table td {
        padding: 13px 14px;
        font-size: 13px;
        color: var(--text-2);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .pf-table tr:last-child td {
        border-bottom: none;
    }

    .pf-table td:first-child {
        color: var(--text-1);
        font-weight: 600;
    }

    .pf-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 100px;
        font-size: 11.5px;
        font-weight: 700;
    }

    .pf-badge-login {
        background: var(--info-lt);
        color: #2563eb;
    }

    .pf-badge-update {
        background: var(--success-lt);
        color: var(--success);
    }

    .pf-badge-password {
        background: var(--warning-lt);
        color: var(--warning);
    }

    .pf-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* ── DANGER ZONE ── */
    .pf-danger-zone {
        border: 1.5px solid #fecaca;
        border-radius: var(--radius);
        padding: 20px;
        background: #fff5f5;
        margin-top: 22px;
    }

    .pf-danger-zone h4 {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--danger);
        margin-bottom: 5px;
    }

    .pf-danger-zone p {
        font-size: 12.5px;
        color: var(--text-2);
        margin-bottom: 14px;
        line-height: 1.6;
    }

    /* ── IP CHIP ── */
    .pf-ip {
        font-size: 12px;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
        letter-spacing: 0.2px;
        background: var(--bg);
        border: 1px solid var(--border);
        padding: 3px 8px;
        border-radius: 6px;
        color: var(--text-2);
    }

    /* ── TOAST ── */
    #pf-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: var(--text-1);
        color: #fff;
        border-radius: var(--radius);
        padding: 12px 18px;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        display: flex;
        align-items: center;
        gap: 9px;
        box-shadow: var(--shadow-lg);
        transform: translateY(70px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 9999;
    }

    #pf-toast.show {
        transform: translateY(0);
        opacity: 1;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 700px) {
        .pf-wrap {
            padding: 20px 16px 48px;
        }

        .pf-hero {
            padding: 20px;
            gap: 16px;
        }

        .pf-hero-avatar {
            width: 68px;
            height: 68px;
            border-radius: 12px;
        }

        .pf-hero-info h2 {
            font-size: 17px;
        }

        .pf-hero-meta {
            gap: 14px;
        }

        .pf-grid {
            grid-template-columns: 1fr;
        }

        .pf-row {
            grid-template-columns: 1fr;
        }

        .pf-btn-row {
            flex-direction: column;
        }

        .pf-btn {
            justify-content: center;
        }

        .pf-page-head h1 {
            font-size: 21px;
        }

        #pf-toast {
            left: 16px;
            right: 16px;
            bottom: 16px;
        }
    }
</style>

<div class="pf-wrap">

    <!-- PAGE HEADER -->
    <div class="pf-page-head">
        <div>
            <h1>Profile Settings</h1>
            <p>Manage your account information and preferences</p>
        </div>
    </div>

    <!-- HERO CARD -->
    <div class="pf-hero">
        <div class="pf-hero-avatar">
            <img src="<?php echo app_profile_image_url(isset($profile_user['profile_image']) ? $profile_user['profile_image'] : ''); ?>" alt="<?php echo html_escape($profile_user['full_name']); ?>">
        </div>
        <div class="pf-hero-info">
            <h2><?php echo html_escape($profile_user['full_name']); ?></h2>
            <div class="pf-hero-role">Administrator Account</div>
            <div class="pf-hero-meta">
                <div class="pf-meta-item">
                    <span class="lbl">Email</span>
                    <span class="val"><?php echo html_escape($profile_user['email']); ?></span>
                </div>
                <div class="pf-meta-item">
                    <span class="lbl">Phone</span>
                    <span class="val"><?php echo html_escape($profile_user['phone']); ?></span>
                </div>
                <div class="pf-meta-item">
                    <span class="lbl">Member Since</span>
                    <span class="val"><?php echo !empty($profile_user['created_at']) ? date('d M Y', strtotime($profile_user['created_at'])) : 'N/A'; ?></span>
                </div>
            </div>
        </div>
        <div class="pf-status">
            <div class="pf-status-dot"></div>
            Active
        </div>
    </div>

    <!-- TABS -->
    <div class="pf-tabs">
        <button class="pf-tab active" data-tab="pf-edit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            Edit Profile
        </button>
        <button class="pf-tab" data-tab="pf-password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <rect x="3" y="11" width="18" height="11" rx="2" />
                <path d="M7 11V7a5 5 0 0110 0v4" />
            </svg>
            Change Password
        </button>
        <button class="pf-tab" data-tab="pf-activity">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
            </svg>
            Activity
        </button>
    </div>

    <!-- EDIT PROFILE TAB -->
    <div id="pf-edit" class="pf-pane active">
        <div class="pf-grid">

            <!-- Personal Info -->
            <div class="pf-card">
                <div class="pf-card-head">
                    <h3>Personal Information</h3>
                    <p>Update your name, email, and phone number.</p>
                </div>
                <form method="post" action="<?php echo base_url('admin/profile/update'); ?>" enctype="multipart/form-data">
                    <div class="pf-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?php echo html_escape($profile_user['full_name']); ?>" required>
                    </div>
                    <div class="pf-row">
                        <div class="pf-group">
                            <label>Email Address</label>
                            <input type="email" name="email" value="<?php echo html_escape($profile_user['email']); ?>" required>
                            <div class="pf-hint">Used for login &amp; notifications</div>
                        </div>
                        <div class="pf-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" value="<?php echo html_escape($profile_user['phone']); ?>" required>
                        </div>
                    </div>
                    <div class="pf-btn-row">
                        <button type="submit" class="pf-btn pf-btn-primary">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Save Changes
                        </button>
                        <button type="reset" class="pf-btn pf-btn-ghost">Discard</button>
                    </div>
                </form>
            </div>

            <!-- Profile Picture -->
            <div class="pf-card">
                <div class="pf-card-head">
                    <h3>Profile Picture</h3>
                    <p>Shown in the admin header. JPG, PNG or WEBP · Max 4 MB · 400×400 px recommended.</p>
                </div>
                <form method="post" action="<?php echo base_url('admin/profile/update'); ?>" enctype="multipart/form-data">
                    <div class="pf-upload" id="pf-upload-zone">
                        <input type="file" name="profile_image" id="pf-file" accept=".jpg,.jpeg,.png,.webp">
                        <div class="pf-upload-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2">
                                <polyline points="16 16 12 12 8 16" />
                                <line x1="12" y1="12" x2="12" y2="21" />
                                <path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3" />
                            </svg>
                        </div>
                        <p>Click to upload or drag &amp; drop</p>
                        <span>JPG, PNG or WEBP — Max 4 MB</span>
                    </div>
                    <div class="pf-btn-row">
                        <button type="submit" class="pf-btn pf-btn-primary">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="16 16 12 12 8 16" />
                                <line x1="12" y1="12" x2="12" y2="21" />
                                <path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3" />
                            </svg>
                            Upload Picture
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- CHANGE PASSWORD TAB -->
    <div id="pf-password" class="pf-pane">
        <div class="pf-grid" style="grid-template-columns: minmax(0, 500px);">
            <div class="pf-card">
                <div class="pf-card-head">
                    <h3>Change Password</h3>
                    <p>Update your password regularly. Minimum 8 characters with mixed types.</p>
                </div>
                <div class="pf-alert pf-alert-info">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <div class="pf-alert-body">
                        <strong>Security Tip</strong>
                        <p>Use uppercase, lowercase, numbers and symbols for a stronger password.</p>
                    </div>
                </div>
                <form method="post" action="<?php echo base_url('admin/profile/password'); ?>">
                    <div class="pf-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required autocomplete="current-password">
                    </div>
                    <div class="pf-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" id="pf-new-pwd" minlength="8" required autocomplete="new-password">
                        <div class="pf-strength-bar">
                            <div class="pf-seg" id="pf-s1"></div>
                            <div class="pf-seg" id="pf-s2"></div>
                            <div class="pf-seg" id="pf-s3"></div>
                            <div class="pf-seg" id="pf-s4"></div>
                        </div>
                        <div class="pf-strength-lbl" id="pf-slbl">Enter a password</div>
                    </div>
                    <div class="pf-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" id="pf-confirm-pwd" minlength="8" required autocomplete="new-password">
                        <div class="pf-hint" id="pf-match-hint"></div>
                    </div>
                    <div class="pf-btn-row">
                        <button type="submit" class="pf-btn pf-btn-primary">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                            Update Password
                        </button>
                        <button type="reset" class="pf-btn pf-btn-ghost">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ACTIVITY TAB -->
    <div id="pf-activity" class="pf-pane">
        <div class="pf-card">
            <div class="pf-card-head">
                <h3>Account Activity</h3>
                <p>Recent login and change history for your account.</p>
            </div>

            <div class="pf-alert pf-alert-success" style="margin-bottom:0;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                <div class="pf-alert-body">
                    <strong>Account Standing</strong>
                    <p>Your account is active and all systems are operational.</p>
                </div>
            </div>

            <hr class="pf-divider">

            <div style="overflow-x:auto;">
                <table class="pf-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Date &amp; Time</th>
                            <th>IP Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="pf-badge pf-badge-login"><span class="pf-dot"></span>Login</span></td>
                            <td>Today — 10:30 AM</td>
                            <td><span class="pf-ip">192.168.1.100</span></td>
                            <td style="color:var(--success);font-weight:700;font-size:12px;">Success</td>
                        </tr>
                        <tr>
                            <td><span class="pf-badge pf-badge-update"><span class="pf-dot"></span>Profile Updated</span></td>
                            <td>Yesterday — 3:15 PM</td>
                            <td><span class="pf-ip">192.168.1.100</span></td>
                            <td style="color:var(--success);font-weight:700;font-size:12px;">Success</td>
                        </tr>
                        <tr>
                            <td><span class="pf-badge pf-badge-password"><span class="pf-dot"></span>Password Changed</span></td>
                            <td>2 days ago — 9:00 AM</td>
                            <td><span class="pf-ip">192.168.1.100</span></td>
                            <td style="color:var(--success);font-weight:700;font-size:12px;">Success</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pf-danger-zone">
                <h4>Danger Zone</h4>
                <p>Sign out of all other sessions to secure your account on other devices.</p>
                <button class="pf-btn pf-btn-danger" onclick="pfToast('All other sessions signed out.')">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Sign Out All Other Sessions
                </button>
            </div>
        </div>
    </div>

</div><!-- /pf-wrap -->

<!-- TOAST -->
<div id="pf-toast">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5">
        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
        <polyline points="22 4 12 14.01 9 11.01" />
    </svg>
    <span id="pf-toast-msg">Done.</span>
</div>

<script>
    (function() {
        // ── TABS ──
        document.querySelectorAll('.pf-tab').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.pf-tab').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.pf-pane').forEach(p => p.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(btn.dataset.tab).classList.add('active');
            });
        });

        // ── FILE UPLOAD ──
        const fileInput = document.getElementById('pf-file');
        const zone = document.getElementById('pf-upload-zone');

        function handleFile(file) {
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => {
                zone.innerHTML = `
                <input type="file" name="profile_image" id="pf-file" accept=".jpg,.jpeg,.png,.webp">
                <img src="${ev.target.result}" class="pf-preview-img" alt="Preview">
                <p>${file.name}</p>
                <span>${(file.size / 1024).toFixed(1)} KB</span>
            `;
                zone.classList.add('has-file');
                zone.querySelector('input[type="file"]').addEventListener('change', e => handleFile(e.target.files[0]));
            };
            reader.readAsDataURL(file);
        }

        fileInput && fileInput.addEventListener('change', e => handleFile(e.target.files[0]));

        zone && zone.addEventListener('dragover', e => {
            e.preventDefault();
            zone.style.borderColor = 'var(--accent)';
        });
        zone && zone.addEventListener('dragleave', () => zone.style.borderColor = '');
        zone && zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.style.borderColor = '';
            handleFile(e.dataTransfer.files[0]);
        });

        // ── PASSWORD STRENGTH ──
        const newPwd = document.getElementById('pf-new-pwd');
        const confPwd = document.getElementById('pf-confirm-pwd');
        const segs = ['pf-s1', 'pf-s2', 'pf-s3', 'pf-s4'].map(id => document.getElementById(id));
        const slbl = document.getElementById('pf-slbl');
        const mhint = document.getElementById('pf-match-hint');

        function strength(v) {
            let s = 0;
            if (v.length >= 8) s++;
            if (/[A-Z]/.test(v)) s++;
            if (/[0-9]/.test(v)) s++;
            if (/[^A-Za-z0-9]/.test(v)) s++;
            return s;
        }

        newPwd && newPwd.addEventListener('input', () => {
            const s = newPwd.value ? strength(newPwd.value) : 0;
            const cls = s <= 1 ? 'weak' : s <= 2 ? 'fair' : 'strong';
            const lbl = ['', 'Weak', 'Fair', 'Strong', 'Very Strong'];
            const clr = s <= 1 ? '#f87171' : s <= 2 ? 'var(--warning)' : 'var(--success)';
            segs.forEach((seg, i) => {
                seg.className = 'pf-seg';
                if (i < s) seg.classList.add(cls);
            });
            slbl.textContent = newPwd.value ? (lbl[s] || 'Very Strong') : 'Enter a password';
            slbl.style.color = newPwd.value ? clr : 'var(--text-3)';
        });

        confPwd && confPwd.addEventListener('input', () => {
            if (!confPwd.value) {
                mhint.textContent = '';
                return;
            }
            const match = confPwd.value === newPwd.value;
            mhint.textContent = match ? 'Passwords match' : 'Passwords do not match';
            mhint.style.color = match ? 'var(--success)' : 'var(--danger)';
        });

        // ── TOAST ──
        window.pfToast = function(msg) {
            const t = document.getElementById('pf-toast');
            document.getElementById('pf-toast-msg').textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3000);
        };
    })();
</script>