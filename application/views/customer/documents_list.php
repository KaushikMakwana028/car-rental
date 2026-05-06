<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$document_map = isset($document_map) ? $document_map : array();
$required_types = isset($required_types) ? $required_types : array();
$booking = !empty($booking) ? $booking : array();
$can_continue_to_payment = !empty($can_continue_to_payment);
$current_step = isset($current_step) ? (int) $current_step : 2;
$booking_back_url = base_url('customer/bookings/create' . (!empty($booking['vehicle_id']) ? '?vehicle_id=' . (int) $booking['vehicle_id'] : ''));
$booking_back_url .= (strpos($booking_back_url, '?') === false ? '?' : '&') . 'booking_id=' . (int) $booking['id'] . '&customer_id=' . (int) $booking['customer_id'];
?>

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
                <div class="eyebrow">Documents</div>
                <h3>Upload the required files.</h3>
                <p>Add Aadhaar Card and Driving License as image or PDF files for this booking.</p>
            </div>
        </div>

        <div class="info-grid" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-bottom:20px;">
            <?php foreach ($required_types as $document_type): ?>
                <?php $document = isset($document_map[$document_type]) ? $document_map[$document_type] : array('status' => 'missing'); ?>
                <div class="feature-card">
                    <strong><?php echo html_escape($document_type); ?></strong>
                    <span>
                        Status:
                        <?php echo !empty($document['file_path']) ? html_escape(ucfirst($document['status'])) : 'Not uploaded'; ?>
                    </span>
                    <?php if (!empty($document['admin_notes'])): ?>
                        <span>Note: <?php echo html_escape($document['admin_notes']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($document['file_path'])): ?>
                        <div class="hero-actions" style="margin-top:12px;">
                            <a class="btn-secondary" href="<?php echo base_url($document['file_path']); ?>" target="_blank">View</a>
                            <a class="btn-secondary" href="<?php echo base_url('customer/documents/delete/' . (int) $document['id'] . '?customer_id=' . (int) $booking['customer_id']); ?>" onclick="return confirm('Delete this document?');">Delete</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="post" action="<?php echo base_url('customer/documents/store'); ?>" enctype="multipart/form-data">
            <input type="hidden" name="booking_id" value="<?php echo (int) $booking['id']; ?>">
            <input type="hidden" name="customer_id" value="<?php echo (int) $booking['customer_id']; ?>">
            <div class="form-grid">
                <?php
                $field_map = array('aadhaar_file' => 'Aadhaar Card', 'driving_license_file' => 'Driving License');
                foreach ($field_map as $field_name => $document_type):
                    $has_file = !empty($document_map[$document_type]['file_path']);
                ?>
                    <div>
                        <label><?php echo $document_type; ?></label>
                        <?php if ($has_file): ?>
                            <p style="color:#1a8a4a;font-size:13px;font-weight:600;margin:4px 0;">
                                ✓ Already uploaded &nbsp;
                                <!-- <a href="<?php echo base_url($document_map[$document_type]['file_path']); ?>" target="_blank"
                                    style="color:var(--accent);font-weight:600;">View</a> -->
                            </p>
                            <label style="display:inline-flex;align-items:center;gap:6px;margin-top:6px;font-size:13px;color:#666;cursor:pointer;">
                                <input type="checkbox" style="width:15px;height:15px;cursor:pointer;accent-color:var(--accent);"
                                    onchange="document.getElementById('<?php echo $field_name; ?>').style.display=this.checked?'block':'none'">
                                Replace document
                            </label>
                            <input type="file" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>"
                                accept=".jpg,.jpeg,.png,.pdf"
                                style="display:none;margin-top:8px;font-size:13px;">
                        <?php else: ?>
                            <input type="file" name="<?php echo $field_name; ?>" accept=".jpg,.jpeg,.png,.pdf" required>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="booking-actions">
                <a class="btn-secondary" href="<?php echo $booking_back_url; ?>">Previous Step</a>
                <?php
                $all_uploaded = !empty($document_map['Aadhaar Card']['file_path']) && !empty($document_map['Driving License']['file_path']);
                ?>
                <?php if ($all_uploaded): ?>
                    <a class="btn" href="<?php echo base_url('customer/payments/pay/' . (int)$booking['id'] . '?customer_id=' . (int)$booking['customer_id']); ?>">Continue to Payment</a>
                <?php else: ?>
                    <button class="btn" type="submit">Upload Documents and Continue</button>
                <?php endif; ?>
                <a class="btn-secondary" href="<?php echo base_url('customer/dashboard'); ?>">Cancel</a>
            </div>
        </form>
    </section>

    <aside class="section-card accent-card">
        <div class="eyebrow">Booking</div>
        <div class="card-head">
            <div>
                <h3>Current booking summary.</h3>
                <p>Upload both documents, then move to advance payment.</p>
            </div>
        </div>
        <div class="info-grid" style="grid-template-columns:1fr;">
            <div class="feature-card">
                <strong><?php echo html_escape($booking['booking_code']); ?></strong>
                <span><?php echo html_escape($booking['vehicle_name']); ?></span>
            </div>
            <div class="feature-card">
                <strong>Trip</strong>
                <span><?php echo html_escape($booking['trip_label']); ?></span>
            </div>
            <div class="feature-card">
                <strong>Route</strong>
                <span><?php echo html_escape($booking['trip_route']); ?></span>
            </div>
            <div class="feature-card">
                <strong>Advance</strong>
                <span>&#8377;<?php echo number_format((float) $booking['advance_due'], 2); ?></span>
            </div>
        </div>
    </aside>
</div>