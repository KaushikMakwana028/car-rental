<?php $this->load->view('customer/partials/header'); ?>
<style>
    .vehicle-photo{
        height:170px;margin-bottom:18px;border-radius:22px;overflow:hidden;border:1px solid #dcecf4;
        background:linear-gradient(135deg,#dff4ff,#edf8f2);display:flex;align-items:center;justify-content:center
    }
    .vehicle-photo img{width:100%;height:100%;object-fit:cover;display:block}
</style>
<div class="section-card">
    <div class="card-head">
        <div>
            <h3>Available Vehicles</h3>
            <p>Compare your options quickly and continue straight to the booking request form.</p>
        </div>
        <a class="btn-secondary" href="<?php echo base_url('customer/bookings'); ?>">View My Bookings</a>
    </div>
    <?php if (!empty($vehicles)): ?>
        <div class="vehicle-grid">
            <?php foreach ($vehicles as $vehicle): ?>
                <div class="vehicle-card">
                    <div class="vehicle-photo">
                        <img src="<?php echo app_vehicle_image_url(isset($vehicle['image']) ? $vehicle['image'] : ''); ?>" alt="<?php echo html_escape($vehicle['name']); ?>">
                    </div>
                    <h3><?php echo html_escape($vehicle['name']); ?></h3>
                    <div class="vehicle-meta"><?php echo html_escape($vehicle['registration_no']); ?></div>
                    <div class="spec-row"><span>Type</span><strong><?php echo html_escape($vehicle['vehicle_type']); ?></strong></div>
                    <div class="spec-row"><span>Fuel</span><strong><?php echo html_escape($vehicle['fuel_type']); ?></strong></div>
                    <div class="spec-row"><span>Seats</span><strong><?php echo (int) $vehicle['seats']; ?></strong></div>
                    <div class="spec-row"><span>Rate/KM</span><strong><?php echo number_format((float) $vehicle['rate_per_day'], 2); ?></strong></div>
                    <div class="spec-row"><span>Required Advance</span><strong><?php echo number_format((float) $vehicle['advance_amount'], 2); ?></strong></div>
                    <div style="margin-top:16px;"><a class="btn" href="<?php echo base_url('customer/bookings/create?vehicle_id=' . (int) $vehicle['id']); ?>">Book Now</a></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">No vehicles are available right now. Please check back later or contact the admin team.</div>
    <?php endif; ?>
</div>
<?php $this->load->view('customer/partials/footer'); ?>
