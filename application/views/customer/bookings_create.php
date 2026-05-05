<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $selected_vehicle_id = isset($selected_vehicle_id) ? (int) $selected_vehicle_id : 0; ?>
<?php
$document_gate = isset($document_gate) ? $document_gate : array(
    'is_ready' => false,
    'approved_count' => 0,
    'required_count' => 0,
    'missing_documents' => array(),
    'pending_documents' => array(),
    'rejected_documents' => array(),
);
?>

<div class="split-grid">
    <section class="section-card">
        <div class="card-head">
            <div>
                <div class="eyebrow">Booking Form</div>
                <h3>Share the trip details clearly.</h3>
                <p>The amount is calculated automatically from your selected vehicle rate and estimated travel distance.</p>
            </div>
        </div>

        <?php if (empty($document_gate['is_ready'])): ?>
            <div class="flash flash-error" style="margin-bottom:20px;">
                Booking is locked until the admin approves all 4 required documents.
            </div>
            <div class="info-grid" style="grid-template-columns:repeat(auto-fit,minmax(180px,1fr));margin-bottom:20px;">
                <div class="feature-card">
                    <strong>Approved</strong>
                    <span><?php echo (int) $document_gate['approved_count']; ?> of <?php echo (int) $document_gate['required_count']; ?> ready for booking.</span>
                </div>
                <div class="feature-card">
                    <strong>Pending Review</strong>
                    <span><?php echo !empty($document_gate['pending_documents']) ? html_escape(implode(', ', $document_gate['pending_documents'])) : 'None'; ?></span>
                </div>
                <div class="feature-card">
                    <strong>Missing / Re-upload</strong>
                    <span>
                        <?php
                        $remaining_documents = array_merge($document_gate['missing_documents'], $document_gate['rejected_documents']);
                        echo !empty($remaining_documents) ? html_escape(implode(', ', $remaining_documents)) : 'None';
                        ?>
                    </span>
                </div>
            </div>
            <div class="hero-actions">
                <a class="btn" href="<?php echo base_url('customer/documents'); ?>">Go To My Documents</a>
                <a class="btn-secondary" href="<?php echo base_url('customer/vehicles'); ?>">Back to Fleet</a>
            </div>
        <?php else: ?>
            <form method="post" action="<?php echo base_url('customer/bookings/store'); ?>">
                <div class="form-grid">
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
                        <div class="helper">Vehicle options include both the rate per KM and the required advance amount.</div>
                    </div>
                    <div>
                        <label>Pickup Date</label>
                        <input type="date" name="pickup_date" required>
                    </div>
                    <div>
                        <label>Return Date</label>
                        <input type="date" name="return_date" required>
                    </div>
                    <div>
                        <label>Pickup Location</label>
                        <input type="text" name="pickup_location" placeholder="Enter pickup location" required>
                    </div>
                    <div>
                        <label>Drop Location</label>
                        <input type="text" name="drop_location" placeholder="Enter drop location" required>
                    </div>
                    <div>
                        <label>Estimated KM</label>
                        <input type="number" name="estimated_km" id="estimated_km" min="0" placeholder="Enter expected distance" required>
                    </div>
                    <div>
                        <label>Expected Amount</label>
                        <input type="number" step="0.01" name="amount" id="expected_amount" readonly required>
                        <div class="helper">Auto-calculated from Estimated KM x Rate per KM.</div>
                    </div>
                    <div>
                        <label>Required Advance</label>
                        <input type="text" id="required_advance" readonly>
                        <div class="helper">Advance amount required for the selected vehicle.</div>
                    </div>
                </div>
                <div class="hero-actions">
                    <button class="btn" type="submit">Submit Booking</button>
                    <a class="btn-secondary" href="<?php echo base_url('customer/vehicles'); ?>">Back to Fleet</a>
                </div>
            </form>
        <?php endif; ?>
    </section>

    <aside class="section-card accent-card">
        <div class="eyebrow">Before You Submit</div>
        <div class="card-head">
            <div>
                <h3 style="color:#fff;">Fast approval starts with clear details.</h3>
                <p style="color:rgba(247,243,231,.72);">
                    <?php if (!empty($document_gate['is_ready'])): ?>
                        Use accurate dates, locations, and travel distance so the admin team can review your request without delays.
                    <?php else: ?>
                        Your booking form opens automatically after the required documents move from pending review to approved.
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="info-grid" style="grid-template-columns:1fr;">
            <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);">
                <strong style="color:#fff;">Document approval first</strong>
                <span style="color:rgba(247,243,231,.70);">Driving License, Aadhaar Card, Passport / Voter ID, and Passport Photo must all be approved.</span>
            </div>
            <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);">
                <strong style="color:#fff;">Pending means wait</strong>
                <span style="color:rgba(247,243,231,.70);">Uploaded files stay in review until the admin checks and approves them.</span>
            </div>
            <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);">
                <strong style="color:#fff;">Track it later</strong>
                <span style="color:rgba(247,243,231,.70);">After approval and booking, the request appears in My Bookings with payment and trip progress.</span>
            </div>
        </div>
    </aside>
</div>

<?php if (!empty($document_gate['is_ready'])): ?>
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
<?php endif; ?>
