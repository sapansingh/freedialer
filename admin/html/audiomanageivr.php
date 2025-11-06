<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IVR Audio Files Management</title>
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
        
        .upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .upload-area:hover {
            border-color: var(--primary-color);
            background: #f0f4ff;
        }
        
        .upload-area.dragover {
            border-color: var(--primary-color);
            background: #e0e7ff;
        }
        
        .file-preview {
            margin-top: 15px;
            padding: 15px;
            background: #f1f5f9;
            border-radius: 8px;
            display: none;
        }
        
        .file-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 10px;
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
        
        .file-type-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .type-wav {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .type-mp3 {
            background: #f0fdf4;
            color: #166534;
        }
        
        .type-gsm {
            background: #fef3c7;
            color: #92400e;
        }
        
        .type-ulaw {
            background: #fce7f3;
            color: #be185d;
        }
        
        .type-alaw {
            background: #e0e7ff;
            color: #3730a3;
        }
        
        .audio-player {
            width: 200px;
            height: 40px;
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
                <i class="fas fa-file-audio"></i>
                <span>IVR AUDIO FILES MANAGEMENT</span>
            </div>
            
            <div class="header-actions">
                <div class="header-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
                        <i class="fas fa-upload me-1"></i> Upload File
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
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalFiles">0</h3>
                            <p>Total Files</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4ade80, #22c55e);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="uploadedFiles">0</h3>
                            <p>Uploaded Files</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="wavFiles">0</h3>
                            <p>WAV Files</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <i class="fas fa-headphones"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="mp3Files">0</h3>
                            <p>MP3 Files</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Files Table -->
            <div class="table-container" style="position: relative;">
                <div class="loading-overlay" id="tableLoading" style="display: none;">
                    <div class="spinner"></div>
                </div>
                <div class="table-responsive">
                    <table id="filesTable" class="table table-hover display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th> 
                                <th>File Name</th>
                                <th>File Size</th>
                                <th>Preview</th>
                                <th>Location</th>
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
                ConVox CCS v2.0 | IVR Audio Files Management
            </div>
            <div>
                <span id="lastUpdated">Last updated: Just now</span>
            </div>
        </div>
    </div>

    <!-- Upload File Modal -->
    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileModalLabel">
                        <i class="fas fa-upload me-2"></i>Upload IVR Audio File
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> File Information
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="file_name" class="form-label required">File Name *</label>
                                    <input type="text" class="form-control" id="file_name" name="file_name" required>
                                    <div class="form-text">Display name for the audio file</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-file-upload"></i> File Upload
                            </div>
                            <div class="upload-area" id="uploadArea">
                                <input type="file" id="audio_file" name="audio_file" accept=".wav,.mp3,.gsm,.ulaw,.alaw" style="display: none;">
                                <div class="file-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h5>Drag & Drop your audio file here</h5>
                                <p class="text-muted">or click to browse</p>
                                <small class="text-muted">
                                    Supported formats: WAV, MP3, GSM, ULAW, ALAW<br>
                                    Maximum file size: 10MB
                                </small>
                            </div>
                            
                            <div class="file-preview" id="filePreview">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-file-audio text-primary fa-2x"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 id="previewFileName" class="mb-1"></h6>
                                        <small id="previewFileSize" class="text-muted"></small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFileSelection()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="uploadBtn" disabled>
                        <i class="fas fa-upload me-1"></i> Upload File
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit File Modal -->
    <div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFileModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit File Name
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit_file_id" name="file_id">
                        <div class="mb-3">
                            <label for="edit_file_name" class="form-label required">File Name *</label>
                            <input type="text" class="form-control" id="edit_file_name" name="file_name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn">
                        <i class="fas fa-save me-1"></i> Save Changes
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
                    <h5 class="mb-3">Delete File</h5>
                    <p>Are you sure you want to delete the file <strong id="fileToDeleteName">[File Name]</strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone and will remove the file permanently.</small></p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i> Delete File
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
        const API_BASE_URL = '.././api/ivr_files_api.php';
        
        let filesTable;
        let fileToDelete = null;
        let selectedFile = null;

        // Initialize the application when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable();
            loadStats();
            updateLastUpdatedTime();
            setupFileUpload();
            
            // Set up event listeners
            document.getElementById('refreshBtn').addEventListener('click', refreshData);
            document.getElementById('uploadBtn').addEventListener('click', uploadFile);
            document.getElementById('saveEditBtn').addEventListener('click', saveEdit);
            document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
            
            // Reset form when modal is hidden
            document.getElementById('uploadFileModal').addEventListener('hidden.bs.modal', resetUploadForm);
        });

        // API Functions
        async function apiCall(endpoint, method = 'GET', data = null, isFormData = false) {
            const options = {
                method: method
            };
            
            if (isFormData) {
                options.body = data;
            } else if (data && (method === 'POST' || method === 'DELETE')) {
                options.headers = {
                    'Content-Type': 'application/json',
                };
                options.body = JSON.stringify(data);
            }
            
            try {
                showTableLoading(true);
                const response = await fetch(endpoint, options);
                const result = await response.json();
                return result;
            } catch (error) {
                console.error('API call failed:', error);
                return {
                    success: false,
                    message: 'Network error: ' + error.message
                };
            } finally {
                showTableLoading(false);
            }
        }

        // Setup file upload functionality
        function setupFileUpload() {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('audio_file');
            
            // Click to select file
            uploadArea.addEventListener('click', () => {
                fileInput.click();
            });
            
            // File input change
            fileInput.addEventListener('change', handleFileSelect);
            
            // Drag and drop
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });
            
            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });
            
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                
                if (e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    handleFileSelect();
                }
            });
        }

        // Handle file selection
        function handleFileSelect() {
            const fileInput = document.getElementById('audio_file');
            const file = fileInput.files[0];
            
            if (file) {
                selectedFile = file;
                showFilePreview(file);
                document.getElementById('uploadBtn').disabled = false;
            }
        }

        // Show file preview
        function showFilePreview(file) {
            const preview = document.getElementById('filePreview');
            const fileName = document.getElementById('previewFileName');
            const fileSize = document.getElementById('previewFileSize');
            
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            preview.style.display = 'block';
        }

        // Clear file selection
        function clearFileSelection() {
            const fileInput = document.getElementById('audio_file');
            const preview = document.getElementById('filePreview');
            
            fileInput.value = '';
            selectedFile = null;
            preview.style.display = 'none';
            document.getElementById('uploadBtn').disabled = true;
        }

        // Format file size for display
        function formatFileSize(bytes) {
            if (bytes >= 1073741824) {
                return (bytes / 1073741824).toFixed(2) + ' GB';
            } else if (bytes >= 1048576) {
                return (bytes / 1048576).toFixed(2) + ' MB';
            } else if (bytes >= 1024) {
                return (bytes / 1024).toFixed(2) + ' KB';
            } else {
                return bytes + ' bytes';
            }
        }

        // Initialize DataTable
        function initializeDataTable() {
            filesTable = $('#filesTable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                responsive: true,
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [[0, 'desc']],
                columns: [
                    { data: 'File_id' },
                    { 
                        data: 'File_Name',
                        render: function(data, type, row) {
                            return `<div class="d-flex align-items-center">
                                <i class="fas fa-file-audio text-primary me-2"></i>
                                <strong>${data || 'N/A'}</strong>
                            </div>`;
                        }
                    },
                    { 
                        data: 'File_Size',
                        render: function(data) {
                            return `<span class="badge bg-info">${data || 'Unknown'}</span>`;
                        }
                    },
                    { 
                        data: 'File_Location',
                        render: function(data) {
                            const ext = data.split('.').pop().toLowerCase();
                            if (['wav', 'mp3'].includes(ext)) {
                                return `<audio controls class="audio-player">
                                    <source src="${data}" type="audio/${ext}">
                                    Your browser does not support the audio element.
                                </audio>`;
                            } else {
                                return '<span class="text-muted">Preview not available</span>';
                            }
                        }
                    },
                    { 
                        data: 'File_Location',
                        render: function(data) {
                            return `<small class="text-muted" title="${data}">${data.substring(0, 30)}...</small>`;
                        }
                    },
                    { 
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="action-buttons">
                                <button onclick="editFile(${row.File_id}, '${(row.File_Name || '').replace(/'/g, "\\'")}')" title="Edit File" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="deleteFile(${row.File_id}, '${(row.File_Name || '').replace(/'/g, "\\'")}')" title="Delete File" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>`;
                        },
                        orderable: false
                    }
                ],
                data: [],
                language: {
                    emptyTable: "No audio files found",
                    info: "Showing _START_ to _END_ of _TOTAL_ files",
                    search: "Search files...",
                    zeroRecords: "No matching files found"
                }
            });
            
            loadFilesData();
        }

        // Load files data
        async function loadFilesData() {
            try {
                const result = await apiCall(API_BASE_URL);
                
                if (result.success) {
                    filesTable.clear().rows.add(result.data).draw();
                    showNotification('success', 'Data Loaded', `Loaded ${result.data.length} audio files`);
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading files:', error);
                showNotification('error', 'Error', 'Failed to load files data: ' + error.message);
            }
        }

        // Load statistics
        async function loadStats() {
            try {
                const result = await apiCall(API_BASE_URL + '?action=stats');
                
                if (result.success) {
                    const stats = result.data;
                    document.getElementById('totalFiles').textContent = stats.total_files;
                    document.getElementById('uploadedFiles').textContent = stats.uploaded_files;
                    document.getElementById('wavFiles').textContent = stats.wav_files;
                    document.getElementById('mp3Files').textContent = stats.mp3_files;
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // Upload file
        async function uploadFile() {
            const fileName = document.getElementById('file_name').value.trim();
            
            if (!fileName) {
                showNotification('error', 'Validation Error', 'File name is required');
                return;
            }
            
            if (!selectedFile) {
                showNotification('error', 'Validation Error', 'Please select a file to upload');
                return;
            }

            const formData = new FormData();
            formData.append('file_name', fileName);
            formData.append('audio_file', selectedFile);

            try {
                showTableLoading(true);
                const result = await apiCall(API_BASE_URL, 'POST', formData, true);
                
                if (result.success) {
                    showNotification('success', 'File Uploaded', 'Audio file uploaded successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('uploadFileModal')).hide();
                    resetUploadForm();
                    await refreshData();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error uploading file:', error);
                showNotification('error', 'Error', 'Failed to upload file: ' + error.message);
            }
        }

        // Edit file
        function editFile(id, name) {
            document.getElementById('edit_file_id').value = id;
            document.getElementById('edit_file_name').value = name;
            new bootstrap.Modal(document.getElementById('editFileModal')).show();
        }

        // Save edit
        async function saveEdit() {
            const fileId = document.getElementById('edit_file_id').value;
            const fileName = document.getElementById('edit_file_name').value.trim();

            if (!fileName) {
                showNotification('error', 'Validation Error', 'File name is required');
                return;
            }

            try {
                const result = await apiCall(API_BASE_URL, 'POST', {
                    file_id: fileId,
                    file_name: fileName
                });
                
                if (result.success) {
                    showNotification('success', 'File Updated', 'File name updated successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('editFileModal')).hide();
                    await refreshData();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error updating file:', error);
                showNotification('error', 'Error', 'Failed to update file: ' + error.message);
            }
        }

        // Delete file
        function deleteFile(id, name) {
            fileToDelete = id;
            document.getElementById('fileToDeleteName').textContent = name;
            new bootstrap.Modal(document.getElementById('deleteConfirmationModal')).show();
        }

        // Confirm delete
        async function confirmDelete() {
            if (!fileToDelete) return;
            
            try {
                const result = await apiCall(API_BASE_URL, 'DELETE', { id: fileToDelete });
                
                if (result.success) {
                    showNotification('success', 'File Deleted', 'File deleted successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                    await refreshData();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error deleting file:', error);
                showNotification('error', 'Error', 'Failed to delete file: ' + error.message);
            }
            
            fileToDelete = null;
        }

        // Reset upload form
        function resetUploadForm() {
            document.getElementById('uploadForm').reset();
            clearFileSelection();
            document.getElementById('uploadBtn').disabled = true;
        }

        // Refresh data
        async function refreshData() {
            await Promise.all([loadFilesData(), loadStats()]);
            updateLastUpdatedTime();
            showNotification('info', 'Refreshed', 'Data refreshed successfully');
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
        }
    </script>
</body>
</html>