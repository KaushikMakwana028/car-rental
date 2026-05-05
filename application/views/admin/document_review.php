<div class="split-grid">
    <div class="section-card">
        <div class="card-head">
            <div>
                <h3><?php echo html_escape($document['document_type']); ?></h3>
                <p>Review the uploaded file, confirm the customer details and update its verification status.</p>
            </div>
            <a class="btn-secondary" href="<?php echo base_url($document['file_path']); ?>" target="_blank">Open File</a>
        </div>
        <div class="mini-list">
            <div class="mini-item"><strong>Customer</strong><span><?php echo html_escape($document['full_name']); ?> | <?php echo html_escape($document['email']); ?> | <?php echo html_escape($document['phone']); ?></span></div>
            <div class="mini-item"><strong>Booking Reference</strong><span><?php echo !empty($document['booking_reference']) ? html_escape($this->General_model->format_booking_code($document['booking_reference'], $document['booking_created_at'])) . ' - ' . html_escape($document['vehicle_name']) : 'General document'; ?></span></div>
            <div class="mini-item"><strong>Current Status</strong><span><?php echo html_escape($document['status']); ?></span></div>
        </div>
    </div>

    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>Review Action</h3>
                <p>Approve the document if it is valid, or reject it with clear notes for the customer.</p>
            </div>
        </div>
        <form method="post" action="<?php echo base_url('admin/documents/update-status'); ?>">
            <input type="hidden" name="document_id" value="<?php echo (int) $document['id']; ?>">
            <div class="form-grid">
                <div class="full">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="pending" <?php echo $document['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="approved" <?php echo $document['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="rejected" <?php echo $document['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>
                <div class="full">
                    <label>Admin Notes</label>
                    <textarea name="admin_notes" rows="5" placeholder="Add review notes for the customer."><?php echo html_escape($document['admin_notes']); ?></textarea>
                </div>
            </div>
            <p style="margin-top:18px;"><button class="btn" type="submit">Update Review</button></p>
        </form>
    </div>
</div>
