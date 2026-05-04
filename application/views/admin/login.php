<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --amber: #2563eb;
            --amber-dark: #1d4ed8;
            --amber-glow: rgba(37, 99, 235, 0.14);
            --amber-border: rgba(37, 99, 235, 0.28);
            --bg-deep: #f4f7fb;
            --bg-card: #ffffff;
            --bg-surface: #f8fafc;
            --bg-input: #ffffff;
            --border-subtle: rgba(148, 163, 184, 0.25);
            --border-input: rgba(148, 163, 184, 0.45);
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --success-bg: #dcfce7;
            --success-border: #86efac;
            --error-bg: #fee2e2;
            --error-border: #fca5a5;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle background texture */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% -10%, rgba(37, 99, 235, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 80% 80%, rgba(14, 165, 233, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* Dot grid */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle, rgba(148, 163, 184, 0.14) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
            z-index: 0;
        }

        .wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Brand mark */
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: #dbeafe;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-icon svg {
            width: 18px;
            height: 18px;
            fill: #2563eb;
        }

        .brand-name {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--text-secondary);
        }

        /* Card */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: 40px 36px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(37, 99, 235, 0.3) 50%, transparent 100%);
        }

        @media (max-width: 480px) {
            .card {
                padding: 28px 22px;
                border-radius: var(--radius-md);
            }
        }

        .card-header {
            margin-bottom: 28px;
        }

        .card-title {
            font-size: clamp(22px, 5vw, 26px);
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1.2;
            margin-bottom: 6px;
        }

        .card-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            font-weight: 300;
            line-height: 1.5;
        }

        /* Flash messages */
        .flash {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 15px;
            border-radius: var(--radius-sm);
            margin-bottom: 22px;
            font-size: 14px;
            line-height: 1.5;
            border: 1px solid;
            animation: slideIn 0.3s ease both;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .flash-icon {
            flex-shrink: 0;
            width: 16px;
            height: 16px;
            margin-top: 2px;
        }

        .flash.success {
            background: var(--success-bg);
            border-color: var(--success-border);
            color: #166534;
        }

        .flash.error {
            background: var(--error-bg);
            border-color: var(--error-border);
            color: #991b1b;
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 7px;
            letter-spacing: 0.02em;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--text-muted);
            pointer-events: none;
            transition: color var(--transition);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px 12px 40px;
            background: var(--bg-input);
            border: 1px solid var(--border-input);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
            transition: border-color var(--transition), box-shadow var(--transition);
            outline: none;
            -webkit-appearance: none;
        }

        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: var(--text-muted);
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: var(--amber-border);
            box-shadow: 0 0 0 3px var(--amber-glow);
        }

        input[type="text"]:focus+.input-icon,
        input[type="password"]:focus+.input-icon {
            color: var(--amber);
        }

        /* Focus icon fix — icon is before input in markup for z-order */
        .input-wrap:focus-within .input-icon {
            color: var(--amber);
        }

        /* Password toggle */
        .toggle-pw {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color var(--transition);
            border-radius: 4px;
        }

        .toggle-pw:hover {
            color: var(--text-secondary);
        }

        .toggle-pw svg {
            width: 16px;
            height: 16px;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 14px 20px;
            background: var(--amber);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            margin-top: 6px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: var(--amber-dark);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.22);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .btn-submit svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-subtle);
        }

        .divider span {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Footer links */
        .links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .link-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 14px;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-sm);
            text-decoration: none;
            transition: border-color var(--transition), background var(--transition);
            group: true;
        }

        .link-item:hover {
            border-color: var(--border-input);
            background: #f8fafc;
        }

        .link-item-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .link-item-icon {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .link-item-icon svg {
            width: 14px;
            height: 14px;
        }

        .link-item-text {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .link-item-text strong {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            line-height: 1.3;
        }

        .link-arrow {
            width: 16px;
            height: 16px;
            color: var(--text-muted);
            flex-shrink: 0;
            transition: color var(--transition), transform var(--transition);
        }

        .link-item:hover .link-arrow {
            color: var(--amber);
            transform: translateX(2px);
        }

        /* Autocomplete style fix */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px var(--bg-input) inset;
            -webkit-text-fill-color: var(--text-primary);
            caret-color: var(--text-primary);
            border-color: var(--border-input);
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Brand -->
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                </svg>
            </div>
            <span class="brand-name">Admin Portal</span>
        </div>

        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Welcome back</h1>
                <p class="card-subtitle">Sign in to manage bookings, vehicles &amp; customers.</p>
            </div>

            <!-- Flash messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="flash success">
                    <svg class="flash-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="flash error">
                    <svg class="flash-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Login form -->
            <form method="post" action="<?php echo base_url('admin'); ?>">

                <div class="form-group">
                    <label for="login_id">Email or Mobile Number</label>
                    <div class="input-wrap">
                        <input
                            type="text"
                            id="login_id"
                            name="login_id"
                            placeholder="Enter email or mobile number"
                            autocomplete="username"
                            required>
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required>
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <button type="button" class="toggle-pw" id="togglePw" aria-label="Show password" tabindex="-1">
                            <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button class="btn-submit" type="submit">
                    Sign in to Admin
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </form>

            <div class="divider"><span>or navigate to</span></div>

            <div class="links">
                <a href="<?php echo base_url('register'); ?>" class="link-item">
                    <div class="link-item-left">
                        <div class="link-item-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <line x1="19" y1="8" x2="19" y2="14" />
                                <line x1="22" y1="11" x2="16" y2="11" />
                            </svg>
                        </div>
                        <div class="link-item-text">
                            <strong>Create Account</strong>
                            Register a new user account
                        </div>
                    </div>
                    <svg class="link-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </a>

            </div>
        </div>
    </div>

    <script>
        (function() {
            var pw = document.getElementById('password');
            var btn = document.getElementById('togglePw');
            var icon = document.getElementById('eyeIcon');
            var eyeOpen = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            var eyeOff = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            btn.addEventListener('click', function() {
                var show = pw.type === 'password';
                pw.type = show ? 'text' : 'password';
                icon.innerHTML = show ? eyeOff : eyeOpen;
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        })();
    </script>
</body>

</html>
