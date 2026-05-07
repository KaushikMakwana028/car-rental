<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,600;1,9..144,300&display=swap" rel="stylesheet">

<style>
    :root {
        --cream: #FBF8EE;
        --cream-dark: #FFF1BF;
        --ink: #17355C;
        --ink-soft: #456383;
        --ink-muted: #73849A;
        --accent: #235EA7;
        --accent-hover: #163F72;
        --gold-light: #FFF5D6;
        --border: rgba(23, 53, 92, 0.1);
        --border-strong: rgba(23, 53, 92, 0.18);
        --card-bg: #FFFFFF;
        --shadow-sm: 0 1px 4px rgba(23, 53, 92, 0.06), 0 0 0 0.5px rgba(23, 53, 92, 0.08);
        --shadow-md: 0 4px 20px rgba(23, 53, 92, 0.09), 0 0 0 0.5px rgba(23, 53, 92, 0.07);
        --shadow-hover: 0 10px 40px rgba(23, 53, 92, 0.13), 0 0 0 0.5px rgba(23, 53, 92, 0.09);
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 18px;
        --radius-xl: 24px;
        --font-display: 'Fraunces', Georgia, serif;
        --font-body: 'Plus Jakarta Sans', system-ui, sans-serif;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .vc-page {
        font-family: var(--font-body);
        background: var(--cream);
        min-height: 100vh;
        padding-bottom: 80px;
    }

    /* Hero */
    .vc-hero {
        background: linear-gradient(135deg, #fffdf5 0%, #fff3c8 100%);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        padding: 56px 40px 72px;
        position: relative;
        overflow: hidden;
    }

    .vc-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 120% at 110% 50%, rgba(35, 94, 167, .12) 0%, transparent 60%),
            radial-gradient(ellipse 50% 80% at -10% 80%, rgba(241, 193, 79, .18) 0%, transparent 55%);
    }

    .vc-hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }

    .vc-eyebrow {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .vc-eyebrow::before {
        content: '';
        width: 20px;
        height: 1.5px;
        background: var(--accent);
        border-radius: 2px;
        display: inline-block;
    }

    .vc-hero h1 {
        font-family: var(--font-display);
        font-size: clamp(30px, 5vw, 52px);
        font-weight: 300;
        color: var(--ink);
        line-height: 1.1;
        letter-spacing: -.02em;
    }

    .vc-hero h1 em {
        font-style: italic;
        color: var(--accent);
    }

    .vc-hero-sub {
        font-size: 15px;
        color: var(--ink-soft);
        margin-top: 12px;
        max-width: 400px;
        line-height: 1.6;
    }

    .vc-hero-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--accent);
        color: #FAF8F3;
        font-family: var(--font-body);
        font-size: 14px;
        font-weight: 600;
        padding: 13px 24px;
        border-radius: var(--radius-md);
        text-decoration: none;
        transition: background .18s, transform .15s;
        white-space: nowrap;
    }

    .vc-hero-cta:hover {
        background: var(--accent-hover);
        transform: translateY(-1px);
    }

    .vc-hero-cta svg {
        width: 16px;
        height: 16px;
    }

    /* Body */
    .vc-body {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* Filters */
    .vc-filters-wrap {
        background: var(--card-bg);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        padding: 24px 28px;
        margin-top: 20px;
        position: relative;
        z-index: 10;
        border: .5px solid var(--border);
    }

    .vc-search-row {
        display: flex;
        align-items: center;
        background: var(--cream);
        border: 1.5px solid var(--border-strong);
        border-radius: var(--radius-md);
        padding: 0 16px;
        margin-bottom: 20px;
        transition: border-color .18s, box-shadow .18s;
    }

    .vc-search-row:focus-within {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(35, 94, 167, .1);
    }

    .vc-search-icon {
        color: var(--ink-muted);
        flex-shrink: 0;
    }

    .vc-search-icon svg {
        width: 18px;
        height: 18px;
        display: block;
    }

    #vehicleSearch {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        font-family: var(--font-body);
        font-size: 15px;
        color: var(--ink);
        padding: 13px 12px;
        width: 100%;
    }

    #vehicleSearch::placeholder {
        color: var(--ink-muted);
    }

    .vc-filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
    }

    .vc-filter-group label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: 6px;
    }

    .vc-filter-group select {
        width: 100%;
        appearance: none;
        background: var(--cream) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%238A867E' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 12px center;
        border: 1.5px solid var(--border-strong);
        border-radius: var(--radius-sm);
        font-family: var(--font-body);
        font-size: 14px;
        color: var(--ink);
        padding: 9px 32px 9px 12px;
        cursor: pointer;
        transition: border-color .18s, box-shadow .18s;
        outline: none;
    }

    .vc-filter-group select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(35, 94, 167, .1);
    }

    /* Results meta */
    .vc-results-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 28px 0 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .vc-results-count {
        font-size: 14px;
        color: var(--ink-muted);
    }

    .vc-results-count strong {
        color: var(--ink);
        font-weight: 600;
    }

    /* Grid */
    .vc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    /* Card */
    .vc-card {
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: .5px solid var(--border);
        overflow: hidden;
        transition: box-shadow .22s, transform .22s;
        display: flex;
        flex-direction: column;
        animation: fadeUp .4s ease both;
    }

    .vc-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-3px);
    }

    /* Media */
    .vc-card-media {
        position: relative;
        height: 192px;
        background: var(--cream-dark);
        overflow: hidden;
    }

    .vc-card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .4s ease;
    }

    .vc-card:hover .vc-card-media img {
        transform: scale(1.04);
    }

    .vc-card-media-empty {
        height: 192px;
        background: linear-gradient(135deg, #EDE9E0 0%, #D9D4C9 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .vc-empty-initial {
        width: 60px;
        height: 60px;
        background: rgba(26, 24, 20, .08);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-display);
        font-size: 26px;
        font-weight: 600;
        color: var(--ink-soft);
    }

    .vc-empty-text {
        font-size: 12px;
        color: var(--ink-muted);
        font-weight: 500;
    }

    .vc-type-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(250, 248, 243, .92);
        backdrop-filter: blur(8px);
        border: .5px solid rgba(26, 24, 20, .12);
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        color: var(--ink-soft);
        letter-spacing: .06em;
        text-transform: uppercase;
        padding: 4px 10px;
    }

    /* Card body */
    .vc-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .vc-card-name {
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 600;
        color: var(--ink);
        letter-spacing: -.01em;
        margin-bottom: 2px;
        line-height: 1.25;
    }

    .vc-card-reg {
        font-size: 12px;
        color: var(--ink-muted);
        font-weight: 500;
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .vc-spec-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 16px;
    }

    .vc-spec-item {
        background: var(--cream);
        border-radius: var(--radius-sm);
        padding: 10px 12px;
    }

    .vc-spec-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--ink-muted);
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 3px;
    }

    .vc-spec-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--ink);
    }

    .vc-divider {
        height: .5px;
        background: var(--border);
        margin: 0 0 16px;
    }

    .vc-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
    }

    .vc-price-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--ink-muted);
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .vc-price-value {
        font-family: var(--font-display);
        font-size: 22px;
        font-weight: 600;
        color: var(--ink);
        letter-spacing: -.02em;
    }

    .vc-price-unit {
        font-size: 12px;
        color: var(--ink-muted);
        font-family: var(--font-body);
        font-weight: 400;
        margin-left: 2px;
    }

    .vc-advance-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--gold-light);
        border: .5px solid rgba(212, 160, 23, .3);
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        color: #7A5C00;
        padding: 4px 10px;
        margin-top: 8px;
    }

    .vc-book-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--accent);
        color: #FAF8F3;
        font-family: var(--font-body);
        font-size: 13px;
        font-weight: 600;
        padding: 10px 18px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        transition: background .18s, transform .15s;
    }

    .vc-book-btn:hover {
        background: var(--accent-hover);
        transform: translateY(-1px);
    }

    .vc-book-btn svg {
        width: 14px;
        height: 14px;
    }

    /* Empty state */
    .vc-empty-state {
        grid-column: 1/-1;
        text-align: center;
        padding: 80px 24px;
    }

    .vc-empty-icon {
        width: 72px;
        height: 72px;
        background: var(--cream-dark);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .vc-empty-icon svg {
        width: 32px;
        height: 32px;
        color: var(--ink-muted);
    }

    .vc-empty-state h3 {
        font-family: var(--font-display);
        font-size: 22px;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 8px;
    }

    .vc-empty-state p {
        font-size: 15px;
        color: var(--ink-muted);
        line-height: 1.6;
    }

    .vc-no-vehicles {
        text-align: center;
        padding: 100px 24px;
    }

    .vc-no-vehicles h2 {
        font-family: var(--font-display);
        font-size: 28px;
        font-weight: 300;
        color: var(--ink);
        margin-bottom: 10px;
    }

    .vc-no-vehicles p {
        font-size: 15px;
        color: var(--ink-muted);
        line-height: 1.6;
    }

    /* ── PAGINATION ── */
    .vc-pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 36px 0 8px;
        flex-wrap: wrap;
    }

    .vc-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 6px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border-strong);
        background: var(--card-bg);
        font-family: var(--font-body);
        font-size: 14px;
        font-weight: 500;
        color: var(--ink-soft);
        cursor: pointer;
        transition: background .15s, border-color .15s, color .15s, transform .12s;
        user-select: none;
        line-height: 1;
    }

    .vc-page-btn:hover:not(:disabled):not(.active) {
        background: var(--cream-dark);
        border-color: var(--accent);
        color: var(--accent);
        transform: translateY(-1px);
    }

    .vc-page-btn.active {
        background: var(--accent);
        border-color: var(--accent);
        color: #FAF8F3;
        font-weight: 600;
        cursor: default;
    }

    .vc-page-btn:disabled {
        opacity: .38;
        cursor: not-allowed;
    }

    .vc-page-btn.ellipsis {
        border-color: transparent;
        background: transparent;
        cursor: default;
        color: var(--ink-muted);
        pointer-events: none;
        min-width: 24px;
    }

    .vc-page-btn svg {
        width: 16px;
        height: 16px;
    }

    /* Animations */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media(max-width:768px) {
        .vc-hero {
            padding: 40px 20px 44px;
        }

        .vc-hero-inner {
            flex-direction: column;
            align-items: flex-start;
        }

        .vc-body {
            padding: 0 16px;
        }

        .vc-filters-wrap {
            padding: 18px 16px;
            margin-top: 18px;
            border-radius: var(--radius-lg);
        }

        .vc-filter-grid {
            grid-template-columns: 1fr 1fr;
        }

        .vc-grid {
            grid-template-columns: 1fr;
        }

        .vc-page-btn {
            min-width: 34px;
            height: 34px;
            font-size: 13px;
        }
    }

    @media(max-width:480px) {
        .vc-filter-grid {
            grid-template-columns: 1fr;
        }

        .vc-hero h1 {
            font-size: 28px;
        }
    }
</style>

<div class="vc-page">

    <div class="vc-hero">
        <div class="vc-hero-inner">
            <div>
                <div class="vc-eyebrow">Fleet Catalogue</div>
                <h1>Find your<br><em>perfect ride.</em></h1>
                <p class="vc-hero-sub">Browse our curated fleet. Filter by type, fuel, and seats to find exactly what you need.</p>
            </div>
            <a class="vc-hero-cta" href="<?php echo base_url('bookings/create'); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
                Book a Car
            </a>
        </div>
    </div>

    <div class="vc-body">

        <?php if (!empty($vehicles)): ?>

            <div class="vc-filters-wrap">
                <div class="vc-search-row">
                    <span class="vc-search-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                    </span>
                    <input type="text" id="vehicleSearch" placeholder="Search by name, registration, type or fuel…">
                </div>
                <div class="vc-filter-grid">
                    <div class="vc-filter-group">
                        <label>Vehicle Type</label>
                        <select id="filterType">
                            <option value="">All Types</option>
                            <?php
                            $types = array_values(array_unique(array_filter(array_map(function ($v) {
                                return trim((string)$v['vehicle_type']);
                            }, $vehicles))));
                            sort($types);
                            foreach ($types as $type):
                            ?>
                                <option value="<?php echo html_escape(strtolower($type)); ?>"><?php echo html_escape($type); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="vc-filter-group">
                        <label>Fuel Type</label>
                        <select id="filterFuel">
                            <option value="">All Fuel Types</option>
                            <?php
                            $fuels = array_values(array_unique(array_filter(array_map(function ($v) {
                                return trim((string)$v['fuel_type']);
                            }, $vehicles))));
                            sort($fuels);
                            foreach ($fuels as $fuel):
                            ?>
                                <option value="<?php echo html_escape(strtolower($fuel)); ?>"><?php echo html_escape($fuel); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="vc-filter-group">
                        <label>Min Seats</label>
                        <select id="filterSeats">
                            <option value="">Any Seats</option>
                            <?php
                            $seats = array_values(array_unique(array_filter(array_map(function ($v) {
                                return (int)$v['seats'];
                            }, $vehicles))));
                            sort($seats);
                            foreach ($seats as $seat):
                            ?>
                                <option value="<?php echo (int)$seat; ?>"><?php echo (int)$seat; ?>+ Seats</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="vc-filter-group">
                        <label>Max Advance (₹)</label>
                        <select id="filterAdvance">
                            <option value="">Any Amount</option>
                            <option value="1000">Up to ₹1,000</option>
                            <option value="2000">Up to ₹2,000</option>
                            <option value="5000">Up to ₹5,000</option>
                            <option value="10000">Up to ₹10,000</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="vc-results-meta">
                <div class="vc-results-count" id="resultsCount">Showing <strong><?php echo count($vehicles); ?></strong> vehicles</div>
            </div>

            <div class="vc-grid" id="vehicleGrid">
                <?php foreach ($vehicles as $vehicle): ?>
                    <?php $vehicle_image = isset($vehicle['image']) ? trim($vehicle['image']) : ''; ?>
                    <article
                        class="vc-card js-vehicle-card"
                        data-name="<?php echo html_escape(strtolower($vehicle['name'])); ?>"
                        data-registration="<?php echo html_escape(strtolower($vehicle['registration_no'])); ?>"
                        data-type="<?php echo html_escape(strtolower($vehicle['vehicle_type'])); ?>"
                        data-fuel="<?php echo html_escape(strtolower($vehicle['fuel_type'])); ?>"
                        data-seats="<?php echo (int)$vehicle['seats']; ?>"
                        data-advance="<?php echo (float)$vehicle['advance_amount']; ?>">

                        <?php if ($vehicle_image !== ''): ?>
                            <div class="vc-card-media">
                                <img src="<?php echo app_vehicle_image_url($vehicle_image); ?>" alt="<?php echo html_escape($vehicle['name']); ?>" loading="lazy">
                                <span class="vc-type-badge"><?php echo html_escape($vehicle['vehicle_type']); ?></span>
                            </div>
                        <?php else: ?>
                            <div class="vc-card-media-empty">
                                <div class="vc-empty-initial"><?php echo html_escape(strtoupper(substr($vehicle['name'], 0, 1))); ?></div>
                                <div class="vc-empty-text">No image available</div>
                                <span class="vc-type-badge" style="position:static;margin-top:4px;"><?php echo html_escape($vehicle['vehicle_type']); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="vc-card-body">
                            <div class="vc-card-name"><?php echo html_escape($vehicle['name']); ?></div>
                            <div class="vc-card-reg"><?php echo html_escape($vehicle['registration_no']); ?></div>
                            <div class="vc-spec-grid">
                                <div class="vc-spec-item">
                                    <div class="vc-spec-label">Fuel</div>
                                    <div class="vc-spec-value"><?php echo html_escape($vehicle['fuel_type']); ?></div>
                                </div>
                                <div class="vc-spec-item">
                                    <div class="vc-spec-label">Seats</div>
                                    <div class="vc-spec-value"><?php echo (int)$vehicle['seats']; ?> Seats</div>
                                </div>
                            </div>
                            <div class="vc-divider"></div>
                            <div class="vc-card-footer">
                                <div>
                                    <div class="vc-price-label">Rate / KM</div>
                                    <div class="vc-price-value">&#8377;<?php echo number_format((float)$vehicle['rate_per_day'], 2); ?><span class="vc-price-unit">/km</span></div>
                                    <div class="vc-advance-tag">
                                        &#8377;<?php echo number_format((float)$vehicle['advance_amount'], 0); ?> advance
                                    </div>
                                </div>
                                <a class="vc-book-btn" href="<?php echo base_url('bookings/create?vehicle_id=' . (int)$vehicle['id']); ?>">
                                    Book
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <div id="vehicleEmptyState" class="vc-empty-state" style="display:none;">
                    <div class="vc-empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                    </div>
                    <h3>No vehicles found</h3>
                    <p>Try adjusting your search or clearing some filters.</p>
                </div>
            </div>

            <!-- Pagination -->
            <nav class="vc-pagination-wrap" id="vcPagination" aria-label="Vehicle pages"></nav>

        <?php else: ?>
            <div class="vc-no-vehicles">
                <h2>No vehicles available right now.</h2>
                <p>Please contact our admin team to check for availability.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php if (!empty($vehicles)): ?>
    <script>
        (function() {

            /* ── refs ── */
            var search = document.getElementById('vehicleSearch');
            var selType = document.getElementById('filterType');
            var selFuel = document.getElementById('filterFuel');
            var selSeats = document.getElementById('filterSeats');
            var selAdv = document.getElementById('filterAdvance');
            var grid = document.getElementById('vehicleGrid');
            var emptyEl = document.getElementById('vehicleEmptyState');
            var countEl = document.getElementById('resultsCount');
            var pagNav = document.getElementById('vcPagination');

            var allCards = Array.prototype.slice.call(document.querySelectorAll('.js-vehicle-card'));

            /* ── state ── */
            var currentPage = 1;
            var visibleCards = allCards.slice(); // cards that pass current filters

            /* ── per-page: 9 desktop / 6 mobile ── */
            function perPage() {
                return window.innerWidth <= 768 ? 6 : 9;
            }

            /* ── filter ── */
            function applyFilters() {
                var sv = (search.value || '').toLowerCase().trim();
                var tv = (selType.value || '').toLowerCase();
                var fv = (selFuel.value || '').toLowerCase();
                var sev = parseInt(selSeats.value || '0', 10);
                var adv = parseFloat(selAdv.value || '0');

                visibleCards = allCards.filter(function(card) {
                    return (
                        (sv === '' ||
                            card.dataset.name.indexOf(sv) !== -1 ||
                            card.dataset.registration.indexOf(sv) !== -1 ||
                            card.dataset.type.indexOf(sv) !== -1 ||
                            card.dataset.fuel.indexOf(sv) !== -1
                        ) &&
                        (tv === '' || card.dataset.type === tv) &&
                        (fv === '' || card.dataset.fuel === fv) &&
                        (sev === 0 || parseInt(card.dataset.seats, 10) >= sev) &&
                        (adv === 0 || parseFloat(card.dataset.advance) <= adv)
                    );
                });

                /* reset to page 1 whenever filters change */
                currentPage = 1;
                render();
            }

            /* ── render cards for current page ── */
            function render() {
                var pp = perPage();
                var total = visibleCards.length;
                var totalPages = Math.max(1, Math.ceil(total / pp));

                if (currentPage > totalPages) currentPage = totalPages;

                var start = (currentPage - 1) * pp;
                var end = start + pp;

                /* hide all, show only page slice */
                allCards.forEach(function(c) {
                    c.style.display = 'none';
                });
                visibleCards.forEach(function(c, i) {
                    c.style.display = (i >= start && i < end) ? '' : 'none';
                    /* re-trigger fade animation */
                    if (i >= start && i < end) {
                        c.style.animation = 'none';
                        /* eslint-disable-next-line no-unused-expressions */
                        c.offsetHeight; /* reflow */
                        c.style.animation = '';
                        c.style.animationDelay = ((i - start) * 0.05) + 's';
                    }
                });

                emptyEl.style.display = total === 0 ? '' : 'none';

                /* count text */
                if (countEl) {
                    if (total === 0) {
                        countEl.innerHTML = 'No vehicles found';
                    } else {
                        var showing = Math.min(end, total) - start;
                        countEl.innerHTML =
                            'Showing <strong>' + (start + 1) + '–' + Math.min(end, total) +
                            '</strong> of <strong>' + total + '</strong> vehicle' + (total !== 1 ? 's' : '');
                    }
                }

                buildPagination(totalPages);
            }

            /* ── build pagination nav ── */
            function buildPagination(totalPages) {
                pagNav.innerHTML = '';
                if (totalPages <= 1) return;

                var pages = getPageNumbers(currentPage, totalPages);

                /* Prev button */
                pagNav.appendChild(makeBtn(null, currentPage === 1, false, 'prev',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>'
                ));

                pages.forEach(function(p) {
                    if (p === '…') {
                        pagNav.appendChild(makeBtn('…', false, false, 'ellipsis'));
                    } else {
                        pagNav.appendChild(makeBtn(p, false, p === currentPage, 'number'));
                    }
                });

                /* Next button */
                pagNav.appendChild(makeBtn(null, currentPage === totalPages, false, 'next',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>'
                ));
            }

            /* ── smart page number list ── */
            /* Rules:
                 first  → 1 2 3 … last
                 middle → 1 … p-1 p p+1 … last
                 last   → 1 … last-2 last-1 last
            */
            function getPageNumbers(cur, total) {
                if (total <= 5) {
                    /* show all pages when there are 5 or fewer */
                    var arr = [];
                    for (var i = 1; i <= total; i++) arr.push(i);
                    return arr;
                }

                /* first 3 pages */
                if (cur <= 3) {
                    var result = [1, 2, 3];
                    if (total > 4) result.push('…');
                    result.push(total);
                    return result;
                }

                /* last 3 pages */
                if (cur >= total - 2) {
                    return [1, '…', total - 2, total - 1, total];
                }

                /* middle */
                return [1, '…', cur - 1, cur, cur + 1, '…', total];
            }

            /* ── create a single pagination button ── */
            function makeBtn(label, disabled, active, type, innerHtml) {
                var btn = document.createElement('button');
                btn.className = 'vc-page-btn' +
                    (active ? ' active' : '') +
                    (type === 'ellipsis' ? ' ellipsis' : '');
                btn.innerHTML = innerHtml || label;
                btn.disabled = !!disabled;

                if (type === 'number' && !active) {
                    btn.setAttribute('aria-label', 'Page ' + label);
                    btn.addEventListener('click', function() {
                        currentPage = label;
                        render();
                        scrollToGrid();
                    });
                }
                if (type === 'prev') {
                    btn.setAttribute('aria-label', 'Previous page');
                    btn.addEventListener('click', function() {
                        if (currentPage > 1) {
                            currentPage--;
                            render();
                            scrollToGrid();
                        }
                    });
                }
                if (type === 'next') {
                    btn.setAttribute('aria-label', 'Next page');
                    btn.addEventListener('click', function() {
                        var pp = perPage();
                        var totalPages = Math.ceil(visibleCards.length / pp);
                        if (currentPage < totalPages) {
                            currentPage++;
                            render();
                            scrollToGrid();
                        }
                    });
                }
                return btn;
            }

            /* smooth scroll back to top of grid on page change */
            function scrollToGrid() {
                var top = grid.getBoundingClientRect().top + window.pageYOffset - 24;
                window.scrollTo({
                    top: top,
                    behavior: 'smooth'
                });
            }

            /* ── event listeners ── */
            [search, selType, selFuel, selSeats, selAdv].forEach(function(el) {
                el.addEventListener('input', applyFilters);
                el.addEventListener('change', applyFilters);
            });

            /* re-render on resize (desktop ↔ mobile per-page change) */
            var resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    currentPage = 1;
                    render();
                }, 200);
            });

            /* ── initial render ── */
            render();

        })();
    </script>
<?php endif; ?>