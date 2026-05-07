<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$existing_request   = !empty($existing_request)   ? $existing_request   : array();
$payment_settings   = !empty($payment_settings)   ? $payment_settings   : array();
$advance_amount     = isset($booking['advance_due']) ? (float) $booking['advance_due'] : 0;
$advance_amount     = $advance_amount > 0 ? $advance_amount : (float) $booking['amount'];
$current_step       = isset($current_step) ? (int) $current_step : 3;
?>

<style>
    /* ── Stepper (ORIGINAL — untouched) ──────────────────── */
    .step-shell {
        padding: 20px 24px;
    }

    .stepper {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .step-item {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .step-badge {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        border: 1px solid rgba(35, 94, 167, .18);
        background: #fff;
        color: var(--muted);
    }

    .step-item.active .step-badge,
    .step-item.done .step-badge {
        background: linear-gradient(135deg, var(--accent) 0%, #f1c14f 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 8px 18px rgba(35, 94, 167, .18);
    }

    .step-label {
        color: var(--muted);
        font-weight: 700;
    }

    .step-item.active .step-label,
    .step-item.done .step-label {
        color: var(--ink);
    }

    .step-line {
        width: 42px;
        height: 2px;
        border-radius: 999px;
        background: rgba(35, 94, 167, .14);
    }

    .step-line.done {
        background: linear-gradient(90deg, var(--accent) 0%, #f1c14f 100%);
    }

    /* ── Responsive split grid ────────────────────────────── */
    .split-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 860px) {
        .split-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ── Form field styles ────────────────────────────────── */
    .pay-form-card .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 580px) {
        .pay-form-card .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .pay-form-card .form-grid .full {
        grid-column: 1 / -1;
    }

    .pay-form-card .form-grid label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        margin: 0 0 5px;
    }

    .pay-form-card .form-grid input,
    .pay-form-card .form-grid select,
    .pay-form-card .form-grid textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 13px;
        border-radius: 12px;
        border: 1.5px solid rgba(35, 94, 167, .16);
        background: rgba(246, 250, 255, .8);
        font-size: 14px;
        color: var(--ink);
        font-family: inherit;
        outline: none;
        transition: border-color .18s, box-shadow .18s, background .18s;
        appearance: none;
        -webkit-appearance: none;
    }

    .pay-form-card .form-grid select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23235ea7' stroke-width='1.6' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 34px;
        cursor: pointer;
    }

    .pay-form-card .form-grid input:focus,
    .pay-form-card .form-grid select:focus,
    .pay-form-card .form-grid textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(35, 94, 167, .10);
        background: #fff;
    }

    .pay-form-card .form-grid input[readonly] {
        background: rgba(35, 94, 167, .05);
        color: var(--muted);
        cursor: default;
        border-color: rgba(35, 94, 167, .08);
    }

    .pay-form-card .form-grid textarea {
        resize: vertical;
        min-height: 86px;
    }

    /* File dropzone */
    .pay-file-zone {
        position: relative;
        border: 2px dashed rgba(35, 94, 167, .22);
        border-radius: 14px;
        background: rgba(246, 250, 255, .7);
        padding: 22px 16px 18px;
        text-align: center;
        cursor: pointer;
        transition: border-color .18s, background .18s;
    }

    .pay-file-zone:hover {
        border-color: var(--accent);
        background: rgba(35, 94, 167, .04);
    }

    .pay-file-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    .pay-file-zone-icon {
        font-size: 26px;
        line-height: 1;
        margin-bottom: 7px;
    }

    .pay-file-zone-text {
        font-size: 13px;
        font-weight: 700;
        color: var(--accent);
    }

    .pay-file-zone-hint {
        font-size: 11.5px;
        color: var(--muted);
        margin-top: 3px;
    }

    .js-payment-file-name {
        font-size: 12.5px;
        color: var(--muted);
        min-height: 18px;
        margin-top: 5px;
        padding: 0 2px;
    }

    /* Booking actions */
    .booking-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid rgba(35, 94, 167, .09);
    }

    .booking-actions .btn,
    .booking-actions .btn-secondary {
        min-width: 148px;
    }

    @media (max-width: 480px) {
        .booking-actions {
            flex-direction: column;
        }

        .booking-actions .btn,
        .booking-actions .btn-secondary {
            width: 100%;
            min-width: unset;
            text-align: center;
        }
    }

    /* ── Admin aside card ─────────────────────────────────── */
    .pay-aside-card {
        padding: 0;
        overflow: hidden;
    }

    .pay-amt-hero {
        padding: 20px 22px 16px;
        background: linear-gradient(135deg, rgba(35, 94, 167, .09) 0%, rgba(255, 234, 140, .38) 100%);
        border-bottom: 1px solid rgba(35, 94, 167, .10);
    }

    .pay-amt-eyebrow {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 6px;
    }

    .pay-amt-value {
        font-size: clamp(30px, 5vw, 40px);
        font-weight: 900;
        color: var(--ink);
        line-height: 1;
        letter-spacing: -.02em;
    }

    .pay-amt-note {
        font-size: 12.5px;
        color: var(--ink-2, #5a6a7a);
        margin-top: 8px;
        line-height: 1.6;
    }

    .pay-aside-body {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    /* QR */
    .pay-qr-wrap {
        text-align: center;
    }

    .pay-qr-lbl {
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .10em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 10px;
    }

    .pay-qr-frame {
        display: inline-block;
        padding: 10px;
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(35, 94, 167, .12);
        box-shadow: 0 4px 18px rgba(35, 94, 167, .09);
    }

    .pay-qr-frame img {
        display: block;
        width: min(170px, 100%);
        height: auto;
        border-radius: 10px;
    }

    .pay-qr-note {
        font-size: 11.5px;
        color: var(--muted);
        margin-top: 8px;
        line-height: 1.55;
    }

    /* Bank list */
    .pay-bank-head {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .10em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .pay-bank-list {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .pay-bank-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 10px 13px;
        border-radius: 12px;
        background: rgba(255, 255, 255, .85);
        border: 1px solid rgba(35, 94, 167, .10);
    }

    .pay-bank-lbl {
        font-size: 9.5px;
        font-weight: 800;
        letter-spacing: .10em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 2px;
    }

    .pay-bank-val {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--ink);
        word-break: break-all;
        line-height: 1.3;
    }

    .pay-bank-val.mono {
        font-family: 'Courier New', monospace;
        font-size: 13px;
        color: var(--accent);
        letter-spacing: .02em;
    }

    .pay-copy {
        flex-shrink: 0;
        background: rgba(35, 94, 167, .10);
        border: none;
        border-radius: 8px;
        padding: 4px 9px;
        font-size: 11px;
        font-weight: 700;
        color: var(--accent);
        cursor: pointer;
        transition: background .15s, color .15s;
        white-space: nowrap;
    }

    .pay-copy:hover {
        background: rgba(35, 94, 167, .18);
    }

    .pay-copy.copied {
        background: rgba(50, 160, 50, .13);
        color: #2a8a2a;
    }

    /* Instructions */
    .pay-instr {
        padding: 13px 14px;
        background: rgba(255, 248, 210, .75);
        border: 1px solid rgba(210, 170, 50, .28);
        border-radius: 13px;
        font-size: 13px;
        color: #6b520e;
        line-height: 1.65;
    }

    .pay-instr-lbl {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .10em;
        text-transform: uppercase;
        color: #a07010;
        margin-bottom: 5px;
    }

    /* Status */
    .pay-status {
        background: rgba(255, 255, 255, .88);
        border: 1.5px solid rgba(35, 94, 167, .14);
        border-radius: 13px;
        padding: 13px 14px;
    }

    .pay-status-lbl {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .10em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 7px;
    }

    .pay-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px 4px 9px;
        border-radius: 999px;
        background: rgba(35, 94, 167, .10);
        color: var(--accent);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .pay-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--accent);
        display: inline-block;
    }

    .pay-status-note {
        font-size: 12.5px;
        color: var(--ink-2, #5a6a7a);
        line-height: 1.6;
    }
</style>

<!-- ════ Stepper (ORIGINAL, unchanged) ════════════════════════════════ -->
<section class="section-card step-shell">
    <div class="stepper">
        <?php
        $steps = array(1 => 'Booking', 2 => 'Document', 3 => 'Payment');
        foreach ($steps as $step_no => $step_label):
            $is_active = $current_step === $step_no;
            $is_done   = $current_step > $step_no;
        ?>
            <div class="step-item <?php echo $is_active ? 'active' : ''; ?> <?php echo $is_done ? 'done' : ''; ?>">
                <div class="step-badge"><?php echo $is_done ? '&#10003;' : $step_no; ?></div>
                <div class="step-label"><?php echo html_escape($step_label); ?></div>
            </div>
            <?php if ($step_no < 3): ?>
                <div class="step-line <?php echo $current_step > $step_no ? 'done' : ''; ?>"></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- ════ Content ══════════════════════════════════════════════════════ -->
<div class="split-grid">

    <!-- LEFT: Form ─────────────────────────────────────────────────── -->
    <section class="section-card pay-form-card">
        <div class="card-head">
            <div>
                <div class="eyebrow">Advance Payment</div>
                <h3>Upload your advance payment receipt.</h3>
                <p>Pay the advance amount using the admin payment details on the right, then upload the receipt to complete the booking request.</p>
            </div>
        </div>

        <form method="post" action="<?php echo base_url('payments/store'); ?>" enctype="multipart/form-data">
            <input type="hidden" name="booking_id" value="<?php echo (int) $booking['id']; ?>">
            <input type="hidden" name="customer_id" value="<?php echo (int) $booking['customer_id']; ?>">

            <div class="form-grid">
                <div class="full">
                    <label>Booking</label>
                    <input type="text" value="<?php echo html_escape($booking['booking_code'] . ' | ' . $booking['vehicle_name']); ?>" readonly>
                </div>
                <div>
                    <label>Payment Type</label>
                    <input type="text" value="Advance Payment" readonly>
                </div>
                <div>
                    <label>Advance Amount</label>
                    <input type="number" step="0.01" value="<?php echo number_format($advance_amount, 2, '.', ''); ?>" readonly required>
                </div>
                <div>
                    <label>Payment Mode</label>
                    <select name="payment_mode" required>
                        <option value="UPI">UPI</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cash Deposit">Cash Deposit</option>
                    </select>
                </div>
                <div>
                    <label>Transaction / Reference No.</label>
                    <input type="text" name="reference_no" placeholder="Enter UPI or bank reference number" required>
                </div>
                <div class="full">
                    <label>Receipt Upload</label>
                    <div class="pay-file-zone">
                        <input class="js-payment-file" type="file" name="receipt_file" accept=".jpg,.jpeg,.png,.pdf,.webp" required>
                        <div class="pay-file-zone-icon">📎</div>
                        <div class="pay-file-zone-text">Click or drag &amp; drop to upload</div>
                        <div class="pay-file-zone-hint">JPG, PNG, PDF or WebP &mdash; max 8 MB</div>
                    </div>
                    <div class="js-payment-file-name"></div>
                </div>
                <div class="full">
                    <label>Customer Note <span style="font-weight:500;text-transform:none;font-size:11px;opacity:.55;">(optional)</span></label>
                    <textarea name="customer_notes" rows="3" placeholder="Optional note for admin, such as sender name or branch details."><?php echo !empty($existing_request['customer_notes']) ? html_escape($existing_request['customer_notes']) : ''; ?></textarea>
                </div>
            </div>

            <div class="booking-actions">
                <a class="btn-secondary" href="<?php echo base_url('documents?booking_id=' . (int) $booking['id'] . '&customer_id=' . (int) $booking['customer_id']); ?>">&#8592; Previous Step</a>
                <button class="btn" type="submit">Complete Booking</button>
                <a class="btn-secondary" href="<?php echo base_url('dashboard'); ?>">Cancel</a>
            </div>
        </form>
    </section>

    <!-- RIGHT: Admin Payment Details ───────────────────────────────── -->
    <aside class="section-card accent-card pay-aside-card">

        <div class="pay-amt-hero">
            <div class="pay-amt-eyebrow">Pay This Amount</div>
            <div class="pay-amt-value">&#8377;<?php echo number_format($advance_amount, 2); ?></div>
            <div class="pay-amt-note">Use the QR code or bank details below. Upload your receipt after payment.</div>
        </div>

        <div class="pay-aside-body">

            <?php if (!empty($payment_settings['qr_image'])): ?>
                <div class="pay-qr-wrap">
                    <div class="pay-qr-lbl">Scan &amp; Pay</div>
                    <div class="pay-qr-frame">
                        <img src="<?php echo base_url($payment_settings['qr_image']); ?>" alt="Payment QR Code">
                    </div>
                    <div class="pay-qr-note">Scan and pay the exact advance amount,<br>then upload your payment receipt.</div>
                </div>
            <?php endif; ?>

            <div>
                <div class="pay-bank-head">Bank Details</div>
                <div class="pay-bank-list">
                    <?php
                    $fields = array(
                        array('key' => 'account_holder', 'lbl' => 'Account Holder', 'mono' => false),
                        array('key' => 'bank_name',     'lbl' => 'Bank Name',     'mono' => false),
                        array('key' => 'account_number', 'lbl' => 'Account Number', 'mono' => true),
                        array('key' => 'ifsc_code',     'lbl' => 'IFSC Code',     'mono' => true),
                        array('key' => 'branch_name',   'lbl' => 'Branch',        'mono' => false),
                        array('key' => 'upi_id',        'lbl' => 'UPI ID',        'mono' => true),
                    );
                    foreach ($fields as $f):
                        $val = !empty($payment_settings[$f['key']]) ? html_escape($payment_settings[$f['key']]) : 'Not added yet';
                        $raw = !empty($payment_settings[$f['key']]) ? $payment_settings[$f['key']] : '';
                    ?>
                        <div class="pay-bank-row">
                            <div>
                                <div class="pay-bank-lbl"><?php echo $f['lbl']; ?></div>
                                <div class="pay-bank-val <?php echo $f['mono'] ? 'mono' : ''; ?>"><?php echo $val; ?></div>
                            </div>
                            <?php if ($f['mono'] && $raw): ?>
                                <button class="pay-copy" type="button" data-copy="<?php echo html_escape($raw); ?>">Copy</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="pay-instr">
                <div class="pay-instr-lbl">&#128161; Instructions</div>
                <?php echo !empty($payment_settings['payment_instructions'])
                    ? nl2br(html_escape($payment_settings['payment_instructions']))
                    : 'Use the available QR code or bank details above. Upload your receipt once the payment is done.'; ?>
            </div>

            <?php if (!empty($existing_request)): ?>
                <div class="pay-status">
                    <div class="pay-status-lbl">Current Request Status</div>
                    <div class="pay-status-badge">
                        <span class="pay-status-dot"></span>
                        <?php echo ucfirst(html_escape($existing_request['status'])); ?>
                    </div>
                    <div class="pay-status-note">
                        <?php echo !empty($existing_request['admin_notes'])
                            ? html_escape($existing_request['admin_notes'])
                            : 'Your uploaded receipt is waiting for admin action.'; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </aside>

</div>

<script>
    (function() {
        var input = document.querySelector('.js-payment-file');
        var nameEl = document.querySelector('.js-payment-file-name');
        var zone = document.querySelector('.pay-file-zone');

        if (input && nameEl) {
            input.addEventListener('change', function() {
                if (input.files && input.files.length > 0) {
                    var f = input.files[0];
                    var kb = f.size / 1024;
                    var sz = kb > 1024 ? (kb / 1024).toFixed(1) + ' MB' : Math.round(kb) + ' KB';
                    nameEl.textContent = '\u2713 ' + f.name + ' \u2014 ' + sz;
                    nameEl.style.color = '#2a8a2a';
                    nameEl.style.fontWeight = '700';
                    if (zone) {
                        zone.style.borderColor = '#5db85d';
                        zone.style.background = 'rgba(50,160,50,.05)';
                    }
                } else {
                    nameEl.textContent = '';
                    nameEl.style.color = '';
                    nameEl.style.fontWeight = '';
                    if (zone) {
                        zone.style.borderColor = '';
                        zone.style.background = '';
                    }
                }
            });
        }

        document.querySelectorAll('.pay-copy').forEach(function(btn) {
            btn.addEventListener('click', function() {
                navigator.clipboard.writeText(btn.getAttribute('data-copy') || '').then(function() {
                    btn.textContent = 'Copied!';
                    btn.classList.add('copied');
                    setTimeout(function() {
                        btn.textContent = 'Copy';
                        btn.classList.remove('copied');
                    }, 1800);
                });
            });
        });
    })();
</script>
