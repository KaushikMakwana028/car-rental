<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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

    /* Extra charge notice above submit button */
    .extra-notice-banner {
        background: #fffbf0;
        border: 2px solid #f5c842;
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 14px;
    }

    .extra-notice-banner-title {
        font-size: 15px;
        font-weight: 800;
        color: #7a5c00;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .extra-notice-banner-title span.rate {
        font-size: 18px;
        font-weight: 900;
        color: #c47d00;
    }

    .extra-notice-banner-desc {
        font-size: 12px;
        color: #a07840;
        margin-top: 5px;
        line-height: 1.7;
    }
</style>

<!-- ── Stepper ── -->
<section class="section-card step-shell">
    <div class="stepper">
        <?php
        $steps = array(1 => 'Booking', 2 => 'Document', 3 => 'Payment');
        foreach ($steps as $step_no => $step_label):
            $is_active = $current_step === $step_no;
            $is_done   = $current_step > $step_no;
        ?>
            <div class="step-item <?php echo $is_active ? 'active' : ''; ?> <?php echo $is_done ? 'done' : ''; ?>">
                <div class="step-badge"><?php echo $is_done ? '&#10003;' : $step_no; ?></div>
                <div class="step-label"><?php echo html_escape($step_label); ?></div>
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
                <p>Fill in your details and choose your dates, then continue.</p>
            </div>
        </div>

        <form method="post" action="<?php echo base_url('bookings/store'); ?>">
            <input type="hidden" name="booking_id" value="<?php echo !empty($booking_edit['id'])          ? (int)$booking_edit['id']          : 0; ?>">
            <input type="hidden" name="customer_id" value="<?php echo !empty($booking_edit['customer_id']) ? (int)$booking_edit['customer_id'] : 0; ?>">

            <div class="form-grid">

                <!-- ── 1. Customer Name & Phone ── -->
                <div>
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" placeholder="Enter your name"
                        value="<?php echo !empty($booking_edit['customer_name']) ? html_escape($booking_edit['customer_name']) : ''; ?>" required>
                </div>
                <div>
                    <label>Mobile Number</label>
                    <input type="text" name="customer_phone" placeholder="Enter your mobile number"
                        value="<?php echo !empty($booking_edit['customer_phone']) ? html_escape($booking_edit['customer_phone']) : ''; ?>" required>
                </div>

                <!-- ── 2. Vehicle ── -->
                <div class="full">
                    <label>Vehicle</label>
                    <select name="vehicle_id" id="vehicle_id" required>
                        <option value="">Select vehicle</option>
                        <?php foreach ($vehicles as $v): ?>
                            <option
                                value="<?php echo (int)$v['id']; ?>"
                                data-rate-km="<?php echo (float)(isset($v['rate_per_day']) ? $v['rate_per_day'] : 0); ?>"
                                data-advance="<?php echo (float)$v['advance_amount']; ?>"
                                data-p6="<?php echo (float)(isset($v['price_6_hours'])        ? $v['price_6_hours']       : 0); ?>"
                                data-p12="<?php echo (float)(isset($v['price_12_hours'])      ? $v['price_12_hours']      : 0); ?>"
                                data-p24="<?php echo (float)(isset($v['price_24_hours'])      ? $v['price_24_hours']      : 0); ?>"
                                data-extra="<?php echo (float)(isset($v['extra_hour_charge']) ? $v['extra_hour_charge']   : 0); ?>"
                                <?php echo ((int)$v['id'] === $selected_vehicle_id) ? 'selected' : ''; ?>>
                                <?php echo html_escape($v['name'] . ' | ' . $v['registration_no']
                                    . ' | Adv ₹' . number_format((float)$v['advance_amount'], 0)); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label>Booking Type</label>
                    <?php $selected_booking_type = !empty($booking_edit['booking_type']) ? $booking_edit['booking_type'] : 'hours'; ?>
                    <select name="booking_type" id="booking_type" required>
                        <option value="hours" <?php echo $selected_booking_type === 'hours' ? 'selected' : ''; ?>>Hour Package</option>
                        <option value="km" <?php echo $selected_booking_type === 'km' ? 'selected' : ''; ?>>KM Basis</option>
                    </select>
                    <div class="helper">Choose <strong>Hour Package</strong> for fixed 6, 12, or 24 hour pricing, or choose <strong>KM Basis</strong> if you want the fare calculated by total kilometers.</div>
                </div>

                <div id="km_fields" style="display:none;">
                    <label>Estimated KM</label>
                    <input type="number" min="1" name="estimated_km" id="estimated_km"
                        value="<?php echo !empty($booking_edit['estimated_km']) ? (int)$booking_edit['estimated_km'] : ''; ?>"
                        placeholder="Enter expected distance">
                </div>

                <!-- ── 3. Pickup Date & Return Date ── -->
                <div>
                    <label>Pickup Date</label>
                    <input type="date" name="pickup_date" id="pickup_date"
                        value="<?php echo !empty($booking_edit['pickup_date']) ? html_escape($booking_edit['pickup_date']) : ''; ?>" required>
                </div>
                <div>
                    <label>Return Date</label>
                    <input type="date" name="return_date" id="return_date"
                        value="<?php echo !empty($booking_edit['return_date']) ? html_escape($booking_edit['return_date']) : ''; ?>" required>
                </div>

                <!-- ── 4. Pickup Time & Return Time ── -->
              <div id="pickup_time_wrap">
    <label>Pickup Time</label>

    <input 
        type="time"
        name="pickup_time"
        id="pickup_time"
        value="<?php echo !empty($booking_edit['pickup_time']) ? html_escape(date('H:i', strtotime($booking_edit['pickup_time']))) : ''; ?>"
        required
    >

    <div class="helper">Select pickup time.</div>
</div>

<div id="return_time_wrap">
    <label>Return Time</label>

    <input 
        type="time"
        name="return_time"
        id="return_time"
        value="<?php echo !empty($booking_edit['return_time']) ? html_escape(date('H:i', strtotime($booking_edit['return_time']))) : ''; ?>"
        required
    >

    <div class="helper">Select return time.</div>
</div>

                <!-- ── 5. Calculated Duration Box ── -->
                <div class="full" id="hours_duration_wrap">
                    <div id="hours_duration_box" style="background:#EEF3FA; border:1.5px solid #B5D4F4; border-radius:10px; padding:12px 16px; display:flex; align-items:center; justify-content:space-between; gap:12px;">
                        <div>
                            <div style="font-size:12px; font-weight:700; color:#185FA5; text-transform:uppercase; letter-spacing:.08em;">⏱ Calculated Duration</div>
                            <div style="font-size:11px; color:#456383; margin-top:2px;" id="hours_duration_note">Select pickup and return date &amp; time to calculate.</div>
                        </div>
                        <div style="text-align:right; flex-shrink:0;">
                            <div style="font-size:26px; font-weight:800; color:#17355C; line-height:1;" id="hours_duration_value">—</div>
                            <div style="font-size:11px; color:#73849A; margin-top:2px;">hours total</div>
                        </div>
                    </div>
                </div>

                <!-- ── 6. Select Duration & Package Price ── -->
                <div id="hours_fields">
                    <label>Select Duration</label>
                    <select id="hours_slot" name="hours_slot" required>
                        <option value="">-- Select slot --</option>
                        <option value="6" <?php echo (!empty($booking_edit['hours_slot']) && $booking_edit['hours_slot'] == 6)  ? 'selected' : ''; ?>>6 Hours</option>
                        <option value="12" <?php echo (!empty($booking_edit['hours_slot']) && $booking_edit['hours_slot'] == 12) ? 'selected' : ''; ?>>12 Hours</option>
                        <option value="24" <?php echo (!empty($booking_edit['hours_slot']) && $booking_edit['hours_slot'] == 24) ? 'selected' : ''; ?>>24 Hours</option>
                    </select>
                </div>

                <div id="expected_amount_wrap">
                    <label id="amount_label">Package Price</label>
                    <input type="number" step="0.01" id="expected_amount" name="expected_amount" readonly>
                    <div class="helper" id="amount_helper">Select a duration slot to see the package price.</div>
                </div>

                <!-- ── 7. Pickup Location & Drop Location ── -->
                <div>
                    <label>Pickup Location</label>
                    <input type="text" name="pickup_location" placeholder="Enter pickup location"
                        value="<?php echo !empty($booking_edit['pickup_location']) ? html_escape($booking_edit['pickup_location']) : ''; ?>" required>
                </div>
                <div>
                    <label>Drop Location</label>
                    <input type="text" name="drop_location" placeholder="Enter drop location"
                        value="<?php echo !empty($booking_edit['drop_location']) ? html_escape($booking_edit['drop_location']) : ''; ?>" required>
                </div>

                <!-- ── 8. Advance Payment ── -->
                <div>
                    <label>Advance Payment</label>
                    <?php $requires_advance = isset($booking_edit['requires_advance']) ? (int) $booking_edit['requires_advance'] : 0; ?>
                    <label style="display:flex;align-items:center;gap:10px;text-transform:none;letter-spacing:0;font-size:14px;margin-bottom:8px;">
                        <input type="checkbox" name="requires_advance" id="requires_advance" value="1" style="width:auto;min-height:auto;" <?php echo $requires_advance ? 'checked' : ''; ?>>
                        I want to pay advance for this booking
                    </label>
                    <input type="text" id="required_advance" name="required_advance_display" readonly>
                    <div class="helper" id="advance_helper">This amount will be paid on the next page only when advance payment is selected.</div>
                </div>

            </div><!-- /.form-grid -->

            <!-- ── Extra Charge Notice Banner — shown only when extra_hour_charge > 0 ── -->
            <div class="extra-notice-banner" id="extra_notice_banner" style="display:none;">
                <div class="extra-notice-banner-title">
                    ⚡ Extra Hour Charge: <span class="rate" id="notice_extra_val">₹0</span> / hr
                </div>
                <div class="extra-notice-banner-desc">
                    <strong>Important:</strong> If you return the vehicle after your booked slot ends, each additional hour will be charged at the rate shown above. Please plan your trip accordingly to avoid extra charges.
                </div>
            </div>

            <div class="booking-actions">
                <button class="btn" type="submit">Continue</button>
                <a class="btn-secondary" href="<?php echo base_url('dashboard'); ?>">Back to Home</a>
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
    (function() {

        var vehicleSel = document.getElementById('vehicle_id');
        var bookingTypeSel = document.getElementById('booking_type');
        var kmFields = document.getElementById('km_fields');
        var kmInput = document.getElementById('estimated_km');
        var hoursFields = document.getElementById('hours_fields');
        var pickupTimeWrap = document.getElementById('pickup_time_wrap');
        var returnTimeWrap = document.getElementById('return_time_wrap');
        var hoursDurationWrap = document.getElementById('hours_duration_wrap');
        var slotSel = document.getElementById('hours_slot');
        var amountInp = document.getElementById('expected_amount');
        var advanceInp = document.getElementById('required_advance');
        var requiresAdvanceChk = document.getElementById('requires_advance');
        var advanceHelper = document.getElementById('advance_helper');
        var amountLabel = document.getElementById('amount_label');
        var helperEl = document.getElementById('amount_helper');
        var pickupDate = document.getElementById('pickup_date');
        var returnDate = document.getElementById('return_date');
        var pickupTimeInp = document.getElementById('pickup_time');
        var returnTimeInp = document.getElementById('return_time');
        var hoursDurBox = document.getElementById('hours_duration_box');
        var hoursDurValue = document.getElementById('hours_duration_value');
        var hoursDurNote = document.getElementById('hours_duration_note');
        var extraBanner = document.getElementById('extra_notice_banner');
        var noticExtraVal = document.getElementById('notice_extra_val');

        /* ── Correct Indian rupee formatter using built-in toLocaleString ── */
        function fmt(n) {
            var num = parseFloat(n) || 0;
            return '₹' + num.toLocaleString('en-IN', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        function getVehicleData() {
            var opt = vehicleSel ? vehicleSel.options[vehicleSel.selectedIndex] : null;
            if (!opt || !opt.value) return null;
            return {
                rateKm: parseFloat(opt.getAttribute('data-rate-km') || '0'),
                advance: parseFloat(opt.getAttribute('data-advance') || '0'),
                p6: parseFloat(opt.getAttribute('data-p6') || '0'),
                p12: parseFloat(opt.getAttribute('data-p12') || '0'),
                p24: parseFloat(opt.getAttribute('data-p24') || '0'),
                extra: parseFloat(opt.getAttribute('data-extra') || '0')
            };
        }

        function isKmBooking() {
            return bookingTypeSel && bookingTypeSel.value === 'km';
        }

        function needsAdvance() {
            return requiresAdvanceChk && requiresAdvanceChk.checked;
        }

        function toggleBookingMode() {
            var kmMode = isKmBooking();
            if (kmFields) kmFields.style.display = kmMode ? '' : 'none';
            if (hoursFields) hoursFields.style.display = kmMode ? 'none' : '';
            if (pickupTimeWrap) pickupTimeWrap.style.display = kmMode ? 'none' : '';
            if (returnTimeWrap) returnTimeWrap.style.display = kmMode ? 'none' : '';
            if (hoursDurationWrap) hoursDurationWrap.style.display = kmMode ? 'none' : '';
            if (pickupTimeInp) pickupTimeInp.required = !kmMode;
            if (returnTimeInp) returnTimeInp.required = !kmMode;
            if (slotSel) slotSel.required = !kmMode;
            if (kmInput) kmInput.required = kmMode;
            updateAmount();
        }

        function calcHours() {
            var pd = pickupDate ? pickupDate.value : '';
            var rd = returnDate ? returnDate.value : '';
            var pt = pickupTimeInp ? pickupTimeInp.value : '';
            var rt = returnTimeInp ? returnTimeInp.value : '';
            if (!pd || !rd || !pt || !rt) return null;
            var pickupMs = buildDateTime(pd, pt);
            var returnMs = buildDateTime(rd, rt);
            if (isNaN(pickupMs) || isNaN(returnMs)) return null;
            if (returnMs <= pickupMs) return -1;
            return (returnMs - pickupMs) / (1000 * 60 * 60);
        }

        function buildDateTime(dateValue, timeValue) {
            var parsed = parseTimeValue(timeValue);
            if (!dateValue || !parsed) return NaN;
            var parts = dateValue.split('-');
            if (parts.length !== 3) return NaN;
            return new Date(
                parseInt(parts[0], 10),
                parseInt(parts[1], 10) - 1,
                parseInt(parts[2], 10),
                parsed.hour,
                parsed.minute,
                0
            ).getTime();
        }

        function parseTimeValue(raw) {
            var value = String(raw || '').trim().toUpperCase();
            var match = value.match(/^(\d{1,2}):(\d{2})(?:\s*(AM|PM))?$/);
            if (!match) return null;
            var hour = parseInt(match[1], 10);
            var minute = parseInt(match[2], 10);
            var meridiem = match[3] || '';

            if (minute < 0 || minute > 59) return null;

            if (meridiem) {
                if (hour < 1 || hour > 12) return null;
                if (meridiem === 'PM' && hour !== 12) hour += 12;
                if (meridiem === 'AM' && hour === 12) hour = 0;
            } else if (hour < 0 || hour > 23) {
                return null;
            }

            return {
                hour: hour,
                minute: minute
            };
        }

        function calcHourPackages(hours, slot) {
            var slotNum = parseInt(slot || '0', 10);
            if (!hours || hours <= 0 || slotNum <= 0) return 0;
            return Math.max(1, Math.ceil(hours / slotNum));
        }

        function updateHoursDuration() {
            var hours = calcHours();

            if (hours === null) {
                hoursDurValue.textContent = '—';
                hoursDurNote.textContent = 'Select pickup and return date & time to calculate.';
                hoursDurBox.style.borderColor = '#B5D4F4';
                hoursDurBox.style.background = '#EEF3FA';
                return;
            }
            if (hours === -1) {
                hoursDurValue.textContent = '!';
                hoursDurNote.textContent = '⚠ Return time must be after pickup time.';
                hoursDurBox.style.borderColor = '#f5c6c6';
                hoursDurBox.style.background = '#fff5f5';
                return;
            }

            var displayHours = Math.ceil(hours * 2) / 2;
            hoursDurValue.textContent = (displayHours % 1 === 0) ?
                displayHours.toFixed(0) :
                displayHours.toFixed(1);

            var suggestedSlot = hours <= 6 ? '6' : hours <= 12 ? '12' : '24';
            if (hours > 0 && slotSel) {
                slotSel.value = suggestedSlot;
            }

            var suggestedPackageCount = calcHourPackages(hours, suggestedSlot);
            hoursDurNote.textContent = displayHours + ' hrs total. Suggested slot: ' + suggestedSlot + '-hour package' +
                (suggestedPackageCount > 1 ? ' x ' + suggestedPackageCount + '.' : '.');

            var isExact = (hours === 6 || hours === 12 || hours === 24);
            hoursDurBox.style.borderColor = isExact ? '#86efac' : '#B5D4F4';
            hoursDurBox.style.background = isExact ? '#f0fdf4' : '#EEF3FA';

            updateAmount();
        }

        function updateAmount() {
            var d = getVehicleData();
            var kmMode = isKmBooking();

            if (!d) {
                if (amountInp) amountInp.value = '';
                if (advanceInp) advanceInp.value = '';
                if (extraBanner) extraBanner.style.display = 'none';
                return;
            }

            /* ── Extra charge notice banner above submit ── */
            if (d.extra > 0) {
                extraBanner.style.display = 'block';
                noticExtraVal.textContent = fmt(d.extra);
            } else {
                extraBanner.style.display = 'none';
            }

            /* ── Advance field ── */
            advanceInp.value = needsAdvance() && d.advance ? 'Rs. ' + d.advance.toFixed(2) : 'Not selected';
            if (advanceHelper) {
                advanceHelper.textContent = needsAdvance()
                    ? 'This amount will be paid on the next page.'
                    : 'Advance is optional. If unchecked, your booking will finish after document upload.';
            }

            /* ── Package price based on selected slot ── */
            var h = slotSel ? slotSel.value : '';
            var km = kmInput ? parseInt(kmInput.value || '0', 10) : 0;
            var totalHours = calcHours();
            var packageCount = calcHourPackages(totalHours, h);
            var price = kmMode ? (Math.max(0, km) * d.rateKm) : (
                (h === '6' ? d.p6 :
                h === '12' ? d.p12 :
                h === '24' ? d.p24 : 0) * Math.max(1, packageCount || 1)
            );

            amountInp.value = price > 0 ? price.toFixed(2) : '';

            if (kmMode) {
                amountLabel.textContent = 'Estimated Amount (KM)';
                helperEl.textContent = d.rateKm > 0 ?
                    ('Calculated at ' + fmt(d.rateKm) + ' per km.' + (km > 0 ? ' For ' + km + ' km.' : '')) :
                    'KM rate is not set for this vehicle yet.';
            } else if (h) {
                amountLabel.textContent = 'Package Price (' + h + ' Hours)';
                helperEl.textContent = 'Fixed price for the ' + h + '-hour package' +
                    ((packageCount || 0) > 1 ? (' x ' + packageCount) : '') + '.' +
                    (d.extra > 0 ? ' Extra hours charged at ' + fmt(d.extra) + '/hr.' : '');
            } else {
                amountLabel.textContent = 'Package Price';
                helperEl.textContent = 'Select a duration slot to see the package price.';
            }
        }

        if (vehicleSel) vehicleSel.addEventListener('change', updateAmount);
        if (bookingTypeSel) bookingTypeSel.addEventListener('change', toggleBookingMode);
        if (requiresAdvanceChk) requiresAdvanceChk.addEventListener('change', updateAmount);
        if (slotSel) slotSel.addEventListener('change', updateAmount);
        if (kmInput) kmInput.addEventListener('input', updateAmount);

        [pickupDate, returnDate, pickupTimeInp, returnTimeInp].forEach(function(el) {
            if (el) el.addEventListener('change', function() {
                updateHoursDuration();
                updateAmount();
            });
        });

        /* Run on load for edit mode pre-filled values */
        updateHoursDuration();
        toggleBookingMode();
        updateAmount();

    })();
</script>

