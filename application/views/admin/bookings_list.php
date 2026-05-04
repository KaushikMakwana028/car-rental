<?php $this->load->view('admin/partials/header'); ?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f8fafc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* ===== PAGE HEADER ===== */
    .page-header {
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-header-content h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .page-header-content p {
        font-size: 15px;
        color: #64748b;
        line-height: 1.6;
    }

    .page-header-actions {
        display: flex;
        gap: 12px;
    }

    .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: none;
        background: #e2e8f0;
        color: #475569;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        background: #cbd5e1;
        color: #1e293b;
    }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(99, 102, 241, 0.05));
        border-radius: 50%;
    }

    .stat-card-content {
        position: relative;
        z-index: 1;
    }

    .stat-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 12px;
    }

    .stat-number {
        display: block;
        font-size: 36px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .stat-description {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
    }

    .stat-card.blue {
        border-left: 4px solid #3b82f6;
    }

    .stat-card.green {
        border-left: 4px solid #10b981;
    }

    .stat-card.orange {
        border-left: 4px solid #f59e0b;
    }

    .stat-card.purple {
        border-left: 4px solid #8b5cf6;
    }

    /* ===== SECTION CARD ===== */
    .section-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .card-head {
        padding: 28px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .card-head>div {
        flex: 1;
    }

    .card-head h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .card-head p {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
    }

    /* ===== BUTTONS ===== */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        text-decoration: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn:active {
        transform: translateY(0);
    }

    /* ===== TABLE ===== */
    .table-wrap {
        overflow-x: auto;
    }

    .table-wrap table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-wrap thead {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-wrap th {
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #64748b;
    }

    .table-wrap td {
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
        color: #1e293b;
    }

    .table-wrap tbody tr {
        transition: all 0.3s ease;
    }

    .table-wrap tbody tr:hover {
        background: #f8fafc;
    }

    .table-wrap tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== BOOKING DETAILS ===== */
    .booking-id {
        font-weight: 700;
        color: #3b82f6;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .booking-date {
        font-size: 12px;
        color: #64748b;
    }

    .customer-info,
    .vehicle-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .customer-name,
    .vehicle-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 15px;
    }

    .customer-phone,
    .vehicle-reg {
        font-size: 12px;
        color: #64748b;
    }

    .trip-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        background: #dbeafe;
        color: #1e40af;
        font-size: 12px;
        font-weight: 600;
        width: fit-content;
    }

    .route-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .pickup-location {
        font-weight: 700;
        color: #1e293b;
        font-size: 14px;
    }

    .drop-location {
        font-size: 12px;
        color: #64748b;
    }

    .km-display {
        font-weight: 700;
        color: #1e293b;
        font-size: 15px;
    }

    .amount-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .amount-total {
        font-weight: 700;
        color: #1e293b;
        font-size: 15px;
    }

    .amount-balance {
        font-size: 12px;
        color: #64748b;
    }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .payment-badge.paid {
        background: #dcfce7;
        color: #15803d;
    }

    .payment-badge.advance-received {
        background: #ffedd5;
        color: #b45309;
    }

    .payment-badge.part-paid {
        background: #fef3c7;
        color: #b45309;
    }

    .payment-badge.pending {
        background: #fee2e2;
        color: #991b1b;
    }

    .paid-amount {
        font-size: 12px;
        color: #64748b;
    }

    /* ===== STATUS BADGE ===== */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-confirmed {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-completed {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        padding: 60px 40px;
        text-align: center;
    }

    .empty-state-text {
        font-size: 16px;
        color: #64748b;
        margin-bottom: 16px;
    }

    .empty-state-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .empty-state-btn:hover {
        transform: translateY(-2px);
    }

    /* ===== FILTERS & SEARCH ===== */
    .table-filters {
        padding: 20px 28px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input,
    .filter-select {
        padding: 8px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        background: white;
        color: #1e293b;
        transition: all 0.3s ease;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1200px) {
        .table-wrap {
            font-size: 13px;
        }

        .table-wrap th,
        .table-wrap td {
            padding: 16px;
        }

        .stat-number {
            font-size: 28px;
        }
    }

    @media (max-width: 1024px) {
        .page-wrapper {
            padding: 24px 16px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .card-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .table-wrap {
            font-size: 12px;
        }

        .table-wrap th,
        .table-wrap td {
            padding: 12px;
        }
    }

    @media (max-width: 768px) {
        .page-wrapper {
            padding: 16px 12px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .table-wrap {
            font-size: 11px;
        }

        .table-wrap th,
        .table-wrap td {
            padding: 10px;
        }

        .stat-number {
            font-size: 24px;
        }

        .customer-name,
        .vehicle-name,
        .pickup-location {
            font-size: 13px;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .table-filters {
            flex-direction: column;
            align-items: flex-start;
            padding: 16px 20px;
        }

        .filter-group {
            width: 100%;
        }

        .filter-input,
        .filter-select {
            flex: 1;
        }
    }

    @media (max-width: 480px) {
        .table-wrap {
            font-size: 10px;
        }

        .table-wrap th,
        .table-wrap td {
            padding: 8px;
        }

        .page-header-content h1 {
            font-size: 24px;
        }

        .stat-card {
            padding: 20px;
        }

        .stat-number {
            font-size: 20px;
        }

        .stat-label {
            font-size: 11px;
        }
    }
</style>

<div class="page-wrapper">
    <!-- PAGE HEADER -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>Bookings Management</h1>
            <p>Track all reservations, payments, and trip details in one place</p>
        </div>
        <div class="page-header-actions">
            <button class="btn-icon" title="Refresh">↻</button>
            <button class="btn-icon" title="Help">?</button>
        </div>
    </div>

    <!-- STATS GRID -->
    <?php
    $total_bookings = count($bookings);
    $confirmed_bookings = 0;
    $pending_bookings = 0;
    $completed_bookings = 0;
    $booking_revenue = 0;

    foreach ($bookings as $booking) {
        $booking_revenue += (float) $booking['amount'];

        if ($booking['status'] === 'confirmed') {
            $confirmed_bookings++;
        } elseif ($booking['status'] === 'pending') {
            $pending_bookings++;
        } elseif ($booking['status'] === 'completed') {
            $completed_bookings++;
        }
    }
    ?>
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-card-content">
                <span class="stat-label">Total Bookings</span>
                <span class="stat-number"><?php echo $total_bookings; ?></span>
                <p class="stat-description">All reservations in the system</p>
            </div>
        </div>

        <div class="stat-card green">
            <div class="stat-card-content">
                <span class="stat-label">Confirmed Trips</span>
                <span class="stat-number"><?php echo $confirmed_bookings; ?></span>
                <p class="stat-description">Approved and ready to go</p>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-content">
                <span class="stat-label">Pending Review</span>
                <span class="stat-number"><?php echo $pending_bookings; ?></span>
                <p class="stat-description">Awaiting admin confirmation</p>
            </div>
        </div>

        <div class="stat-card purple">
            <div class="stat-card-content">
                <span class="stat-label">Total Revenue</span>
                <span class="stat-number">₹<?php echo number_format($booking_revenue, 0); ?></span>
                <p class="stat-description">Combined booking amount</p>
            </div>
        </div>
    </div>

    <!-- BOOKINGS TABLE SECTION -->
    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>All Bookings</h3>
                <p>View all reservations with customer details, vehicle information, route, payment status and booking confirmation.</p>
            </div>
            <a class="btn" href="<?php echo base_url('admin/bookings/create'); ?>">Create Booking</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Trip Type</th>
                        <th>Route</th>
                        <th>Distance</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Booking Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): foreach ($bookings as $booking): ?>
                            <tr>
                                <!-- Booking ID -->
                                <td>
                                    <div class="booking-id"><?php echo html_escape($booking['booking_code']); ?></div>
                                    <div class="booking-date">
                                        <?php echo !empty($booking['created_at']) ? date('d M Y', strtotime($booking['created_at'])) : '-'; ?>
                                    </div>
                                </td>

                                <!-- Customer Info -->
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-name"><?php echo html_escape($booking['customer_name']); ?></div>
                                        <div class="customer-phone"><?php echo html_escape($booking['customer_phone']); ?></div>
                                    </div>
                                </td>

                                <!-- Vehicle Info -->
                                <td>
                                    <div class="vehicle-info">
                                        <div class="vehicle-name"><?php echo html_escape($booking['vehicle_name']); ?></div>
                                        <div class="vehicle-reg"><?php echo html_escape($booking['registration_no']); ?></div>
                                    </div>
                                </td>

                                <!-- Trip Type -->
                                <td>
                                    <span class="trip-badge"><?php echo html_escape($booking['trip_label']); ?></span>
                                </td>

                                <!-- Route Info -->
                                <td>
                                    <div class="route-info">
                                        <div class="pickup-location"><?php echo html_escape($booking['pickup_location']); ?></div>
                                        <div class="drop-location">Drop: <?php echo html_escape($booking['drop_location']); ?></div>
                                    </div>
                                </td>

                                <!-- Distance -->
                                <td>
                                    <div class="km-display"><?php echo html_escape($booking['display_km']); ?></div>
                                </td>

                                <!-- Amount -->
                                <td>
                                    <div class="amount-info">
                                        <div class="amount-total">₹<?php echo number_format((float) $booking['amount'], 0); ?></div>
                                        <div class="amount-balance">Balance: ₹<?php echo number_format((float) $booking['balance_amount'], 0); ?></div>
                                    </div>
                                </td>

                                <!-- Payment Status -->
                                <td>
                                    <span class="payment-badge <?php echo html_escape($booking['payment_badge']); ?>">
                                        <?php echo html_escape($booking['payment_status']); ?>
                                    </span>
                                    <div class="paid-amount">Paid: ₹<?php echo number_format((float) $booking['paid_amount'], 0); ?></div>
                                </td>

                                <!-- Booking Status -->
                                <td>
                                    <span class="badge badge-<?php echo html_escape($booking['status']); ?>">
                                        <?php echo ucfirst(html_escape($booking['status'])); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <p class="empty-state-text">No bookings available yet</p>
                                    <a href="<?php echo base_url('admin/bookings/create'); ?>" class="empty-state-btn">Create First Booking</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/footer'); ?>