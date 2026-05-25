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

    .bk-actions form {
        display: contents;
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

    /* ── Pagination ── */
    .bk-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        border-top: 0.5px solid var(--bk-border);
        background: var(--bk-card-soft);
        gap: 10px;
        flex-wrap: wrap;
    }

    .bk-page-info {
        font-size: 11px;
        color: var(--bk-muted);
    }

    .bk-page-info strong {
        color: var(--bk-text);
        font-weight: 600;
    }

    .bk-page-btns {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }

    .bk-pg-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        padding: 0 6px;
        border-radius: var(--r-md);
        border: 0.5px solid var(--bk-border-med);
        background: var(--bk-card);
        color: var(--bk-muted);
        font: 600 11px/1 var(--font);
        cursor: pointer;
        transition: background 0.12s, border-color 0.12s, color 0.12s;
        white-space: nowrap;
        font-family: var(--font);
    }

    .bk-pg-btn:hover:not(:disabled):not(.active) {
        background: var(--bk-primary-soft);
        border-color: var(--bk-primary-mid);
        color: var(--bk-primary-deep);
    }

    .bk-pg-btn.active {
        background: var(--bk-primary);
        border-color: var(--bk-primary);
        color: #fff;
        cursor: default;
    }

    .bk-pg-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    .bk-pg-btn svg {
        width: 12px;
        height: 12px;
    }

    .bk-pg-dots {
        font-size: 11px;
        color: var(--bk-hint);
        padding: 0 2px;
        line-height: 28px;
    }

    /* ── Icon action buttons ── */
    .bk-icon-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        justify-content: center;
        position: relative;
        font-size: 14px;
        border-radius: var(--r-md);
    }

    .bk-icon-btn i {
        font-size: 14px;
        line-height: 1;
    }

    .bk-icon-btn.danger {
        background: #FCEBEB;
        border-color: #F7C1C1;
        color: var(--bk-danger);
    }

    .bk-icon-btn.danger:hover {
        background: #F7C1C1;
    }

    /* Photo count pip */
    .bk-photo-pip {
        position: absolute;
        top: -5px;
        right: -5px;
        min-width: 15px;
        height: 15px;
        padding: 0 3px;
        background: var(--bk-primary-deep);
        color: #fff;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        border: 1.5px solid var(--bk-card);
    }

    /* Tooltip on hover */
    .bk-icon-btn[title] {
        overflow: visible;
    }

    .bk-icon-btn::after {
        content: attr(title);
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%);
        background: #1e293b;
        color: #fff;
        font-size: 10px;
        font-weight: 500;
        padding: 3px 7px;
        border-radius: 5px;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.15s;
        z-index: 100;
        font-family: var(--font);
    }

    .bk-icon-btn::before {
        content: '';
        position: absolute;
        bottom: calc(100% + 2px);
        left: 50%;
        transform: translateX(-50%);
        border: 4px solid transparent;
        border-top-color: #1e293b;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.15s;
        z-index: 100;
    }

    .bk-icon-btn:hover::after,
    .bk-icon-btn:hover::before {
        opacity: 1;
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
                        <th>Duration</th>
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
                            $collection_message = app_booking_confirmation_whatsapp_message($booking);
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
    'pickup_date'        => !empty($booking['pickup_date']) ? $booking['pickup_date'] : '',  // ADD THIS
    'return_date'        => !empty($booking['return_date']) ? $booking['return_date'] : '',  // ADD THIS
    'pickup_location'    => $booking['pickup_location'],
    'drop_location'      => $booking['drop_location'],
    'estimated_km'       => !empty($booking['estimated_km']) ? (int) $booking['estimated_km'] : 0,
    'amount' => (float) $booking['amount'],
    'fuel_expense' => !empty($booking['fuel_expense']) ? (float) $booking['fuel_expense'] : 0,
    'toll_expense' => !empty($booking['toll_expense']) ? (float) $booking['toll_expense'] : 0,
    'driver_expense' => !empty($booking['driver_expense']) ? (float) $booking['driver_expense'] : 0,
    'parking_expense' => !empty($booking['parking_expense']) ? (float) $booking['parking_expense'] : 0,
    'total_expenses' => !empty($booking['total_expenses']) ? (float) $booking['total_expenses'] : 0,
    'net_amount' => !empty($booking['net_amount']) ? (float) $booking['net_amount'] : 0,
    'other_expenses' => !empty($booking['other_expenses']) ? (float) $booking['other_expenses'] : 0,
    'paid_amount' => (float) $booking['paid_amount'],
    'balance_amount' => (float) $booking['balance_amount'],
    
    'advance_due'        => (float) $booking['advance_due'],
    'payment_status'     => $booking['payment_status'],
    'pickup_time'  => !empty($booking['pickup_time'])  ? $booking['pickup_time']  : '',
    'return_time'  => !empty($booking['return_time'])  ? $booking['return_time']  : '',
    'booking_type' => !empty($booking['booking_type']) ? $booking['booking_type'] : 'km',
    'hours_slot'   => !empty($booking['hours_slot'])   ? (int)$booking['hours_slot'] : 0,
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
                                    <?php
                                    $btype = !empty($booking['booking_type']) ? $booking['booking_type'] : 'km';
                                    $hslot = !empty($booking['hours_slot'])   ? (int)$booking['hours_slot'] : 0;
                                    $pt    = !empty($booking['pickup_time'])  ? $booking['pickup_time']  : '';
                                    $rt    = !empty($booking['return_time'])  ? $booking['return_time']  : '';
                                    ?>
                                    <?php if ($btype === 'hours' && $hslot > 0): ?>
                                        <span class="td-strong">⏱ <?php echo $hslot; ?> Hours</span>
                                        <?php if ($pt && $rt): ?>
                                            <span class="td-muted"><?php echo date('h:i A', strtotime($pt)); ?> – <?php echo date('h:i A', strtotime($rt)); ?></span>
                                        <?php else: ?>
                                            <span class="td-muted">Hours-based</span>
                                        <?php endif; ?>
                                        <span class="td-muted js-late-badge"
                                            data-slot="<?php echo $hslot; ?>"
                                            data-rdate="<?php echo html_escape($booking['return_date']); ?>"
                                            data-rtime="<?php echo html_escape($rt); ?>">
                                        </span>
                                    <?php else: ?>
                                        <span class="td-strong">🚗 <?php echo !empty($booking['estimated_km']) ? (int) $booking['estimated_km'] . ' km' : 'KM Booking'; ?></span>
                                        <span class="td-muted">KM-based booking</span>
                                    <?php endif; ?>
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
    <!-- View -->
    <button class="bk-action-btn bk-icon-btn js-bk-view" type="button" title="View Details">
        <i class="ti ti-eye"></i>
    </button>

    <!-- Edit -->
    <a class="bk-action-btn bk-icon-btn" href="<?php echo base_url('admin/booking/edit/' . (int) $booking['id']); ?>" title="Edit Booking">
        <i class="ti ti-edit"></i>
    </a>

    <!-- Photos -->
    <a class="bk-action-btn bk-icon-btn blue" href="<?php echo base_url('admin/bookings/photos/' . (int) $booking['id']); ?>" title="Car Photos">
        <i class="ti ti-camera"></i>
        <?php if (!empty($booking['booking_photo_count'])): ?>
            <span class="bk-photo-pip"><?php echo (int)$booking['booking_photo_count']; ?></span>
        <?php endif; ?>
    </a>

    <!-- Collect / Summary -->
    <?php if ($has_balance): ?>
        <button class="bk-action-btn bk-icon-btn blue js-bk-collect" type="button" title="Collect Payment">
            <i class="ti ti-coin-rupee"></i>
        </button>
    <?php else: ?>
        <button class="bk-action-btn bk-icon-btn js-bk-view" type="button" title="View Summary">
            <i class="ti ti-file-description"></i>
        </button>
    <?php endif; ?>

    <!-- WhatsApp -->
    <?php if ($collection_whatsapp_url !== ''): ?>
        <a class="bk-action-btn bk-icon-btn" href="<?php echo html_escape($collection_whatsapp_url); ?>" target="_blank" rel="noopener noreferrer" title="Send WhatsApp">
            <i class="ti ti-brand-whatsapp"></i>
        </a>
    <?php endif; ?>

    <!-- Delete -->
    <form method="post" action="<?php echo base_url('admin/bookings/delete/' . (int)$booking['id']); ?>" class="js-swal-confirm-form" data-swal-title="Delete booking?" data-swal-text="This booking and its payment records will be permanently removed." data-swal-confirm="Delete">
        <button class="bk-action-btn bk-icon-btn danger" type="submit" title="Delete Booking">
            <i class="ti ti-trash"></i>
        </button>
    </form>
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

        <!-- Pagination -->
        <div class="bk-pagination" id="bkPagination">
            <div class="bk-page-info" id="bkPageInfo"></div>
            <div class="bk-page-btns" id="bkPageBtns"></div>
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
                    <span>Duration</span>
                    <strong id="bkDKm">—</strong>
                </div>
            </div>
           <div class="bk-fare-box">
    <div class="bk-fare-row"><span>Base Fare</span><strong id="bkDAmount">Rs 0</strong></div>
    
    <div id="bkDExpensesSection" style="display:none;">
        <div class="bk-fare-row" id="bkDFuelRow" style="display:none;"><span>⛽ Fuel Expense</span><strong id="bkDFuel">Rs 0</strong></div>
        <div class="bk-fare-row" id="bkDTollRow" style="display:none;"><span>🛣️ Toll Expense</span><strong id="bkDToll">Rs 0</strong></div>
        <div class="bk-fare-row" id="bkDDriverRow" style="display:none;"><span>👤 Driver Expense</span><strong id="bkDDriver">Rs 0</strong></div>
        <div class="bk-fare-row" id="bkDParkingRow" style="display:none;"><span>🅿️ Parking Expense</span><strong id="bkDParking">Rs 0</strong></div>
        <div class="bk-fare-row" style="border-top:0.5px solid var(--bk-border);padding-top:6px;margin-top:4px;"><span>Total Expenses</span><strong id="bkDTotalExpenses">Rs 0</strong></div>
    </div>
    
    <div class="bk-fare-row" id="bkDOtherExpensesRow" style="display:none;"><span>Other Expenses</span><strong id="bkDOtherExpenses">Rs 0</strong></div>
    
    <div class="bk-fare-row total" id="bkDTotalRow" style="border-top:1px solid var(--bk-border);padding-top:8px;margin-top:4px;">
        <span>Net Amount (After Expenses)</span><strong id="bkDTotal">Rs 0</strong>
    </div>
    </div>
            <div class="bk-detail-note" id="bkDetailNote">Payment summary will appear here.</div>
           <div class="bk-modal-actions">

    <button class="bk-btn-light" type="button" data-close-modal="bkDetailModal">
        Close
    </button>

    <a class="bk-btn-light"
       href="#"
       id="bkDetailWhatsappBtn"
       target="_blank"
       rel="noopener noreferrer"
       style="display:none;">

        <svg class="bk-action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
        </svg>

        WhatsApp
    </a>

    <button class="bk-btn-warning"
            type="button"
            id="bkDetailReminderBtn"
            style="display:none;">

        <svg class="bk-action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>

        Payment Reminder
    </button>

    <button class="bk-btn-primary"
            type="button"
            id="bkDetailCollectBtn">

        Collect Payment
    </button>

</div>
<style>
    .bk-modal-actions{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
    flex-wrap:wrap;
}

/* Common Button Style */
.bk-btn-light,
.bk-btn-warning,
.bk-btn-primary{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    height:42px;
    padding:0 18px;

    border-radius:10px;
    border:none;

    font-size:14px;
    font-weight:600;

    cursor:pointer;
    text-decoration:none;

    transition:all .2s ease;
}

/* Close + Whatsapp */
.bk-btn-light{
    background:#f8fafc;
    color:#334155;
    border:1px solid #e2e8f0;
}

.bk-btn-light:hover{
    background:#eef2ff;
    color:#2563eb;
}

/* Reminder */
.bk-btn-warning{
    background:#eff6ff;
    color:#2563eb;
}

.bk-btn-warning:hover{
    background:#2563eb;
    color:#fff;
}

/* Main Button */
.bk-btn-primary{
    background:#2563eb;
    color:#fff;
}

.bk-btn-primary:hover{
    background:#1d4ed8;
}

/* Icon */
.bk-action-icon{
    width:16px;
    height:16px;
    flex-shrink:0;
}
</style>
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
                <div>
    <label>Other Expenses (Optional)</label>
    <input type="number" step="0.01" min="0" name="other_expenses" id="bkCOtherExpenses" placeholder="Toll, parking, fuel surcharge, etc.">
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
        var detailReminderBtn = document.getElementById('bkDetailReminderBtn');
        var detailNote = document.getElementById('bkDetailNote');
        var collectNote = document.getElementById('bkCNote');
        var activeFilter = 'all';
        var currentCollect = null;

        /* ── Pagination state ── */
        var PER_PAGE = 10;
        var currentPage = 1;
        var visibleRows = [];

        /* ── Pagination render ── */
        function renderPage(page) {
            currentPage = page;
            var total = visibleRows.length;
            var totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            var start = (currentPage - 1) * PER_PAGE;
            var end = start + PER_PAGE;

            /* Show/hide rows */
            rows.forEach(function(row) {
                row.style.display = 'none';
            });
            visibleRows.forEach(function(row, i) {
                row.style.display = (i >= start && i < end) ? '' : 'none';
            });

            /* Page info */
            var infoEl = document.getElementById('bkPageInfo');
            if (infoEl) {
                if (total === 0) {
                    infoEl.innerHTML = 'No bookings found';
                } else {
                    infoEl.innerHTML = 'Showing <strong>' + (start + 1) + '–' + Math.min(end, total) + '</strong> of <strong>' + total + '</strong> bookings';
                }
            }

            buildPageButtons(totalPages);
        }

        function buildPageButtons(totalPages) {
            var container = document.getElementById('bkPageBtns');
            if (!container) return;
            container.innerHTML = '';
            if (totalPages <= 1) return;

            /* Prev arrow */
            var prev = makePgBtn(null, currentPage === 1, false, 'prev');
            prev.innerHTML = '<svg viewBox="0 0 12 12" fill="none"><path d="M7.5 2L4 6l3.5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            prev.setAttribute('aria-label', 'Previous');
            container.appendChild(prev);

            /* Page numbers with smart ellipsis */
            getPageNumbers(currentPage, totalPages).forEach(function(p) {
                if (p === '…') {
                    var dots = document.createElement('span');
                    dots.className = 'bk-pg-dots';
                    dots.textContent = '…';
                    container.appendChild(dots);
                } else {
                    var btn = makePgBtn(p, false, p === currentPage, 'number');
                    btn.textContent = p;
                    btn.setAttribute('aria-label', 'Page ' + p);
                    container.appendChild(btn);
                }
            });

            /* Next arrow */
            var next = makePgBtn(null, currentPage === totalPages, false, 'next');
            next.innerHTML = '<svg viewBox="0 0 12 12" fill="none"><path d="M4.5 2L8 6l-3.5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            next.setAttribute('aria-label', 'Next');
            container.appendChild(next);
        }

        function makePgBtn(label, disabled, active, type) {
            var btn = document.createElement('button');
            btn.className = 'bk-pg-btn' + (active ? ' active' : '');
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
            if (total <= 5) {
                var arr = [];
                for (var i = 1; i <= total; i++) arr.push(i);
                return arr;
            }
            if (cur <= 3) return [1, 2, 3, '…', total];
            if (cur >= total - 2) return [1, '…', total - 2, total - 1, total];
            return [1, '…', cur - 1, cur, cur + 1, '…', total];
        }

        function applyFilters() {
            var q = searchInput ? searchInput.value.toLowerCase().trim() : '';

            visibleRows = [];
            rows.forEach(function(row) {
                var st = row.getAttribute('data-status') || '';
                var sr = row.getAttribute('data-search') || '';
                var match = (activeFilter === 'all' || st === activeFilter) && (q === '' || sr.indexOf(q) !== -1);
                if (match) visibleRows.push(row);
                else row.style.display = 'none';
            });

            currentPage = 1;
            renderPage(1);
        }

        function setFilter(f) {
            activeFilter = f;
            chips.forEach(function(c) {
                c.classList.toggle('active', c.getAttribute('data-filter') === f);
            });
            applyFilters();
        }

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

        function formatTime12(t) {
            if (!t) return '';
            var parts = t.split(':');
            var h = parseInt(parts[0], 10);
            var m = parts[1] || '00';
            var ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12 || 12;
            return h + ':' + m + ' ' + ampm;
        }

        function computeLateBadges() {
            var now = Date.now();
            document.querySelectorAll('.js-late-badge').forEach(function(el) {
                var slot = parseInt(el.getAttribute('data-slot') || '0', 10);
                var rdate = el.getAttribute('data-rdate') || '';
                var rtime = el.getAttribute('data-rtime') || '';
                if (!rdate || !rtime || slot <= 0) return;
                var returnMs = new Date(rdate + 'T' + rtime + ':00').getTime();
                if (isNaN(returnMs)) return;
                var diffHours = (now - returnMs) / (1000 * 60 * 60);
                if (diffHours <= 0) {
                    el.innerHTML = '<span style="display:inline-block;margin-top:3px;padding:1px 6px;border-radius:999px;font-size:10px;font-weight:700;background:#e1f5ee;color:#0F6E56;"><i class="ti ti-clock-check" style="font-size:10px;vertical-align:-1px;margin-right:2px;"></i>' + Math.ceil(-diffHours) + 'h remaining</span>';
                } else {
                    el.innerHTML = '<span style="display:inline-block;margin-top:3px;padding:1px 6px;border-radius:999px;font-size:10px;font-weight:700;background:#FCEBEB;color:#A32D2D;"><i class="ti ti-alert-triangle" style="font-size:10px;vertical-align:-1px;margin-right:2px;"></i>' + Math.ceil(diffHours) + 'h late</span>';
                }
            });
        }
        computeLateBadges();

        function parseDetail(row) {
            try {
                return JSON.parse(row.getAttribute('data-detail') || '{}');
            } catch (e) {
                return {};
            }
        }

function generatePaymentReminderMessage(data) {
    var customerName = data.customer_name || 'Customer';
    var bookingCode = data.booking_code || '';
    var vehicleName = data.vehicle_name || 'Vehicle';
    var registrationNo = data.registration_no || '';
    var pickupLocation = data.pickup_location || 'N/A';
    var dropLocation = data.drop_location || 'N/A';
    
    // Format dates
    var pickupDate = data.pickup_date || '';
    var returnDate = data.return_date || '';
    
    var pickupDateFormatted = '';
    if (pickupDate) {
        var pd = new Date(pickupDate);
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        pickupDateFormatted = pd.getDate() + ' ' + months[pd.getMonth()] + ' ' + pd.getFullYear();
    }
    
    var returnDateFormatted = '';
    if (returnDate) {
        var rd = new Date(returnDate);
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        returnDateFormatted = rd.getDate() + ' ' + months[rd.getMonth()] + ' ' + rd.getFullYear();
    }
    
    // Format times
    var pickupTime = data.pickup_time ? formatTime12(data.pickup_time) : 'N/A';
    var returnTime = data.return_time ? formatTime12(data.return_time) : 'N/A';
    
    // Build booking type info
    var bookingType = data.booking_type || 'km';
    var durationInfo = '';
    
    if (bookingType === 'hours') {
        var hoursSlot = parseInt(data.hours_slot || 0, 10);
        durationInfo = hoursSlot + ' Hours';
    } else {
        var estimatedKm = parseInt(data.estimated_km || 0, 10);
        durationInfo = estimatedKm > 0 ? estimatedKm + ' KM' : 'As per usage';
    }
    
    // Calculate amounts
    var baseAmount = parseFloat(data.amount || 0);
    var fuelExpense = parseFloat(data.fuel_expense || 0);
    var tollExpense = parseFloat(data.toll_expense || 0);
    var driverExpense = parseFloat(data.driver_expense || 0);
    var parkingExpense = parseFloat(data.parking_expense || 0);
    var totalExpenses = fuelExpense + tollExpense + driverExpense + parkingExpense;
    var otherExpenses = parseFloat(data.other_expenses || 0);
    var netAmount = baseAmount - totalExpenses;
    var totalAmount = netAmount + otherExpenses;
    var balanceAmount = totalAmount - parseFloat(data.paid_amount || 0);
    var paidAmount = parseFloat(data.paid_amount || 0);
    
    var message = '🚗 *PAYMENT REMINDER*\n\n';
    message += 'Dear *' + customerName + '*,\n\n';
    message += 'This is a friendly reminder for your upcoming booking.\n\n';
    
    message += '━━━━━━━━━━━━━━━━━\n';
    message += '📋 *BOOKING DETAILS*\n';
    message += '━━━━━━━━━━━━━━━━━\n\n';
    
    message += '🆔 Booking ID: *' + bookingCode + '*\n';
    message += '🚙 Vehicle: *' + vehicleName + '*\n';
    if (registrationNo) {
        message += '🔢 Registration: *' + registrationNo + '*\n';
    }
    
    message += '\n━━━━━━━━━━━━━━━━━\n';
    message += '📅 *TRIP SCHEDULE*\n';
    message += '━━━━━━━━━━━━━━━━━\n\n';
    
    message += '📍 *PICKUP*\n';
    message += '   📅 Date: ' + (pickupDateFormatted || 'N/A') + '\n';
    message += '   🕐 Time: ' + pickupTime + '\n';
    message += '   📌 Location: ' + pickupLocation + '\n\n';
    
    message += '📍 *DROP-OFF*\n';
    message += '   📅 Date: ' + (returnDateFormatted || 'N/A') + '\n';
    message += '   🕐 Time: ' + returnTime + '\n';
    message += '   📌 Location: ' + dropLocation + '\n\n';
    
    message += '⏱️ *Duration:* ' + durationInfo + '\n';
    
    message += '\n━━━━━━━━━━━━━━━━━\n';
    message += '💰 *PAYMENT DETAILS*\n';
    message += '━━━━━━━━━━━━━━━━━\n\n';
    
    message += '💵 Base Amount: ₹' + baseAmount.toFixed(2) + '\n';
    
    if (totalExpenses > 0) {
        message += '\n*Expenses:*\n';
        if (fuelExpense > 0) {
            message += '  ⛽ Fuel: ₹' + fuelExpense.toFixed(2) + '\n';
        }
        if (tollExpense > 0) {
            message += '  🛣️ Toll: ₹' + tollExpense.toFixed(2) + '\n';
        }
        if (driverExpense > 0) {
            message += '  👤 Driver: ₹' + driverExpense.toFixed(2) + '\n';
        }
        if (parkingExpense > 0) {
            message += '  🅿️ Parking: ₹' + parkingExpense.toFixed(2) + '\n';
        }
        message += '  ────────────────\n';
        message += '  Total Expenses: ₹' + totalExpenses.toFixed(2) + '\n\n';
    }
    
    message += '💵 Total Amount: ₹' + totalAmount.toFixed(2) + '\n';
    
    if (paidAmount > 0) {
        message += '✅ Amount Paid: ₹' + paidAmount.toFixed(2) + '\n';
        message += '⚠️ *Balance Due: ₹' + balanceAmount.toFixed(2) + '*\n';
    } else {
        message += '⚠️ *Amount Due: ₹' + balanceAmount.toFixed(2) + '*\n';
    }
    
    message += '\n━━━━━━━━━━━━━━━━━\n\n';
    message += '⏰ *Please complete your payment before the pickup time to confirm your booking.*\n\n';
    message += 'For payment details or assistance, feel free to contact us.\n\n';
    message += 'Thank you for choosing our service! 🙏\n';
    message += '━━━━━━━━━━━━━━━━━';
    
    return message;
}      
 function fillDetail(d, row) {
    // Safety function to set text safely
    function setText(elementId, value) {
        var el = document.getElementById(elementId);
        if (el) el.textContent = value;
    }
    
    function setHTML(elementId, value) {
        var el = document.getElementById(elementId);
        if (el) el.innerHTML = value;
    }
    
    function setDisplay(elementId, display) {
        var el = document.getElementById(elementId);
        if (el) el.style.display = display;
    }

    setText('bkDetailCode', d.booking_code || 'Booking');
    setText('bkDetailSub', (d.payment_status || '') + ' • ' + (d.status_label || ''));
    setText('bkDetailStatus', d.status_label || 'Status');
    setHTML('bkDCustomer', esc(d.customer_name) + (d.customer_phone ? '<br><span class="td-muted">' + esc(d.customer_phone) + '</span>' : ''));
    setHTML('bkDVehicle', esc(d.vehicle_name) + (d.registration_no ? '<br><span class="td-muted">' + esc(d.registration_no) + '</span>' : ''));
    setHTML('bkDDates', esc(d.trip_dates_label) + '<br><span class="td-muted">' + esc((d.trip_days || 1) + ' day(s)') + '</span>');
    
    var btype = d.booking_type || 'km';
    var hslot = parseInt(d.hours_slot || 0, 10);
    var ptFmt = d.pickup_time ? formatTime12(d.pickup_time) : '';
    var rtFmt = d.return_time ? formatTime12(d.return_time) : '';
    
    if (btype === 'hours' && hslot > 0) {
        setHTML('bkDKm', '⏱ ' + hslot + '-hour package<br><span class="td-muted">' + (ptFmt && rtFmt ? ptFmt + ' – ' + rtFmt : 'Times not set') + '</span>');
    } else {
        var kmValue = parseInt(d.estimated_km || 0, 10);
        setHTML('bkDKm', kmValue > 0 ?
            ('🚗 ' + kmValue + ' km<br><span class="td-muted">KM-based booking</span>') :
            'KM Booking<br><span class="td-muted">Distance not available</span>');
    }
    
    // Calculate amounts with all expenses
    var baseAmount = parseFloat(d.amount || 0);
    var fuelExpense = parseFloat(d.fuel_expense || 0);
    var tollExpense = parseFloat(d.toll_expense || 0);
    var driverExpense = parseFloat(d.driver_expense || 0);
    var parkingExpense = parseFloat(d.parking_expense || 0);
    var totalExpenses = fuelExpense + tollExpense + driverExpense + parkingExpense;
    var otherExpenses = parseFloat(d.other_expenses || 0);
    var netAmount = baseAmount - totalExpenses;
    var totalAmount = netAmount + otherExpenses;
    var paidAmount = parseFloat(d.paid_amount || 0);
    var balanceAmount = totalAmount - paidAmount;

    setText('bkDAmount', fmt(baseAmount));

    // Show expense breakdown if any expenses
    if (totalExpenses > 0) {
        setDisplay('bkDExpensesSection', '');
        
        if (fuelExpense > 0) {
            setText('bkDFuel', fmt(fuelExpense));
            setDisplay('bkDFuelRow', '');
        } else {
            setDisplay('bkDFuelRow', 'none');
        }
        
        if (tollExpense > 0) {
            setText('bkDToll', fmt(tollExpense));
            setDisplay('bkDTollRow', '');
        } else {
            setDisplay('bkDTollRow', 'none');
        }
        
        if (driverExpense > 0) {
            setText('bkDDriver', fmt(driverExpense));
            setDisplay('bkDDriverRow', '');
        } else {
            setDisplay('bkDDriverRow', 'none');
        }
        
        if (parkingExpense > 0) {
            setText('bkDParking', fmt(parkingExpense));
            setDisplay('bkDParkingRow', '');
        } else {
            setDisplay('bkDParkingRow', 'none');
        }
        
        setText('bkDTotalExpenses', fmt(totalExpenses));
    } else {
        setDisplay('bkDExpensesSection', 'none');
    }

    if (otherExpenses > 0) {
        setText('bkDOtherExpenses', fmt(otherExpenses));
        setDisplay('bkDOtherExpensesRow', '');
    } else {
        setDisplay('bkDOtherExpensesRow', 'none');
    }

    setText('bkDTotal', fmt(totalAmount));
    
    // These might not exist, so check
    var paidEl = document.getElementById('bkDPaid');
    if (paidEl) paidEl.textContent = fmt(paidAmount);
    
    var balanceEl = document.getElementById('bkDBalance');
    if (balanceEl) balanceEl.textContent = fmt(balanceAmount);
    
    var noteEl = document.getElementById('bkDetailNote');
    if (noteEl) {
        var isFullyPaid = paidAmount >= totalAmount && totalAmount > 0;
        noteEl.textContent = isFullyPaid
            ? 'Full payment of Rs ' + paidAmount.toFixed(2) + ' has been received. This booking is complete and ready for a warm thank-you message to the customer.'
            : 'A total of Rs ' + paidAmount.toFixed(2) + ' has been received for this booking so far.';
    }

    currentCollect = {
        bookingId: row.getAttribute('data-booking-id') || '',
        bookingCode: row.getAttribute('data-booking-code') || '',
        customerName: row.getAttribute('data-booking-customer') || '',
        customerPhone: d.customer_phone || '',
        amount: totalAmount.toFixed(2),
        paid: paidAmount.toFixed(2),
        balance: balanceAmount.toFixed(2),
        whatsappUrl: d.collection_whatsapp_url || '',
        fullData: d
    };
    
    var hasBalance = balanceAmount > 0.01;
    setDisplay('bkDetailCollectBtn', hasBalance ? 'inline-flex' : 'none');
    
    if (detailReminderBtn && currentCollect.customerPhone && hasBalance) {
        detailReminderBtn.style.display = 'inline-flex';
    } else if (detailReminderBtn) {
        detailReminderBtn.style.display = 'none';
    }
    
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

        /* ── Event listeners ── */
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

        // Payment Reminder Button Handler
        if (detailReminderBtn) {
            detailReminderBtn.addEventListener('click', function() {
                if (!currentCollect || !currentCollect.customerPhone) {
                    alert('Customer phone number is not available.');
                    return;
                }
                
                var reminderMessage = generatePaymentReminderMessage(currentCollect.fullData);
                var phone = currentCollect.customerPhone.replace(/\D/g, '');
                
                if (phone.length === 10) {
                    phone = '91' + phone;
                }
                
                var whatsappUrl = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(reminderMessage);
                window.open(whatsappUrl, '_blank');
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

        /* ── Init ── */
        applyFilters();
    })();
</script>
