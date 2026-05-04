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

    .stat-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 32px;
        opacity: 0.8;
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
        min-width: 1200px;
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
        padding: 16px 20px;
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

    /* ===== VEHICLE CARD ===== */
    .vehicle-id {
        font-weight: 700;
        color: #3b82f6;
    }

    .vehicle-thumb {
        width: 80px;
        height: 60px;
        border-radius: 10px;
        overflow: hidden;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .vehicle-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .vehicle-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .vehicle-details {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .vehicle-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 15px;
    }

    .vehicle-reg {
        font-size: 13px;
        color: #64748b;
    }

    /* ===== BADGE ===== */
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

    .badge-available {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-booked {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-service {
        background: #fef3c7;
        color: #92400e;
    }

    .badge::before {
        content: '●';
        font-size: 10px;
    }

    /* ===== TABLE ACTIONS ===== */
    .table-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-small {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        border: 1.5px solid;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-edit {
        background: #dbeafe;
        color: #0369a1;
        border-color: #bae6fd;
    }

    .btn-edit:hover {
        background: #bae6fd;
    }

    .btn-danger {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fecaca;
    }

    .btn-danger:hover {
        background: #fecaca;
    }

    /* ===== MODAL - FIXED CENTER ===== */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(6px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 9999;
        overflow-y: auto;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .modal-overlay.open {
        display: flex;
    }

    .modal-card {
        width: 100%;
        max-width: 900px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 28px 70px rgba(15, 23, 42, 0.2);
        padding: 32px;
        margin: auto;
        position: relative;
    }

    .modal-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 32px;
    }

    .modal-head h3 {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        color: #1e293b;
    }

    .modal-head p {
        margin: 8px 0 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .modal-close {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        border-color: #cbd5e1;
        color: #1e293b;
        background: white;
    }

    .modal-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .modal-grid .full {
        grid-column: 1 / -1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        color: #1e293b;
    }

    .form-group input,
    .form-group select {
        padding: 12px 14px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #1e293b;
        font: inherit;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .form-hint {
        font-size: 12px;
        color: #64748b;
        margin-top: 6px;
        line-height: 1.5;
    }

    /* ===== FILE UPLOAD ===== */
    .upload-box {
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-box:hover {
        border-color: #3b82f6;
        background: #f0f4ff;
    }

    .upload-box.drag-over {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .upload-box input[type="file"] {
        width: 100%;
        padding: 0;
        border: none;
        background: transparent;
        cursor: pointer;
    }

    .upload-box input[type="file"]::file-selector-button {
        display: none;
    }

    .upload-icon {
        font-size: 32px;
        margin-bottom: 12px;
        display: block;
    }

    .upload-text {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .upload-subtext {
        font-size: 12px;
        color: #64748b;
    }

    .modal-preview {
        margin-top: 16px;
        height: 180px;
        border-radius: 12px;
        overflow: hidden;
        border: 1.5px solid #e2e8f0;
        background: white;
    }

    .modal-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ===== MODAL ACTIONS ===== */
    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1.5px solid #e2e8f0;
    }

    .modal-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .btn-cancel {
        border: 1.5px solid #e2e8f0;
        background: white;
        color: #475569;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-save {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        padding: 40px;
        text-align: center;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
        display: block;
    }

    .empty-state-text {
        font-size: 16px;
        color: #64748b;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .page-wrapper {
            padding: 24px 16px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .modal-grid {
            grid-template-columns: 1fr;
        }

        .card-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .modal-card {
            padding: 24px;
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
            font-size: 12px;
        }

        .table-wrap th,
        .table-wrap td {
            padding: 12px 14px;
        }

        .vehicle-thumb {
            width: 60px;
            height: 45px;
        }

        .stat-number {
            font-size: 28px;
        }

        .modal-overlay {
            padding: 16px;
        }

        .modal-card {
            padding: 20px;
            max-width: calc(100% - 32px);
        }

        .modal-head {
            flex-direction: column;
            gap: 12px;
        }

        .modal-head h3 {
            font-size: 22px;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .modal-grid {
            gap: 16px;
        }
    }

    @media (max-width: 480px) {
        .page-wrapper {
            padding: 12px 8px;
        }

        .table-wrap {
            font-size: 11px;
        }

        .table-wrap th,
        .table-wrap td {
            padding: 10px 12px;
        }

        .modal-actions {
            flex-direction: column;
        }

        .modal-btn {
            width: 100%;
            justify-content: center;
        }

        .stat-icon {
            font-size: 24px;
        }

        .modal-card {
            padding: 16px;
        }

        .modal-head {
            margin-bottom: 20px;
        }
    }
</style>

<div class="page-wrapper">
    <!-- PAGE HEADER -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>🚗 Fleet Management</h1>
            <p>Manage your rental vehicles, pricing, and availability status</p>
        </div>
        <div class="page-header-actions">
            <button class="btn-icon" title="Refresh">🔄</button>
            <button class="btn-icon" title="Help">❓</button>
        </div>
    </div>

    <!-- STATS GRID -->
    <?php
    $total_vehicles = count($vehicles);
    $available_vehicles = 0;
    $booked_vehicles = 0;
    $service_vehicles = 0;

    foreach ($vehicles as $vehicle) {
        if ($vehicle['status'] === 'available') {
            $available_vehicles++;
        } elseif ($vehicle['status'] === 'booked') {
            $booked_vehicles++;
        } elseif ($vehicle['status'] === 'service') {
            $service_vehicles++;
        }
    }
    ?>
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-card-content">
                <span class="stat-label">Total Fleet</span>
                <span class="stat-number"><?php echo $total_vehicles; ?></span>
                <p class="stat-description">All vehicles in your system</p>
            </div>
            <span class="stat-icon">🚗</span>
        </div>

        <div class="stat-card green">
            <div class="stat-card-content">
                <span class="stat-label">Available Now</span>
                <span class="stat-number"><?php echo $available_vehicles; ?></span>
                <p class="stat-description">Ready for new bookings</p>
            </div>
            <span class="stat-icon">✅</span>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-content">
                <span class="stat-label">Booked / Service</span>
                <span class="stat-number"><?php echo $booked_vehicles + $service_vehicles; ?></span>
                <p class="stat-description">Assigned or under maintenance</p>
            </div>
            <span class="stat-icon">⚙️</span>
        </div>
    </div>

    <!-- VEHICLES TABLE SECTION -->
    <div class="section-card">
        <div class="card-head">
            <div>
                <h3>Vehicles</h3>
                <p>Add, edit or remove vehicles from your fleet. Update pricing, images, and availability status instantly.</p>
            </div>
            <button class="btn" type="button" id="openVehicleModal">
                ➕ Add Vehicle
            </button>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vehicle</th>
                        <th>Registration</th>
                        <th>Type</th>
                        <th>Fuel</th>
                        <th>Seats</th>
                        <th>Rate/KM</th>
                        <th>Advance</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($vehicles)): foreach ($vehicles as $vehicle): ?>
                            <?php $vehicle_image = isset($vehicle['image']) ? $vehicle['image'] : ''; ?>
                            <tr>
                                <td>
                                    <span class="vehicle-id">#<?php echo (int) $vehicle['id']; ?></span>
                                </td>
                                <td>
                                    <div class="vehicle-info">
                                        <div class="vehicle-thumb">
                                            <img src="<?php echo app_vehicle_image_url($vehicle_image); ?>" alt="<?php echo html_escape($vehicle['name']); ?>">
                                        </div>
                                        <div class="vehicle-details">
                                            <div class="vehicle-name"><?php echo html_escape($vehicle['name']); ?></div>
                                            <div class="vehicle-reg"><?php echo html_escape($vehicle['registration_no']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo html_escape($vehicle['registration_no']); ?></td>
                                <td><?php echo html_escape($vehicle['vehicle_type']); ?></td>
                                <td><?php echo html_escape($vehicle['fuel_type']); ?></td>
                                <td><?php echo (int) $vehicle['seats']; ?></td>
                                <td>₹<?php echo number_format((float) $vehicle['rate_per_day'], 0); ?></td>
                                <td>₹<?php echo number_format((float) $vehicle['advance_amount'], 0); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo html_escape($vehicle['status']); ?>">
                                        <?php echo ucfirst(html_escape($vehicle['status'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button
                                            class="btn-small btn-edit edit-vehicle-btn"
                                            type="button"
                                            data-id="<?php echo (int) $vehicle['id']; ?>"
                                            data-name="<?php echo html_escape($vehicle['name']); ?>"
                                            data-registration="<?php echo html_escape($vehicle['registration_no']); ?>"
                                            data-type="<?php echo html_escape($vehicle['vehicle_type']); ?>"
                                            data-fuel="<?php echo html_escape($vehicle['fuel_type']); ?>"
                                            data-seats="<?php echo (int) $vehicle['seats']; ?>"
                                            data-rate="<?php echo (float) $vehicle['rate_per_day']; ?>"
                                            data-advance="<?php echo (float) $vehicle['advance_amount']; ?>"
                                            data-status="<?php echo html_escape($vehicle['status']); ?>"
                                            data-image="<?php echo html_escape($vehicle_image); ?>">
                                            ✏️ Edit
                                        </button>
                                        <form method="post" action="<?php echo base_url('admin/vehicles/delete/' . (int) $vehicle['id']); ?>" style="display: inline;" onsubmit="return confirm('Delete this vehicle?');">
                                            <button class="btn-small btn-danger" type="submit">🗑️ Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <span class="empty-state-icon">📋</span>
                                    <p class="empty-state-text">No vehicles added yet. Click "Add Vehicle" to get started!</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL - CENTERED -->
<div class="modal-overlay" id="vehicleModal">
    <div class="modal-card">
        <div class="modal-head">
            <div>
                <h3 id="vehicleModalTitle">Add New Vehicle</h3>
                <p id="vehicleModalCopy">Create a new vehicle entry with all details, pricing, advance, and upload a compelling vehicle image.</p>
            </div>
            <button class="modal-close" type="button" id="closeVehicleModal">&times;</button>
        </div>

        <form method="post" action="<?php echo base_url('admin/vehicles/store'); ?>" enctype="multipart/form-data" id="vehicleForm">
            <div class="modal-grid">
                <div class="form-group">
                    <label>Vehicle Name</label>
                    <input type="text" name="name" id="vehicle_name" placeholder="e.g., Maruti Swift Dzire" required>
                </div>

                <div class="form-group">
                    <label>Registration No.</label>
                    <input type="text" name="registration_no" id="registration_no" placeholder="GJ01-XX-XXXX" required>
                </div>

                <div class="form-group">
                    <label>Vehicle Category</label>
                    <input type="text" name="vehicle_type" id="vehicle_type" placeholder="Sedan / SUV / Hatchback" required>
                </div>

                <div class="form-group">
                    <label>Fuel Type</label>
                    <input type="text" name="fuel_type" id="fuel_type" placeholder="Petrol / Diesel / CNG" required>
                </div>

                <div class="form-group">
                    <label>Seating Capacity</label>
                    <input type="number" name="seats" id="seats" placeholder="5" min="1" required>
                </div>

                <div class="form-group">
                    <label>Rate per Day (₹)</label>
                    <input type="number" step="0.01" name="rate_per_km" id="rate_per_km" placeholder="2000" required>
                </div>

                <div class="form-group">
                    <label>Required Advance (₹)</label>
                    <input type="number" step="0.01" name="advance_amount" id="advance_amount" placeholder="1000" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status">
                        <option value="available">✅ Available</option>
                        <option value="booked">❌ Booked</option>
                        <option value="service">⚙️ Service</option>
                    </select>
                    <div class="form-hint">Mark as "Service" when vehicle is under maintenance or temporarily unavailable.</div>
                </div>

                <div class="full form-group">
                    <label>Vehicle Image</label>
                    <div class="upload-box" id="uploadBox">
                        <span class="upload-icon">🖼️</span>
                        <p class="upload-text">Click to upload vehicle photo</p>
                        <p class="upload-subtext">JPG, PNG or WEBP • Max 4 MB</p>
                        <input type="file" name="vehicle_image" id="vehicle_image" accept=".jpg,.jpeg,.png,.webp">
                    </div>
                    <div class="modal-preview">
                        <img src="<?php echo app_vehicle_image_url(); ?>" alt="Vehicle preview" id="vehiclePreview">
                    </div>
                </div>
            </div>

            <div class="modal-actions">
                <button class="modal-btn btn-cancel" type="button" id="cancelVehicleModal">Cancel</button>
                <button class="modal-btn btn-save" type="submit" id="vehicleSubmitBtn">Add Vehicle</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function() {
        var modal = document.getElementById('vehicleModal');
        var form = document.getElementById('vehicleForm');
        var title = document.getElementById('vehicleModalTitle');
        var copy = document.getElementById('vehicleModalCopy');
        var submitBtn = document.getElementById('vehicleSubmitBtn');
        var openBtn = document.getElementById('openVehicleModal');
        var closeBtn = document.getElementById('closeVehicleModal');
        var cancelBtn = document.getElementById('cancelVehicleModal');
        var editButtons = document.querySelectorAll('.edit-vehicle-btn');
        var imageInput = document.getElementById('vehicle_image');
        var preview = document.getElementById('vehiclePreview');
        var uploadBox = document.getElementById('uploadBox');
        var baseStoreUrl = '<?php echo base_url('admin/vehicles/store'); ?>';
        var baseUpdateUrl = '<?php echo base_url('admin/vehicles/update/'); ?>';
        var defaultImage = '<?php echo app_vehicle_image_url(); ?>';

        function openModal() {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
            // Scroll modal to top
            modal.scrollTop = 0;
        }

        function closeModal() {
            modal.classList.remove('open');
            document.body.style.overflow = '';
            form.reset();
            form.action = baseStoreUrl;
            title.textContent = 'Add New Vehicle';
            copy.textContent = 'Create a new vehicle entry with all details, pricing, advance, and upload a compelling vehicle image.';
            submitBtn.textContent = 'Add Vehicle';
            if (preview) {
                preview.src = defaultImage;
            }
        }

        function setValue(id, value) {
            var field = document.getElementById(id);
            if (field) {
                field.value = value || '';
            }
        }

        openBtn.addEventListener('click', function() {
            closeModal();
            openModal();
        });

        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        // File upload handling
        if (imageInput && preview) {
            imageInput.addEventListener('change', function(event) {
                var file = event.target.files && event.target.files[0];
                if (!file) {
                    preview.src = defaultImage;
                    return;
                }
                preview.src = URL.createObjectURL(file);
            });
        }

        // Drag and drop
        if (uploadBox) {
            uploadBox.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadBox.classList.add('drag-over');
            });

            uploadBox.addEventListener('dragleave', function() {
                uploadBox.classList.remove('drag-over');
            });

            uploadBox.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadBox.classList.remove('drag-over');
                if (e.dataTransfer.files.length > 0) {
                    imageInput.files = e.dataTransfer.files;
                    var event = new Event('change', {
                        bubbles: true
                    });
                    imageInput.dispatchEvent(event);
                }
            });
        }

        // Edit buttons
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                form.action = baseUpdateUrl + button.getAttribute('data-id');
                title.textContent = 'Edit Vehicle';
                copy.textContent = 'Update vehicle details, rates, status, or upload a new image.';
                submitBtn.textContent = 'Save Changes';
                setValue('vehicle_name', button.getAttribute('data-name'));
                setValue('registration_no', button.getAttribute('data-registration'));
                setValue('vehicle_type', button.getAttribute('data-type'));
                setValue('fuel_type', button.getAttribute('data-fuel'));
                setValue('seats', button.getAttribute('data-seats'));
                setValue('rate_per_km', button.getAttribute('data-rate'));
                setValue('advance_amount', button.getAttribute('data-advance'));
                setValue('status', button.getAttribute('data-status'));
                if (preview) {
                    var imagePath = button.getAttribute('data-image');
                    preview.src = imagePath ? '<?php echo base_url(); ?>' + imagePath : defaultImage;
                }
                openModal();
            });
        });

        // Keyboard shortcut to close
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.classList.contains('open')) {
                closeModal();
            }
        });
    })();
</script>

<?php $this->load->view('admin/partials/footer'); ?>