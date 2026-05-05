<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$document_gate = isset($document_gate) ? $document_gate : array(
    'is_ready' => false,
    'approved_count' => 0,
    'required_count' => 0,
    'missing_documents' => array(),
    'pending_documents' => array(),
    'rejected_documents' => array(),
);
$available_document_types = array();
foreach ($documents as $document) {
    if ($document['status'] === 'missing') {
        $available_document_types[] = $document['document_type'];
    }
}
?>

<section class="section-card">
    <div class="card-head">
        <div>
            <div class="eyebrow">Verification</div>
            <h3>My documents and approval progress.</h3>
            <p>Upload each file once, track the review result, and unlock booking only after the admin approves the required documents.</p>
        </div>
        <div class="progress-shell">
            <div class="progress-bar"><div class="progress-fill" style="width: <?php echo (int) $document_progress['percentage']; ?>%;"></div></div>
            <div class="text-muted"><?php echo (int) $document_progress['submitted']; ?> of <?php echo (int) $document_progress['total']; ?> submitted</div>
        </div>
    </div>

    <?php if (!empty($document_gate['is_ready'])): ?>
        <div class="flash flash-success" style="margin-bottom:20px;">All required documents are approved. Booking is now available on your account.</div>
    <?php else: ?>
        <div class="flash flash-error" style="margin-bottom:20px;">
            Booking stays locked until admin approval is complete.
            <?php if (!empty($document_gate['pending_documents'])): ?>
                Under review: <?php echo html_escape(implode(', ', $document_gate['pending_documents'])); ?>.
            <?php endif; ?>
            <?php if (!empty($document_gate['missing_documents'])): ?>
                Not uploaded: <?php echo html_escape(implode(', ', $document_gate['missing_documents'])); ?>.
            <?php endif; ?>
            <?php if (!empty($document_gate['rejected_documents'])): ?>
                Upload again: <?php echo html_escape(implode(', ', $document_gate['rejected_documents'])); ?>.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="info-grid" style="grid-template-columns:repeat(auto-fit,minmax(180px,1fr));margin-bottom:24px;">
        <div class="feature-card">
            <strong>Required Approved</strong>
            <span><?php echo (int) $document_gate['approved_count']; ?> / <?php echo (int) $document_gate['required_count']; ?> ready for booking.</span>
        </div>
        <div class="feature-card">
            <strong>Pending Review</strong>
            <span><?php echo !empty($document_gate['pending_documents']) ? html_escape(implode(', ', $document_gate['pending_documents'])) : 'No document waiting right now.'; ?></span>
        </div>
        <div class="feature-card">
            <strong>Need Action</strong>
            <span>
                <?php
                $needs_action = array_merge($document_gate['missing_documents'], $document_gate['rejected_documents']);
                echo !empty($needs_action) ? html_escape(implode(', ', $needs_action)) : 'Everything required is already handled.';
                ?>
            </span>
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
                                echo 'Not uploaded';
                            } elseif ($document['status'] === 'approved') {
                                echo 'Verified by admin';
                            } elseif ($document['status'] === 'rejected') {
                                echo 'Rejected. Please upload a clear file again.';
                            } else {
                                echo 'Pending admin approval';
                            }
                            ?>
                        </span>
                        <?php if (!empty($document['admin_notes'])): ?>
                            <span style="color:#6b6050;">Note: <?php echo html_escape($document['admin_notes']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;justify-content:flex-end;">
                    <span class="badge badge-<?php echo html_escape($document['status']); ?>"><?php echo html_escape(ucfirst($document['status'])); ?></span>
                    <?php if (!empty($document['file_path'])): ?>
                        <a class="btn-secondary" href="<?php echo base_url($document['file_path']); ?>" target="_blank">View</a>
                        <a class="btn-secondary" href="<?php echo base_url('customer/documents/delete/' . (int) $document['id']); ?>" onclick="return confirm('Delete this document?');">Delete</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="upload-panel">
        <div class="card-head">
            <div>
                <div class="eyebrow">Upload</div>
                <h3>Upload a new document.</h3>
                <p>Accepted formats: JPG, PNG, PDF. Uploaded document types are removed from the list until the customer deletes that document.</p>
            </div>
        </div>
        <?php if (!empty($available_document_types)): ?>
            <form method="post" action="<?php echo base_url('customer/documents/store'); ?>" enctype="multipart/form-data">
                <div class="form-grid">
                    <div>
                        <label>Document Type</label>
                        <select name="document_type" required>
                            <option value="">Select document type</option>
                            <?php foreach ($available_document_types as $document_type): ?>
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
                        <input class="js-document-file" type="file" name="document_file" accept=".jpg,.jpeg,.png,.pdf" required>
                        <div class="helper js-document-file-name">No file selected yet. Maximum file size: 4 MB.</div>
                    </div>
                </div>
                <div class="hero-actions">
                    <button class="btn" type="submit">Upload Document</button>
                    <?php if (!empty($document_gate['is_ready'])): ?>
                        <a class="btn-secondary" href="<?php echo base_url('customer/bookings/create'); ?>">Create Booking</a>
                    <?php else: ?>
                        <a class="btn-secondary" href="<?php echo base_url('customer/bookings'); ?>">View My Bookings</a>
                    <?php endif; ?>
                </div>
            </form>
        <?php else: ?>
            <div class="feature-card">
                <strong>All document types are already uploaded.</strong>
                <span>Delete an existing document if you want to upload that same document type again.</span>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    (function () {
        var input = document.querySelector('.js-document-file');
        var fileName = document.querySelector('.js-document-file-name');

        if (!input || !fileName) {
            return;
        }

        input.addEventListener('change', function () {
            if (input.files && input.files.length > 0) {
                fileName.textContent = input.files[0].name;
            } else {
                fileName.textContent = 'No file selected yet. Maximum file size: 4 MB.';
            }
        });
    })();
</script>
