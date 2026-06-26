<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$my_total = count($bookings);
$my_pending = 0;
$my_confirmed = 0;
$my_spend = 0;
$document_gate = $this->General_model->get_required_documents_status((int) $current_user['id']);

foreach ($bookings as $booking) {
    $booking_status = !empty($booking['effective_status']) ? $booking['effective_status'] : $booking['status'];
    $my_spend += (float) $booking['amount'];
    if ($booking_status === 'pending') {
        $my_pending++;
    }
    if ($booking_status === 'confirmed' || $booking_status === 'completed') {
        $my_confirmed++;
    }
}
?>

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-label">Total Bookings</span>
        <span class="stat-value"><?php echo $my_total; ?></span>
        <span class="stat-note">Every ride request linked to your customer account appears here.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Pending</span>
        <span class="stat-value"><?php echo $my_pending; ?></span>
        <span class="stat-note">Trips waiting for final review or approval from the admin team.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Confirmed</span>
        <span class="stat-value"><?php echo $my_confirmed; ?></span>
        <span class="stat-note">Bookings already accepted or completed successfully.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Estimated Total</span>
        <span class="stat-value">&#8377;<?php echo number_format($my_spend, 0); ?></span>
        <span class="stat-note">Combined estimated booking value across your trip history.</span>
    </div>
</div>

<section class="section-card">
    <div class="card-head">
        <div>
            <div class="eyebrow">Ride History</div>
            <h3>My bookings at a glance.</h3>
            <p>Booking IDs, trip type, route, payment progress, and current status are laid out in one cleaner table view.</p>
        </div>
        <?php if (!empty($document_gate['is_ready'])): ?>
            <a class="btn" href="<?php echo base_url('bookings/create'); ?>">Create Booking</a>
        <?php else: ?>
            <a class="btn" href="<?php echo base_url('documents'); ?>">Complete Documents</a>
        <?php endif; ?>
    </div>

    <?php if (empty($document_gate['is_ready'])): ?>
        <div class="flash flash-error" style="margin-bottom:20px;">
            Booking is disabled until the admin approves your required documents.
        </div>
    <?php endif; ?>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Booking</th>
                    <th>Vehicle</th>
                    <th>Trip Type</th>
                    <th>Route</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $booking): ?>
                    <?php $booking_status = !empty($booking['effective_status']) ? $booking['effective_status'] : $booking['status']; ?>
                    <tr>
                        <td>
                            <span class="table-title"><?php echo html_escape($booking['booking_code']); ?></span>
                            <span class="table-note">Created <?php echo !empty($booking['created_at']) ? date('d M Y', strtotime($booking['created_at'])) : '-'; ?></span>
                        </td>
                        <td>
                            <span class="table-title"><?php echo html_escape($booking['vehicle_name']); ?></span>
                            <span class="table-note"><?php echo html_escape($booking['registration_no']); ?></span>
                        </td>
                        <td>
                            <span class="pill"><?php echo html_escape($booking['trip_mode_label']); ?></span>
                            <span class="table-note"><?php echo html_escape($booking['trip_label']); ?></span>
                        </td>
                        <td>
                            <span class="table-title"><?php echo html_escape($booking['pickup_location']); ?></span>
                            <span class="table-note">Drop: <?php echo html_escape($booking['drop_location']); ?></span>
                        </td>

                        <td>
                            <span class="table-title">&#8377;<?php echo number_format((float) $booking['amount'], 2); ?></span>
                        </td>
                        <td><span class="badge badge-<?php echo html_escape($booking_status); ?>"><?php echo html_escape(ucfirst($booking_status)); ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">
                        <div class="empty-state">You have not created any bookings yet. Start by choosing a car and submitting your trip details.</div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
