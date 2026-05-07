<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$available_count = !empty($vehicles) ? count($vehicles) : 0;
$seat_capacity = 0;
$document_gate = isset($document_gate) ? $document_gate : array('is_ready' => false, 'overall_status' => 'missing');
foreach ($vehicles as $vehicle) {
    $seat_capacity += (int) $vehicle['seats'];
}
?>

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-label">Fleet Count</span>
        <span class="stat-value"><?php echo $available_count; ?></span>
        <span class="stat-note">Active vehicle options ready for customer bookings.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Seat Capacity</span>
        <span class="stat-value"><?php echo $seat_capacity; ?></span>
        <span class="stat-note">Combined seating across the current visible fleet selection.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Flexible Use</span>
        <span class="stat-value">City</span>
        <span class="stat-note">Suitable for local rides, airport transfers, and outstation travel needs.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Next Step</span>
        <span class="stat-value">Book</span>
        <span class="stat-note">Every vehicle card takes the customer directly into the booking form.</span>
    </div>
</div>

<section class="section-card">
    <div class="card-head">
        <div>
            <div class="eyebrow">Fleet Showcase</div>
            <h3>Choose the car that fits the trip.</h3>
            <p>Vehicle cards are now cleaner, image-led, and easier to scan on mobile screens without losing the important pricing details.</p>
        </div>
        <a class="btn-secondary" href="<?php echo base_url('bookings'); ?>">View My Bookings</a>
    </div>

    <?php if (empty($document_gate['is_ready'])): ?>
        <div class="flash flash-error" style="margin-bottom:20px;">
            Booking is available after admin approves all required documents.
            <?php if (!empty($document_gate['pending_documents'])): ?>
                Waiting for approval: <?php echo html_escape(implode(', ', $document_gate['pending_documents'])); ?>.
            <?php endif; ?>
            <?php if (!empty($document_gate['missing_documents'])): ?>
                Upload: <?php echo html_escape(implode(', ', $document_gate['missing_documents'])); ?>.
            <?php endif; ?>
            <?php if (!empty($document_gate['rejected_documents'])): ?>
                Re-upload: <?php echo html_escape(implode(', ', $document_gate['rejected_documents'])); ?>.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($vehicles)): ?>
        <div class="vehicle-grid">
            <?php foreach ($vehicles as $vehicle): ?>
                <article class="vehicle-card">
                    <?php $vehicle_image = isset($vehicle['image']) ? trim($vehicle['image']) : ''; ?>
                    <div class="vehicle-media<?php echo $vehicle_image !== '' ? '' : ' vehicle-media-empty'; ?>">
                        <?php if ($vehicle_image !== ''): ?>
                            <img src="<?php echo app_vehicle_image_url($vehicle_image); ?>" alt="<?php echo html_escape($vehicle['name']); ?>">
                        <?php else: ?>
                            <div class="vehicle-empty-badge"><?php echo html_escape(strtoupper(substr($vehicle['name'], 0, 1))); ?></div>
                            <div class="vehicle-empty-copy">Add a real vehicle image in admin to show this card perfectly.</div>
                        <?php endif; ?>
                    </div>
                    <div class="vehicle-body">
                        <h3><?php echo html_escape($vehicle['name']); ?></h3>
                        <div class="vehicle-meta"><?php echo html_escape($vehicle['registration_no']); ?></div>
                        <div class="spec-list">
                            <div class="spec-row"><span>Type</span><strong><?php echo html_escape($vehicle['vehicle_type']); ?></strong></div>
                            <div class="spec-row"><span>Fuel</span><strong><?php echo html_escape($vehicle['fuel_type']); ?></strong></div>
                            <div class="spec-row"><span>Seats</span><strong><?php echo (int) $vehicle['seats']; ?></strong></div>
                            <div class="spec-row"><span>Rate / KM</span><strong>&#8377;<?php echo number_format((float) $vehicle['rate_per_day'], 2); ?></strong></div>
                            <div class="spec-row"><span>Advance</span><strong>&#8377;<?php echo number_format((float) $vehicle['advance_amount'], 2); ?></strong></div>
                        </div>
                        <?php if (!empty($document_gate['is_ready'])): ?>
                            <a class="btn" href="<?php echo base_url('bookings/create?vehicle_id=' . (int) $vehicle['id']); ?>">Book Now</a>
                        <?php else: ?>
                            <a class="btn" href="<?php echo base_url('documents'); ?>">Complete Documents</a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">No vehicles are available right now. Please check again later for fresh fleet availability.</div>
    <?php endif; ?>
</section>
