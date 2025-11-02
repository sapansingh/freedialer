<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Break Management - Call Center</title>
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
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.2);
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 2rem;
        }
        
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        }
        
        .page-header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #e1e5e9;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 0.85rem;
        }
        
        .required-field::after {
            content: ' *';
            color: var(--warning-color);
        }
        
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            font-size: 0.85rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        
        .btn-action {
            padding: 6px 10px;
            border-radius: 6px;
            margin: 0 2px;
            transition: all 0.2s ease;
            font-size: 0.8rem;
        }
        
        .btn-action:hover {
            transform: scale(1.05);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.8rem;
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
        
        .stat-card {
            text-align: center;
            padding: 20px 15px;
            border-radius: 12px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 600;
        }
        
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .search-box .input-group-text {
            background: white;
            border-right: none;
            border-radius: 8px 0 0 8px;
        }
        
        .search-box .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
        
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 15px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px;
            padding: 8px 12px;
            border: 1px solid #e1e5e9;
        }
        
        .real-time-stats {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 15px;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-label-small {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        .time-input-group {
            display: flex;
            align-items: center;
        }
        
        .time-input-group .form-control {
            flex: 1;
        }
        
        .time-input-group .input-group-text {
            background: #f8f9fa;
            border: 1px solid #e1e5e9;
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
        
        .delete-modal-content {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .delete-modal-header {
            background: linear-gradient(135deg, #f72585, #b5179e);
            color: white;
            padding: 20px 25px;
        }
        
        .delete-modal-body {
            padding: 25px;
            text-align: center;
        }
        
        .delete-icon {
            font-size: 3rem;
            color: #f72585;
            margin-bottom: 15px;
        }
        
        .delete-modal-footer {
            padding: 15px 25px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .validation-modal-content {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .validation-modal-header {
            background: linear-gradient(135deg, #4cc9f0, #4895ef);
            color: white;
            padding: 20px 25px;
        }
        
        .validation-modal-body {
            padding: 25px;
            text-align: center;
        }
        
        .validation-icon {
            font-size: 3rem;
            color: #4cc9f0;
            margin-bottom: 15px;
        }
        
        .validation-modal-footer {
            padding: 15px 25px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status" style="width: 2.5rem; height: 2.5rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Break Modal -->
    <div class="modal fade" id="breakModal" tabindex="-1" aria-labelledby="breakModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content glass-card" style="background: var(--glass-bg);">
                <div class="modal-header">
                    <h5 class="modal-title" id="breakModalLabel">Add New Break</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="breakForm">
                        <input type="hidden" id="breakId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="breakName" class="form-label required-field">Break Name</label>
                                    <input type="text" class="form-control" id="breakName" required maxlength="20">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="breakTime" class="form-label required-field">Break Time</label>
                                    <div class="time-input-group">
                                        <input type="time" class="form-control" id="breakTime" required>
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" maxlength="100"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="process" class="form-label required-field">Process</label>
                            <select class="form-select" id="process" required>
                                <option value="">Select Process</option>
                                <option value="Production">Production</option>
                                <option value="Verification">Verification</option>
                                <option value="Quality Control">Quality Control</option>
                                <option value="Management">Management</option>
                                <option value="All">All Processes</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveBreakBtn">Save Break</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-modal-content">
                <div class="delete-modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="delete-modal-body">
                    <div class="delete-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h4 class="mb-3">Delete Break</h4>
                    <p>Are you sure you want to delete the break <strong id="breakToDeleteName">[Break Name]</strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="delete-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i> Delete Break
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Validation Modal -->
    <div class="modal fade" id="validationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content validation-modal-content">
                <div class="validation-modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-circle me-2"></i>Validation Error</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="validation-modal-body">
                    <div class="validation-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <h4 class="mb-3" id="validationTitle">Missing Information</h4>
                    <p id="validationMessage">Please complete all required fields.</p>
                </div>
                <div class="validation-modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-3">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <div>
                    <h1 class="h4 mb-1"><i class="fas fa-coffee me-2 text-primary"></i>Break Management</h1>
                    <p class="text-muted mb-0">Manage employee breaks and monitor break schedules</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#breakModal">
                    <i class="fas fa-plus me-1"></i> Add New Break
                </button>
            </div>
        </div>

        <!-- Real-time Statistics -->
        <div class="real-time-stats">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-value" id="totalBreaks">0</div>
                        <div class="stat-label-small">Total Breaks</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-value" id="activeBreaks">0</div>
                        <div class="stat-label-small">Active Breaks</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-value" id="upcomingBreaks">0</div>
                        <div class="stat-label-small">Upcoming Breaks</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-value" id="avgBreakTime">15m</div>
                        <div class="stat-label-small">Avg Break Time</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                        <i class="fas fa-coffee"></i>
                    </div>
                    <div class="stat-number text-primary" id="morningBreaks">0</div>
                    <div class="stat-label">Morning Breaks</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="stat-number text-info" id="lunchBreaks">0</div>
                    <div class="stat-label">Lunch Breaks</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number text-warning" id="afternoonBreaks">0</div>
                    <div class="stat-label">Afternoon Breaks</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                        <i class="fas fa-walking"></i>
                    </div>
                    <div class="stat-number text-secondary" id="shortBreaks">0</div>
                    <div class="stat-label">Short Breaks</div>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="glass-card">
            <div class="table-responsive">
                <table id="breaksTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Break Name</th>
                            <th>Description</th>
                            <th>Time</th>
                            <th>Process</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

   <script>

    // API Configuration
const API_BASE_URL = '../api/breaks.php';

// Global variables
let breaksData = [];
let breakToDelete = null;
let breaksTable;

// DOM Elements
const breakModal = document.getElementById('breakModal');
const breakForm = document.getElementById('breakForm');
const breakIdInput = document.getElementById('breakId');
const breakNameInput = document.getElementById('breakName');
const descriptionInput = document.getElementById('description');
const breakTimeInput = document.getElementById('breakTime');
const processInput = document.getElementById('process');
const saveBreakBtn = document.getElementById('saveBreakBtn');
const toastContainer = document.getElementById('toastContainer');
const loadingOverlay = document.getElementById('loadingOverlay');
const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
const breakToDeleteName = document.getElementById('breakToDeleteName');

// Statistics elements
const totalBreaksEl = document.getElementById('totalBreaks');
const activeBreaksEl = document.getElementById('activeBreaks');
const upcomingBreaksEl = document.getElementById('upcomingBreaks');
const avgBreakTimeEl = document.getElementById('avgBreakTime');
const morningBreaksEl = document.getElementById('morningBreaks');
const lunchBreaksEl = document.getElementById('lunchBreaks');
const afternoonBreaksEl = document.getElementById('afternoonBreaks');
const shortBreaksEl = document.getElementById('shortBreaks');

// Initialize the page
$(document).ready(function() {
    loadBreaks();
    setupEventListeners();
});

// API Functions
async function loadBreaks() {
    showLoading(true);
    try {
        const response = await fetch(`${API_BASE_URL}?action=getAll`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        
        // Check if the response has a success property
        if (data.success) {
            breaksData = data.data || [];
            console.log('Loaded breaks:', breaksData); // Debug log
            
            // Ensure all break_id values are numbers
            breaksData = breaksData.map(breakItem => {
                return {
                    ...breakItem,
                    break_id: parseInt(breakItem.break_id)
                };
            });
            
            console.log('Processed breaksData:', breaksData); // Debug log
        } else {
            throw new Error(data.message || 'Failed to load breaks');
        }
        
        initializeDataTable();
        updateStatistics();
    } catch (error) {
        console.error('Error loading breaks:', error);
        showToast('Failed to load breaks: ' + error.message, 'danger');
        // Initialize with empty data if API fails
        breaksData = [];
        initializeDataTable();
        updateStatistics();
    } finally {
        showLoading(false);
    }
}

async function saveBreakToAPI(breakData) {
    const isUpdate = breakData.break_id !== undefined && breakData.break_id !== '';
    const action = isUpdate ? 'update' : 'create';
    
    try {
        const response = await fetch(`${API_BASE_URL}?action=${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(breakData)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success) {
            return result;
        } else {
            throw new Error(result.message || 'Failed to save break');
        }
    } catch (error) {
        console.error('Error saving break:', error);
        throw error;
    }
}

async function deleteBreakFromAPI(breakId) {
    try {
        const response = await fetch(`${API_BASE_URL}?action=delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ break_id: breakId })
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success) {
            return result;
        } else {
            throw new Error(result.message || 'Failed to delete break');
        }
    } catch (error) {
        console.error('Error deleting break:', error);
        throw error;
    }
}

function initializeDataTable() {
    if (breaksTable) {
        breaksTable.destroy();
    }
    
    breaksTable = $('#breaksTable').DataTable({
        data: breaksData,
        columns: [
            { data: 'break_id' },
            { data: 'break' }, // Note: This matches your database column name
            { data: 'description' },
            { 
                data: 'break_time',
                render: function(data) {
                    // Format time for display (remove seconds if 00:00)
                    return data.endsWith(':00') ? data.substring(0, 5) : data;
                }
            },
            { data: 'process' },
            { 
                data: 'break_time',
                render: function(data) {
                    return getBreakStatus(data);
                }
            },
            {
                data: 'break_id',
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-warning btn-action" onclick="editBreak(${data})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-action" onclick="deleteBreak(${data})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                },
                orderable: false,
                searchable: false
            }
        ],
        pageLength: 10,
        responsive: true,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search breaks...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        // Add this to ensure data is available for editing
        drawCallback: function() {
            // Update breaksData with current table data
            breaksData = this.api().rows().data().toArray();
            console.log('DataTable breaksData updated:', breaksData); // Debug log
        }
    });
}

function setupEventListeners() {
    // Save break button
    saveBreakBtn.addEventListener('click', function() {
        saveBreak();
    });

    // Delete confirmation
    confirmDeleteBtn.addEventListener('click', function() {
        if (breakToDelete) {
            performDeleteBreak(breakToDelete);
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
            modal.hide();
        }
    });

    // Reset form when modal is hidden
    breakModal.addEventListener('hidden.bs.modal', function() {
        resetForm();
    });
}

function getBreakStatus(breakTime) {
    const now = new Date();
    const breakTimeObj = new Date();
    const [hours, minutes] = breakTime.split(':');
    breakTimeObj.setHours(parseInt(hours), parseInt(minutes), 0, 0);
    
    let status = 'Upcoming';
    let statusClass = 'bg-warning';
    
    if (now > breakTimeObj) {
        status = 'Completed';
        statusClass = 'bg-secondary';
    }
    
    // Check if break is within the next 15 minutes
    const fifteenMinutesFromNow = new Date(now.getTime() + 15 * 60000);
    if (now < breakTimeObj && breakTimeObj < fifteenMinutesFromNow) {
        status = 'Starting Soon';
        statusClass = 'bg-info';
    }
    
    return `<span class="badge ${statusClass}">${status}</span>`;
}

function updateStatistics() {
    const breaks = breaksTable ? breaksTable.data().toArray() : [];
    
    // Update main statistics
    totalBreaksEl.textContent = breaks.length;
    
    // Calculate active breaks (within the next hour)
    const now = new Date();
    const oneHourFromNow = new Date(now.getTime() + 60 * 60000);
    const activeBreaks = breaks.filter(breakItem => {
        const breakTime = new Date();
        const [hours, minutes] = breakItem.break_time.split(':');
        breakTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
        return now < breakTime && breakTime < oneHourFromNow;
    });
    activeBreaksEl.textContent = activeBreaks.length;
    
    // Calculate upcoming breaks (today)
    const upcomingBreaks = breaks.filter(breakItem => {
        const breakTime = new Date();
        const [hours, minutes] = breakItem.break_time.split(':');
        breakTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
        return now < breakTime;
    });
    upcomingBreaksEl.textContent = upcomingBreaks.length;
    
    // Calculate break type statistics
    const morningBreaks = breaks.filter(breakItem => {
        const hour = parseInt(breakItem.break_time.split(':')[0]);
        return hour >= 6 && hour < 12;
    });
    morningBreaksEl.textContent = morningBreaks.length;
    
    const lunchBreaks = breaks.filter(breakItem => {
        const hour = parseInt(breakItem.break_time.split(':')[0]);
        return hour >= 11 && hour < 14;
    });
    lunchBreaksEl.textContent = lunchBreaks.length;
    
    const afternoonBreaks = breaks.filter(breakItem => {
        const hour = parseInt(breakItem.break_time.split(':')[0]);
        return hour >= 14 && hour < 18;
    });
    afternoonBreaksEl.textContent = afternoonBreaks.length;
    
    const shortBreaks = breaks.filter(breakItem => {
        return breakItem.description.toLowerCase().includes('quick') || 
               breakItem.description.toLowerCase().includes('short') ||
               breakItem.description.toLowerCase().includes('coffee');
    });
    shortBreaksEl.textContent = shortBreaks.length;
}

async function saveBreak() {
    const id = breakIdInput.value ? parseInt(breakIdInput.value) : null;
    const breakName = breakNameInput.value.trim();
    const description = descriptionInput.value.trim();
    const breakTime = breakTimeInput.value;
    const process = processInput.value;
    
    if (!breakName || !breakTime || !process) {
        showValidationModal('Missing Information', 'Please fill in all required fields!');
        return;
    }
    
    // Format time properly
    const formattedTime = breakTime + ':00';
    
    const breakData = {
        break_id: id,
        break: breakName, // Note: This matches your API field name
        description: description,
        break_time: formattedTime,
        process: process
    };

    showLoading(true);
    try {
        const result = await saveBreakToAPI(breakData);
        
        if (result.success) {
            showToast(id ? 'Break updated successfully!' : 'Break added successfully!', 'success');
            await loadBreaks(); // Reload data from API
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(breakModal);
            modal.hide();
        }
    } catch (error) {
        console.error('Error saving break:', error);
        showToast('Failed to save break: ' + error.message, 'danger');
    } finally {
        showLoading(false);
    }
}

function deleteBreak(id) {
    // Get the break data directly from the DataTable
    const breakItem = breaksTable.row(`[data-id="${id}"]`).data();
    if (!breakItem) {
        // Fallback: search in breaksData array
        const foundBreak = breaksData.find(b => b.break_id === id);
        if (!foundBreak) {
            showToast('Break not found!', 'danger');
            return;
        }
        breakToDeleteName.textContent = foundBreak.break;
    } else {
        breakToDeleteName.textContent = breakItem.break;
    }
    
    breakToDelete = id;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
    deleteModal.show();
}

async function performDeleteBreak(id) {
    showLoading(true);
    try {
        const result = await deleteBreakFromAPI(id);
        
        if (result.success) {
            showToast('Break deleted successfully!', 'success');
            await loadBreaks(); // Reload data from API
        }
    } catch (error) {
        console.error('Error deleting break:', error);
        showToast('Failed to delete break: ' + error.message, 'danger');
    } finally {
        showLoading(false);
        breakToDelete = null;
    }
}

function editBreak(id) {
    console.log('Editing break ID:', id); // Debug log
    console.log('Available breaksData:', breaksData); // Debug log
    
    // Try to find the break in the breaksData array
    const breakItem = breaksData.find(b => b.break_id == id);
    
    if (!breakItem) {
        console.error('Break not found in breaksData. ID:', id); // Debug log
        showToast('Break not found!', 'danger');
        return;
    }
    
    console.log('Found break item:', breakItem); // Debug log
    
    breakIdInput.value = breakItem.break_id;
    breakNameInput.value = breakItem.break;
    descriptionInput.value = breakItem.description || '';
    
    // Format time for input (remove seconds)
    let timeValue = breakItem.break_time;
    if (timeValue && timeValue.endsWith(':00')) {
        timeValue = timeValue.substring(0, 5);
    }
    breakTimeInput.value = timeValue;
    
    processInput.value = breakItem.process;
    
    // Update modal title
    document.getElementById('breakModalLabel').textContent = 'Edit Break';
    
    // Show modal
    const modal = new bootstrap.Modal(breakModal);
    modal.show();
}

function resetForm() {
    breakForm.reset();
    breakIdInput.value = '';
    document.getElementById('breakModalLabel').textContent = 'Add New Break';
}

function showValidationModal(title, message) {
    document.getElementById('validationTitle').textContent = title;
    document.getElementById('validationMessage').textContent = message;
    const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
    validationModal.show();
}

function showLoading(show) {
    loadingOverlay.style.display = show ? 'flex' : 'none';
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    // Remove toast from DOM after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        toast.remove();
    });
}

// Simulate real-time updates
setInterval(function() {
    updateStatistics();
}, 60000); // Update every minute
   </script>
  
</body>
</html>