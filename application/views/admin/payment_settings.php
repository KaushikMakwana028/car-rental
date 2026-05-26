<style>
    .page-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-size: 30px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
    }

    .payment-settings-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(320px, .8fr);
        gap: 24px;
    }

    .info-panel {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        color: white;
    }

    .info-panel .card-head,
    .info-panel .detail-stack {
        border-color: rgba(255, 255, 255, .12);
    }

    .detail-stack {
        padding: 22px 24px 24px;
        display: grid;
        gap: 14px;
    }

    .detail-box {
        padding: 14px 16px;
        border-radius: 14px;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .12);
    }

    .detail-box strong {
        display: block;
        font-size: 13px;
        margin-bottom: 6px;
        color: #bfdbfe;
    }

    .detail-box span {
        display: block;
        font-size: 14px;
        line-height: 1.6;
        color: rgba(255, 255, 255, .86);
        word-break: break-word;
    }

    .preview-qr {
        max-width: 230px;
        border-radius: 18px;
        background: white;
        padding: 10px;
        margin-top: 10px;
    }

    @media (max-width: 992px) {

        .payment-settings-grid {
            grid-template-columns: 1fr !important;
        }

        .page-wrapper {
            padding: 16px;
        }
    }

    @media (max-width: 768px) {

        /* Header */
        .page-header h1 {
            font-size: 24px;
            line-height: 1.3;
        }

        .page-header p {
            font-size: 13px;
        }

        /* Cards */
        .section-card {
            border-radius: 16px;
            overflow: hidden;
        }

        /* Card Header */
        .card-head {
            padding: 18px 18px 14px;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .card-head h3 {
            font-size: 18px;
        }

        .card-head p {
            font-size: 13px;
            line-height: 1.5;
        }

        /* Form Padding */
        form {
            padding: 18px !important;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr !important;
            gap: 16px;
        }

        /* Inputs */
        .form-grid input,
        .form-grid textarea,
        .form-grid select {
            width: 100%;
            font-size: 14px;
            padding: 12px 14px;
            box-sizing: border-box;
        }

        /* Labels */
        .form-grid label {
            font-size: 13px;
            margin-bottom: 6px;
            display: block;
        }

        /* Button */
        .btn {
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        /* Right Side Panel */
        .detail-stack {
            padding: 18px;
        }

        .detail-box {
            padding: 14px;
            border-radius: 12px;
        }

        .detail-box strong {
            font-size: 12px;
        }

        .detail-box span {
            font-size: 13px;
            line-height: 1.5;
        }

        /* QR Image */
        .preview-qr {
            width: 100%;
            max-width: 220px;
            height: auto;
            display: block;
        }
    }

    @media (max-width: 480px) {

        .page-wrapper {
            padding: 12px;
        }

        .page-header {
            margin-bottom: 18px;
        }

        .page-header h1 {
            font-size: 22px;
        }

        .section-card {
            border-radius: 14px;
        }

        .card-head {
            padding: 16px;
        }

        form {
            padding: 16px !important;
        }

        .detail-stack {
            padding: 16px;
        }

        .detail-box {
            padding: 12px;
        }

        .preview-qr {
            max-width: 180px;
        }
    }
</style>

<div class="page-wrapper">
    <!-- <div class="page-header">
        <div class="page-header-content">
            <h1>Payment Details</h1>
            <p>Add the QR image, bank account details, and instructions customers should use before uploading their receipt.</p>
        </div>
    </div> -->

    <div class="payment-settings-grid">
        <section class="section-card">
            <div class="card-head">
                <div>
                    <h3>Customer Payment Setup</h3>
                    <p>These details are shown on the customer payment page before they upload the advance receipt.</p>
                </div>
            </div>

            <form method="post" action="<?php echo base_url('admin/payments/settings/save'); ?>" enctype="multipart/form-data" style="padding:24px;">
                <div class="form-grid">
                    <div><label>Account Holder</label><input type="text" name="account_holder" value="<?php echo html_escape($payment_settings['account_holder']); ?>" placeholder="Enter account holder name"></div>
                    <div><label>Bank Name</label><input type="text" name="bank_name" value="<?php echo html_escape($payment_settings['bank_name']); ?>" placeholder="Enter bank name"></div>
                    <div><label>Account Number</label><input type="text" name="account_number" value="<?php echo html_escape($payment_settings['account_number']); ?>" placeholder="Enter account number"></div>
                    <div><label>IFSC Code</label><input type="text" name="ifsc_code" value="<?php echo html_escape($payment_settings['ifsc_code']); ?>" placeholder="Enter IFSC code"></div>
                    <div><label>Branch Name</label><input type="text" name="branch_name" value="<?php echo html_escape($payment_settings['branch_name']); ?>" placeholder="Enter branch name"></div>
                    <div><label>UPI ID</label><input type="text" name="upi_id" value="<?php echo html_escape($payment_settings['upi_id']); ?>" placeholder="Enter UPI ID"></div>
                    <div class="full">
                        <label>QR Image</label>
                        <input type="file" name="qr_image" accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-hint">Optional. Upload a QR image so customers can scan and pay quickly.</div>
                    </div>
                    <div class="full">
                        <label>Payment Instructions</label>
                        <textarea name="payment_instructions" rows="5" placeholder="Add admin instructions for payment, receipt upload, or bank transfer notes."><?php echo html_escape($payment_settings['payment_instructions']); ?></textarea>
                    </div>
                </div>
                <div style="margin-top:20px;">
                    <button class="btn" type="submit">Save Payment Details</button>
                </div>
            </form>
        </section>

        <aside class="section-card info-panel">
            <div class="card-head">
                <div>
                    <h3 style="color:#fff;">Current Customer View</h3>
                    <p style="color:rgba(255,255,255,.72);">This is what customers use while making advance payments.</p>
                </div>
            </div>
            <div class="detail-stack">
                <div class="detail-box">
                    <strong>Bank Account</strong>
                    <span><?php echo !empty($payment_settings['account_holder']) ? html_escape($payment_settings['account_holder']) : 'Not added yet'; ?></span>
                    <span><?php echo !empty($payment_settings['bank_name']) ? html_escape($payment_settings['bank_name']) : 'Bank name missing'; ?></span>
                    <span><?php echo !empty($payment_settings['account_number']) ? html_escape($payment_settings['account_number']) : 'Account number missing'; ?></span>
                    <span><?php echo !empty($payment_settings['ifsc_code']) ? html_escape($payment_settings['ifsc_code']) : 'IFSC missing'; ?></span>
                </div>
                <div class="detail-box">
                    <strong>UPI ID</strong>
                    <span><?php echo !empty($payment_settings['upi_id']) ? html_escape($payment_settings['upi_id']) : 'UPI not added yet'; ?></span>
                </div>
                <div class="detail-box">
                    <strong>QR Preview</strong>
                    <?php if (!empty($payment_settings['qr_image'])): ?>
                        <img class="preview-qr" src="<?php echo base_url($payment_settings['qr_image']); ?>" alt="QR Preview">
                    <?php else: ?>
                        <span>QR image not uploaded yet.</span>
                    <?php endif; ?>
                </div>
                <div class="detail-box">
                    <strong>Instructions</strong>
                    <span><?php echo !empty($payment_settings['payment_instructions']) ? nl2br(html_escape($payment_settings['payment_instructions'])) : 'No payment instructions added yet.'; ?></span>
                </div>
            </div>
        </aside>
    </div>
</div>