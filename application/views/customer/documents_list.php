<?php $this->load->view('customer/partials/header'); ?>
<div class="section-card">
    <div class="card-head">
        <div>
            <h3>My Documents</h3>
            <p>Upload your verification files and track which ones are approved, pending or still missing.</p>
        </div>
        <div class="progress-shell">
            <div class="progress-bar"><div class="progress-fill" style="width: <?php echo (int) $document_progress['percentage']; ?>%;"></div></div>
            <div style="font-size:13px;color:#64748b;"><?php echo (int) $document_progress['submitted']; ?> of <?php echo (int) $document_progress['total']; ?> submitted</div>
        </div>
    </div>

    <div class="docs-grid" style="margin-bottom:22px;">
        <?php foreach ($documents as $document): ?>
            <div class="doc-card">
                <div class="doc-left">
                    <div class="doc-icon"><?php echo strtoupper(substr($document['document_type'], 0, 1)); ?></div>
                    <div class="doc-meta">
                        <strong><?php echo html_escape($document['document_type']); ?></strong>
                        <span>
                            <?php
                            if ($document['status'] === 'missing') {
                                echo 'Not uploaded yet';
                            } elseif ($document['status'] === 'approved') {
                                echo 'Verified by admin';
                            } elseif ($document['status'] === 'rejected') {
                                echo 'Rejected - please re-upload';
                            } else {
                                echo 'Under review';
                            }
                            ?>
                        </span>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;justify-content:flex-end;">
                    <span class="badge badge-<?php echo html_escape($document['status']); ?>"><?php echo html_escape($document['status']); ?></span>
                    <?php if (!empty($document['file_path'])): ?>
                        <a class="btn-secondary" href="<?php echo base_url($document['file_path']); ?>" target="_blank">View</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="upload-panel">
        <div class="card-head">
            <div>
                <h3>Upload New Document</h3>
                <p>Submit a file in JPG, PNG or PDF format and it will appear in the review queue for the admin team.</p>
            </div>
        </div>
        <form method="post" action="<?php echo base_url('customer/documents/store'); ?>" enctype="multipart/form-data">
            <div class="form-grid">
                <div>
                    <label>Document Type</label>
                    <select name="document_type" required>
                        <option value="">Select document type</option>
                        <?php foreach ($this->General_model->get_document_types() as $document_type): ?>
                            <option value="<?php echo html_escape($document_type); ?>"><?php echo html_escape($document_type); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Related Booking</label>
                    <select name="booking_id">
                        <option value="0">General / Not linked</option>
                        <?php foreach ($bookings as $booking): ?>
                            <option value="<?php echo (int) $booking['id']; ?>"><?php echo html_escape($booking['booking_code']); ?> - <?php echo html_escape($booking['vehicle_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="full">
                    <label>Choose File</label>
                    <input type="file" name="document_file" accept=".jpg,.jpeg,.png,.pdf" required>
                    <div class="helper">Accepted formats: JPG, PNG and PDF. Maximum file size: 4 MB.</div>
                </div>
            </div>
            <p style="margin-top:18px;"><button class="btn" type="submit">Upload Document</button></p>
        </form>
    </div>
</div>
<?php $this->load->view('customer/partials/footer'); ?>
