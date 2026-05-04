<?php
$selected_vehicle_id = isset($selected_vehicle_id) ? (int) $selected_vehicle_id : 0;
?>
<?php $this->load->view('customer/partials/header'); ?>
<div class="section-card">
    <div class="card-head">
        <div>
            <h3>Book a Vehicle</h3>
            <p>Share your trip details clearly so the admin team can confirm your request quickly.</p>
        </div>
    </div>
    <form method="post" action="<?php echo base_url('customer/bookings/store'); ?>">
        <div class="form-grid">
            <div class="full">
                <label>Vehicle</label>
                <select name="vehicle_id" id="vehicle_id" required>
                    <option value="">Select vehicle</option>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <option value="<?php echo $vehicle['id']; ?>" data-rate="<?php echo (float) $vehicle['rate_per_day']; ?>" <?php echo ((int) $vehicle['id'] === $selected_vehicle_id) ? 'selected' : ''; ?>><?php echo html_escape($vehicle['name'] . ' - ' . $vehicle['registration_no'] . ' - Rate/KM: ' . number_format((float) $vehicle['rate_per_day'], 2) . ' - Advance: ' . number_format((float) $vehicle['advance_amount'], 2)); ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="helper">Vehicle options include both rate per KM and required advance amount.</div>
            </div>
            <div><label>Pickup Date</label><input type="date" name="pickup_date" required></div>
            <div><label>Return Date</label><input type="date" name="return_date" required></div>
            <div><label>Pickup Location</label><input type="text" name="pickup_location" required></div>
            <div><label>Drop Location</label><input type="text" name="drop_location" required></div>
            <div><label>Estimated KM</label><input type="number" name="estimated_km" id="estimated_km" min="0" required></div>
            <div>
                <label>Expected Amount</label>
                <input type="number" step="0.01" name="amount" id="expected_amount" readonly required>
                <div class="helper">This amount is auto-calculated from Estimated KM × Rate per KM.</div>
            </div>
        </div>
        <p style="margin-top:18px;"><button class="btn" type="submit">Submit Booking</button></p>
    </form>
</div>
<script>
    (function () {
        var vehicle = document.getElementById('vehicle_id');
        var km = document.getElementById('estimated_km');
        var amount = document.getElementById('expected_amount');

        function updateAmount() {
            var selected = vehicle.options[vehicle.selectedIndex];
            var rate = selected ? parseFloat(selected.getAttribute('data-rate') || '0') : 0;
            var distance = parseFloat(km.value || '0');
            var total = rate * distance;
            amount.value = total ? total.toFixed(2) : '';
        }

        vehicle.addEventListener('change', updateAmount);
        km.addEventListener('input', updateAmount);
        updateAmount();
    })();
</script>
<?php $this->load->view('customer/partials/footer'); ?>
