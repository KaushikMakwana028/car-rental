<?php $this->load->view('admin/partials/header'); ?>
<div class="section-card">
    <div class="card-head">
        <div>
            <h3>Create Booking</h3>
            <p>Assign a customer, select an available vehicle and confirm the rental details.</p>
        </div>
    </div>
    <form method="post" action="<?php echo base_url('admin/bookings/store'); ?>">
        <div class="form-grid">
            <div>
                <label>Customer</label>
                <select name="customer_id" required>
                    <option value="">Select customer</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?php echo $customer['id']; ?>"><?php echo html_escape($customer['full_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Vehicle</label>
                <select name="vehicle_id" id="admin_vehicle_id" required>
                    <option value="">Select vehicle</option>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <option value="<?php echo $vehicle['id']; ?>" data-rate="<?php echo (float) $vehicle['rate_per_day']; ?>"><?php echo html_escape($vehicle['name'] . ' - ' . $vehicle['registration_no'] . ' - Rate/KM: ' . number_format((float) $vehicle['rate_per_day'], 2)); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div><label>Pickup Date</label><input type="date" name="pickup_date" required></div>
            <div><label>Return Date</label><input type="date" name="return_date" required></div>
            <div><label>Pickup Location</label><input type="text" name="pickup_location" required></div>
            <div><label>Drop Location</label><input type="text" name="drop_location" required></div>
            <div><label>Estimated KM</label><input type="number" name="estimated_km" id="admin_estimated_km" min="0" required></div>
            <div>
                <label>Expected Amount</label>
                <input type="number" step="0.01" name="amount" id="admin_expected_amount" readonly required>
                <div class="helper">This amount is auto-calculated from Estimated KM × Rate per KM.</div>
            </div>
            <div class="full">
                <label>Status</label>
                <select name="status">
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                </select>
                <div class="helper">Choose the current lifecycle stage for this reservation.</div>
            </div>
        </div>
        <p style="margin-top:18px;"><button class="btn" type="submit">Save Booking</button></p>
    </form>
</div>
<script>
    (function () {
        var vehicle = document.getElementById('admin_vehicle_id');
        var km = document.getElementById('admin_estimated_km');
        var amount = document.getElementById('admin_expected_amount');

        function updateAmount() {
            var selected = vehicle.options[vehicle.selectedIndex];
            var rate = selected ? parseFloat(selected.getAttribute('data-rate') || '0') : 0;
            var distance = parseFloat(km.value || '0');
            var total = rate * distance;
            amount.value = total ? total.toFixed(2) : '';
        }

        vehicle.addEventListener('change', updateAmount);
        km.addEventListener('input', updateAmount);
    })();
</script>
<?php $this->load->view('admin/partials/footer'); ?>
