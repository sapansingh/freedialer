<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IVRS Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #c0392b;
            --info-color: #3498db;
            --light-bg: #f5f7fb;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.875rem;
            padding: 1rem;
        }
        
        .container-fluid {
            padding: 0;
        }
        
        /* Header */
        .page-header {
            background: white;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-left: 4px solid var(--primary-color);
        }
        
        .page-header h1 {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .page-header p {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0;
        }
        
        /* Statistics Cards */
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 1rem;
            text-align: center;
            border-left: 4px solid var(--primary-color);
            transition: transform 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0 auto 0.75rem;
            font-size: 1.2rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        /* Glass Card */
        .glass-card {
            background: white;
            border-radius: 10px;
            padding: 1.25rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        
        /* Search and Filters */
        .search-box .input-group-text {
            background: white;
            border-right: none;
        }
        
        .search-box .form-control {
            border-left: none;
        }
        
        .filter-section label {
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #495057;
        }
        
        /* Table */
        #ivrsTable th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem;
        }
        
        #ivrsTable td {
            font-size: 0.8rem;
            vertical-align: middle;
            padding: 0.75rem;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        /* Badges */
        .badge {
            font-size: 0.7rem;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        
        /* Action Buttons */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 6px;
        }
        
        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
        }
        
        /* Modal */
        .modal-header {
            padding: 1rem 1.25rem;
            background: var(--primary-color);
            color: white;
        }
        
        .modal-title {
            font-size: 1rem;
            font-weight: 600;
        }
        
        .modal-body {
            padding: 1.25rem;
        }
        
        .modal-footer {
            padding: 1rem 1.25rem;
        }
        
        /* Tabs */
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1.25rem;
        }
        
        .nav-tabs .nav-link {
            font-size: 0.8rem;
            padding: 0.6rem 1rem;
            border: none;
            color: #6c757d;
            font-weight: 500;
            border-radius: 0;
        }
        
        .nav-tabs .nav-link.active {
            background: none;
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }
        
        /* Form Elements */
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: #495057;
        }
        
        .form-control, .form-select {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            border: 1px solid #ced4da;
        }
        
        .form-text {
            font-size: 0.7rem;
        }
        
        .required-field::after {
            content: " *";
            color: var(--danger-color);
        }
        
        /* Form Sections */
        .form-section {
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none;
        }
        
        /* Toast Container */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }
        
        /* Confirmation Modal */
        .confirmation-modal .modal-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #f8d7da;
            color: var(--danger-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin: 0 auto 0.75rem;
        }
        
        /* Queue Transfer Items */
        .queue-transfer-item {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background-color: #f8f9fa;
        }
        
        .digit-input {
            max-width: 60px;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .btn-action {
                margin-bottom: 0.25rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status" style="width: 2rem; height: 2rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="container-fluid">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1"><i class="fas fa-phone-volume me-2 text-primary"></i>IVRS Management</h1>
                    <p class="text-muted mb-0">Manage Interactive Voice Response Systems</p>
                </div>
                <button class="btn btn-primary btn-sm" onclick="openAddModal()">
                    <i class="fas fa-plus me-1"></i> Add IVRS
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-3">
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                    <div class="stat-number text-primary" id="totalIvr">0</div>
                    <div class="stat-label">Total IVRS</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #27ae60, #229954);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number text-success" id="activeIvr">0</div>
                    <div class="stat-label">Active</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <div class="stat-number text-warning" id="inactiveIvr">0</div>
                    <div class="stat-label">Inactive</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #3498db, #2980b9);">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-number text-info" id="queueTransfers">0</div>
                    <div class="stat-label">Transfers</div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="search-box">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search IVRS...">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label">Status</label>
                        <select id="statusFilter" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label">Type</label>
                        <select id="typeFilter" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="main">Main Menu</option>
                            <option value="sub">Sub Menu</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary btn-sm w-100 mt-3" onclick="resetFilters()">
                        <i class="fas fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="glass-card">
            <div class="table-responsive">
                <table id="ivrsTable" class="table table-sm table-hover w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IVRS Name</th>
                            <th>Description</th>
                            <th>Voice File</th>
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

    <!-- IVR Modal Form -->
    <div class="modal fade" id="ivrModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-plus me-2"></i>Add New IVRS</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="ivrTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                <i class="fas fa-info-circle me-1"></i> Basic
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="queue-tab" data-bs-toggle="tab" data-bs-target="#queue" type="button" role="tab">
                                <i class="fas fa-exchange-alt me-1"></i> Transfers
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-3" id="ivrTabsContent">
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <form id="ivrForm">
                                <input type="hidden" id="sno" name="sno">
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-signature"></i> IVRS Info
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="ivr_name" class="form-label required-field">IVRS Name</label>
                                                        <input type="text" class="form-control form-control-sm" id="ivr_name" name="ivr_name" required placeholder="e.g., emri_ivr">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="ivr_description" class="form-label required-field">Description</label>
                                                        <input type="text" class="form-control form-control-sm" id="ivr_description" name="ivr_description" required placeholder="e.g., Emergency IVR System">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-sliders-h"></i> Configuration
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="voice_file" class="form-label required-field">Voice File</label>
                                                        <select class="form-select form-select-sm" id="voice_file" name="voice_file" required>
                                                            <option value="">Select Voice File</option>
                                                            <option value="welcome_message">Welcome Message</option>
                                                            <option value="main_menu">Main Menu</option>
                                                            <option value="thank_you">Thank You</option>
                                                            <option value="newivesystem">New IVE System</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="ivr_status" class="form-label required-field">Status</label>
                                                        <select class="form-select form-select-sm" id="ivr_status" name="ivr_status" required>
                                                            <option value="active">Active</option>
                                                            <option value="inactive">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="small">
                                            <div><strong>Name:</strong> <span id="previewName">-</span></div>
                                            <div><strong>Description:</strong> <span id="previewDescription">-</span></div>
                                            <div><strong>Voice File:</strong> <span id="previewVoiceFile">-</span></div>
                                            <div><strong>Status:</strong> <span id="previewStatus" class="badge bg-secondary">Inactive</span></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Queue Transfer Settings Tab -->
                        <div class="tab-pane fade" id="queue" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-exchange-alt"></i> Queue Transfers
                                </div>
                                <p class="text-muted mb-3 small">Configure digit-based queue transfers</p>
                                
                                <div id="queueTransfersContainer">
                                    <!-- Queue transfer items will be added here dynamically -->
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addQueueTransfer()">
                                        <i class="fas fa-plus me-1"></i> Add Transfer
                                    </button>
                                    <span class="text-muted small">Max 10 transfers</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="saveIvr()">
                        <i class="fas fa-save me-1"></i> Save IVRS
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade confirmation-modal" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <div class="modal-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h6 class="mb-2">Confirm Delete</h6>
                    <p class="text-muted mb-3 small" id="deleteConfirmText">Are you sure you want to delete this IVRS?</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Delete</button>
                    </div>
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
        let currentEditingId = null;
        let ivrsData = [];
        let ivrsTable;
        let queueTransferCount = 0;

        // Initialize DataTable
        $(document).ready(function() {
            ivrsTable = $('#ivrsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50],
                order: [[0, 'desc']],
                language: {
                    search: "",
                    searchPlaceholder: "Search IVRS...",
                    lengthMenu: "_MENU_"
                },
                initComplete: function() {
                    $('.dataTables_length select').addClass('form-select form-select-sm');
                    $('.dataTables_filter input').addClass('form-control form-control-sm');
                }
            });

            // Update preview when form fields change
            $('#ivr_name, #ivr_description, #voice_file, #ivr_status').on('input change', updatePreview);
            
            // Load initial data
            loadIvrs();
            
            // Add initial queue transfer
            addQueueTransfer();
        });

        // Load IVRS from API
        function loadIvrs() {
            showLoading(true);
            
            // Simulate API call
            setTimeout(() => {
                // Sample data
                ivrsData = [
                    {
                        sno: 1,
                        ivr_name: 'emri_ivr',
                        ivr_description: 'Emergency IVR System',
                        voice_file: 'newivesystem',
                        ivr_status: 'active',
                        queue_transfers: 4
                    },
                    {
                        sno: 2,
                        ivr_name: 'sales_ivr',
                        ivr_description: 'Sales Department IVR',
                        voice_file: 'welcome_message',
                        ivr_status: 'active',
                        queue_transfers: 3
                    },
                    {
                        sno: 3,
                        ivr_name: 'support_ivr',
                        ivr_description: 'Customer Support IVR',
                        voice_file: 'main_menu',
                        ivr_status: 'inactive',
                        queue_transfers: 5
                    }
                ];

                populateIvrsTable(ivrsData);
                updateStatistics(ivrsData);
                showLoading(false);
            }, 1000);
        }

        // Populate IVRS table
        function populateIvrsTable(ivrs) {
            const table = $('#ivrsTable').DataTable();
            table.clear();
            
            ivrs.forEach(ivr => {
                const statusBadge = ivr.ivr_status === 'active' ? 
                    '<span class="badge bg-success">Active</span>' : 
                    '<span class="badge bg-secondary">Inactive</span>';
                
                table.row.add([
                    ivr.sno,
                    `<div class="fw-bold">${ivr.ivr_name}</div>`,
                    ivr.ivr_description,
                    `<span class="badge bg-info">${ivr.voice_file}</span>`,
                    statusBadge,
                    `<div class="btn-group">
                        <button class="btn btn-outline-primary btn-action" onclick="editIvr(${ivr.sno})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-success btn-action" onclick="testIvr(${ivr.sno})" title="Test">
                            <i class="fas fa-play"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-action" onclick="confirmDelete(${ivr.sno}, '${ivr.ivr_name}')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`
                ]).draw(false);
            });
        }

        // Update statistics
        function updateStatistics(ivrs) {
            $('#totalIvr').text(ivrs.length);
            $('#activeIvr').text(ivrs.filter(i => i.ivr_status === 'active').length);
            $('#inactiveIvr').text(ivrs.filter(i => i.ivr_status === 'inactive').length);
            $('#queueTransfers').text(ivrs.reduce((sum, ivr) => sum + (ivr.queue_transfers || 0), 0));
        }

        // Open add modal
        function openAddModal() {
            currentEditingId = null;
            $('#modalTitle').html('<i class="fas fa-plus me-2"></i>Add New IVRS');
            $('#ivrForm')[0].reset();
            $('#sno').val('');
            updatePreview();
            $('#ivrModal').modal('show');
        }

        // Edit IVRS
        function editIvr(ivrId) {
            const ivr = ivrsData.find(i => i.sno === ivrId);
            if (!ivr) return;

            currentEditingId = ivrId;
            $('#modalTitle').html('<i class="fas fa-edit me-2"></i>Edit IVRS');
            
            // Fill form with IVRS data
            $('#sno').val(ivr.sno);
            $('#ivr_name').val(ivr.ivr_name);
            $('#ivr_description').val(ivr.ivr_description);
            $('#voice_file').val(ivr.voice_file);
            $('#ivr_status').val(ivr.ivr_status);

            updatePreview();
            $('#ivrModal').modal('show');
        }

        // Confirm delete
        function confirmDelete(ivrId, ivrName) {
            $('#deleteConfirmText').text(`Delete IVRS "${ivrName}"? This action cannot be undone.`);
            $('#confirmDeleteBtn').off('click').on('click', function() {
                deleteIvr(ivrId);
            });
            $('#deleteConfirmModal').modal('show');
        }

        // Delete IVRS
        function deleteIvr(ivrId) {
            $('#deleteConfirmModal').modal('hide');
            showLoading(true);

            // Simulate API call
            setTimeout(() => {
                ivrsData = ivrsData.filter(i => i.sno !== ivrId);
                populateIvrsTable(ivrsData);
                updateStatistics(ivrsData);
                showLoading(false);
                showToast('IVRS deleted successfully!', 'success');
            }, 1000);
        }

        // Save IVRS
        function saveIvr() {
            const formData = new FormData(document.getElementById('ivrForm'));
            const data = Object.fromEntries(formData.entries());

            // Validation
            if (!data.ivr_name.trim()) {
                alert('Please enter an IVRS name');
                return;
            }
            
            if (!data.ivr_description.trim()) {
                alert('Please enter a description');
                return;
            }
            
            if (!data.voice_file) {
                alert('Please select a voice file');
                return;
            }

            showLoading(true);

            // Simulate API call
            setTimeout(() => {
                if (currentEditingId) {
                    // Update existing IVRS
                    const index = ivrsData.findIndex(i => i.sno === currentEditingId);
                    if (index !== -1) {
                        ivrsData[index] = { ...ivrsData[index], ...data, sno: currentEditingId };
                    }
                    showToast('IVRS updated successfully!', 'success');
                } else {
                    // Add new IVRS
                    const newIvr = {
                        ...data,
                        sno: Math.max(...ivrsData.map(i => i.sno)) + 1,
                        queue_transfers: queueTransferCount
                    };
                    ivrsData.unshift(newIvr);
                    showToast('IVRS created successfully!', 'success');
                }

                populateIvrsTable(ivrsData);
                updateStatistics(ivrsData);
                showLoading(false);
                $('#ivrModal').modal('hide');
            }, 1500);
        }

        // Add queue transfer item
        function addQueueTransfer() {
            if (queueTransferCount >= 10) {
                showToast('Maximum 10 queue transfers allowed', 'warning');
                return;
            }
            
            queueTransferCount++;
            const transferId = `transfer_${queueTransferCount}`;
            
            const transferHtml = `
                <div class="queue-transfer-item" id="${transferId}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-2">
                            <label class="form-label small">Digit</label>
                            <input type="text" class="form-control form-control-sm digit-input" maxlength="1" placeholder="1" name="transfer_digit[]">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small">Description</label>
                            <input type="text" class="form-control form-control-sm" placeholder="e.g., Sales Department" name="transfer_description[]">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Target</label>
                            <input type="text" class="form-control form-control-sm" placeholder="e.g., sales_queue" name="transfer_value[]">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small">&nbsp;</label>
                            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeQueueTransfer('${transferId}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('queueTransfersContainer').insertAdjacentHTML('beforeend', transferHtml);
        }

        // Remove queue transfer item
        function removeQueueTransfer(id) {
            const element = document.getElementById(id);
            if (element) {
                element.remove();
                queueTransferCount--;
            }
        }

        // Update IVRS preview
        function updatePreview() {
            const name = $('#ivr_name').val() || 'IVRS Name';
            const description = $('#ivr_description').val() || 'Description';
            const voiceFile = $('#voice_file').val() || 'Not selected';
            const status = $('#ivr_status').val() === 'active' ? 'Active' : 'Inactive';
            const statusClass = $('#ivr_status').val() === 'active' ? 'bg-success' : 'bg-secondary';
            
            // Update preview text
            $('#previewName').text(name);
            $('#previewDescription').text(description);
            $('#previewVoiceFile').text(voiceFile);
            $('#previewStatus').text(status).removeClass('bg-success bg-secondary').addClass(statusClass);
        }

        // Test IVRS
        function testIvr(ivrId) {
            showLoading(true);
            // Simulate IVRS testing
            setTimeout(() => {
                showLoading(false);
                showToast('IVRS test completed successfully!', 'success');
            }, 2000);
        }

        // Function to reset filters
        function resetFilters() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#typeFilter').val('');
            
            // Reset DataTable search and filters
            const table = $('#ivrsTable').DataTable();
            table.search('').columns().search('').draw();
        }

        // Function to show toast messages
        function showToast(message, type = 'info') {
            const toastContainer = $('#toastContainer');
            const toastId = 'toast-' + Date.now();
            
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            toastContainer.append(toastHtml);
            const toastElement = $('#' + toastId);
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            
            // Remove toast from DOM after it's hidden
            toastElement.on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }
    </script>
</body>
</html>