<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disposition Management</title>
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
        
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: var(--card-shadow);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
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
                <i class="fas fa-tags"></i>
                <span>DISPOSITION MANAGEMENT</span>
            </div>
            
            <div class="header-actions">
                <div class="header-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDispositionModal">
                        <i class="fas fa-plus me-1"></i> Add Disposition
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
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalDispositions">0</h3>
                            <p>Total Dispositions</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4ade80, #22c55e);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="selectableDispositions">0</h3>
                            <p>Selectable Dispositions</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalProcesses">0</h3>
                            <p>Total Processes</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-6">
                        <label for="processFilter" class="form-label"><strong>Filter by Process</strong></label>
                        <select class="form-select" id="processFilter">
                            <option value="">All Processes</option>
                            <!-- Processes will be loaded dynamically -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="selectableFilter" class="form-label"><strong>Filter by Selectable Status</strong></label>
                        <select class="form-select" id="selectableFilter">
                            <option value="">All Status</option>
                            <option value="Y">Selectable</option>
                            <option value="N">Non-Selectable</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Dispositions Table -->
            <div class="table-container" style="position: relative;">
                <div class="loading-overlay" id="tableLoading" style="display: none;">
                    <div class="spinner"></div>
                </div>
                <div class="table-responsive">
                    <table id="dispositionsTable" class="table table-hover display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th> 
                                <th>Status Code</th>
                                <th>Status Name</th>
                                <th>Process</th>
                                <th>Selectable</th>
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
                ConVox CCS v2.0 | Disposition Management
            </div>
            <div>
                <span id="lastUpdated">Last updated: Just now</span>
            </div>
        </div>
    </div>

    <!-- Add/Edit Disposition Modal -->
    <div class="modal fade" id="addDispositionModal" tabindex="-1" aria-labelledby="addDispositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDispositionModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Add New Disposition
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dispositionForm">
                        <input type="hidden" id="sno" name="sno">
                        
                        <div class="mb-3">
                            <label for="status" class="form-label required">Status Code *</label>
                            <input type="text" class="form-control" id="status" name="status" required maxlength="20">
                            <div class="form-text">Unique code for the disposition (max 20 characters)</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status_name" class="form-label required">Status Name *</label>
                            <input type="text" class="form-control" id="status_name" name="status_name" required maxlength="30">
                            <div class="form-text">Display name for the disposition (max 30 characters)</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="process" class="form-label required">Process *</label>
                            <select class="form-select" id="process" name="process" required>
                                <option value="">Select Process</option>
                                <!-- Processes will be loaded dynamically -->
                            </select>
                            <div class="form-text">Select the process this disposition belongs to</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="selectable" class="form-label required">Selectable *</label>
                            <select class="form-select" id="selectable" name="selectable" required>
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                            <div class="form-text">Whether this disposition can be selected by agents</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveDispositionBtn">
                        <i class="fas fa-save me-1"></i> Save Disposition
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
                    <h5 class="mb-3">Delete Disposition</h5>
                    <p>Are you sure you want to delete the disposition <strong id="dispositionToDeleteName">[Disposition Name]</strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i> Delete Disposition
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
    const API_BASE_URL = '.././api/disposition_api.php';
    const PROCESS_API_URL = '.././api/indiapi/process_api_dropdown.php';
    
    let dispositionsTable;
    let dispositionToDelete = null;

    // Initialize the application when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing Disposition Management...');
        initializeDataTable();
        loadProcesses();
        updateLastUpdatedTime();
        
        // Set up event listeners
        document.getElementById('refreshBtn').addEventListener('click', refreshData);
        document.getElementById('saveDispositionBtn').addEventListener('click', saveDisposition);
        document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
        document.getElementById('processFilter').addEventListener('change', applyFilters);
        document.getElementById('selectableFilter').addEventListener('change', applyFilters);
        
        // Reset form when modal is hidden
        document.getElementById('addDispositionModal').addEventListener('hidden.bs.modal', resetForm);
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

    // Load processes for both filter and modal dropdowns
    async function loadProcesses() {
        try {
            console.log('Loading processes from:', PROCESS_API_URL);
            showTableLoading(true);
            
            const result = await fetch(PROCESS_API_URL);
            
            if (!result.ok) {
                throw new Error(`HTTP error! status: ${result.status}`);
            }
            
            const data = await result.json();
            console.log('Processes API Response:', data);
            
            if (data.success && data.data) {
                populateProcessDropdowns(data.data);
                showNotification('success', 'Processes Loaded', `Loaded ${data.data.length} processes`);
            } else {
                throw new Error(data.message || 'Failed to load processes');
            }
        } catch (error) {
            console.error('Error loading processes:', error);
            showNotification('error', 'Error', 'Failed to load processes: ' + error.message);
            // Set default options on error
            populateProcessDropdowns([]);
        } finally {
            showTableLoading(false);
        }
    }

    // Populate both filter and modal dropdowns with processes
    function populateProcessDropdowns(processes) {
        const processFilter = document.getElementById('processFilter');
        const processModal = document.getElementById('process');
        
        // Clear existing options
        processFilter.innerHTML = '<option value="">All Processes</option>';
        processModal.innerHTML = '<option value="">Select Process</option>';
        
        // Add process options
        if (processes && processes.length > 0) {
            processes.forEach(process => {
                // For filter dropdown
                const filterOption = document.createElement('option');
                filterOption.value = process;
                filterOption.textContent = process;
                processFilter.appendChild(filterOption);
                
                // For modal dropdown
                const modalOption = document.createElement('option');
                modalOption.value = process;
                modalOption.textContent = process;
                processModal.appendChild(modalOption);
            });
            
            console.log(`Populated ${processes.length} processes in dropdowns`);
        } else {
            console.log('No processes found to populate');
            // Add a default option if no processes
            const noProcessOption = document.createElement('option');
            noProcessOption.value = '';
            noProcessOption.textContent = 'No processes available';
            noProcessOption.disabled = true;
            processModal.appendChild(noProcessOption);
        }
    }

    // Initialize DataTable
    function initializeDataTable() {
        console.log('Initializing DataTable...');
        
        dispositionsTable = $('#dispositionsTable').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            responsive: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            order: [[0, 'desc']],
            columns: [
                { data: 'sno' },
                { 
                    data: 'status',
                    render: function(data) {
                        return `<span class="badge bg-primary">${data || 'N/A'}</span>`;
                    }
                },
                { 
                    data: 'status_name',
                    render: function(data) {
                        return `<strong>${data || 'N/A'}</strong>`;
                    }
                },
                { 
                    data: 'process',
                    render: function(data) {
                        return data ? `<span class="badge bg-info">${data}</span>` : 'N/A';
                    }
                },
                { 
                    data: 'selectable',
                    render: function(data) {
                        const isSelectable = data === 'Y';
                        return `<span class="status-badge ${isSelectable ? 'bg-success' : 'bg-secondary'}">
                            <i class="fas ${isSelectable ? 'fa-check' : 'fa-times'}"></i> ${isSelectable ? 'Selectable' : 'Non-Selectable'}
                        </span>`;
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return `<div class="action-buttons">
                            <button onclick="editDisposition(${row.sno})" title="Edit Disposition" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button onclick="deleteDisposition(${row.sno}, '${(row.status_name || '').replace(/'/g, "\\'")}')" title="Delete Disposition" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>`;
                    },
                    orderable: false
                }
            ],
            data: [],
            language: {
                emptyTable: "No dispositions found",
                info: "Showing _START_ to _END_ of _TOTAL_ dispositions",
                search: "Search dispositions...",
                zeroRecords: "No matching dispositions found"
            },
            initComplete: function() {
                console.log('DataTable initialization complete');
                loadDispositionsData();
            }
        });
    }

    // Load dispositions data
    async function loadDispositionsData() {
        try {
            console.log('Loading dispositions data...');
            showTableLoading(true);
            
            const result = await apiCall(API_BASE_URL);
            
            if (result.success) {
                dispositionsTable.clear().rows.add(result.data).draw();
                updateStats(result.data);
                console.log(`Loaded ${result.data.length} dispositions`);
                showNotification('success', 'Data Loaded', `Loaded ${result.data.length} dispositions`);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error loading dispositions:', error);
            showNotification('error', 'Error', 'Failed to load dispositions data: ' + error.message);
        } finally {
            showTableLoading(false);
        }
    }

    // Update statistics
    function updateStats(data) {
        const totalDispositions = data.length;
        const selectableDispositions = data.filter(d => d.selectable === 'Y').length;
        const uniqueProcesses = [...new Set(data.map(d => d.process).filter(Boolean))].length;
        
        document.getElementById('totalDispositions').textContent = totalDispositions;
        document.getElementById('selectableDispositions').textContent = selectableDispositions;
        document.getElementById('totalProcesses').textContent = uniqueProcesses;
        
        console.log(`Stats updated: ${totalDispositions} dispositions, ${selectableDispositions} selectable, ${uniqueProcesses} processes`);
    }

    // Apply filters
    function applyFilters() {
        const processFilter = document.getElementById('processFilter').value;
        const selectableFilter = document.getElementById('selectableFilter').value;
        
        dispositionsTable.column(3).search(processFilter);
        dispositionsTable.column(4).search(selectableFilter);
        dispositionsTable.draw();
        
        console.log(`Filters applied - Process: ${processFilter}, Selectable: ${selectableFilter}`);
    }

    // Edit disposition
    async function editDisposition(id) {
        try {
            console.log(`Editing disposition ID: ${id}`);
            showTableLoading(true);
            
            const result = await apiCall(API_BASE_URL + '?id=' + id);
            
            if (result.success) {
                const disposition = result.data;
                
                // Populate form
                document.getElementById('sno').value = disposition.sno;
                document.getElementById('status').value = disposition.status;
                document.getElementById('status_name').value = disposition.status_name;
                document.getElementById('process').value = disposition.process;
                document.getElementById('selectable').value = disposition.selectable;
                
                // Update modal title
                document.getElementById('addDispositionModalLabel').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Disposition';
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('addDispositionModal'));
                modal.show();
                
                console.log('Disposition form populated for editing');
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error loading disposition:', error);
            showNotification('error', 'Error', 'Failed to load disposition data: ' + error.message);
        } finally {
            showTableLoading(false);
        }
    }

    // Delete disposition
    function deleteDisposition(id, name) {
        dispositionToDelete = id;
        document.getElementById('dispositionToDeleteName').textContent = name;
        new bootstrap.Modal(document.getElementById('deleteConfirmationModal')).show();
        console.log(`Delete confirmation requested for disposition: ${name}`);
    }

    // Confirm delete
    async function confirmDelete() {
        if (!dispositionToDelete) return;
        
        try {
            console.log(`Deleting disposition ID: ${dispositionToDelete}`);
            showTableLoading(true);
            
            const result = await apiCall(API_BASE_URL, 'DELETE', { id: dispositionToDelete });
            
            if (result.success) {
                showNotification('success', 'Disposition Deleted', 'Disposition deleted successfully!');
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                await refreshData();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error deleting disposition:', error);
            showNotification('error', 'Error', 'Failed to delete disposition: ' + error.message);
        } finally {
            showTableLoading(false);
            dispositionToDelete = null;
        }
    }

    // Save disposition
    async function saveDisposition() {
        const formData = {
            status: document.getElementById('status').value.trim(),
            status_name: document.getElementById('status_name').value.trim(),
            process: document.getElementById('process').value,
            selectable: document.getElementById('selectable').value
        };

        console.log('Saving disposition:', formData);

        // Validation
        if (!formData.status) {
            showNotification('error', 'Validation Error', 'Status Code is required');
            document.getElementById('status').focus();
            return;
        }

        if (!formData.status_name) {
            showNotification('error', 'Validation Error', 'Status Name is required');
            document.getElementById('status_name').focus();
            return;
        }

        if (!formData.process) {
            showNotification('error', 'Validation Error', 'Please select a process');
            document.getElementById('process').focus();
            return;
        }

        const sno = document.getElementById('sno').value;
        if (sno) {
            formData.sno = parseInt(sno);
        }

        try {
            showTableLoading(true);
            const result = await apiCall(API_BASE_URL, 'POST', formData);
            
            if (result.success) {
                const action = sno ? 'updated' : 'created';
                showNotification('success', 'Disposition Saved', `Disposition ${action} successfully!`);
                bootstrap.Modal.getInstance(document.getElementById('addDispositionModal')).hide();
                resetForm();
                await refreshData();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error saving disposition:', error);
            showNotification('error', 'Error', 'Failed to save disposition: ' + error.message);
        } finally {
            showTableLoading(false);
        }
    }

    // Reset form
    function resetForm() {
        document.getElementById('dispositionForm').reset();
        document.getElementById('sno').value = '';
        document.getElementById('addDispositionModalLabel').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Add New Disposition';
        console.log('Disposition form reset');
    }

    // Refresh data
    async function refreshData() {
        console.log('Refreshing all data...');
        showTableLoading(true);
        
        try {
            await Promise.all([
                loadDispositionsData(),
                loadProcesses()
            ]);
            updateLastUpdatedTime();
            showNotification('info', 'Refreshed', 'Data refreshed successfully');
        } catch (error) {
            console.error('Error refreshing data:', error);
            showNotification('error', 'Error', 'Failed to refresh data: ' + error.message);
        } finally {
            showTableLoading(false);
        }
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
        
        console.log(`Notification: ${type} - ${title} - ${message}`);
    }
</script>
</body>
</html>