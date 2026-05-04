<?php $this->load->view('customer/partials/header'); ?>
<style>
    .dashboard-vehicle-photo{
        height:160px;margin-bottom:18px;border-radius:22px;overflow:hidden;border:1px solid #dcecf4;
        background:linear-gradient(135deg,#dff4ff,#edf8f2);display:flex;align-items:center;justify-content:center
    }
    .dashboard-vehicle-photo img{width:100%;height:100%;object-fit:cover;display:block}
</style>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-top"><div class="stat-label">My Bookings</div><div class="stat-chip">Trips</div></div>
        <div class="stat-value"><?php echo $stats['my_bookings']; ?></div>
        <div class="stat-note">Reservations linked to your account.</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><div class="stat-label">Pending</div><div class="stat-chip">Review</div></div>
        <div class="stat-value"><?php echo $stats['my_pending_bookings']; ?></div>
        <div class="stat-note">Requests still waiting for admin confirmation.</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><div class="stat-label">Available</div><div class="stat-chip">Open</div></div>
        <div class="stat-value"><?php echo $stats['available_vehicles']; ?></div>
        <div class="stat-note">Vehicles you can request right now.</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><div class="stat-label">Fleet</div><div class="stat-chip">All Cars</div></div>
        <div class="stat-value"><?php echo $stats['total_vehicles']; ?></div>
        <div class="stat-note">Total vehicles currently managed by DriveEase.</div>
    </div>
</div>

<div class="split-grid">
    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>My Recent Bookings</h3>
                <p>A quick look at your latest requests, trip dates and current status.</p>
            </div>
            <a class="btn-secondary" href="<?php echo base_url('customer/bookings'); ?>">See All</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Booking ID</th><th>Vehicle</th><th>Trip</th><th>Status</th><th>Amount</th></tr></thead>
                <tbody>
                <?php if (!empty($my_bookings)): foreach ($my_bookings as $booking): ?>
                    <tr>
                        <td><?php echo html_escape($booking['booking_code']); ?></td>
                        <td><?php echo html_escape($booking['vehicle_name']); ?></td>
                        <td><?php echo html_escape($booking['trip_label']); ?></td>
                        <td><span class="badge badge-<?php echo html_escape($booking['status']); ?>"><?php echo html_escape($booking['status']); ?></span></td>
                        <td><?php echo number_format((float) $booking['amount'], 2); ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5">No bookings found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>Booking Tips</h3>
                <p>Simple things to keep your next reservation smooth.</p>
            </div>
        </div>
        <div class="mini-list">
            <div class="mini-item"><strong>Book early</strong><span>Popular vehicles get reserved quickly on weekends and holidays.</span></div>
            <div class="mini-item"><strong>Check pickup time</strong><span>Set clear travel times to help admins confirm your request faster.</span></div>
            <div class="mini-item"><strong>Review fare estimate</strong><span>Rates and trip distance both affect your final payable amount.</span></div>
        </div>
    </div>
</div>

<div class="section-card">
    <div class="card-head">
        <div>
            <h3>Available Vehicles</h3>
            <p>Browse a few ready-to-book vehicles from the current active fleet.</p>
        </div>
        <a class="btn" href="<?php echo base_url('customer/vehicles'); ?>">Explore Fleet</a>
    </div>
    <div class="vehicle-grid">
        <?php foreach ($vehicles as $vehicle): ?>
            <div class="vehicle-card">
                <div class="dashboard-vehicle-photo">
                    <img src="<?php echo app_vehicle_image_url(isset($vehicle['image']) ? $vehicle['image'] : ''); ?>" alt="<?php echo html_escape($vehicle['name']); ?>">
                </div>
                <h3><?php echo html_escape($vehicle['name']); ?></h3>
                <div class="vehicle-meta"><?php echo html_escape($vehicle['vehicle_type']); ?> | <?php echo html_escape($vehicle['fuel_type']); ?></div>
                <div class="spec-row"><span>Seats</span><strong><?php echo (int) $vehicle['seats']; ?></strong></div>
                <div class="spec-row"><span>Rate per KM</span><strong><?php echo number_format((float) $vehicle['rate_per_day'], 2); ?></strong></div>
                <div class="spec-row"><span>Required advance</span><strong><?php echo number_format((float) $vehicle['advance_amount'], 2); ?></strong></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php $this->load->view('customer/partials/footer'); ?>
