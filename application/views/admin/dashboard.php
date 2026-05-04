<?php $this->load->view('admin/partials/header'); ?>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Total Users</div>
            <div class="stat-chip">Live</div>
        </div>
        <div class="stat-value"><?php echo $stats['total_customers']; ?></div>
        <div class="stat-note">Registered customers available for booking.</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Fleet Size</div>
            <div class="stat-chip">Cars</div>
        </div>
        <div class="stat-value"><?php echo $stats['total_vehicles']; ?></div>
        <div class="stat-note">Total vehicles currently listed in the system.</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Available</div>
            <div class="stat-chip">Ready</div>
        </div>
        <div class="stat-value"><?php echo $stats['available_vehicles']; ?></div>
        <div class="stat-note">Vehicles ready to accept new bookings today.</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Pending</div>
            <div class="stat-chip">Attention</div>
        </div>
        <div class="stat-value"><?php echo $stats['pending_bookings']; ?></div>
        <div class="stat-note">Reservations waiting for confirmation or follow-up.</div>
    </div>
</div>

<div class="split-grid">
    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>Recent Bookings</h3>
                <p>Latest reservations coming in from users and admin staff.</p>
            </div>
            <a class="btn-secondary" href="<?php echo base_url('admin/bookings'); ?>">View All</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Trip</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_bookings)): foreach ($recent_bookings as $booking): ?>
                            <tr>
                                <td><?php echo html_escape($booking['booking_code']); ?></td>
                                <td><?php echo html_escape($booking['customer_name']); ?></td>
                                <td><?php echo html_escape($booking['vehicle_name']); ?></td>
                                <td><?php echo html_escape($booking['trip_label']); ?></td>
                                <td><span class="badge badge-<?php echo html_escape($booking['status']); ?>"><?php echo html_escape($booking['status']); ?></span></td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="5">No bookings found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>Quick Actions</h3>
                <p>Jump straight into the most common admin tasks.</p>
            </div>
        </div>
        <div class="mini-list">
            <div class="mini-item"><strong>Create a booking</strong><span>Add a reservation for a walk-in or phone customer.</span></div>
            <div class="mini-item"><strong>Add vehicle</strong><span>Expand your fleet and keep rates up to date.</span></div>
            <div class="mini-item"><strong>Review pending trips</strong><span>Confirm bookings waiting for approval.</span></div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>