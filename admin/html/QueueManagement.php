<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --info-color: #4895ef;
            --warning-color: #f72585;
            --danger-color: #e63946;
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: #f5f7fb;
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
        #queuesTable th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem;
        }
        
        #queuesTable td {
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
            border-bottom: none;
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
            border-top: 1px solid #dee2e6;
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
        
        /* Health Indicator */
        .health-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .health-good { background: var(--success-color); }
        .health-warning { background: var(--warning-color); }
        .health-critical { background: var(--danger-color); }
        
        /* Validation Error */
        .validation-error {
            color: var(--danger-color);
            font-size: 0.7rem;
            margin-top: 0.25rem;
            display: none;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .form-group-enhanced {
            margin-bottom: 1rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .checkbox-group label {
            margin-bottom: 0;
            font-weight: normal;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .btn-action {
                margin-bottom: 0.25rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
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
                    <h1 class="h3 mb-1"><i class="fas fa-list-alt me-2 text-primary"></i>Queue Management</h1>
                    <p class="text-muted mb-0">Configure and manage call center queues</p>
                </div>
                <button class="btn btn-primary btn-sm" onclick="openAddModal()">
                    <i class="fas fa-plus me-1"></i> Add Queue
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-3">
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <div class="stat-number text-primary" id="totalQueues">0</div>
                    <div class="stat-label">Total Queues</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-number text-info" id="executiveQueues">0</div>
                    <div class="stat-label">Executive</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-number text-warning" id="verifierQueues">0</div>
                    <div class="stat-label">Verifier</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number text-secondary" id="activeQueues">0</div>
                    <div class="stat-label">Active</div>
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
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search queues...">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label">Type</label>
                        <select id="typeFilter" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="executive">Executive</option>
                            <option value="verifier">Verifier</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label">Status</label>
                        <select id="statusFilter" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="Y">Active</option>
                            <option value="N">Inactive</option>
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
                <table id="queuesTable" class="table table-sm table-hover w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Queue Name</th>
                            <th>Type</th>
                            <th>DID</th>
                            <th>Process</th>
                            <th>Queue Length</th>
                            <th>Drop Time</th>
                            <th>Status</th>
                            <th>Health</th>
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

    <!-- Add/Edit Queue Modal -->
    <div class="modal fade" id="queueModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="queueModalTitle">
                        <i class="fas fa-plus-circle me-2"></i>Add New Queue
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="queueForm">
                        <div class="form-grid">
                            <div class="form-group-enhanced">
                                <label for="queue_name" class="form-label required-field">Queue Name</label>
                                <input type="text" class="form-control" id="queue_name" name="queue_name" required maxlength="30" placeholder="Enter queue name">
                                <div class="validation-error" id="queueNameError">Queue name is required</div>
                            </div>
                            
                            <div class="form-group-enhanced">
                                <label for="queue_type" class="form-label">Queue Type</label>
                                <select class="form-select" id="queue_type" name="queue_type">
                                    <option value="executive">Executive</option>
                                    <option value="verifier">Verifier</option>
                                </select>
                            </div>
                            
                            <div class="form-group-enhanced">
                                <label for="queue_did" class="form-label">DID</label>
                                <input type="text" class="form-control" id="queue_did" name="queue_did" maxlength="20" placeholder="Enter DID">
                            </div>
                            
                            <div class="form-group-enhanced">
                                <label for="greeting_file_id" class="form-label required-field">Greeting File</label>
                                <select class="form-select" id="greeting_file_id" name="greeting_file_id" required>
                                    <option value="">Select Greeting File</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            
                            <div class="form-group-enhanced">
                                <label for="call_queue_file_id" class="form-label required-field">Waiting Message</label>
                                <select class="form-select" id="call_queue_file_id" name="call_queue_file_id" required>
                                    <option value="">Select Waiting Message</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            
                            <div class="form-group-enhanced">
                                <label for="queue_drop_time" class="form-label required-field">Queue Drop Time (sec)</label>
                                <input type="number" class="form-control" id="queue_drop_time" name="queue_drop_time" required min="0" max="999" value="0">
                            </div>
                            
                            <div class="form-group-enhanced">
                                <label for="queue_drop_action" class="form-label">Queue Drop Action</label>
                                <select class="form-select" id="queue_drop_action" name="queue_drop_action" onchange="toggleDropValue()">
                                    <option value="play">Play Voicefile</option>
                                    <option value="voicemail">Transfer To Voice Mail</option>
                                    <option value="callforward">Call Forward</option>
                                    <option value="extension">Transfer To Extension</option>
                                    <option value="ip">DirectIP Dial</option>
                                    <option value="queue">Transfer To Queue</option>
                                    <option value="IVR">IVR</option>
                                </select>
                            </div>
                            
                            <div class="form-group-enhanced">
                                <label for="queue_drop_value" class="form-label required-field">Queue Drop Value</label>
                                <div id="dropValueContainer">
                                    <select class="form-select" id="queue_drop_value" name="queue_drop_value" required>
                                        <option value="">Select Drop Value</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group-enhanced">
                                <label for="queue_length" class="form-label required-field">Queue Length</label>
                                <input type="number" class="form-control" id="queue_length" name="queue_length" required min="0" max="999" value="1">
                                <small class="form-text text-muted">0 = unlimited calls</small>
                            </div>
                            
                            <div class="form-group-enhanced">
                                <label for="queue_assigned_process" class="form-label required-field">Process</label>
                                <select class="form-select" id="queue_assigned_process" name="queue_assigned_process" required>
                                    <option value="">Select Process</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="play_queue_no" name="play_queue_no" value="Y">
                                    <label for="play_queue_no">Play Queue No</label>
                                </div>
                                <select class="form-select mt-2" id="queue_no_file" name="queue_no_file" disabled>
                                    <option value="">Select Queue No File</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="play_hold_durn" name="play_hold_durn" value="Y">
                                    <label for="play_hold_durn">Play Hold Duration</label>
                                </div>
                                <select class="form-select mt-2" id="hold_durn_file" name="hold_durn_file" disabled>
                                    <option value="">Select Hold Duration File</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group-enhanced">
                                    <label for="playback_freq" class="form-label">PlayBack Frequency (sec)</label>
                                    <input type="number" class="form-control" id="playback_freq" name="playback_freq" min="0" max="99" value="0">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-enhanced">
                                    <label for="queue_over_flow" class="form-label">Queue Overflow</label>
                                    <select class="form-select" id="queue_over_flow" name="queue_over_flow">
                                        <option value="">Select Overflow Queue</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-3">
                            <small>
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> 
                                1. If Queue Length is zero, then queue can take unlimited calls. Greeting File, Play Queue No, Play Hold Duration, PlayBack Frequency will not be affected in Predictive Mode.<br>
                                2. In Queue Drop Action Call Forward, Transfer To Extension, Direct IP Dial and Transfer To Queue will not be affected in Predictive Mode.
                            </small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" id="saveQueueBtn" onclick="saveQueue()">
                        <i class="fas fa-save me-1"></i> Save Queue
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
                    <p class="text-muted mb-3 small" id="deleteConfirmText">Are you sure you want to delete this queue?</p>
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
        // API Configuration
        const API_BASE_URL = '../api/queue_api.php'; // Update this path as needed
        
        let currentEditingId = null;
        let queuesData = [];
        let queuesTable;
        let voiceFiles = []; // This would be populated from your voice files API

        // Initialize DataTable
        $(document).ready(function() {
            queuesTable = $('#queuesTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50],
                order: [[0, 'desc']],
                language: {
                    search: "",
                    searchPlaceholder: "Search queues...",
                    lengthMenu: "_MENU_"
                },
                initComplete: function() {
                    $('.dataTables_length select').addClass('form-select form-select-sm');
                    $('.dataTables_filter input').addClass('form-control form-control-sm');
                }
            });

            // Load initial data
            loadQueues();
            loadStatistics();
            loadDropdownData();

            // Event listeners for checkboxes
            $('#play_queue_no').change(function() {
                $('#queue_no_file').prop('disabled', !this.checked);
            });

            $('#play_hold_durn').change(function() {
                $('#hold_durn_file').prop('disabled', !this.checked);
            });
        });

        // API Call Helper Function
        async function apiCall(url, options = {}) {
            try {
                showLoading(true);
                const response = await fetch(url, {
                    headers: {
                        'Content-Type': 'application/json',
                        ...options.headers
                    },
                    ...options
                });
                
                const data = await response.json();
                showLoading(false);
                
                if (!data.success) {
                    throw new Error(data.message || 'API request failed');
                }
                
                return data;
            } catch (error) {
                showLoading(false);
                showToast('Error: ' + error.message, 'error');
                throw error;
            }
        }

        // Load dropdown data (voice files, processes, etc.)
     // Update the loadDropdownData function in your Queue Management page
async function loadDropdownData() {
    try {
        // Load voice files from API
        const voiceFilesResponse = await apiCall('../api/indiapi/voice_files_api.php?action=getAll');
        const voiceFilesData = voiceFilesResponse.data;

        // Load processes (you might have a separate API for this)

      const processesDataResponse = await apiCall('../api/indiapi/processes.php');
const processesData = processesDataResponse.data || [];

        // Populate voice file dropdowns
        populateVoiceFileDropdown('#greeting_file_id', voiceFilesData);
        populateVoiceFileDropdown('#call_queue_file_id', voiceFilesData);
        populateVoiceFileDropdown('#queue_drop_value', voiceFilesData);
        populateVoiceFileDropdown('#queue_no_file', voiceFilesData);
        populateVoiceFileDropdown('#hold_durn_file', voiceFilesData);

        // Populate process dropdown
        populateProcessDropdown('#queue_assigned_process', processesData);

        // Populate queue overflow dropdown
        const queuesData = await apiCall(`${API_BASE_URL}?action=getAll`);
        populateQueueDropdown('#queue_over_flow', queuesData.data);

    } catch (error) {
        console.error('Error loading dropdown data:', error);
    }
}

// Update the populateVoiceFileDropdown function
function populateVoiceFileDropdown(selector, files) {
    const dropdown = $(selector);
    dropdown.empty();
    dropdown.append('<option value="">Select File</option>');
    files.forEach(file => {
        dropdown.append(`<option value="${file.id}">${file.name}</option>`);
    });
}

        function populateVoiceFileDropdown(selector, files) {
            const dropdown = $(selector);
            dropdown.empty();
            dropdown.append('<option value="">Select File</option>');
            files.forEach(file => {
                dropdown.append(`<option value="${file.id}">${file.name}</option>`);
            });
        }
function populateProcessDropdown(selector, processes) {
    const dropdown = $(selector);
    dropdown.empty();
    dropdown.append('<option value="">Select Process</option>');
    processes.forEach(process => {
        // If process is an object with name property
        if (typeof process === 'object' && process.name) {
            dropdown.append(`<option value="${process.name}">${process.name}</option>`);
        } 
        // If process is just a string
        else if (typeof process === 'string') {
            dropdown.append(`<option value="${process}">${process}</option>`); 
        }
    });
}

        function populateQueueDropdown(selector, queues) {
            const dropdown = $(selector);
            dropdown.empty();
            dropdown.append('<option value="">Select Queue</option>');
            queues.forEach(queue => {
                dropdown.append(`<option value="${queue.queue_id}">${queue.queue_name}</option>`);
            });
        }

        // Toggle drop value based on drop action
        function toggleDropValue() {
            const action = $('#queue_drop_action').val();
            const container = $('#dropValueContainer');
            
            if (['play', 'voicemail'].includes(action)) {
                container.html(`
                    <select class="form-select" id="queue_drop_value" name="queue_drop_value" required>
                        <option value="">Select Voice File</option>
                    </select>
                `);
                populateVoiceFileDropdown('#queue_drop_value', voiceFiles);
            } else if (action === 'queue') {
                container.html(`
                    <select class="form-select" id="queue_drop_value" name="queue_drop_value" required>
                        <option value="">Select Queue</option>
                    </select>
                `);
                populateQueueDropdown('#queue_drop_value', queuesData);
            } else {
                container.html(`
                    <input type="text" class="form-control" id="queue_drop_value" name="queue_drop_value" required placeholder="Enter value">
                `);
            }
        }

        // Load queues from API
        async function loadQueues() {
            try {
                const data = await apiCall(`${API_BASE_URL}?action=getAll`);
                queuesData = data.data;
                populateQueuesTable(queuesData);
            } catch (error) {
                console.error('Error loading queues:', error);
            }
        }

        // Load statistics
        async function loadStatistics() {
            try {
                const data = await apiCall(`${API_BASE_URL}?action=getStats`);
                updateStatistics(data.data);
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        }

        // Populate queues table
        function populateQueuesTable(queues) {
            const table = $('#queuesTable').DataTable();
            table.clear();
            
            queues.forEach(queue => {
                const statusBadge = queue.queue_selected === 'Y' ? 
                    '<span class="badge bg-success">Active</span>' : 
                    '<span class="badge bg-secondary">Inactive</span>';
                
                const typeBadge = queue.queue_type === 'executive' ? 'bg-primary' : 'bg-warning';
                const typeText = queue.queue_type === 'executive' ? 'Executive' : 'Verifier';
                
                // Health calculation
                let health = 'good';
                let healthText = 'Good';
                
                if (queue.queue_length === 0 && queue.queue_selected === 'Y') {
                    health = 'warning';
                    healthText = 'Unlimited';
                } else if (!queue.queue_assigned_process && queue.queue_selected === 'Y') {
                    health = 'critical';
                    healthText = 'No Process';
                } else if (queue.queue_selected === 'N') {
                    health = 'warning';
                    healthText = 'Inactive';
                }
                
                table.row.add([
                    queue.queue_id,
                    `<div class="fw-bold">${queue.queue_name}</div>`,
                    `<span class="badge ${typeBadge}">${typeText}</span>`,
                    queue.queue_did || 'N/A',
                    queue.queue_assigned_process || 'N/A',
                    queue.queue_length === 0 ? 'Unlimited' : queue.queue_length,
                    `${queue.queue_drop_time}s`,
                    statusBadge,
                    `<span class="health-indicator health-${health}"></span>${healthText}`,
                    `<div class="btn-group">
                        <button class="btn btn-outline-primary btn-action" onclick="openEditModal(${queue.queue_id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-action" onclick="confirmDelete(${queue.queue_id}, '${queue.queue_name}')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`
                ]).draw(false);
            });
        }

        // Update statistics
        function updateStatistics(stats) {
            $('#totalQueues').text(stats.totalQueues || 0);
            $('#executiveQueues').text(stats.executiveQueues || 0);
            $('#verifierQueues').text(stats.verifierQueues || 0);
            $('#activeQueues').text(stats.activeQueues || 0);
        }

        // Open add modal
        function openAddModal() {
            currentEditingId = null;
            $('#queueForm')[0].reset();
            $('#queueModalTitle').html('<i class="fas fa-plus-circle me-2"></i>Add New Queue');
            $('#saveQueueBtn').html('<i class="fas fa-save me-1"></i> Save Queue');
            $('#queueModal').modal('show');
        }

        // Open edit modal
        async function openEditModal(queueId) {
            try {
                const data = await apiCall(`${API_BASE_URL}?action=get&id=${queueId}`);
                const queue = data.data;
                
                if (!queue) {
                    showToast('Queue not found', 'error');
                    return;
                }

                currentEditingId = queueId;

                // Fill the form with queue data
                $('#queue_name').val(queue.queue_name);
                $('#queue_type').val(queue.queue_type);
                $('#queue_did').val(queue.queue_did);
                $('#greeting_file_id').val(queue.greeting_file_id);
                $('#call_queue_file_id').val(queue.call_queue_file_id);
                $('#queue_drop_time').val(queue.queue_drop_time);
                $('#queue_drop_action').val(queue.queue_drop_action);
                $('#queue_drop_value').val(queue.queue_drop_value);
                $('#queue_length').val(queue.queue_length);
                $('#queue_assigned_process').val(queue.queue_assigned_process);
                $('#play_queue_no').prop('checked', queue.play_queue_no === 'Y');
                $('#queue_no_file').val(queue.queue_no_file).prop('disabled', queue.play_queue_no !== 'Y');
                $('#play_hold_durn').prop('checked', queue.play_hold_durn === 'Y');
                $('#hold_durn_file').val(queue.hold_durn_file).prop('disabled', queue.play_hold_durn !== 'Y');
                $('#playback_freq').val(queue.playback_freq);
                $('#queue_over_flow').val(queue.queue_over_flow);

                $('#queueModalTitle').html('<i class="fas fa-edit me-2"></i>Edit Queue');
                $('#saveQueueBtn').html('<i class="fas fa-save me-1"></i> Update Queue');
                $('#queueModal').modal('show');

            } catch (error) {
                console.error('Error loading queue details:', error);
            }
        }

        // Save queue
        async function saveQueue() {
            const form = $('#queueForm')[0];
            
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            try {
                const queueData = {
                    queue_name: $('#queue_name').val(),
                    queue_type: $('#queue_type').val(),
                    queue_did: $('#queue_did').val(),
                    greeting_file_id: $('#greeting_file_id').val(),
                    call_queue_file_id: $('#call_queue_file_id').val(),
                    queue_drop_time: $('#queue_drop_time').val(),
                    queue_drop_action: $('#queue_drop_action').val(),
                    queue_drop_value: $('#queue_drop_value').val(),
                    queue_length: $('#queue_length').val(),
                    queue_assigned_process: $('#queue_assigned_process').val(),
                    play_queue_no: $('#play_queue_no').is(':checked') ? 'Y' : 'N',
                    queue_no_file: $('#queue_no_file').val(),
                    play_hold_durn: $('#play_hold_durn').is(':checked') ? 'Y' : 'N',
                    hold_durn_file: $('#hold_durn_file').val(),
                    playback_freq: $('#playback_freq').val(),
                    queue_over_flow: $('#queue_over_flow').val(),
                    queue_selected: 'Y' // Default to active
                };

                let response;
                if (currentEditingId) {
                    queueData.queue_id = currentEditingId;
                    response = await apiCall(`${API_BASE_URL}?action=update`, {
                        method: 'POST',
                        body: JSON.stringify(queueData)
                    });
                } else {
                    response = await apiCall(`${API_BASE_URL}?action=create`, {
                        method: 'POST',
                        body: JSON.stringify(queueData)
                    });
                }

                $('#queueModal').modal('hide');
                showToast(`Queue ${currentEditingId ? 'updated' : 'created'} successfully!`, 'success');
                
                // Reload data
                await loadQueues();
                await loadStatistics();

            } catch (error) {
                console.error('Error saving queue:', error);
            }
        }

        // Confirm delete
        function confirmDelete(queueId, queueName) {
            $('#deleteConfirmText').text(`Delete queue "${queueName}"? This action cannot be undone.`);
            $('#confirmDeleteBtn').off('click').on('click', function() {
                deleteQueue(queueId);
            });
            $('#deleteConfirmModal').modal('show');
        }

        // Delete queue
        async function deleteQueue(queueId) {
            $('#deleteConfirmModal').modal('hide');
            
            try {
                const data = await apiCall(`${API_BASE_URL}?action=delete`, {
                    method: 'POST',
                    body: JSON.stringify({ queue_id: queueId })
                });

                showToast('Queue deleted successfully!', 'success');
                
                // Reload data
                await loadQueues();
                await loadStatistics();

            } catch (error) {
                console.error('Error deleting queue:', error);
            }
        }

        // Function to reset filters
        function resetFilters() {
            $('#searchInput').val('');
            $('#typeFilter').val('');
            $('#statusFilter').val('');
            
            // Reset DataTable search and filters
            const table = $('#queuesTable').DataTable();
            table.search('').columns().search('').draw();
        }

        // Function to show toast messages
        function showToast(message, type = 'info') {
            const toastContainer = $('#toastContainer');
            const toastId = 'toast-' + Date.now();
            
            const bgClass = type === 'success' ? 'bg-success' : 
                           type === 'error' ? 'bg-danger' : 'bg-info';
            
            const icon = type === 'success' ? 'check-circle' : 
                        type === 'error' ? 'exclamation-circle' : 'info-circle';
            
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${icon} me-2"></i>
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

        // Add event listeners for real-time filtering
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                queuesTable.search(this.value).draw();
            });

            $('#typeFilter').on('change', function() {
                queuesTable.column(2).search(this.value).draw();
            });

            $('#statusFilter').on('change', function() {
                queuesTable.column(7).search(this.value).draw();
            });
        });
    </script>
</body>
</html>