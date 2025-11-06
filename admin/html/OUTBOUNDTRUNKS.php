<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trunks Configuration</title>
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
        
        .type-configuration {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            background: #f8fafc;
            margin-top: 15px;
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
             bottom: 20px;
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
        
        .type-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .type-pstn {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .type-voip {
            background: #f0fdf4;
            color: #166534;
        }
        
        .type-direct-ip {
            background: #fef3c7;
            color: #92400e;
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
                <i class="fas fa-server"></i>
                <span>TRUNKS CONFIGURATION</span>
            </div>
            
            <div class="header-actions">
                <div class="header-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTrunkModal">
                        <i class="fas fa-plus me-1"></i> Add Trunk
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
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalTrunks">0</h3>
                            <p>Total Trunks</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4ade80, #22c55e);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="activeTrunks">0</h3>
                            <p>Active Trunks</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="inactiveTrunks">0</h3>
                            <p>Inactive Trunks</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="voipTrunks">0</h3>
                            <p>VOIP Trunks</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Trunks Table -->
            <div class="table-container" style="position: relative;">
                <div class="loading-overlay" id="tableLoading" style="display: none;">
                    <div class="spinner"></div>
                </div>
                <div class="table-responsive">
                    <table id="trunksTable" class="table table-hover display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th> 
                                <th>Trunk Name</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Channels</th>
                                <th>Configuration</th>
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
                ConVox CCS v2.0 | Trunks Configuration
            </div>
            <div>
                <span id="lastUpdated">Last updated: Just now</span>
            </div>
        </div>
    </div>

    <!-- Add Trunk Modal -->
    <div class="modal fade" id="addTrunkModal" tabindex="-1" aria-labelledby="addTrunkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTrunkModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Add New Trunk
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="trunkForm">
                        <input type="hidden" id="trunk_id" name="trunk_id">
                        
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Basic Information
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="trunk_name" class="form-label required">Trunk Name *</label>
                                    <input type="text" class="form-control" id="trunk_name" name="trunk_name" required>
                                    <div class="form-text">Unique identifier for this trunk</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="trunk_description" class="form-label">Trunk Description</label>
                                    <input type="text" class="form-control" id="trunk_description" name="trunk_description">
                                    <div class="form-text">Optional description for this trunk</div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="trunk_active" class="form-label required">Trunk Active</label>
                                    <select class="form-select" id="trunk_active" name="trunk_active" required>
                                        <option value="Y" selected>Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="trunk_type" class="form-label required">Trunk Type</label>
                                    <select class="form-select" id="trunk_type" name="trunk_type" required onchange="showTypeConfiguration()">
                                        <option value="PSTN" selected>PSTN</option>
                                        <option value="VOIP">VOIP</option>
                                        <option value="Direct-IP">Direct-IP</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="channels" class="form-label required">Channels</label>
                                    <input type="number" class="form-control" id="channels" name="channels" value="1" min="1" max="100" required>
                                    <div class="form-text">Number of concurrent channels</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PSTN Configuration -->
                        <div class="form-section type-configuration" id="pstnConfig" style="display: block;">
                            <div class="section-title">
                                <i class="fas fa-phone-alt"></i> PSTN Configuration
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pstn_technology" class="form-label">PSTN Technology</label>
                                    <select class="form-select" id="pstn_technology" name="pstn_technology">
                                        <option value="dahdi" selected>DAHDI</option>
                                        <option value="zap">ZAP</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="pstn_zap_dahdi_id" class="form-label">ZAP/DAHDI ID</label>
                                    <input type="text" class="form-control" id="pstn_zap_dahdi_id" name="pstn_zap_dahdi_id">
                                    <div class="form-text">Channel identifier for DAHDI/ZAP</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- VOIP Configuration -->
                        <div class="form-section type-configuration" id="voipConfig" style="display: none;">
                            <div class="section-title">
                                <i class="fas fa-globe"></i> VOIP Configuration
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="voip_custom_settings" class="form-label">Custom Settings</label>
                                    <select class="form-select" id="voip_custom_settings" name="voip_custom_settings">
                                        <option value="N" selected>No</option>
                                        <option value="Y">Yes</option>
                                    </select>
                                    <div class="form-text">Enable custom VOIP settings</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="voip_type" class="form-label">VOIP Type</label>
                                    <select class="form-select" id="voip_type" name="voip_type">
                                        <option value="peer" selected>Peer</option>
                                        <option value="friend">Friend</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="voip_account_id" class="form-label">Account ID</label>
                                    <input type="text" class="form-control" id="voip_account_id" name="voip_account_id">
                                </div>
                                <div class="col-md-6">
                                    <label for="voip_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="voip_password" name="voip_password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="voip_host_ip_address" class="form-label">Host IP Address</label>
                                    <input type="text" class="form-control" id="voip_host_ip_address" name="voip_host_ip_address" placeholder="e.g., 192.168.1.100">
                                </div>
                                <div class="col-md-6">
                                    <label for="voip_context" class="form-label">Context</label>
                                    <input type="text" class="form-control" id="voip_context" name="voip_context" placeholder="e.g., from-trunk">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="voip_account_details" class="form-label">Account Details</label>
                                    <textarea class="form-control" id="voip_account_details" name="voip_account_details" rows="3" placeholder="Additional VOIP configuration details"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Direct-IP Configuration -->
                        <div class="form-section type-configuration" id="directIpConfig" style="display: none;">
                            <div class="section-title">
                                <i class="fas fa-desktop"></i> Direct-IP Configuration
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="direct_ip_address" class="form-label">IP Address</label>
                                    <input type="text" class="form-control" id="direct_ip_address" name="direct_ip_address" placeholder="e.g., 192.168.1.100">
                                    <div class="form-text">IP address for direct IP connection</div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveTrunkBtn">
                        <i class="fas fa-save me-1"></i> Save Trunk
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
                    <h5 class="mb-3">Delete Trunk</h5>
                    <p>Are you sure you want to delete the trunk <strong id="trunkToDeleteName">[Trunk Name]</strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i> Delete Trunk
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
        const API_BASE_URL = '.././api/trunks_api.php';
        
        let trunksTable;
        let trunkToDelete = null;

        // Initialize the application when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable();
            loadStats();
            updateLastUpdatedTime();
            
            // Set up event listeners
            document.getElementById('refreshBtn').addEventListener('click', refreshData);
            document.getElementById('saveTrunkBtn').addEventListener('click', saveTrunk);
            document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
            
            // Reset form when modal is hidden
            document.getElementById('addTrunkModal').addEventListener('hidden.bs.modal', resetForm);
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
            trunksTable = $('#trunksTable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                responsive: true,
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [[0, 'desc']],
                columns: [
                    { data: 'trunk_id' },
                    { 
                        data: 'trunk_name',
                        render: function(data, type, row) {
                            return `<div class="d-flex align-items-center">
                                <i class="fas fa-server text-primary me-2"></i>
                                <strong>${data || 'N/A'}</strong>
                            </div>`;
                        }
                    },
                    { 
                        data: 'trunk_description',
                        render: function(data) {
                            return data || '<span class="text-muted">No description</span>';
                        }
                    },
                    { 
                        data: 'trunk_type',
                        render: function(data) {
                            let badgeClass = '';
                            let icon = '';
                            switch(data) {
                                case 'PSTN':
                                    badgeClass = 'type-pstn';
                                    icon = 'fa-phone-alt';
                                    break;
                                case 'VOIP':
                                    badgeClass = 'type-voip';
                                    icon = 'fa-globe';
                                    break;
                                case 'Direct-IP':
                                    badgeClass = 'type-direct-ip';
                                    icon = 'fa-desktop';
                                    break;
                                default:
                                    badgeClass = 'bg-secondary';
                                    icon = 'fa-server';
                            }
                            return `<span class="type-badge ${badgeClass}">
                                <i class="fas ${icon} me-1"></i>${data}
                            </span>`;
                        }
                    },
                    { 
                        data: 'channels',
                        render: function(data) {
                            return `<span class="badge bg-info">${data || 0}</span>`;
                        }
                    },
                    { 
                        data: null,
                        render: function(data, type, row) {
                            let config = '';
                            switch(row.trunk_type) {
                                case 'PSTN':
                                    config = `${row.pstn_technology} - ${row.pstn_zap_dahdi_id}`;
                                    break;
                                case 'VOIP':
                                    config = `${row.voip_host_ip_address}`;
                                    break;
                                case 'Direct-IP':
                                    config = `${row.direct_ip_address}`;
                                    break;
                                default:
                                    config = 'N/A';
                            }
                            return `<small class="text-muted">${config}</small>`;
                        }
                    },
                    { 
                        data: 'trunk_active',
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
                                <button onclick="editTrunk(${row.trunk_id})" title="Modify Trunk" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="deleteTrunk(${row.trunk_id}, '${(row.trunk_name || '').replace(/'/g, "\\'")}')" title="Delete Trunk" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>`;
                        },
                        orderable: false
                    }
                ],
                data: [],
                language: {
                    emptyTable: "No trunks found",
                    info: "Showing _START_ to _END_ of _TOTAL_ trunks",
                    search: "Search trunks...",
                    zeroRecords: "No matching trunks found"
                }
            });
            
            loadTrunksData();
        }

        // Load trunks data
        async function loadTrunksData() {
            try {
                const result = await apiCall(API_BASE_URL);
                
                if (result.success) {
                    trunksTable.clear().rows.add(result.data).draw();
                    showNotification('success', 'Data Loaded', `Loaded ${result.data.length} trunks`);
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading trunks:', error);
                showNotification('error', 'Error', 'Failed to load trunks data: ' + error.message);
            }
        }

        // Load statistics
        async function loadStats() {
            try {
                const result = await apiCall(API_BASE_URL + '?action=stats');
                
                if (result.success) {
                    const stats = result.data;
                    document.getElementById('totalTrunks').textContent = stats.total_trunks;
                    document.getElementById('activeTrunks').textContent = stats.active_trunks;
                    document.getElementById('inactiveTrunks').textContent = stats.inactive_trunks;
                    document.getElementById('voipTrunks').textContent = stats.voip_trunks;
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // Show type-specific configuration
        function showTypeConfiguration() {
            const trunkType = document.getElementById('trunk_type').value;
            
            // Hide all configuration sections
            document.getElementById('pstnConfig').style.display = 'none';
            document.getElementById('voipConfig').style.display = 'none';
            document.getElementById('directIpConfig').style.display = 'none';
            
            // Show selected configuration
            switch(trunkType) {
                case 'PSTN':
                    document.getElementById('pstnConfig').style.display = 'block';
                    break;
                case 'VOIP':
                    document.getElementById('voipConfig').style.display = 'block';
                    break;
                case 'Direct-IP':
                    document.getElementById('directIpConfig').style.display = 'block';
                    break;
            }
        }

        // Edit trunk
        async function editTrunk(id) {
            try {
                const result = await apiCall(API_BASE_URL + '?id=' + id);
                
                if (result.success) {
                    const trunk = result.data;
                    
                    // Populate form
                    document.getElementById('trunk_id').value = trunk.trunk_id;
                    document.getElementById('trunk_name').value = trunk.trunk_name;
                    document.getElementById('trunk_description').value = trunk.trunk_description || '';
                    document.getElementById('trunk_active').value = trunk.trunk_active;
                    document.getElementById('trunk_type').value = trunk.trunk_type;
                    document.getElementById('channels').value = trunk.channels || 1;
                    
                    // Populate type-specific fields
                    document.getElementById('direct_ip_address').value = trunk.direct_ip_address || '';
                    document.getElementById('pstn_technology').value = trunk.pstn_technology || 'dahdi';
                    document.getElementById('pstn_zap_dahdi_id').value = trunk.pstn_zap_dahdi_id || '';
                    document.getElementById('voip_custom_settings').value = trunk.voip_custom_settings || 'N';
                    document.getElementById('voip_account_id').value = trunk.voip_account_id || '';
                    document.getElementById('voip_password').value = trunk.voip_password || '';
                    document.getElementById('voip_host_ip_address').value = trunk.voip_host_ip_address || '';
                    document.getElementById('voip_type').value = trunk.voip_type || 'peer';
                    document.getElementById('voip_context').value = trunk.voip_context || '';
                    document.getElementById('voip_account_details').value = trunk.voip_account_details || '';
                    
                    // Show appropriate configuration
                    showTypeConfiguration();
                    
                    // Update modal title
                    document.getElementById('addTrunkModalLabel').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Trunk';
                    
                    // Show modal
                    new bootstrap.Modal(document.getElementById('addTrunkModal')).show();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading trunk:', error);
                showNotification('error', 'Error', 'Failed to load trunk data: ' + error.message);
            }
        }

        // Delete trunk
        function deleteTrunk(id, name) {
            trunkToDelete = id;
            document.getElementById('trunkToDeleteName').textContent = name;
            new bootstrap.Modal(document.getElementById('deleteConfirmationModal')).show();
        }

        // Confirm delete
        async function confirmDelete() {
            if (!trunkToDelete) return;
            
            try {
                const result = await apiCall(API_BASE_URL, 'DELETE', { id: trunkToDelete });
                
                if (result.success) {
                    showNotification('success', 'Trunk Deleted', 'Trunk deleted successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                    await refreshData();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error deleting trunk:', error);
                showNotification('error', 'Error', 'Failed to delete trunk: ' + error.message);
            }
            
            trunkToDelete = null;
        }

        // Save trunk
        async function saveTrunk() {
            const formData = {
                trunk_name: document.getElementById('trunk_name').value.trim(),
                trunk_description: document.getElementById('trunk_description').value.trim(),
                trunk_active: document.getElementById('trunk_active').value,
                trunk_type: document.getElementById('trunk_type').value,
                channels: parseInt(document.getElementById('channels').value) || 1,
                
                // Type-specific fields
                direct_ip_address: document.getElementById('direct_ip_address').value.trim(),
                pstn_technology: document.getElementById('pstn_technology').value,
                pstn_zap_dahdi_id: document.getElementById('pstn_zap_dahdi_id').value.trim(),
                voip_custom_settings: document.getElementById('voip_custom_settings').value,
                voip_account_id: document.getElementById('voip_account_id').value.trim(),
                voip_password: document.getElementById('voip_password').value.trim(),
                voip_host_ip_address: document.getElementById('voip_host_ip_address').value.trim(),
                voip_type: document.getElementById('voip_type').value,
                voip_context: document.getElementById('voip_context').value.trim(),
                voip_account_details: document.getElementById('voip_account_details').value.trim()
            };

            // Validation
            if (!formData.trunk_name) {
                showNotification('error', 'Validation Error', 'Trunk Name is required');
                document.getElementById('trunk_name').focus();
                return;
            }

            const trunkId = document.getElementById('trunk_id').value;
            if (trunkId) {
                formData.trunk_id = trunkId;
            }

            try {
                const result = await apiCall(API_BASE_URL, 'POST', formData);
                
                if (result.success) {
                    const action = trunkId ? 'updated' : 'created';
                    showNotification('success', 'Trunk Saved', `Trunk ${action} successfully!`);
                    bootstrap.Modal.getInstance(document.getElementById('addTrunkModal')).hide();
                    resetForm();
                    await refreshData();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error saving trunk:', error);
                showNotification('error', 'Error', 'Failed to save trunk: ' + error.message);
            }
        }

        // Reset form
        function resetForm() {
            document.getElementById('trunkForm').reset();
            document.getElementById('trunk_id').value = '';
            document.getElementById('channels').value = '1';
            document.getElementById('addTrunkModalLabel').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Add New Trunk';
            showTypeConfiguration();
        }

        // Refresh data
        async function refreshData() {
            await Promise.all([loadTrunksData(), loadStats()]);
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