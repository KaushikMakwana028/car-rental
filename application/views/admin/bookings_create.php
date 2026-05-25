<style>
    .select2-container {
        width: 100% !important;
    }

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

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        padding-left: 0 !important;
        color: #333 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px !important;
        right: 10px !important;
    }

    .select2-dropdown {
        border-radius: 10px !important;
        border: 1px solid #dcdfe6 !important;
        overflow: hidden;
    }

    .select2-search__field {
        border-radius: 8px !important;
        padding: 8px !important;
    }

    .select2-results__option--highlighted {
        background: #4f46e5 !important;
        color: #fff !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #4f46e5 !important;
    }

    /* Phone lookup */
    .phone-input-wrapper {
        position: relative;
    }

    .phone-input-wrapper input {
        padding-right: 42px !important;
    }

    .phone-spinner {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        border: 2.5px solid #e0e7ff;
        border-top-color: #4f46e5;
        border-radius: 50%;
        animation: admSpin 0.65s linear infinite;
        display: none;
    }

    @keyframes admSpin {
        to {
            transform: translateY(-50%) rotate(360deg);
        }
    }

    .lookup-banner {
        display: none;
        border-radius: 9px;
        padding: 9px 13px;
        font-size: 13px;
        margin-top: 7px;
        align-items: center;
        gap: 8px;
    }

    .lookup-banner.found {
        background: #f0fdf4;
        border: 1.5px solid #86efac;
        color: #166534;
    }

    .lookup-banner.new {
        background: #eff6ff;
        border: 1.5px solid #93c5fd;
        color: #1e40af;
    }

    .lookup-banner.error {
        background: #fff5f5;
        border: 1.5px solid #fca5a5;
        color: #991b1b;
    }

    /* Green flash on autofill */
    @keyframes greenFlash {
        0% {
            background: #dcfce7;
            border-color: #86efac;
        }

        100% {
            background: #fff;
            border-color: #dcdfe6;
        }
    }

    .autofilled {
        animation: greenFlash 1.8s ease forwards;
    }
</style>

<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="section-card">
    <div class="card-head">
        <div>
            <h3>Create Booking</h3>
            <p>Enter walk-in customer details, select an available vehicle and confirm the rental details.</p>
        </div>
    </div>
    <form method="post" action="<?php echo base_url('admin/bookings/store'); ?>">
        <div class="form-grid">

            <!-- 1. Customer Name -->
            <div>
                <label>Customer Name</label>
                <input type="text" name="customer_name" id="adm_customer_name"
                    placeholder="Enter customer name" required>
            </div>

            <!-- 2. Customer Phone with live lookup -->
            <div>
                <label>Customer Phone</label>
                <div class="phone-input-wrapper">
                    <input type="text" name="customer_phone" id="adm_customer_phone"
                        placeholder="Enter customer phone" required
                        autocomplete="off" maxlength="15" inputmode="numeric">
                    <div class="phone-spinner" id="adm_phone_spinner"></div>
                </div>
                <div class="helper" style="margin-top:5px;">
                    📋 Enter phone number — existing customer details will auto-fill instantly.
                </div>
                <div class="lookup-banner found" id="adm_banner_found"></div>
                <div class="lookup-banner new" id="adm_banner_new">🆕 New customer — a fresh profile will be created on save.</div>
                <div class="lookup-banner error" id="adm_banner_error">⚠️ Could not reach server. Please fill details manually.</div>
                <div class="lookup-banner" id="adm_banner_doc_images" style="display:none;background:#fefce8;border:1.5px solid #fde047;color:#713f12;border-radius:9px;padding:9px 13px;font-size:13px;margin-top:7px;align-items:center;gap:8px;">
                    📎 This customer has uploaded document images from their portal. You can review them in the <a href="#" id="adm_docs_review_link" style="color:#1d4ed8;font-weight:600;">Documents section</a>.
                </div>
            </div>

            <!-- 3. Email -->
            <div class="full">
                <label>Customer Email</label>
                <input type="email" name="customer_email" id="adm_customer_email"
                    placeholder="Optional email for the customer">
                <div class="helper">If this phone or email already exists, the system will reuse that customer automatically.</div>
            </div>

            <!-- 4. Docs -->
            <div>
                <label>Aadhaar Number</label>
                <input type="text" name="aadhaar_number" id="adm_aadhaar_number"
                    placeholder="Enter Aadhaar number">
            </div>
            <div>
                <label>Driving License Number</label>
                <input type="text" name="driving_license_number" id="adm_driving_license_number"
                    placeholder="Enter license number">
            </div>
            <div class="full">
                <label style="display:flex;align-items:center;gap:10px;text-transform:none;letter-spacing:0;font-size:14px;">
                    <input type="checkbox" name="documents_verified" id="adm_documents_verified" value="1" style="width:auto;min-height:auto;">
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

            <div class="full" id="adm_extra_box" style="display:none;">
                <div style="background:#fff8e1;border:1.5px solid #f1c14f;border-radius:10px;padding:12px 16px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:#7a5c00;">⚡ Extra Hour Charge</div>
                    <div style="font-size:22px;font-weight:800;color:#17355C;margin-top:3px;" id="adm_extra_val">₹0</div>
                    <div style="font-size:11px;color:#73849A;margin-top:2px;">Charged per additional hour beyond the booked slot.</div>
                </div>
            </div>

            <div><label>Pickup Date</label><input type="date" name="pickup_date" id="pickup_date" required></div>
            <div><label>Return Date</label><input type="date" name="return_date" id="return_date" required></div>

            <div id="adm_pickup_time_wrap">
                <label>Pickup Time</label>
                <input type="text" name="pickup_time" id="adm_pickup_time" placeholder="Select time" required readonly>
                <div class="helper">Click to select time from picker.</div>
            </div>
            <div id="adm_return_time_wrap">
                <label>Return Time</label>
                <input type="text" name="return_time" id="adm_return_time" placeholder="Select time" required readonly>
                <div class="helper">Click to select time from picker.</div>
            </div>

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

            <div id="adm_hrs_wrap">
                <label>Select Duration</label>
                <select id="adm_hours_slot" name="hours_slot" required>
                    <option value="">-- Select slot --</option>
                    <option value="6">6 Hours</option>
                    <option value="12">12 Hours</option>
                    <option value="24">24 Hours</option>
                </select>
            </div>

            <div id="adm_amount_wrap">
                <label>Expected Amount (Base Fare)</label>
                <input type="number" step="0.01" name="amount" id="admin_expected_amount" required>
                <div class="helper">Auto-calculated. You can modify if needed for custom pricing.</div>
            </div>

            <div class="full" style="border-top: 1.5px solid var(--border); padding-top: 16px; margin-top: 8px;">
                <label style="font-weight: 700; display: block; margin-bottom: 12px;">Expenses Breakdown</label>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                    <div><label>Fuel Expense</label><input type="number" step="0.01" min="0" name="fuel_expense" id="adm_fuel_expense" placeholder="0.00"></div>
                    <div><label>Toll Expense</label><input type="number" step="0.01" min="0" name="toll_expense" id="adm_toll_expense" placeholder="0.00"></div>
                    <div><label>Driver Expense</label><input type="number" step="0.01" min="0" name="driver_expense" id="adm_driver_expense" placeholder="0.00"></div>
                    <div><label>Parking Expense</label><input type="number" step="0.01" min="0" name="parking_expense" id="adm_parking_expense" placeholder="0.00"></div>
                </div>
                <div class="helper" style="margin-top: 10px;">These expenses will be deducted from the booking amount.</div>
            </div>

            <div id="adm_expense_summary" style="background:#fff8e1;border:1.5px solid #f1c14f;border-radius:10px;padding:12px 16px;margin-top:12px;display:none;">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:#7a5c00;">💰 Expense Summary</div>
                <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-top:10px;">
                    <div>
                        <div style="font-size:10px;color:#73849A;margin-bottom:4px;">Total Expenses</div>
                        <div style="font-size:16px;font-weight:700;color:#17355C;" id="adm_total_expenses_display">₹0</div>
                    </div>
                    <div>
                        <div style="font-size:10px;color:#73849A;margin-bottom:4px;">Net Amount (After Expenses)</div>
                        <div style="font-size:16px;font-weight:700;color:#0F6E56;" id="adm_net_amount_display">₹0</div>
                    </div>
                </div>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function() {

        // ═══════════════════════════════════════════════════════════
        //  CUSTOMER PHONE LIVE LOOKUP
        // ═══════════════════════════════════════════════════════════
        var lookupTimer = null;
        var lastPhone = '';
        var LOOKUP_URL = '<?php echo base_url("admin/bookings/lookup_customer"); ?>';

        var $phoneInput = $('#adm_customer_phone');
        var $spinner = $('#adm_phone_spinner');
        var $bannerFound = $('#adm_banner_found');
        var $bannerNew = $('#adm_banner_new');
        var $bannerError = $('#adm_banner_error');

        function hideBanners() {
            $bannerFound.hide();
            $bannerNew.hide();
            $bannerError.hide();
        }

        function flashField(id, value) {
            var el = document.getElementById(id);
            if (!el) return;
            el.value = value || '';
            if (value) {
                el.classList.remove('autofilled');
                // Force reflow to restart animation
                void el.offsetWidth;
                el.classList.add('autofilled');
            }
        }

        function doLookup(phone) {
            if (phone === lastPhone) return;
            lastPhone = phone;

            hideBanners();
            $spinner.show();

            $.ajax({
                url: LOOKUP_URL,
                type: 'GET', // ← Changed from POST to GET (bypasses CSRF)
                data: {
                    phone: phone
                },
                dataType: 'json',
                timeout: 8000,
                success: function(res) {
                    $spinner.hide();
                    if (!res) {
                        $bannerError.show();
                        return;
                    }

                    if (res.found) {
                        flashField('adm_customer_name', res.customer_name);
                        flashField('adm_customer_email', res.customer_email);
                        flashField('adm_aadhaar_number', res.aadhaar_number);
                        flashField('adm_driving_license_number', res.driving_license_number);

                        var docCb = document.getElementById('adm_documents_verified');
                        if (docCb) docCb.checked = (res.documents_verified == 1);

                        $bannerFound
                            .html('✅ Customer <strong>' + $('<span>').text(res.customer_name).html() + '</strong> found — details auto-filled.')
                            .show();

                        if (res.has_document_images) {
                            var reviewUrl = '<?php echo base_url("admin/documents"); ?>';
                            if (res.customer_id) reviewUrl += '?customer_id=' + res.customer_id;
                            $('#adm_docs_review_link').attr('href', reviewUrl);
                            $('#adm_banner_doc_images').css('display', 'flex');
                        }
                    } else {
                        $bannerNew.show();
                    }
                },
                error: function(xhr) {
                    $spinner.hide();
                    if (xhr.statusText !== 'abort') {
                        console.error('Lookup failed:', xhr.status, xhr.responseText ? xhr.responseText.substring(0, 300) : '');
                        $bannerError.show();
                    }
                }
            });
        }

        function hideBanners() {
            $bannerFound.hide();
            $bannerNew.hide();
            $bannerError.hide();
            $('#adm_banner_doc_images').hide();
        }

        $phoneInput.on('input', function() {
            var rawPhone = $.trim($(this).val()).replace(/\s+/g, '');
            hideBanners();
            clearTimeout(lookupTimer);

            // Only lookup when we have enough digits (≥ 7)
            if (rawPhone.replace(/\D/g, '').length < 7) {
                $spinner.hide();
                lastPhone = ''; // reset so same number triggers again after clearing
                return;
            }

            // Debounce 600ms
            lookupTimer = setTimeout(function() {
                doLookup(rawPhone);
            }, 600);
        });

        // ═══════════════════════════════════════════════════════════
        //  SELECT2
        // ═══════════════════════════════════════════════════════════
        $('#admin_vehicle_id').select2({
            placeholder: "Search vehicle...",
            allowClear: true,
            width: '100%'
        });

        // ═══════════════════════════════════════════════════════════
        //  FLATPICKR
        // ═══════════════════════════════════════════════════════════
        flatpickr("#adm_pickup_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
            minuteIncrement: 15,
            onChange: function() {
                admUpdateHoursDuration();
                admUpdateAmount();
            }
        });
        flatpickr("#adm_return_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
            minuteIncrement: 15,
            onChange: function() {
                admUpdateHoursDuration();
                admUpdateAmount();
            }
        });

        // ═══════════════════════════════════════════════════════════
        //  EXPENSE LISTENERS
        // ═══════════════════════════════════════════════════════════
        ['adm_fuel_expense', 'adm_toll_expense', 'adm_driver_expense', 'adm_parking_expense'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('input', admUpdateExpenses);
        });

        // ═══════════════════════════════════════════════════════════
        //  VEHICLE / AMOUNT HELPERS
        // ═══════════════════════════════════════════════════════════
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
            if (!dateValue || !timeValue) return NaN;
            var parts = dateValue.split('-'),
                timeParts = timeValue.split(':');
            if (parts.length !== 3 || timeParts.length !== 2) return NaN;
            return new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10),
                parseInt(timeParts[0], 10), parseInt(timeParts[1], 10), 0).getTime();
        }

        function admCalcHours() {
            var pd = (document.getElementById('pickup_date') || {}).value || '';
            var rd = (document.getElementById('return_date') || {}).value || '';
            var pt = (document.getElementById('adm_pickup_time') || {}).value || '';
            var rt = (document.getElementById('adm_return_time') || {}).value || '';
            if (!pd || !rd || !pt || !rt) return null;
            var pm = admBuildDateTime(pd, pt),
                rm = admBuildDateTime(rd, rt);
            if (isNaN(pm) || isNaN(rm)) return null;
            if (rm <= pm) return -1;
            return (rm - pm) / 3600000;
        }

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
            var cnt = admCalcHourPackages(hours, suggested);
            note.textContent = display + ' hrs total. Suggested slot: ' + suggested + '-hour package' + (cnt > 1 ? ' x ' + cnt + '.' : '.');
            if (hours > 0) document.getElementById('adm_hours_slot').value = suggested;
            var isExact = (hours === 6 || hours === 12 || hours === 24);
            box.style.borderColor = isExact ? '#86efac' : '#B5D4F4';
            box.style.background = isExact ? '#f0fdf4' : '#EEF3FA';
            admUpdateAmount();
        }

        function admUpdateExpenses() {
            var fuel = parseFloat(document.getElementById('adm_fuel_expense').value || '0');
            var toll = parseFloat(document.getElementById('adm_toll_expense').value || '0');
            var driver = parseFloat(document.getElementById('adm_driver_expense').value || '0');
            var parking = parseFloat(document.getElementById('adm_parking_expense').value || '0');
            var total = fuel + toll + driver + parking;
            var base = parseFloat(document.getElementById('admin_expected_amount').value || '0');
            var net = Math.max(0, base - total);
            document.getElementById('adm_expense_summary').style.display = total > 0 ? '' : 'none';
            document.getElementById('adm_total_expenses_display').textContent = '₹' + total.toLocaleString('en-IN', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            document.getElementById('adm_net_amount_display').textContent = '₹' + net.toLocaleString('en-IN', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        function admUpdateAmount() {
            var d = admGetData(),
                kmMode = admIsKmBooking();
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
            var advCb = document.getElementById('adm_requires_advance');
            document.getElementById('admin_advance_amount').value = advCb.checked && d.advance ? 'Rs. ' + d.advance.toFixed(2) : 'Not selected';
            document.getElementById('adm_advance_helper').textContent = advCb.checked ? 'Advance will be expected for this booking.' : 'Advance is optional. Booking can be created without payment.';
            var h = document.getElementById('adm_hours_slot').value;
            var km = parseInt(document.getElementById('adm_estimated_km').value || '0', 10);
            var th = admCalcHours();
            var pc = admCalcHourPackages(th, h);
            var price = kmMode ? (Math.max(0, km) * d.rateKm) : ((h === '6' ? d.p6 : h === '12' ? d.p12 : h === '24' ? d.p24 : 0) * Math.max(1, pc || 1));
            document.getElementById('admin_expected_amount').value = price > 0 ? price.toFixed(2) : '';
        }

        // ═══════════════════════════════════════════════════════════
        //  EVENT BINDINGS
        // ═══════════════════════════════════════════════════════════
        $('#admin_vehicle_id').on('change', admUpdateAmount);
        document.getElementById('adm_booking_type').addEventListener('change', admToggleBookingMode);
        document.getElementById('adm_requires_advance').addEventListener('change', admUpdateAmount);
        document.getElementById('adm_hours_slot').addEventListener('change', admUpdateAmount);
        document.getElementById('adm_estimated_km').addEventListener('input', admUpdateAmount);
        ['pickup_date', 'return_date'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('change', function() {
                admUpdateHoursDuration();
                admUpdateAmount();
            });
        });

        // ═══════════════════════════════════════════════════════════
        //  INIT
        // ═══════════════════════════════════════════════════════════
        admUpdateHoursDuration();
        admToggleBookingMode();
        admUpdateAmount();
        admUpdateExpenses();
    });
</script>