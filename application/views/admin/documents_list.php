<?php $this->load->view('admin/partials/header'); ?>
<div class="section-card">
    <div class="card-head">
        <div>
            <h3>Documents Review</h3>
            <p>Review customer uploads, open the submitted file and approve or reject documents with admin notes.</p>
        </div>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Document Type</th>
                    <th>Booking</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($documents)): foreach ($documents as $document): ?>
                <tr>
                    <td>
                        <strong><?php echo html_escape($document['full_name']); ?></strong><br>
                        <span style="color:#64748b;"><?php echo html_escape($document['email']); ?></span>
                    </td>
                    <td><?php echo html_escape($document['document_type']); ?></td>
                    <td><?php echo !empty($document['booking_reference']) ? html_escape($this->General_model->format_booking_code($document['booking_reference'], $document['booking_created_at'])) . ' - ' . html_escape($document['vehicle_name']) : 'General'; ?></td>
                    <td><span class="badge badge-<?php echo html_escape($document['status']); ?>"><?php echo html_escape($document['status']); ?></span></td>
                    <td><?php echo html_escape($document['updated_at']); ?></td>
                    <td><a class="btn-secondary" href="<?php echo base_url($document['file_path']); ?>" target="_blank">Open</a></td>
                    <td><a class="btn" href="<?php echo base_url('admin/documents/review/'.(int) $document['id']); ?>">Review</a></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="7">No documents uploaded yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
