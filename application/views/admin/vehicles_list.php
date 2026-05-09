<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Mono:wght@400;500&display=swap');

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
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --shadow-xs: 0 1px 3px rgba(15, 23, 42, .06);
        --shadow-sm: 0 4px 16px rgba(15, 23, 42, .08);
        --shadow-md: 0 8px 32px rgba(15, 23, 42, .12);
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

    .vm-wrap {
        font-family: var(--font);
        color: var(--text-1);
    }

    /* ── Stats grid ── */
    .vm-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }

    .vm-stat {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 22px 24px;
        box-shadow: var(--shadow-xs);
        position: relative;
        overflow: hidden;
    }

    .vm-stat::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    }

    .vm-stat.blue::after {
        background: #2563eb;
    }

    .vm-stat.green::after {
        background: #22c55e;
    }

    .vm-stat.amber::after {
        background: #f59e0b;
    }

    .vm-stat-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .7px;
        color: var(--text-3);
        margin-bottom: 10px;
    }

    .vm-stat-value {
        font-size: 34px;
        font-weight: 600;
        color: var(--text-1);
        line-height: 1;
        margin-bottom: 6px;
        letter-spacing: -1px;
    }

    .vm-stat-desc {
        font-size: 13px;
        color: var(--text-2);
    }

    /* ── Section card ── */
    .vm-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-xs);
        overflow: hidden;
    }

    .vm-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 24px 28px;
        border-bottom: 1px solid var(--border-soft);
        flex-wrap: wrap;
    }

    .vm-card-head h3 {
        font-size: 17px;
        font-weight: 600;
        color: var(--text-1);
        margin-bottom: 3px;
    }

    .vm-card-head p {
        font-size: 13.5px;
        color: var(--text-2);
        line-height: 1.5;
    }

    /* ── Add button ── */
    .vm-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--brand);
        color: #fff;
        border: none;
        border-radius: var(--radius-md);
        font: 600 13.5px/1 var(--font);
        cursor: pointer;
        white-space: nowrap;
        transition: background .15s ease, transform .1s ease, box-shadow .15s ease;
        box-shadow: 0 2px 8px rgba(37, 99, 235, .3);
    }

    .vm-add-btn:hover {
        background: var(--brand-hover);
        box-shadow: 0 4px 14px rgba(37, 99, 235, .4);
    }

    .vm-add-btn:active {
        transform: scale(.98);
    }

    .vm-add-btn svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    /* ── Table ── */
    .vm-table-wrap {
        overflow-x: auto;
    }

    .vm-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 960px;
        font-size: 13.5px;
    }

    .vm-table thead {
        background: var(--surface-alt);
        border-bottom: 1px solid var(--border);
    }

    .vm-table th {
        padding: 13px 18px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .6px;
        text-transform: uppercase;
        color: var(--text-3);
        white-space: nowrap;
    }

    .vm-table td {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border-soft);
        color: var(--text-1);
        vertical-align: middle;
    }

    .vm-table tbody tr:last-child td {
        border-bottom: none;
    }

    .vm-table tbody tr {
        transition: background .1s ease;
    }

    .vm-table tbody tr:hover {
        background: #fafbfc;
    }

    /* ── Vehicle info cell ── */
    .vm-vehicle-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .vm-thumb {
        width: 72px;
        height: 52px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 1px solid var(--border);
        background: var(--surface-alt);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .vm-thumb img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .vm-thumb-empty {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--text-3);
        text-align: center;
        padding: 4px;
    }

    .vm-vehicle-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-1);
        margin-bottom: 2px;
    }

    .vm-vehicle-reg {
        font-size: 12px;
        color: var(--text-3);
        font-family: var(--font-mono);
    }

    .vm-row-num {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-3);
        font-family: var(--font-mono);
    }

    .vm-mono {
        font-family: var(--font-mono);
        font-size: 13px;
    }

    /* ── Badges ── */
    .vm-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        border: 1px solid transparent;
    }

    .vm-badge::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .vm-badge.available {
        background: var(--success-bg);
        border-color: var(--success-bd);
        color: var(--success-tx);
    }

    .vm-badge.available::before {
        background: #22c55e;
    }

    .vm-badge.booked {
        background: var(--danger-bg);
        border-color: var(--danger-bd);
        color: var(--danger-tx);
    }

    .vm-badge.booked::before {
        background: #ef4444;
    }

    .vm-badge.service {
        background: var(--warning-bg);
        border-color: var(--warning-bd);
        color: var(--warning-tx);
    }

    .vm-badge.service::before {
        background: #f59e0b;
    }

    /* ── Table action buttons ── */
    .vm-actions {
        display: flex;
        gap: 7px;
        flex-wrap: wrap;
    }

    .vm-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 13px;
        border-radius: var(--radius-sm);
        font: 600 12px/1 var(--font);
        border: 1.5px solid;
        cursor: pointer;
        transition: background .12s ease, transform .1s ease;
        white-space: nowrap;
        text-decoration: none;
    }

    .vm-btn svg {
        width: 12px;
        height: 12px;
        flex-shrink: 0;
    }

    .vm-btn:active {
        transform: scale(.97);
    }

    .vm-btn.edit {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1d4ed8;
    }

    .vm-btn.edit:hover {
        background: #dbeafe;
    }

    .vm-btn.view {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #334155;
    }

    .vm-btn.view:hover {
        background: #eef2f7;
    }

    .vm-btn.delete {
        background: var(--danger-bg);
        border-color: var(--danger-bd);
        color: var(--danger-tx);
    }

    .vm-btn.delete:hover {
        background: #ffe4e6;
    }

    .vm-actions form {
        display: contents;
    }

    .vm-booking-card {
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .vm-booking-hero {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 24px 24px 20px;
        border-bottom: 1px solid var(--border-soft);
        background: radial-gradient(circle at top right, rgba(37, 99, 235, .10), transparent 34%), linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
    }

    .vm-booking-kicker {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--brand);
        margin-bottom: 10px;
    }

    .vm-booking-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-1);
        margin-bottom: 4px;
        line-height: 1.15;
    }

    .vm-booking-sub {
        font-size: 13.5px;
        color: var(--text-2);
        line-height: 1.6;
    }

    .vm-booking-status {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 14px;
        border-radius: 999px;
        background: var(--brand-light);
        border: 1px solid var(--brand-mid);
        color: var(--brand-hover);
        font-size: 12px;
        font-weight: 700;
    }

    .vm-booking-status::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
    }

    .vm-booking-grid {
        display: grid;
        grid-template-columns: 1.15fr .85fr;
        gap: 18px;
        padding: 22px 24px 24px;
    }

    .vm-booking-panel {
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        background: #fff;
        padding: 18px;
    }

    .vm-panel-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--text-3);
        margin-bottom: 14px;
    }

    .vm-panel-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 18px;
    }

    .vm-panel-avatar {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        background: var(--brand-light);
        border: 1px solid var(--brand-mid);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--brand-hover);
        font-size: 18px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .vm-panel-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-1);
        margin-bottom: 3px;
    }

    .vm-panel-sub {
        font-size: 13px;
        color: var(--text-2);
    }

    .vm-detail-list {
        display: grid;
        gap: 10px;
    }

    .vm-detail-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-soft);
    }

    .vm-detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .vm-detail-key {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--text-3);
        flex-shrink: 0;
    }

    .vm-detail-val {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-1);
        text-align: right;
        line-height: 1.55;
    }

    .vm-detail-val.muted {
        color: var(--text-2);
        font-weight: 500;
    }

    .vm-detail-highlight {
        margin-top: 16px;
        padding: 14px 16px;
        border-radius: var(--radius-md);
        background: linear-gradient(135deg, #eff6ff 0%, #f8fbff 100%);
        border: 1px solid var(--brand-mid);
        color: var(--brand-hover);
        font-size: 13px;
        line-height: 1.6;
    }

    /* ── Empty ── */
    .vm-empty {
        padding: 56px 24px;
        text-align: center;
        color: var(--text-3);
    }

    .vm-empty svg {
        width: 40px;
        height: 40px;
        margin: 0 auto 14px;
        display: block;
        opacity: .4;
    }

    .vm-empty strong {
        display: block;
        font-size: 15px;
        color: var(--text-2);
        margin-bottom: 4px;
    }

    .vm-empty p {
        font-size: 13.5px;
    }

    /* ══════════════════════════════════
       MODAL
    ══════════════════════════════════ */
    .vm-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .45);
        display: none;
        align-items: flex-start;
        justify-content: center;
        padding: 40px 20px 40px;
        z-index: 9999;
        overflow-y: auto;
    }

    .vm-modal-overlay.open {
        display: flex;
    }

    .vm-modal {
        width: 100%;
        max-width: 860px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-modal);
        padding: 32px;
        margin: auto;
        position: relative;
    }

    .vm-modal-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-soft);
    }

    .vm-modal-head h3 {
        font-size: 20px;
        font-weight: 600;
        color: var(--text-1);
        margin-bottom: 4px;
    }

    .vm-modal-head p {
        font-size: 13.5px;
        color: var(--text-2);
        line-height: 1.5;
    }

    .vm-modal-close {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
        background: var(--surface-alt);
        color: var(--text-2);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background .12s ease, color .12s ease;
    }

    .vm-modal-close:hover {
        background: var(--border-soft);
        color: var(--text-1);
    }

    .vm-modal-close svg {
        width: 16px;
        height: 16px;
    }

    /* Form grid */
    .vm-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 20px;
    }

    .vm-form-grid .full {
        grid-column: 1 / -1;
    }

    .vm-fg {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .vm-fg label {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: var(--text-2);
    }

    .vm-fg input,
    .vm-fg select {
        padding: 10px 13px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border);
        background: var(--surface-alt);
        color: var(--text-1);
        font: 400 14px var(--font);
        transition: border-color .15s ease, background .15s ease, box-shadow .15s ease;
        appearance: none;
    }

    .vm-fg input:focus,
    .vm-fg select:focus {
        outline: none;
        border-color: var(--brand);
        background: var(--surface);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .vm-fg .hint {
        font-size: 12px;
        color: var(--text-3);
        line-height: 1.5;
    }

    /* Upload */
    .vm-upload-box {
        border: 2px dashed var(--border);
        background: var(--surface-alt);
        border-radius: var(--radius-lg);
        padding: 28px 20px;
        text-align: center;
        cursor: pointer;
        position: relative;
        transition: border-color .15s ease, background .15s ease;
    }

    .vm-upload-box:hover,
    .vm-upload-box.drag-over {
        border-color: var(--brand);
        background: var(--brand-light);
    }

    .vm-upload-box input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
        z-index: 2;
        border: none;
        background: transparent;
    }

    .vm-upload-box input[type="file"]::file-selector-button {
        display: none;
    }

    .vm-upload-content {
        pointer-events: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .vm-upload-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        border: 1px solid var(--brand-mid);
        background: var(--brand-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--brand);
        margin-bottom: 4px;
    }

    .vm-upload-icon svg {
        width: 22px;
        height: 22px;
    }

    .vm-upload-title {
        font-size: 14.5px;
        font-weight: 600;
        color: var(--text-1);
    }

    .vm-upload-sub {
        font-size: 12.5px;
        color: var(--text-3);
    }

    .vm-preview {
        margin-top: 14px;
        height: 200px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border);
        background: var(--surface-alt);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .vm-preview img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: none;
    }

    .vm-preview.has-image img {
        display: block;
    }

    .vm-preview-empty {
        font-size: 13px;
        color: var(--text-3);
        text-align: center;
        padding: 20px;
        line-height: 1.6;
    }

    .vm-preview.has-image .vm-preview-empty {
        display: none;
    }

    /* Modal footer */
    .vm-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 20px;
        border-top: 1px solid var(--border-soft);
        margin-top: 24px;
    }

    .vm-mbtn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 22px;
        border-radius: var(--radius-md);
        font: 600 13.5px/1 var(--font);
        cursor: pointer;
        transition: background .12s ease, transform .1s ease, box-shadow .12s ease;
        border: 1.5px solid transparent;
        white-space: nowrap;
    }

    .vm-mbtn:active {
        transform: scale(.98);
    }

    .vm-mbtn.cancel {
        background: var(--surface);
        border-color: var(--border);
        color: var(--text-2);
    }

    .vm-mbtn.cancel:hover {
        background: var(--surface-alt);
    }

    .vm-mbtn.save {
        background: var(--brand);
        color: #fff;
        box-shadow: 0 2px 8px rgba(37, 99, 235, .3);
    }

    .vm-mbtn.save:hover {
        background: var(--brand-hover);
        box-shadow: 0 4px 14px rgba(37, 99, 235, .4);
    }

    /* ── Pagination ── */
    .vm-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        border-top: 1px solid var(--border-soft);
        gap: 12px;
        flex-wrap: wrap;
    }

    .vm-page-info {
        font-size: 13px;
        color: var(--text-2);
    }

    .vm-page-info strong {
        color: var(--text-1);
        font-weight: 600;
    }

    .vm-page-btns {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .vm-pg-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 8px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--text-2);
        font: 600 13px/1 var(--font);
        cursor: pointer;
        transition: background .12s ease, border-color .12s ease, color .12s ease;
        white-space: nowrap;
    }

    .vm-pg-btn:hover:not(:disabled):not(.active) {
        background: var(--brand-light);
        border-color: var(--brand-mid);
        color: var(--brand);
    }

    .vm-pg-btn.active {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
        cursor: default;
    }

    .vm-pg-btn:disabled {
        opacity: .38;
        cursor: not-allowed;
    }

    .vm-pg-btn svg {
        width: 14px;
        height: 14px;
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .vm-stats {
            grid-template-columns: 1fr 1fr;
        }

        .vm-stats .vm-stat:last-child {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 680px) {
        .vm-stats {
            grid-template-columns: 1fr;
        }

        .vm-stats .vm-stat:last-child {
            grid-column: auto;
        }

        .vm-card-head {
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .vm-add-btn {
            width: 100%;
            justify-content: center;
        }

        .vm-form-grid {
            grid-template-columns: 1fr;
        }

        .vm-form-grid .full {
            grid-column: 1;
        }

        .vm-booking-hero,
        .vm-detail-row {
            flex-direction: column;
        }

        .vm-booking-grid {
            grid-template-columns: 1fr;
        }

        .vm-detail-val {
            text-align: left;
        }

        .vm-modal {
            padding: 20px;
        }

        .vm-modal-head {
            flex-direction: column;
            gap: 10px;
        }

        .vm-modal-footer {
            flex-direction: column-reverse;
        }

        .vm-mbtn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .vm-modal-overlay {
            padding: 16px;
        }

        .vm-stat-value {
            font-size: 28px;
        }
    }
</style>

<div class="vm-wrap">

    <!-- Stats -->
    <?php
    $total_vehicles    = count($vehicles);
    $available_count   = 0;
    $booked_count      = 0;
    $service_count     = 0;
    foreach ($vehicles as $v) {
        if ($v['status'] === 'available') $available_count++;
        elseif ($v['status'] === 'booked') $booked_count++;
        elseif ($v['status'] === 'service') $service_count++;
    }
    ?>
    <div class="vm-stats">
        <div class="vm-stat blue">
            <div class="vm-stat-label">Total Fleet</div>
            <div class="vm-stat-value"><?php echo $total_vehicles; ?></div>
            <div class="vm-stat-desc">All vehicles in your system</div>
        </div>
        <div class="vm-stat green">
            <div class="vm-stat-label">Available</div>
            <div class="vm-stat-value"><?php echo $available_count; ?></div>
            <div class="vm-stat-desc">Ready for new bookings</div>
        </div>
        <div class="vm-stat amber">
            <div class="vm-stat-label">Booked / Service</div>
            <div class="vm-stat-value"><?php echo $booked_count + $service_count; ?></div>
            <div class="vm-stat-desc">Assigned or under maintenance</div>
        </div>
    </div>

    <!-- Table card -->
    <div class="vm-card">
        <div class="vm-card-head">
            <div>
                <h3>Vehicles</h3>
                <p>Add, edit or remove vehicles. Update pricing, images, and availability instantly.</p>
            </div>
            <button class="vm-add-btn" type="button" id="openVehicleModal">
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                Add Vehicle
            </button>
        </div>

        <div class="vm-table-wrap">
            <table class="vm-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle</th>
                        <th>Registration</th>
                        <th>Type</th>
                        <th>Fuel</th>
                        <th>Seats</th>

                        <th>Advance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($vehicles)): ?>
                        <?php foreach ($vehicles as $index => $vehicle): ?>
                            <?php $vehicle_image = isset($vehicle['image']) ? $vehicle['image'] : ''; ?>
                            <?php $active_booking = !empty($vehicle['active_booking']) ? $vehicle['active_booking'] : array(); ?>
                            <?php
                            $booking_detail = array(
                                'vehicle_name' => isset($vehicle['name']) ? $vehicle['name'] : '',
                                'registration_no' => isset($vehicle['registration_no']) ? $vehicle['registration_no'] : '',
                                'vehicle_type' => isset($vehicle['vehicle_type']) ? $vehicle['vehicle_type'] : '',
                                'fuel_type' => isset($vehicle['fuel_type']) ? $vehicle['fuel_type'] : '',
                                'seats' => isset($vehicle['seats']) ? (int) $vehicle['seats'] : 0,
                                'rate_per_day' => isset($vehicle['rate_per_day']) ? (float) $vehicle['rate_per_day'] : 0,
                                'price_6_hours' => isset($vehicle['price_6_hours']) ? (float) $vehicle['price_6_hours'] : 0,
                                'price_12_hours' => isset($vehicle['price_12_hours']) ? (float) $vehicle['price_12_hours'] : 0,
                                'price_24_hours' => isset($vehicle['price_24_hours']) ? (float) $vehicle['price_24_hours'] : 0,
                                'extra_hour_charge' => isset($vehicle['extra_hour_charge']) ? (float) $vehicle['extra_hour_charge'] : 0,
                                'advance_amount' => isset($vehicle['advance_amount']) ? (float) $vehicle['advance_amount'] : 0,
                                'vehicle_status' => isset($vehicle['status']) ? $vehicle['status'] : '',
                                'booking_code' => !empty($active_booking['booking_code']) ? $active_booking['booking_code'] : '',
                                'booking_status' => !empty($active_booking['effective_status']) ? $active_booking['effective_status'] : (!empty($active_booking['status']) ? $active_booking['status'] : ''),
                                'customer_name' => !empty($active_booking['customer_name']) ? $active_booking['customer_name'] : '',
                                'customer_phone' => !empty($active_booking['customer_phone']) ? $active_booking['customer_phone'] : '',
                                'trip_label' => !empty($active_booking['trip_label']) ? $active_booking['trip_label'] : '',
                                'trip_route' => !empty($active_booking['trip_route']) ? $active_booking['trip_route'] : '',
                                'pickup_date' => !empty($active_booking['pickup_date']) ? date('d M Y', strtotime($active_booking['pickup_date'])) : '',
                                'return_date' => !empty($active_booking['return_date']) ? date('d M Y', strtotime($active_booking['return_date'])) : '',

                                'amount' => !empty($active_booking['amount']) ? (float) $active_booking['amount'] : 0,
                                'paid_amount' => !empty($active_booking['paid_amount']) ? (float) $active_booking['paid_amount'] : 0,
                                'balance_amount' => !empty($active_booking['balance_amount']) ? (float) $active_booking['balance_amount'] : 0,
                                'payment_status' => !empty($active_booking['payment_status']) ? $active_booking['payment_status'] : '',
                                'booking_created_at' => !empty($active_booking['created_at']) ? date('d M Y, h:i A', strtotime($active_booking['created_at'])) : '',
                            );
                            ?>
                            <tr data-row="1">
                                <td><span class="vm-row-num"><?php echo (int)$index + 1; ?></span></td>
                                <td>
                                    <div class="vm-vehicle-info">
                                        <div class="vm-thumb">
                                            <?php if ($vehicle_image !== ''): ?>
                                                <img src="<?php echo app_vehicle_image_url($vehicle_image); ?>" alt="<?php echo html_escape($vehicle['name']); ?>">
                                            <?php else: ?>
                                                <span class="vm-thumb-empty">No Image</span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="vm-vehicle-name"><?php echo html_escape($vehicle['name']); ?></div>
                                            <div class="vm-vehicle-reg"><?php echo html_escape($vehicle['registration_no']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="vm-mono"><?php echo html_escape($vehicle['registration_no']); ?></td>
                                <td><?php echo html_escape($vehicle['vehicle_type']); ?></td>
                                <td><?php echo html_escape($vehicle['fuel_type']); ?></td>
                                <td><?php echo (int)$vehicle['seats']; ?></td>

                                <td class="vm-mono">₹<?php echo number_format((float)$vehicle['advance_amount'], 0); ?></td>
                                <td>
                                    <span class="vm-badge <?php echo html_escape($vehicle['status']); ?>">
                                        <?php echo ucfirst(html_escape($vehicle['status'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="vm-actions">
                                        <?php if ($vehicle['status'] === 'booked'): ?>
                                            <button class="vm-btn view js-open-booking-view" type="button"
                                                data-detail="<?php echo html_escape(json_encode($booking_detail)); ?>">
                                                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.5 8s2.4-4 6.5-4 6.5 4 6.5 4-2.4 4-6.5 4-6.5-4-6.5-4Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" />
                                                    <circle cx="8" cy="8" r="2.2" stroke="currentColor" stroke-width="1.4" />
                                                </svg>
                                                View
                                            </button>
                                        <?php endif; ?>
                                        <button class="vm-btn edit edit-vehicle-btn" type="button"
                                            data-id="<?php echo (int)$vehicle['id']; ?>"
                                            data-name="<?php echo html_escape($vehicle['name']); ?>"
                                            data-registration="<?php echo html_escape($vehicle['registration_no']); ?>"
                                            data-type="<?php echo html_escape($vehicle['vehicle_type']); ?>"
                                            data-fuel="<?php echo html_escape($vehicle['fuel_type']); ?>"
                                            data-seats="<?php echo (int)$vehicle['seats']; ?>"
                                            data-rate-km="<?php echo isset($vehicle['rate_per_day']) ? (float)$vehicle['rate_per_day'] : 0; ?>"
                                            data-price-6-hours="<?php echo isset($vehicle['price_6_hours']) ? (float)$vehicle['price_6_hours'] : 0; ?>"
                                            data-price-12-hours="<?php echo isset($vehicle['price_12_hours']) ? (float)$vehicle['price_12_hours'] : 0; ?>"
                                            data-price-24-hours="<?php echo isset($vehicle['price_24_hours']) ? (float)$vehicle['price_24_hours'] : 0; ?>"
                                            data-extra-hour-charge="<?php echo isset($vehicle['extra_hour_charge']) ? (float)$vehicle['extra_hour_charge'] : 0; ?>"
                                            data-advance="<?php echo (float)$vehicle['advance_amount']; ?>"
                                            data-status="<?php echo html_escape($vehicle['status']); ?>"
                                            data-image="<?php echo html_escape($vehicle_image); ?>">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.5 2.5a1.414 1.414 0 0 1 2 2L5 13 2 14l1-3 8.5-8.5Z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            Edit
                                        </button>
                                        <form method="post" action="<?php echo base_url('admin/vehicles/delete/' . (int)$vehicle['id']); ?>" class="js-swal-confirm-form" data-swal-title="Delete vehicle?" data-swal-text="This vehicle will be removed permanently." data-swal-confirm="Delete">
                                            <button class="vm-btn delete" type="submit">
                                                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2 4h12M5 4V2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5V4M6 7v5M10 7v5M3 4l.8 9a1 1 0 0 0 1 .9h6.4a1 1 0 0 0 1-.9L13 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">
                                <div class="vm-empty">
                                    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="2" y="12" width="36" height="22" rx="5" stroke="currentColor" stroke-width="2" />
                                        <path d="M8 12V9a4 4 0 0 1 4-4h16a4 4 0 0 1 4 4v3" stroke="currentColor" stroke-width="2" />
                                        <circle cx="12" cy="29" r="3" stroke="currentColor" stroke-width="2" />
                                        <circle cx="28" cy="29" r="3" stroke="currentColor" stroke-width="2" />
                                    </svg>
                                    <strong>No vehicles yet</strong>
                                    <p>Click "Add Vehicle" to add your first vehicle to the fleet.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="vm-pagination" id="vmPagination">
            <div class="vm-page-info" id="vmPageInfo"></div>
            <div class="vm-page-btns" id="vmPageBtns"></div>
        </div>
    </div>
</div>

<!-- ══ MODAL ══ -->
<div class="vm-modal-overlay" id="vehicleBookingViewModal">
    <div class="vm-modal">
        <div class="vm-modal-head">
            <div>
                <h3>Vehicle Booking Details</h3>
                <p>See the current booking and customer information for this vehicle in one clean summary card.</p>
            </div>
            <button class="vm-modal-close" type="button" id="closeVehicleBookingViewModal" aria-label="Close">
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 3l10 10M13 3 3 13" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
                </svg>
            </button>
        </div>
        <div class="vm-booking-card">
            <div class="vm-booking-hero">
                <div>
                    <div class="vm-booking-kicker">Current Assignment</div>
                    <div class="vm-booking-title" id="vmBookingViewTitle">Vehicle Name</div>
                    <div class="vm-booking-sub" id="vmBookingViewSubtitle">Registration and category details will appear here.</div>
                </div>
                <div class="vm-booking-status" id="vmBookingViewStatus">Available</div>
            </div>
            <div class="vm-booking-grid">
                <div class="vm-booking-panel">
                    <div class="vm-panel-label">Customer</div>
                    <div class="vm-panel-head">
                        <div class="vm-panel-avatar" id="vmBookingCustomerAvatar">C</div>
                        <div>
                            <div class="vm-panel-title" id="vmBookingCustomerName">No customer assigned</div>
                            <div class="vm-panel-sub" id="vmBookingCustomerPhone">Vehicle is currently not linked to any active booking.</div>
                        </div>
                    </div>
                    <div class="vm-detail-list">
                        <div class="vm-detail-row">
                            <div class="vm-detail-key">Booking ID</div>
                            <div class="vm-detail-val" id="vmBookingCode">-</div>
                        </div>
                        <div class="vm-detail-row">
                            <div class="vm-detail-key">Status</div>
                            <div class="vm-detail-val" id="vmBookingStatusText">-</div>
                        </div>
                        <div class="vm-detail-row">
                            <div class="vm-detail-key">Payment</div>
                            <div class="vm-detail-val" id="vmBookingPaymentStatus">-</div>
                        </div>
                        <div class="vm-detail-row">
                            <div class="vm-detail-key">Created</div>
                            <div class="vm-detail-val muted" id="vmBookingCreatedAt">-</div>
                        </div>
                    </div>
                </div>
                <div class="vm-booking-panel">
                    <div class="vm-panel-label">Trip Summary</div>
                    <div class="vm-detail-list">
                        <div class="vm-detail-row">
                            <div class="vm-detail-key">Dates</div>
                            <div class="vm-detail-val" id="vmBookingTripDates">-</div>
                        </div>
                        <div class="vm-detail-row">
                            <div class="vm-detail-key">Route</div>
                            <div class="vm-detail-val" id="vmBookingRoute">-</div>
                        </div>

                        <div class="vm-detail-row">
                            <div class="vm-detail-key">Estimated Fare</div>
                            <div class="vm-detail-val" id="vmBookingAmount">-</div>
                        </div>
                        <div class="vm-detail-row">
                            <div class="vm-detail-key">Paid / Balance</div>
                            <div class="vm-detail-val" id="vmBookingBalance">-</div>
                        </div>
                    </div>
                    <div class="vm-detail-highlight" id="vmVehicleMeta">
                        Category, fuel, seating, and advance amount will appear here.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="vm-modal-overlay" id="vehicleModal">
    <div class="vm-modal">
        <div class="vm-modal-head">
            <div>
                <h3 id="vehicleModalTitle">Add New Vehicle</h3>
                <p id="vehicleModalCopy">Fill in all details, set pricing and advance, then upload a vehicle photo.</p>
            </div>
            <button class="vm-modal-close" type="button" id="closeVehicleModal" aria-label="Close">
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 3l10 10M13 3 3 13" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <form method="post" action="<?php echo base_url('admin/vehicles/store'); ?>" enctype="multipart/form-data" id="vehicleForm">
            <div class="vm-form-grid">

                <div class="vm-fg">
                    <label>Vehicle Name</label>
                    <input type="text" name="name" id="vehicle_name" placeholder="e.g. Maruti Swift Dzire" required>
                </div>

                <div class="vm-fg">
                    <label>Registration No.</label>
                    <input type="text" name="registration_no" id="registration_no" placeholder="GJ01-XX-1234" required>
                </div>

                <div class="vm-fg">
                    <label>Vehicle Category</label>
                    <input type="text" name="vehicle_type" id="vehicle_type" placeholder="Sedan / SUV / Hatchback" required>
                </div>

                <div class="vm-fg">
                    <label>Fuel Type</label>
                    <input type="text" name="fuel_type" id="fuel_type" placeholder="Petrol / Diesel / CNG" required>
                </div>

                <div class="vm-fg">
                    <label>Seating Capacity</label>
                    <input type="number" name="seats" id="seats" placeholder="5" min="1" required>
                </div>

                <div class="vm-fg">
                    <label>Rate Per KM (₹)</label>
                    <input type="number" step="0.01" min="0" name="rate_per_km" id="rate_per_km" placeholder="18.00" required>
                </div>

                <div class="vm-fg">
                    <label>6 Hours Price (₹)</label>
                    <input type="number" step="0.01" min="0" name="price_6_hours" id="price_6_hours" placeholder="1800.00" required>
                </div>

                <div class="vm-fg">
                    <label>12 Hours Price (₹)</label>
                    <input type="number" step="0.01" min="0" name="price_12_hours" id="price_12_hours" placeholder="3200.00" required>
                </div>

                <div class="vm-fg">
                    <label>24 Hours Price (₹)</label>
                    <input type="number" step="0.01" min="0" name="price_24_hours" id="price_24_hours" placeholder="5000.00" required>
                </div>

                <div class="vm-fg">
                    <label>Extra Charge Per Hour (₹)</label>
                    <input type="number" step="0.01" min="0" name="extra_hour_charge" id="extra_hour_charge" placeholder="300.00" required>
                    <span class="hint">Extra charge for every additional hour beyond 6, 12, or 24 hour package.</span>
                </div>

                <div class="vm-fg">
                    <label>Required Advance (₹)</label>
                    <input type="number" step="0.01" name="advance_amount" id="advance_amount" placeholder="1000" required>
                </div>

                <div class="vm-fg">
                    <label>Status</label>
                    <select name="status" id="status">
                        <option value="available">Available</option>
                        <option value="booked">Booked</option>
                        <option value="service">Service</option>
                    </select>
                    <span class="hint">Set to "Service" when under maintenance.</span>
                </div>

                <div class="vm-fg full">
                    <label>Vehicle Image</label>
                    <div class="vm-upload-box" id="uploadBox">
                        <input type="file" name="vehicle_image" id="vehicle_image" accept=".jpg,.jpeg,.png,.webp">
                        <div class="vm-upload-content">
                            <div class="vm-upload-icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span class="vm-upload-title" id="uploadTitle">Click to upload vehicle photo</span>
                            <span class="vm-upload-sub" id="uploadSub">JPG, PNG or WEBP &middot; Max 4 MB</span>
                        </div>
                    </div>
                    <div class="vm-preview" id="vehiclePreviewWrap">
                        <div class="vm-preview-empty" id="vehiclePreviewEmpty">No image selected yet</div>
                        <img src="" alt="Vehicle preview" id="vehiclePreview">
                    </div>
                </div>

            </div><!-- /.vm-form-grid -->

            <div class="vm-modal-footer">
                <button class="vm-mbtn cancel" type="button" id="cancelVehicleModal">Cancel</button>
                <button class="vm-mbtn save" type="submit" id="vehicleSubmitBtn">Add Vehicle</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function() {
        var modal = document.getElementById('vehicleModal');
        var bookingViewModal = document.getElementById('vehicleBookingViewModal');
        var form = document.getElementById('vehicleForm');
        var title = document.getElementById('vehicleModalTitle');
        var copy = document.getElementById('vehicleModalCopy');
        var submitBtn = document.getElementById('vehicleSubmitBtn');
        var imageInput = document.getElementById('vehicle_image');
        var preview = document.getElementById('vehiclePreview');
        var previewWrap = document.getElementById('vehiclePreviewWrap');
        var previewEmpty = document.getElementById('vehiclePreviewEmpty');
        var uploadBox = document.getElementById('uploadBox');
        var uploadTitle = document.getElementById('uploadTitle');
        var uploadSub = document.getElementById('uploadSub');
        var baseStore = '<?php echo base_url('admin/vehicles/store'); ?>';
        var baseUpdate = '<?php echo base_url('admin/vehicles/update/'); ?>';

        /* ── Pagination ── */
        var PER_PAGE = 10;
        var currentPage = 1;
        var allRows = [];

        function initPagination() {
            allRows = Array.prototype.slice.call(
                document.querySelectorAll('.vm-table tbody tr[data-row]')
            );
            renderPage(1);
        }

        function renderPage(page) {
            currentPage = page;
            var total = allRows.length;
            var totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
            if (currentPage > totalPages) currentPage = totalPages;

            var start = (currentPage - 1) * PER_PAGE;
            var end = start + PER_PAGE;

            allRows.forEach(function(row, i) {
                row.style.display = (i >= start && i < end) ? '' : 'none';
            });

            // Page info
            var infoEl = document.getElementById('vmPageInfo');
            if (infoEl) {
                if (total === 0) {
                    infoEl.innerHTML = 'No vehicles';
                } else {
                    infoEl.innerHTML =
                        'Showing <strong>' + (start + 1) + '–' + Math.min(end, total) +
                        '</strong> of <strong>' + total + '</strong> vehicles';
                }
            }

            buildButtons(totalPages);
        }

        function buildButtons(totalPages) {
            var container = document.getElementById('vmPageBtns');
            if (!container) return;
            container.innerHTML = '';

            // Prev
            var prev = makeBtn(null, currentPage === 1, false, 'prev');
            prev.innerHTML = '<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 3L6 8l4 5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            prev.setAttribute('aria-label', 'Previous page');
            container.appendChild(prev);

            // Page numbers
            getPageNumbers(currentPage, totalPages).forEach(function(p) {
                if (p === '…') {
                    var dots = document.createElement('span');
                    dots.textContent = '…';
                    dots.style.cssText = 'padding:0 4px;color:var(--text-3);font-size:13px;line-height:34px;';
                    container.appendChild(dots);
                } else {
                    var btn = makeBtn(p, false, p === currentPage, 'number');
                    btn.textContent = p;
                    btn.setAttribute('aria-label', 'Page ' + p);
                    container.appendChild(btn);
                }
            });

            // Next
            var next = makeBtn(null, currentPage === totalPages, false, 'next');
            next.innerHTML = '<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 3l4 5-4 5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            next.setAttribute('aria-label', 'Next page');
            container.appendChild(next);
        }

        function makeBtn(label, disabled, active, type) {
            var btn = document.createElement('button');
            btn.className = 'vm-pg-btn' + (active ? ' active' : '');
            btn.type = 'button';
            btn.disabled = !!disabled;
            btn.addEventListener('click', function() {
                if (type === 'prev') renderPage(currentPage - 1);
                else if (type === 'next') renderPage(currentPage + 1);
                else if (type === 'number' && !active) renderPage(label);
            });
            return btn;
        }

        function getPageNumbers(cur, total) {
            if (total <= 7) {
                var arr = [];
                for (var i = 1; i <= total; i++) arr.push(i);
                return arr;
            }
            if (cur <= 3) return [1, 2, 3, '…', total];
            if (cur >= total - 2) return [1, '…', total - 2, total - 1, total];
            return [1, '…', cur - 1, cur, cur + 1, '…', total];
        }
        /* ── End Pagination ── */

        function fmtMoney(value) {
            var num = parseFloat(value || 0);
            return 'Rs ' + num.toLocaleString('en-IN', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });
        }

        function getInitials(name) {
            var parts = String(name || '').trim().split(/\s+/).filter(Boolean);
            if (!parts.length) return 'C';
            if (parts.length === 1) return parts[0].slice(0, 1).toUpperCase();
            return (parts[0].slice(0, 1) + parts[1].slice(0, 1)).toUpperCase();
        }

        function setPreview(src) {
            if (src) {
                preview.src = src;
                previewWrap.classList.add('has-image');
            } else {
                preview.removeAttribute('src');
                previewWrap.classList.remove('has-image');
            }
        }

        function setUpload(label, sub) {
            uploadTitle.textContent = label || 'Click to upload vehicle photo';
            uploadSub.textContent = sub || 'JPG, PNG or WEBP \u00b7 Max 4 MB';
        }

        function openModal() {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
            modal.scrollTop = 0;
        }

        function openBookingViewModal() {
            bookingViewModal.classList.add('open');
            document.body.style.overflow = 'hidden';
            bookingViewModal.scrollTop = 0;
        }

        function closeModal() {
            modal.classList.remove('open');
            document.body.style.overflow = '';
            form.reset();
            form.action = baseStore;
            title.textContent = 'Add New Vehicle';
            copy.textContent = 'Fill in all details, set pricing and advance, then upload a vehicle photo.';
            submitBtn.textContent = 'Add Vehicle';
            setPreview('');
            setUpload('', '');
        }

        function closeBookingViewModal() {
            bookingViewModal.classList.remove('open');
            document.body.style.overflow = '';
        }

        function setVal(id, val) {
            var el = document.getElementById(id);
            if (el) el.value = val || '';
        }

        document.getElementById('openVehicleModal').addEventListener('click', function() {
            closeModal();
            openModal();
        });

        document.getElementById('closeVehicleModal').addEventListener('click', closeModal);
        document.getElementById('cancelVehicleModal').addEventListener('click', closeModal);
        document.getElementById('closeVehicleBookingViewModal').addEventListener('click', closeBookingViewModal);

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
        bookingViewModal.addEventListener('click', function(e) {
            if (e.target === bookingViewModal) closeBookingViewModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
            if (e.key === 'Escape' && bookingViewModal.classList.contains('open')) closeBookingViewModal();
        });

        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                var file = e.target.files && e.target.files[0];
                if (!file) {
                    setPreview('');
                    setUpload('', '');
                    return;
                }
                setUpload(file.name, 'Image selected — click to replace');
                setPreview(URL.createObjectURL(file));
            });
        }

        if (uploadBox) {
            uploadBox.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadBox.classList.add('drag-over');
            });
            uploadBox.addEventListener('dragleave', function() {
                uploadBox.classList.remove('drag-over');
            });
            uploadBox.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadBox.classList.remove('drag-over');
                if (e.dataTransfer.files.length) {
                    imageInput.files = e.dataTransfer.files;
                    imageInput.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                }
            });
        }

        document.querySelectorAll('.edit-vehicle-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                form.action = baseUpdate + btn.dataset.id;
                title.textContent = 'Edit Vehicle';
                copy.textContent = 'Update vehicle details, rates, status, or upload a new image.';
                submitBtn.textContent = 'Save Changes';
                setVal('vehicle_name', btn.dataset.name);
                setVal('registration_no', btn.dataset.registration);
                setVal('vehicle_type', btn.dataset.type);
                setVal('fuel_type', btn.dataset.fuel);
                setVal('seats', btn.dataset.seats);
                setVal('rate_per_km', btn.getAttribute('data-rate-km'));
                setVal('price_6_hours', btn.getAttribute('data-price-6-hours'));
                setVal('price_12_hours', btn.getAttribute('data-price-12-hours'));
                setVal('price_24_hours', btn.getAttribute('data-price-24-hours'));
                setVal('extra_hour_charge', btn.getAttribute('data-extra-hour-charge'));
                setVal('advance_amount', btn.dataset.advance);
                setVal('status', btn.dataset.status);
                var img = btn.dataset.image;
                if (img) {
                    var fileName = img.split('/').pop();
                    setUpload(fileName, 'Current image loaded — choose another to replace');
                    setPreview('<?php echo base_url(); ?>' + img);
                } else {
                    setUpload('', '');
                    setPreview('');
                }
                openModal();
            });
        });

        document.querySelectorAll('.js-open-booking-view').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var detail = {};
                try {
                    detail = JSON.parse(btn.getAttribute('data-detail') || '{}');
                } catch (e) {
                    detail = {};
                }

                var statusText = String(detail.booking_status || detail.vehicle_status || 'available')
                    .replace(/\b\w/g, function(ch) {
                        return ch.toUpperCase();
                    });
                var customerName = detail.customer_name || 'No customer assigned';
                var customerPhone = detail.customer_phone || 'Vehicle is currently not linked to any active booking.';

                document.getElementById('vmBookingViewTitle').textContent = detail.vehicle_name || 'Vehicle Details';
                document.getElementById('vmBookingViewSubtitle').textContent = [detail.registration_no, detail.vehicle_type, detail.fuel_type].filter(Boolean).join(' • ') || 'Vehicle information';
                document.getElementById('vmBookingViewStatus').textContent = statusText;
                document.getElementById('vmBookingCustomerAvatar').textContent = getInitials(customerName);
                document.getElementById('vmBookingCustomerName').textContent = customerName;
                document.getElementById('vmBookingCustomerPhone').textContent = customerPhone;
                document.getElementById('vmBookingCode').textContent = detail.booking_code || 'No active booking';
                document.getElementById('vmBookingStatusText').textContent = statusText;
                document.getElementById('vmBookingPaymentStatus').textContent = detail.payment_status || 'No payment activity';
                document.getElementById('vmBookingCreatedAt').textContent = detail.booking_created_at || '-';
                document.getElementById('vmBookingTripDates').textContent = detail.trip_label || '-';
                document.getElementById('vmBookingRoute').textContent = detail.trip_route || '-';
                document.getElementById('vmBookingAmount').textContent = detail.amount ? fmtMoney(detail.amount) : '-';
                document.getElementById('vmBookingBalance').textContent = (detail.paid_amount || detail.balance_amount) ?
                    (fmtMoney(detail.paid_amount || 0) + ' paid • ' + fmtMoney(detail.balance_amount || 0) + ' balance') :
                    'No payment recorded';
                document.getElementById('vmVehicleMeta').textContent =
                    'Seats: ' + (detail.seats || '-') +
                    ' • 6H: ' + fmtMoney(detail.price_6_hours || 0) +
                    ' • 12H: ' + fmtMoney(detail.price_12_hours || 0) +
                    ' • 24H: ' + fmtMoney(detail.price_24_hours || 0) +
                    ' • Extra/Hr: ' + fmtMoney(detail.extra_hour_charge || 0) +
                    ' • Advance: ' + fmtMoney(detail.advance_amount || 0) +
                    ' • Pickup: ' + (detail.pickup_date || '-') +
                    ' • Return: ' + (detail.return_date || '-');

                openBookingViewModal();
            });
        });

        // Init pagination last
        initPagination();
    })();
</script>
