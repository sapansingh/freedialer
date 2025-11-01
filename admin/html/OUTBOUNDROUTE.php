<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outbound Routes Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #16a085;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #c0392b;
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
            background: linear-gradient(135deg, #16a085, #1abc9c);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 32px rgba(22, 160, 133, 0.3);
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
            background: linear-gradient(135deg, #16a085, #1abc9c);
            color: white;
        }
        
        .stat-card.active {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }
        
        .stat-card.inactive {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }
        
        .stat-card.serial {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #16a085, #1abc9c);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(22, 160, 133, 0.4);
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
            background-color: rgba(22, 160, 133, 0.05);
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
            color: #16a085;
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
            border-color: #16a085;
            box-shadow: 0 0 0 0.2rem rgba(22, 160, 133, 0.25);
        }
        
        .filter-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .filter-select:focus {
            border-color: #16a085;
            box-shadow: 0 0 0 0.2rem rgba(22, 160, 133, 0.25);
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
            color: #16a085;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #16a085;
            border-color: #16a085;
        }
        
        .trunk-selection-area {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8f9fa;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .trunk-item {
            padding: 8px 12px;
            margin-bottom: 5px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .trunk-item:hover {
            background-color: #e3f2fd;
            border-color: #16a085;
        }
        
        .trunk-item.selected {
            background-color: #16a085;
            color: white;
            border-color: #16a085;
        }
        
        .method-badge {
            font-size: 0.7rem;
        }
        
        .trunks-preview {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
        }
        
        .trunk-tag {
            display: inline-block;
            background: #16a085;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            margin: 2px;
        }
        
        .form-label {
            font-weight: 500;
            color: #2c3e50;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 8px 12px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #16a085;
            box-shadow: 0 0 0 0.2rem rgba(22, 160, 133, 0.25);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
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
                    <h1 class="h3 mb-1"><i class="fas fa-route me-2"></i>Outbound Routes Management</h1>
                    <p class="mb-0 opacity-75">Manage outbound call routing and trunk configurations</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#routeModal">
                        <i class="fas fa-plus me-1"></i> Add New Route
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card total">
                    <h6 class="text-white-50 mb-1">Total Routes</h6>
                    <h3 class="text-white" id="totalRoutes">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card active">
                    <h6 class="text-white-50 mb-1">Active Routes</h6>
                    <h3 class="text-white" id="activeRoutes">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card inactive">
                    <h6 class="text-white-50 mb-1">Inactive Routes</h6>
                    <h3 class="text-white" id="inactiveRoutes">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card serial">
                    <h6 class="text-white-50 mb-1">Serial Method</h6>
                    <h3 class="text-white" id="serialRoutes">0</h3>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control search-box border-start-0" placeholder="Search routes...">
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
                    <select id="methodFilter" class="form-select filter-select">
                        <option value="">All Methods</option>
                        <option value="Serial">Serial</option>
                        <option value="Random">Random</option>
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
                <table id="routesTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Route ID</th>
                            <th>Route Name</th>
                            <th>Description</th>
                            <th>Trunks</th>
                            <th>Method</th>
                            <th>Add Digits</th>
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

    <!-- Route Modal Form -->
    <div class="modal fade" id="routeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-route me-2"></i>Create New Outbound Route</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="routeForm">
                        <input type="hidden" id="route_id" name="route_id">
                        
                        <div class="section-title">Basic Information</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="route_name" class="form-label required-field">Route Name</label>
                                    <input type="text" class="form-control" id="route_name" name="route_name" required placeholder="e.g., Cute_im">
                                    <div class="form-text">Unique name for this outbound route</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="route_description" class="form-label required-field">Description</label>
                                    <input type="text" class="form-control" id="route_description" name="route_description" required placeholder="e.g., Route for international calls">
                                    <div class="form-text">Brief description of this route</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="call_forward_route" class="form-label">Call Forward Route</label>
                                    <select class="form-select" id="call_forward_route" name="call_forward_route">
                                        <option value="">Select Call Forward Route</option>
                                        <option value="ConVox_CallForward_Route" selected>ConVox_CallForward_Route</option>
                                        <option value="Default_CallForward">Default CallForward</option>
                                        <option value="Emergency_Forward">Emergency Forward</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="schedule" class="form-label">Schedule?</label>
                                    <select class="form-select" id="schedule" name="schedule">
                                        <option value="No" selected>No</option>
                                        <option value="Yes">Yes</option>
                                        <option value="Business_Hours">Business Hours Only</option>
                                        <option value="After_Hours">After Hours Only</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="application" class="form-label">Application</label>
                                    <select class="form-select" id="application" name="application">
                                        <option value="">Select Application</option>
                                        <option value="Transfer_To_IVR" selected>Transfer To IVR</option>
                                        <option value="Hangup">Hangup</option>
                                        <option value="Voicemail">Voicemail</option>
                                        <option value="Queue">Queue</option>
                                        <option value="Extension">Extension</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="did_number" class="form-label">DID Number</label>
                                    <input type="text" class="form-control" id="did_number" name="did_number" placeholder="e.g., 14397100">
                                </div>
                            </div>
                        </div>

                        <div class="section-title">Routing Configuration</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="route_method" class="form-label required-field">Routing Method</label>
                                    <select class="form-select" id="route_method" name="route_method" required>
                                        <option value="Serial">Serial (Sequential)</option>
                                        <option value="Random">Random</option>
                                    </select>
                                    <div class="form-text">
                                        <strong>Serial:</strong> Try trunks in order<br>
                                        <strong>Random:</strong> Try trunks randomly
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="add_digits" class="form-label">Add Digits</label>
                                    <input type="text" class="form-control" id="add_digits" name="add_digits" placeholder="e.g., 9" maxlength="10">
                                    <div class="form-text">Digits to add to dialed number (optional)</div>
                                </div>
                            </div>
                        </div>

                        <div class="section-title">Trunk Selection</div>
                        <p class="text-muted mb-3">Select trunks for this outbound route. Drag to reorder for serial routing.</p>
                        
                        <div class="trunk-selection-area" id="trunkSelectionArea">
                            <!-- Trunks will be populated by JavaScript -->
                        </div>
                        
                        <div class="trunks-preview mt-3" id="trunksPreview">
                            <h6 class="mb-2">Selected Trunks:</h6>
                            <div id="selectedTrunksList">
                                <span class="text-muted">No trunks selected</span>
                            </div>
                        </div>
                        
                        <input type="hidden" id="selected_trunks" name="selected_trunks">

                        <div class="section-title">Status</div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="route_active" name="route_active" checked>
                                    <label for="route_active" class="form-label">Active</label>
                                </div>
                                <div class="form-text">Enable or disable this route</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" onclick="saveRoute()">
                        <i class="fas fa-save me-1"></i> Save Route
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Route Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Outbound Route Details</h5>
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
        const API_BASE_URL = '../api/outbound_routes/'; // Adjust this to your API endpoint
        
        // Available trunks data
        const availableTrunks = [
            { id: 'trunk1', name: 'airtel – VOIP', provider: 'Airtel VoIP' },
            { id: 'trunk2', name: 'jio – VOIP', provider: 'Jio VoIP' },
            { id: 'trunk3', name: 'PSTN Gateway 1', provider: 'Local Telecom' },
            { id: 'trunk4', name: 'PSTN Gateway 2', provider: 'Local Telecom' },
            { id: 'trunk5', name: 'International SIP', provider: 'Global VoIP' },
            { id: 'trunk6', name: 'Backup Trunk', provider: 'Emergency Provider' }
        ];

        // Initialize DataTable
        let routesTable;
        $(document).ready(function() {
            routesTable = $('#routesTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search routes...",
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
                    { data: 'route_id' },
                    { data: 'route_name' },
                    { data: 'route_description' },
                    { 
                        data: 'selected_trunks',
                        render: function(data, type, row) {
                            if (!data) return '<span class="text-muted">No trunks</span>';
                            const trunks = JSON.parse(data);
                            return trunks.slice(0, 2).map(trunk => 
                                `<span class="trunk-tag">${trunk.name}</span>`
                            ).join('') + (trunks.length > 2 ? ` <span class="text-muted">+${trunks.length - 2} more</span>` : '');
                        }
                    },
                    { 
                        data: 'route_method',
                        render: function(data, type, row) {
                            const badgeClass = data === 'Serial' ? 'bg-primary' : 'bg-info';
                            return `<span class="badge ${badgeClass} method-badge">${data}</span>`;
                        }
                    },
                    { 
                        data: 'add_digits',
                        render: function(data, type, row) {
                            return data ? `<code>${data}</code>` : '<span class="text-muted">None</span>';
                        }
                    },
                    { 
                        data: 'route_active',
                        render: function(data, type, row) {
                            return data === 'Y' 
                                ? '<span class="badge bg-success status-badge"><i class="fas fa-check-circle me-1"></i>Active</span>' 
                                : '<span class="badge bg-warning status-badge"><i class="fas fa-times-circle me-1"></i>Inactive</span>';
                        }
                    },
                    {
                        data: 'route_id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-outline-primary btn-action" onclick="editRoute(${data})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-info btn-action" onclick="viewRoute(${data})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-success btn-action" onclick="testRoute(${data})" title="Test">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-action" onclick="deleteRoute(${data})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                        },
                        orderable: false
                    }
                ]
            });

            // Load initial data
            loadRoutes();
            
            // Setup trunk selection
            setupTrunkSelection();
        });

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // Setup trunk selection functionality
        function setupTrunkSelection() {
            const trunkArea = document.getElementById('trunkSelectionArea');
            
            // Populate available trunks
            availableTrunks.forEach(trunk => {
                const trunkElement = document.createElement('div');
                trunkElement.className = 'trunk-item';
                trunkElement.dataset.trunkId = trunk.id;
                trunkElement.innerHTML = `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="trunk_${trunk.id}" value="${trunk.id}">
                        <label class="form-check-label" for="trunk_${trunk.id}">
                            <strong>${trunk.name}</strong><br>
                            <small class="text-muted">${trunk.provider}</small>
                        </label>
                    </div>
                `;
                trunkArea.appendChild(trunkElement);
                
                // Add click event
                trunkElement.addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox') {
                        const checkbox = this.querySelector('input[type="checkbox"]');
                        checkbox.checked = !checkbox.checked;
                        this.classList.toggle('selected', checkbox.checked);
                    } else {
                        this.classList.toggle('selected', e.target.checked);
                    }
                    updateSelectedTrunks();
                });
            });
        }

        // Update selected trunks display and hidden field
        function updateSelectedTrunks() {
            const selectedCheckboxes = document.querySelectorAll('#trunkSelectionArea input[type="checkbox"]:checked');
            const selectedTrunks = Array.from(selectedCheckboxes).map(checkbox => {
                const trunkId = checkbox.value;
                const trunk = availableTrunks.find(t => t.id === trunkId);
                return trunk;
            });
            
            const selectedTrunksList = document.getElementById('selectedTrunksList');
            const hiddenField = document.getElementById('selected_trunks');
            
            if (selectedTrunks.length === 0) {
                selectedTrunksList.innerHTML = '<span class="text-muted">No trunks selected</span>';
                hiddenField.value = '';
            } else {
                selectedTrunksList.innerHTML = selectedTrunks.map(trunk => 
                    `<span class="trunk-tag">${trunk.name}</span>`
                ).join('');
                hiddenField.value = JSON.stringify(selectedTrunks);
            }
        }

        // API Functions
        async function loadRoutes() {
            showLoading(true);
            try {
                // In a real implementation, this would fetch from your API
                // For demo purposes, we'll use mock data
                const mockData = {
                    success: true,
                    data: [
                        {
                            route_id: 1,
                            route_name: 'Cute_im',
                            route_description: 'Route for Cute IM service',
                            route_active: 'Y',
                            selected_trunks: JSON.stringify([availableTrunks[0]]),
                            route_method: 'Serial',
                            add_digits: '',
                            call_forward_route: 'ConVox_CallForward_Route',
                            schedule: 'No',
                            application: 'Transfer_To_IVR',
                            did_number: '14397100'
                        },
                        {
                            route_id: 2,
                            route_name: 'Local_Route',
                            route_description: 'Route for local calls',
                            route_active: 'Y',
                            selected_trunks: JSON.stringify([availableTrunks[2], availableTrunks[3]]),
                            route_method: 'Random',
                            add_digits: '',
                            call_forward_route: 'Default_CallForward',
                            schedule: 'No',
                            application: 'Extension',
                            did_number: ''
                        },
                        {
                            route_id: 3,
                            route_name: 'Emergency_Route',
                            route_description: 'Emergency backup route',
                            route_active: 'N',
                            selected_trunks: JSON.stringify([availableTrunks[5]]),
                            route_method: 'Serial',
                            add_digits: '9',
                            call_forward_route: 'Emergency_Forward',
                            schedule: 'Yes',
                            application: 'Queue',
                            did_number: ''
                        },
                        {
                            route_id: 4,
                            route_name: 'Premium_Route',
                            route_description: 'High quality international route',
                            route_active: 'Y',
                            selected_trunks: JSON.stringify([availableTrunks[0], availableTrunks[4], availableTrunks[1]]),
                            route_method: 'Serial',
                            add_digits: '001',
                            call_forward_route: 'ConVox_CallForward_Route',
                            schedule: 'Business_Hours',
                            application: 'Transfer_To_IVR',
                            did_number: '14397101'
                        }
                    ]
                };
                
                // Simulate API delay
                setTimeout(() => {
                    if (mockData.success) {
                        routesTable.clear().rows.add(mockData.data).draw();
                        updateStatistics(mockData.data);
                    } else {
                        showNotification('Failed to load routes', 'danger');
                    }
                    showLoading(false);
                }, 800);
                
            } catch (error) {
                console.error('Error loading routes:', error);
                showNotification('Error loading routes. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function getRoute(id) {
            showLoading(true);
            try {
                // In a real implementation, this would fetch from your API
                // For demo purposes, we'll use mock data
                const mockData = {
                    success: true,
                    data: {
                        route_id: id,
                        route_name: 'Cute_im',
                        route_description: 'Route for Cute IM service',
                        route_active: 'Y',
                        selected_trunks: JSON.stringify([availableTrunks[0]]),
                        route_method: 'Serial',
                        add_digits: '',
                        call_forward_route: 'ConVox_CallForward_Route',
                        schedule: 'No',
                        application: 'Transfer_To_IVR',
                        did_number: '14397100',
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
                            showNotification('Failed to load route', 'danger');
                            resolve(null);
                        }
                    }, 500);
                });
            } catch (error) {
                console.error('Error loading route:', error);
                showNotification('Error loading route. Please check console.', 'danger');
                showLoading(false);
                return null;
            }
        }

        async function saveRoute() {
            const formData = new FormData(document.getElementById('routeForm'));
            const data = Object.fromEntries(formData);
            
            // Convert checkbox to Y/N
            data.route_active = document.getElementById('route_active').checked ? 'Y' : 'N';
            
            // Validation
            if (!data.route_name.trim()) {
                showNotification('Please enter a route name', 'danger');
                return;
            }
            
            if (!data.route_description.trim()) {
                showNotification('Please enter a description', 'danger');
                return;
            }
            
            if (!data.selected_trunks) {
                showNotification('Please select at least one trunk', 'danger');
                return;
            }

            showLoading(true);
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate a successful response
                const mockResponse = {
                    success: true,
                    message: `Route ${data.route_id ? 'updated' : 'created'} successfully!`
                };
                
                // Simulate API delay
                setTimeout(() => {
                    showLoading(false);
                    if (mockResponse.success) {
                        showNotification(mockResponse.message, 'success');
                        loadRoutes();
                        
                        // Close modal
                        bootstrap.Modal.getInstance(document.getElementById('routeModal')).hide();
                        resetRouteForm();
                    } else {
                        showNotification('Failed to save route', 'danger');
                    }
                }, 800);
            } catch (error) {
                console.error('Error saving route:', error);
                showNotification('Error saving route. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function deleteRoute(id) {
            if (!confirm('Are you sure you want to delete this route?')) {
                return;
            }

            showLoading(true);
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate a successful response
                const mockResponse = {
                    success: true,
                    message: 'Route deleted successfully!'
                };
                
                // Simulate API delay
                setTimeout(() => {
                    showLoading(false);
                    if (mockResponse.success) {
                        showNotification(mockResponse.message, 'success');
                        loadRoutes();
                    } else {
                        showNotification('Failed to delete route', 'danger');
                    }
                }, 800);
            } catch (error) {
                console.error('Error deleting route:', error);
                showNotification('Error deleting route. Please check console.', 'danger');
                showLoading(false);
            }
        }

        // UI Functions
        async function editRoute(id) {
            const route = await getRoute(id);
            if (!route) return;

            // Populate form
            Object.keys(route).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    if (key === 'route_active') {
                        element.checked = route[key] === 'Y';
                    } else {
                        element.value = route[key];
                    }
                }
            });

            // Update trunk selection
            const selectedTrunks = JSON.parse(route.selected_trunks || '[]');
            document.querySelectorAll('#trunkSelectionArea input[type="checkbox"]').forEach(checkbox => {
                const trunkId = checkbox.value;
                const isSelected = selectedTrunks.some(trunk => trunk.id === trunkId);
                checkbox.checked = isSelected;
                
                const trunkItem = checkbox.closest('.trunk-item');
                if (trunkItem) {
                    trunkItem.classList.toggle('selected', isSelected);
                }
            });
            updateSelectedTrunks();

            // Update modal title
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Modify Route';

            // Show modal
            new bootstrap.Modal(document.getElementById('routeModal')).show();
        }

        async function viewRoute(id) {
            const route = await getRoute(id);
            if (!route) return;

            // Parse selected trunks
            const selectedTrunks = JSON.parse(route.selected_trunks || '[]');
            
            // Create trunks HTML
            const trunksHtml = selectedTrunks.length > 0 
                ? selectedTrunks.map((trunk, index) => `
                    <div class="mb-2">
                        <span class="badge bg-light text-dark me-2">${index + 1}</span>
                        <strong>${trunk.name}</strong> <small class="text-muted">(${trunk.provider})</small>
                    </div>
                `).join('')
                : '<span class="text-muted">No trunks configured</span>';

            // Create details HTML
            const detailsHtml = `
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6 class="text-muted">Route Information</h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Route ID:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${route.route_id}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Route Name:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${route.route_name}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Description:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${route.route_description}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Call Forward Route:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${route.call_forward_route || '<span class="text-muted">Not set</span>'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Schedule:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${route.schedule || '<span class="text-muted">Not set</span>'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Application:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${route.application || '<span class="text-muted">Not set</span>'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>DID Number:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${route.did_number || '<span class="text-muted">Not set</span>'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Routing Method:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        <span class="badge ${route.route_method === 'Serial' ? 'bg-primary' : 'bg-info'}">${route.route_method}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Add Digits:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${route.add_digits ? `<code>${route.add_digits}</code>` : '<span class="text-muted">None</span>'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${route.route_active === 'Y' 
                            ? '<span class="badge bg-success">Active</span>' 
                            : '<span class="badge bg-warning">Inactive</span>'}
                    </div>
                </div>
                
                <div class="section-title mt-3">Configured Trunks</div>
                <div class="trunks-preview">
                    ${trunksHtml}
                </div>
                
                <div class="mt-3 text-center">
                    <button class="btn btn-primary-custom me-2" onclick="testRoute(${route.route_id})">
                        <i class="fas fa-play me-1"></i> Test Route
                    </button>
                    <button class="btn btn-outline-primary" onclick="editRoute(${route.route_id})">
                        <i class="fas fa-edit me-1"></i> Edit Route
                    </button>
                </div>
            `;

            // Populate modal body
            document.getElementById('viewModalBody').innerHTML = detailsHtml;

            // Show modal
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }

        function testRoute(id) {
            // In a real implementation, this would test the route
            showNotification('Testing route... This would initiate a test call in production.', 'info');
        }

        function updateStatistics(routes) {
            const total = routes.length;
            const active = routes.filter(r => r.route_active === 'Y').length;
            const inactive = total - active;
            const serial = routes.filter(r => r.route_method === 'Serial').length;
            
            document.getElementById('totalRoutes').textContent = total;
            document.getElementById('activeRoutes').textContent = active;
            document.getElementById('inactiveRoutes').textContent = inactive;
            document.getElementById('serialRoutes').textContent = serial;
        }

        function resetRouteForm() {
            document.getElementById('routeForm').reset();
            document.querySelectorAll('#trunkSelectionArea input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.closest('.trunk-item').classList.remove('selected');
            });
            updateSelectedTrunks();
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Create New Outbound Route';
        }

        // Search functionality
        $('#searchInput').on('keyup', function() {
            routesTable.search(this.value).draw();
        });

        // Filter by status
        $('#statusFilter').on('change', function() {
            routesTable.column(6).search(this.value).draw();
        });

        // Filter by method
        $('#methodFilter').on('change', function() {
            routesTable.column(4).search(this.value).draw();
        });

        function resetFilters() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#methodFilter').val('');
            routesTable.search('').columns().search('').draw();
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
        document.getElementById('routeModal').addEventListener('hidden.bs.modal', function() {
            resetRouteForm();
        });
    </script>
</body>
</html>