<?php $this->load->view('admin/partials/header'); ?>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-top"><div class="stat-label">Total Collected</div><div class="stat-chip">This Month</div></div>
        <div class="stat-value money-good"><?php echo number_format((float) $payment_summary['total_collected'], 2); ?></div>
        <div class="stat-note">All payment entries recorded inside the system.</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><div class="stat-label">Advance Received</div><div class="stat-chip">Deposits</div></div>
        <div class="stat-value money-warn"><?php echo number_format((float) $payment_summary['advance_received'], 2); ?></div>
        <div class="stat-note">Advance amounts already collected from active bookings.</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><div class="stat-label">Remaining to Collect</div><div class="stat-chip">Pending</div></div>
        <div class="stat-value money-danger"><?php echo number_format((float) $payment_summary['remaining_to_collect'], 2); ?></div>
        <div class="stat-note">Outstanding balances still expected from booking totals.</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><div class="stat-label">Refunds Issued</div><div class="stat-chip">Adjustments</div></div>
        <div class="stat-value"><?php echo number_format((float) $payment_summary['refunds_issued'], 2); ?></div>
        <div class="stat-note">Recorded refund payments or reversals.</div>
    </div>
</div>

<div class="split-grid">
    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>Payment Timeline<?php if (!empty($featured_booking)): ?> - <?php echo html_escape($featured_booking['booking_code']); ?> <?php echo html_escape($featured_booking['customer_name']); ?><?php endif; ?></h3>
                <p>Track the latest booking's payment flow from advance collection to pending final settlement.</p>
            </div>
        </div>
        <?php if (!empty($featured_booking)): ?>
            <div class="timeline">
                <?php if (!empty($featured_timeline)): foreach ($featured_timeline as $payment): ?>
                    <div class="timeline-item">
                        <div class="timeline-dot <?php echo $payment['payment_type'] === 'refund' ? 'danger' : ($payment['payment_type'] === 'advance' ? 'success' : 'warn'); ?>">
                            <?php echo $payment['payment_type'] === 'refund' ? 'R' : ($payment['payment_type'] === 'advance' ? 'A' : 'P'); ?>
                        </div>
                        <div class="timeline-body">
                            <strong><?php echo ucwords(str_replace('_', ' ', $payment['payment_type'])); ?></strong>
                            <span><?php echo html_escape($payment['payment_mode']); ?><?php echo !empty($payment['reference_no']) ? ' | Ref: '.html_escape($payment['reference_no']) : ''; ?></span>
                        </div>
                        <strong><?php echo number_format((float) $payment['amount'], 2); ?></strong>
                    </div>
                <?php endforeach; endif; ?>
                <div class="timeline-item">
                    <div class="timeline-dot danger">F</div>
                    <div class="timeline-body">
                        <strong>Final collection balance</strong>
                        <span>Estimated from booking amount minus all recorded payments.</span>
                    </div>
                    <strong class="money-danger">
                        <?php
                        $paid = 0;
                        foreach ($featured_timeline as $item) { $paid += (float) $item['amount']; }
                        echo number_format(max(0, (float) $featured_booking['amount'] - $paid), 2);
                        ?>
                    </strong>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">No bookings are available yet for payment tracking.</div>
        <?php endif; ?>
    </div>

    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>Record Payment</h3>
                <p>Add a payment entry against any booking using a simple form.</p>
            </div>
        </div>
        <form method="post" action="<?php echo base_url('admin/payments/store'); ?>">
            <div class="form-grid">
                <div class="full">
                    <label>Booking ID</label>
                    <select name="booking_id" required>
                        <option value="">Select booking</option>
                        <?php foreach ($bookings as $booking): ?>
                            <option value="<?php echo $booking['id']; ?>"><?php echo html_escape($booking['booking_code']); ?> - <?php echo html_escape($booking['customer_name'].' - '.$booking['vehicle_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="full">
                    <label>Payment Type</label>
                    <select name="payment_type" required>
                        <option value="advance">Advance Payment</option>
                        <option value="trip_start">Trip Start Payment</option>
                        <option value="final">Final Payment</option>
                        <option value="refund">Refund</option>
                    </select>
                </div>
                <div><label>Amount</label><input type="number" step="0.01" name="amount" placeholder="Enter amount" required></div>
                <div>
                    <label>Payment Mode</label>
                    <select name="payment_mode" required>
                        <option value="Cash">Cash</option>
                        <option value="UPI">UPI</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Card">Card</option>
                    </select>
                </div>
                <div class="full"><label>Reference / Transaction ID</label><input type="text" name="reference_no" placeholder="e.g. UPI ref no."></div>
                <div class="full"><label>Notes</label><textarea name="notes" rows="3" placeholder="Optional payment notes"></textarea></div>
            </div>
            <p style="margin-top:18px;"><button class="btn" type="submit">Record Payment</button></p>
        </form>
    </div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
