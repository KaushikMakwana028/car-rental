<?php $this->load->view('admin/partials/header'); ?>
<div class="section-card">
    <div class="card-head">
        <div>
            <h3>Customers</h3>
            <p>All registered customers, booking totals, spending and last activity in one clear light-theme table.</p>
        </div>
        <a class="btn" href="<?php echo base_url('register'); ?>">Add Customer</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Total Bookings</th>
                    <th>Total Spent</th>
                    <th>Docs</th>
                    <th>Last Booking</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($customers)): foreach ($customers as $customer): ?>
                <tr>
                    <td>
                        <strong><?php echo html_escape($customer['full_name']); ?></strong><br>
                        <span style="color:#64748b;"><?php echo html_escape($customer['email']); ?></span>
                    </td>
                    <td><?php echo html_escape($customer['phone']); ?></td>
                    <td><?php echo (int) $customer['total_bookings']; ?></td>
                    <td><?php echo number_format((float) $customer['total_spent'], 2); ?></td>
                    <td><span class="badge badge-<?php echo html_escape($customer['doc_status']); ?>"><?php echo html_escape($customer['doc_status']); ?></span></td>
                    <td><?php echo !empty($customer['last_booking']) ? html_escape($customer['last_booking']) : 'No bookings'; ?></td>
                    <td><a class="btn-secondary" href="<?php echo base_url('admin/bookings'); ?>">View</a></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="7">No customers found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
