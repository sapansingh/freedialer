<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebRTC Channels Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #3498db;
            --light-bg: #f5f7fb;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }
        
        .header-section {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 32px rgba(52, 152, 219, 0.3);
        }
        
        .stat-card {
            text-align: center;
            padding: 20px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: scale(1.03);
        }
        
        .stat-card.total {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        
        .stat-card.active {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
        }
        
        .stat-card.inactive {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }
        
        .stat-card.logged-in {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
            color: white;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            margin: 0 2px;
            border-radius: 6px;
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 50px;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        
        .section-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #3498db;
            margin-bottom: 0.8rem;
            padding-bottom: 0.3rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        .required-field::after {
            content: ' *';
            color: #e74c3c;
        }
        
        .search-box {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .search-box:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .filter-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .filter-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .badge-webrtc-enabled {
            background-color: #2ecc71;
        }
        
        .badge-webrtc-disabled {
            background-color: #e74c3c;
        }
        
        .badge-logged-in {
            background-color: #2ecc71;
        }
        
        .badge-logged-out {
            background-color: #f39c12;
        }
        
        .form-check-input:checked {
            background-color: #3498db;
            border-color: #3498db;
        }
        
        .notification-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .notification-success { color: #28a745; }
        .notification-warning { color: #ffc107; }
        .notification-danger { color: #dc3545; }
        .notification-info { color: #17a2b8; }
        
        .range-validation {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .range-validation.valid {
            color: #28a745;
        }
        
        .range-validation.invalid {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 mb-1"><i class="fas fa-phone-alt me-2"></i>WebRTC Channels Management</h1>
                    <p class="mb-0 opacity-75">Manage WebRTC channels and monitor their status</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="btn-group">
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#channelModal">
                            <i class="fas fa-plus me-1"></i> Add Channel
                        </button>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#generateModal">
                            <i class="fas fa-bolt me-1"></i> Auto Generate
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card total">
                    <h6 class="text-white-50 mb-1">Total Channels</h6>
                    <h3 class="text-white" id="totalChannels">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card active">
                    <h6 class="text-white-50 mb-1">WebRTC Enabled</h6>
                    <h3 class="text-white" id="webrtcEnabled">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card inactive">
                    <h6 class="text-white-50 mb-1">WebRTC Disabled</h6>
                    <h3 class="text-white" id="webrtcDisabled">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card logged-in">
                    <h6 class="text-white-50 mb-1">Logged In</h6>
                    <h3 class="text-white" id="loggedIn">0</h3>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control search-box border-start-0" placeholder="Search channels...">
                    </div>
                </div>
                <div class="col-md-2">
                    <select id="webrtcFilter" class="form-select filter-select">
                        <option value="">WebRTC Status</option>
                        <option value="1">Enabled</option>
                        <option value="0">Disabled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="statusFilter" class="form-select filter-select">
                        <option value="">Station Status</option>
                        <option value="logged_in">Logged In</option>
                        <option value="logged_out">Logged Out</option>
                        <option value="on_call">On Call</option>
                        <option value="paused">Paused</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="transportFilter" class="form-select filter-select">
                        <option value="">Transport</option>
                        <option value="udp">UDP</option>
                        <option value="tcp">TCP</option>
                        <option value="tls">TLS</option>
                        <option value="ws">WebSocket</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="fas fa-redo me-1"></i> Reset Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="glass-card">
            <div class="table-responsive">
                <table id="channelsTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Extension</th>
                            <th>Username</th>
                            <th>Server IP</th>
                            <th>WebRTC</th>
                            <th>Transport</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Channel Modal Form -->
    <div class="modal fade" id="channelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-phone-alt me-2"></i>Add New WebRTC Channel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="channelForm">
                        <input type="hidden" id="id" name="id">
                        
                        <div class="section-title">Basic Information</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="extension" class="form-label required-field">Extension</label>
                                    <input type="text" class="form-control" id="extension" name="extension" required maxlength="10" placeholder="e.g., 1001">
                                    <div class="form-text">The extension number for this channel</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="server_ip" class="form-label">Server IP</label>
                                    <input type="text" class="form-control" id="server_ip" name="server_ip" maxlength="20" placeholder="e.g., 192.168.1.100">
                                    <div class="form-text">The server IP address (optional)</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="section-title">Configuration</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="context" class="form-label">Context</label>
                                    <input type="text" class="form-control" id="context" name="context" maxlength="50" placeholder="e.g., default">
                                    <div class="form-text">Dialplan context</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="transport" class="form-label">Transport</label>
                                    <select class="form-select" id="transport" name="transport">
                                        <option value="udp">UDP</option>
                                        <option value="tcp">TCP</option>
                                        <option value="tls">TLS</option>
                                        <option value="ws">WebSocket</option>
                                    </select>
                                    <div class="form-text">Transport protocol</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="transport_type" class="form-label">Transport Type</label>
                                    <input type="text" class="form-control" id="transport_type" name="transport_type" maxlength="50" placeholder="e.g., webrtc">
                                    <div class="form-text">Transport type specification</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="station_status" class="form-label">Station Status</label>
                                    <select class="form-select" id="station_status" name="station_status">
                                        <option value="logged_out">Logged Out</option>
                                        <option value="logged_in">Logged In</option>
                                        <option value="on_call">On Call</option>
                                        <option value="paused">Paused</option>
                                    </select>
                                    <div class="form-text">Current station status</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="section-title">Features</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="webrtc" name="webrtc" checked>
                                    <label class="form-check-label" for="webrtc">WebRTC Enabled</label>
                                    <div class="form-text">Enable WebRTC for this channel</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="direct_media" name="direct_media">
                                    <label class="form-check-label" for="direct_media">Direct Media</label>
                                    <div class="form-text">Enable direct media (non-ACL)</div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Auto-generated credentials:</strong> Username and password will be automatically generated based on the extension (e.g., user1001, pass1001)
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" onclick="saveChannel()">Save Channel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Generate Multiple Channels Modal -->
    <div class="modal fade" id="generateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-bolt me-2"></i>Auto Generate Channels</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="generateForm">
                        <div class="section-title">Extension Range</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_extension" class="form-label required-field">Start Extension</label>
                                    <input type="number" class="form-control" id="start_extension" name="start_extension" required min="1000" max="9999" placeholder="e.g., 1000">
                                    <div class="form-text">Starting extension number</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_extension" class="form-label required-field">End Extension</label>
                                    <input type="number" class="form-control" id="end_extension" name="end_extension" required min="1000" max="9999" placeholder="e.g., 1010">
                                    <div class="form-text">Ending extension number</div>
                                </div>
                            </div>
                        </div>

                        <!-- Range Validation Display -->
                        <div id="rangeValidation" class="alert alert-info d-none">
                            <div id="rangePreview"></div>
                            <div id="rangeStatus" class="range-validation mt-1"></div>
                        </div>
                        
                        <div class="section-title">Server Configuration</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="generate_server_ip" class="form-label required-field">Server IP</label>
                                    <input type="text" class="form-control" id="generate_server_ip" name="server_ip" required maxlength="20" placeholder="e.g., 192.168.1.100">
                                    <div class="form-text">Server IP address for all channels</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="context" class="form-label">Context</label>
                                    <input type="text" class="form-control" id="generate_context" name="context" maxlength="50" placeholder="e.g., default" value="default">
                                    <div class="form-text">Dialplan context for all channels</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="section-title">Channel Settings</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="generate_transport" class="form-label">Transport</label>
                                    <select class="form-select" id="generate_transport" name="transport">
                                        <option value="udp" selected>UDP</option>
                                        <option value="tcp">TCP</option>
                                        <option value="tls">TLS</option>
                                        <option value="ws">WebSocket</option>
                                    </select>
                                    <div class="form-text">Transport protocol for all channels</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="generate_transport_type" class="form-label">Transport Type</label>
                                    <input type="text" class="form-control" id="generate_transport_type" name="transport_type" maxlength="50" placeholder="e.g., webrtc" value="webrtc">
                                    <div class="form-text">Transport type for all channels</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="generate_webrtc" name="webrtc" checked>
                                    <label class="form-check-label" for="generate_webrtc">WebRTC Enabled</label>
                                    <div class="form-text">Enable WebRTC for all channels</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="generate_direct_media" name="direct_media">
                                    <label class="form-check-label" for="generate_direct_media">Direct Media</label>
                                    <div class="form-text">Enable direct media for all channels</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Auto-generated credentials:</strong> Usernames and passwords will be automatically generated based on extensions (e.g., user1001, pass1001)
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="generateButton" onclick="generateChannels()" disabled>
                        <i class="fas fa-bolt me-1"></i> Generate Channels
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Channel Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Channel Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewModalBody">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-triangle notification-warning notification-icon"></i>
                    <h6 class="mb-2">Confirm Delete</h6>
                    <p class="small text-muted mb-3">Are you sure you want to delete this channel?</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <i class="fas fa-check-circle notification-success notification-icon"></i>
                    <h6 class="mb-2">Success</h6>
                    <p class="small text-muted mb-3" id="successMessage">Operation completed successfully</p>
                    <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <i class="fas fa-times-circle notification-danger notification-icon"></i>
                    <h6 class="mb-2">Error</h6>
                    <p class="small text-muted mb-3" id="errorMessage">An error occurred</p>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // API Configuration
        const API_BASE_URL = '../api/';

        // Initialize DataTable
        let channelsTable;
        let currentDeleteId = null;

        $(document).ready(function() {
            channelsTable = $('#channelsTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search channels...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'extension' },
                    { data: 'username' },
                    { data: 'server_ip' },
                    { 
              
    data: 'webrtc',
    render: function(data, type, row) {
        // Convert to boolean - any truthy value will be considered enabled
        const isEnabled = Boolean(Number(data));
        return isEnabled
            ? '<span class="badge badge-webrtc-enabled status-badge"><i class="fas fa-check-circle me-1"></i>Enabled</span>' 
            : '<span class="badge badge-webrtc-disabled status-badge"><i class="fas fa-times-circle me-1"></i>Disabled</span>';
    }

                    },
                    { data: 'transport' },
                    { 
                        data: 'station_status',
                        render: function(data, type, row) {
                            let badgeClass = 'badge-logged-out';
                            let icon = 'fa-sign-out-alt';
                            
                            if (data === 'logged_in') {
                                badgeClass = 'badge-logged-in';
                                icon = 'fa-sign-in-alt';
                            } else if (data === 'on_call') {
                                badgeClass = 'badge-primary';
                                icon = 'fa-phone-alt';
                            } else if (data === 'paused') {
                                badgeClass = 'badge-warning';
                                icon = 'fa-pause';
                            }
                            
                            return `<span class="badge ${badgeClass} status-badge"><i class="fas ${icon} me-1"></i>${data ? data.replace('_', ' ').toUpperCase() : 'N/A'}</span>`;
                        }
                    },
                    { 
                        data: 'created_at',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString() : 'N/A';
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-outline-primary btn-action" onclick="editChannel(${data})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-info btn-action" onclick="viewChannel(${data})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-action" onclick="showDeleteConfirm(${data})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                        },
                        orderable: false
                    }
                ]
            });

            // Load initial data
            loadChannels();

            // Delete confirmation handler
            $('#confirmDeleteBtn').click(function() {
                if (currentDeleteId) {
                    deleteChannel(currentDeleteId);
                }
            });

            // Extension range validation
            $('#start_extension, #end_extension').on('input', validateExtensionRange);
        });

        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        async function validateExtensionRange() {
            const start = $('#start_extension').val();
            const end = $('#end_extension').val();
            const validationDiv = $('#rangeValidation');
            const rangePreview = $('#rangePreview');
            const rangeStatus = $('#rangeStatus');
            const generateButton = $('#generateButton');

            if (!start || !end) {
                validationDiv.addClass('d-none');
                generateButton.prop('disabled', true);
                return;
            }

            if (parseInt(start) > parseInt(end)) {
                validationDiv.removeClass('d-none').removeClass('alert-info alert-success alert-warning').addClass('alert-warning');
                rangePreview.html('<i class="fas fa-exclamation-triangle me-2"></i><strong>Range:</strong> ' + start + ' to ' + end);
                rangeStatus.html('<span class="range-validation invalid">Start extension must be less than or equal to end extension</span>');
                generateButton.prop('disabled', true);
                return;
            }

            const totalExtensions = (parseInt(end) - parseInt(start)) + 1;
            
            if (totalExtensions > 100) {
                validationDiv.removeClass('d-none').removeClass('alert-info alert-success alert-warning').addClass('alert-warning');
                rangePreview.html('<i class="fas fa-exclamation-triangle me-2"></i><strong>Range:</strong> ' + start + ' to ' + end);
                rangeStatus.html('<span class="range-validation invalid">Cannot generate more than 100 channels at once</span>');
                generateButton.prop('disabled', true);
                return;
            }

            // Show loading state
            validationDiv.removeClass('d-none').removeClass('alert-info alert-success alert-warning').addClass('alert-info');
            rangePreview.html('<i class="fas fa-spinner fa-spin me-2"></i><strong>Range:</strong> ' + start + ' to ' + end);
            rangeStatus.html('<span class="range-validation">Checking extension availability...</span>');

            try {
                const response = await fetch(API_BASE_URL + 'webrtc_channels.php?action=checkExtensionRange', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        start_extension: start,
                        end_extension: end
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    const data = result.data;
                    
                    if (data.can_generate) {
                        validationDiv.removeClass('alert-info alert-warning').addClass('alert-success');
                        rangePreview.html('<i class="fas fa-check-circle me-2"></i><strong>Range:</strong> ' + start + ' to ' + end);
                        
                        let statusText = `<span class="range-validation valid">Ready to generate ${data.available_extensions} channels`;
                        if (data.existing_extensions.length > 0) {
                            statusText += ` (${data.existing_extensions.length} extensions already exist)`;
                        }
                        statusText += '</span>';
                        
                        rangeStatus.html(statusText);
                        generateButton.prop('disabled', false);
                    } else {
                        validationDiv.removeClass('alert-info alert-success').addClass('alert-warning');
                        rangePreview.html('<i class="fas fa-exclamation-triangle me-2"></i><strong>Range:</strong> ' + start + ' to ' + end);
                        rangeStatus.html('<span class="range-validation invalid">All extensions in this range already exist</span>');
                        generateButton.prop('disabled', true);
                    }
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error validating extension range:', error);
                validationDiv.removeClass('alert-info alert-success').addClass('alert-warning');
                rangePreview.html('<i class="fas fa-exclamation-triangle me-2"></i><strong>Range:</strong> ' + start + ' to ' + end);
                rangeStatus.html('<span class="range-validation invalid">Error checking extension availability</span>');
                generateButton.prop('disabled', true);
            }
        }

        // API Functions
        async function loadChannels() {
            showLoading(true);
            try {
                const response = await fetch(API_BASE_URL + 'webrtc_channels.php?action=getAll');
                const result = await response.json();
                
                if (result.success) {
                    channelsTable.clear().rows.add(result.data).draw();
                    updateStatistics(result.data);
                } else {
                    showErrorModal('Error loading channels: ' + result.message);
                }
            } catch (error) {
                console.error('Error loading channels:', error);
                showErrorModal('Failed to load channels. Please check console.');
            } finally {
                showLoading(false);
            }
        }

        async function getChannel(id) {
            showLoading(true);
            try {
                const response = await fetch(API_BASE_URL + 'webrtc_channels.php?action=get&id=' + id);
                const result = await response.json();
                
                if (result.success) {
                    return result.data;
                } else {
                    showErrorModal('Failed to load channel: ' + result.message);
                    return null;
                }
            } catch (error) {
                console.error('Error loading channel:', error);
                showErrorModal('Failed to load channel. Please check console.');
                return null;
            } finally {
                showLoading(false);
            }
        }

        async function saveChannel() {
            const formData = new FormData(document.getElementById('channelForm'));
            const data = Object.fromEntries(formData);
            
            // Convert checkbox values to proper boolean
            data.webrtc = document.getElementById('webrtc').checked ? 1 : 0;
            data.direct_media = document.getElementById('direct_media').checked ? 1 : 0;
            
            // Validation
            if (!data.extension.trim()) {
                showErrorModal('Please enter an extension');
                return;
            }

            showLoading(true);
            try {
                const action = data.id ? 'update' : 'create';
                const response = await fetch(API_BASE_URL + 'webrtc_channels.php?action=' + action, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showSuccessModal(result.message);
                    loadChannels();
                    $('#channelModal').modal('hide');
                } else {
                    showErrorModal(result.message);
                }
            } catch (error) {
                console.error('Error saving channel:', error);
                showErrorModal('Failed to save channel');
            } finally {
                showLoading(false);
            }
        }

        async function generateChannels() {
            const formData = new FormData(document.getElementById('generateForm'));
            const data = Object.fromEntries(formData);
            
            // Convert checkbox values to proper boolean
            data.webrtc = document.getElementById('generate_webrtc').checked ? 1 : 0;
            data.direct_media = document.getElementById('generate_direct_media').checked ? 1 : 0;
            
            // Validation
            if (!data.start_extension || !data.end_extension || !data.server_ip) {
                showErrorModal('Please fill all required fields');
                return;
            }

            if (parseInt(data.start_extension) > parseInt(data.end_extension)) {
                showErrorModal('Start extension must be less than or equal to end extension');
                return;
            }

            showLoading(true);
            try {
                const response = await fetch(API_BASE_URL + 'webrtc_channels.php?action=generateMultiple', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showSuccessModal(result.message);
                    loadChannels();
                    $('#generateModal').modal('hide');
                } else {
                    showErrorModal(result.message);
                }
            } catch (error) {
                console.error('Error generating channels:', error);
                showErrorModal('Failed to generate channels');
            } finally {
                showLoading(false);
            }
        }

        async function deleteChannel(id) {
            showLoading(true);
            try {
                const response = await fetch(API_BASE_URL + 'webrtc_channels.php?action=delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showSuccessModal(result.message);
                    loadChannels();
                    $('#deleteModal').modal('hide');
                } else {
                    showErrorModal(result.message);
                }
            } catch (error) {
                console.error('Error deleting channel:', error);
                showErrorModal('Failed to delete channel');
            } finally {
                showLoading(false);
                currentDeleteId = null;
            }
        }

        // UI Functions
        async function editChannel(id) {
            const channel = await getChannel(id);
            if (!channel) return;

            // Populate form
            Object.keys(channel).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    if (element.type === 'checkbox') {
                        element.checked = channel[key] == 1;
                    } else {
                        element.value = channel[key];
                    }
                }
            });

            // Update modal title
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Channel';

            // Show modal
            new bootstrap.Modal(document.getElementById('channelModal')).show();
        }

        async function viewChannel(id) {
            const channel = await getChannel(id);
            if (!channel) return;

            // Create details HTML
            const detailsHtml = `
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6 class="text-primary">Channel Information</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Channel ID</strong>
                        <span>${channel.id}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Extension</strong>
                        <span class="badge bg-primary">${channel.extension}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Username</strong>
                        <span>${channel.username || 'N/A'}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Password</strong>
                        <span class="text-muted">••••••••</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Server IP</strong>
                        <code>${channel.server_ip || 'N/A'}</code>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Context</strong>
                        <span>${channel.context || 'N/A'}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Transport</strong>
                        <span class="badge bg-info">${channel.transport || 'N/A'}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Transport Type</strong>
                        <span>${channel.transport_type || 'N/A'}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">WebRTC</strong>
                        ${channel.webrtc == 1 
                            ? '<span class="badge badge-webrtc-enabled">Enabled</span>' 
                            : '<span class="badge badge-webrtc-disabled">Disabled</span>'}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Direct Media</strong>
                        ${channel.direct_media == 1 
                            ? '<span class="badge bg-success">Enabled</span>' 
                            : '<span class="badge bg-secondary">Disabled</span>'}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Station Status</strong>
                        ${channel.station_status 
                            ? `<span class="badge badge-${channel.station_status === 'logged_in' ? 'logged-in' : 'logged-out'}">${channel.station_status.replace('_', ' ').toUpperCase()}</span>` 
                            : 'N/A'}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="d-block text-muted small">Created At</strong>
                        <span>${channel.created_at ? new Date(channel.created_at).toLocaleString() : 'N/A'}</span>
                    </div>
                </div>
            `;

            // Populate modal body
            document.getElementById('viewModalBody').innerHTML = detailsHtml;

            // Show modal
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }

        function showDeleteConfirm(id) {
            currentDeleteId = id;
            $('#deleteModal').modal('show');
        }

        function updateStatistics(channels) {
            const total = channels.length;
            const webrtcEnabled = channels.filter(c => c.webrtc == 1).length;
            const webrtcDisabled = total - webrtcEnabled;
            const loggedIn = channels.filter(c => c.station_status === 'logged_in').length;
            
            document.getElementById('totalChannels').textContent = total;
            document.getElementById('webrtcEnabled').textContent = webrtcEnabled;
            document.getElementById('webrtcDisabled').textContent = webrtcDisabled;
            document.getElementById('loggedIn').textContent = loggedIn;
        }

        // Search functionality
        $('#searchInput').on('keyup', function() {
            channelsTable.search(this.value).draw();
        });

        // Filter by WebRTC status
        $('#webrtcFilter').on('change', function() {
            channelsTable.column(4).search(this.value).draw();
        });

        // Filter by station status
        $('#statusFilter').on('change', function() {
            channelsTable.column(6).search(this.value).draw();
        });

        // Filter by transport
        $('#transportFilter').on('change', function() {
            channelsTable.column(5).search(this.value).draw();
        });

        function resetFilters() {
            $('#searchInput').val('');
            $('#webrtcFilter').val('');
            $('#statusFilter').val('');
            $('#transportFilter').val('');
            channelsTable.search('').columns().search('').draw();
        }

        // Modal Functions
        function showSuccessModal(message) {
            $('#successMessage').text(message);
            $('#successModal').modal('show');
        }

        function showErrorModal(message) {
            $('#errorMessage').text(message);
            $('#errorModal').modal('show');
        }

        // Reset form when modal closes
        $('#channelModal').on('hidden.bs.modal', function() {
            document.getElementById('channelForm').reset();
            $('#id').val('');
            $('#modalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Add New WebRTC Channel';
        });

        $('#generateModal').on('hidden.bs.modal', function() {
            document.getElementById('generateForm').reset();
            $('#rangeValidation').addClass('d-none');
            $('#generateButton').prop('disabled', true);
        });
    </script>
</body>
</html>