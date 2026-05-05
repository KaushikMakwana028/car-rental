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

    .requests-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .request-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
    }

    .request-card span {
        display: block;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
    }

    .request-card strong {
        display: block;
        font-size: 30px;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .request-card p {
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
    }

    .request-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 12px;
    }

    .request-actions form {
        display: inline-flex;
    }

    .mini-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 8px 14px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        font-weight: 700;
    }

    .mini-btn.approve {
        background: #dcfce7;
        color: #166534;
    }

    .mini-btn.reject {
        background: #fee2e2;
        color: #b91c1c;
    }

    .receipt-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #0f172a;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }
</style>

<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-content">
            <h1>Payment Requests</h1>
            <p>Review uploaded payment receipts, open the proof file, and approve or reject each customer request.</p>
        </div>
    </div>

    <div class="requests-grid">
        <div class="request-card">
            <span>Total Requests</span>
            <strong><?php echo (int) $payment_request_counts['total']; ?></strong>
            <p>All payment receipts uploaded by customers.</p>
        </div>
        <div class="request-card">
            <span>Pending Review</span>
            <strong><?php echo (int) $payment_request_counts['pending']; ?></strong>
            <p>Requests waiting for your approval decision.</p>
        </div>
        <div class="request-card">
            <span>Approved</span>
            <strong><?php echo (int) $payment_request_counts['approved']; ?></strong>
            <p>Receipts already converted into approved payment records.</p>
        </div>
        <div class="request-card">
            <span>Rejected</span>
            <strong><?php echo (int) $payment_request_counts['rejected']; ?></strong>
            <p>Receipts that customers need to upload again.</p>
        </div>
    </div>

    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>Customer Upload Queue</h3>
                <p>Open the uploaded receipt and mark the payment request as approved or rejected. Customers will see the same status on their side.</p>
            </div>
            <a class="btn" href="<?php echo base_url('admin/payments/settings'); ?>">Add Payment Details</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Receipt</th>
                        <th>Status</th>
                        <th>Customer Note</th>
                        <th>Admin Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($payment_requests)): foreach ($payment_requests as $request): ?>
                        <tr>
                            <td>
                                <strong><?php echo html_escape($request['booking_code']); ?></strong><br>
                                <span style="color:#64748b;"><?php echo !empty($request['created_at']) ? date('d M Y h:i A', strtotime($request['created_at'])) : '-'; ?></span>
                            </td>
                            <td>
                                <strong><?php echo html_escape($request['customer_name']); ?></strong><br>
                                <span style="color:#64748b;"><?php echo html_escape($request['customer_phone']); ?></span>
                            </td>
                            <td>
                                <strong><?php echo html_escape($request['vehicle_name']); ?></strong><br>
                                <span style="color:#64748b;"><?php echo html_escape($request['registration_no']); ?></span>
                            </td>
                            <td><?php echo ucwords(str_replace('_', ' ', html_escape($request['payment_type']))); ?></td>
                            <td>
                                <strong>&#8377;<?php echo number_format((float) $request['amount'], 2); ?></strong><br>
                                <span style="color:#64748b;"><?php echo html_escape($request['payment_mode']); ?></span>
                            </td>
                            <td><a class="receipt-link" href="<?php echo base_url($request['receipt_path']); ?>" target="_blank">Open Receipt</a></td>
                            <td><span class="badge badge-<?php echo html_escape($request['status']); ?>"><?php echo html_escape($request['status']); ?></span></td>
                            <td style="max-width:220px;">
                                <span style="color:#475569;"><?php echo !empty($request['customer_notes']) ? html_escape($request['customer_notes']) : 'No note added'; ?></span>
                                <?php if (!empty($request['admin_notes'])): ?>
                                    <br><span style="color:#b91c1c;">Admin: <?php echo html_escape($request['admin_notes']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="request-actions">
                                    <form method="post" action="<?php echo base_url('admin/payments/approve/' . (int) $request['id']); ?>">
                                        <input type="hidden" name="admin_notes" value="Payment approved by admin.">
                                        <button class="mini-btn approve" type="submit">Approve</button>
                                    </form>
                                    <form method="post" action="<?php echo base_url('admin/payments/reject/' . (int) $request['id']); ?>">
                                        <input type="hidden" name="admin_notes" value="Receipt rejected. Please upload a clear or correct payment proof.">
                                        <button class="mini-btn reject" type="submit">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">No payment requests uploaded yet.</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
