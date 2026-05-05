<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$existing_request = !empty($existing_request) ? $existing_request : array();
$payment_settings = !empty($payment_settings) ? $payment_settings : array();
$advance_amount = isset($booking['advance_due']) ? (float) $booking['advance_due'] : 0;
$full_amount = isset($booking['amount']) ? (float) $booking['amount'] : 0;
$selected_payment_type = !empty($existing_request['payment_type']) && in_array($existing_request['payment_type'], array('advance', 'full'), true)
    ? $existing_request['payment_type']
    : 'advance';
?>

<div class="split-grid">
    <section class="section-card">
        <div class="card-head">
            <div>
                <div class="eyebrow">Booking Payment</div>
                <h3>Upload your payment receipt.</h3>
                <p>Select advance or full payment, pay using the QR code or bank details below, and then upload your receipt for admin approval.</p>
            </div>
        </div>

        <form method="post" action="<?php echo base_url('customer/payments/store'); ?>" enctype="multipart/form-data">
            <input type="hidden" name="booking_id" value="<?php echo (int) $booking['id']; ?>">

            <div class="form-grid">
                <div class="full">
                    <label>Booking</label>
                    <input type="text" value="<?php echo html_escape($booking['booking_code'] . ' | ' . $booking['vehicle_name']); ?>" readonly>
                </div>
                <div>
                    <label>Payment Type</label>
                    <select name="payment_type" class="js-payment-type" required>
                        <option value="advance" <?php echo $selected_payment_type === 'advance' ? 'selected' : ''; ?>>Advance Payment</option>
                        <option value="full" <?php echo $selected_payment_type === 'full' ? 'selected' : ''; ?>>Full Payment</option>
                    </select>
                </div>
                <div>
                    <label class="js-payment-amount-label">Amount</label>
                    <input
                        type="number"
                        step="0.01"
                        name="amount"
                        class="js-payment-amount"
                        value="<?php echo number_format($selected_payment_type === 'full' ? $full_amount : $advance_amount, 2, '.', ''); ?>"
                        data-advance-amount="<?php echo number_format($advance_amount, 2, '.', ''); ?>"
                        data-full-amount="<?php echo number_format($full_amount, 2, '.', ''); ?>"
                        readonly
                        required
                    >
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
                    <input class="js-payment-file" type="file" name="receipt_file" accept=".jpg,.jpeg,.png,.pdf,.webp" required>
                    <div class="helper js-payment-file-name">Upload image or PDF receipt. Maximum file size: 8 MB.</div>
                </div>
                <div class="full">
                    <label>Customer Note</label>
                    <textarea name="customer_notes" rows="3" placeholder="Optional note for admin, such as sender name or branch details."><?php echo !empty($existing_request['customer_notes']) ? html_escape($existing_request['customer_notes']) : ''; ?></textarea>
                </div>
            </div>

            <div class="hero-actions">
                <button class="btn" type="submit">Upload Receipt</button>
                <a class="btn-secondary" href="<?php echo base_url('customer/payments'); ?>">View Payment Status</a>
            </div>
        </form>
    </section>

    <aside class="section-card accent-card">
        <div class="eyebrow">Admin Payment Details</div>
        <div class="card-head">
            <div>
                <h3 style="color:#fff;">Pay with the details below.</h3>
                <p style="color:rgba(247,243,231,.74);">Once the admin approves your receipt, your customer payment status will change from pending to approved.</p>
            </div>
        </div>
        <div class="info-grid" style="grid-template-columns:1fr;">
            <?php if (!empty($payment_settings['qr_image'])): ?>
                <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);text-align:center;">
                    <strong style="color:#fff;margin-bottom:14px;">Scan QR</strong>
                    <img src="<?php echo base_url($payment_settings['qr_image']); ?>" alt="Payment QR" style="max-width:220px;margin:0 auto;border-radius:18px;background:#fff;padding:10px;">
                </div>
            <?php endif; ?>

            <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);">
                <strong style="color:#fff;">Bank Details</strong>
                <span style="color:rgba(247,243,231,.74);">
                    Account Holder: <?php echo !empty($payment_settings['account_holder']) ? html_escape($payment_settings['account_holder']) : 'Not added yet'; ?><br>
                    Bank Name: <?php echo !empty($payment_settings['bank_name']) ? html_escape($payment_settings['bank_name']) : 'Not added yet'; ?><br>
                    Account Number: <?php echo !empty($payment_settings['account_number']) ? html_escape($payment_settings['account_number']) : 'Not added yet'; ?><br>
                    IFSC Code: <?php echo !empty($payment_settings['ifsc_code']) ? html_escape($payment_settings['ifsc_code']) : 'Not added yet'; ?><br>
                    Branch: <?php echo !empty($payment_settings['branch_name']) ? html_escape($payment_settings['branch_name']) : 'Not added yet'; ?><br>
                    UPI ID: <?php echo !empty($payment_settings['upi_id']) ? html_escape($payment_settings['upi_id']) : 'Not added yet'; ?>
                </span>
            </div>

            <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);">
                <strong style="color:#fff;">Instructions</strong>
                <span style="color:rgba(247,243,231,.74);">
                    <?php echo !empty($payment_settings['payment_instructions']) ? nl2br(html_escape($payment_settings['payment_instructions'])) : 'Admin has not added custom payment instructions yet. Use the available QR or bank details and upload your receipt.'; ?>
                </span>
            </div>

            <?php if (!empty($existing_request)): ?>
                <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);">
                    <strong style="color:#fff;">Current Request Status</strong>
                    <span style="color:rgba(247,243,231,.74);">
                        Status: <?php echo ucfirst(html_escape($existing_request['status'])); ?><br>
                        <?php if (!empty($existing_request['admin_notes'])): ?>
                            Admin Note: <?php echo html_escape($existing_request['admin_notes']); ?>
                        <?php else: ?>
                            The latest uploaded receipt is waiting for admin action.
                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </aside>
</div>

<script>
    (function () {
        var input = document.querySelector('.js-payment-file');
        var fileName = document.querySelector('.js-payment-file-name');
        var paymentType = document.querySelector('.js-payment-type');
        var paymentAmount = document.querySelector('.js-payment-amount');
        var paymentAmountLabel = document.querySelector('.js-payment-amount-label');

        function updatePaymentAmount() {
            if (!paymentType || !paymentAmount) {
                return;
            }

            var selectedType = paymentType.value === 'full' ? 'full' : 'advance';
            var amountValue = selectedType === 'full'
                ? paymentAmount.getAttribute('data-full-amount')
                : paymentAmount.getAttribute('data-advance-amount');

            paymentAmount.value = amountValue || '0.00';

            if (paymentAmountLabel) {
                paymentAmountLabel.textContent = selectedType === 'full' ? 'Full Payment Amount' : 'Advance Payment Amount';
            }
        }

        updatePaymentAmount();

        if (paymentType) {
            paymentType.addEventListener('change', updatePaymentAmount);
        }

        if (!input || !fileName) {
            return;
        }

        input.addEventListener('change', function () {
            if (input.files && input.files.length > 0) {
                fileName.textContent = input.files[0].name;
            } else {
                fileName.textContent = 'Upload image or PDF receipt. Maximum file size: 8 MB.';
            }
        });
    })();
</script>
