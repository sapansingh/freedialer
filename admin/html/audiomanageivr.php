<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Files Management - IVR System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #8e44ad;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
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
            background: linear-gradient(135deg, #8e44ad, #9b59b6);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 32px rgba(142, 68, 173, 0.3);
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
            background: linear-gradient(135deg, #8e44ad, #9b59b6);
            color: white;
        }
        
        .stat-card.gsm {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        
        .stat-card.wav {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
        }
        
        .stat-card.size {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #8e44ad, #9b59b6);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(142, 68, 173, 0.4);
        }
        
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            margin: 0 2px;
            border-radius: 6px;
        }
        
        .file-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 50px;
        }
        
        .badge-gsm {
            background-color: #3498db;
        }
        
        .badge-wav {
            background-color: #2ecc71;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(142, 68, 173, 0.05);
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
            color: #8e44ad;
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
            border-color: #8e44ad;
            box-shadow: 0 0 0 0.2rem rgba(142, 68, 173, 0.25);
        }
        
        .filter-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .filter-select:focus {
            border-color: #8e44ad;
            box-shadow: 0 0 0 0.2rem rgba(142, 68, 173, 0.25);
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
            color: #8e44ad;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #8e44ad;
            border-color: #8e44ad;
        }
        
        .file-upload-area {
            border: 2px dashed #8e44ad;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            background-color: rgba(142, 68, 173, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .file-upload-area:hover {
            background-color: rgba(142, 68, 173, 0.1);
            border-color: #9b59b6;
        }
        
        .file-upload-area.dragover {
            background-color: rgba(142, 68, 173, 0.2);
            border-color: #8e44ad;
        }
        
        .file-preview {
            max-width: 100%;
            margin-top: 15px;
            display: none;
        }
        
        .audio-player {
            width: 100%;
            margin-top: 10px;
            border-radius: 8px;
        }
        
        .file-size {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .file-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }
        
        .upload-progress {
            height: 8px;
            border-radius: 4px;
            margin-top: 10px;
            display: none;
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
                    <h1 class="h3 mb-1"><i class="fas fa-music me-2"></i>Audio Files Management</h1>
                    <p class="mb-0 opacity-75">Manage IVR audio files and upload new recordings</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fas fa-upload me-1"></i> Upload Audio File
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card total">
                    <h6 class="text-white-50 mb-1">Total Files</h6>
                    <h3 class="text-white" id="totalFiles">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card gsm">
                    <h6 class="text-white-50 mb-1">GSM Files</h6>
                    <h3 class="text-white" id="gsmFiles">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card wav">
                    <h6 class="text-white-50 mb-1">WAV Files</h6>
                    <h3 class="text-white" id="wavFiles">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card size">
                    <h6 class="text-white-50 mb-1">Total Size</h6>
                    <h3 class="text-white" id="totalSize">0 MB</h3>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control search-box border-start-0" placeholder="Search audio files...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="typeFilter" class="form-select filter-select">
                        <option value="">All File Types</option>
                        <option value="gsm">GSM</option>
                        <option value="wav">WAV</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="sizeFilter" class="form-select filter-select">
                        <option value="">All Sizes</option>
                        <option value="small">Small (&lt; 1MB)</option>
                        <option value="medium">Medium (1-5MB)</option>
                        <option value="large">Large (&gt; 5MB)</option>
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
                <table id="audioFilesTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>SNO</th>
                            <th>File Name</th>
                            <th>File Size</th>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Uploaded</th>
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

    <!-- Upload Modal Form -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-upload me-2"></i>Upload Audio File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm">
                        <div class="section-title">File Information</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="file_name" class="form-label required-field">File Name</label>
                                    <input type="text" class="form-control" id="file_name" name="file_name" required placeholder="e.g., welcome_message">
                                    <div class="form-text">Name for the audio file (without extension)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="file_type" class="form-label required-field">File Type</label>
                                    <select class="form-select" id="file_type" name="file_type" required>
                                        <option value="">Select file type</option>
                                        <option value="gsm">GSM</option>
                                        <option value="wav">WAV</option>
                                    </select>
                                    <div class="form-text">Select the audio file format</div>
                                </div>
                            </div>
                        </div>

                        <div class="section-title">File Upload</div>
                        <div class="file-upload-area" id="fileUploadArea">
                            <div id="uploadPlaceholder">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                <h5>Drag & Drop Audio File Here</h5>
                                <p class="text-muted">Supported formats: GSM, WAV</p>
                                <p class="text-muted">Maximum file size: 10MB</p>
                                <button type="button" class="btn btn-primary-custom mt-2" onclick="document.getElementById('audio_file').click()">
                                    <i class="fas fa-folder-open me-1"></i> Browse Files
                                </button>
                            </div>
                            <input type="file" id="audio_file" name="audio_file" accept=".gsm,.wav,.audio/*" style="display: none;" onchange="handleFileSelect(this.files)">
                            
                            <div id="filePreview" class="file-preview">
                                <div class="file-info">
                                    <h6 id="selectedFileName" class="mb-1"></h6>
                                    <p class="file-size mb-2" id="selectedFileSize"></p>
                                    <audio id="audioPreview" class="audio-player" controls></audio>
                                </div>
                                <div class="progress upload-progress" id="uploadProgress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" onclick="uploadFile()" id="uploadButton" disabled>
                        <i class="fas fa-upload me-1"></i> Upload File
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View File Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Audio File Details</h5>
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
        const API_BASE_URL = '../api/audio_files/'; // Adjust this to your API endpoint

        // Initialize DataTable
        let audioFilesTable;
        $(document).ready(function() {
            audioFilesTable = $('#audioFilesTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search audio files...",
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
                    { data: 'sno' },
                    { data: 'file_name' },
                    { 
                        data: 'file_size',
                        render: function(data, type, row) {
                            return formatFileSize(data);
                        }
                    },
                    { 
                        data: 'file_type',
                        render: function(data, type, row) {
                            return data === 'gsm' 
                                ? '<span class="badge badge-gsm file-badge"><i class="fas fa-file-audio me-1"></i>GSM</span>' 
                                : '<span class="badge badge-wav file-badge"><i class="fas fa-file-audio me-1"></i>WAV</span>';
                        }
                    },
                    { 
                        data: 'duration',
                        render: function(data, type, row) {
                            return data ? formatDuration(data) : 'N/A';
                        }
                    },
                    { 
                        data: 'uploaded_at',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString() : 'N/A';
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-outline-primary btn-action" onclick="playAudio(${data})" title="Play">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="btn btn-outline-info btn-action" onclick="viewFile(${data})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-action" onclick="deleteFile(${data})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-outline-success btn-action" onclick="downloadFile(${data})" title="Download">
                                    <i class="fas fa-download"></i>
                                </button>
                            `;
                        },
                        orderable: false
                    }
                ]
            });

            // Load initial data
            loadAudioFiles();
            setupDragAndDrop();
        });

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // Setup drag and drop functionality
        function setupDragAndDrop() {
            const dropArea = document.getElementById('fileUploadArea');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropArea.classList.add('dragover');
            }
            
            function unhighlight() {
                dropArea.classList.remove('dragover');
            }
            
            dropArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFileSelect(files);
            }
        }

        // Handle file selection
        function handleFileSelect(files) {
            if (files.length > 0) {
                const file = files[0];
                
                // Validate file type
                const validTypes = ['audio/gsm', 'audio/wav', 'audio/x-wav', 'audio/wave'];
                const fileExtension = file.name.split('.').pop().toLowerCase();
                
                if (!validTypes.includes(file.type) && !['gsm', 'wav'].includes(fileExtension)) {
                    showNotification('Please select a valid audio file (GSM or WAV format)', 'danger');
                    return;
                }
                
                // Validate file size (max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    showNotification('File size exceeds 10MB limit', 'danger');
                    return;
                }
                
                // Update UI
                document.getElementById('uploadPlaceholder').style.display = 'none';
                document.getElementById('filePreview').style.display = 'block';
                document.getElementById('selectedFileName').textContent = file.name;
                document.getElementById('selectedFileSize').textContent = `Size: ${formatFileSize(file.size)}`;
                
                // Set file type based on extension
                const fileType = fileExtension === 'gsm' ? 'gsm' : 'wav';
                document.getElementById('file_type').value = fileType;
                
                // Set file name without extension
                const fileName = file.name.replace(/\.[^/.]+$/, "");
                document.getElementById('file_name').value = fileName;
                
                // Preview audio if possible
                const audioPreview = document.getElementById('audioPreview');
                if (fileExtension === 'wav') {
                    const objectUrl = URL.createObjectURL(file);
                    audioPreview.src = objectUrl;
                } else {
                    audioPreview.style.display = 'none';
                    document.querySelector('.file-info').innerHTML += `
                        <div class="alert alert-info mt-2">
                            <i class="fas fa-info-circle me-1"></i> GSM files cannot be previewed in browser
                        </div>
                    `;
                }
                
                // Enable upload button
                document.getElementById('uploadButton').disabled = false;
            }
        }

        // API Functions
        async function loadAudioFiles() {
            showLoading(true);
            try {
                // In a real implementation, this would fetch from your API
                // For demo purposes, we'll use mock data
                const mockData = {
                    success: true,
                    data: [
                        {
                            id: 1,
                            sno: 1,
                            file_name: 'welcome_message',
                            file_size: 102400, // 100KB
                            file_type: 'gsm',
                            duration: 15, // seconds
                            uploaded_at: '2023-06-15 10:30:00'
                        },
                        {
                            id: 2,
                            sno: 2,
                            file_name: 'main_menu',
                            file_size: 204800, // 200KB
                            file_type: 'wav',
                            duration: 25,
                            uploaded_at: '2023-06-16 14:45:00'
                        },
                        {
                            id: 3,
                            sno: 3,
                            file_name: 'thank_you',
                            file_size: 51200, // 50KB
                            file_type: 'gsm',
                            duration: 8,
                            uploaded_at: '2023-06-17 09:15:00'
                        },
                        {
                            id: 4,
                            sno: 4,
                            file_name: 'error_message',
                            file_size: 307200, // 300KB
                            file_type: 'wav',
                            duration: 12,
                            uploaded_at: '2023-06-18 16:20:00'
                        }
                    ]
                };
                
                // Simulate API delay
                setTimeout(() => {
                    if (mockData.success) {
                        audioFilesTable.clear().rows.add(mockData.data).draw();
                        updateStatistics(mockData.data);
                    } else {
                        showNotification('Failed to load audio files', 'danger');
                    }
                    showLoading(false);
                }, 800);
                
            } catch (error) {
                console.error('Error loading audio files:', error);
                showNotification('Error loading audio files. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function uploadFile() {
            const fileName = document.getElementById('file_name').value.trim();
            const fileType = document.getElementById('file_type').value;
            const fileInput = document.getElementById('audio_file');
            
            if (!fileName) {
                showNotification('Please enter a file name', 'danger');
                return;
            }
            
            if (!fileType) {
                showNotification('Please select a file type', 'danger');
                return;
            }
            
            if (!fileInput.files.length) {
                showNotification('Please select a file to upload', 'danger');
                return;
            }

            showLoading(true);
            const progressBar = document.querySelector('#uploadProgress .progress-bar');
            progressBar.style.width = '0%';
            document.getElementById('uploadProgress').style.display = 'block';
            
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate upload progress
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 5;
                    progressBar.style.width = `${progress}%`;
                    
                    if (progress >= 100) {
                        clearInterval(interval);
                        
                        // Simulate API response
                        const mockResponse = {
                            success: true,
                            message: 'File uploaded successfully!'
                        };
                        
                        setTimeout(() => {
                            showLoading(false);
                            if (mockResponse.success) {
                                showNotification(mockResponse.message, 'success');
                                loadAudioFiles();
                                
                                // Close modal and reset form
                                bootstrap.Modal.getInstance(document.getElementById('uploadModal')).hide();
                                resetUploadForm();
                            } else {
                                showNotification('Failed to upload file', 'danger');
                            }
                        }, 500);
                    }
                }, 100);
                
            } catch (error) {
                console.error('Error uploading file:', error);
                showNotification('Error uploading file. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function deleteFile(id) {
            if (!confirm('Are you sure you want to delete this audio file?')) {
                return;
            }

            showLoading(true);
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate a successful response
                const mockResponse = {
                    success: true,
                    message: 'File deleted successfully!'
                };
                
                // Simulate API delay
                setTimeout(() => {
                    showLoading(false);
                    if (mockResponse.success) {
                        showNotification(mockResponse.message, 'success');
                        loadAudioFiles();
                    } else {
                        showNotification('Failed to delete file', 'danger');
                    }
                }, 800);
            } catch (error) {
                console.error('Error deleting file:', error);
                showNotification('Error deleting file. Please check console.', 'danger');
                showLoading(false);
            }
        }

        // UI Functions
        function playAudio(id) {
            // In a real implementation, this would play the audio file
            showNotification('Playing audio file...', 'info');
        }

        async function viewFile(id) {
            // In a real implementation, this would fetch file details from API
            const mockFile = {
                id: id,
                file_name: 'sample_file_' + id,
                file_size: 102400 + (id * 51200),
                file_type: id % 2 === 0 ? 'wav' : 'gsm',
                duration: 10 + (id * 5),
                uploaded_at: '2023-06-15 10:30:00',
                file_path: '/audio/files/sample_' + id + (id % 2 === 0 ? '.wav' : '.gsm')
            };

            // Create details HTML
            const detailsHtml = `
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6 class="text-muted">File Information</h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>File ID:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${mockFile.id}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>File Name:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${mockFile.file_name}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>File Size:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${formatFileSize(mockFile.file_size)}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>File Type:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${mockFile.file_type === 'gsm' 
                            ? '<span class="badge badge-gsm">GSM</span>' 
                            : '<span class="badge badge-wav">WAV</span>'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Duration:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${formatDuration(mockFile.duration)}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Uploaded At:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${new Date(mockFile.uploaded_at).toLocaleString()}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>File Path:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        <code>${mockFile.file_path}</code>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <button class="btn btn-primary-custom me-2" onclick="playAudio(${mockFile.id})">
                        <i class="fas fa-play me-1"></i> Play Audio
                    </button>
                    <button class="btn btn-success" onclick="downloadFile(${mockFile.id})">
                        <i class="fas fa-download me-1"></i> Download
                    </button>
                </div>
            `;

            // Populate modal body
            document.getElementById('viewModalBody').innerHTML = detailsHtml;

            // Show modal
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }

        function downloadFile(id) {
            // In a real implementation, this would download the file
            showNotification('Downloading file...', 'info');
        }

        function updateStatistics(files) {
            const total = files.length;
            const gsmFiles = files.filter(f => f.file_type === 'gsm').length;
            const wavFiles = total - gsmFiles;
            const totalSize = files.reduce((sum, file) => sum + file.file_size, 0);
            
            document.getElementById('totalFiles').textContent = total;
            document.getElementById('gsmFiles').textContent = gsmFiles;
            document.getElementById('wavFiles').textContent = wavFiles;
            document.getElementById('totalSize').textContent = formatFileSize(totalSize, true);
        }

        // Utility Functions
        function formatFileSize(bytes, short = false) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = short ? ['B', 'KB', 'MB', 'GB'] : ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function formatDuration(seconds) {
            if (!seconds) return 'N/A';
            
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        function resetUploadForm() {
            document.getElementById('uploadForm').reset();
            document.getElementById('uploadPlaceholder').style.display = 'block';
            document.getElementById('filePreview').style.display = 'none';
            document.getElementById('uploadProgress').style.display = 'none';
            document.getElementById('uploadButton').disabled = true;
        }

        // Search functionality
        $('#searchInput').on('keyup', function() {
            audioFilesTable.search(this.value).draw();
        });

        // Filter by file type
        $('#typeFilter').on('change', function() {
            audioFilesTable.column(3).search(this.value).draw();
        });

        // Filter by file size
        $('#sizeFilter').on('change', function() {
            // This would need custom filtering logic based on actual file sizes
            audioFilesTable.draw();
        });

        function resetFilters() {
            $('#searchInput').val('');
            $('#typeFilter').val('');
            $('#sizeFilter').val('');
            audioFilesTable.search('').columns().search('').draw();
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
        document.getElementById('uploadModal').addEventListener('hidden.bs.modal', function() {
            resetUploadForm();
        });
    </script>
</body>
</html>