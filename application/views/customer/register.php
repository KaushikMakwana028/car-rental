<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account</title>
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
            --teal: #0f766e;
            --teal-dark: #0d6460;
            --teal-glow: rgba(15, 118, 110, 0.13);
            --ink: #0f172a;
            --ink-3: #64748b;
            --ink-4: #94a3b8;
            --surface: #ffffff;
            --page: #f1fdfb;
            --border: #ccf0ec;
            --err-bg: #fff1f2;
            --err-border: #fecdd3;
            --err-text: #be123c;
            --r: 10px;
            --t: 0.18s ease;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: var(--page);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .form-box {
            width: 100%;
            max-width: 430px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 32px 28px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        .form-title {
            font-size: 28px;
            font-weight: 900;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .form-sub {
            font-size: 14px;
            font-weight: 300;
            color: var(--ink-3);
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .flash {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 13px;
            border-radius: var(--r);
            border: 1px solid var(--err-border);
            background: var(--err-bg);
            color: var(--err-text);
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .flash svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .field {
            margin-bottom: 14px;
        }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 14px;
        }

        @media (max-width: 480px) {
            .row-2 {
                grid-template-columns: 1fr;
            }
        }

        label {
            display: block;
            font-size: 11px;
            font-weight: 500;
            color: var(--ink-3);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
        }

        .iico {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            color: var(--ink-4);
            pointer-events: none;
            transition: color var(--t);
        }

        .input-wrap:focus-within .iico {
            color: var(--teal);
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            height: 44px;
            padding: 0 12px 0 36px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--r);
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            font-weight: 400;
            color: var(--ink);
            outline: none;
            transition: border-color var(--t), box-shadow var(--t);
            -webkit-appearance: none;
        }

        input::placeholder {
            color: var(--ink-4);
            font-weight: 300;
        }

        input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px var(--teal-glow);
        }

        .btn {
            width: 100%;
            height: 48px;
            background: var(--teal);
            color: #fff;
            border: none;
            border-radius: var(--r);
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: pointer;
            margin-top: 8px;
            transition: background var(--t), transform var(--t), box-shadow var(--t);
        }

        .btn:hover {
            background: var(--teal-dark);
            box-shadow: 0 6px 20px rgba(15, 118, 110, 0.28);
            transform: translateY(-1px);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider span {
            font-size: 11px;
            color: var(--ink-4);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            white-space: nowrap;
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            height: 44px;
            border: 1.5px solid var(--border);
            border-radius: var(--r);
            background: var(--surface);
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-3);
            text-decoration: none;
            transition: color var(--t), border-color var(--t), background var(--t);
        }

        .back-link:hover {
            color: var(--teal);
            border-color: var(--teal);
            background: #eefcf9;
        }

        .terms {
            font-size: 11px;
            color: var(--ink-4);
            text-align: center;
            line-height: 1.6;
            margin-top: 14px;
        }

        .terms a {
            color: var(--teal);
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="form-box">
        <h1 class="form-title">Create your account</h1>
        <p class="form-sub">Register with your name, email, phone and one password.</p>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="flash">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo base_url('register'); ?>">
            <div class="field">
                <label for="full_name">Full Name</label>
                <div class="input-wrap">
                    <input type="text" id="full_name" name="full_name" placeholder="Jane Doe" autocomplete="name" required>
                    <svg class="iico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="5" />
                        <path d="M3 21a9 9 0 0 1 18 0" />
                    </svg>
                </div>
            </div>

            <div class="row-2">
                <div class="field" style="margin-bottom:0">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <input type="email" id="email" name="email" placeholder="you@email.com" autocomplete="email" required>
                        <svg class="iico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                    </div>
                </div>
                <div class="field" style="margin-bottom:0">
                    <label for="phone">Phone</label>
                    <div class="input-wrap">
                        <input type="tel" id="phone" name="phone" placeholder="+91 98765 43210" autocomplete="tel" required>
                        <svg class="iico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="field" style="margin-top:14px">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="new-password" required>
                    <svg class="iico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </div>
            </div>

            <button class="btn" type="submit">Create Account</button>
        </form>

        <div class="divider"><span>already registered?</span></div>

        <a href="<?php echo base_url('customer'); ?>" class="back-link">Back to Login</a>

        <p class="terms">By registering you agree to our <a href="#">Terms</a> &amp; <a href="#">Privacy Policy</a></p>
    </div>
</body>

</html>
