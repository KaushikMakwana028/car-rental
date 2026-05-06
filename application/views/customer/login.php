<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Login | Cab Booking Fast</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --bg:#f6efe3;
            --bg-soft:#fbf8f1;
            --paper:#fffdf8;
            --ink:#251c14;
            --muted:#716353;
            --line:rgba(129,96,44,.16);
            --gold:#b98735;
            --gold-deep:#8f6320;
            --forest:#173b34;
            --forest-soft:#224a42;
            --danger:#a73434;
            --danger-soft:#fde8e8;
            --success:#1e7b57;
            --success-soft:#ddf4e8;
            --shadow-lg:0 28px 60px rgba(72,52,22,.12);
            --shadow-md:0 18px 34px rgba(72,52,22,.08);
        }
        *{box-sizing:border-box}
        body{
            margin:0;
            min-height:100vh;
            font-family:'Manrope',sans-serif;
            color:var(--ink);
            background:
                radial-gradient(circle at top left, rgba(185,135,53,.16), transparent 26%),
                radial-gradient(circle at right, rgba(23,59,52,.12), transparent 24%),
                linear-gradient(180deg,#fbf7ef 0%,#f4ebdd 100%);
        }
        a{text-decoration:none;color:inherit}
        img{display:block;max-width:100%}
        .auth-shell{
            min-height:100vh;
            display:grid;
            grid-template-columns:1.05fr .95fr;
        }
        .auth-showcase{
            padding:34px;
            background:
                radial-gradient(circle at top right, rgba(200,85,61,.14), transparent 32%),
                linear-gradient(135deg,#fffaf3,#fff1e7);
            color:var(--ink);
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            border-right:1px solid var(--line);
        }
        .brand{
            display:flex;
            align-items:center;
            gap:14px;
        }
        .brand-logo{
            width:68px;
            height:68px;
            padding:10px;
            border-radius:22px;
            background:linear-gradient(135deg,#fff5de,#eed29d);
            box-shadow:0 14px 28px rgba(185,135,53,.16);
        }
        .brand-copy strong{
            display:block;
            font-family:'Cormorant Garamond',serif;
            font-size:38px;
            line-height:.9;
        }
        .brand-copy span{
            display:block;
            margin-top:6px;
            font-size:11px;
            font-weight:800;
            letter-spacing:.18em;
            text-transform:uppercase;
            color:#7a6953;
        }
        .showcase-copy{
            max-width:560px;
        }
        .eyebrow{
            display:inline-flex;
            align-items:center;
            gap:10px;
            color:var(--gold-deep);
            font-size:11px;
            font-weight:800;
            letter-spacing:.16em;
            text-transform:uppercase;
        }
        .eyebrow::before{
            content:'';
            width:24px;
            height:2px;
            background:linear-gradient(90deg,var(--gold),transparent);
            border-radius:999px;
        }
        .showcase-copy h1{
            margin:18px 0 0;
            font-family:'Cormorant Garamond',serif;
            font-size:72px;
            line-height:.9;
            letter-spacing:-.03em;
        }
        .showcase-copy p{
            margin:18px 0 0;
            color:var(--muted);
            font-size:16px;
            line-height:1.9;
        }
        .showcase-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:14px;
            margin-top:28px;
        }
        .showcase-tile{
            padding:18px;
            border-radius:20px;
            background:rgba(255,255,255,.72);
            border:1px solid rgba(129,96,44,.12);
        }
        .showcase-tile strong{
            display:block;
            color:var(--gold-deep);
            font-family:'Cormorant Garamond',serif;
            font-size:28px;
        }
        .showcase-tile span{
            display:block;
            margin-top:4px;
            color:var(--muted);
            font-size:13px;
            line-height:1.6;
        }
        .showcase-footer{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
            margin-top:32px;
        }
        .showcase-pill{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:10px 14px;
            border-radius:999px;
            background:rgba(255,255,255,.68);
            border:1px solid rgba(129,96,44,.12);
            color:var(--muted);
            font-size:12px;
            font-weight:700;
        }
        .auth-panel{
            display:flex;
            align-items:center;
            justify-content:center;
            padding:34px 20px;
        }
        .card{
            width:100%;
            max-width:490px;
            padding:34px;
            border-radius:30px;
            background:rgba(255,253,248,.96);
            border:1px solid var(--line);
            box-shadow:var(--shadow-lg);
        }
        .card h2{
            margin:0;
            font-family:'Cormorant Garamond',serif;
            font-size:48px;
            line-height:.92;
        }
        .card p{
            margin:12px 0 0;
            color:var(--muted);
            font-size:15px;
            line-height:1.8;
        }
        .flash{
            margin-top:20px;
            padding:14px 16px;
            border-radius:18px;
            border:1px solid transparent;
            font-size:14px;
            font-weight:700;
            line-height:1.6;
        }
        .flash.success{background:var(--success-soft);border-color:#bbe2cd;color:#14593d}
        .flash.error{background:var(--danger-soft);border-color:#efc5c5;color:#922e2e}
        .form-grid{
            display:grid;
            gap:16px;
            margin-top:24px;
        }
        label{
            display:block;
            margin-bottom:8px;
            font-size:11px;
            font-weight:800;
            letter-spacing:.12em;
            text-transform:uppercase;
            color:#7a6547;
        }
        .input-wrap{position:relative}
        .input-icon{
            position:absolute;
            left:14px;
            top:50%;
            width:18px;
            height:18px;
            color:#9a8870;
            transform:translateY(-50%);
            pointer-events:none;
        }
        input{
            width:100%;
            min-height:54px;
            padding:14px 46px 14px 46px;
            border-radius:18px;
            border:1px solid rgba(129,96,44,.18);
            background:#fff;
            color:var(--ink);
            outline:none;
            transition:.18s ease;
        }
        input:focus{
            border-color:rgba(185,135,53,.56);
            box-shadow:0 0 0 4px rgba(185,135,53,.10);
        }
        .toggle-pw{
            position:absolute;
            right:14px;
            top:50%;
            transform:translateY(-50%);
            border:none;
            background:none;
            color:#8c7a65;
            cursor:pointer;
            padding:0;
        }
        .btn{
            width:100%;
            min-height:52px;
            border:none;
            border-radius:999px;
            background:linear-gradient(135deg,var(--gold),var(--gold-deep));
            color:#fff;
            font-size:14px;
            font-weight:800;
            cursor:pointer;
            box-shadow:0 16px 28px rgba(185,135,53,.22);
        }
        .auth-links{
            display:grid;
            gap:12px;
            margin-top:22px;
        }
        .auth-link{
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:14px 16px;
            border-radius:18px;
            border:1px solid var(--line);
            background:#fffaf1;
            color:#564835;
            font-size:14px;
            font-weight:700;
        }
        .auth-link strong{
            display:block;
            color:#221a13;
        }
        .auth-link span{
            display:block;
            margin-top:3px;
            color:var(--muted);
            font-size:12px;
            font-weight:600;
        }
        @media (max-width:980px){
            .auth-shell{grid-template-columns:1fr}
            .auth-showcase{padding-bottom:26px}
        }
        @media (max-width:640px){
            .auth-showcase,.auth-panel{padding:20px 14px}
            .showcase-copy h1{font-size:48px}
            .showcase-grid{grid-template-columns:1fr}
            .card{padding:24px 18px;border-radius:24px}
            .card h2{font-size:38px}
        }
    </style>
</head>
<body>
    <div class="auth-shell">
        <section class="auth-showcase">
            <div class="brand">
                <div class="brand-logo">
                    <img src="<?php echo base_url('assets/home/logo.png'); ?>" alt="Cab Booking Fast logo">
                </div>
                <div class="brand-copy">
                    <strong>Cab Booking Fast</strong>
                    <span>Customer Portal</span>
                </div>
            </div>

            <div class="showcase-copy">
                <div class="eyebrow">Customer Access</div>
                <h1>Premium ride booking with a cleaner first impression.</h1>
                <p>Sign in to manage bookings, upload documents, and move through the customer experience with the same visual style used across the full customer side.</p>
                <div class="showcase-grid">
                    <div class="showcase-tile">
                        <strong>Fleet</strong>
                        <span>Browse vehicles with better visuals and easier comparison.</span>
                    </div>
                    <div class="showcase-tile">
                        <strong>Track</strong>
                        <span>See booking and payment progress from one dashboard.</span>
                    </div>
                    <div class="showcase-tile">
                        <strong>Upload</strong>
                        <span>Keep account verification documents organized and review ready.</span>
                    </div>
                </div>
            </div>

            <div class="showcase-footer">
                <div class="showcase-pill">Mobile responsive</div>
                <div class="showcase-pill">Logo-based branding</div>
                <div class="showcase-pill">Unified customer UI</div>
            </div>
        </section>

        <section class="auth-panel">
            <div class="card">
                <h2>Welcome back</h2>
                <p>Sign in with your email or mobile number to continue into the customer area.</p>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="flash success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="flash error"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <form method="post" action="<?php echo base_url('customer/login'); ?>">
                    <div class="form-grid">
                        <div>
                            <label for="login_id">Email or Mobile</label>
                            <div class="input-wrap">
                                <input type="text" id="login_id" name="login_id" placeholder="Enter email or mobile number" autocomplete="username" required>
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label for="password">Password</label>
                            <div class="input-wrap">
                                <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <button type="button" class="toggle-pw" id="togglePw" aria-label="Show password">
                                    <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="btn" type="submit">Sign In to Customer Area</button>
                    </div>
                </form>

                <div class="auth-links">
                    <a class="auth-link" href="<?php echo base_url('customer/dashboard'); ?>">
                        <div>
                            <strong>Browse customer home</strong>
                            <span>Go back and explore the updated light customer pages first.</span>
                        </div>
                        <div>&rsaquo;</div>
                    </a>
                </div>
            </div>
        </section>
    </div>

    <script>
        (function () {
            var pw = document.getElementById('password');
            var btn = document.getElementById('togglePw');
            var icon = document.getElementById('eyeIcon');
            var eyeOpen = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            var eyeOff = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';

            btn.addEventListener('click', function () {
                var show = pw.type === 'password';
                pw.type = show ? 'text' : 'password';
                icon.innerHTML = show ? eyeOff : eyeOpen;
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        })();
    </script>
</body>
</html>
