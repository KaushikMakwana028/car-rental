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
$total_customers  = count($customers);
$active_customers = 0;
$pending_docs     = 0;
$customer_revenue = 0;

foreach ($customers as $c) {
    if ((int)$c['total_bookings'] > 0) $active_customers++;
    if (!in_array($c['doc_status'], ['approved', 'complete'], true)) $pending_docs++;
    $customer_revenue += (float)$c['total_spent'];
}

function cm_initials($name)
{
    $parts = array_filter(explode(' ', trim($name)));
    $out = '';
    foreach (array_slice($parts, 0, 2) as $p) $out .= strtoupper($p[0]);
    return $out ?: '?';
}
?>

<div class="cm-wrap">

    <!-- Stats -->
    <div class="cm-stats">
        <div class="cm-stat blue">
            <div class="cm-stat-label">Total Customers</div>
            <div class="cm-stat-value"><?php echo (int)$total_customers; ?></div>
            <div class="cm-stat-desc">Registered accounts</div>
        </div>
        <div class="cm-stat green">
            <div class="cm-stat-label">Active</div>
            <div class="cm-stat-value"><?php echo (int)$active_customers; ?></div>
            <div class="cm-stat-desc">With at least 1 booking</div>
        </div>
        <div class="cm-stat amber">
            <div class="cm-stat-label">Pending Docs</div>
            <div class="cm-stat-value"><?php echo (int)$pending_docs; ?></div>
            <div class="cm-stat-desc">Needs review</div>
        </div>
        <div class="cm-stat teal">
            <div class="cm-stat-label">Total Spent</div>
            <div class="cm-stat-value" style="font-size:20px;letter-spacing:-.3px;">&#8377;<?php echo number_format($customer_revenue, 0); ?></div>
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
            <a class="cm-add-btn" href="<?php echo base_url('register'); ?>">
                <svg viewBox="0 0 16 16" fill="none">
                    <path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                Add Customer
            </a>
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
                            <tr>
                                <td>
                                    <div class="cm-customer-cell">
                                        <div class="cm-avatar"><?php echo html_escape(cm_initials($customer['full_name'])); ?></div>
                                        <div>
                                            <div class="cm-name"><?php echo html_escape($customer['full_name']); ?></div>
                                            <div class="cm-email"><?php echo html_escape($customer['email']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="cm-mono"><?php echo html_escape($customer['phone']); ?></td>
                                <td><?php echo (int)$customer['total_bookings']; ?></td>
                                <td class="cm-amount">&#8377;<?php echo number_format((float)$customer['total_spent'], 0); ?></td>
                                <td>
                                    <span class="cm-badge <?php echo html_escape(strtolower($customer['doc_status'])); ?>">
                                        <?php echo ucfirst(html_escape($customer['doc_status'])); ?>
                                    </span>
                                </td>
                                <td class="cm-muted">
                                    <?php echo !empty($customer['last_booking']) ? date('d M Y', strtotime($customer['last_booking'])) : 'No bookings'; ?>
                                </td>
                                <td>
                                    <button class="cm-view-btn customer-view-btn" type="button"
                                        data-name="<?php echo html_escape($customer['full_name']); ?>"
                                        data-email="<?php echo html_escape($customer['email']); ?>"
                                        data-phone="<?php echo html_escape($customer['phone']); ?>"
                                        data-bookings="<?php echo (int)$customer['total_bookings']; ?>"
                                        data-spent="<?php echo number_format((float)$customer['total_spent'], 2, '.', ''); ?>"
                                        data-docs="<?php echo html_escape($customer['doc_status']); ?>"
                                        data-last-booking="<?php echo !empty($customer['last_booking']) ? date('d M Y', strtotime($customer['last_booking'])) : 'No bookings'; ?>"
                                        data-detail="<?php echo html_escape(json_encode($customer['detail'])); ?>">
                                        <svg viewBox="0 0 16 16" fill="none">
                                            <path d="M1 8s3-5 7-5 7 5 7 5-3 5-7 5-7-5-7-5Z" stroke="currentColor" stroke-width="1.4" />
                                            <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.4" />
                                        </svg>
                                        View
                                    </button>
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
                    <div class="cm-kv-label">Total Spent</div>
                    <div class="cm-kv-value mono" id="cmModalSpent">₹0</div>
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
    (function() {
        var overlay = document.getElementById('customerModal');
        var closeBtn = document.getElementById('closeCustomerModal');

        var elAvatar = document.getElementById('cmModalAvatar');
        var elName = document.getElementById('cmModalName');
        var elEmail = document.getElementById('cmModalEmail');
        var elPhone = document.getElementById('cmModalPhone');
        var elBookings = document.getElementById('cmModalBookings');
        var elSpent = document.getElementById('cmModalSpent');
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
            return parts.map(function(p) {
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
            elDocsList.innerHTML = docs.map(function(d) {
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
            elBkgsList.innerHTML = bookings.map(function(b) {
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
                elSpent.textContent = '₹' + spent.toLocaleString('en-IN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                elDocs.textContent = docs.charAt(0).toUpperCase() + docs.slice(1);
                elLastBooking.textContent = lastBkg;
                elNote.textContent = bookings > 0 ?
                    name + ' has ' + bookings + ' booking(s) with a total spend of ₹' + spent.toFixed(0) + '.' :
                    name + ' is registered but has not created any booking yet.';

                renderDocs(detail.documents || []);
                renderBookings(detail.bookings || []);
                openModal();
            });
        });

        closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
        });
    })();
</script>