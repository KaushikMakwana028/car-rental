<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $selected_vehicle_id = isset($selected_vehicle_id) ? (int) $selected_vehicle_id : 0; ?>
<?php $current_step = isset($current_step) ? (int) $current_step : 1; ?>
<?php $booking_edit = !empty($booking_edit) ? $booking_edit : array(); ?>

<style>
    .step-shell {
        padding: 20px 24px;
    }

    .stepper {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .step-item {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .step-badge {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        border: 1px solid rgba(35, 94, 167, .18);
        background: #fff;
        color: var(--muted);
    }

    .step-item.active .step-badge,
    .step-item.done .step-badge {
        background: linear-gradient(135deg, var(--accent) 0%, #f1c14f 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 8px 18px rgba(35, 94, 167, .18);
    }

    .step-label {
        color: var(--muted);
        font-weight: 700;
    }

    .step-item.active .step-label,
    .step-item.done .step-label {
        color: var(--ink);
    }

    .step-line {
        width: 42px;
        height: 2px;
        border-radius: 999px;
        background: rgba(35, 94, 167, .14);
    }

    .step-line.done {
        background: linear-gradient(90deg, var(--accent) 0%, #f1c14f 100%);
    }

    .booking-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 6px;
    }

    .booking-actions .btn,
    .booking-actions .btn-secondary {
        min-width: 156px;
    }
</style>

<section class="section-card step-shell">
    <div class="stepper">
        <?php
        $steps = array(
            1 => 'Booking',
            2 => 'Document',
            3 => 'Payment',
        );
        foreach ($steps as $step_no => $step_label):
            $is_active = $current_step === $step_no;
            $is_done = $current_step > $step_no;
        ?>
            <div class="step-item <?php echo $is_active ? 'active' : ''; ?> <?php echo $is_done ? 'done' : ''; ?>">
                <div class="step-badge">
                    <?php echo $is_done ? '&#10003;' : $step_no; ?>
                </div>
                <div class="step-label">
                    <?php echo html_escape($step_label); ?>
                </div>
            </div>
            <?php if ($step_no < 3): ?>
                <div class="step-line <?php echo $current_step > $step_no ? 'done' : ''; ?>"></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<div class="split-grid">
    <section class="section-card">
        <div class="card-head">
            <div>
                <div class="eyebrow">Booking Form</div>
                <h3>Enter customer and trip details.</h3>
                <p>Start the booking with mobile number and name, then continue to document upload.</p>
            </div>
        </div>
        <form method="post" action="<?php echo base_url('customer/bookings/store'); ?>">
            <input type="hidden" name="booking_id" value="<?php echo !empty($booking_edit['id']) ? (int) $booking_edit['id'] : 0; ?>">
            <input type="hidden" name="customer_id" value="<?php echo !empty($booking_edit['customer_id']) ? (int) $booking_edit['customer_id'] : 0; ?>">
            <div class="form-grid">
                <div>
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" placeholder="Enter your name" value="<?php echo !empty($booking_edit['customer_name']) ? html_escape($booking_edit['customer_name']) : ''; ?>" required>
                </div>
                <div>
                    <label>Mobile Number</label>
                    <input type="text" name="customer_phone" placeholder="Enter your mobile number" value="<?php echo !empty($booking_edit['customer_phone']) ? html_escape($booking_edit['customer_phone']) : ''; ?>" required>
                </div>
                <div class="full">
                    <label>Vehicle</label>
                    <select name="vehicle_id" id="vehicle_id" required>
                        <option value="">Select vehicle</option>
                        <?php foreach ($vehicles as $vehicle): ?>
                            <option value="<?php echo (int) $vehicle['id']; ?>" data-rate="<?php echo (float) $vehicle['rate_per_day']; ?>" data-advance="<?php echo (float) $vehicle['advance_amount']; ?>" <?php echo ((int) $vehicle['id'] === $selected_vehicle_id) ? 'selected' : ''; ?>>
                                <?php echo html_escape($vehicle['name'] . ' | ' . $vehicle['registration_no'] . ' | Rate/KM ' . number_format((float) $vehicle['rate_per_day'], 2) . ' | Advance ' . number_format((float) $vehicle['advance_amount'], 2)); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Pickup Date</label>
                    <input type="date" name="pickup_date" value="<?php echo !empty($booking_edit['pickup_date']) ? html_escape($booking_edit['pickup_date']) : ''; ?>" required>
                </div>
                <div>
                    <label>Return Date</label>
                    <input type="date" name="return_date" value="<?php echo !empty($booking_edit['return_date']) ? html_escape($booking_edit['return_date']) : ''; ?>" required>
                </div>
                <div>
                    <label>Pickup Location</label>
                    <input type="text" name="pickup_location" placeholder="Enter pickup location" value="<?php echo !empty($booking_edit['pickup_location']) ? html_escape($booking_edit['pickup_location']) : ''; ?>" required>
                </div>
                <div>
                    <label>Drop Location</label>
                    <input type="text" name="drop_location" placeholder="Enter drop location" value="<?php echo !empty($booking_edit['drop_location']) ? html_escape($booking_edit['drop_location']) : ''; ?>" required>
                </div>
                <div>
                    <label>Estimated KM</label>
                    <input type="number" name="estimated_km" id="estimated_km" min="0" placeholder="Enter expected distance" value="<?php echo isset($booking_edit['estimated_km']) ? (int) $booking_edit['estimated_km'] : ''; ?>" required>
                </div>
                <div>
                    <label>Expected Amount</label>
                    <input type="number" step="0.01" id="expected_amount" readonly required>
                    <div class="helper">Auto-calculated from Estimated KM x Rate per KM.</div>
                </div>
                <div>
                    <label>Advance Payment</label>
                    <input type="text" id="required_advance" readonly>
                    <div class="helper">This amount will be paid on the next page.</div>
                </div>
            </div>
            <div class="booking-actions">
                <button class="btn" type="submit">Continue</button>
                <a class="btn-secondary" href="<?php echo base_url('customer/dashboard'); ?>">Back to Home</a>
            </div>
        </form>
    </section>

    <aside class="section-card accent-card">
        <div class="eyebrow">Next Steps</div>
        <div class="card-head">
            <div>
                <h3>Booking first, then document, then payment.</h3>
                <p>This page is step 1. After saving the booking, the next page opens for document upload and then payment.</p>
            </div>
        </div>
        <div class="info-grid" style="grid-template-columns:1fr;">
            <div class="feature-card">
                <strong>1. Booking</strong>
                <span>Name, mobile number, dates, locations, and selected car are saved first.</span>
            </div>
            <div class="feature-card">
                <strong>2. Document</strong>
                <span>Upload Aadhaar Card and Driving License as image or PDF files.</span>
            </div>
            <div class="feature-card">
                <strong>3. Payment</strong>
                <span>Upload the advance receipt and your booking request will be completed.</span>
            </div>
        </div>
    </aside>
</div>

<script>
    (function () {
        var vehicle = document.getElementById('vehicle_id');
        var km = document.getElementById('estimated_km');
        var amount = document.getElementById('expected_amount');
        var advance = document.getElementById('required_advance');

        function updateAmount() {
            var selected = vehicle.options[vehicle.selectedIndex];
            var rate = selected ? parseFloat(selected.getAttribute('data-rate') || '0') : 0;
            var advanceAmount = selected ? parseFloat(selected.getAttribute('data-advance') || '0') : 0;
            var distance = parseFloat(km.value || '0');
            var total = rate * distance;
            amount.value = total ? total.toFixed(2) : '';
            advance.value = advanceAmount ? 'Rs. ' + advanceAmount.toFixed(2) : '';
        }

        vehicle.addEventListener('change', updateAmount);
        km.addEventListener('input', updateAmount);
        updateAmount();
    })();
</script>
