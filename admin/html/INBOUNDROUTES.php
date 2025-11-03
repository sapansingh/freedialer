<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbound Routes Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --info-color: #4895ef;
            --warning-color: #f72585;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .main-container {
            background-color: #FFF;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            height: calc(100vh - 40px);
            display: flex;
            flex-direction: column;
        }
        
        .header-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header-title i {
            font-size: 1.8rem;
        }
        
        .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .content-section {
            flex: 1;
            overflow: auto;
            padding: 25px;
            background-color: #f8fafc;
        }
        
        .footer-section {
            padding: 15px 25px;
            background-color: #f1f5f9;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: #64748b;
        }
        
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }
        
        .table-container:hover {
            box-shadow: var(--hover-shadow);
        }
        
        /* DataTables Custom Styling */
        .dataTables_wrapper {
            padding: 0;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            padding: 15px 20px;
        }
        
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.9rem;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 10px;
            width: 200px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px;
            margin: 0 3px;
            border: 1px solid #e2e8f0;
            color: var(--primary-color) !important;
            font-weight: 500;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: rgba(67, 97, 238, 0.1) !important;
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }
        
        table.dataTable thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 16px 12px;
            font-weight: 600;
            font-size: 0.9rem;
            text-align: center;
            position: sticky;
            top: 0;
        }
        
        table.dataTable tbody td {
            padding: 14px 12px;
            vertical-align: middle;
            border-color: #f1f3f4;
            font-size: 0.9rem;
            text-align: center;
        }
        
        table.dataTable tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05) !important;
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
        
        .action-buttons .btn {
            padding: 6px 10px;
            margin: 0 2px;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }
        
        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .app-value-btn {
            background: none;
            border: none;
            color: #0A7CFF;
            font-weight: 500;
            transition: all 0.2s ease;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .app-value-btn:hover {
            color: #00C000;
            background-color: rgba(10, 124, 255, 0.1);
            text-decoration: none;
            transform: translateY(-1px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-outline-secondary {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            transform: translateY(-2px);
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px 12px 0 0;
        }
        
        .form-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #e2e8f0;
        }
        
        .section-title i {
            font-size: 1.2rem;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #334155;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        .trunks-display {
            min-height: 42px;
            background-color: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .trunk-badge {
            background: linear-gradient(135deg, var(--info-color), var(--primary-color));
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .stats-container {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            flex: 1;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-info h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
        }
        
        .stat-info p {
            margin: 0;
            color: #64748b;
            font-size: 0.9rem;
        }
        
        /* Notification System */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            max-width: 350px;
        }
        
        .notification {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            padding: 15px 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.4s ease;
            border-left: 4px solid;
        }
        
        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .notification.success {
            border-left-color: #10b981;
        }
        
        .notification.error {
            border-left-color: #ef4444;
        }
        
        .notification.warning {
            border-left-color: #f59e0b;
        }
        
        .notification.info {
            border-left-color: #3b82f6;
        }
        
        .notification-icon {
            font-size: 1.5rem;
        }
        
        .notification.success .notification-icon {
            color: #10b981;
        }
        
        .notification.error .notification-icon {
            color: #ef4444;
        }
        
        .notification.warning .notification-icon {
            color: #f59e0b;
        }
        
        .notification.info .notification-icon {
            color: #3b82f6;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .notification-message {
            font-size: 0.9rem;
            color: #64748b;
        }
        
        .notification-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .notification-close:hover {
            color: #64748b;
        }
        
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            border-radius: 12px;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .stats-container {
                flex-direction: column;
            }
            
            .action-buttons .btn {
                margin-bottom: 3px;
            }
            
            .notification-container {
                left: 20px;
                right: 20px;
                max-width: none;
            }
            
            .dataTables_wrapper .dataTables_filter input {
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>
    
    <div class="main-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-title">
                <i class="fas fa-route"></i>
                <span>INBOUND ROUTES MANAGEMENT</span>
            </div>
            
            <div class="header-actions">
                <div class="header-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRouteModal">
                        <i class="fas fa-plus me-1"></i> Add Route
                    </button>
                    <button class="btn btn-outline-secondary" id="refreshBtn">
                        <i class="fas fa-sync-alt me-1"></i> Refresh
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Content Section -->
        <div class="content-section">
            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="fas fa-route"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="totalRoutes">0</h3>
                        <p>Total Routes</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4ade80, #22c55e);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="activeRoutes">0</h3>
                        <p>Active Routes</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="inactiveRoutes">0</h3>
                        <p>Inactive Routes</p>
                    </div>
                </div>
            </div>
            
            <!-- Routes Table -->
            <div class="table-container" style="position: relative;">
                <div class="loading-overlay" id="tableLoading" style="display: none;">
                    <div class="spinner"></div>
                </div>
                <div class="table-responsive">
                    <table id="routesTable" class="table table-hover display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th> 
                                <th>Route Name</th>
                                <th>DID Number</th>
                                <th>Application Type</th>
                                <th>Application Value</th>
                                <th>Channels</th>
                                <th>Status</th>
                                <th>Actions</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by DataTable -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Footer Section -->
        <div class="footer-section">
            <div>
                ConVox CCS v2.0 | Inbound Routes Management
            </div>
            <div>
                <span id="lastUpdated">Last updated: Just now</span>
            </div>
        </div>
    </div>

    <!-- Add Route Modal -->
    <div class="modal fade" id="addRouteModal" tabindex="-1" aria-labelledby="addRouteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRouteModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Add New Inbound Route
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="routeForm">
                        <input type="hidden" id="route_id" name="route_id">
                        
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Basic Information
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="route_name" class="form-label required">Route Name</label>
                                    <input type="text" class="form-control" id="route_name" name="route_name" required>
                                    <div class="form-text">Unique identifier for this route</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="did_num" class="form-label required">DID Number</label>
                                    <input type="text" class="form-control" id="did_num" name="did_num" required>
                                    <div class="form-text">Direct Inward Dialing number</div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="call_forward_route_id" class="form-label required">Call Forward Route ID</label>
                                    <input type="number" class="form-control" id="call_forward_route_id" name="call_forward_route_id" value="0" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="channels" class="form-label required">Channels</label>
                                    <input type="number" class="form-control" id="channels" name="channels" value="0" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="schedule" class="form-label required">Schedule?</label>
                                    <select class="form-select" id="schedule" name="schedule" required>
                                        <option value="No" selected>No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="active" class="form-label required">Status</label>
                                    <select class="form-select" id="active" name="active" required>
                                        <option value="Y" selected>Active</option>
                                        <option value="N">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-cog"></i> Application Configuration
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="application_type" class="form-label required">Application Type</label>
                                    <select class="form-select" id="application_type" name="application_type" required onchange="showApplicationValue(this.value);">
                                        <option value="process">Transfer To Process</option>
                                        <option value="queue">Transfer To Queue</option>
                                        <option value="ivr">Transfer To IVR</option>
                                        <option value="callforward">Call Forward</option>
                                        <option value="voicemail">Transfer To Voice Mail</option>
                                        <option value="extension">Transfer To Extension</option>
                                        <option value="ip">DirectIP Dial</option>
                                        <option value="play">Play Voicefile</option>
                                        <option value="complete">Complete Call</option>
                                        <option value="misscall">Missed Call</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="application_value" class="form-label required">Application Value</label>
                                    <div id="application_value_container">
                                        <input type="text" class="form-control" id="application_value" name="application_value" required placeholder="Enter application value">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveRouteBtn">
                        <i class="fas fa-save me-1"></i> Save Route
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-trash-alt fa-3x text-danger"></i>
                    </div>
                    <h5 class="mb-3">Delete Route</h5>
                    <p>Are you sure you want to delete the route <strong id="routeToDeleteName">[Route Name]</strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i> Delete Route
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    // API Configuration
    const API_BASE_URL = '.././api/inbound_route.php'; // Update this path if needed
    
    let routesTable;
    let routeToDelete = null;

    // Initialize the application when page loads
    document.addEventListener('DOMContentLoaded', function() {
        showApplicationValue('process');
        initializeDataTable();
        loadStats();
        updateLastUpdatedTime();
        
        // Set up event listeners
        document.getElementById('refreshBtn').addEventListener('click', refreshData);
        document.getElementById('saveRouteBtn').addEventListener('click', saveRoute);
        document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
        
        // Reset form when modal is hidden
        document.getElementById('addRouteModal').addEventListener('hidden.bs.modal', resetForm);
    });

    // API Functions
    async function apiCall(endpoint, method = 'GET', data = null) {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            }
        };
        
        if (data && (method === 'POST' || method === 'PUT' || method === 'DELETE')) {
            options.body = JSON.stringify(data);
        }
        
        try {
            console.log('API Call:', endpoint, method, data);
            const response = await fetch(endpoint, options);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            console.log('API Response:', result);
            return result;
        } catch (error) {
            console.error('API call failed:', error);
            return {
                success: false,
                message: 'Network error: ' + error.message
            };
        }
    }

    // Initialize DataTable
    function initializeDataTable() {
        showTableLoading(true);
        
        routesTable = $('#routesTable').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            responsive: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            order: [[0, 'desc']],
            columns: [
                { data: 'Route_Id' },
                { 
                    data: 'Route_Name',
                    render: function(data, type, row) {
                        return `<div class="d-flex align-items-center">
                            <i class="fas fa-route text-primary me-2"></i>
                            <strong>${data || 'N/A'}</strong>
                        </div>`;
                    }
                },
                { 
                    data: 'did_num',
                    render: function(data) {
                        return data || 'N/A';
                    }
                },
                { 
                    data: 'Application_Type',
                    render: function(data) {
                        return `<span class="badge bg-info">${formatApplicationType(data)}</span>`;
                    }
                },
                { 
                    data: 'Application_Value',
                    render: function(data) {
                        return `<span class="app-value-text">${data || 'N/A'}</span>`;
                    }
                },
                { 
                    data: 'Channels',
                    render: function(data) {
                        return `<span class="badge bg-secondary">${data || 0}</span>`;
                    }
                },
                { 
                    data: 'Active',
                    render: function(data) {
                        const isActive = data === 'Y';
                        return `<span class="status-badge ${isActive ? 'bg-success' : 'bg-secondary'}">
                            <i class="fas ${isActive ? 'fa-check-circle' : 'fa-times-circle'}"></i> ${isActive ? 'Active' : 'Inactive'}
                        </span>`;
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return `<div class="action-buttons">
                            <button onclick="editRoute(${row.Route_Id})" title="Modify Inbound Route" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button onclick="deleteRoute(${row.Route_Id}, '${(row.Route_Name || '').replace(/'/g, "\\'")}')" title="Delete Inbound route" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>`;
                    },
                    orderable: false
                }
            ],
            data: [], // Initialize with empty data
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search routes...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                emptyTable: "No routes found",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            },
            initComplete: function() {
                showTableLoading(false);
            }
        });
        
        loadRoutesData();
    }

    // Load routes data from API
    async function loadRoutesData() {
        try {
            showTableLoading(true);
            const result = await apiCall(API_BASE_URL);
            
            if (result.success) {
                // Check if data exists and is an array
                if (result.data && Array.isArray(result.data)) {
                    routesTable.clear().rows.add(result.data).draw();
                    showNotification('success', 'Data Loaded', `Loaded ${result.data.length} routes successfully`);
                } else {
                    // If no data or data is not array, show empty table
                    routesTable.clear().draw();
                    showNotification('info', 'No Data', 'No routes found in the database');
                }
            } else {
                throw new Error(result.message || 'Unknown error occurred');
            }
        } catch (error) {
            console.error('Error loading routes:', error);
            showNotification('error', 'Error', 'Failed to load routes data: ' + error.message);
            // Clear table on error
            routesTable.clear().draw();
        } finally {
            showTableLoading(false);
        }
    }

    // Load statistics
    async function loadStats() {
        try {
            const result = await apiCall(API_BASE_URL + '?action=stats');
            
            if (result.success) {
                const stats = result.data;
                // Handle null values by converting to 0
                const totalRoutes = parseInt(stats.total_routes) || 0;
                const activeRoutes = parseInt(stats.active_routes) || 0;
                const inactiveRoutes = parseInt(stats.inactive_routes) || 0;
                
                document.getElementById('totalRoutes').textContent = totalRoutes;
                document.getElementById('activeRoutes').textContent = activeRoutes;
                document.getElementById('inactiveRoutes').textContent = inactiveRoutes;
            } else {
                throw new Error(result.message || 'Failed to load statistics');
            }
        } catch (error) {
            console.error('Error loading stats:', error);
            // Set default values on error
            document.getElementById('totalRoutes').textContent = '0';
            document.getElementById('activeRoutes').textContent = '0';
            document.getElementById('inactiveRoutes').textContent = '0';
            showNotification('error', 'Error', 'Failed to load statistics');
        }
    }

    // Format application type for display
    function formatApplicationType(type) {
        if (!type) return 'Not Set';
        
        const typeMap = {
            'process': 'Transfer To Process',
            'queue': 'Transfer To Queue',
            'ivr': 'Transfer To IVR',
            'callforward': 'Call Forward',
            'voicemail': 'Transfer To Voice Mail',
            'extension': 'Transfer To Extension',
            'ip': 'DirectIP Dial',
            'play': 'Play Voicefile',
            'complete': 'Complete Call',
            'misscall': 'Missed Call'
        };
        return typeMap[type] || type;
    }

    // Update last updated time
    function updateLastUpdatedTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        document.getElementById('lastUpdated').textContent = `Last updated: ${timeString}`;
    }

    // Refresh data
    async function refreshData() {
        showTableLoading(true);
        try {
            await Promise.all([loadRoutesData(), loadStats()]);
            updateLastUpdatedTime();
        } catch (error) {
            console.error('Error refreshing data:', error);
        } finally {
            showTableLoading(false);
        }
    }

    // Show application value based on selected type
    function showApplicationValue(type) {
        const container = document.getElementById('application_value_container');
        
        if (type === 'process') {
            container.innerHTML = `
                <select class="form-select" id="application_value" name="application_value" required>
                    <option value="">Select Process</option>
                    <option value="ConVox_Process">ConVox_Process</option>
                    <option value="EMRI_PROCESS">EMRI_PROCESS</option>
                    <option value="merit_tool">merit_tool</option>
                    <option value="merit_R1">merit_R1</option>
                    <option value="merit_R2">merit_R2</option>
                    <option value="merit_R3">merit_R3</option>
                    <option value="merit_R4">merit_R4</option>
                    <option value="merit_A1">merit_A1</option>
                    <option value="vehicle_release">vehicle_release</option>
                    <option value="merit_R5">merit_R5</option>
                    <option value="Complaint">Complaint</option>
                    <option value="merit_R5_1">merit_R5_1</option>
                    <option value="merit_R7">merit_R7</option>
                    <option value="merit_R6">merit_R6</option>
                    <option value="merit_R8">merit_R8</option>
                    <option value="merit_R9">merit_R9</option>
                    <option value="merit_R10">merit_R10</option>
                    <option value="merit_R11">merit_R11</option>
                    <option value="Merit_R13">Merit_R13</option>
                    <option value="Merit_R14">Merit_R14</option>
                    <option value="Merit_R15">Merit_R15</option>
                    <option value="Merit_R16">Merit_R16</option>
                    <option value="Merit_R17">Merit_R17</option>
                </select>
            `;
        } else if (type === 'ivr') {
            container.innerHTML = `
                <select class="form-select" id="application_value" name="application_value" required>
                    <option value="">Select IVR</option>
                    <option value="1">emri_ivr</option>
                </select>
            `;
        } else {
            container.innerHTML = `<input type="text" class="form-control" id="application_value" name="application_value" required placeholder="Enter application value">`;
        }
    }

    // Edit route function
    async function editRoute(id) {
        try {
            showTableLoading(true);
            const result = await apiCall(API_BASE_URL + '?id=' + id);
            
            if (result.success && result.data) {
                const route = result.data;
                
                // Populate form
                document.getElementById('route_id').value = route.Route_Id || '';
                document.getElementById('route_name').value = route.Route_Name || '';
                document.getElementById('did_num').value = route.did_num || '';
                document.getElementById('call_forward_route_id').value = route.call_forward_route_id || 0;
                document.getElementById('channels').value = route.Channels || 0;
                document.getElementById('schedule').value = route.Schedule || 'No';
                document.getElementById('active').value = route.Active || 'Y';
                document.getElementById('application_type').value = route.Application_Type || 'process';
                
                // Update application value
                showApplicationValue(route.Application_Type || 'process');
                setTimeout(() => {
                    document.getElementById('application_value').value = route.Application_Value || '';
                }, 100);

                // Update modal title
                document.getElementById('addRouteModalLabel').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Inbound Route';

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('addRouteModal'));
                modal.show();
            } else {
                throw new Error(result.message || 'Route not found');
            }
        } catch (error) {
            console.error('Error loading route:', error);
            showNotification('error', 'Error', 'Failed to load route data: ' + error.message);
        } finally {
            showTableLoading(false);
        }
    }

    // Delete route function
    function deleteRoute(id, name) {
        routeToDelete = id;
        document.getElementById('routeToDeleteName').textContent = name || 'Unknown Route';
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        deleteModal.show();
    }

    // Confirm delete
    async function confirmDelete() {
        if (!routeToDelete) return;
        
        try {
            showTableLoading(true);
            const result = await apiCall(API_BASE_URL, 'DELETE', { id: routeToDelete });
            
            if (result.success) {
                showNotification('success', 'Route Deleted', 'Route deleted successfully!');
                
                // Close modal
                const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
                deleteModal.hide();
                
                // Refresh data
                await refreshData();
            } else {
                throw new Error(result.message || 'Failed to delete route');
            }
        } catch (error) {
            console.error('Error deleting route:', error);
            showNotification('error', 'Error', 'Failed to delete route: ' + error.message);
        } finally {
            showTableLoading(false);
            routeToDelete = null;
        }
    }

    // Save route function
    async function saveRoute() {
        const formData = new FormData(document.getElementById('routeForm'));
        const data = Object.fromEntries(formData);
        
        // Validation
        if (!data.route_name || !data.route_name.trim()) {
            showNotification('error', 'Validation Error', 'Please enter a route name');
            document.getElementById('route_name').focus();
            return;
        }
        
        if (!data.did_num || !data.did_num.trim()) {
            showNotification('error', 'Validation Error', 'Please enter a DID number');
            document.getElementById('did_num').focus();
            return;
        }

        if (!data.application_value || !data.application_value.trim()) {
            showNotification('error', 'Validation Error', 'Please enter an application value');
            document.getElementById('application_value').focus();
            return;
        }

        try {
            showTableLoading(true);
            let result;
            const routeData = {
                route_name: data.route_name.trim(),
                did_num: data.did_num.trim(),
                call_forward_route_id: parseInt(data.call_forward_route_id) || 0,
                channels: parseInt(data.channels) || 0,
                schedule: data.schedule || 'No',
                active: data.active || 'Y',
                application_type: data.application_type || 'process',
                application_value: data.application_value.trim()
            };

            if (data.route_id) {
                // Update existing route
                routeData.route_id = parseInt(data.route_id);
                result = await apiCall(API_BASE_URL, 'POST', routeData);
            } else {
                // Create new route
                result = await apiCall(API_BASE_URL, 'POST', routeData);
            }
            
            if (result.success) {
                const action = data.route_id ? 'updated' : 'created';
                showNotification('success', 'Route Saved', `Route ${action} successfully!`);
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addRouteModal'));
                modal.hide();
                
                // Reset form
                resetForm();
                
                // Refresh data
                await refreshData();
            } else {
                throw new Error(result.message || 'Failed to save route');
            }
        } catch (error) {
            console.error('Error saving route:', error);
            showNotification('error', 'Error', 'Failed to save route: ' + error.message);
        } finally {
            showTableLoading(false);
        }
    }

    // Reset form function
    function resetForm() {
        document.getElementById('routeForm').reset();
        document.getElementById('route_id').value = '';
        document.getElementById('call_forward_route_id').value = '0';
        document.getElementById('channels').value = '0';
        document.getElementById('addRouteModalLabel').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Add New Inbound Route';
        showApplicationValue('process');
    }

    // Notification System
    function showNotification(type, title, message, duration = 5000) {
        const container = document.getElementById('notificationContainer');
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        
        let iconClass;
        switch(type) {
            case 'success':
                iconClass = 'fas fa-check-circle';
                break;
            case 'error':
                iconClass = 'fas fa-exclamation-circle';
                break;
            case 'warning':
                iconClass = 'fas fa-exclamation-triangle';
                break;
            case 'info':
                iconClass = 'fas fa-info-circle';
                break;
            default:
                iconClass = 'fas fa-bell';
        }
        
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="${iconClass}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">${title}</div>
                <div class="notification-message">${message}</div>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        container.appendChild(notification);
        
        // Show notification with animation
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Close button functionality
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            hideNotification(notification);
        });
        
        // Auto-hide after duration
        if (duration > 0) {
            setTimeout(() => {
                hideNotification(notification);
            }, duration);
        }
    }
    
    function hideNotification(notification) {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 400);
    }

    // Show/hide table loading
    function showTableLoading(show) {
        const loadingElement = document.getElementById('tableLoading');
        if (show) {
            loadingElement.style.display = 'flex';
        } else {
            loadingElement.style.display = 'none';
        }
    }
</script>
</body>
</html>