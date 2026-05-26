<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap');

    :root {
        --brand: #2563eb;
        --brand-light: #eff6ff;
        --brand-mid: #dbeafe;
        --surface: #ffffff;
        --surface-alt: #f8fafc;
        --border: #e2e8f0;
        --border-soft: #f1f5f9;
        --text-primary: #0f172a;
        --text-secondary: #475569;
        --text-muted: #94a3b8;
        --success-bg: #f0fdf4;
        --success-border: #bbf7d0;
        --success-text: #15803d;
        --danger-bg: #fff1f2;
        --danger-border: #fecdd3;
        --danger-text: #be123c;
        --warning-bg: #fffbeb;
        --warning-border: #fde68a;
        --warning-text: #b45309;
        --info-bg: #eff6ff;
        --info-border: #bfdbfe;
        --info-text: #1d4ed8;
        --danger-border: #fecdd3;
        --danger-text: #be123c;
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --shadow-xs: 0 1px 3px rgba(15, 23, 42, .06), 0 1px 2px rgba(15, 23, 42, .04);
        --shadow-sm: 0 4px 12px rgba(15, 23, 42, .07), 0 1px 3px rgba(15, 23, 42, .04);
        --shadow-md: 0 8px 24px rgba(15, 23, 42, .09), 0 2px 6px rgba(15, 23, 42, .05);
        --font: 'DM Sans', system-ui, sans-serif;
        --font-mono: 'DM Mono', monospace;
    }

    * {
        box-sizing: border-box;
    }

    .dr-wrap {
        font-family: var(--font);
        color: var(--text-primary);
    }

    /* ── Page header ── */
    .dr-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 0 0 24px;
        border-bottom: 1px solid var(--border-soft);
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .dr-header-title {
        font-size: 22px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 4px;
        letter-spacing: -0.3px;
    }

    .dr-header-sub {
        font-size: 14px;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.5;
        max-width: 520px;
    }

    .dr-search {
        width: min(340px, 100%);
        min-height: 42px;
        padding: 0 14px;
        border-radius: 12px;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-primary);
        font: 500 13px/1.2 var(--font);
        outline: none;
        transition: border-color .18s ease, box-shadow .18s ease;
    }

    .dr-search:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .dr-summary-pills {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .dr-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 12.5px;
        font-weight: 600;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-secondary);
        white-space: nowrap;
    }

    .dr-pill-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dr-pill.pending .dr-pill-dot {
        background: #f59e0b;
    }

    .dr-pill.approved .dr-pill-dot {
        background: #22c55e;
    }

    .dr-pill.rejected .dr-pill-dot {
        background: #ef4444;
    }

    /* ── Groups ── */
    .dr-groups {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .dr-group {
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        background: var(--surface);
        overflow: hidden;
        box-shadow: var(--shadow-xs);
        transition: box-shadow .2s ease;
    }

    .dr-group[open] {
        box-shadow: var(--shadow-md);
    }

    .dr-group summary {
        list-style: none;
        cursor: pointer;
        padding: 18px 20px;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
    }

    .dr-group summary::-webkit-details-marker {
        display: none;
    }

    .dr-group summary:hover {
        background: var(--surface-alt);
    }

    /* ── Group header row ── */
    .dr-group-head {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 12px;
        align-items: center;
    }

    .dr-group-left {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .dr-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--brand-light);
        border: 2px solid var(--brand-mid);
        color: var(--brand);
        font-size: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-family: var(--font);
    }

    .dr-customer-info {
        min-width: 0;
    }

    .dr-customer-name {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dr-customer-meta {
        font-size: 12.5px;
        color: var(--text-muted);
        font-family: var(--font-mono);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dr-group-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .dr-kpi-cluster {
        display: flex;
        gap: 8px;
    }

    .dr-kpi {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 8px 14px;
        border-radius: var(--radius-md);
        background: var(--surface-alt);
        border: 1px solid var(--border-soft);
        text-align: center;
        min-width: 64px;
    }

    .dr-kpi-label {
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: var(--text-muted);
        font-weight: 600;
        margin-bottom: 2px;
    }

    .dr-kpi-value {
        font-size: 17px;
        font-weight: 600;
        color: var(--text-primary);
        line-height: 1;
    }

    .dr-kpi-value.has-pending {
        color: #d97706;
    }

    .dr-toggle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1.5px solid var(--brand-mid);
        background: var(--brand-light);
        color: var(--brand);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
    }

    .dr-toggle svg {
        width: 14px;
        height: 14px;
        transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
    }

    .dr-group[open] .dr-toggle svg {
        transform: rotate(45deg);
    }

    /* ── Group body ── */
    .dr-group-body {
        padding: 0 20px 20px;
        border-top: 1px solid var(--border-soft);
    }

    /* ── Cards grid ── */
    .dr-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 12px;
        padding-top: 16px;
    }

    .dr-card {
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px;
        background: var(--surface);
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: box-shadow .15s ease, border-color .15s ease;
    }

    .dr-card:hover {
        box-shadow: var(--shadow-sm);
        border-color: #cbd5e1;
    }

    /* Status accent bar */
    .dr-card[data-status="pending"] {
        border-left: 3px solid #f59e0b;
    }

    .dr-card[data-status="approved"] {
        border-left: 3px solid #22c55e;
    }

    .dr-card[data-status="rejected"] {
        border-left: 3px solid #ef4444;
    }

    .dr-card[data-status="missing"] {
        border-left: 3px solid #94a3b8;
    }

    .dr-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .dr-doc-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        background: var(--surface-alt);
        border: 1px solid var(--border-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--text-muted);
    }

    .dr-doc-icon svg {
        width: 16px;
        height: 16px;
    }

    .dr-card-title {
        flex: 1;
        min-width: 0;
    }

    .dr-card-title strong {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .dr-card-title .booking-label {
        display: block;
        font-size: 12px;
        color: var(--text-secondary);
        margin-bottom: 2px;
    }

    .dr-card-title .timestamp {
        display: block;
        font-size: 11.5px;
        color: var(--text-muted);
        font-family: var(--font-mono);
    }

    /* ── Badges ── */
    .dr-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .dr-badge::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dr-badge.badge-pending {
        background: var(--warning-bg);
        border: 1px solid var(--warning-border);
        color: var(--warning-text);
    }

    .dr-badge.badge-pending::before {
        background: #f59e0b;
    }

    .dr-badge.badge-approved {
        background: var(--success-bg);
        border: 1px solid var(--success-border);
        color: var(--success-text);
    }

    .dr-badge.badge-approved::before {
        background: #22c55e;
    }

    .dr-badge.badge-rejected {
        background: var(--danger-bg);
        border: 1px solid var(--danger-border);
        color: var(--danger-text);
    }

    .dr-badge.badge-rejected::before {
        background: #ef4444;
    }

    .dr-badge.badge-missing {
        background: #f8fafc;
        border: 1px solid var(--border);
        color: var(--text-muted);
    }

    .dr-badge.badge-missing::before {
        background: #94a3b8;
    }

    /* ── Card actions ── */
    .dr-card-actions {
        display: flex;
        gap: 7px;
        flex-wrap: wrap;
    }

    .dr-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 34px;
        padding: 6px 14px;
        border-radius: var(--radius-sm);
        font-size: 12.5px;
        font-weight: 600;
        font-family: var(--font);
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--text-primary);
        cursor: pointer;
        text-decoration: none;
        transition: background .12s ease, border-color .12s ease, transform .1s ease;
        white-space: nowrap;
        -webkit-tap-highlight-color: transparent;
    }

    .dr-btn:hover {
        background: var(--surface-alt);
        border-color: #cbd5e1;
    }

    .dr-btn:active {
        transform: scale(0.97);
    }

    .dr-btn svg {
        width: 13px;
        height: 13px;
        flex-shrink: 0;
    }

    .dr-btn.accept {
        background: var(--success-bg);
        border-color: var(--success-border);
        color: var(--success-text);
    }

    .dr-btn.accept:hover {
        background: #dcfce7;
        border-color: #86efac;
    }

    .dr-btn.reject {
        background: var(--danger-bg);
        border-color: var(--danger-border);
        color: var(--danger-text);
    }

    .dr-btn.reject:hover {
        background: #ffe4e6;
        border-color: #fca5a5;
    }

    /* Inline form reset */
    .dr-card-actions form {
        display: contents;
    }

    /* ── Admin note ── */
    .dr-card-note {
        font-size: 12.5px;
        color: var(--text-secondary);
        line-height: 1.6;
        padding: 10px 12px;
        background: var(--surface-alt);
        border-radius: var(--radius-sm);
        border: 1px dashed var(--border);
        border-left: 3px solid #cbd5e1;
    }

    .dr-card-note-label {
        display: block;
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    /* ── Empty ── */
    .dr-empty {
        text-align: center;
        padding: 56px 24px;
        color: var(--text-muted);
    }

    .dr-empty-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--surface-alt);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: var(--text-muted);
    }

    .dr-empty-icon svg {
        width: 24px;
        height: 24px;
    }

    .dr-empty p {
        font-size: 14px;
        margin: 0;
    }

    .dr-empty strong {
        display: block;
        font-size: 16px;
        color: var(--text-secondary);
        margin-bottom: 4px;
    }

    .dr-pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    .dr-pagination-info {
        font-size: 13px;
        color: var(--text-secondary);
    }

    .dr-pagination {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .dr-page-btn,
    .dr-page-dot {
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

    .dr-page-btn {
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-secondary);
        cursor: pointer;
        transition: all .18s ease;
    }

    .dr-page-btn:hover {
        border-color: var(--brand-mid);
        color: var(--brand);
        background: var(--brand-light);
    }

    .dr-page-btn.active {
        border-color: var(--brand);
        background: var(--brand);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .dr-page-btn:disabled {
        opacity: .45;
        cursor: not-allowed;
        background: var(--surface-alt);
    }

    .dr-page-dot {
        color: var(--text-muted);
    }

    /* ── Responsive ── */
    @media (max-width: 680px) {
        .dr-header {
            flex-direction: column;
            gap: 14px;
        }

        .dr-group-head {
            grid-template-columns: 1fr;
        }

        .dr-group-right {
            flex-wrap: wrap;
        }

        .dr-kpi-cluster {
            flex: 1;
        }

        .dr-kpi {
            flex: 1;
            min-width: 0;
        }

        .dr-toggle {
            display: none;
        }

        .dr-grid {
            grid-template-columns: 1fr;
        }

        .dr-avatar {
            width: 38px;
            height: 38px;
            font-size: 13px;
        }

        .dr-customer-name {
            font-size: 14px;
        }

        .dr-btn {
            min-height: 38px;
            padding: 8px 14px;
            font-size: 13px;
        }

        .dr-group-body {
            padding: 0 14px 14px;
        }

        .dr-group summary {
            padding: 14px;
        }
    }

    @media (max-width: 400px) {
        .dr-card-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .dr-card-actions {
            gap: 6px;
        }

        .dr-btn {
            flex: 1 1 auto;
            justify-content: center;
        }
    }
</style>

<?php
/* Helper: initials from full name */
function dr_initials($name)
{
    $parts = array_filter(explode(' ', trim($name)));
    $initials = '';
    foreach (array_slice($parts, 0, 2) as $p) {
        $initials .= strtoupper($p[0]);
    }
    return $initials ?: '?';
}
?>

<div class="dr-wrap">
    <!-- Page header -->
    <!-- <div class="dr-header">
        <div>
            <h3 class="dr-header-title">Documents Review</h3>
            <p class="dr-header-sub">Open one customer at a time, review every document, and approve or reject pending uploads directly from this page.</p>
        </div>
        <?php if (!empty($document_groups)): ?>
            <input type="search" id="drSearchInput" class="dr-search" placeholder="Search customer, email, phone, or document">
        <?php endif; ?>
    </div> -->

    <!-- Document groups -->
    <div class="dr-groups" id="drGroups">
        <?php if (!empty($document_groups)): ?>
            <?php foreach ($document_groups as $index => $group): ?>
                <?php $customer = $group['customer']; ?>
                <?php
                $document_search_parts = array(
                    isset($customer['full_name']) ? $customer['full_name'] : '',
                    isset($customer['email']) ? $customer['email'] : '',
                    isset($customer['phone']) ? $customer['phone'] : '',
                );
                foreach ($group['documents'] as $document) {
                    $document_search_parts[] = isset($document['document_type']) ? $document['document_type'] : '';
                    $document_search_parts[] = isset($document['status']) ? $document['status'] : '';
                    $document_search_parts[] = isset($document['booking_label']) ? $document['booking_label'] : '';
                    $document_search_parts[] = isset($document['admin_notes']) ? $document['admin_notes'] : '';
                    $document_search_parts[] = isset($document['file_name']) ? $document['file_name'] : '';
                }
                $document_group_search = strtolower(trim(implode(' ', array_filter($document_search_parts))));
                ?>
                <details class="dr-group js-dr-group" data-search="<?php echo html_escape($document_group_search); ?>">
                    <summary>
                        <div class="dr-group-head">
                            <!-- Left: avatar + name -->
                            <div class="dr-group-left">
                                <div class="dr-avatar" aria-hidden="true">
                                    <?php echo html_escape(dr_initials($customer['full_name'])); ?>
                                </div>
                                <div class="dr-customer-info">
                                    <p class="dr-customer-name"><?php echo html_escape($customer['full_name']); ?></p>
                                    <p class="dr-customer-meta"><?php echo html_escape($customer['email']); ?><?php if (!empty($customer['phone'])): ?> &middot; <?php echo html_escape($customer['phone']); ?><?php endif; ?></p>
                                </div>
                            </div>

                            <!-- Right: KPIs + toggle -->
                            <div class="dr-group-right">
                                <div class="dr-kpi-cluster">
                                    <div class="dr-kpi">
                                        <span class="dr-kpi-label">Uploaded</span>
                                        <span class="dr-kpi-value"><?php echo (int)$group['uploaded_count']; ?><span style="color:var(--text-muted);font-size:13px;font-weight:500;"> / <?php echo (int)$group['total_count']; ?></span></span>
                                    </div>
                                    <div class="dr-kpi">
                                        <span class="dr-kpi-label">Pending</span>
                                        <span class="dr-kpi-value <?php echo $group['pending_count'] > 0 ? 'has-pending' : ''; ?>">
                                            <?php echo (int)$group['pending_count']; ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Delete all docs button -->
                                <form method="post"
                                    action="<?php echo base_url('admin/documents/delete-customer/' . (int)$customer['id']); ?>"
                                    class="js-swal-confirm-form"
                                    data-swal-title="Delete all documents?"
                                    data-swal-text="All documents for <?php echo html_escape($customer['full_name']); ?> will be permanently deleted."
                                    data-swal-confirm="Delete All"
                                    style="display:inline;">
                                    <button type="submit" style="
            display:inline-flex;align-items:center;gap:5px;height:32px;
            padding:0 12px;border-radius:8px;
            border:1.5px solid var(--danger-border);
            background:var(--danger-bg);color:var(--danger-text);
            font:600 12px/1 var(--font);cursor:pointer;white-space:nowrap;
        ">
                                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                                            <path d="M2 4h12M5 4V2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5V4M6 7v5M10 7v5M3 4l.8 9a1 1 0 0 0 1 .9h6.4a1 1 0 0 0 1-.9L13 4"
                                                stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Delete All
                                    </button>
                                </form>

                                <div class="dr-toggle" aria-hidden="true">
                                    <svg viewBox="0 0 16 16" fill="none">
                                        <path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </summary>

                    <div class="dr-group-body">
                        <div class="dr-grid">
                            <?php foreach ($group['documents'] as $document): ?>
                                <div class="dr-card" data-status="<?php echo html_escape($document['status']); ?>">

                                    <!-- Card top: icon + title + badge -->
                                    <div class="dr-card-top">
                                        <div class="dr-doc-icon">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 2a1 1 0 0 1 1-1h6.586a1 1 0 0 1 .707.293l2.414 2.414A1 1 0 0 1 14 4.414V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2Z" stroke="currentColor" stroke-width="1.25" />
                                                <path d="M10 1v3a1 1 0 0 0 1 1h3" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" />
                                                <path d="M6 9h4M6 11.5h2.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" />
                                            </svg>
                                        </div>

                                        <div class="dr-card-title">
                                            <strong><?php echo html_escape($document['document_type']); ?></strong>
                                            <?php if (!empty($document['booking_label'])): ?>
                                                <span class="booking-label"><?php echo html_escape($document['booking_label']); ?></span>
                                            <?php endif; ?>
                                            <span class="timestamp">
                                                <?php if ($document['status'] === 'missing'): ?>
                                                    Not uploaded yet
                                                <?php elseif (!empty($document['updated_at'])): ?>
                                                    Updated <?php echo html_escape($document['updated_at']); ?>
                                                <?php else: ?>
                                                    &mdash;
                                                <?php endif; ?>
                                            </span>
                                        </div>

                                        <span class="dr-badge badge-<?php echo html_escape($document['status']); ?>">
                                            <?php echo html_escape(ucfirst($document['status'])); ?>
                                        </span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="dr-card-actions">
                                        <?php if (!empty($document['file_path'])): ?>
                                            <a class="dr-btn" href="<?php echo base_url($document['file_path']); ?>" target="_blank" rel="noopener noreferrer">
                                                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 10.5 3.5 6h9L8 10.5Z" fill="currentColor" />
                                                    <rect x="1" y="13" width="14" height="1.5" rx=".75" fill="currentColor" />
                                                    <rect x="7.25" y="1" width="1.5" height="8" rx=".75" fill="currentColor" />
                                                </svg>
                                                View file
                                            </a>
                                        <?php else: ?>
                                            <span style="font-size:12.5px;color:var(--text-muted);font-weight:600;padding:6px 2px;display:flex;align-items:center;gap:5px;">
                                                <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                                                    <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.25" />
                                                    <path d="M10 6 6 10M6 6l4 4" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" />
                                                </svg>
                                                Not uploaded
                                            </span>
                                        <?php endif; ?>

                                        <?php if ($document['status'] === 'pending' && !empty($document['id'])): ?>
                                            <form method="post" action="<?php echo base_url('admin/documents/update-status'); ?>">
                                                <input type="hidden" name="document_id" value="<?php echo (int)$document['id']; ?>">
                                                <input type="hidden" name="status" value="approved">
                                                <input type="hidden" name="admin_notes" value="Approved by admin from documents review.">
                                                <button class="dr-btn accept" type="submit">
                                                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.5 8.5 6 12l7.5-8" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="post" action="<?php echo base_url('admin/documents/update-status'); ?>">
                                                <input type="hidden" name="document_id" value="<?php echo (int)$document['id']; ?>">
                                                <input type="hidden" name="status" value="rejected">
                                                <input type="hidden" name="admin_notes" value="Rejected by admin from documents review. Please upload again.">
                                                <button class="dr-btn reject" type="submit">
                                                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 4l8 8M12 4l-8 8" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
                                                    </svg>
                                                    Reject
                                                </button>
                                            </form>
                                        <?php elseif (!empty($document['id'])): ?>
                                            <a class="dr-btn" href="<?php echo base_url('admin/documents/review/' . (int)$document['id']); ?>">
                                                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.5 12.5a.75.75 0 0 1 .75-.75h9.5a.75.75 0 0 1 0 1.5h-9.5a.75.75 0 0 1-.75-.75ZM2.5 9.5a.75.75 0 0 1 .75-.75h9.5a.75.75 0 0 1 0 1.5h-9.5A.75.75 0 0 1 2.5 9.5ZM2.5 6.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5A.75.75 0 0 1 2.5 6.5ZM5.75 3.5a.75.75 0 0 1 .75-.75h5.75a.75.75 0 0 1 0 1.5H6.5a.75.75 0 0 1-.75-.75Z" fill="currentColor" />
                                                </svg>
                                                Notes
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Admin note -->
                                    <?php if (!empty($document['admin_notes'])): ?>
                                        <div class="dr-card-note">
                                            <span class="dr-card-note-label">Admin note</span>
                                            <?php echo html_escape($document['admin_notes']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </details>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="dr-empty">
                <div class="dr-empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <strong>No documents yet</strong>
                <p>When customers upload documents, they'll appear here for review.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($document_groups)): ?>
        <div class="dr-pagination-wrap" id="drPaginationWrap">
            <div class="dr-pagination-info" id="drPaginationInfo"></div>
            <div class="dr-pagination" id="drPagination"></div>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($document_groups)): ?>
<script>
    (function () {
        var groups = Array.prototype.slice.call(document.querySelectorAll('.js-dr-group'));
        var paginationWrap = document.getElementById('drPaginationWrap');
        var paginationInfo = document.getElementById('drPaginationInfo');
        var pagination = document.getElementById('drPagination');
        var searchInput = document.getElementById('drSearchInput');
        var perPage = 6;
        var currentPage = 1;
        var filteredGroups = groups.slice();

        if (!groups.length || !paginationWrap || !paginationInfo || !pagination) {
            return;
        }

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

        function createButton(label, page, disabled, active) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'dr-page-btn' + (active ? ' active' : '');
            btn.textContent = label;
            btn.disabled = !!disabled;
            if (!disabled && !active) {
                btn.addEventListener('click', function () {
                    currentPage = page;
                    render();
                });
            }
            return btn;
        }

        function createDots() {
            var dot = document.createElement('span');
            dot.className = 'dr-page-dot';
            dot.textContent = '...';
            return dot;
        }

        function render() {
            var term = searchInput ? searchInput.value.toLowerCase().trim() : '';
            filteredGroups = groups.filter(function (group) {
                var haystack = (group.getAttribute('data-search') || '').toLowerCase();
                return term === '' || haystack.indexOf(term) !== -1;
            });

            var total = filteredGroups.length;
            if (total === 0) {
                groups.forEach(function (group) {
                    group.style.display = 'none';
                });
                paginationInfo.textContent = 'No matching customers found';
                pagination.innerHTML = '';
                return;
            }

            var totalPages = Math.max(1, Math.ceil(total / perPage));
            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            var start = (currentPage - 1) * perPage;
            var end = start + perPage;

            groups.forEach(function (group) {
                group.style.display = 'none';
            });

            filteredGroups.forEach(function (group, index) {
                group.style.display = (index >= start && index < end) ? '' : 'none';
            });

            paginationInfo.textContent = 'Showing ' + (start + 1) + '-' + Math.min(end, total) + ' of ' + total + ' customers';
            pagination.innerHTML = '';
            pagination.appendChild(createButton('Prev', currentPage - 1, currentPage === 1, false));

            getPageItems(totalPages, currentPage).forEach(function (item) {
                if (item === 'dots') {
                    pagination.appendChild(createDots());
                    return;
                }
                pagination.appendChild(createButton(String(item), item, false, item === currentPage));
            });

            pagination.appendChild(createButton('Next', currentPage + 1, currentPage === totalPages, false));
        }

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                currentPage = 1;
                render();
            });
        }

        render();
    })();
</script>
<?php endif; ?>
