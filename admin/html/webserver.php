<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Servers Management</title>
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
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: #f5f7fb;
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
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 32px rgba(67, 97, 238, 0.3);
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
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
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
        
        .stat-card.month {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
            color: white;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
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
            background-color: rgba(67, 97, 238, 0.05);
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
            color: #4361ee;
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
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        .filter-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .filter-select:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
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
            color: #4361ee;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #4361ee;
            border-color: #4361ee;
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
                    <h1 class="h3 mb-1"><i class="fas fa-server me-2"></i>Web Servers Management</h1>
                    <p class="mb-0 opacity-75">Manage your web servers and monitor their status</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#serverModal">
                        <i class="fas fa-plus me-1"></i> Add New Server
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card total">
                    <h6 class="text-white-50 mb-1">Total Servers</h6>
                    <h3 class="text-white" id="totalServers">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card active">
                    <h6 class="text-white-50 mb-1">Active</h6>
                    <h3 class="text-white" id="activeServers">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card inactive">
                    <h6 class="text-white-50 mb-1">Inactive</h6>
                    <h3 class="text-white" id="inactiveServers">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card month">
                    <h6 class="text-white-50 mb-1">This Month</h6>
                    <h3 class="text-white" id="monthServers">0</h3>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control search-box border-start-0" placeholder="Search servers...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="statusFilter" class="form-select filter-select">
                        <option value="">All Status</option>
                        <option value="Y">Active</option>
                        <option value="N">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="portFilter" class="form-select filter-select">
                        <option value="">All Ports</option>
                        <option value="80">Port 80</option>
                        <option value="443">Port 443</option>
                        <option value="8080">Port 8080</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="fas fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="glass-card">
            <div class="table-responsive">
                <table id="serversTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Port</th>
                            <th>Status</th>
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

    <!-- Server Modal Form -->
    <div class="modal fade" id="serverModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-server me-2"></i>Add New Server</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="serverForm">
                        <input type="hidden" id="server_id" name="server_id">
                        
                        <div class="mb-3">
                            <label for="server_description" class="form-label required-field">Description</label>
                            <input type="text" class="form-control" id="server_description" name="server_description" required maxlength="100" placeholder="e.g., Production Web Server">
                            <div class="form-text">A short description to identify this server</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="server_ip" class="form-label required-field">IP Address</label>
                            <input type="text" class="form-control" id="server_ip" name="server_ip" required maxlength="20" placeholder="e.g., 192.168.1.100">
                            <div class="form-text">The IP address or hostname of the server</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="port" class="form-label required-field">Port</label>
                            <input type="text" class="form-control" id="port" name="port" required maxlength="10" placeholder="e.g., 80, 443, 8080">
                            <div class="form-text">The port number the server is listening on</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="active" class="form-label required-field">Status</label>
                            <select class="form-select" id="active" name="active" required>
                                <option value="N">Inactive</option>
                                <option value="Y">Active</option>
                            </select>
                            <div class="form-text">Set the server status</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" onclick="saveServer()">Save Server</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Server Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Server Details</h5>
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
        const API_BASE_URL = '../api/web_servers/'; // Adjust this to your API endpoint

        // Initialize DataTable
        let serversTable;
        $(document).ready(function() {
            serversTable = $('#serversTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search servers...",
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
                    { data: 'server_id' },
                    { data: 'server_description' },
                    { data: 'server_ip' },
                    { data: 'port' },
                    { 
                        data: 'active',
                        render: function(data, type, row) {
                            return data === 'Y' 
                                ? '<span class="badge bg-success status-badge"><i class="fas fa-check-circle me-1"></i>Active</span>' 
                                : '<span class="badge bg-warning status-badge"><i class="fas fa-times-circle me-1"></i>Inactive</span>';
                        }
                    },
                    {
                        data: 'server_id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-outline-primary btn-action" onclick="editServer(${data})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-info btn-action" onclick="viewServer(${data})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-action" onclick="deleteServer(${data})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                        },
                        orderable: false
                    }
                ]
            });

            // Load initial data
            loadServers();
        });

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // API Functions
        async function loadServers() {
            showLoading(true);
            try {
                // In a real implementation, this would fetch from your API
                // For demo purposes, we'll use mock data
                const mockData = {
                    success: true,
                    data: [
                        {
                            server_id: 1,
                            server_ip: '192.168.1.100',
                            port: '80',
                            server_description: 'Production Web Server',
                            active: 'Y'
                        },
                        {
                            server_id: 2,
                            server_ip: '192.168.1.101',
                            port: '443',
                            server_description: 'Development Server',
                            active: 'N'
                        },
                        {
                            server_id: 3,
                            server_ip: '192.168.1.102',
                            port: '8080',
                            server_description: 'Testing Server',
                            active: 'Y'
                        },
                        {
                            server_id: 4,
                            server_ip: '192.168.1.103',
                            port: '80',
                            server_description: 'Staging Server',
                            active: 'Y'
                        }
                    ]
                };
                
                // Simulate API delay
                setTimeout(() => {
                    if (mockData.success) {
                        serversTable.clear().rows.add(mockData.data).draw();
                        updateStatistics(mockData.data);
                    } else {
                        showNotification('Failed to load servers', 'danger');
                    }
                    showLoading(false);
                }, 800);
                
            } catch (error) {
                console.error('Error loading servers:', error);
                showNotification('Error loading servers. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function getServer(id) {
            showLoading(true);
            try {
                // In a real implementation, this would fetch from your API
                // For demo purposes, we'll use mock data
                const mockData = {
                    success: true,
                    data: {
                        server_id: id,
                        server_ip: '192.168.1.' + (100 + id),
                        port: id % 2 === 0 ? '443' : '80',
                        server_description: 'Server ' + id,
                        active: id % 2 === 0 ? 'N' : 'Y'
                    }
                };
                
                // Simulate API delay
                return new Promise(resolve => {
                    setTimeout(() => {
                        showLoading(false);
                        if (mockData.success) {
                            resolve(mockData.data);
                        } else {
                            showNotification('Failed to load server', 'danger');
                            resolve(null);
                        }
                    }, 500);
                });
            } catch (error) {
                console.error('Error loading server:', error);
                showNotification('Error loading server. Please check console.', 'danger');
                showLoading(false);
                return null;
            }
        }

        async function saveServer() {
            const formData = new FormData(document.getElementById('serverForm'));
            const data = Object.fromEntries(formData);
            
            // Validation
            if (!data.server_description.trim()) {
                alert('Please enter a server description');
                return;
            }
            
            if (!data.server_ip.trim()) {
                alert('Please enter a server IP address');
                return;
            }
            
            if (!data.port.trim()) {
                alert('Please enter a port number');
                return;
            }

            showLoading(true);
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate a successful response
                const mockResponse = {
                    success: true,
                    message: `Server ${data.server_id ? 'updated' : 'created'} successfully!`
                };
                
                // Simulate API delay
                setTimeout(() => {
                    showLoading(false);
                    if (mockResponse.success) {
                        showNotification(mockResponse.message, 'success');
                        loadServers();
                        
                        // Close modal
                        bootstrap.Modal.getInstance(document.getElementById('serverModal')).hide();
                    } else {
                        showNotification('Failed to save server', 'danger');
                    }
                }, 800);
            } catch (error) {
                console.error('Error saving server:', error);
                showNotification('Error saving server. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function deleteServer(id) {
            if (!confirm('Are you sure you want to delete server #' + id + '?')) {
                return;
            }

            showLoading(true);
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate a successful response
                const mockResponse = {
                    success: true,
                    message: 'Server deleted successfully!'
                };
                
                // Simulate API delay
                setTimeout(() => {
                    showLoading(false);
                    if (mockResponse.success) {
                        showNotification(mockResponse.message, 'success');
                        loadServers();
                    } else {
                        showNotification('Failed to delete server', 'danger');
                    }
                }, 800);
            } catch (error) {
                console.error('Error deleting server:', error);
                showNotification('Error deleting server. Please check console.', 'danger');
                showLoading(false);
            }
        }

        // UI Functions
        async function editServer(id) {
            const server = await getServer(id);
            if (!server) return;

            // Populate form
            Object.keys(server).forEach(key => {
                const element = document.getElementById(key);
                if (element) element.value = server[key];
            });

            // Update modal title
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Server';

            // Show modal
            new bootstrap.Modal(document.getElementById('serverModal')).show();
        }

        async function viewServer(id) {
            const server = await getServer(id);
            if (!server) return;

            // Create details HTML
            const detailsHtml = `
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6 class="text-muted">Server Information</h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Server ID:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${server.server_id}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Description:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${server.server_description}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>IP Address:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${server.server_ip}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Port:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${server.port}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${server.active === 'Y' 
                            ? '<span class="badge bg-success">Active</span>' 
                            : '<span class="badge bg-warning">Inactive</span>'}
                    </div>
                </div>
            `;

            // Populate modal body
            document.getElementById('viewModalBody').innerHTML = detailsHtml;

            // Show modal
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }

        function updateStatistics(servers) {
            const total = servers.length;
            const active = servers.filter(s => s.active === 'Y').length;
            const inactive = total - active;
            
            // For this month count, we'd need a created_at field in the database
            // This is a placeholder implementation
            const thisMonth = servers.length; // Simplified for demo
            
            document.getElementById('totalServers').textContent = total;
            document.getElementById('activeServers').textContent = active;
            document.getElementById('inactiveServers').textContent = inactive;
            document.getElementById('monthServers').textContent = thisMonth;
        }

        // Search functionality
        $('#searchInput').on('keyup', function() {
            serversTable.search(this.value).draw();
        });

        // Filter by status
        $('#statusFilter').on('change', function() {
            serversTable.column(4).search(this.value).draw();
        });

        // Filter by port
        $('#portFilter').on('change', function() {
            serversTable.column(3).search(this.value).draw();
        });

        function resetFilters() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#portFilter').val('');
            serversTable.search('').columns().search('').draw();
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
        document.getElementById('serverModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('serverForm').reset();
            document.getElementById('server_id').value = '';
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Add New Server';
        });
    </script>
</body>
</html>