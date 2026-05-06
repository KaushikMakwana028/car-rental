<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
<style>
    :root {
        --bk-bg: #F2F5F9;
        --bk-card: #ffffff;
        --bk-card-soft: #F8FAFD;
        --bk-text: #111827;
        --bk-muted: #6B7280;
        --bk-hint: #9CA3AF;
        --bk-border: rgba(0, 0, 0, 0.09);
        --bk-border-med: rgba(0, 0, 0, 0.13);

        /* Blue palette — replaces all gold/amber */
        --bk-primary: #378ADD;
        --bk-primary-deep: #185FA5;
        --bk-primary-soft: #E6F1FB;
        --bk-primary-mid: #B5D4F4;

        --bk-success: #0F6E56;
        --bk-success-soft: #E1F5EE;
        --bk-warning: #854F0B;
        --bk-warning-soft: #FAEEDA;
        --bk-danger: #A32D2D;
        --bk-danger-soft: #FCEBEB;
        --bk-info: #185FA5;
        --bk-info-soft: #E6F1FB;

        --r-sm: 6px;
        --r-md: 8px;
        --r-lg: 12px;
        --r-xl: 16px;
        --font: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ── Reset scoped ── */
    .bk-shell *,
    .bk-shell *::before,
    .bk-shell *::after,
    .bk-modal-overlay *,
    .bk-modal-overlay *::before,
    .bk-modal-overlay *::after {
        box-sizing: border-box;
    }

    .bk-shell,
    .bk-modal-overlay {
        font-family: var(--font);
        color: var(--bk-text);
        font-size: 13px;
        line-height: 1.5;
    }

    /* ── Shell ── */
    .bk-shell {
        background: var(--bk-bg);
        padding: 16px 18px 28px;
    }

    /* ── Top bar ── */
    .bk-topbar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .bk-topbar h1 {
        font-size: 18px;
        font-weight: 600;
        color: var(--bk-text);
        margin: 0 0 2px;
        line-height: 1.2;
    }

    .bk-topbar p {
        font-size: 12px;
        color: var(--bk-muted);
        margin: 0;
        max-width: 560px;
    }

    .bk-topbar-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
        flex-wrap: wrap;
    }

    /* ── Buttons ── */
    .bk-btn,
    .bk-btn-ghost,
    .bk-btn-line {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        height: 32px;
        padding: 0 13px;
        border-radius: var(--r-md);
        font-size: 12px;
        font-weight: 600;
        font-family: var(--font);
        text-decoration: none;
        border: 0.5px solid transparent;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s, opacity 0.15s;
        white-space: nowrap;
    }

    .bk-btn {
        background: var(--bk-primary);
        color: #fff;
        border-color: var(--bk-primary);
    }

    .bk-btn:hover {
        background: var(--bk-primary-deep);
        border-color: var(--bk-primary-deep);
    }

    .bk-btn-ghost {
        background: var(--bk-card);
        color: var(--bk-muted);
        border-color: var(--bk-border-med);
    }

    .bk-btn-ghost:hover {
        background: var(--bk-card-soft);
        color: var(--bk-text);
    }

    .bk-btn-line {
        background: transparent;
        color: var(--bk-muted);
        border-color: var(--bk-border-med);
    }

    .bk-btn-line:hover {
        background: var(--bk-card-soft);
        color: var(--bk-text);
    }

    .bk-btn-blue {
        background: var(--bk-primary-soft);
        color: var(--bk-primary-deep);
        border-color: var(--bk-primary-mid);
    }

    .bk-btn-blue:hover {
        background: var(--bk-primary-mid);
    }

    /* ── Stat cards ── */
    .bk-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 14px;
    }

    .bk-stat {
        background: var(--bk-card);
        border: 0.5px solid var(--bk-border);
        border-radius: var(--r-lg);
        padding: 11px 13px;
        position: relative;
        overflow: hidden;
    }

    .bk-stat::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
    }

    .bk-stat.s-blue::before {
        background: var(--bk-primary);
    }

    .bk-stat.s-teal::before {
        background: #1D9E75;
    }

    .bk-stat.s-amber::before {
        background: #EF9F27;
    }

    .bk-stat.s-green::before {
        background: #639922;
    }

    .bk-stat-label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--bk-hint);
        display: block;
        margin-bottom: 3px;
    }

    .bk-stat-value {
        font-size: 20px;
        font-weight: 600;
        line-height: 1;
        display: block;
        margin-bottom: 3px;
    }

    .bk-stat-value.c-blue {
        color: var(--bk-primary-deep);
    }

    .bk-stat-value.c-teal {
        color: #0F6E56;
    }

    .bk-stat-value.c-amber {
        color: #854F0B;
    }

    .bk-stat-value.c-green {
        color: #3B6D11;
    }

    .bk-stat-desc {
        font-size: 10px;
        color: var(--bk-hint);
        line-height: 1.3;
    }

    /* ── Main card ── */
    .bk-card {
        background: var(--bk-card);
        border: 0.5px solid var(--bk-border);
        border-radius: var(--r-xl);
        overflow: hidden;
    }

    .bk-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 16px;
        border-bottom: 0.5px solid var(--bk-border);
        flex-wrap: wrap;
    }

    .bk-card-head h3 {
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 1px;
        color: var(--bk-text);
    }

    .bk-card-head p {
        font-size: 11px;
        color: var(--bk-muted);
        margin: 0;
    }

    /* ── Toolbar ── */
    .bk-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 16px;
        border-bottom: 0.5px solid var(--bk-border);
        background: var(--bk-card-soft);
        flex-wrap: wrap;
    }

    .bk-filters {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .bk-chip {
        height: 26px;
        padding: 0 10px;
        border-radius: 999px;
        border: 0.5px solid var(--bk-border-med);
        background: var(--bk-card);
        color: var(--bk-muted);
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        font-family: var(--font);
        transition: all 0.15s;
        white-space: nowrap;
    }

    .bk-chip.active {
        background: var(--bk-primary-soft);
        border-color: var(--bk-primary-mid);
        color: var(--bk-primary-deep);
    }

    .bk-chip:hover:not(.active) {
        background: var(--bk-card-soft);
        color: var(--bk-text);
    }

    .bk-search {
        height: 30px;
        min-width: 220px;
        max-width: 280px;
        flex: 1;
        border: 0.5px solid var(--bk-border-med);
        border-radius: var(--r-md);
        background: var(--bk-card);
        padding: 0 10px;
        font-size: 12px;
        font-family: var(--font);
        color: var(--bk-text);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .bk-search:focus {
        border-color: var(--bk-primary);
        box-shadow: 0 0 0 3px rgba(55, 138, 221, 0.12);
    }

    /* ── Table ── */
    .bk-table-wrap {
        overflow-x: auto;
    }

    .bk-table {
        width: 100%;
        min-width: 960px;
        border-collapse: collapse;
    }

    .bk-table thead {
        background: var(--bk-card-soft);
    }

    .bk-table th {
        padding: 8px 14px;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: var(--bk-hint);
        text-align: left;
        border-bottom: 0.5px solid var(--bk-border);
        white-space: nowrap;
    }

    .bk-table td {
        padding: 9px 14px;
        border-bottom: 0.5px solid var(--bk-border);
        vertical-align: middle;
        font-size: 12px;
        color: var(--bk-text);
    }

    .bk-table tbody tr:last-child td {
        border-bottom: none;
    }

    .bk-table tbody tr:hover td {
        background: var(--bk-primary-soft);
    }

    .td-id {
        font-weight: 700;
        color: var(--bk-primary-deep);
        font-size: 12px;
        display: block;
    }

    .td-sub {
        font-size: 10px;
        color: var(--bk-hint);
        display: block;
        margin-top: 1px;
    }

    .td-strong {
        font-weight: 500;
        color: var(--bk-text);
        display: block;
    }

    .td-muted {
        font-size: 10px;
        color: var(--bk-hint);
        display: block;
        margin-top: 1px;
    }

    /* Badges */
    .bk-badge,
    .bk-pay-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .bk-trip-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 7px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 600;
        background: var(--bk-info-soft);
        color: var(--bk-info);
        margin-bottom: 3px;
    }

    .bk-badge.pending {
        background: var(--bk-warning-soft);
        color: var(--bk-warning);
    }

    .bk-badge.confirmed,
    .bk-badge.active {
        background: var(--bk-success-soft);
        color: var(--bk-success);
    }

    .bk-badge.completed {
        background: #E2E8F0;
        color: #475569;
    }

    .bk-badge.upcoming {
        background: var(--bk-info-soft);
        color: var(--bk-info);
    }

    .bk-badge.cancelled {
        background: var(--bk-danger-soft);
        color: var(--bk-danger);
    }

    .bk-pay-badge.paid {
        background: var(--bk-success-soft);
        color: var(--bk-success);
    }

    .bk-pay-badge.advance-received,
    .bk-pay-badge.part-paid {
        background: var(--bk-warning-soft);
        color: var(--bk-warning);
    }

    .bk-pay-badge.pending {
        background: var(--bk-danger-soft);
        color: var(--bk-danger);
    }

    .bk-actions {
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .bk-action-btn {
        display: inline-flex;
        align-items: center;
        height: 26px;
        padding: 0 10px;
        border-radius: var(--r-sm);
        font-size: 11px;
        font-weight: 600;
        border: 0.5px solid var(--bk-border-med);
        background: var(--bk-card);
        color: var(--bk-text);
        cursor: pointer;
        font-family: var(--font);
        text-decoration: none;
        transition: background 0.15s;
    }

    .bk-action-btn:hover {
        background: var(--bk-card-soft);
    }

    .bk-action-btn.blue {
        background: var(--bk-primary-soft);
        border-color: var(--bk-primary-mid);
        color: var(--bk-primary-deep);
    }

    .bk-action-btn.blue:hover {
        background: var(--bk-primary-mid);
    }

    .bk-empty {
        padding: 36px 20px;
        text-align: center;
        color: var(--bk-muted);
        font-size: 13px;
    }

    .bk-empty-icon {
        width: 36px;
        height: 36px;
        background: var(--bk-primary-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
    }

    .bk-empty-title {
        font-size: 13px;
        font-weight: 500;
        color: var(--bk-text);
        margin-bottom: 2px;
    }

    .bk-empty-desc {
        font-size: 11px;
        color: var(--bk-hint);
    }

    /* ── Modals ── */
    .bk-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
        z-index: 9999;
    }

    .bk-modal-overlay.open {
        display: flex;
    }

    .bk-modal {
        width: 100%;
        max-width: 620px;
        max-height: calc(100vh - 32px);
        background: var(--bk-card);
        border-radius: var(--r-xl);
        border: 0.5px solid var(--bk-border-med);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .bk-modal-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 16px 12px;
        border-bottom: 0.5px solid var(--bk-border);
        background: var(--bk-card-soft);
        flex-shrink: 0;
    }

    .bk-modal-head h3 {
        font-size: 15px;
        font-weight: 600;
        margin: 0 0 2px;
        color: var(--bk-text);
    }

    .bk-modal-head p {
        font-size: 11px;
        color: var(--bk-muted);
        margin: 0;
    }

    .bk-modal-close {
        width: 28px;
        height: 28px;
        border-radius: var(--r-sm);
        border: 0.5px solid var(--bk-border-med);
        background: var(--bk-card);
        color: var(--bk-muted);
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        line-height: 1;
        font-family: var(--font);
    }

    .bk-modal-close:hover {
        background: var(--bk-card-soft);
        color: var(--bk-text);
    }

    .bk-modal-body {
        padding: 14px 16px 16px;
        overflow-y: auto;
        flex: 1;
    }

    .bk-modal-kicker {
        display: inline-flex;
        align-items: center;
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 600;
        background: var(--bk-primary-soft);
        color: var(--bk-primary-deep);
        margin-bottom: 10px;
    }

    /* Detail grid */
    .bk-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        margin-bottom: 12px;
    }

    .bk-detail-card {
        border: 0.5px solid var(--bk-border);
        border-radius: var(--r-lg);
        padding: 10px 12px;
        background: var(--bk-card-soft);
    }

    .bk-detail-card span {
        display: block;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: var(--bk-hint);
        margin-bottom: 4px;
    }

    .bk-detail-card strong {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--bk-text);
        line-height: 1.4;
    }

    /* Fare box */
    .bk-fare-box {
        border: 0.5px solid var(--bk-primary-mid);
        background: var(--bk-primary-soft);
        border-radius: var(--r-lg);
        padding: 12px 14px;
        margin-bottom: 12px;
    }

    .bk-fare-row {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        padding: 5px 0;
        font-size: 12px;
        color: var(--bk-muted);
    }

    .bk-fare-row strong {
        color: var(--bk-text);
        font-weight: 500;
    }

    .bk-fare-row.total {
        margin-top: 6px;
        padding-top: 10px;
        border-top: 0.5px solid var(--bk-primary-mid);
        font-size: 14px;
        font-weight: 600;
        color: var(--bk-text);
    }

    .bk-fare-row.good strong {
        color: var(--bk-success);
    }

    .bk-fare-row.due strong {
        color: var(--bk-danger);
    }

    .bk-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 2px;
    }

    .bk-detail-note {
        margin-top: 12px;
        padding: 10px 12px;
        border-radius: var(--r-md);
        background: #f8fafc;
        border: 0.5px solid var(--bk-border);
        color: var(--bk-muted);
        font-size: 11px;
        line-height: 1.6;
    }

    /* Collect form */
    .bk-collect-summary {
        border: 0.5px solid var(--bk-primary-mid);
        background: var(--bk-primary-soft);
        border-radius: var(--r-lg);
        padding: 10px 14px;
        margin-bottom: 12px;
    }

    .bk-collect-form {
        display: grid;
        gap: 10px;
    }

    .bk-collect-form label {
        display: block;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: var(--bk-muted);
        margin-bottom: 4px;
    }

    .bk-collect-form input,
    .bk-collect-form select,
    .bk-collect-form textarea {
        width: 100%;
        height: 34px;
        border: 0.5px solid var(--bk-border-med);
        border-radius: var(--r-md);
        background: var(--bk-card);
        padding: 0 10px;
        font-size: 12px;
        font-family: var(--font);
        color: var(--bk-text);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        -webkit-appearance: none;
    }

    .bk-collect-form textarea {
        height: 70px;
        padding: 8px 10px;
        resize: vertical;
    }

    .bk-collect-form input:focus,
    .bk-collect-form select:focus,
    .bk-collect-form textarea:focus {
        border-color: var(--bk-primary);
        box-shadow: 0 0 0 3px rgba(55, 138, 221, 0.12);
    }

    .bk-collect-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .bk-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .bk-shell {
            padding: 12px 12px 20px;
        }

        .bk-stats {
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .bk-stat-value {
            font-size: 17px;
        }

        .bk-topbar {
            align-items: stretch;
        }

        .bk-topbar-actions {
            width: 100%;
        }

        .bk-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .bk-search {
            max-width: none;
            min-width: 0;
        }

        .bk-filters {
            gap: 5px;
        }

        .bk-detail-grid {
            grid-template-columns: 1fr;
        }

        .bk-collect-grid {
            grid-template-columns: 1fr;
        }

        .bk-modal-overlay {
            padding: 10px;
            align-items: flex-end;
        }

        .bk-modal {
            max-width: 100%;
            border-radius: var(--r-xl) var(--r-xl) 0 0;
        }
    }

    @media (max-width: 420px) {
        .bk-topbar h1 {
            font-size: 16px;
        }

        .bk-stats {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<?php
if (!function_exists('admin_whatsapp_url')) {
    function admin_whatsapp_url($phone, $message)
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '') {
            return '';
        }

        if (strlen($digits) === 10) {
            $digits = '91' . $digits;
        }

        return 'https://wa.me/' . $digits . '?text=' . rawurlencode($message);
    }
}
/* ── Computed stats ── */
$total_bookings     = count($bookings);
$confirmed_bookings = 0;
$pending_bookings   = 0;
$completed_bookings = 0;
$booking_revenue    = 0;

foreach ($bookings as &$booking) {
    $booking_revenue += (float) $booking['amount'];

    $booking_status = !empty($booking['effective_status']) ? $booking['effective_status'] : $booking['status'];

    if ($booking_status === 'confirmed')          $confirmed_bookings++;
    elseif ($booking_status === 'pending')        $pending_bookings++;
    elseif ($booking_status === 'completed')      $completed_bookings++;

    $today  = date('Y-m-d');
    $pickup = !empty($booking['pickup_date']) ? $booking['pickup_date'] : '';
    $return = !empty($booking['return_date'])  ? $booking['return_date']  : '';

    if ($booking_status === 'completed')            $booking['display_status'] = 'completed';
    elseif ($pickup !== '' && $pickup > $today)     $booking['display_status'] = 'upcoming';
    elseif ($booking_status === 'confirmed')        $booking['display_status'] = 'active';
    else                                            $booking['display_status'] = 'pending';

    $ps = !empty($booking['pickup_date'])  ? strtotime($booking['pickup_date']) : false;
    $rs = !empty($booking['return_date'])  ? strtotime($booking['return_date'])  : false;
    $booking['trip_dates_label'] = ($ps && $rs)
        ? date('d M', $ps) . ' – ' . date('d M', $rs)
        : ($booking['trip_label'] ?? '—');
    $booking['trip_days'] = ($ps && $rs && $rs >= $ps)
        ? max(1, (int) round(($rs - $ps) / 86400) + 1) : 1;
    $booking['rate_per_km_estimate'] = !empty($booking['estimated_km'])
        ? round(((float) $booking['amount']) / max(1, (int) $booking['estimated_km']), 2) : 0;
    $booking['table_search'] = strtolower(trim(
        ($booking['booking_code'] ?? '') . ' ' .
            ($booking['customer_name'] ?? '') . ' ' .
            ($booking['customer_phone'] ?? '') . ' ' .
            ($booking['vehicle_name'] ?? '') . ' ' .
            ($booking['registration_no'] ?? '') . ' ' .
            ($booking['pickup_location'] ?? '') . ' ' .
            ($booking['drop_location'] ?? '') . ' ' .
            $booking['display_status'] . ' ' .
            ($booking['payment_status'] ?? '')
    ));
}
unset($booking);
?>

<div class="bk-shell">

    <!-- Top bar -->
    <div class="bk-topbar">
        <div>
            <h1>Bookings</h1>
            <p>Track reservations, payment progress and trip activity from one workspace.</p>
        </div>
        <div class="bk-topbar-actions">
            <button class="bk-btn-ghost" type="button" id="bkRefreshBtn">
                <svg width="11" height="11" viewBox="0 0 11 11" fill="none">
                    <path d="M9.5 5.5A4 4 0 112 5.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                    <path d="M9.5 2.5v3h-3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Refresh
            </button>
            <a class="bk-btn" href="<?php echo base_url('admin/bookings/create'); ?>">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                    <path d="M5 1v8M1 5h8" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                </svg>
                New Booking
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="bk-stats">
        <div class="bk-stat s-blue">
            <span class="bk-stat-label">Total Bookings</span>
            <span class="bk-stat-value c-blue"><?php echo $total_bookings; ?></span>
            <span class="bk-stat-desc">All reservations on record</span>
        </div>
        <div class="bk-stat s-teal">
            <span class="bk-stat-label">Active / Confirmed</span>
            <span class="bk-stat-value c-teal"><?php echo $confirmed_bookings; ?></span>
            <span class="bk-stat-desc">Trips approved &amp; ready</span>
        </div>
        <div class="bk-stat s-amber">
            <span class="bk-stat-label">Pending</span>
            <span class="bk-stat-value c-amber"><?php echo $pending_bookings; ?></span>
            <span class="bk-stat-desc">Awaiting review or payment</span>
        </div>
        <div class="bk-stat s-green">
            <span class="bk-stat-label">Revenue</span>
            <span class="bk-stat-value c-green">Rs <?php echo number_format($booking_revenue, 0); ?></span>
            <span class="bk-stat-desc">Combined expected amount</span>
        </div>
    </div>

    <!-- Main card -->
    <div class="bk-card">
        <div class="bk-card-head">
            <div>
                <h3>Booking Registry</h3>
                <p>Filter, search and collect payments without leaving this page.</p>
            </div>
        </div>

        <div class="bk-toolbar">
            <div class="bk-filters">
                <button class="bk-chip active" type="button" data-filter="all">All (<?php echo $total_bookings; ?>)</button>
                <button class="bk-chip" type="button" data-filter="active">Active (<?php echo $confirmed_bookings; ?>)</button>
                <button class="bk-chip" type="button" data-filter="pending">Pending (<?php echo $pending_bookings; ?>)</button>
                <button class="bk-chip" type="button" data-filter="upcoming">Upcoming</button>
                <button class="bk-chip" type="button" data-filter="completed">Completed (<?php echo $completed_bookings; ?>)</button>
            </div>
            <input class="bk-search" type="text" id="bkSearchInput" placeholder="Search booking, customer, vehicle…">
        </div>

        <div class="bk-table-wrap">
            <table class="bk-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Trip</th>
                        <th>KM</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="bkTableBody">
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $booking): ?>
                            <?php
                            $has_balance = ((float) $booking['balance_amount'] > 0.01);
                            $is_fully_paid = (float) $booking['paid_amount'] >= (float) $booking['amount'] && (float) $booking['amount'] > 0;
                            $collection_message = $is_fully_paid
                                ? 'Hello ' . trim((string) $booking['customer_name']) . ', thank you for completing your payment. We have received the full amount of Rs ' . number_format((float) $booking['paid_amount'], 2) . ' for booking ' . trim((string) $booking['booking_code']) . '. Your booking is confirmed successfully. We wish you a comfortable journey and hope you travel with us again soon.'
                                : 'Hello ' . trim((string) $booking['customer_name']) . ', thank you for your payment. For booking ' . trim((string) $booking['booking_code']) . ', we have received a total of Rs ' . number_format((float) $booking['paid_amount'], 2) . '. Your booking is being processed successfully.';
                            $collection_whatsapp_url = ((float) $booking['paid_amount'] > 0 && trim((string) $booking['customer_phone']) !== '')
                                ? admin_whatsapp_url($booking['customer_phone'], $collection_message)
                                : '';
                            $detail_payload = [
                                'booking_code'       => $booking['booking_code'],
                                'customer_name'      => $booking['customer_name'],
                                'customer_phone'     => $booking['customer_phone'],
                                'vehicle_name'       => $booking['vehicle_name'],
                                'registration_no'    => $booking['registration_no'],
                                'trip_dates_label'   => $booking['trip_dates_label'],
                                'trip_days'          => $booking['trip_days'],
                                'display_km'         => $booking['display_km'],
                                'estimated_km'       => (int) $booking['estimated_km'],
                                'rate_per_km_estimate' => $booking['rate_per_km_estimate'],
                                'pickup_location'    => $booking['pickup_location'],
                                'drop_location'      => $booking['drop_location'],
                                'amount'             => (float) $booking['amount'],
                                'paid_amount'        => (float) $booking['paid_amount'],
                                'balance_amount'     => (float) $booking['balance_amount'],
                                'advance_due'        => (float) $booking['advance_due'],
                                'payment_status'     => $booking['payment_status'],
                                'payment_badge'      => $booking['payment_badge'],
                                'status'             => $booking['display_status'],
                                'status_label'       => ucfirst($booking['display_status']),
                                'collection_whatsapp_url' => $collection_whatsapp_url,
                                'thank_you_message'  => $is_fully_paid
                                    ? 'Full payment of Rs ' . number_format((float) $booking['paid_amount'], 2) . ' has been received. This booking is complete and ready for a warm thank-you message to the customer.'
                                    : 'A total of Rs ' . number_format((float) $booking['paid_amount'], 2) . ' has been received for this booking so far.',
                            ];
                            ?>
                            <tr class="js-bk-row"
                                data-status="<?php echo html_escape($booking['display_status']); ?>"
                                data-search="<?php echo html_escape($booking['table_search']); ?>"
                                data-detail="<?php echo html_escape(json_encode($detail_payload)); ?>"
                                data-booking-id="<?php echo (int) $booking['id']; ?>"
                                data-booking-code="<?php echo html_escape($booking['booking_code']); ?>"
                                data-booking-customer="<?php echo html_escape($booking['customer_name']); ?>"
                                data-balance="<?php echo number_format((float) $booking['balance_amount'], 2, '.', ''); ?>"
                                data-amount="<?php echo number_format((float) $booking['amount'], 2, '.', ''); ?>"
                                data-paid="<?php echo number_format((float) $booking['paid_amount'], 2, '.', ''); ?>">

                                <td>
                                    <span class="td-id"><?php echo html_escape($booking['booking_code']); ?></span>
                                    <span class="td-sub">Created <?php echo !empty($booking['created_at']) ? date('d M Y', strtotime($booking['created_at'])) : '—'; ?></span>
                                </td>
                                <td>
                                    <span class="td-strong"><?php echo html_escape($booking['customer_name']); ?></span>
                                    <span class="td-muted"><?php echo html_escape($booking['customer_phone']); ?></span>
                                </td>
                                <td>
                                    <span class="td-strong"><?php echo html_escape($booking['vehicle_name']); ?></span>
                                    <span class="td-muted"><?php echo html_escape($booking['registration_no']); ?></span>
                                </td>
                                <td>
                                    <span class="bk-trip-badge"><?php echo html_escape($booking['trip_dates_label']); ?></span>
                                    <span class="td-muted"><?php echo html_escape($booking['pickup_location']); ?> → <?php echo html_escape($booking['drop_location']); ?></span>
                                </td>
                                <td>
                                    <span class="td-strong"><?php echo html_escape($booking['display_km']); ?></span>
                                    <span class="td-muted"><?php echo (float) $booking['rate_per_km_estimate'] > 0 ? 'Rs ' . number_format((float) $booking['rate_per_km_estimate'], 2) . '/km' : 'Est.'; ?></span>
                                </td>
                                <td>
                                    <span class="td-strong">Rs <?php echo number_format((float) $booking['amount'], 0); ?></span>
                                    <span class="td-muted">Bal Rs <?php echo number_format((float) $booking['balance_amount'], 0); ?></span>
                                </td>
                                <td>
                                    <span class="bk-pay-badge <?php echo html_escape($booking['payment_badge']); ?>"><?php echo html_escape($booking['payment_status']); ?></span>
                                    <span class="td-muted">Paid Rs <?php echo number_format((float) $booking['paid_amount'], 0); ?></span>
                                </td>
                                <td>
                                    <span class="bk-badge <?php echo html_escape($booking['display_status']); ?>"><?php echo ucfirst($booking['display_status']); ?></span>
                                </td>
                                <td>
                                    <div class="bk-actions">
                                        <button class="bk-action-btn js-bk-view" type="button">View</button>
                                        <?php if ($has_balance): ?>
                                            <button class="bk-action-btn blue js-bk-collect" type="button">Collect</button>
                                        <?php elseif (!empty($booking['payment_request_receipt'])): ?>
                                            <a class="bk-action-btn" href="<?php echo base_url($booking['payment_request_receipt']); ?>" target="_blank">Receipt</a>
                                        <?php else: ?>
                                            <button class="bk-action-btn js-bk-view" type="button">Summary</button>
                                        <?php endif; ?>
                                        <?php if ($collection_whatsapp_url !== ''): ?>
                                            <a class="bk-action-btn" href="<?php echo html_escape($collection_whatsapp_url); ?>" target="_blank" rel="noopener noreferrer">WhatsApp</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="bk-empty">
                                    <div class="bk-empty-icon">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <rect x="2" y="2" width="14" height="14" rx="3" stroke="#378ADD" stroke-width="1.5" />
                                            <path d="M6 9h6M9 6v6" stroke="#378ADD" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="bk-empty-title">No bookings yet</div>
                                    <div class="bk-empty-desc">Create a reservation to start tracking trips and payments here.</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ── Detail Modal ── -->
<div class="bk-modal-overlay" id="bkDetailModal">
    <div class="bk-modal">
        <div class="bk-modal-head">
            <div>
                <h3 id="bkDetailCode">Booking</h3>
                <p id="bkDetailSub">Trip summary and fare breakdown.</p>
            </div>
            <button class="bk-modal-close" type="button" data-close-modal="bkDetailModal">&times;</button>
        </div>
        <div class="bk-modal-body">
            <span class="bk-modal-kicker" id="bkDetailStatus">Status</span>
            <div class="bk-detail-grid">
                <div class="bk-detail-card">
                    <span>Customer</span>
                    <strong id="bkDCustomer">—</strong>
                </div>
                <div class="bk-detail-card">
                    <span>Vehicle</span>
                    <strong id="bkDVehicle">—</strong>
                </div>
                <div class="bk-detail-card">
                    <span>Trip Dates</span>
                    <strong id="bkDDates">—</strong>
                </div>
                <div class="bk-detail-card">
                    <span>Distance</span>
                    <strong id="bkDKm">—</strong>
                </div>
            </div>
            <div class="bk-fare-box">
                <div class="bk-fare-row"><span>Estimated Fare</span><strong id="bkDAmount">Rs 0</strong></div>
                <div class="bk-fare-row"><span>Advance Target</span><strong id="bkDAdvance">Rs 0</strong></div>
                <div class="bk-fare-row good"><span>Collected So Far</span><strong id="bkDPaid">Rs 0</strong></div>
                <div class="bk-fare-row total due"><span>Balance Due</span><strong id="bkDBalance">Rs 0</strong></div>
            </div>
            <div class="bk-detail-note" id="bkDetailNote">Payment summary will appear here.</div>
            <div class="bk-modal-actions">
                <button class="bk-btn-line" type="button" data-close-modal="bkDetailModal">Close</button>
                <a class="bk-btn-line" href="#" id="bkDetailWhatsappBtn" target="_blank" rel="noopener noreferrer" style="display:none;">WhatsApp</a>
                <button class="bk-btn" type="button" id="bkDetailCollectBtn">Collect Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- ── Collect Modal ── -->
<div class="bk-modal-overlay" id="bkCollectModal">
    <div class="bk-modal">
        <div class="bk-modal-head">
            <div>
                <h3>Collect Payment</h3>
                <p>Record a direct payment for the selected booking.</p>
            </div>
            <button class="bk-modal-close" type="button" data-close-modal="bkCollectModal">&times;</button>
        </div>
        <div class="bk-modal-body">
            <div class="bk-collect-summary">
                <div class="bk-fare-row"><span>Booking</span><strong id="bkCLabel">—</strong></div>
                <div class="bk-fare-row"><span>Total Amount</span><strong id="bkCTotal">Rs 0</strong></div>
                <div class="bk-fare-row good"><span>Already Paid</span><strong id="bkCPaid">Rs 0</strong></div>
                <div class="bk-fare-row total due"><span>Balance Due</span><strong id="bkCBalance">Rs 0</strong></div>
            </div>
            <div class="bk-detail-note" id="bkCNote">Save the payment and then share the thank-you message with the customer.</div>
            <form class="bk-collect-form" method="post" action="<?php echo base_url('admin/payments/store'); ?>">
                <input type="hidden" name="booking_id" id="bkCBookingId" value="">
                <input type="hidden" name="payment_type" value="payment">
                <input type="hidden" name="redirect_to" value="admin/bookings">
                <div>
                    <label>Amount to Collect</label>
                    <input type="number" step="0.01" min="0" name="amount" id="bkCAmountInput" required>
                </div>
                <div class="bk-collect-grid">
                    <div>
                        <label>Payment Mode</label>
                        <select name="payment_mode" required>
                            <option value="Cash">Cash</option>
                            <option value="UPI">UPI</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Card">Card</option>
                        </select>
                    </div>
                    <div>
                        <label>Reference No</label>
                        <input type="text" name="reference_no" placeholder="Optional reference">
                    </div>
                </div>
                <div>
                    <label>Notes</label>
                    <textarea name="notes" placeholder="Add a collection note or receipt remark…"></textarea>
                </div>
                <div class="bk-modal-actions">
                    <button class="bk-btn-line" type="button" data-close-modal="bkCollectModal">Cancel</button>
                    <button class="bk-btn" type="submit">Save Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        var rows = Array.prototype.slice.call(document.querySelectorAll('.js-bk-row'));
        var chips = Array.prototype.slice.call(document.querySelectorAll('.bk-chip'));
        var searchInput = document.getElementById('bkSearchInput');
        var refreshBtn = document.getElementById('bkRefreshBtn');
        var detailModal = document.getElementById('bkDetailModal');
        var collectModal = document.getElementById('bkCollectModal');
        var detailCollectBtn = document.getElementById('bkDetailCollectBtn');
        var detailWhatsappBtn = document.getElementById('bkDetailWhatsappBtn');
        var detailNote = document.getElementById('bkDetailNote');
        var collectNote = document.getElementById('bkCNote');
        var activeFilter = 'all';
        var currentCollect = null;

        function fmt(v) {
            var n = parseFloat(v || 0);
            return 'Rs ' + n.toFixed(2).replace(/\.00$/, '');
        }

        function esc(s) {
            return String(s || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }

        function openModal(m) {
            if (m) {
                m.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(m) {
            if (m) {
                m.classList.remove('open');
                document.body.style.overflow = '';
            }
        }

        function applyFilters() {
            var q = searchInput ? searchInput.value.toLowerCase().trim() : '';
            rows.forEach(function(row) {
                var st = row.getAttribute('data-status') || '';
                var sr = row.getAttribute('data-search') || '';
                var show = (activeFilter === 'all' || st === activeFilter) && (q === '' || sr.indexOf(q) !== -1);
                row.style.display = show ? '' : 'none';
            });
        }

        function setFilter(f) {
            activeFilter = f;
            chips.forEach(function(c) {
                c.classList.toggle('active', c.getAttribute('data-filter') === f);
            });
            applyFilters();
        }

        function parseDetail(row) {
            try {
                return JSON.parse(row.getAttribute('data-detail') || '{}');
            } catch (e) {
                return {};
            }
        }

        function fillDetail(d, row) {
            document.getElementById('bkDetailCode').textContent = d.booking_code || 'Booking';
            document.getElementById('bkDetailSub').textContent = (d.payment_status || '') + ' • ' + (d.status_label || '');
            document.getElementById('bkDetailStatus').textContent = d.status_label || 'Status';
            document.getElementById('bkDCustomer').innerHTML = esc(d.customer_name) + (d.customer_phone ? '<br><span class="td-muted">' + esc(d.customer_phone) + '</span>' : '');
            document.getElementById('bkDVehicle').innerHTML = esc(d.vehicle_name) + (d.registration_no ? '<br><span class="td-muted">' + esc(d.registration_no) + '</span>' : '');
            document.getElementById('bkDDates').innerHTML = esc(d.trip_dates_label) + '<br><span class="td-muted">' + esc((d.trip_days || 1) + ' day(s)') + '</span>';
            document.getElementById('bkDKm').innerHTML = esc(d.display_km || '—') + (d.rate_per_km_estimate > 0 ? '<br><span class="td-muted">Rs ' + d.rate_per_km_estimate + '/km</span>' : '');
            document.getElementById('bkDAmount').textContent = fmt(d.amount || 0);
            document.getElementById('bkDAdvance').textContent = fmt(d.advance_due || 0);
            document.getElementById('bkDPaid').textContent = fmt(d.paid_amount || 0);
            document.getElementById('bkDBalance').textContent = fmt(d.balance_amount || 0);
            if (detailNote) {
                detailNote.textContent = d.thank_you_message || 'Payment summary will appear here.';
            }

            currentCollect = {
                bookingId: row.getAttribute('data-booking-id') || '',
                bookingCode: row.getAttribute('data-booking-code') || '',
                customerName: row.getAttribute('data-booking-customer') || '',
                amount: row.getAttribute('data-amount') || '0',
                paid: row.getAttribute('data-paid') || '0',
                balance: row.getAttribute('data-balance') || '0',
                whatsappUrl: d.collection_whatsapp_url || '',
                nextTotal: parseFloat(d.amount || 0),
                paidSoFar: parseFloat(d.paid_amount || 0)
            };
            detailCollectBtn.style.display = parseFloat(currentCollect.balance) > 0.01 ? 'inline-flex' : 'none';
            if (detailWhatsappBtn) {
                if (currentCollect.whatsappUrl) {
                    detailWhatsappBtn.href = currentCollect.whatsappUrl;
                    detailWhatsappBtn.style.display = 'inline-flex';
                } else {
                    detailWhatsappBtn.href = '#';
                    detailWhatsappBtn.style.display = 'none';
                }
            }
        }

        function fillCollect(data) {
            if (!data) return;
            document.getElementById('bkCBookingId').value = data.bookingId || '';
            document.getElementById('bkCLabel').textContent = (data.bookingCode || '') + ' – ' + (data.customerName || '');
            document.getElementById('bkCTotal').textContent = fmt(data.amount || 0);
            document.getElementById('bkCPaid').textContent = fmt(data.paid || 0);
            document.getElementById('bkCBalance').textContent = fmt(data.balance || 0);
            document.getElementById('bkCAmountInput').value = parseFloat(data.balance || '0').toFixed(2);
            if (collectNote) {
                var nextPaid = parseFloat(data.paid || 0) + parseFloat(data.balance || 0);
                var totalAmount = parseFloat(data.amount || 0);
                collectNote.textContent = nextPaid >= totalAmount && totalAmount > 0 ?
                    'After saving this payment, the full booking amount will be collected at ' + fmt(nextPaid) + '. You can then send a complete thank-you and travel-again message to the customer on WhatsApp.' :
                    'After saving this payment, the total collected amount will become ' + fmt(nextPaid) + ' for this booking. You can then send a thank-you message to the customer on WhatsApp.';
            }
        }

        chips.forEach(function(c) {
            c.addEventListener('click', function() {
                setFilter(c.getAttribute('data-filter') || 'all');
            });
        });
        if (searchInput) searchInput.addEventListener('input', applyFilters);
        if (refreshBtn) refreshBtn.addEventListener('click', function() {
            window.location.reload();
        });

        rows.forEach(function(row) {
            row.querySelectorAll('.js-bk-view').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    fillDetail(parseDetail(row), row);
                    openModal(detailModal);
                });
            });
            row.querySelectorAll('.js-bk-collect').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    currentCollect = {
                        bookingId: row.getAttribute('data-booking-id') || '',
                        bookingCode: row.getAttribute('data-booking-code') || '',
                        customerName: row.getAttribute('data-booking-customer') || '',
                        amount: row.getAttribute('data-amount') || '0',
                        paid: row.getAttribute('data-paid') || '0',
                        balance: row.getAttribute('data-balance') || '0',
                        whatsappUrl: ''
                    };
                    fillCollect(currentCollect);
                    openModal(collectModal);
                });
            });
        });

        if (detailCollectBtn) {
            detailCollectBtn.addEventListener('click', function() {
                closeModal(detailModal);
                fillCollect(currentCollect);
                openModal(collectModal);
            });
        }

        document.querySelectorAll('[data-close-modal]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                closeModal(document.getElementById(btn.getAttribute('data-close-modal')));
            });
        });
        [detailModal, collectModal].forEach(function(m) {
            if (!m) return;
            m.addEventListener('click', function(e) {
                if (e.target === m) closeModal(m);
            });
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal(detailModal);
                closeModal(collectModal);
            }
        });

        applyFilters();
    })();
</script>