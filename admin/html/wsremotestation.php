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
        
        .pagination .page-link {
            border-radius: 6px;
            margin: 0 3px;
            border: 1px solid #e0e0e0;
            color: #3498db;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #3498db;
            border-color: #3498db;
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
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 mb-1"><i class="fas fa-phone-alt me-2"></i>WebRTC Channels Management</h1>
                    <p class="mb-0 opacity-75">Manage WebRTC channels and monitor their status</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#channelModal">
                        <i class="fas fa-plus me-1"></i> Add New Channel
                    </button>
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
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" maxlength="50" placeholder="e.g., user1001">
                                    <div class="form-text">Authentication username</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" maxlength="50" placeholder="Enter password">
                                    <div class="form-text">Authentication password</div>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" onclick="saveChannel()">Save Channel</button>
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

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // API Configuration
        const API_BASE_URL = '../api/webrtc_channels/'; // Adjust this to your API endpoint

        // Initialize DataTable
        let channelsTable;
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
                            return data === 1 || data === true
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
                                <button class="btn btn-outline-danger btn-action" onclick="deleteChannel(${data})" title="Delete">
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
        });

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // API Functions
        async function loadChannels() {
            showLoading(true);
            try {
                // In a real implementation, this would fetch from your API
                // For demo purposes, we'll use mock data
                const mockData = {
                    success: true,
                    data: [
                        {
                            id: 1,
                            server_ip: '192.168.1.100',
                            extension: '1001',
                            username: 'user1001',
                            password: 'pass1001',
                            context: 'default',
                            transport: 'udp',
                            transport_type: 'webrtc',
                            webrtc: 1,
                            direct_media: 0,
                            station_status: 'logged_in',
                            created_at: '2023-06-15 10:30:00'
                        },
                        {
                            id: 2,
                            server_ip: '192.168.1.101',
                            extension: '1002',
                            username: 'user1002',
                            password: 'pass1002',
                            context: 'default',
                            transport: 'tcp',
                            transport_type: 'webrtc',
                            webrtc: 1,
                            direct_media: 1,
                            station_status: 'logged_out',
                            created_at: '2023-06-16 14:45:00'
                        },
                        {
                            id: 3,
                            server_ip: '192.168.1.102',
                            extension: '1003',
                            username: 'user1003',
                            password: 'pass1003',
                            context: 'internal',
                            transport: 'ws',
                            transport_type: 'webrtc',
                            webrtc: 0,
                            direct_media: 0,
                            station_status: 'on_call',
                            created_at: '2023-06-17 09:15:00'
                        },
                        {
                            id: 4,
                            server_ip: '192.168.1.103',
                            extension: '1004',
                            username: 'user1004',
                            password: 'pass1004',
                            context: 'default',
                            transport: 'tls',
                            transport_type: 'webrtc',
                            webrtc: 1,
                            direct_media: 1,
                            station_status: 'paused',
                            created_at: '2023-06-18 16:20:00'
                        }
                    ]
                };
                
                // Simulate API delay
                setTimeout(() => {
                    if (mockData.success) {
                        channelsTable.clear().rows.add(mockData.data).draw();
                        updateStatistics(mockData.data);
                    } else {
                        showNotification('Failed to load channels', 'danger');
                    }
                    showLoading(false);
                }, 800);
                
            } catch (error) {
                console.error('Error loading channels:', error);
                showNotification('Error loading channels. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function getChannel(id) {
            showLoading(true);
            try {
                // In a real implementation, this would fetch from your API
                // For demo purposes, we'll use mock data
                const mockData = {
                    success: true,
                    data: {
                        id: id,
                        server_ip: '192.168.1.' + (100 + id),
                        extension: '100' + id,
                        username: 'user100' + id,
                        password: 'pass100' + id,
                        context: 'default',
                        transport: id % 2 === 0 ? 'tcp' : 'udp',
                        transport_type: 'webrtc',
                        webrtc: id % 2 === 0 ? 0 : 1,
                        direct_media: id % 3 === 0 ? 1 : 0,
                        station_status: id % 2 === 0 ? 'logged_out' : 'logged_in',
                        created_at: '2023-06-15 10:30:00'
                    }
                };
                
                // Simulate API delay
                return new Promise(resolve => {
                    setTimeout(() => {
                        showLoading(false);
                        if (mockData.success) {
                            resolve(mockData.data);
                        } else {
                            showNotification('Failed to load channel', 'danger');
                            resolve(null);
                        }
                    }, 500);
                });
            } catch (error) {
                console.error('Error loading channel:', error);
                showNotification('Error loading channel. Please check console.', 'danger');
                showLoading(false);
                return null;
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
                alert('Please enter an extension');
                return;
            }

            showLoading(true);
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate a successful response
                const mockResponse = {
                    success: true,
                    message: `Channel ${data.id ? 'updated' : 'created'} successfully!`
                };
                
                // Simulate API delay
                setTimeout(() => {
                    showLoading(false);
                    if (mockResponse.success) {
                        showNotification(mockResponse.message, 'success');
                        loadChannels();
                        
                        // Close modal
                        bootstrap.Modal.getInstance(document.getElementById('channelModal')).hide();
                    } else {
                        showNotification('Failed to save channel', 'danger');
                    }
                }, 800);
            } catch (error) {
                console.error('Error saving channel:', error);
                showNotification('Error saving channel. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function deleteChannel(id) {
            if (!confirm('Are you sure you want to delete channel #' + id + '?')) {
                return;
            }

            showLoading(true);
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate a successful response
                const mockResponse = {
                    success: true,
                    message: 'Channel deleted successfully!'
                };
                
                // Simulate API delay
                setTimeout(() => {
                    showLoading(false);
                    if (mockResponse.success) {
                        showNotification(mockResponse.message, 'success');
                        loadChannels();
                    } else {
                        showNotification('Failed to delete channel', 'danger');
                    }
                }, 800);
            } catch (error) {
                console.error('Error deleting channel:', error);
                showNotification('Error deleting channel. Please check console.', 'danger');
                showLoading(false);
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
                        <h6 class="text-muted">Channel Information</h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Channel ID:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.id}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Extension:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.extension}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Username:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.username || 'N/A'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Server IP:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.server_ip || 'N/A'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Context:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.context || 'N/A'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Transport:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.transport || 'N/A'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Transport Type:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.transport_type || 'N/A'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>WebRTC:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.webrtc == 1 
                            ? '<span class="badge badge-webrtc-enabled">Enabled</span>' 
                            : '<span class="badge badge-webrtc-disabled">Disabled</span>'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Direct Media:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.direct_media == 1 
                            ? '<span class="badge bg-success">Enabled</span>' 
                            : '<span class="badge bg-secondary">Disabled</span>'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Station Status:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.station_status 
                            ? `<span class="badge badge-${channel.station_status === 'logged_in' ? 'logged-in' : 'logged-out'}">${channel.station_status.replace('_', ' ').toUpperCase()}</span>` 
                            : 'N/A'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Created At:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${channel.created_at ? new Date(channel.created_at).toLocaleString() : 'N/A'}
                    </div>
                </div>
            `;

            // Populate modal body
            document.getElementById('viewModalBody').innerHTML = detailsHtml;

            // Show modal
            new bootstrap.Modal(document.getElementById('viewModal')).show();
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

        function showNotification(message, type = 'info') {
            const toastContainer = document.querySelector('.toast-container');
            
            // Create toast
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'danger' ? 'danger' : 'primary'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        // Reset form when modal is hidden
        document.getElementById('channelModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('channelForm').reset();
            document.getElementById('id').value = '';
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Add New WebRTC Channel';
        });
    </script>
</body>
</html>