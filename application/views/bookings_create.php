<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $selected_vehicle_id = isset($selected_vehicle_id) ? (int) $selected_vehicle_id : 0; ?>
<?php $current_step = isset($current_step) ? (int) $current_step : 1; ?>
<?php $booking_edit = !empty($booking_edit) ? $booking_edit : array(); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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

    .booking-conflict-note {
        display: none;
        margin-top: 8px;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid #fecaca;
        background: #fff1f2;
        color: #b91c1c;
        font-size: 12.5px;
        font-weight: 600;
        line-height: 1.5;
    }

    .booking-conflict-note.show {
        display: block;
    }

    .booking-conflict-input {
        border-color: #f87171 !important;
        box-shadow: 0 0 0 3px rgba(248, 113, 113, .12);
    }

    .booking-picker-input {
        background-color: #fff !important;
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 18px 18px;
        cursor: pointer;
        padding-right: 48px !important;
    }

    .booking-picker-input.date {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%230f3b74' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'/%3E%3Cline x1='16' y1='2' x2='16' y2='6'/%3E%3Cline x1='8' y1='2' x2='8' y2='6'/%3E%3Cline x1='3' y1='10' x2='21' y2='10'/%3E%3C/svg%3E");
    }

    .booking-picker-input.time {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%230f3b74' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='9'/%3E%3Cpolyline points='12 7 12 12 15 15'/%3E%3C/svg%3E");
    }

    .booking-picker-input[readonly] {
        user-select: none;
    }

    /* ═══════════════════════════════════════════
       FLATPICKR — CALENDAR (DATE PICKER)
    ═══════════════════════════════════════════ */

    .flatpickr-calendar {
        border: 1px solid rgba(35, 94, 167, .14) !important;
        box-shadow: 0 20px 44px rgba(15, 23, 42, .16) !important;
        border-radius: 16px !important;
        overflow: hidden !important;
        font-family: inherit !important;
        background: #fff !important;
        z-index: 40;
        width: 308px !important;
        padding: 0 !important;
    }

    .flatpickr-calendar.open {
        animation: bookingPickerFade .18s ease;
    }

    /* ── Header bar ── */
    .flatpickr-months {
        background: linear-gradient(135deg, #17355c 0%, #235ea7 100%) !important;
        height: 56px !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 6px !important;
        position: relative !important;
    }

    /* ── Prev / Next arrows ── */
    .flatpickr-months .flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month {
        position: static !important;
        height: 40px !important;
        width: 40px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        top: auto !important;
        border-radius: 8px !important;
        flex-shrink: 0 !important;
        fill: #fff !important;
        color: #fff !important;
        transition: background .15s !important;
    }

    .flatpickr-months .flatpickr-prev-month:hover,
    .flatpickr-months .flatpickr-next-month:hover {
        background: rgba(255, 255, 255, .18) !important;
    }

    .flatpickr-months .flatpickr-prev-month svg,
    .flatpickr-months .flatpickr-next-month svg {
        fill: #fff !important;
    }

    /* ── Month container ── */
    .flatpickr-months .flatpickr-month {
        flex: 1 !important;
        height: 56px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: transparent !important;
        float: none !important;
        line-height: 1 !important;
    }

    /* ── Month + Year row ── */
    .flatpickr-current-month {
        position: static !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        width: auto !important;
        height: auto !important;
        padding: 0 !important;
        left: auto !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        color: #fff !important;
    }

    /* ── Month dropdown — force white text ── */
    .flatpickr-monthDropdown-months {
        appearance: none !important;
        -webkit-appearance: none !important;
        background: transparent !important;
        border: 0 !important;
        outline: 0 !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        color: #fff !important;
        -webkit-text-fill-color: #fff !important;
        opacity: 1 !important;
        cursor: pointer !important;
        padding: 0 2px !important;
    }

    .flatpickr-monthDropdown-months option {
        background: #17355c !important;
        color: #fff !important;
    }

    /* ── Year input ── */
    .flatpickr-current-month input.cur-year {
        font-size: 16px !important;
        font-weight: 700 !important;
        color: #fff !important;
        -webkit-text-fill-color: #fff !important;
        background: transparent !important;
        border: 0 !important;
        outline: 0 !important;
        padding: 0 2px !important;
        margin: 0 !important;
        max-width: 60px !important;
    }

    .flatpickr-current-month .cur-year[disabled] {
        opacity: 1 !important;
        color: #fff !important;
        -webkit-text-fill-color: #fff !important;
    }

    .flatpickr-current-month .numInputWrapper:hover {
        background: transparent !important;
    }

    /* ── Weekday header ── */
    .flatpickr-weekdays {
        background: #edf4fd !important;
        padding: 6px 10px 4px !important;
    }

    span.flatpickr-weekday {
        color: #456383 !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        letter-spacing: .08em !important;
        text-transform: uppercase !important;
        background: transparent !important;
    }

    /* ── Day grid ── */
    .flatpickr-days {
        padding: 8px 10px 12px !important;
    }

    .dayContainer {
        min-width: 100% !important;
        max-width: 100% !important;
    }

    .flatpickr-day {
        border-radius: 8px !important;
        max-width: 36px !important;
        height: 36px !important;
        line-height: 36px !important;
        font-size: 13px !important;
        color: #17355c !important;
    }

    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange,
    .flatpickr-day.selected:hover,
    .flatpickr-day.startRange:hover,
    .flatpickr-day.endRange:hover {
        background: #235ea7 !important;
        border-color: #235ea7 !important;
        color: #fff !important;
    }

    .flatpickr-day.today {
        border-color: #f1c14f !important;
        color: #7a5c00 !important;
        font-weight: 700 !important;
    }

    .flatpickr-day:hover:not(.selected) {
        background: rgba(35, 94, 167, .09) !important;
        border-color: transparent !important;
    }

    .flatpickr-day.prevMonthDay,
    .flatpickr-day.nextMonthDay {
        color: #b0c4d8 !important;
    }

    .flatpickr-day.flatpickr-disabled,
    .flatpickr-day.flatpickr-disabled:hover {
        opacity: .35 !important;
        color: #b0c4d8 !important;
    }

    /* ═══════════════════════════════════════════
       FLATPICKR — TIME PICKER
    ═══════════════════════════════════════════ */

    .flatpickr-calendar.noCalendar {
        width: auto !important;
        min-width: 240px !important;
        border-radius: 16px !important;
        padding: 20px !important;
    }

    .flatpickr-calendar.noCalendar .flatpickr-time {
        border: 0 !important;
        background: transparent !important;
        height: auto !important;
        max-height: none !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        padding: 0 !important;
    }

    .flatpickr-calendar.noCalendar .flatpickr-time .numInputWrapper {
        flex: 1 !important;
        height: 64px !important;
        border-radius: 12px !important;
        background: #edf4fd !important;
        border: 1.5px solid #b5d4f4 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: visible !important;
    }

    .flatpickr-calendar.noCalendar .flatpickr-time .numInputWrapper:hover {
        background: #ddeaf9 !important;
    }

    .flatpickr-calendar.noCalendar .flatpickr-time input.flatpickr-hour,
    .flatpickr-calendar.noCalendar .flatpickr-time input.flatpickr-minute {
        font-size: 28px !important;
        font-weight: 800 !important;
        color: #17355c !important;
        text-align: center !important;
        width: 100% !important;
        background: transparent !important;
        border: 0 !important;
        outline: 0 !important;
        height: 64px !important;
        line-height: 64px !important;
        padding: 0 !important;
        cursor: default !important;
    }

    .flatpickr-calendar.noCalendar .flatpickr-time .flatpickr-time-separator {
        font-size: 26px !important;
        font-weight: 800 !important;
        color: #17355c !important;
        flex-shrink: 0 !important;
        width: 16px !important;
        text-align: center !important;
        background: transparent !important;
        border: 0 !important;
        height: auto !important;
        min-height: auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        line-height: 64px !important;
    }

    .flatpickr-calendar.noCalendar .flatpickr-time .flatpickr-am-pm {
        height: 64px !important;
        min-height: 64px !important;
        width: 64px !important;
        border-radius: 12px !important;
        background: #235ea7 !important;
        border: 0 !important;
        color: #fff !important;
        font-size: 15px !important;
        font-weight: 700 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        flex-shrink: 0 !important;
        line-height: 1 !important;
    }

    .flatpickr-calendar.noCalendar .flatpickr-time .flatpickr-am-pm:hover {
        background: #17355c !important;
    }

    /* ── Hide up/down arrow spinners ── */
    .flatpickr-time .numInputWrapper span {
        display: none !important;
    }

    @keyframes bookingPickerFade {
        from {
            opacity: 0;
            transform: translateY(4px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
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
                            <?php
                            $is_booked_vehicle = isset($v['status']) && $v['status'] === 'booked' && !empty($v['active_booking']);
                            $booked_option_note = $is_booked_vehicle ? ' | Booked till ' . date('d M Y', strtotime($v['active_booking']['return_date'])) : '';
                            ?>
                            <option
                                value="<?php echo (int)$v['id']; ?>"
                                data-rate-km="<?php echo (float)(isset($v['rate_per_day']) ? $v['rate_per_day'] : 0); ?>"
                                data-advance="<?php echo (float)$v['advance_amount']; ?>"
                                data-p6="<?php echo (float)(isset($v['price_6_hours'])        ? $v['price_6_hours']       : 0); ?>"
                                data-p12="<?php echo (float)(isset($v['price_12_hours'])      ? $v['price_12_hours']      : 0); ?>"
                                data-p24="<?php echo (float)(isset($v['price_24_hours'])      ? $v['price_24_hours']      : 0); ?>"
                                data-extra="<?php echo (float)(isset($v['extra_hour_charge']) ? $v['extra_hour_charge']   : 0); ?>"
                                data-booked-until="<?php echo $is_booked_vehicle ? html_escape($v['active_booking']['return_date']) : ''; ?>"
                                <?php echo ((int)$v['id'] === $selected_vehicle_id) ? 'selected' : ''; ?>>
                                <?php echo html_escape($v['name'] . ' | ' . $v['registration_no']
                                    . ' | Adv ₹' . number_format((float)$v['advance_amount'], 0)); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="helper" id="vehicle_booking_note">Cars marked as booked can still be reserved for future non-overlapping dates.</div>
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
                    <input type="text" name="pickup_date" id="pickup_date" class="booking-picker-input date" readonly
                        value="<?php echo !empty($booking_edit['pickup_date']) ? html_escape($booking_edit['pickup_date']) : ''; ?>" required>
                    <div class="helper">Click to select pickup date.</div>
                    <div class="booking-conflict-note" id="bookingConflictNote"></div>
                </div>
                <div>
                    <label>Return Date</label>
                    <input type="text" name="return_date" id="return_date" class="booking-picker-input date" readonly
                        value="<?php echo !empty($booking_edit['return_date']) ? html_escape($booking_edit['return_date']) : ''; ?>" required>
                    <div class="helper">Click to select return date.</div>
                </div>

                <!-- ── 4. Pickup Time & Return Time ── -->
                <div id="pickup_time_wrap">
                    <label>Pickup Time</label>

                    <input
                        type="text"
                        name="pickup_time"
                        id="pickup_time"
                        class="booking-picker-input time"
                        value="<?php echo !empty($booking_edit['pickup_time']) ? html_escape(date('h:i K', strtotime($booking_edit['pickup_time']))) : ''; ?>"
                        required
                        readonly>

                    <div class="helper">Click to select pickup time.</div>
                </div>

                <div id="return_time_wrap">
                    <label>Return Time</label>

                    <input
                        type="text"
                        name="return_time"
                        id="return_time"
                        class="booking-picker-input time"
                        value="<?php echo !empty($booking_edit['return_time']) ? html_escape(date('h:i K', strtotime($booking_edit['return_time']))) : ''; ?>"
                        required
                        readonly>

                    <div class="helper">Click to select return time.</div>
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
        var vehicleBookingNote = document.getElementById('vehicle_booking_note');
        var pickupDate = document.getElementById('pickup_date');
        var returnDate = document.getElementById('return_date');
        var pickupTimeInp = document.getElementById('pickup_time');
        var returnTimeInp = document.getElementById('return_time');
        var hoursDurBox = document.getElementById('hours_duration_box');
        var hoursDurValue = document.getElementById('hours_duration_value');
        var hoursDurNote = document.getElementById('hours_duration_note');
        var extraBanner = document.getElementById('extra_notice_banner');
        var noticExtraVal = document.getElementById('notice_extra_val');
        var conflictNote = document.getElementById('bookingConflictNote');
        var submitBtn = document.querySelector('form[action*="bookings/store"] button[type="submit"]');
        var availabilityUrl = '<?php echo base_url('api/vehicles/check-availability'); ?>';
        var availabilityRequestToken = 0;
        var conflictActive = false;
        var pickupDatePicker = null;
        var returnDatePicker = null;
        var pickupTimePicker = null;
        var returnTimePicker = null;

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
                extra: parseFloat(opt.getAttribute('data-extra') || '0'),
                bookedUntil: opt.getAttribute('data-booked-until') || ''
            };
        }

        function updateVehicleBookingNote() {
            if (!vehicleBookingNote) return;
            var data = getVehicleData();
            if (data && data.bookedUntil) {
                vehicleBookingNote.textContent = 'This car is already booked till ' + data.bookedUntil + '. You can still book it for dates after that.';
                return;
            }
            vehicleBookingNote.textContent = 'Cars marked as booked can still be reserved for future non-overlapping dates.';
        }

        function setConflictState(hasConflict, message) {
            conflictActive = !!hasConflict;

            toggleConflictInput(pickupDate, conflictActive);
            toggleConflictInput(returnDate, conflictActive);

            if (conflictNote) {
                conflictNote.textContent = message || '';
                conflictNote.classList.toggle('show', conflictActive && !!message);
            }

            if (submitBtn) {
                submitBtn.disabled = conflictActive;
                submitBtn.style.opacity = conflictActive ? '0.65' : '';
                submitBtn.style.cursor = conflictActive ? 'not-allowed' : '';
            }
        }

        function toggleConflictInput(field, hasConflict) {
            if (!field) {
                return;
            }
            field.classList.toggle('booking-conflict-input', hasConflict);
            if (field._flatpickr && field._flatpickr.altInput) {
                field._flatpickr.altInput.classList.toggle('booking-conflict-input', hasConflict);
            }
        }

        function checkAvailability() {
            var data = getVehicleData();
            var vehicleId = vehicleSel ? vehicleSel.value : '';
            var pickupValue = pickupDate ? pickupDate.value : '';
            var returnValue = returnDate ? returnDate.value : '';
            var bookingIdInput = document.querySelector('input[name="booking_id"]');
            var bookingId = bookingIdInput ? bookingIdInput.value : '0';

            if (!data || !vehicleId || !pickupValue) {
                setConflictState(false, '');
                return;
            }

            var token = ++availabilityRequestToken;
            var url = availabilityUrl +
                '?vehicle_id=' + encodeURIComponent(vehicleId) +
                '&pickup_date=' + encodeURIComponent(pickupValue) +
                '&return_date=' + encodeURIComponent(returnValue || pickupValue) +
                '&booking_id=' + encodeURIComponent(bookingId || '0');

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(result) {
                    if (token !== availabilityRequestToken) {
                        return;
                    }

                    if (result && result.available === false) {
                        setConflictState(true, result.message || 'Selected dates are not available for this car.');
                        return;
                    }

                    setConflictState(false, '');
                })
                .catch(function() {
                    if (token !== availabilityRequestToken) {
                        return;
                    }
                    setConflictState(false, '');
                });
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
            updateVehicleBookingNote();
            updateAmount();
            checkAvailability();
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

        function initPickers() {
            if (typeof flatpickr === 'undefined') {
                return;
            }

            pickupDatePicker = flatpickr('#pickup_date', {
                altInput: true,
                altInputClass: 'booking-picker-input date',
                altFormat: 'd-m-Y',
                dateFormat: 'Y-m-d',
                minDate: 'today',
                disableMobile: true,
                onChange: function(selectedDates, dateStr) {
                    if (returnDatePicker && dateStr) {
                        returnDatePicker.set('minDate', dateStr);
                        if (returnDate && returnDate.value && returnDate.value < dateStr) {
                            returnDatePicker.clear();
                        }
                    }
                    updateHoursDuration();
                    updateAmount();
                    checkAvailability();
                }
            });

            returnDatePicker = flatpickr('#return_date', {
                altInput: true,
                altInputClass: 'booking-picker-input date',
                altFormat: 'd-m-Y',
                dateFormat: 'Y-m-d',
                minDate: pickupDate && pickupDate.value ? pickupDate.value : 'today',
                disableMobile: true,
                onChange: function() {
                    updateHoursDuration();
                    updateAmount();
                    checkAvailability();
                }
            });

            pickupTimePicker = flatpickr('#pickup_time', {
                enableTime: true,
                noCalendar: true,
                dateFormat: 'h:i K',
                time_24hr: false,
                minuteIncrement: 15,
                disableMobile: true,
                position: 'auto left',
                onChange: function() {
                    updateHoursDuration();
                    updateAmount();
                    checkAvailability();
                }
            });

            returnTimePicker = flatpickr('#return_time', {
                enableTime: true,
                noCalendar: true,
                dateFormat: 'h:i K',
                time_24hr: false,
                minuteIncrement: 15,
                disableMobile: true,
                position: 'auto left',
                onChange: function() {
                    updateHoursDuration();
                    updateAmount();
                    checkAvailability();
                }
            });
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
                advanceHelper.textContent = needsAdvance() ?
                    'This amount will be paid on the next page.' :
                    'Advance is optional. If unchecked, your booking will finish after document upload.';
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

        if (vehicleSel) vehicleSel.addEventListener('change', function() {
            updateVehicleBookingNote();
            updateAmount();
            checkAvailability();
        });
        if (bookingTypeSel) bookingTypeSel.addEventListener('change', toggleBookingMode);
        if (requiresAdvanceChk) requiresAdvanceChk.addEventListener('change', updateAmount);
        if (slotSel) slotSel.addEventListener('change', updateAmount);
        if (kmInput) kmInput.addEventListener('input', updateAmount);

        [pickupDate, returnDate, pickupTimeInp, returnTimeInp].forEach(function(el) {
            if (el) el.addEventListener('change', function() {
                updateHoursDuration();
                updateAmount();
                checkAvailability();
            });
        });

        /* Run on load for edit mode pre-filled values */
        initPickers();
        updateHoursDuration();
        updateVehicleBookingNote();
        toggleBookingMode();
        updateAmount();
        checkAvailability();

    })();
</script>