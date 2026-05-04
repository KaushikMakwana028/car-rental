<?php $this->load->view('customer/partials/header'); ?>
<style>
    .booking-highlight-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px;margin-bottom:22px}
    .booking-highlight-card{
        padding:20px;border-radius:20px;border:1px solid #d8eeea;background:linear-gradient(180deg,#ffffff 0%,#fbfefd 100%);
        box-shadow:0 12px 30px rgba(15,23,42,.05)
    }
    .booking-highlight-card span{display:block;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#0f766e}
    .booking-highlight-card strong{display:block;font-size:30px;line-height:1;margin:12px 0 8px}
    .booking-highlight-card p{margin:0;color:#64748b;font-size:14px}
    .booking-code{font-weight:800;color:#0f172a}
    .booking-subline{display:block;margin-top:6px;color:#64748b;font-size:13px;line-height:1.45}
    .trip-pill{display:inline-flex;align-items:center;padding:8px 12px;border-radius:999px;background:#d9f7f3;color:#0f766e;font-size:12px;font-weight:700}
    .payment-chip{display:inline-flex;align-items:center;padding:8px 12px;border-radius:999px;font-size:12px;font-weight:700}
    .payment-chip.paid{background:#dcfce7;color:#15803d}
    .payment-chip.advance-received,.payment-chip.part-paid{background:#ffedd5;color:#c2410c}
    .payment-chip.pending{background:#fee2e2;color:#b91c1c}
    .table-wrap table{min-width:1040px}
    @media (max-width:1100px){.booking-highlight-grid{grid-template-columns:1fr 1fr}}
    @media (max-width:640px){.booking-highlight-grid{grid-template-columns:1fr}}
</style>
<?php
$my_total = count($bookings);
$my_pending = 0;
$my_spend = 0;

foreach ($bookings as $booking) {
    $my_spend += (float) $booking['amount'];
    if ($booking['status'] === 'pending') {
        $my_pending++;
    }
}
?>
<div class="booking-highlight-grid">
    <div class="booking-highlight-card">
        <span>Total Bookings</span>
        <strong><?php echo $my_total; ?></strong>
        <p>Every trip request linked to your customer account.</p>
    </div>
    <div class="booking-highlight-card">
        <span>Pending Requests</span>
        <strong><?php echo $my_pending; ?></strong>
        <p>Bookings that are still waiting for final admin approval.</p>
    </div>
    <div class="booking-highlight-card">
        <span>Estimated Total</span>
        <strong><?php echo number_format($my_spend, 2); ?></strong>
        <p>Your combined estimated booking value across all trips.</p>
    </div>
</div>

<div class="section-card">
    <div class="card-head">
        <div>
            <h3>My Bookings</h3>
            <p>Your custom booking ID, route, travel dates and payment progress are visible here and on the admin side too.</p>
        </div>
        <a class="btn" href="<?php echo base_url('customer/bookings/create'); ?>">New Booking</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Vehicle</th>
                    <th>Trip</th>
                    <th>Route</th>
                    <th>KM</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($bookings)): foreach ($bookings as $booking): ?>
                <tr>
                    <td>
                        <div class="booking-code"><?php echo html_escape($booking['booking_code']); ?></div>
                        <span class="booking-subline">Created <?php echo !empty($booking['created_at']) ? date('d M Y', strtotime($booking['created_at'])) : '-'; ?></span>
                    </td>
                    <td>
                        <strong><?php echo html_escape($booking['vehicle_name']); ?></strong>
                        <span class="booking-subline"><?php echo html_escape($booking['registration_no']); ?></span>
                    </td>
                    <td><span class="trip-pill"><?php echo html_escape($booking['trip_label']); ?></span></td>
                    <td>
                        <strong><?php echo html_escape($booking['pickup_location']); ?></strong>
                        <span class="booking-subline">Drop: <?php echo html_escape($booking['drop_location']); ?></span>
                    </td>
                    <td><?php echo html_escape($booking['display_km']); ?></td>
                    <td>
                        <strong><?php echo number_format((float) $booking['amount'], 2); ?></strong>
                        <span class="booking-subline">Balance <?php echo number_format((float) $booking['balance_amount'], 2); ?></span>
                    </td>
                    <td>
                        <span class="payment-chip <?php echo html_escape($booking['payment_badge']); ?>"><?php echo html_escape($booking['payment_status']); ?></span>
                        <span class="booking-subline">Paid <?php echo number_format((float) $booking['paid_amount'], 2); ?></span>
                    </td>
                    <td><span class="badge badge-<?php echo html_escape($booking['status']); ?>"><?php echo html_escape($booking['status']); ?></span></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="8">You have not created any bookings yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view('customer/partials/footer'); ?>
