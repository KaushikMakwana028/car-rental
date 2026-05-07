<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$register_mode = isset($register_mode) ? $register_mode : 'customer';
$is_admin_setup = $register_mode === 'admin';
$portal_label = $is_admin_setup ? 'Admin Setup' : 'Customer Portal';
$hero_title = $is_admin_setup ? 'Create the first admin account for this car rental panel.' : 'Start booking with a more premium customer side.';
$hero_text = $is_admin_setup ? 'This page is available only until the first admin account is created. Once that account is saved, registration closes automatically for safety.' : 'Registration is now part of the same warm, brand-led experience, with better spacing, cleaner form styling, and mobile-friendly layout behavior.';
$intro_one_title = $is_admin_setup ? 'One-time secure setup' : 'One customer identity';
$intro_one_text = $is_admin_setup ? 'Use this screen to create the first admin who will manage vehicles, bookings, payments, and customer records.' : 'Register once and manage bookings, documents, and profile details from one dashboard.';
$intro_two_title = $is_admin_setup ? 'Auto-disable after signup' : 'Fast booking start';
$intro_two_text = $is_admin_setup ? 'After the first admin is registered, this page is disabled automatically so no extra admin accounts can be opened from the public route.' : 'After account creation, you can sign in and continue directly into the booking flow.';
$intro_three_title = $is_admin_setup ? 'Clean login handoff' : 'Improved mobile view';
$intro_three_text = $is_admin_setup ? 'As soon as setup is complete, you will be sent back to the admin login page to sign in.' : 'The full registration experience now stacks cleanly on smaller screens.';
$card_title = $is_admin_setup ? 'Create admin account' : 'Create your account';
$card_text = $is_admin_setup ? 'Enter the admin name, email, phone, and password to unlock the admin dashboard.' : 'Register with your name, email, phone, and password to unlock the redesigned customer experience.';
$submit_label = $is_admin_setup ? 'Create Admin Account' : 'Create Customer Account';
$login_url = isset($login_url) ? $login_url : base_url('login');
$back_label = $is_admin_setup ? 'Back to Admin Login' : 'Back to Login';
$terms_text = $is_admin_setup ? 'After the first admin account is created, this registration page turns off automatically.' : 'By creating an account, you are ready to use the redesigned customer booking experience.';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account | Cab Booking Fast</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f6efe3;
            --paper: #fffdf8;
            --ink: #241b13;
            --muted: #716252;
            --line: rgba(129, 96, 44, .16);
            --gold: #b98735;
            --gold-deep: #8f6320;
            --forest: #173b34;
            --danger: #a73434;
            --danger-soft: #fde8e8;
            --shadow-lg: 0 28px 60px rgba(72, 52, 22, .12);
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(185, 135, 53, .14), transparent 24%),
                radial-gradient(circle at right, rgba(23, 59, 52, .10), transparent 22%),
                linear-gradient(180deg, #fbf7ef 0%, #f4ebdd 100%);
            padding: 24px;
        }

        a {
            text-decoration: none;
            color: inherit
        }

        img {
            display: block;
            max-width: 100%
        }

        .page {
            max-width: 1180px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: .92fr 1.08fr;
            gap: 22px;
            align-items: stretch;
        }

        .intro,
        .card {
            border-radius: 30px;
            border: 1px solid var(--line);
            background: rgba(255, 253, 248, .96);
            box-shadow: var(--shadow-lg);
        }

        .intro {
            padding: 30px;
            background:
                radial-gradient(circle at top right, rgba(185, 135, 53, .16), transparent 28%),
                linear-gradient(180deg, #fffaf1 0%, #f7eedf 100%);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            width: 68px;
            height: 68px;
            padding: 10px;
            border-radius: 22px;
            background: linear-gradient(135deg, #fff5de, #eed29d);
            box-shadow: 0 14px 28px rgba(185, 135, 53, .16);
        }

        .brand-copy strong {
            display: block;
            font-family: 'Cormorant Garamond', serif;
            font-size: 38px;
            line-height: .9;
            color: #7a541d;
        }

        .brand-copy span {
            display: block;
            margin-top: 6px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: #7a6953;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 34px;
            color: #8c6220;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: '';
            width: 24px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), transparent);
            border-radius: 999px;
        }

        .intro h1 {
            margin: 16px 0 0;
            font-family: 'Cormorant Garamond', serif;
            font-size: 66px;
            line-height: .9;
            letter-spacing: -.03em;
            color: #2a1f14;
        }

        .intro p {
            margin: 18px 0 0;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.9;
        }

        .intro-grid {
            display: grid;
            gap: 14px;
            margin-top: 26px;
        }

        .intro-item {
            padding: 18px;
            border-radius: 20px;
            background: #fffdfa;
            border: 1px solid rgba(129, 96, 44, .12);
        }

        .intro-item strong {
            display: block;
            font-size: 15px;
            color: #2b2015;
        }

        .intro-item span {
            display: block;
            margin-top: 6px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .card {
            padding: 30px;
        }

        .card h2 {
            margin: 0;
            font-family: 'Cormorant Garamond', serif;
            font-size: 48px;
            line-height: .92;
        }

        .card p {
            margin: 12px 0 0;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.8;
        }

        .flash {
            margin-top: 20px;
            padding: 14px 16px;
            border-radius: 18px;
            border: 1px solid #efc5c5;
            background: var(--danger-soft);
            color: #922e2e;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.6;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 24px;
        }

        .full {
            grid-column: 1 / -1
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #7a6547;
        }

        .input-wrap {
            position: relative
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            width: 18px;
            height: 18px;
            color: #9a8870;
            transform: translateY(-50%);
            pointer-events: none;
        }

        input {
            width: 100%;
            min-height: 54px;
            padding: 14px 16px 14px 46px;
            border-radius: 18px;
            border: 1px solid rgba(129, 96, 44, .18);
            background: #fff;
            color: var(--ink);
            outline: none;
            transition: .18s ease;
        }

        input:focus {
            border-color: rgba(185, 135, 53, .56);
            box-shadow: 0 0 0 4px rgba(185, 135, 53, .10);
        }

        .btn {
            width: 100%;
            min-height: 52px;
            border: none;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--gold), var(--gold-deep));
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 16px 28px rgba(185, 135, 53, .22);
        }

        .back-link {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 50px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: #fff8eb;
            color: #5f503d;
            font-size: 14px;
            font-weight: 700;
        }

        .terms {
            margin-top: 14px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
            text-align: center;
        }

        @media (max-width:980px) {
            .page {
                grid-template-columns: 1fr
            }
        }

        @media (max-width:640px) {
            body {
                padding: 14px
            }

            .intro,
            .card {
                padding: 22px;
                border-radius: 24px
            }

            .intro h1 {
                font-size: 46px
            }

            .card h2 {
                font-size: 38px
            }

            .form-grid {
                grid-template-columns: 1fr
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <section class="intro">
            <div class="brand">
                <div class="brand-logo">
                    <img src="<?php echo base_url('assets/home/logo.png'); ?>" alt="Cab Booking Fast logo">
                </div>
                <div class="brand-copy">
                    <strong>Cab Booking Fast</strong>
                    <span><?php echo $portal_label; ?></span>
                </div>
            </div>

            <div class="eyebrow">Create Account</div>
            <h1><?php echo $hero_title; ?></h1>
            <p><?php echo $hero_text; ?></p>

            <div class="intro-grid">
                <div class="intro-item">
                    <strong><?php echo $intro_one_title; ?></strong>
                    <span><?php echo $intro_one_text; ?></span>
                </div>
                <div class="intro-item">
                    <strong><?php echo $intro_two_title; ?></strong>
                    <span><?php echo $intro_two_text; ?></span>
                </div>
                <div class="intro-item">
                    <strong><?php echo $intro_three_title; ?></strong>
                    <span><?php echo $intro_three_text; ?></span>
                </div>
            </div>
        </section>

        <section class="card">
            <h2><?php echo $card_title; ?></h2>
            <p><?php echo $card_text; ?></p>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="flash"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <form method="post" action="<?php echo base_url('register'); ?>">
                <div class="form-grid">
                    <div class="full">
                        <label for="full_name">Full Name</label>
                        <div class="input-wrap">
                            <input type="text" id="full_name" name="full_name" placeholder="Enter full name" autocomplete="name" required>
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="5"></circle>
                                <path d="M3 21a9 9 0 0 1 18 0"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <div class="input-wrap">
                            <input type="email" id="email" name="email" placeholder="Enter email" autocomplete="email" required>
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <label for="phone">Phone</label>
                        <div class="input-wrap">
                            <input type="tel" id="phone" name="phone" placeholder="Enter phone number" autocomplete="tel" required>
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="full">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <input type="password" id="password" name="password" placeholder="Create a password" autocomplete="new-password" required>
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="full">
                        <button class="btn" type="submit"><?php echo $submit_label; ?></button>
                    </div>
                </div>
            </form>

            <a class="back-link" href="<?php echo $login_url; ?>"><?php echo $back_label; ?></a>
            <div class="terms"><?php echo $terms_text; ?></div>
        </section>
    </div>
</body>

</html>
