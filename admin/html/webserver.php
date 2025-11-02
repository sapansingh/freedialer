<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Server Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .stat-card {
            padding: 15px;
            border-radius: 8px;
            color: white;
            text-align: center;
        }
        .stat-card.total { background: linear-gradient(135deg, #667eea, #764ba2); }
        .stat-card.active { background: linear-gradient(135deg, #11998e, #38ef7d); }
        .stat-card.inactive { background: linear-gradient(135deg, #ff416c, #ff4b2b); }
        .server-row {
            border-left: 4px solid #28a745;
            margin-bottom: 10px;
        }
        .server-row.inactive {
            border-left-color: #ffc107;
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        .form-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .notification-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .notification-success { color: #28a745; }
        .notification-warning { color: #ffc107; }
        .notification-danger { color: #dc3545; }
        .notification-info { color: #17a2b8; }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Toast Container for Notifications -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fas fa-server text-primary me-2"></i>Web Server Management</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#serverModal">
                <i class="fas fa-plus me-1"></i> Add Web Server
            </button>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card total">
                    <h6 class="mb-1">Total Web Servers</h6>
                    <h3 class="mb-0" id="totalServers">0</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card active">
                    <h6 class="mb-1">Active</h6>
                    <h3 class="mb-0" id="activeServers">0</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card inactive">
                    <h6 class="mb-1">Inactive</h6>
                    <h3 class="mb-0" id="inactiveServers">0</h3>
                </div>
            </div>
        </div>

        <!-- Web Servers List -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-list me-2"></i>Web Servers List</h5>
                <div id="serversList">
                    <!-- Web servers will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Web Server Modal -->
    <div class="modal fade" id="serverModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Web Server</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="serverForm">
                        <input type="hidden" id="server_id" name="server_id">
                        
                        <!-- Basic Information -->
                        <div class="form-section">
                            <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Basic Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Server Description</label>
                                        <input type="text" class="form-control" id="server_description" name="server_description" required 
                                               placeholder="e.g., Production Web Server">
                                        <div class="form-text">A descriptive name for this web server</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Status</label>
                                        <select class="form-select" id="active" name="active" required>
                                            <option value="Y">Active</option>
                                            <option value="N">Inactive</option>
                                        </select>
                                        <div class="form-text">Set the server status</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Network Configuration -->
                        <div class="form-section">
                            <h6 class="mb-3"><i class="fas fa-network-wired me-2"></i>Network Configuration</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">IP Address</label>
                                        <input type="text" class="form-control" id="server_ip" name="server_ip" required 
                                               placeholder="e.g., 192.168.1.100">
                                        <div class="form-text">Server IP address or hostname</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Port</label>
                                        <input type="text" class="form-control" id="port" name="port" required 
                                               placeholder="e.g., 80, 443, 8080">
                                        <div class="form-text">Web server port number</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Common Port Presets -->
                        <div class="mb-3">
                            <label class="form-label">Quick Port Selection</label>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setPort('80')">HTTP (80)</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setPort('443')">HTTPS (443)</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setPort('8080')">8080</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setPort('8443')">8443</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setPort('3000')">3000</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setPort('5000')">5000</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveServer()">Save Web Server</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Server Details Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Server Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewModalBody">
                    <!-- Server details will be loaded here -->
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
                    <p class="small text-muted mb-3">Are you sure you want to delete this web server?</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Validation Warning Modal -->
    <div class="modal fade" id="validationModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-circle notification-warning notification-icon"></i>
                    <h6 class="mb-2" id="validationTitle">Validation Error</h6>
                    <p class="small text-muted mb-3" id="validationMessage">Please check your input</p>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">OK</button>
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

    <script>
        const API_BASE_URL = '../api/';
        let currentDeleteId = null;

        $(document).ready(function() {
            loadServers();
            
            // Delete confirmation handler
            $('#confirmDeleteBtn').click(function() {
                if (currentDeleteId) {
                    deleteServer(currentDeleteId);
                }
            });
        });

        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // Quick port selection
        function setPort(port) {
            $('#port').val(port);
        }

        // Load web servers list
        async function loadServers() {
            showLoading(true);
            try {
                const response = await fetch(API_BASE_URL + 'web_servers.php?action=getAll');
                const result = await response.json();
                
                if (result.success) {
                    updateStatistics(result.data);
                    renderServersList(result.data);
                } else {
                    showErrorModal('Error loading servers: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('Failed to load web servers. Please check console.');
            } finally {
                showLoading(false);
            }
        }

        function updateStatistics(servers) {
            const total = servers.length;
            const active = servers.filter(s => s.active === 'Y').length;
            const inactive = total - active;

            $('#totalServers').text(total);
            $('#activeServers').text(active);
            $('#inactiveServers').text(inactive);
        }

        function renderServersList(servers) {
            const container = $('#serversList');
            
            if (servers.length === 0) {
                container.html(`
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-server fa-3x mb-3 opacity-25"></i>
                        <p>No web servers found</p>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#serverModal">
                            <i class="fas fa-plus me-1"></i> Add Your First Web Server
                        </button>
                    </div>
                `);
                return;
            }

            let html = '';
            servers.forEach(server => {
                html += `
                    <div class="server-row p-3 rounded ${server.active === 'Y' ? '' : 'inactive'} bg-white border">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <strong>${server.server_description}</strong>
                                <div class="small text-muted">ID: ${server.server_id}</div>
                            </div>
                            <div class="col-md-2">
                                <code>${server.server_ip}</code>
                            </div>
                            <div class="col-md-2">
                                <span class="badge bg-primary">Port ${server.port}</span>
                            </div>
                            <div class="col-md-2">
                                <span class="badge ${server.active === 'Y' ? 'bg-success' : 'bg-warning'}">
                                    <i class="fas ${server.active === 'Y' ? 'fa-check' : 'fa-times'} me-1"></i>
                                    ${server.active === 'Y' ? 'Active' : 'Inactive'}
                                </span>
                            </div>
                            <div class="col-md-3 text-end">
                                <button class="btn btn-outline-primary btn-sm" onclick="editServer(${server.server_id})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-info btn-sm" onclick="viewServer(${server.server_id})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="showDeleteConfirm(${server.server_id})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.html(html);
        }

        function showServerModal() {
            $('#serverForm')[0].reset();
            $('#server_id').val('');
            $('#modalTitle').text('Add Web Server');
            $('#serverModal').modal('show');
        }

        async function saveServer() {
            const formData = new FormData(document.getElementById('serverForm'));
            const data = Object.fromEntries(formData);
            
            // Validation
            if (!data.server_description.trim()) {
                showValidationModal('Validation Error', 'Please enter server description');
                return;
            }
            if (!data.server_ip.trim()) {
                showValidationModal('Validation Error', 'Please enter IP address');
                return;
            }
            if (!data.port.trim()) {
                showValidationModal('Validation Error', 'Please enter port number');
                return;
            }

            showLoading(true);
            try {
                const action = data.server_id ? 'update' : 'create';
                const response = await fetch(API_BASE_URL + 'web_servers.php?action=' + action, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showSuccessModal(result.message);
                    loadServers();
                    $('#serverModal').modal('hide');
                } else {
                    showErrorModal(result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('Failed to save web server');
            } finally {
                showLoading(false);
            }
        }

        async function editServer(id) {
            showLoading(true);
            try {
                const response = await fetch(API_BASE_URL + 'web_servers.php?action=get&id=' + id);
                const result = await response.json();
                
                if (result.success) {
                    const server = result.data;
                    
                    // Populate form
                    $('#server_id').val(server.server_id);
                    $('#server_description').val(server.server_description);
                    $('#server_ip').val(server.server_ip);
                    $('#port').val(server.port);
                    $('#active').val(server.active);
                    
                    $('#modalTitle').text('Edit Web Server');
                    $('#serverModal').modal('show');
                } else {
                    showErrorModal(result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('Failed to load web server');
            } finally {
                showLoading(false);
            }
        }

        async function viewServer(id) {
            showLoading(true);
            try {
                const response = await fetch(API_BASE_URL + 'web_servers.php?action=get&id=' + id);
                const result = await response.json();
                
                if (result.success) {
                    const server = result.data;
                    const detailsHtml = `
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h6 class="text-primary">Web Server Information</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong class="d-block text-muted small">Server ID</strong>
                                <span>${server.server_id}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong class="d-block text-muted small">Status</strong>
                                <span class="badge ${server.active === 'Y' ? 'bg-success' : 'bg-warning'}">
                                    ${server.active === 'Y' ? 'Active' : 'Inactive'}
                                </span>
                            </div>
                            <div class="col-12 mb-3">
                                <strong class="d-block text-muted small">Description</strong>
                                <span>${server.server_description}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong class="d-block text-muted small">IP Address</strong>
                                <code>${server.server_ip}</code>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong class="d-block text-muted small">Port</strong>
                                <span class="badge bg-primary">${server.port}</span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="border-top pt-3">
                                    <strong class="d-block text-muted small mb-2">Connection Details</strong>
                                    <code class="small">http://${server.server_ip}:${server.port}</code>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('#viewModalBody').html(detailsHtml);
                    $('#viewModal').modal('show');
                } else {
                    showErrorModal(result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('Failed to load web server details');
            } finally {
                showLoading(false);
            }
        }

        function showDeleteConfirm(id) {
            currentDeleteId = id;
            $('#deleteModal').modal('show');
        }

        async function deleteServer(id) {
            showLoading(true);
            try {
                const response = await fetch(API_BASE_URL + 'web_servers.php?action=delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ server_id: id })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showSuccessModal(result.message);
                    loadServers();
                    $('#deleteModal').modal('hide');
                } else {
                    showErrorModal(result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('Failed to delete web server');
            } finally {
                showLoading(false);
                currentDeleteId = null;
            }
        }

        // Modal Functions
        function showValidationModal(title, message) {
            $('#validationTitle').text(title);
            $('#validationMessage').text(message);
            $('#validationModal').modal('show');
        }

        function showSuccessModal(message) {
            $('#successMessage').text(message);
            $('#successModal').modal('show');
        }

        function showErrorModal(message) {
            $('#errorMessage').text(message);
            $('#errorModal').modal('show');
        }

        // Reset form when modal closes
        $('#serverModal').on('hidden.bs.modal', function() {
            document.getElementById('serverForm').reset();
            $('#server_id').val('');
            $('#modalTitle').text('Add Web Server');
        });
    </script>
</body>
</html>