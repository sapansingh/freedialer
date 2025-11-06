<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outbound Routes Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --info-color: #4895ef;
            --warning-color: #f72585;
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
        
        table.dataTable thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 16px 12px;
            font-weight: 600;
            font-size: 0.9rem;
            text-align: center;
        }
        
        table.dataTable tbody td {
            padding: 14px 12px;
            vertical-align: middle;
            border-color: #f1f3f4;
            font-size: 0.9rem;
            text-align: center;
        }
        
        .action-buttons .btn {
            padding: 6px 10px;
            margin: 0 2px;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 0.85rem;
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
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
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
        }
        
        .trunks-container {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            background: #f8fafc;
        }
        
        .trunk-select {
            width: 100%;
            height: 150px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
        }
        
        .trunk-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: center;
        }
        
        .trunk-controls {
            display: flex;
            flex-direction: column;
            gap: 5px;
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
        
        .notification.info {
            border-left-color: #3b82f6;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            height: 100%;
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
    </style>
</head>
<body>
    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>
    
    <div class="main-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-title">
                <i class="fas fa-sign-out-alt"></i>
                <span>OUTBOUND ROUTES MANAGEMENT</span>
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
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                            <i class="fas fa-route"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalRoutes">0</h3>
                            <p>Total Routes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4ade80, #22c55e);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="activeRoutes">0</h3>
                            <p>Active Routes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
                                <th>Description</th>
                                <th>Method</th>
                                <th>Add Digits</th>
                                <th>Trunks Count</th>
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
                ConVox CCS v2.0 | Outbound Routes Management
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
                        <i class="fas fa-plus-circle me-2"></i>Add New Outbound Route
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
                                    <label for="route_name" class="form-label required">Route Name *</label>
                                    <input type="text" class="form-control" id="route_name" name="route_name" required>
                                    <div class="form-text">Unique identifier for this route</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="route_description" class="form-label">Route Description</label>
                                    <input type="text" class="form-control" id="route_description" name="route_description">
                                    <div class="form-text">Optional description for this route</div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="route_active" class="form-label required">Route Active</label>
                                    <select class="form-select" id="route_active" name="route_active" required>
                                        <option value="Y" selected>Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="add_digits" class="form-label">Add Digits</label>
                                    <input type="text" class="form-control" id="add_digits" name="add_digits" maxlength="4" pattern="[0-9]*">
                                    <div class="form-text">Digits to add to outgoing calls (max 4, numbers only)</div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="route_method" class="form-label required">Route Method</label>
                                    <select class="form-select" id="route_method" name="route_method" required>
                                        <option value="Serial" selected>Serial</option>
                                        <option value="Random">Random</option>
                                    </select>
                                    <div class="form-text">Serial: Use trunks in order | Random: Use trunks randomly</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-server"></i> Trunks Configuration
                            </div>
                            <div class="trunks-container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="form-label"><b>Available Trunks</b></label>
                                        <select multiple class="form-control trunk-select" id="available_trunks">
                                            <!-- Trunks will be loaded dynamically -->
                                        </select>
                                    </div>
                                    <div class="col-md-2 trunk-buttons">
                                        <div class="d-flex flex-column gap-2 mt-4">
                                            <button type="button" class="btn btn-primary" onclick="moveRight()">
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary" onclick="moveLeft()">
                                                <i class="fas fa-arrow-left"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label"><b>Selected Trunks</b></label>
                                        <select multiple class="form-control trunk-select" id="selected_trunks" name="selected_trunks[]">
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="moveTop()">
                                                <i class="fas fa-angle-double-up"></i> Top
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="moveUp()">
                                                <i class="fas fa-angle-up"></i> Up
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="moveDown()">
                                                <i class="fas fa-angle-down"></i> Down
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="moveBottom()">
                                                <i class="fas fa-angle-double-down"></i> Bottom
                                            </button>
                                        </div>
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
        const API_BASE_URL = '.././api/outbound_route.php';
        
        let routesTable;
        let routeToDelete = null;
        let availableTrunks = [];

        // Initialize the application when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable();
            loadStats();
            loadTrunks();
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
            
            if (data && (method === 'POST' || method === 'DELETE')) {
                options.body = JSON.stringify(data);
            }
            
            try {
                showTableLoading(true);
                const response = await fetch(endpoint, options);
                const result = await response.json();
                return result;
            } catch (error) {
                console.error('API call failed:', error);
                return {
                    success: false,
                    message: 'Network error: ' + error.message
                };
            } finally {
                showTableLoading(false);
            }
        }

        // Initialize DataTable
        function initializeDataTable() {
            routesTable = $('#routesTable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                responsive: true,
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [[0, 'desc']],
                columns: [
                    { data: 'route_id' },
                    { 
                        data: 'route_name',
                        render: function(data, type, row) {
                            return `<div class="d-flex align-items-center">
                                <i class="fas fa-sign-out-alt text-primary me-2"></i>
                                <strong>${data || 'N/A'}</strong>
                            </div>`;
                        }
                    },
                    { 
                        data: 'route_description',
                        render: function(data) {
                            return data || '<span class="text-muted">No description</span>';
                        }
                    },
                    { 
                        data: 'route_method',
                        render: function(data) {
                            const badgeClass = data === 'Serial' ? 'bg-info' : 'bg-warning';
                            return `<span class="badge ${badgeClass}">${data || 'Serial'}</span>`;
                        }
                    },
                    { 
                        data: 'add_digits',
                        render: function(data) {
                            return data ? `<span class="badge bg-secondary">${data}</span>` : '<span class="text-muted">None</span>';
                        }
                    },
                    { 
                        data: 'selected_trunks',
                        render: function(data) {
                            const count = data ? data.split(',').filter(Boolean).length : 0;
                            const badgeClass = count > 0 ? 'bg-success' : 'bg-secondary';
                            return `<span class="badge ${badgeClass}">${count} trunk(s)</span>`;
                        }
                    },
                    { 
                        data: 'route_active',
                        render: function(data) {
                            const isActive = data === 'Y';
                            return `<span class="status-badge ${isActive ? 'bg-success' : 'bg-danger'}">
                                <i class="fas ${isActive ? 'fa-check-circle' : 'fa-times-circle'}"></i> ${isActive ? 'Active' : 'Inactive'}
                            </span>`;
                        }
                    },
                    { 
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="action-buttons">
                                <button onclick="editRoute(${row.route_id})" title="Modify Route" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="deleteRoute(${row.route_id}, '${(row.route_name || '').replace(/'/g, "\\'")}')" title="Delete Route" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>`;
                        },
                        orderable: false
                    }
                ],
                data: [],
                language: {
                    emptyTable: "No outbound routes found",
                    info: "Showing _START_ to _END_ of _TOTAL_ routes",
                    search: "Search routes...",
                    zeroRecords: "No matching routes found"
                }
            });
            
            loadRoutesData();
        }

        // Load routes data
        async function loadRoutesData() {
            try {
                const result = await apiCall(API_BASE_URL);
                
                if (result.success) {
                    routesTable.clear().rows.add(result.data).draw();
                    showNotification('success', 'Data Loaded', `Loaded ${result.data.length} outbound routes`);
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading routes:', error);
                showNotification('error', 'Error', 'Failed to load routes data: ' + error.message);
            }
        }

        // Load statistics
        async function loadStats() {
            try {
                const result = await apiCall(API_BASE_URL + '?action=stats');
                
                if (result.success) {
                    const stats = result.data;
                    document.getElementById('totalRoutes').textContent = stats.total_routes;
                    document.getElementById('activeRoutes').textContent = stats.active_routes;
                    document.getElementById('inactiveRoutes').textContent = stats.inactive_routes;
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // Load trunks
        async function loadTrunks() {
            try {
                const result = await apiCall(API_BASE_URL + '?action=trunks');
                
                if (result.success) {
                    availableTrunks = result.data;
                    updateAvailableTrunksList();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading trunks:', error);
            }
        }

        // Update available trunks list
        function updateAvailableTrunksList() {
            const availableSelect = document.getElementById('available_trunks');
            availableSelect.innerHTML = '';
            
            availableTrunks.forEach(trunk => {
                const option = document.createElement('option');
                option.value = trunk.trunk_id;
                option.textContent = `${trunk.trunk_name} - ${trunk.trunk_type}`;
                option.title = `ID: ${trunk.trunk_id} - ${trunk.trunk_type}`;
                availableSelect.appendChild(option);
            });
        }

        // =============================================
        // FIXED TRUNK MOVEMENT FUNCTIONS
        // =============================================

        function moveRight() {
            moveSelectedOptions('available_trunks', 'selected_trunks');
        }

        function moveLeft() {
            moveSelectedOptions('selected_trunks', 'available_trunks');
        }

        function moveSelectedOptions(fromId, toId) {
            const fromSelect = document.getElementById(fromId);
            const toSelect = document.getElementById(toId);
            
            // Get all selected options
            const selectedOptions = Array.from(fromSelect.selectedOptions);
            
            // Move each selected option
            selectedOptions.forEach(option => {
                toSelect.appendChild(option);
                option.selected = true; // Keep it selected after moving
            });
        }

        function moveTop() {
            moveSelectionToPosition('selected_trunks', 'top');
        }

        function moveUp() {
            moveSelectionToPosition('selected_trunks', 'up');
        }

        function moveDown() {
            moveSelectionToPosition('selected_trunks', 'down');
        }

        function moveBottom() {
            moveSelectionToPosition('selected_trunks', 'bottom');
        }

        function moveSelectionToPosition(selectId, direction) {
            const select = document.getElementById(selectId);
            const selectedOptions = Array.from(select.selectedOptions);
            const selectedValues = selectedOptions.map(opt => opt.value);
            
            if (selectedOptions.length === 0) return;
            
            // Store the current scroll position
            const scrollTop = select.scrollTop;
            
            // Remove selected options temporarily
            selectedOptions.forEach(option => option.remove());
            
            // Reinsert at new position
            switch (direction) {
                case 'top':
                    selectedOptions.forEach((option, index) => {
                        select.insertBefore(option, select.options[index]);
                    });
                    break;
                case 'up':
                    if (selectedOptions.length > 0) {
                        const firstSelectedIndex = findFirstSelectedIndex(select, selectedValues);
                        if (firstSelectedIndex > 0) {
                            selectedOptions.forEach(option => {
                                select.insertBefore(option, select.options[firstSelectedIndex - 1]);
                            });
                        } else {
                            selectedOptions.forEach(option => {
                                select.insertBefore(option, select.options[0]);
                            });
                        }
                    }
                    break;
                case 'down':
                    if (selectedOptions.length > 0) {
                        const lastSelectedIndex = findLastSelectedIndex(select, selectedValues);
                        selectedOptions.reverse().forEach(option => {
                            if (lastSelectedIndex < select.options.length - 1) {
                                select.insertBefore(option, select.options[lastSelectedIndex + 1].nextSibling);
                            } else {
                                select.appendChild(option);
                            }
                        });
                    }
                    break;
                case 'bottom':
                    selectedOptions.forEach(option => {
                        select.appendChild(option);
                    });
                    break;
            }
            
            // Restore selection and scroll position
            Array.from(select.options).forEach(option => {
                if (selectedValues.includes(option.value)) {
                    option.selected = true;
                }
            });
            select.scrollTop = scrollTop;
        }

        function findFirstSelectedIndex(select, selectedValues) {
            for (let i = 0; i < select.options.length; i++) {
                if (selectedValues.includes(select.options[i].value)) {
                    return i;
                }
            }
            return -1;
        }

        function findLastSelectedIndex(select, selectedValues) {
            for (let i = select.options.length - 1; i >= 0; i--) {
                if (selectedValues.includes(select.options[i].value)) {
                    return i;
                }
            }
            return -1;
        }

        // Edit route
        async function editRoute(id) {
            try {
                const result = await apiCall(API_BASE_URL + '?id=' + id);
                
                if (result.success) {
                    const route = result.data;
                    
                    // Populate form
                    document.getElementById('route_id').value = route.route_id;
                    document.getElementById('route_name').value = route.route_name;
                    document.getElementById('route_description').value = route.route_description || '';
                    document.getElementById('route_active').value = route.route_active;
                    document.getElementById('route_method').value = route.route_method;
                    document.getElementById('add_digits').value = route.add_digits || '';
                    
                    // Populate selected trunks
                    const selectedSelect = document.getElementById('selected_trunks');
                    selectedSelect.innerHTML = '';
                    
                    if (route.selected_trunks) {
                        const trunkIds = route.selected_trunks.split(',').filter(id => id !== '');
                        trunkIds.forEach(trunkId => {
                            const trunk = availableTrunks.find(t => t.trunk_id == trunkId);
                            if (trunk) {
                                const option = document.createElement('option');
                                option.value = trunk.trunk_id;
                                option.textContent = `${trunk.trunk_name} - ${trunk.trunk_type}`;
                                selectedSelect.appendChild(option);
                            }
                        });
                    }
                    
                    // Remove selected trunks from available
                    updateAvailableTrunksList();
                    const selectedOptions = Array.from(selectedSelect.options).map(opt => opt.value);
                    const availableSelect = document.getElementById('available_trunks');
                    for (let i = availableSelect.options.length - 1; i >= 0; i--) {
                        if (selectedOptions.includes(availableSelect.options[i].value)) {
                            availableSelect.remove(i);
                        }
                    }
                    
                    // Update modal title
                    document.getElementById('addRouteModalLabel').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Outbound Route';
                    
                    // Show modal
                    new bootstrap.Modal(document.getElementById('addRouteModal')).show();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading route:', error);
                showNotification('error', 'Error', 'Failed to load route data: ' + error.message);
            }
        }

        // Delete route
        function deleteRoute(id, name) {
            routeToDelete = id;
            document.getElementById('routeToDeleteName').textContent = name;
            new bootstrap.Modal(document.getElementById('deleteConfirmationModal')).show();
        }

        // Confirm delete
        async function confirmDelete() {
            if (!routeToDelete) return;
            
            try {
                const result = await apiCall(API_BASE_URL, 'DELETE', { id: routeToDelete });
                
                if (result.success) {
                    showNotification('success', 'Route Deleted', 'Route deleted successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                    await refreshData();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error deleting route:', error);
                showNotification('error', 'Error', 'Failed to delete route: ' + error.message);
            }
            
            routeToDelete = null;
        }

        // Save route
        async function saveRoute() {
            const formData = {
                route_name: document.getElementById('route_name').value.trim(),
                route_description: document.getElementById('route_description').value.trim(),
                route_active: document.getElementById('route_active').value,
                route_method: document.getElementById('route_method').value,
                add_digits: document.getElementById('add_digits').value.trim()
            };

            // Get selected trunks
            const selectedTrunks = Array.from(document.getElementById('selected_trunks').options)
                .map(option => option.value);
            formData.selected_trunks = selectedTrunks;

            // Validation
            if (!formData.route_name) {
                showNotification('error', 'Validation Error', 'Route Name is required');
                document.getElementById('route_name').focus();
                return;
            }

            if (formData.add_digits && !/^\d+$/.test(formData.add_digits)) {
                showNotification('error', 'Validation Error', 'Add Digits can only contain numbers');
                document.getElementById('add_digits').focus();
                return;
            }

            const routeId = document.getElementById('route_id').value;
            if (routeId) {
                formData.route_id = routeId;
            }

            try {
                const result = await apiCall(API_BASE_URL, 'POST', formData);
                
                if (result.success) {
                    const action = routeId ? 'updated' : 'created';
                    showNotification('success', 'Route Saved', `Route ${action} successfully!`);
                    bootstrap.Modal.getInstance(document.getElementById('addRouteModal')).hide();
                    resetForm();
                    await refreshData();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error saving route:', error);
                showNotification('error', 'Error', 'Failed to save route: ' + error.message);
            }
        }

        // Reset form
        function resetForm() {
            document.getElementById('routeForm').reset();
            document.getElementById('route_id').value = '';
            document.getElementById('selected_trunks').innerHTML = '';
            document.getElementById('addRouteModalLabel').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Add New Outbound Route';
            updateAvailableTrunksList();
        }

        // Refresh data
        async function refreshData() {
            await Promise.all([loadRoutesData(), loadStats(), loadTrunks()]);
            updateLastUpdatedTime();
            showNotification('info', 'Refreshed', 'Data refreshed successfully');
        }

        // Update last updated time
        function updateLastUpdatedTime() {
            document.getElementById('lastUpdated').textContent = 'Last updated: ' + new Date().toLocaleTimeString();
        }

        // Show/hide table loading
        function showTableLoading(show) {
            document.getElementById('tableLoading').style.display = show ? 'flex' : 'none';
        }

        // Notification system
        function showNotification(type, title, message, duration = 5000) {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            
            let iconClass;
            switch(type) {
                case 'success':
                    iconClass = 'fa-check-circle';
                    break;
                case 'error':
                    iconClass = 'fa-exclamation-circle';
                    break;
                case 'info':
                    iconClass = 'fa-info-circle';
                    break;
                default:
                    iconClass = 'fa-bell';
            }
            
            notification.innerHTML = `
                <div class="notification-icon">
                    <i class="fas ${iconClass}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">${title}</div>
                    <div class="notification-message">${message}</div>
                </div>
                <button class="btn-close" onclick="this.parentElement.remove()"></button>
            `;
            
            container.appendChild(notification);
            setTimeout(() => notification.classList.add('show'), 10);
            
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 400);
            }, duration);
        }
    </script>
</body>
</html>