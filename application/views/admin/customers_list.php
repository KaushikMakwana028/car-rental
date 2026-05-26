<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap');

    :root {
        --brand: #2563eb;
        --brand-hover: #1d4ed8;
        --brand-light: #eff6ff;
        --brand-mid: #dbeafe;
        --surface: #ffffff;
        --surface-alt: #f8fafc;
        --border: #e2e8f0;
        --border-soft: #f1f5f9;
        --text-1: #0f172a;
        --text-2: #475569;
        --text-3: #94a3b8;
        --success-bg: #f0fdf4;
        --success-bd: #bbf7d0;
        --success-tx: #15803d;
        --danger-bg: #fff1f2;
        --danger-bd: #fecdd3;
        --danger-tx: #be123c;
        --warning-bg: #fffbeb;
        --warning-bd: #fde68a;
        --warning-tx: #b45309;
        --info-bg: #eff6ff;
        --info-bd: #bfdbfe;
        --info-tx: #1d4ed8;
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --shadow-xs: 0 1px 3px rgba(15, 23, 42, .06);
        --shadow-sm: 0 4px 16px rgba(15, 23, 42, .08);
        --shadow-modal: 0 24px 64px rgba(15, 23, 42, .18);
        --font: 'DM Sans', system-ui, sans-serif;
        --font-mono: 'DM Mono', monospace;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .cm-wrap {
        font-family: var(--font);
        color: var(--text-1);
    }

    /* ── Stats ── */
    .cm-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .cm-stat {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px 18px;
        box-shadow: var(--shadow-xs);
        position: relative;
        overflow: hidden;
    }

    .cm-stat::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    }

    .cm-stat.blue::after {
        background: #2563eb;
    }

    .cm-stat.green::after {
        background: #22c55e;
    }

    .cm-stat.amber::after {
        background: #f59e0b;
    }

    .cm-stat.teal::after {
        background: #0d9488;
    }

    .cm-stat-label {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: var(--text-3);
        margin-bottom: 6px;
    }

    .cm-stat-value {
        font-size: 26px;
        font-weight: 600;
        color: var(--text-1);
        line-height: 1;
        letter-spacing: -.5px;
        margin-bottom: 4px;
    }

    .cm-stat-desc {
        font-size: 12px;
        color: var(--text-2);
        line-height: 1.4;
    }

    /* ── Section card ── */
    .cm-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-xs);
        overflow: hidden;
    }

    .cm-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 22px;
        border-bottom: 1px solid var(--border-soft);
        flex-wrap: wrap;
    }

    .cm-card-head h3 {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-1);
        margin-bottom: 2px;
    }

    .cm-card-head p {
        font-size: 13px;
        color: var(--text-2);
        line-height: 1.4;
    }

    .cm-search {
        width: min(340px, 100%);
        min-height: 42px;
        padding: 0 14px;
        border-radius: 12px;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-1);
        font: 500 13px/1.2 var(--font);
        outline: none;
        transition: border-color .18s ease, box-shadow .18s ease;
    }

    .cm-search:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    /* ── Add button ── */
    .cm-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        background: var(--brand);
        color: #fff;
        border: none;
        border-radius: var(--radius-md);
        font: 600 13px/1 var(--font);
        cursor: pointer;
        text-decoration: none;
        white-space: nowrap;
        transition: background .15s, box-shadow .15s, transform .1s;
        box-shadow: 0 2px 8px rgba(37, 99, 235, .28);
    }

    .cm-add-btn:hover {
        background: var(--brand-hover);
    }

    .cm-add-btn:active {
        transform: scale(.98);
    }

    .cm-add-btn svg {
        width: 14px;
        height: 14px;
    }

    /* ── Table ── */
    .cm-table-wrap {
        overflow-x: auto;
    }

    .cm-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 760px;
        font-size: 13.5px;
    }

    .cm-table thead {
        background: var(--surface-alt);
        border-bottom: 1px solid var(--border);
    }

    .cm-table th {
        padding: 11px 16px;
        text-align: left;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .6px;
        text-transform: uppercase;
        color: var(--text-3);
        white-space: nowrap;
    }

    .cm-table td {
        padding: 13px 16px;
        border-bottom: 1px solid var(--border-soft);
        vertical-align: middle;
        color: var(--text-1);
    }

    .cm-table tbody tr:last-child td {
        border-bottom: none;
    }

    .cm-table tbody tr:hover {
        background: #fafbfc;
    }

    /* ── Customer cell ── */
    .cm-customer-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cm-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: var(--brand-light);
        border: 1.5px solid var(--brand-mid);
        color: var(--brand);
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cm-name {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-1);
        margin-bottom: 1px;
    }

    .cm-email {
        font-size: 12px;
        color: var(--text-3);
        font-family: var(--font-mono);
    }

    .cm-mono {
        font-family: var(--font-mono);
        font-size: 13px;
    }

    .cm-amount {
        font-weight: 600;
        color: var(--text-1);
        font-family: var(--font-mono);
        font-size: 13px;
    }

    .cm-muted {
        font-size: 12.5px;
        color: var(--text-3);
    }

    /* ── Badges ── */
    .cm-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: 100px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
        border: 1px solid transparent;
    }

    .cm-badge::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .cm-badge.approved {
        background: var(--success-bg);
        border-color: var(--success-bd);
        color: var(--success-tx);
    }

    .cm-badge.approved::before {
        background: #22c55e;
    }

    .cm-badge.pending {
        background: var(--warning-bg);
        border-color: var(--warning-bd);
        color: var(--warning-tx);
    }

    .cm-badge.pending::before {
        background: #f59e0b;
    }

    .cm-badge.rejected {
        background: var(--danger-bg);
        border-color: var(--danger-bd);
        color: var(--danger-tx);
    }

    .cm-badge.rejected::before {
        background: #ef4444;
    }

    .cm-badge.missing {
        background: var(--surface-alt);
        border-color: var(--border);
        color: var(--text-3);
    }

    .cm-badge.missing::before {
        background: var(--text-3);
    }

    .cm-badge.complete {
        background: var(--success-bg);
        border-color: var(--success-bd);
        color: var(--success-tx);
    }

    .cm-badge.complete::before {
        background: #22c55e;
    }

    /* ── View button ── */
    .cm-view-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--text-2);
        font: 600 12px/1 var(--font);
        cursor: pointer;
        transition: background .12s, border-color .12s, color .12s;
        white-space: nowrap;
    }

    .cm-view-btn:hover {
        background: var(--brand-light);
        border-color: var(--brand-mid);
        color: var(--brand);
    }

    .cm-view-btn svg {
        width: 12px;
        height: 12px;
    }

    /* ── Empty ── */
    .cm-empty {
        padding: 44px 24px;
        text-align: center;
        color: var(--text-3);
        font-size: 14px;
    }

    .cm-pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 18px 22px 22px;
        border-top: 1px solid var(--border-soft);
        flex-wrap: wrap;
    }

    .cm-pagination-info {
        font-size: 13px;
        color: var(--text-2);
    }

    .cm-pagination {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .cm-page-btn,
    .cm-page-dot {
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
    }

    .cm-page-btn {
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-2);
        cursor: pointer;
        transition: all .18s ease;
    }

    .cm-page-btn:hover {
        border-color: var(--brand-mid);
        color: var(--brand);
        background: var(--brand-light);
    }

    .cm-page-btn.active {
        border-color: var(--brand);
        background: var(--brand);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .cm-page-btn:disabled {
        opacity: .45;
        cursor: not-allowed;
        background: var(--surface-alt);
    }

    .cm-page-dot {
        color: var(--text-3);
    }

    /* ══════════════════════════════
       MODAL
    ══════════════════════════════ */
    .cm-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .42);
        display: none;
        align-items: flex-start;
        justify-content: center;
        padding: 32px 16px;
        z-index: 9999;
        overflow-y: auto;
    }

    .cm-modal-overlay.open {
        display: flex;
    }

    .cm-modal {
        width: 100%;
        max-width: 680px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-modal);
        margin: auto;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    /* Modal header */
    .cm-modal-head {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 22px;
        border-bottom: 1px solid var(--border-soft);
        flex-shrink: 0;
    }

    .cm-modal-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--brand-light);
        border: 2px solid var(--brand-mid);
        color: var(--brand);
        font-size: 15px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cm-modal-head-info {
        flex: 1;
        min-width: 0;
    }

    .cm-modal-head-info h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-1);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 1px;
    }

    .cm-modal-head-info p {
        font-size: 12.5px;
        color: var(--text-3);
        font-family: var(--font-mono);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cm-modal-close {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
        background: var(--surface-alt);
        color: var(--text-2);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background .12s, color .12s;
    }

    .cm-modal-close:hover {
        background: var(--border-soft);
        color: var(--text-1);
    }

    .cm-modal-close svg {
        width: 14px;
        height: 14px;
    }

    /* Modal body */
    .cm-modal-body {
        padding: 18px 22px;
        overflow-y: auto;
        max-height: calc(100vh - 160px);
    }

    /* Key-value grid — compact */
    .cm-kv-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-bottom: 14px;
    }

    .cm-kv {
        background: var(--surface-alt);
        border: 1px solid var(--border-soft);
        border-radius: var(--radius-md);
        padding: 10px 12px;
    }

    .cm-kv-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: var(--text-3);
        margin-bottom: 4px;
    }

    .cm-kv-value {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-1);
        word-break: break-all;
        line-height: 1.3;
    }

    .cm-kv-value.mono {
        font-family: var(--font-mono);
        font-size: 13px;
    }

    /* Info note */
    .cm-note {
        background: var(--info-bg);
        border: 1px solid var(--info-bd);
        border-radius: var(--radius-md);
        padding: 10px 14px;
        font-size: 13px;
        color: var(--info-tx);
        line-height: 1.5;
        margin-bottom: 14px;
    }

    /* Modal sections */
    .cm-section {
        margin-bottom: 14px;
    }

    .cm-section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: var(--text-3);
        margin-bottom: 8px;
        padding-bottom: 6px;
        border-bottom: 1px solid var(--border-soft);
    }

    .cm-list {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .cm-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 12px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
    }

    .cm-list-item-info {
        flex: 1;
        min-width: 0;
    }

    .cm-list-item-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-1);
        margin-bottom: 1px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cm-list-item-sub {
        font-size: 11.5px;
        color: var(--text-3);
        line-height: 1.4;
    }

    .cm-list-empty {
        padding: 10px 12px;
        border-radius: var(--radius-md);
        border: 1px dashed var(--border);
        background: var(--surface-alt);
        font-size: 13px;
        color: var(--text-3);
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .cm-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .cm-stats {
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .cm-stat-value {
            font-size: 22px;
        }

        .cm-card-head {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .cm-add-btn {
            width: 100%;
            justify-content: center;
        }

        .cm-kv-grid {
            grid-template-columns: 1fr 1fr;
        }

        .cm-modal-body {
            max-height: calc(100vh - 120px);
        }

        .cm-modal-overlay {
            padding: 12px;
        }
    }

    @media (max-width: 400px) {
        .cm-stats {
            grid-template-columns: 1fr;
        }

        .cm-kv-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php
$total_customers = count($customers);
$active_customers = 0;
$pending_docs = 0;
$customer_revenue = 0;

foreach ($customers as $c) {
    if ((int) $c['total_bookings'] > 0)
        $active_customers++;
    if (!in_array($c['doc_status'], ['approved', 'complete'], true))
        $pending_docs++;
    $customer_revenue += (float) $c['total_spent'];
}

function cm_initials($name)
{
    $parts = array_filter(explode(' ', trim($name)));
    $out = '';
    foreach (array_slice($parts, 0, 2) as $p)
        $out .= strtoupper($p[0]);
    return $out ?: '?';
}
?>

<div class="cm-wrap">

    <!-- Stats -->
    <div class="cm-stats">
        <div class="cm-stat blue">
            <div class="cm-stat-label">Total Customers</div>
            <div class="cm-stat-value"><?php echo (int) $total_customers; ?></div>
            <div class="cm-stat-desc">Registered accounts</div>
        </div>
        <div class="cm-stat green">
            <div class="cm-stat-label">Active</div>
            <div class="cm-stat-value"><?php echo (int) $active_customers; ?></div>
            <div class="cm-stat-desc">With at least 1 booking</div>
        </div>
        <div class="cm-stat amber">
            <div class="cm-stat-label">Pending Docs</div>
            <div class="cm-stat-value"><?php echo (int) $pending_docs; ?></div>
            <div class="cm-stat-desc">Needs review</div>
        </div>
        <div class="cm-stat teal">
            <div class="cm-stat-label">Total Spent</div>
            <div class="cm-stat-value" style="font-size:20px;letter-spacing:-.3px;">
                &#8377;<?php echo number_format($customer_revenue, 0); ?></div>
            <div class="cm-stat-desc">All booking value</div>
        </div>
    </div>

    <!-- Table card -->
    <div class="cm-card">
        <div class="cm-card-head">
            <div>
                <h3>Customer Directory</h3>
                <p>Quick records with a detail popup for each customer.</p>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <?php if (!empty($customers)): ?>
                    <input type="search" id="cmSearchInput" class="cm-search" placeholder="Search name, email, phone, or status">
                <?php endif; ?>
                <a class="cm-add-btn" href="<?php echo base_url('register'); ?>">
                    <svg viewBox="0 0 16 16" fill="none">
                        <path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Add Customer
                </a>
            </div>
        </div>

        <div class="cm-table-wrap">
            <table class="cm-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Bookings</th>
                        <th>Total Spent</th>
                        <th>Docs</th>
                        <th>Last Booking</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $customer): ?>
                            <?php
                            $customer_search = strtolower(trim(implode(' ', array_filter(array(
                                isset($customer['full_name']) ? $customer['full_name'] : '',
                                isset($customer['email']) ? $customer['email'] : '',
                                isset($customer['phone']) ? $customer['phone'] : '',
                                isset($customer['doc_status']) ? $customer['doc_status'] : '',
                                isset($customer['last_booking']) ? $customer['last_booking'] : '',
                            )))));
                            ?>
                            <tr class="js-cm-customer-row" data-search="<?php echo html_escape($customer_search); ?>">
                                <td>
                                    <div class="cm-customer-cell">
                                        <div class="cm-avatar"><?php echo html_escape(cm_initials($customer['full_name'])); ?>
                                        </div>
                                        <div>
                                            <div class="cm-name"><?php echo html_escape($customer['full_name']); ?></div>
                                            <div class="cm-email"><?php echo html_escape($customer['email']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="cm-mono"><?php echo html_escape($customer['phone']); ?></td>
                                <td><?php echo (int) $customer['total_bookings']; ?></td>
                                <td class="cm-amount">&#8377;<?php echo number_format((float) $customer['total_spent'], 0); ?>
                                </td>
                                <td>
                                    <span class="cm-badge <?php echo html_escape(strtolower($customer['doc_status'])); ?>">
                                        <?php echo ucfirst(html_escape($customer['doc_status'])); ?>
                                    </span>
                                </td>
                                <td class="cm-muted">
                                    <?php echo !empty($customer['last_booking']) ? date('d M Y', strtotime($customer['last_booking'])) : 'No bookings'; ?>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                                        <button class="cm-view-btn customer-view-btn" type="button"
                                            data-name="<?php echo html_escape($customer['full_name']); ?>"
                                            data-email="<?php echo html_escape($customer['email']); ?>"
                                            data-phone="<?php echo html_escape($customer['phone']); ?>"
                                            data-bookings="<?php echo (int) $customer['total_bookings']; ?>"
                                            data-spent="<?php echo number_format((float) $customer['total_spent'], 2, '.', ''); ?>"
                                            data-total-amount="<?php echo number_format((float) $customer['total_amount'], 2, '.', ''); ?>"
                                            data-paid-amount="<?php echo number_format((float) $customer['paid_amount'], 2, '.', ''); ?>"
                                            data-pending-amount="<?php echo number_format((float) $customer['pending_amount'], 2, '.', ''); ?>"
                                            data-docs="<?php echo html_escape($customer['doc_status']); ?>"
                                            data-last-booking="<?php echo !empty($customer['last_booking']) ? date('d M Y', strtotime($customer['last_booking'])) : 'No bookings'; ?>"
                                            data-detail="<?php echo html_escape(json_encode($customer['detail'])); ?>">
                                            <svg viewBox="0 0 16 16" fill="none">
                                                <path d="M1 8s3-5 7-5 7 5 7 5-3 5-7 5-7-5-7-5Z" stroke="currentColor"
                                                    stroke-width="1.4" />
                                                <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.4" />
                                            </svg>
                                            View
                                        </button>

                                        <?php if ((int) $customer['total_bookings'] === 0): ?>
                                            <form method="post"
                                                action="<?php echo base_url('admin/customers/delete/' . (int) $customer['id']); ?>"
                                                class="js-swal-confirm-form" data-swal-title="Delete customer?"
                                                data-swal-text="<?php echo html_escape($customer['full_name']); ?> and all their documents will be permanently removed."
                                                data-swal-confirm="Delete" style="display:inline;">
                                                <button class="cm-view-btn" type="submit"
                                                    style="border-color:var(--danger-bd);color:var(--danger-tx);background:var(--danger-bg);">
                                                    <svg viewBox="0 0 16 16" fill="none">
                                                        <path
                                                            d="M2 4h12M5 4V2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5V4M6 7v5M10 7v5M3 4l.8 9a1 1 0 0 0 1 .9h6.4a1 1 0 0 0 1-.9L13 4"
                                                            stroke="currentColor" stroke-width="1.4" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span style="
                display:inline-flex;align-items:center;gap:4px;
                padding:6px 10px;border-radius:var(--radius-sm);
                background:var(--surface-alt);border:1.5px solid var(--border);
                color:var(--text-3);font:600 11px/1 var(--font);
                cursor:not-allowed;"
                                                title="Delete their <?php echo (int) $customer['total_bookings']; ?> booking(s) first">
                                                <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                                                    <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.4" />
                                                    <path d="M8 5v4M8 10.5v.5" stroke="currentColor" stroke-width="1.4"
                                                        stroke-linecap="round" />
                                                </svg>
                                                <?php echo (int) $customer['total_bookings']; ?>
                                                booking<?php echo (int) $customer['total_bookings'] > 1 ? 's' : ''; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="cm-empty">No customers found.</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (!empty($customers)): ?>
            <div class="cm-pagination-wrap" id="cmPaginationWrap">
                <div class="cm-pagination-info" id="cmPaginationInfo"></div>
                <div class="cm-pagination" id="cmPagination"></div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL -->
<div class="cm-modal-overlay" id="customerModal">
    <div class="cm-modal">

        <!-- Header -->
        <div class="cm-modal-head">
            <div class="cm-modal-avatar" id="cmModalAvatar">?</div>
            <div class="cm-modal-head-info">
                <h3 id="cmModalName">Customer</h3>
                <p id="cmModalEmail">—</p>
            </div>
            <button class="cm-modal-close" id="closeCustomerModal" type="button" aria-label="Close">
                <svg viewBox="0 0 16 16" fill="none">
                    <path d="M3 3l10 10M13 3 3 13" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="cm-modal-body">

            <!-- KV grid -->
           <div class="cm-kv-grid">
    <div class="cm-kv">
        <div class="cm-kv-label">Phone</div>
        <div class="cm-kv-value mono" id="cmModalPhone">—</div>
    </div>
    <div class="cm-kv">
        <div class="cm-kv-label">Bookings</div>
        <div class="cm-kv-value" id="cmModalBookings">0</div>
    </div>
    <div class="cm-kv">
        <div class="cm-kv-label">Total Amount</div>
        <div class="cm-kv-value mono" id="cmModalTotalAmount">₹0</div>
    </div>
    <div class="cm-kv">
        <div class="cm-kv-label">Received Amount</div>
        <div class="cm-kv-value mono" style="color:var(--success-tx);" id="cmModalPaidAmount">₹0</div>
    </div>
    <div class="cm-kv">
        <div class="cm-kv-label">Pending Amount</div>
        <div class="cm-kv-value mono" style="color:var(--danger-tx);" id="cmModalPendingAmount">₹0</div>
    </div>
    <div class="cm-kv">
        <div class="cm-kv-label">Doc Status</div>
        <div class="cm-kv-value" id="cmModalDocs">—</div>
    </div>
    <div class="cm-kv" style="grid-column: span 2;">
        <div class="cm-kv-label">Last Booking</div>
        <div class="cm-kv-value" id="cmModalLastBooking">—</div>
    </div>
</div>

            <!-- Summary note -->
            <div class="cm-note" id="cmModalNote"></div>

            <!-- Documents -->
            <div class="cm-section">
                <div class="cm-section-title">Documents</div>
                <div class="cm-list" id="cmModalDocs-list"></div>
            </div>

            <!-- Bookings -->
            <div class="cm-section">
                <div class="cm-section-title">Bookings</div>
                <div class="cm-list" id="cmModalBookings-list"></div>
            </div>

        </div>
    </div>
</div>

<script>
    (function () {
        var customerRows = Array.prototype.slice.call(document.querySelectorAll('.js-cm-customer-row'));
        var customersPaginationWrap = document.getElementById('cmPaginationWrap');
        var customersPaginationInfo = document.getElementById('cmPaginationInfo');
        var customersPagination = document.getElementById('cmPagination');
        var customersSearchInput = document.getElementById('cmSearchInput');
        var customersPerPage = 8;
        var customersCurrentPage = 1;
        var filteredCustomerRows = customerRows.slice();

        function getPageItems(totalPages, page) {
            if (totalPages <= 5) {
                return Array.from({ length: totalPages }, function (_, index) {
                    return index + 1;
                });
            }
            if (page <= 2) {
                return [1, 2, 3, 'dots', totalPages];
            }
            if (page >= totalPages - 1) {
                return [1, 'dots', totalPages - 2, totalPages - 1, totalPages];
            }
            return [1, 'dots', page - 1, page, page + 1, 'dots', totalPages];
        }

        function createPagerButton(label, page, disabled, active) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'cm-page-btn' + (active ? ' active' : '');
            btn.textContent = label;
            btn.disabled = !!disabled;
            if (!disabled && !active) {
                btn.addEventListener('click', function () {
                    customersCurrentPage = page;
                    renderCustomersPagination();
                });
            }
            return btn;
        }

        function createPagerDots() {
            var dot = document.createElement('span');
            dot.className = 'cm-page-dot';
            dot.textContent = '...';
            return dot;
        }

        function renderCustomersPagination() {
            if (!customerRows.length || !customersPaginationWrap || !customersPaginationInfo || !customersPagination) {
                return;
            }

            var term = customersSearchInput ? customersSearchInput.value.toLowerCase().trim() : '';
            filteredCustomerRows = customerRows.filter(function (row) {
                var haystack = (row.getAttribute('data-search') || '').toLowerCase();
                return term === '' || haystack.indexOf(term) !== -1;
            });

            var total = filteredCustomerRows.length;
            if (total === 0) {
                customerRows.forEach(function (row) {
                    row.style.display = 'none';
                });
                customersPaginationInfo.textContent = 'No matching customers found';
                customersPagination.innerHTML = '';
                return;
            }

            var totalPages = Math.max(1, Math.ceil(total / customersPerPage));
            if (customersCurrentPage > totalPages) {
                customersCurrentPage = totalPages;
            }

            var start = (customersCurrentPage - 1) * customersPerPage;
            var end = start + customersPerPage;

            customerRows.forEach(function (row) {
                row.style.display = 'none';
            });

            filteredCustomerRows.forEach(function (row, index) {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });

            customersPaginationInfo.textContent = 'Showing ' + (start + 1) + '-' + Math.min(end, total) + ' of ' + total + ' customers';
            customersPagination.innerHTML = '';
            customersPagination.appendChild(createPagerButton('Prev', customersCurrentPage - 1, customersCurrentPage === 1, false));

            getPageItems(totalPages, customersCurrentPage).forEach(function (item) {
                if (item === 'dots') {
                    customersPagination.appendChild(createPagerDots());
                    return;
                }
                customersPagination.appendChild(createPagerButton(String(item), item, false, item === customersCurrentPage));
            });

            customersPagination.appendChild(createPagerButton('Next', customersCurrentPage + 1, customersCurrentPage === totalPages, false));
        }

        if (customersSearchInput) {
            customersSearchInput.addEventListener('input', function () {
                customersCurrentPage = 1;
                renderCustomersPagination();
            });
        }

        renderCustomersPagination();

        var overlay = document.getElementById('customerModal');
        var closeBtn = document.getElementById('closeCustomerModal');

       var elAvatar = document.getElementById('cmModalAvatar');
var elName = document.getElementById('cmModalName');
var elEmail = document.getElementById('cmModalEmail');
var elPhone = document.getElementById('cmModalPhone');
var elBookings = document.getElementById('cmModalBookings');
var elSpent = document.getElementById('cmModalSpent');
var elTotalAmount = document.getElementById('cmModalTotalAmount');
var elPaidAmount = document.getElementById('cmModalPaidAmount');
var elPendingAmount = document.getElementById('cmModalPendingAmount');
var elDocs = document.getElementById('cmModalDocs');
var elLastBooking = document.getElementById('cmModalLastBooking');
var elNote = document.getElementById('cmModalNote');
var elDocsList = document.getElementById('cmModalDocs-list');
var elBkgsList = document.getElementById('cmModalBookings-list');

        function esc(v) {
            return String(v || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function initials(name) {
            var parts = name.trim().split(/\s+/).slice(0, 2);
            return parts.map(function (p) {
                return p[0].toUpperCase();
            }).join('');
        }

        function badge(status) {
            var s = (status || 'missing').toLowerCase();
            var label = s.charAt(0).toUpperCase() + s.slice(1);
            return '<span class="cm-badge ' + esc(s) + '">' + esc(label) + '</span>';
        }

        function renderDocs(docs) {
            if (!docs || !docs.length) {
                elDocsList.innerHTML = '<div class="cm-list-empty">No document data for this customer.</div>';
                return;
            }
            elDocsList.innerHTML = docs.map(function (d) {
                var sub = d.status === 'missing' ? 'Not uploaded' : (d.booking_label || 'General');
                var note = d.admin_notes ? ' &middot; ' + esc(d.admin_notes) : '';
                return '<div class="cm-list-item">' +
                    '<div class="cm-list-item-info">' +
                    '<div class="cm-list-item-title">' + esc(d.document_type) + '</div>' +
                    '<div class="cm-list-item-sub">' + esc(sub) + note + '</div>' +
                    '</div>' +
                    badge(d.status) +
                    '</div>';
            }).join('');
        }

        function renderBookings(bookings) {
            if (!bookings || !bookings.length) {
                elBkgsList.innerHTML = '<div class="cm-list-empty">No bookings yet for this customer.</div>';
                return;
            }
            elBkgsList.innerHTML = bookings.map(function (b) {
                var title = (b.booking_code || 'Booking') + ' – ' + (b.vehicle_name || 'Vehicle');
                var sub = (b.pickup_location || '—') + ' → ' + (b.drop_location || '—');
                var meta = '₹' + esc(b.amount || '0') + ' · ' + esc(b.payment_status || '—');
                return '<div class="cm-list-item">' +
                    '<div class="cm-list-item-info">' +
                    '<div class="cm-list-item-title">' + esc(title) + '</div>' +
                    '<div class="cm-list-item-sub">' + esc(sub) + ' &nbsp;|&nbsp; ' + meta + '</div>' +
                    '</div>' +
                    badge(b.status || 'pending') +
                    '</div>';
            }).join('');
        }

        function openModal() {
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden';
            overlay.scrollTop = 0;
        }

        function closeModal() {
            overlay.classList.remove('open');
            document.body.style.overflow = '';
        }

       document.querySelectorAll('.customer-view-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var name = btn.dataset.name || 'Customer';
        var email = btn.dataset.email || '—';
        var phone = btn.dataset.phone || '—';
        var bookings = parseInt(btn.dataset.bookings, 10) || 0;
        var spent = parseFloat(btn.dataset.spent) || 0;
        var totalAmount = parseFloat(btn.dataset.totalAmount) || 0;
        var paidAmount = parseFloat(btn.dataset.paidAmount) || 0;
        var pendingAmount = parseFloat(btn.dataset.pendingAmount) || 0;
        var docs = btn.dataset.docs || '—';
        var lastBkg = btn.dataset.lastBooking || '—';
        var detail = {};
        try {
            detail = JSON.parse(btn.dataset.detail || '{}');
        } catch (e) {}

        elAvatar.textContent = initials(name);
        elName.textContent = name;
        elEmail.textContent = email;
        elPhone.textContent = phone;
        elBookings.textContent = bookings;
       if (elSpent) {
    elSpent.textContent = '₹' + spent.toLocaleString('en-IN', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}
        elTotalAmount.textContent = '₹' + totalAmount.toLocaleString('en-IN', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
        elPaidAmount.textContent = '₹' + paidAmount.toLocaleString('en-IN', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
        elPendingAmount.textContent = '₹' + pendingAmount.toLocaleString('en-IN', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
        elDocs.textContent = docs.charAt(0).toUpperCase() + docs.slice(1);
        elLastBooking.textContent = lastBkg;
        elNote.textContent = bookings > 0 ?
            name + ' has ' + bookings + ' booking(s) with total bookings worth ₹' + totalAmount.toFixed(0) + ', received ₹' + paidAmount.toFixed(0) + ', and ₹' + pendingAmount.toFixed(0) + ' pending.' :
            name + ' is registered but has not created any booking yet.';

        renderDocs(detail.documents || []);
        renderBookings(detail.bookings || []);
        openModal();
    });
});
        closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
        });
    })();
</script>
