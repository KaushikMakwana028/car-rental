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
                <div class="helper">Check this when documents are already verified manually.</div>
            </div>

            <!-- Vehicle -->
            <div class="full">
                <label>Vehicle</label>
                <select name="vehicle_id" id="admin_vehicle_id" required style="width:100%;">
                    <option value="">Select vehicle</option>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <option
                            value="<?php echo (int)$vehicle['id']; ?>"

                            data-rate-km="<?php echo (float)(isset($vehicle['rate_per_day']) ? $vehicle['rate_per_day'] : 0); ?>"
                            data-advance="<?php echo (float)$vehicle['advance_amount']; ?>"
                            data-p6="<?php echo (float)(isset($vehicle['price_6_hours'])   ? $vehicle['price_6_hours']   : 0); ?>"
                            data-p12="<?php echo (float)(isset($vehicle['price_12_hours']) ? $vehicle['price_12_hours']  : 0); ?>"
                            data-p24="<?php echo (float)(isset($vehicle['price_24_hours']) ? $vehicle['price_24_hours']  : 0); ?>"
                            data-extra="<?php echo (float)(isset($vehicle['extra_hour_charge']) ? $vehicle['extra_hour_charge'] : 0); ?>">
                            <?php echo html_escape($vehicle['name'] . ' - ' . $vehicle['registration_no']
                                . ' - Advance: ' . number_format((float)$vehicle['advance_amount'], 2)); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label>Booking Type</label>
                <select name="booking_type" id="adm_booking_type" required>
                    <option value="hours">Hour Package</option>
                    <option value="km">KM Basis</option>
                </select>
            </div>

            <div id="adm_km_wrap" style="display:none;">
                <label>Estimated KM</label>
                <input type="number" min="1" name="estimated_km" id="adm_estimated_km" placeholder="Enter expected distance">
            </div>

            <!-- Hour pricing preview -->
            <div class="full" id="adm_hour_preview" style="display:none;">
                <label>Hour Package Rates</label>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:4px;">
                    <div style="background:#EEF3FA;border-radius:8px;padding:10px;text-align:center;">
                        <div style="font-size:10px;font-weight:700;color:#456383;text-transform:uppercase;letter-spacing:.06em;">6 Hours</div>
                        <div style="font-size:16px;font-weight:800;color:#17355C;margin-top:3px;" id="adm_hp6">₹0</div>
                    </div>
                    <div style="background:#EEF3FA;border-radius:8px;padding:10px;text-align:center;">
                        <div style="font-size:10px;font-weight:700;color:#456383;text-transform:uppercase;letter-spacing:.06em;">12 Hours</div>
                        <div style="font-size:16px;font-weight:800;color:#17355C;margin-top:3px;" id="adm_hp12">₹0</div>
                    </div>
                    <div style="background:#EEF3FA;border-radius:8px;padding:10px;text-align:center;">
                        <div style="font-size:10px;font-weight:700;color:#456383;text-transform:uppercase;letter-spacing:.06em;">24 Hours</div>
                        <div style="font-size:16px;font-weight:800;color:#17355C;margin-top:3px;" id="adm_hp24">₹0</div>
                    </div>
                </div>
            </div>

            <!-- Extra hour charge -->
            <div class="full" id="adm_extra_box" style="display:none;">
                <div style="background:#fff8e1;border:1.5px solid #f1c14f;border-radius:10px;padding:12px 16px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:#7a5c00;">⚡ Extra Hour Charge</div>
                    <div style="font-size:22px;font-weight:800;color:#17355C;margin-top:3px;" id="adm_extra_val">₹0</div>
                    <div style="font-size:11px;color:#73849A;margin-top:2px;">Charged per additional hour beyond the booked slot.</div>
                </div>
            </div>



            <div><label>Pickup Date</label><input type="date" name="pickup_date" id="pickup_date" required></div>
            <div><label>Return Date</label><input type="date" name="return_date" id="return_date" required></div>
            <!-- Pickup Time -->
            <div id="adm_pickup_time_wrap">
                <label>Pickup Time</label>
                <input type="text" name="pickup_time" id="adm_pickup_time" placeholder="Example: 10:30 AM or 22:30" required>
                <div class="helper">Enter time like `10:30 AM` or `22:30`.</div>
            </div>
            <div id="adm_return_time_wrap">
                <label>Return Time</label>
                <input type="text" name="return_time" id="adm_return_time" placeholder="Example: 06:30 PM or 18:30" required>
                <div class="helper">Enter time like `06:30 PM` or `18:30`.</div>
            </div>

            <!-- Hours duration display -->
            <div class="full" id="adm_hours_dur_wrap">
                <div id="adm_hours_dur_box" style="background:#EEF3FA;border:1.5px solid #B5D4F4;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <div>
                        <div style="font-size:12px;font-weight:700;color:#185FA5;text-transform:uppercase;letter-spacing:.08em;">⏱ Calculated Duration</div>
                        <div style="font-size:11px;color:#456383;margin-top:2px;" id="adm_hours_dur_note">Select pickup and return date &amp; time to calculate.</div>
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <div style="font-size:26px;font-weight:800;color:#17355C;line-height:1;" id="adm_hours_dur_value">—</div>
                        <div style="font-size:11px;color:#73849A;margin-top:2px;">hours total</div>
                    </div>
                </div>
            </div>
            <div><label>Pickup Location</label><input type="text" name="pickup_location" required></div>
            <div><label>Drop Location</label><input type="text" name="drop_location" required></div>

            <!-- Hours slot -->
            <div id="adm_hrs_wrap">
                <label>Select Duration</label>
                <select id="adm_hours_slot" name="hours_slot" required>
                    <option value="">-- Select slot --</option>
                    <option value="6">6 Hours</option>
                    <option value="12">12 Hours</option>
                    <option value="24">24 Hours</option>
                </select>
            </div>

            <!-- Expected amount -->
            <div id="adm_amount_wrap">
                <label>Expected Amount</label>
                <input type="number" step="0.01" name="amount" id="admin_expected_amount" readonly required>
            </div>

            <div>
                <label>Required Advance</label>
                <label style="display:flex;align-items:center;gap:10px;text-transform:none;letter-spacing:0;font-size:14px;margin-bottom:8px;">
                    <input type="checkbox" name="requires_advance" id="adm_requires_advance" value="1" style="width:auto;min-height:auto;">
                    Mark this booking with advance payment
                </label>
                <input type="text" id="admin_advance_amount" readonly>
                <div class="helper" id="adm_advance_helper">Advance amount for the selected vehicle.</div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

        $('#admin_vehicle_id').select2({
            placeholder: "Search vehicle...",
            allowClear: true,
            width: '100%'
        });

        function admGetData() {
            var opt = document.getElementById('admin_vehicle_id');
            var sel = opt ? opt.options[opt.selectedIndex] : null;
            if (!sel || !sel.value) return null;
            return {

                rateKm: parseFloat(sel.getAttribute('data-rate-km') || '0'),
                advance: parseFloat(sel.getAttribute('data-advance') || '0'),
                p6: parseFloat(sel.getAttribute('data-p6') || '0'),
                p12: parseFloat(sel.getAttribute('data-p12') || '0'),
                p24: parseFloat(sel.getAttribute('data-p24') || '0'),
                extra: parseFloat(sel.getAttribute('data-extra') || '0'),
            };
        }

        function admFmt(n) {
            return '₹' + Number(n).toLocaleString('en-IN', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        function admIsKmBooking() {
            return document.getElementById('adm_booking_type').value === 'km';
        }

        function admToggleBookingMode() {
            var kmMode = admIsKmBooking();
            document.getElementById('adm_km_wrap').style.display = kmMode ? '' : 'none';
            document.getElementById('adm_hrs_wrap').style.display = kmMode ? 'none' : '';
            document.getElementById('adm_pickup_time_wrap').style.display = kmMode ? 'none' : '';
            document.getElementById('adm_return_time_wrap').style.display = kmMode ? 'none' : '';
            document.getElementById('adm_hours_dur_wrap').style.display = kmMode ? 'none' : '';
            document.getElementById('adm_pickup_time').required = !kmMode;
            document.getElementById('adm_return_time').required = !kmMode;
            document.getElementById('adm_hours_slot').required = !kmMode;
            document.getElementById('adm_estimated_km').required = kmMode;
            admUpdateAmount();
        }

        function admCalcHourPackages(hours, slot) {
            var slotNum = parseInt(slot || '0', 10);
            if (!hours || hours <= 0 || slotNum <= 0) return 0;
            return Math.max(1, Math.ceil(hours / slotNum));
        }

        function admBuildDateTime(dateValue, timeValue) {
            var parsed = admParseTimeValue(timeValue);
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

        function admParseTimeValue(raw) {
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

        /* ── Calculate exact hours between two date+time combos ── */
        function admCalcHours() {
            var pd = document.getElementById('pickup_date') ? document.getElementById('pickup_date').value : '';
            var rd = document.getElementById('return_date') ? document.getElementById('return_date').value : '';
            var pt = document.getElementById('adm_pickup_time') ? document.getElementById('adm_pickup_time').value : '';
            var rt = document.getElementById('adm_return_time') ? document.getElementById('adm_return_time').value : '';
            if (!pd || !rd || !pt || !rt) return null;
            var pickupMs = admBuildDateTime(pd, pt);
            var returnMs = admBuildDateTime(rd, rt);
            if (isNaN(pickupMs) || isNaN(returnMs)) return null;
            if (returnMs <= pickupMs) return -1;
            return (returnMs - pickupMs) / (1000 * 60 * 60);
        }

        /* ── Update hours duration display ── */
        function admUpdateHoursDuration() {
            var hours = admCalcHours();
            var box = document.getElementById('adm_hours_dur_box');
            var val = document.getElementById('adm_hours_dur_value');
            var note = document.getElementById('adm_hours_dur_note');
            if (hours === null) {
                val.textContent = '—';
                note.textContent = 'Select pickup and return date & time to calculate.';
                box.style.borderColor = '#B5D4F4';
                box.style.background = '#EEF3FA';
                return;
            }
            if (hours === -1) {
                val.textContent = '!';
                note.textContent = '⚠ Return time must be after pickup time.';
                box.style.borderColor = '#f5c6c6';
                box.style.background = '#fff5f5';
                return;
            }
            var display = Math.ceil(hours * 2) / 2;
            val.textContent = display % 1 === 0 ? display.toFixed(0) : display.toFixed(1);
            var suggested = hours <= 6 ? '6' : hours <= 12 ? '12' : '24';
            var suggestedPackageCount = admCalcHourPackages(hours, suggested);
            note.textContent = display + ' hrs total. Suggested slot: ' + suggested + '-hour package' +
                (suggestedPackageCount > 1 ? ' x ' + suggestedPackageCount + '.' : '.');
            if (hours > 0) {
                document.getElementById('adm_hours_slot').value = suggested;
            }
            var isExact = (hours === 6 || hours === 12 || hours === 24);
            box.style.borderColor = isExact ? '#86efac' : '#B5D4F4';
            box.style.background = isExact ? '#f0fdf4' : '#EEF3FA';
            admUpdateAmount();
        }



        function admUpdateAmount() {
            var d = admGetData();
            var kmMode = admIsKmBooking();
            if (!d) {
                document.getElementById('admin_expected_amount').value = '';
                document.getElementById('admin_advance_amount').value = '';
                document.getElementById('adm_hour_preview').style.display = 'none';
                document.getElementById('adm_extra_box').style.display = 'none';
                return;
            }
            document.getElementById('adm_hour_preview').style.display = '';
            document.getElementById('adm_hp6').textContent = admFmt(d.p6);
            document.getElementById('adm_hp12').textContent = admFmt(d.p12);
            document.getElementById('adm_hp24').textContent = admFmt(d.p24);
            if (d.extra > 0) {
                document.getElementById('adm_extra_box').style.display = '';
                document.getElementById('adm_extra_val').textContent = admFmt(d.extra);
            } else {
                document.getElementById('adm_extra_box').style.display = 'none';
            }
            document.getElementById('admin_advance_amount').value = document.getElementById('adm_requires_advance').checked && d.advance ? 'Rs. ' + d.advance.toFixed(2) : 'Not selected';
            document.getElementById('adm_advance_helper').textContent = document.getElementById('adm_requires_advance').checked ?
                'Advance will be expected for this booking.' :
                'Advance is optional. Booking can be created without payment.';

            var h = document.getElementById('adm_hours_slot').value;
            var km = parseInt(document.getElementById('adm_estimated_km').value || '0', 10);
            var totalHours = admCalcHours();
            var packageCount = admCalcHourPackages(totalHours, h);
            var price = kmMode ? (Math.max(0, km) * d.rateKm) : ((h === '6' ? d.p6 : h === '12' ? d.p12 : h === '24' ? d.p24 : 0) * Math.max(1, packageCount || 1));
            document.getElementById('admin_expected_amount').value = price > 0 ? price.toFixed(2) : '';
        }

        /* ── Event listeners ── */
        $('#admin_vehicle_id').on('change', admUpdateAmount);
        document.getElementById('adm_booking_type').addEventListener('change', admToggleBookingMode);
        document.getElementById('adm_requires_advance').addEventListener('change', admUpdateAmount);
        document.getElementById('adm_hours_slot').addEventListener('change', admUpdateAmount);
        document.getElementById('adm_estimated_km').addEventListener('input', admUpdateAmount);

        /* Date + time changes recalculate hours duration */
        ['pickup_date', 'return_date'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('change', function() {
                admUpdateHoursDuration();
                admUpdateAmount();
            });
        });
        ['adm_pickup_time', 'adm_return_time'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('change', function() {
                admUpdateHoursDuration();
                admUpdateAmount();
            });
        });

        admUpdateHoursDuration();
        admToggleBookingMode();
        admUpdateAmount();
    });
</script>



