<?php
if (!function_exists('admin_whatsapp_url')) {
    function admin_whatsapp_url($phone, $message)
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '') return '';
        if (strlen($digits) === 10) $digits = '91' . $digits;
        return 'https://wa.me/' . $digits . '?text=' . rawurlencode($message);
    }
}
?>

<style>
    /* ── Reset & Base ─────────────────────────────────────────── */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --c-bg: #f8f9fc;
        --c-surface: #ffffff;
        --c-border: #e4e9f0;
        --c-border-2: #d0d7e2;
        --c-text: #0f172a;
        --c-muted: #64748b;
        --c-hint: #94a3b8;
        --c-primary: #2563eb;
        --c-primary-s: #1d4ed8;
        --c-green-bg: #f0fdf4;
        --c-green-bd: #bbf7d0;
        --c-green-tx: #15803d;
        --c-red-bg: #fef2f2;
        --c-red-bd: #fecaca;
        --c-red-tx: #b91c1c;
        --c-amber-bg: #fffbeb;
        --c-amber-bd: #fde68a;
        --c-amber-tx: #92400e;
        --c-blue-bg: #eff6ff;
        --c-blue-bd: #bfdbfe;
        --c-blue-tx: #1e40af;
        --c-wa: #25d366;
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 14px;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, .07), 0 2px 4px rgba(0, 0, 0, .04);
    }

    /* ── Page Wrapper ─────────────────────────────────────────── */
    .pr-wrap {
        max-width: 1320px;
        margin: 0 auto;
        padding: 16px 16px 40px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--c-text);
        font-size: 14px;
        line-height: 1.5;
    }

    /* ── Page Header ─────────────────────────────────────────── */
    .pr-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .pr-header-left h1 {
        font-size: 20px;
        font-weight: 700;
        color: var(--c-text);
        letter-spacing: -.3px;
    }

    .pr-header-left p {
        font-size: 13px;
        color: var(--c-muted);
        margin-top: 2px;
    }

    /* ── Stats Strip ─────────────────────────────────────────── */
    .pr-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    @media (max-width: 640px) {
        .pr-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .stat-card {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: var(--radius-md);
        padding: 14px 16px;
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 3px 3px 0 0;
    }

    .stat-card.total::before {
        background: #94a3b8;
    }

    .stat-card.pending::before {
        background: #f59e0b;
    }

    .stat-card.approved::before {
        background: #22c55e;
    }

    .stat-card.rejected::before {
        background: #ef4444;
    }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--c-muted);
        margin-bottom: 6px;
    }

    .stat-num {
        font-size: 26px;
        font-weight: 700;
        color: var(--c-text);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-desc {
        font-size: 11.5px;
        color: var(--c-hint);
        line-height: 1.4;
    }

    /* ── Section Card ─────────────────────────────────────────── */
    .section-card {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 20px;
        border-bottom: 1px solid var(--c-border);
        flex-wrap: wrap;
    }

    .card-head h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--c-text);
    }

    .card-head p {
        font-size: 12.5px;
        color: var(--c-muted);
        margin-top: 2px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: var(--c-primary);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        border-radius: var(--radius-sm);
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background .15s;
        white-space: nowrap;
    }

    .btn-primary:hover {
        background: var(--c-primary-s);
    }

    /* ── Table Scroll Wrapper ─────────────────────────────────── */
    .table-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* ── Table ────────────────────────────────────────────────── */
    .pr-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 860px;
    }

    .pr-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid var(--c-border);
    }

    .pr-table th {
        padding: 10px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--c-muted);
        white-space: nowrap;
    }

    .pr-table tbody tr {
        border-bottom: 1px solid var(--c-border);
        transition: background .1s;
    }

    .pr-table tbody tr:last-child {
        border-bottom: none;
    }

    .pr-table tbody tr:hover {
        background: #f8fafc;
    }

    .pr-table td {
        padding: 12px 14px;
        vertical-align: top;
        color: var(--c-text);
    }

    .pr-table td strong {
        display: block;
        font-weight: 600;
        color: var(--c-text);
        margin-bottom: 1px;
    }

    .pr-table td .sub {
        display: block;
        font-size: 12px;
        color: var(--c-muted);
    }

    /* ── Badges ──────────────────────────────────────────────── */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 9px;
        border-radius: 100px;
        font-size: 11.5px;
        font-weight: 600;
        border: 1px solid transparent;
    }

    .badge-pending {
        background: var(--c-amber-bg);
        color: var(--c-amber-tx);
        border-color: var(--c-amber-bd);
    }

    .badge-approved {
        background: var(--c-green-bg);
        color: var(--c-green-tx);
        border-color: var(--c-green-bd);
    }

    .badge-rejected {
        background: var(--c-red-bg);
        color: var(--c-red-tx);
        border-color: var(--c-red-bd);
    }

    /* ── Receipt Link ────────────────────────────────────────── */
    .receipt-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border: 1px solid var(--c-border-2);
        border-radius: var(--radius-sm);
        background: var(--c-surface);
        color: var(--c-text);
        text-decoration: none;
        font-size: 12.5px;
        font-weight: 600;
        transition: border-color .15s, background .15s;
        white-space: nowrap;
    }

    .receipt-link:hover {
        border-color: var(--c-primary);
        color: var(--c-primary);
        background: var(--c-blue-bg);
    }

    .receipt-link svg {
        width: 13px;
        height: 13px;
        flex-shrink: 0;
    }

    /* ── Action Buttons ──────────────────────────────────────── */
    .action-row {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .action-btns {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .action-btns form {
        display: contents;
    }

    .btn-approve,
    .btn-reject,
    .btn-wa {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 11px;
        border-radius: var(--radius-sm);
        font-size: 12.5px;
        font-weight: 600;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        line-height: 1;
        transition: opacity .15s, transform .1s;
        white-space: nowrap;
    }

    .btn-approve:hover,
    .btn-reject:hover,
    .btn-wa:hover {
        opacity: .85;
    }

    .btn-approve:active,
    .btn-reject:active {
        transform: scale(.97);
    }

    .btn-approve {
        background: var(--c-green-bg);
        color: var(--c-green-tx);
        border-color: var(--c-green-bd);
    }

    .btn-reject {
        background: var(--c-red-bg);
        color: var(--c-red-tx);
        border-color: var(--c-red-bd);
    }

    .btn-wa {
        background: #dcfce7;
        color: #15803d;
        border-color: #bbf7d0;
    }

    .btn-icon {
        width: 13px;
        height: 13px;
    }

    /* ── Review State ────────────────────────────────────────── */
    .review-note {
        font-size: 12px;
        color: var(--c-muted);
        line-height: 1.4;
        margin-bottom: 4px;
    }

    /* ── Note Cell ───────────────────────────────────────────── */
    .note-cell {
        max-width: 200px;
    }

    .note-cell .customer-note {
        color: var(--c-muted);
        font-size: 12.5px;
    }

    .note-cell .admin-note {
        color: var(--c-red-tx);
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    /* ── Amount Cell ─────────────────────────────────────────── */
    .amount-cell strong {
        color: var(--c-text);
    }

    .amount-cell .mode-pill {
        display: inline-flex;
        align-items: center;
        padding: 2px 7px;
        background: var(--c-blue-bg);
        color: var(--c-blue-tx);
        border: 1px solid var(--c-blue-bd);
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
        margin-top: 3px;
    }

    /* ── Empty State ─────────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: var(--c-muted);
        font-size: 14px;
    }

    .empty-state svg {
        width: 40px;
        height: 40px;
        color: var(--c-border-2);
        display: block;
        margin: 0 auto 12px;
    }

    /* ── Mobile Card View ────────────────────────────────────── */
    @media (max-width: 860px) {
        .table-scroll {
            display: none;
        }

        .mobile-cards {
            display: block;
        }
    }

    @media (min-width: 861px) {
        .mobile-cards {
            display: none;
        }
    }

    .mobile-cards {
        padding: 0 0 4px;
    }

    .m-card {
        border-bottom: 1px solid var(--c-border);
        padding: 14px 16px;
    }

    .m-card:last-child {
        border-bottom: none;
    }

    .m-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 10px;
    }

    .m-booking-code {
        font-size: 14px;
        font-weight: 700;
        color: var(--c-text);
    }

    .m-date {
        font-size: 11.5px;
        color: var(--c-muted);
        margin-top: 1px;
    }

    .m-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px 12px;
        margin-bottom: 10px;
    }

    .m-field label {
        display: block;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--c-hint);
        margin-bottom: 2px;
    }

    .m-field span {
        font-size: 13px;
        color: var(--c-text);
        font-weight: 500;
    }

    .m-field .sub {
        font-size: 11.5px;
        color: var(--c-muted);
        font-weight: 400;
    }

    .m-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        flex-wrap: wrap;
        padding-top: 10px;
        border-top: 1px solid var(--c-border);
    }

    /* ── Scrollbar ───────────────────────────────────────────── */
    .table-scroll::-webkit-scrollbar {
        height: 5px;
    }

    .table-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background: var(--c-border-2);
        border-radius: 4px;
    }
</style>

<div class="pr-wrap">

    <!-- ── Page Header ── -->
    <div class="pr-header">
        <div class="pr-header-left">
            <h1>Payment Requests</h1>
            <p>Review uploaded receipts and approve or reject each customer request.</p>
        </div>
    </div>

    <!-- ── Stats Strip ── -->
    <div class="pr-stats">
        <div class="stat-card total">
            <div class="stat-label">Total</div>
            <div class="stat-num"><?php echo (int) $payment_request_counts['total']; ?></div>
            <div class="stat-desc">All uploaded receipts</div>
        </div>
        <div class="stat-card pending">
            <div class="stat-label">Pending</div>
            <div class="stat-num"><?php echo (int) $payment_request_counts['pending']; ?></div>
            <div class="stat-desc">Awaiting your review</div>
        </div>
        <div class="stat-card approved">
            <div class="stat-label">Approved</div>
            <div class="stat-num"><?php echo (int) $payment_request_counts['approved']; ?></div>
            <div class="stat-desc">Converted to records</div>
        </div>
        <div class="stat-card rejected">
            <div class="stat-label">Rejected</div>
            <div class="stat-num"><?php echo (int) $payment_request_counts['rejected']; ?></div>
            <div class="stat-desc">Needs re-upload</div>
        </div>
    </div>

    <!-- ── Main Section ── -->
    <div class="section-card">

        <div class="card-head">
            <div>
                <h3>Customer Upload Queue</h3>
                <p>Open the uploaded receipt, then approve or reject. Customers see the same status.</p>
            </div>
            <a class="btn-primary" href="<?php echo base_url('admin/payments/settings'); ?>">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Add Payment Details
            </a>
        </div>

        <?php if (!empty($payment_requests)): ?>

            <!-- ── Desktop Table ── -->
            <div class="table-scroll">
                <table class="pr-table">
                    <thead>
                        <tr>
                            <th>Booking</th>
                            <th>Customer</th>
                            <th>Vehicle</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Receipt</th>
                            <th>Status</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payment_requests as $request):
                            $is_reviewed = in_array(strtolower((string) $request['status']), ['approved', 'rejected'], true);
                            $approved_message = 'Hello ' . trim((string)$request['customer_name']) . ', your advance payment of Rs ' . number_format((float)$request['amount'], 2) . ' has been received for booking ' . trim((string)$request['booking_code']) . '. Your car is booked successfully. Thank you.';
                            $approved_whatsapp_url = strtolower((string)$request['status']) === 'approved'
                                ? admin_whatsapp_url($request['customer_phone'], $approved_message)
                                : '';
                        ?>
                            <tr>
                                <!-- Booking -->
                                <td>
                                    <strong><?php echo html_escape($request['booking_code']); ?></strong>
                                    <span class="sub"><?php echo !empty($request['created_at']) ? date('d M Y, h:i A', strtotime($request['created_at'])) : '—'; ?></span>
                                </td>

                                <!-- Customer -->
                                <td>
                                    <strong><?php echo html_escape($request['customer_name']); ?></strong>
                                    <span class="sub"><?php echo html_escape($request['customer_phone']); ?></span>
                                </td>

                                <!-- Vehicle -->
                                <td>
                                    <strong><?php echo html_escape($request['vehicle_name']); ?></strong>
                                    <span class="sub"><?php echo html_escape($request['registration_no']); ?></span>
                                </td>

                                <!-- Type -->
                                <td><?php echo ucwords(str_replace('_', ' ', html_escape($request['payment_type']))); ?></td>

                                <!-- Amount -->
                                <td class="amount-cell">
                                    <strong>₹<?php echo number_format((float)$request['amount'], 2); ?></strong>
                                    <span class="mode-pill"><?php echo html_escape($request['payment_mode']); ?></span>
                                </td>

                                <!-- Receipt -->
                                <td>
                                    <a class="receipt-link" href="<?php echo base_url($request['receipt_path']); ?>" target="_blank">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                        </svg>
                                        View
                                    </a>
                                </td>

                                <!-- Status -->
                                <td><span class="badge badge-<?php echo html_escape($request['status']); ?>"><?php echo ucfirst(html_escape($request['status'])); ?></span></td>

                                <!-- Note -->
                                <td class="note-cell">
                                    <span class="customer-note"><?php echo !empty($request['customer_notes']) ? html_escape($request['customer_notes']) : '—'; ?></span>
                                    <?php if (!empty($request['admin_notes'])): ?>
                                        <span class="admin-note">↳ <?php echo html_escape($request['admin_notes']); ?></span>
                                    <?php endif; ?>
                                </td>

                                <!-- Action -->
                                <td>
                                    <div class="action-row">
                                        <?php if (!$is_reviewed): ?>
                                            <div class="action-btns">
                                                <form method="post" action="<?php echo base_url('admin/payments/approve/' . (int)$request['id']); ?>">
                                                    <input type="hidden" name="admin_notes" value="Payment approved by admin.">
                                                    <button class="btn-approve" type="submit">
                                                        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="20 6 9 17 4 12" />
                                                        </svg>
                                                        Approve
                                                    </button>
                                                </form>
                                                <form method="post" action="<?php echo base_url('admin/payments/reject/' . (int)$request['id']); ?>">
                                                    <input type="hidden" name="admin_notes" value="Receipt rejected. Please upload a clear or correct payment proof.">
                                                    <button class="btn-reject" type="submit">
                                                        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                            <line x1="18" y1="6" x2="6" y2="18" />
                                                            <line x1="6" y1="6" x2="18" y2="18" />
                                                        </svg>
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <p class="review-note"><?php echo strtolower((string)$request['status']) === 'approved' ? '✓ Already approved' : '✗ Already rejected'; ?></p>
                                            <?php if ($approved_whatsapp_url !== ''): ?>
                                                <a class="btn-wa" href="<?php echo html_escape($approved_whatsapp_url); ?>" target="_blank" rel="noopener noreferrer">
                                                    <svg class="btn-icon" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                                        <path d="M11.999 2.0C6.477 2.0 2.0 6.477 2.0 12.0c0 1.733.463 3.36 1.272 4.775L2 22l5.408-1.233C8.743 21.586 10.34 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.182c-1.577 0-3.05-.432-4.316-1.184l-.309-.183-3.208.732.748-3.121-.201-.32A8.155 8.155 0 0 1 3.818 12C3.818 7.495 7.495 3.818 12 3.818S20.182 7.495 20.182 12 16.505 20.182 12 20.182z" />
                                                    </svg>
                                                    WhatsApp
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- ── Mobile Cards ── -->
            <div class="mobile-cards">
                <?php foreach ($payment_requests as $request):
                    $is_reviewed = in_array(strtolower((string) $request['status']), ['approved', 'rejected'], true);
                    $approved_message = 'Hello ' . trim((string)$request['customer_name']) . ', your advance payment of Rs ' . number_format((float)$request['amount'], 2) . ' has been received for booking ' . trim((string)$request['booking_code']) . '. Your car is booked successfully. Thank you.';
                    $approved_whatsapp_url = strtolower((string)$request['status']) === 'approved'
                        ? admin_whatsapp_url($request['customer_phone'], $approved_message)
                        : '';
                ?>
                    <div class="m-card">
                        <div class="m-card-top">
                            <div>
                                <div class="m-booking-code"><?php echo html_escape($request['booking_code']); ?></div>
                                <div class="m-date"><?php echo !empty($request['created_at']) ? date('d M Y, h:i A', strtotime($request['created_at'])) : '—'; ?></div>
                            </div>
                            <span class="badge badge-<?php echo html_escape($request['status']); ?>"><?php echo ucfirst(html_escape($request['status'])); ?></span>
                        </div>

                        <div class="m-grid">
                            <div class="m-field">
                                <label>Customer</label>
                                <span><?php echo html_escape($request['customer_name']); ?><br><span class="sub"><?php echo html_escape($request['customer_phone']); ?></span></span>
                            </div>
                            <div class="m-field">
                                <label>Vehicle</label>
                                <span><?php echo html_escape($request['vehicle_name']); ?><br><span class="sub"><?php echo html_escape($request['registration_no']); ?></span></span>
                            </div>
                            <div class="m-field">
                                <label>Amount</label>
                                <span>₹<?php echo number_format((float)$request['amount'], 2); ?></span>
                            </div>
                            <div class="m-field">
                                <label>Type</label>
                                <span><?php echo ucwords(str_replace('_', ' ', html_escape($request['payment_type']))); ?></span>
                            </div>
                            <?php if (!empty($request['customer_notes'])): ?>
                                <div class="m-field" style="grid-column:1/-1;">
                                    <label>Customer Note</label>
                                    <span><?php echo html_escape($request['customer_notes']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="m-footer">
                            <a class="receipt-link" href="<?php echo base_url($request['receipt_path']); ?>" target="_blank">
                                <svg style="width:13px;height:13px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                                View Receipt
                            </a>

                            <div class="action-btns">
                                <?php if (!$is_reviewed): ?>
                                    <form method="post" action="<?php echo base_url('admin/payments/approve/' . (int)$request['id']); ?>">
                                        <input type="hidden" name="admin_notes" value="Payment approved by admin.">
                                        <button class="btn-approve" type="submit">✓ Approve</button>
                                    </form>
                                    <form method="post" action="<?php echo base_url('admin/payments/reject/' . (int)$request['id']); ?>">
                                        <input type="hidden" name="admin_notes" value="Receipt rejected. Please upload a clear or correct payment proof.">
                                        <button class="btn-reject" type="submit">✗ Reject</button>
                                    </form>
                                <?php else: ?>
                                    <span class="review-note"><?php echo strtolower((string)$request['status']) === 'approved' ? '✓ Approved' : '✗ Rejected'; ?></span>
                                    <?php if ($approved_whatsapp_url !== ''): ?>
                                        <a class="btn-wa" href="<?php echo html_escape($approved_whatsapp_url); ?>" target="_blank" rel="noopener noreferrer">WhatsApp</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                No payment requests uploaded yet.
            </div>
        <?php endif; ?>

    </div><!-- /.section-card -->

</div><!-- /.pr-wrap -->