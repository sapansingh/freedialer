<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IVR Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0272a7;
            --secondary-color: #6BCBCA;
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .page-header {
            background: white;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid var(--primary-color);
        }
        
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px 8px 0 0 !important;
            padding: 0.75rem 1rem;
            font-weight: 600;
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            border-bottom: 1px solid #dee2e6;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #025a87;
            border-color: #025a87;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }
        
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        
        .form-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .section-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .dtmf-table th {
            background-color: var(--primary-color);
            color: white;
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none;
        }
        
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }
        
        .status-badge {
            font-size: 0.75rem;
        }
        
        .action-buttons {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="container-fluid py-3">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1"><i class="fas fa-phone-volume me-2"></i>IVR Management System</h1>
                    <p class="text-muted mb-0">Manage Interactive Voice Response Systems</p>
                </div>
                <button class="btn btn-primary" onclick="openAddModal()">
                    <i class="fas fa-plus me-1"></i> Add IVR
                </button>
            </div>
        </div>

        <!-- IVR List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>IVR Systems</span>
                <div class="d-flex">
                    <div class="input-group input-group-sm me-2" style="width: 250px;">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search IVR..." id="searchInput">
                    </div>
                    <!-- Removed status filter since status column is removed -->
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="ivrTable">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="25%">IVR Name</th>
                                <th width="30%">Description</th>
                                <th width="15%">Voice File</th>
                                <th width="10%">Wait Seconds</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ivrTableBody">
                            <!-- IVR data will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit IVR Modal -->
    <div class="modal fade" id="ivrModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-plus me-2"></i>Add New IVR</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ivrForm">
                        <input type="hidden" name="mode" value="SAVE">
                        <input type="hidden" name="user_sel_menu" value="IVRS">
                        <input type="hidden" id="ivr_id" name="ivr_id" value="">
                        
                        <div class="form-section">
                            <div class="section-title">Basic Information</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ivr_name" class="form-label required-field">IVR Name</label>
                                        <input type="text" class="form-control" id="ivr_name" name="ivr_name" maxlength="50" required>
                                        <div class="form-text text-danger" id="ivr_name_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ivr_description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="ivr_description" name="ivr_description" maxlength="50">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="voice_file" class="form-label required-field">Voice File</label>
                                        <select class="form-select" id="voice_file" name="voice_file" required>
                                            <option value="">Select Voice File</option>
                                            <!-- Voice files will be populated dynamically -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="seconds_to_wait" class="form-label required-field">Wait Seconds</label>
                                        <input type="number" class="form-control" id="seconds_to_wait" name="seconds_to_wait" min="0" max="60" value="10" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="repeats" class="form-label">Repeats</label>
                                        <input type="number" class="form-control" id="repeats" name="repeats" min="0" max="10" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="direct_call" class="form-label">Direct Call</label>
                                        <select class="form-select" id="direct_call" name="direct_call">
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <div class="section-title">DTMF Options Configuration</div>
                            <p class="text-muted mb-3">Configure actions for each DTMF input</p>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered dtmf-table">
                                    <thead>
                                        <tr>
                                            <th width="10%" class="text-center">DTMF</th>
                                            <th width="40%" class="text-center">Action</th>
                                            <th width="40%" class="text-center">Parameter</th>
                                            <th width="10%" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dtmfOptionsBody">
                                        <!-- DTMF options will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveIvr()">
                        <i class="fas fa-save me-1"></i> Save IVR
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the IVR <strong id="deleteIvrName"></strong>?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   <script>

// API Base URL - Updated to use relative path
const API_BASE_URL = '../api/ivr_api.php';

// Global data stores (only for IVRs, others loaded in real-time)
let currentEditingId = null;
let ivrsData = [];

// Initialize page
$(document).ready(function() {
    loadInitialData();
    
    // Add event listeners for search and filter
    $('#searchInput').on('keyup', filterIvrs);
});

// Load all initial data
async function loadInitialData() {
    showLoading(true);
    try {
        await loadIvrs();
    } catch (error) {
        showToast('Failed to load initial data: ' + error.message, 'error');
    } finally {
        showLoading(false);
    }
}

// API Service Functions
const apiService = {
    // Get all IVRs
    async getIvrs() {
        try {
            const response = await fetch(`${API_BASE_URL}?action=ivrs`);
            if (!response.ok) throw new Error('Failed to fetch IVRs');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error fetching IVRs:', error);
            throw error;
        }
    },

    // Get single IVR by ID with its options
    async getIvr(id) {
        try {
            const response = await fetch(`${API_BASE_URL}?action=ivrs&id=${id}`);
            if (!response.ok) throw new Error('Failed to fetch IVR');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error fetching IVR:', error);
            throw error;
        }
    },

    // Get all processes
    async getProcesses() {
        try {
            const response = await fetch(`${API_BASE_URL}?action=processes`);
            if (!response.ok) throw new Error('Failed to fetch processes');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error fetching processes:', error);
            throw error;
        }
    },

    // Get all queues
    async getQueues() {
        try {
            const response = await fetch(`${API_BASE_URL}?action=queues`);
            if (!response.ok) throw new Error('Failed to fetch queues');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error fetching queues:', error);
            throw error;
        }
    },

    // Get all voice files
    async getVoiceFiles() {
        try {
            const response = await fetch(`${API_BASE_URL}?action=voicefiles`);
            if (!response.ok) throw new Error('Failed to fetch voice files');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error fetching voice files:', error);
            throw error;
        }
    },

    // Get IVRs for dropdown (for transfer to IVR option)
    async getIvrsForDropdown() {
        try {
            const response = await fetch(`${API_BASE_URL}?action=ivrs_dropdown`);
            if (!response.ok) throw new Error('Failed to fetch IVRs for dropdown');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error fetching IVRs for dropdown:', error);
            throw error;
        }
    },

    // Create new IVR with options
    async createIvr(ivrData) {
        try {
            const response = await fetch(`${API_BASE_URL}?action=ivrs`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(ivrData)
            });
            if (!response.ok) throw new Error('Failed to create IVR');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error creating IVR:', error);
            throw error;
        }
    },

    // Update existing IVR
    async updateIvr(id, ivrData) {
        try {
            const response = await fetch(`${API_BASE_URL}?action=ivrs&id=${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(ivrData)
            });
            if (!response.ok) throw new Error('Failed to update IVR');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error updating IVR:', error);
            throw error;
        }
    },

    // Delete IVR
    async deleteIvr(id) {
        try {
            const response = await fetch(`${API_BASE_URL}?action=ivrs&id=${id}`, {
                method: 'DELETE'
            });
            if (!response.ok) throw new Error('Failed to delete IVR');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error deleting IVR:', error);
            throw error;
        }
    },

    // Test IVR
    async testIvr(id) {
        try {
            const response = await fetch(`${API_BASE_URL}?action=ivrs&id=${id}&test=true`, {
                method: 'POST'
            });
            if (!response.ok) throw new Error('Failed to test IVR');
            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'API error');
            return result;
        } catch (error) {
            console.error('Error testing IVR:', error);
            throw error;
        }
    }
};

// Load IVRs from API
async function loadIvrs() {
    try {
        const result = await apiService.getIvrs();
        ivrsData = result.data || [];
        populateIvrsTable(ivrsData);
        
        // Also load voice files for the main form dropdown
        await loadVoiceFilesForForm();
    } catch (error) {
        throw error;
    }
}

// Load voice files for main form dropdown
async function loadVoiceFilesForForm() {
    try {
        const result = await apiService.getVoiceFiles();
        populateVoiceFilesDropdown(result.data || []);
    } catch (error) {
        console.error('Error loading voice files for form:', error);
    }
}

// Populate voice files dropdown in main form
function populateVoiceFilesDropdown(voiceFiles = []) {
    const select = $('#voice_file');
    select.empty().append('<option value="">Select Voice File</option>');
    
    voiceFiles.forEach(file => {
        select.append(`<option value="${file.id}">${file.name}</option>`);
    });
}

// Populate IVRs table
function populateIvrsTable(ivrs) {
    const tbody = $('#ivrTableBody');
    tbody.empty();
    
    if (ivrs.length === 0) {
        tbody.append('<tr><td colspan="6" class="text-center py-4 text-muted">No IVRs found</td></tr>');
        return;
    }
    
    ivrs.forEach(ivr => {
        const voiceFileText = getVoiceFileName(ivr.voice_file);
        
        const row = `
            <tr>
                <td>${ivr.ivr_id}</td>
                <td><strong>${ivr.ivr_name}</strong></td>
                <td>${ivr.ivr_description || ''}</td>
                <td>${voiceFileText}</td>
                <td>${ivr.seconds_to_wait}</td>
                <td>
                    <div class="btn-group btn-group-sm action-buttons">
                        <button class="btn btn-outline-primary" onclick="editIvr(${ivr.ivr_id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-success" onclick="testIvr(${ivr.ivr_id})" title="Test">
                            <i class="fas fa-play"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="confirmDelete(${ivr.ivr_id}, '${ivr.ivr_name}')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

// Get voice file name by ID (for display in table)
function getVoiceFileName(id) {
    // This will be updated when we load voice files for the form
    return `File ${id}`; // Placeholder, will be updated with real data
}

// Filter IVRs based on search
function filterIvrs() {
    const searchText = $('#searchInput').val().toLowerCase();
    
    const filteredIvrs = ivrsData.filter(ivr => {
        const matchesSearch = ivr.ivr_name.toLowerCase().includes(searchText) || 
                             (ivr.ivr_description && ivr.ivr_description.toLowerCase().includes(searchText));
        
        return matchesSearch;
    });
    
    populateIvrsTable(filteredIvrs);
}

// Initialize DTMF options in the form
function initializeDtmfOptions() {
    const dtmfOptionsData = [
        { digit: '0', label: '0' },
        { digit: '1', label: '1' },
        { digit: '2', label: '2' },
        { digit: '3', label: '3' },
        { digit: '4', label: '4' },
        { digit: '5', label: '5' },
        { digit: '6', label: '6' },
        { digit: '7', label: '7' },
        { digit: '8', label: '8' },
        { digit: '9', label: '9' },
        { digit: '10', label: 'Invalid' },
        { digit: '11', label: 'Time out' },
        { digit: '12', label: 'Hangup' }
    ];
    
    const tbody = $('#dtmfOptionsBody');
    tbody.empty();
    
    dtmfOptionsData.forEach(option => {
        const row = `
            <tr>
                <td class="text-center fw-bold">${option.label}</td>
                <td>
                    <select class="form-select form-select-sm ivr-option" id="ivr_option_${option.digit}" name="ivr_option[]" data-digit="${option.digit}" onchange="showParameters(this.value, '${option.digit}')">
                        <option value=""></option>
                        <option value="extension">Transfer to Extension</option>
                        <option value="process">Transfer to Process</option>
                        <option value="queue">Transfer to Queue</option>
                        <option value="voicemail">Transfer to Voice Mail</option>
                        <option value="complete">Complete Call</option>
                        <option value="ivr">Transfer to IVR</option>
                        <option value="ip">DirectIP Dial</option>
                        <option value="callforward">Call Forward</option>
                        <option value="play">Play Voicefile</option>
                        <option value="callback">CallBack</option>
                        <option value="sms">SMS</option>
                    </select>
                </td>
                <td id="ivr_value_span_${option.digit}">
                    <select class="form-select form-select-sm ivr-value" id="ivr_value_${option.digit}" name="ivr_value[]" data-digit="${option.digit}">
                        <option value=""></option>
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearDtmfOption('${option.digit}')" title="Clear">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

// Clear DTMF option
function clearDtmfOption(digit) {
    $(`#ivr_option_${digit}`).val('');
    $(`#ivr_value_${digit}`).val('');
    $(`#ivr_value_span_${digit}`).html(`
        <select class="form-select form-select-sm ivr-value" id="ivr_value_${digit}" name="ivr_value[]" data-digit="${digit}">
            <option value=""></option>
        </select>
    `);
}

// Show parameters based on selected action - REAL-TIME API CALLS
async function showParameters(action, digit) {
    const paramContainer = $(`#ivr_value_span_${digit}`);
    paramContainer.empty();
    
    // Show loading state
    paramContainer.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"></div> Loading...</div>');
    
    if (!action) {
        paramContainer.html(`
            <select class="form-select form-select-sm ivr-value" id="ivr_value_${digit}" name="ivr_value[]" data-digit="${digit}">
                <option value=""></option>
            </select>
        `);
        return;
    }
    
    let options = [];
    let placeholder = '';
    
    try {
        switch(action) {
            case 'process':
                // REAL-TIME API CALL for processes
                const processesResult = await apiService.getProcesses();
                options = processesResult.data.map(p => p.name);
                placeholder = 'Select Process';
                break;
                
            case 'queue':
                // REAL-TIME API CALL for queues
                const queuesResult = await apiService.getQueues();
                options = queuesResult.data.map(q => q.name);
                placeholder = 'Select Queue';
                break;
                
            case 'ivr':
                // REAL-TIME API CALL for IVRs
                const ivrsResult = await apiService.getIvrsForDropdown();
                options = ivrsResult.data.map(i => i.name);
                placeholder = 'Select IVR';
                break;
                
            case 'play':
                // REAL-TIME API CALL for voice files
                const voiceFilesResult = await apiService.getVoiceFiles();
                options = voiceFilesResult.data.map(v => v.name);
                placeholder = 'Select Voice File';
                break;
                
            case 'extension':
                paramContainer.html('<input type="text" class="form-control form-control-sm" id="ivr_value_' + digit + '" name="ivr_value[]" placeholder="Enter extension number" maxlength="10">');
                return;
                
            case 'voicemail':
                paramContainer.html('<input type="text" class="form-control form-control-sm" id="ivr_value_' + digit + '" name="ivr_value[]" placeholder="Enter voicemail ID">');
                return;
                
            case 'ip':
                paramContainer.html('<input type="text" class="form-control form-control-sm" id="ivr_value_' + digit + '" name="ivr_value[]" placeholder="Enter IP address">');
                return;
                
            case 'callforward':
                paramContainer.html('<input type="text" class="form-control form-control-sm" id="ivr_value_' + digit + '" name="ivr_value[]" placeholder="Enter phone number">');
                return;
                
            case 'callback':
                paramContainer.html('<input type="text" class="form-control form-control-sm" id="ivr_value_' + digit + '" name="ivr_value[]" placeholder="Enter callback number">');
                return;
                
            case 'sms':
                paramContainer.html('<input type="text" class="form-control form-control-sm" id="ivr_value_' + digit + '" name="ivr_value[]" placeholder="Enter SMS content">');
                return;
                
            case 'complete':
                paramContainer.html('<input type="hidden" id="ivr_value_' + digit + '" name="ivr_value[]" value="complete">');
                paramContainer.append('<span class="text-muted">No parameter needed</span>');
                return;
                
            default:
                paramContainer.html('<input type="text" class="form-control form-control-sm" id="ivr_value_' + digit + '" name="ivr_value[]" placeholder="Enter value">');
                return;
        }
        
        // Create select element for options
        let selectHtml = `<select class="form-select form-select-sm ivr-value" id="ivr_value_${digit}" name="ivr_value[]" data-digit="${digit}">`;
        selectHtml += `<option value="">${placeholder}</option>`;
        options.forEach(option => {
            selectHtml += `<option value="${option}">${option}</option>`;
        });
        selectHtml += '</select>';
        
        paramContainer.html(selectHtml);
        
    } catch (error) {
        console.error('Error loading parameters:', error);
        paramContainer.html(`
            <div class="text-danger">
                <i class="fas fa-exclamation-triangle"></i> Failed to load data
            </div>
        `);
        showToast('Failed to load ' + action + ' data: ' + error.message, 'error');
    }
}

// Open add modal
function openAddModal() {
    currentEditingId = null;
    $('#modalTitle').html('<i class="fas fa-plus me-2"></i>Add New IVR');
    $('#ivrForm')[0].reset();
    $('#ivr_id').val('');
    initializeDtmfOptions();
    $('#ivrModal').modal('show');
}

// Edit IVR
async function editIvr(ivrId) {
    showLoading(true);
    try {
        const result = await apiService.getIvr(ivrId);
        const ivr = result.data;
        
        currentEditingId = ivrId;
        $('#modalTitle').html('<i class="fas fa-edit me-2"></i>Edit IVR');
        
        // Fill form with IVR data
        $('#ivr_id').val(ivr.ivr_id);
        $('#ivr_name').val(ivr.ivr_name);
        $('#ivr_description').val(ivr.ivr_description || '');
        $('#voice_file').val(ivr.voice_file);
        $('#seconds_to_wait').val(ivr.seconds_to_wait);
        $('#repeats').val(ivr.repeats || 0);
        $('#direct_call').val(ivr.direct_call || 'no');
        
        // Initialize DTMF options
        initializeDtmfOptions();
        
        // Load DTMF options after a short delay to ensure DOM is ready
        setTimeout(async () => {
            if (ivr.options && ivr.options.length > 0) {
                await loadDtmfOptions(ivr.options);
            }
        }, 100);
        
        $('#ivrModal').modal('show');
    } catch (error) {
        showToast('Failed to load IVR: ' + error.message, 'error');
    } finally {
        showLoading(false);
    }
}

// Load DTMF options for editing
async function loadDtmfOptions(options) {
    for (const option of options) {
        const digit = option.option_num;
        const action = option.option_key;
        const value = option.destination;
        
        $(`#ivr_option_${digit}`).val(action);
        
        // Wait for the parameters to load before setting the value
        await showParameters(action, digit);
        
        // Set the value after options are loaded
        setTimeout(() => {
            const valueElement = $(`#ivr_value_${digit}`);
            if (valueElement.length) {
                if (valueElement.is('select')) {
                    valueElement.val(value);
                } else {
                    valueElement.val(value);
                }
            }
        }, 500);
    }
}

// Confirm delete
function confirmDelete(ivrId, ivrName) {
    $('#deleteIvrName').text(ivrName);
    $('#confirmDeleteBtn').off('click').on('click', function() {
        deleteIvr(ivrId);
    });
    $('#deleteConfirmModal').modal('show');
}

// Delete IVR
async function deleteIvr(ivrId) {
    $('#deleteConfirmModal').modal('hide');
    showLoading(true);

    try {
        await apiService.deleteIvr(ivrId);
        // Reload data from API after delete
        await loadIvrs();
        showToast('IVR deleted successfully!', 'success');
    } catch (error) {
        showToast('Failed to delete IVR: ' + error.message, 'error');
    } finally {
        showLoading(false);
    }
}

// Save IVR
async function saveIvr() {
    const formData = new FormData(document.getElementById('ivrForm'));
    const data = Object.fromEntries(formData.entries());

    // Validation
    if (!data.ivr_name.trim()) {
        alert('Please enter an IVR name');
        return;
    }
    
    if (!data.voice_file) {
        alert('Please select a voice file');
        return;
    }
    
    if (!data.seconds_to_wait || data.seconds_to_wait < 0) {
        alert('Please enter a valid wait time');
        return;
    }

    // Collect DTMF options
    const options = collectDtmfOptions();

    // Prepare IVR data
    const ivrData = {
        ivr_name: data.ivr_name,
        ivr_description: data.ivr_description || '',
        voice_file: parseInt(data.voice_file),
        seconds_to_wait: parseInt(data.seconds_to_wait),
        repeats: parseInt(data.repeats) || 0,
        direct_call: data.direct_call,
        options: options
    };

    showLoading(true);

    try {
        if (currentEditingId) {
            // Update existing IVR
            await apiService.updateIvr(currentEditingId, ivrData);
            showToast('IVR updated successfully!', 'success');
        } else {
            // Add new IVR
            await apiService.createIvr(ivrData);
            showToast('IVR created successfully!', 'success');
        }

        // Reload IVRs from API to get fresh data
        await loadIvrs();
        $('#ivrModal').modal('hide');
    } catch (error) {
        showToast('Failed to save IVR: ' + error.message, 'error');
    } finally {
        showLoading(false);
    }
}

// Collect DTMF options from form
function collectDtmfOptions() {
    const options = [];
    $('.ivr-option').each(function() {
        const digit = $(this).data('digit');
        const action = $(this).val();
        
        if (action) {
            const valueElement = $(`#ivr_value_${digit}`);
            let value = '';
            
            if (valueElement.length) {
                if (valueElement.is('select')) {
                    value = valueElement.val();
                } else {
                    value = valueElement.val();
                }
            }
            
            // For complete action, set a default value
            if (action === 'complete' && !value) {
                value = 'complete';
            }
            
            if (value) {
                options.push({
                    option_num: parseInt(digit),
                    option_key: action,
                    destination: value
                });
            }
        }
    });
    return options;
}

// Test IVR
async function testIvr(ivrId) {
    showLoading(true);
    try {
        await apiService.testIvr(ivrId);
        showToast('IVR test completed successfully!', 'success');
    } catch (error) {
        showToast('Failed to test IVR: ' + error.message, 'error');
    } finally {
        showLoading(false);
    }
}

// Function to show toast messages
function showToast(message, type = 'info') {
    const toastContainer = $('#toastContainer');
    const toastId = 'toast-' + Date.now();
    
    const bgClass = type === 'error' ? 'danger' : type;
    
    const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${bgClass} border-0" role="alert">
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