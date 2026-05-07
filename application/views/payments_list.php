<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$total_requests = count($payment_requests);
$pending_requests = 0;
$approved_requests = 0;
$rejected_requests = 0;

foreach ($payment_requests as $request) {
    if ($request['status'] === 'approved') {
        $approved_requests++;
    } elseif ($request['status'] === 'rejected') {
        $rejected_requests++;
    } else {
        $pending_requests++;
    }
}
?>

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-label">Total Requests</span>
        <span class="stat-value"><?php echo $total_requests; ?></span>
        <span class="stat-note">Every uploaded customer payment receipt appears here.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Pending</span>
        <span class="stat-value"><?php echo $pending_requests; ?></span>
        <span class="stat-note">Receipts still waiting for admin review.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Approved</span>
        <span class="stat-value"><?php echo $approved_requests; ?></span>
        <span class="stat-note">Payments accepted by the admin team.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Rejected</span>
        <span class="stat-value"><?php echo $rejected_requests; ?></span>
        <span class="stat-note">Receipts that need to be uploaded again with a clearer proof.</span>
    </div>
</div>

<section class="section-card">
    <div class="card-head">
        <div>
            <div class="eyebrow">Payment Requests</div>
            <h3>Uploaded receipts and approval status.</h3>
            <p>Check whether your advance payment receipt is pending, approved, or rejected by admin.</p>
        </div>
        <a class="btn" href="<?php echo base_url('bookings'); ?>">My Bookings</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Booking</th>
                    <th>Vehicle</th>
                    <th>Payment Type</th>
                    <th>Amount</th>
                    <th>Receipt</th>
                    <th>Status</th>
                    <th>Admin Note</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($payment_requests)): ?>
                <?php foreach ($payment_requests as $request): ?>
                    <tr>
                        <td>
                            <span class="table-title"><?php echo html_escape($request['booking_code']); ?></span>
                            <span class="table-note">Uploaded <?php echo !empty($request['created_at']) ? date('d M Y', strtotime($request['created_at'])) : '-'; ?></span>
                        </td>
                        <td>
                            <span class="table-title"><?php echo html_escape($request['vehicle_name']); ?></span>
                            <span class="table-note"><?php echo html_escape($request['registration_no']); ?></span>
                        </td>
                        <td><span class="pill"><?php echo ucwords(str_replace('_', ' ', html_escape($request['payment_type']))); ?></span></td>
                        <td>
                            <span class="table-title">&#8377;<?php echo number_format((float) $request['amount'], 2); ?></span>
                            <span class="table-note"><?php echo html_escape($request['payment_mode']); ?></span>
                        </td>
                        <td>
                            <a class="btn-secondary" href="<?php echo base_url($request['receipt_path']); ?>" target="_blank">Open Receipt</a>
                        </td>
                        <td><span class="badge badge-<?php echo html_escape($request['status']); ?>"><?php echo html_escape($request['status']); ?></span></td>
                        <td>
                            <span class="table-note"><?php echo !empty($request['admin_notes']) ? html_escape($request['admin_notes']) : 'No admin note yet'; ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">
                        <div class="empty-state">You have not uploaded any payment receipt yet.</div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
