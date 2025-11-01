<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Management - Asterisk PBX</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 25px;
            margin-bottom: 25px;
        }
        .compact-form .form-label {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.3rem;
        }
        .compact-form .form-control, .compact-form .form-select {
            font-size: 0.85rem;
            padding: 0.4rem 0.75rem;
            height: calc(1.5em + 0.8rem);
        }
        .compact-form .form-text {
            font-size: 0.75rem;
            margin-top: 0.2rem;
        }
        .form-group {
            margin-bottom: 0.8rem;
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
            color: #dc3545;
        }
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            margin: 0 2px;
        }
        .status-badge {
            font-size: 0.75rem;
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
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
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

    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
            <h1 class="h3"><i class="fas fa-server me-2"></i>Server Management</h1>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#serverModal">
                <i class="fas fa-plus me-1"></i> Add New Server
            </button>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search servers...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="statusFilter" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="Y">Active</option>
                        <option value="N">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="typeFilter" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="production">Production</option>
                        <option value="development">Development</option>
                        <option value="testing">Testing</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary btn-sm w-100" onclick="resetFilters()">
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
                            <th>Status</th>
                            <th>Telnet Port</th>
                            <th>Voice Port</th>
                            <th>DB Port</th>
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

        <!-- Statistics Cards -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="glass-card text-center">
                    <h6 class="text-muted">Total Servers</h6>
                    <h3 class="text-primary" id="totalServers">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card text-center">
                    <h6 class="text-muted">Active</h6>
                    <h3 class="text-success" id="activeServers">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card text-center">
                    <h6 class="text-muted">Inactive</h6>
                    <h3 class="text-warning" id="inactiveServers">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card text-center">
                    <h6 class="text-muted">This Month</h6>
                    <h3 class="text-info" id="monthServers">0</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Server Modal Form -->
    <div class="modal fade" id="serverModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-server me-2"></i>Add New Server</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="serverForm" class="compact-form">
                        <input type="hidden" id="server_id" name="server_id">
                        
                        <!-- Basic Information -->
                        <div class="section-title">Basic Information</div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="server_description" class="form-label required-field">Description</label>
                                    <input type="text" class="form-control" id="server_description" name="server_description" required maxlength="100" placeholder="e.g., Main Production Server">
                                    <small class="form-text text-muted">Short description for this server</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="server_ip" class="form-label required-field">IP Address</label>
                                    <input type="text" class="form-control" id="server_ip" name="server_ip" value="localhost" required maxlength="15">
                                    <small class="form-text text-muted">Server IP or hostname</small>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="active" class="form-label required-field">Status</label>
                                    <select class="form-select" id="active" name="active" required>
                                        <option value="N">Inactive</option>
                                        <option value="Y">Active</option>
                                    </select>
                                    <small class="form-text text-muted">Set server active status</small>
                                </div>
                            </div>
                        </div>

                        <!-- Telnet Settings -->
                        <div class="section-title mt-3">Telnet Settings</div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telnet_host" class="form-label">Host</label>
                                    <input type="text" class="form-control" id="telnet_host" name="telnet_host" value="localhost" maxlength="15">
                                    <small class="form-text text-muted">Telnet connection host</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telnet_port" class="form-label">Port</label>
                                    <input type="number" class="form-control" id="telnet_port" name="telnet_port" value="5038" min="1" max="65535">
                                    <small class="form-text text-muted">Telnet port number</small>
                                </div>
                            </div>
                        </div>

                        <!-- Manager Accounts -->
                        <div class="section-title mt-3">Manager Accounts</div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_manager" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="user_manager" name="user_manager" value="convox" maxlength="20">
                                    <small class="form-text text-muted">Manager username</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="secret_manager" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="secret_manager" name="secret_manager" value="convox" maxlength="20">
                                    <small class="form-text text-muted">Manager password</small>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="update_manager" class="form-label">Update User</label>
                                    <input type="text" class="form-control" id="update_manager" name="update_manager" value="updateconvox" maxlength="20">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="listen_manager" class="form-label">Listen User</label>
                                    <input type="text" class="form-control" id="listen_manager" name="listen_manager" value="listenconvox" maxlength="20">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="send_manager" class="form-label">Send User</label>
                                    <input type="text" class="form-control" id="send_manager" name="send_manager" value="sendconvox" maxlength="20">
                                </div>
                            </div>
                        </div>

                        <!-- Logging & Ports -->
                        <div class="section-title mt-3">Logging & Ports</div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sys_perf_log" class="form-label">Performance Log</label>
                                    <select class="form-select" id="sys_perf_log" name="sys_perf_log">
                                        <option value="N">Disabled</option>
                                        <option value="Y">Enabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vd_server_logs" class="form-label">VD Server Logs</label>
                                    <select class="form-select" id="vd_server_logs" name="vd_server_logs">
                                        <option value="N">Disabled</option>
                                        <option value="Y">Enabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agi_output" class="form-label">AGI Output</label>
                                    <select class="form-select" id="agi_output" name="agi_output">
                                        <option value="NONE">None</option>
                                        <option value="STDERR">STDERR</option>
                                        <option value="FILE" selected>File</option>
                                        <option value="BOTH">Both</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voice_web_port" class="form-label">Voice Web Port</label>
                                    <input type="number" class="form-control" id="voice_web_port" name="voice_web_port" value="0" min="0" max="65535">
                                    <small class="form-text text-muted">0 to disable</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="db_web_port" class="form-label">DB Web Port</label>
                                    <input type="number" class="form-control" id="db_web_port" name="db_web_port" value="0" min="0" max="65535">
                                    <small class="form-text text-muted">0 to disable</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveServer()">Save Server</button>
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
        const API_BASE_URL = '../api/server/'; // Adjust this to your API endpoint

        // Initialize DataTable
        let serversTable;
        $(document).ready(function() {
            serversTable = $('#serversTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search servers..."
                },
                columns: [
                    { data: 'server_id' },
                    { data: 'server_description' },
                    { data: 'server_ip' },
                    { 
                        data: 'active',
                        render: function(data, type, row) {
                            return data === 'Y' 
                                ? '<span class="badge bg-success status-badge">Active</span>' 
                                : '<span class="badge bg-warning status-badge">Inactive</span>';
                        }
                    },
                    { data: 'telnet_port' },
                    { data: 'voice_web_port' },
                    { data: 'db_web_port' },
                    { 
                        data: 'created_at',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString() : 'N/A';
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
                const response = await fetch(`${API_BASE_URL}servers.php?action=getAll`);
                const result = await response.json();
                
                if (result.success) {
                    serversTable.clear().rows.add(result.data).draw();
                    updateStatistics(result.data);
                } else {
                    showNotification('Failed to load servers: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error loading servers:', error);
                showNotification('Error loading servers. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        async function getServer(id) {
            showLoading(true);
            try {
                const response = await fetch(`${API_BASE_URL}servers.php?action=get&id=${id}`);
                const result = await response.json();
                
                if (result.success) {
                    return result.data;
                } else {
                    showNotification('Failed to load server: ' + result.message, 'danger');
                    return null;
                }
            } catch (error) {
                console.error('Error loading server:', error);
                showNotification('Error loading server. Please check console.', 'danger');
                return null;
            } finally {
                showLoading(false);
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

            showLoading(true);
            try {
                const action = data.server_id ? 'update' : 'create';
                const response = await fetch(`${API_BASE_URL}servers.php?action=${action}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(`Server ${data.server_id ? 'updated' : 'created'} successfully!`, 'success');
                    loadServers();
                    
                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('serverModal')).hide();
                } else {
                    showNotification('Failed to save server: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error saving server:', error);
                showNotification('Error saving server. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        async function deleteServer(id) {
            if (!confirm('Are you sure you want to delete server #' + id + '?')) {
                return;
            }

            showLoading(true);
            try {
                const response = await fetch(`${API_BASE_URL}servers.php?action=delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ server_id: id })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification('Server deleted successfully!', 'success');
                    loadServers();
                } else {
                    showNotification('Failed to delete server: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error deleting server:', error);
                showNotification('Error deleting server. Please check console.', 'danger');
            } finally {
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

            // Create a simple view modal
            let detailsHtml = '';
            Object.keys(server).forEach(key => {
                if (key !== 'server_id') {
                    detailsHtml += `<p><strong>${key.replace(/_/g, ' ')}:</strong> ${server[key]}</p>`;
                }
            });

            const viewModal = `
                <div class="modal fade" id="viewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Server Details - ID: ${server.server_id}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${detailsHtml}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('viewModal');
            if (existingModal) existingModal.remove();

            // Add modal to DOM and show it
            document.body.insertAdjacentHTML('beforeend', viewModal);
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
            serversTable.column(3).search(this.value).draw();
        });

        function resetFilters() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#typeFilter').val('');
            serversTable.search('').columns().search('').draw();
        }

        function showNotification(message, type = 'info') {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-bg-${type === 'success' ? 'success' : type === 'danger' ? 'danger' : 'primary'} border-0`;
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        // Auto-fill manager accounts
        document.getElementById('user_manager').addEventListener('blur', function(e) {
            const user = e.target.value;
            if (user && !document.getElementById('update_manager').value) {
                document.getElementById('update_manager').value = 'update' + user;
            }
            if (user && !document.getElementById('listen_manager').value) {
                document.getElementById('listen_manager').value = 'listen' + user;
            }
            if (user && !document.getElementById('send_manager').value) {
                document.getElementById('send_manager').value = 'send' + user;
            }
        });

        // Reset form when modal is hidden
        document.getElementById('serverModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('serverForm').reset();
            document.getElementById('server_id').value = '';
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Add New Server';
        });
    </script>
</body>
</html>