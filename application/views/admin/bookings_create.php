<style>
    /* Select2 Full Width */
    .select2-container {
        width: 100% !important;
    }

    /* Main Select Box */
    .select2-container--default .select2-selection--single {
        height: 50px !important;
        border: 1px solid #dcdfe6 !important;
        border-radius: 10px !important;
        padding: 10px 12px !important;
        display: flex !important;
        align-items: center !important;
        background: #fff !important;
        font-size: 14px !important;
        box-shadow: none !important;
    }

    /* Selected Text */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        padding-left: 0 !important;
        color: #333 !important;
    }

    /* Arrow Position */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px !important;
        right: 10px !important;
    }

    /* Dropdown */
    .select2-dropdown {
        border-radius: 10px !important;
        border: 1px solid #dcdfe6 !important;
        overflow: hidden;
    }

    /* Search Input */
    .select2-search__field {
        border-radius: 8px !important;
        padding: 8px !important;
    }

    /* Hover Option */
    .select2-results__option--highlighted {
        background: #4f46e5 !important;
        color: #fff !important;
    }

    /* Focus Border */
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #4f46e5 !important;
    }
</style>

<div class="section-card">
    <div class="card-head">
        <div>
            <h3>Create Booking</h3>
            <p>Enter walk-in customer details, select an available vehicle and confirm the rental details.</p>
        </div>
    </div>
    <form method="post" action="<?php echo base_url('admin/bookings/store'); ?>">
        <div class="form-grid">
            <div>
                <label>Customer Name</label>
                <input type="text" name="customer_name" placeholder="Enter customer name" required>
            </div>
            <div>
                <label>Customer Phone</label>
                <input type="text" name="customer_phone" placeholder="Enter customer phone" required>
            </div>
            <div class="full">
                <label>Customer Email</label>
                <input type="email" name="customer_email" placeholder="Optional email for the customer">
                <div class="helper">If this phone or email already exists, the system will reuse that customer automatically.</div>
            </div>
            <div>
                <label>Aadhaar Number</label>
                <input type="text" name="aadhaar_number" placeholder="Enter Aadhaar number">
            </div>
            <div>
                <label>Driving License Number</label>
                <input type="text" name="driving_license_number" placeholder="Enter license number">
            </div>
            <div class="full">
                <label style="display:flex;align-items:center;gap:10px;text-transform:none;letter-spacing:0;font-size:14px;">
                    <input type="checkbox" name="documents_verified" value="1" style="width:auto;min-height:auto;">
                    Documents checked by admin
                </label>
                <div class="helper">Check this when documents are already verified manually. No document image upload is needed from admin side.</div>
            </div>
            <div>
                <label>Vehicle</label>


                <select name="vehicle_id" id="admin_vehicle_id" required style="width:100%;">
                    <option value="">Select vehicle</option>

                    <?php foreach ($vehicles as $vehicle): ?>
                        <option
                            value="<?php echo $vehicle['id']; ?>"
                            data-rate="<?php echo (float) $vehicle['rate_per_day']; ?>"
                            data-advance="<?php echo (float) $vehicle['advance_amount']; ?>">
                            <?php echo html_escape(
                                $vehicle['name'] . ' - ' .
                                    $vehicle['registration_no'] .
                                    ' - Rate/KM: ' . number_format((float) $vehicle['rate_per_day'], 2) .
                                    ' - Advance: ' . number_format((float) $vehicle['advance_amount'], 2)
                            ); ?>
                        </option>
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
            <div>
                <label>Required Advance</label>
                <input type="text" id="admin_advance_amount" readonly>
                <div class="helper">Shows the advance amount for the selected vehicle.</div>
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

        // Searchable dropdown
        $('#admin_vehicle_id').select2({
            placeholder: "Search vehicle...",
            allowClear: true,
            width: '100%'
        });

        var vehicle = document.getElementById('admin_vehicle_id');
        var km = document.getElementById('admin_estimated_km');
        var amount = document.getElementById('admin_expected_amount');
        var advance = document.getElementById('admin_advance_amount');

        function updateAmount() {

            var selected = vehicle.options[vehicle.selectedIndex];

            var rate = selected ? parseFloat(selected.getAttribute('data-rate') || '0') : 0;

            var advanceAmount = selected ? parseFloat(selected.getAttribute('data-advance') || '0') : 0;

            var distance = parseFloat(km.value || '0');

            var total = rate * distance;

            amount.value = total ? total.toFixed(2) : '';

            advance.value = advanceAmount ? 'Rs. ' + advanceAmount.toFixed(2) : '';
        }

        $('#admin_vehicle_id').on('change', updateAmount);

        km.addEventListener('input', updateAmount);

    });
</script>