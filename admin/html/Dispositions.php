<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disposition Management - Call Center</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --info-color: #4895ef;
            --warning-color: #f72585;
            --danger-color: #e63946;
            --executive-color: #7209b7;
            --verifier-color: #f72585;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
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
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
            padding: 30px;
            margin-bottom: 25px;
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
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .page-header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
        }
        
        .nav-tabs {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 25px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            padding: 12px 25px;
            font-weight: 600;
            color: #6c757d;
            border-radius: 10px 10px 0 0;
            margin-right: 5px;
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(67, 97, 238, 0.2);
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 1.3rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e1e5e9;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        .required-field::after {
            content: ' *';
            color: var(--warning-color);
        }
        
        .btn {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }
        
        .btn-action {
            padding: 8px 12px;
            border-radius: 8px;
            margin: 0 3px;
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            transform: scale(1.1);
        }
        
        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
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
            padding: 25px 20px;
            border-radius: 15px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.8rem;
            color: white;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 600;
        }
        
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box .input-group-text {
            background: white;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        
        .search-box .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .filter-section {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            padding: 15px;
        }
        
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 15px 12px;
            font-weight: 600;
        }
        
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-color: #f1f3f4;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .disposition-visual {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            margin-bottom: 20px;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .disposition-visual::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
        }
        
        .feature-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-color);
        }
        
        .feature-toggle label {
            margin-bottom: 0;
            font-weight: 600;
        }
        
        .config-preview {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            border-left: 4px solid var(--primary-color);
        }
        
        .preview-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .preview-content {
            font-family: 'Courier New', monospace;
            background: white;
            padding: 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .drop-action-config {
            background: #e9ecef;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            border-left: 4px solid var(--info-color);
        }
        
        .call-flow-diagram {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            border: 2px solid var(--primary-color);
        }
        
        .flow-step {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid var(--info-color);
        }
        
        .flow-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }
        
        @media (max-width: 768px) {
            .glass-card {
                padding: 20px;
            }
            
            .btn-action {
                margin-bottom: 5px;
                display: block;
                width: 100%;
            }
            
            .table-responsive {
                font-size: 0.85rem;
            }
        }
        
        .select2-container--default .select2-selection--single {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #e1e5e9;
            height: auto;
        }
        
        .connection-line {
            position: relative;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color));
            margin: 30px 0;
            border-radius: 2px;
        }
        
        .connection-line::before, .connection-line::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-color);
            top: -5px;
        }
        
        .connection-line::before {
            left: 0;
        }
        
        .connection-line::after {
            right: 0;
            background: var(--success-color);
        }
        
        .file-upload-box {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-box:hover {
            border-color: var(--primary-color);
            background: #e9ecef;
        }
        
        .file-upload-box i {
            font-size: 2rem;
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .disposition-health {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .health-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .health-good { background: var(--success-color); }
        .health-warning { background: var(--warning-color); }
        .health-critical { background: var(--danger-color); }
        
        .real-time-stats {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 15px;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-label-small {
            font-size: 0.85rem;
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
            border-radius: 0 10px 10px 0;
        }
        
        .selectable-badge {
            width: 80px;
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

    <!-- Disposition Modal -->
    <div class="modal fade" id="dispositionModal" tabindex="-1" aria-labelledby="dispositionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content glass-card" style="background: var(--glass-bg);">
                <div class="modal-header">
                    <h5 class="modal-title" id="dispositionModalLabel">Add New Disposition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dispositionForm">
                        <input type="hidden" id="sno">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label required-field">Status Code</label>
                                    <input type="text" class="form-control" id="status" required maxlength="20" placeholder="e.g., SUCCESS, PENDING">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="statusName" class="form-label required-field">Status Name</label>
                                    <input type="text" class="form-control" id="statusName" required maxlength="30" placeholder="e.g., Call Successful">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="selectable" class="form-label required-field">Selectable</label>
                                    <select class="form-select" id="selectable" required>
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="process" class="form-label required-field">Process</label>
                                    <select class="form-select" id="process" required>
                                        <option value="">Select Process</option>
                                        <option value="Sales">Sales</option>
                                        <option value="Support">Support</option>
                                        <option value="Verification">Verification</option>
                                        <option value="Collections">Collections</option>
                                        <option value="General">General</option>
                                        <option value="All">All Processes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveDispositionBtn">Save Disposition</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <div>
                    <h1 class="h3 mb-1"><i class="fas fa-tags me-2 text-primary"></i>Disposition Management</h1>
                    <p class="text-muted mb-0">Manage call dispositions and status tracking</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dispositionModal">
                    <i class="fas fa-plus me-1"></i> Add New Disposition
                </button>
            </div>
        </div>

        <!-- Real-time Statistics -->
        <div class="real-time-stats">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-value" id="totalDispositions">0</div>
                        <div class="stat-label-small">Total Dispositions</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-value" id="selectableDispositions">0</div>
                        <div class="stat-label-small">Selectable</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-value" id="nonSelectableDispositions">0</div>
                        <div class="stat-label-small">Non-Selectable</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-value" id="processCount">5</div>
                        <div class="stat-label-small">Process Types</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-number text-primary" id="salesDispositions">0</div>
                    <div class="stat-label">Sales Dispositions</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="stat-number text-info" id="supportDispositions">0</div>
                    <div class="stat-label">Support Dispositions</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-number text-warning" id="verificationDispositions">0</div>
                    <div class="stat-label">Verification</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-number text-secondary" id="collectionsDispositions">0</div>
                    <div class="stat-label">Collections</div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search dispositions...">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label small fw-bold">Process</label>
                        <select id="processFilter" class="form-select form-select-sm">
                            <option value="">All Processes</option>
                            <option value="Sales">Sales</option>
                            <option value="Support">Support</option>
                            <option value="Verification">Verification</option>
                            <option value="Collections">Collections</option>
                            <option value="General">General</option>
                            <option value="All">All</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label small fw-bold">Selectable</label>
                        <select id="selectableFilter" class="form-select form-select-sm">
                            <option value="">All</option>
                            <option value="Y">Selectable</option>
                            <option value="N">Non-Selectable</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100 mt-4" onclick="resetFilters()">
                        <i class="fas fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="glass-card">
            <div class="table-responsive">
                <table id="dispositionsTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Status Code</th>
                            <th>Status Name</th>
                            <th>Selectable</th>
                            <th>Process</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="dispositionsTableBody">
                        <!-- Data will be populated by JavaScript -->
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
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Sample data - in a real application, this would come from your database
        let dispositions = [
            { sno: 1, status: "SUCCESS", status_name: "Call Successful", selectable: "Y", process: "Sales" },
            { sno: 2, status: "NOANSWER", status_name: "No Answer", selectable: "Y", process: "Sales" },
            { sno: 3, status: "BUSY", status_name: "Line Busy", selectable: "Y", process: "Sales" },
            { sno: 4, status: "FAILED", status_name: "Call Failed", selectable: "Y", process: "Sales" },
            { sno: 5, status: "RESOLVED", status_name: "Issue Resolved", selectable: "Y", process: "Support" },
            { sno: 6, status: "ESCALATED", status_name: "Escalated to L2", selectable: "Y", process: "Support" },
            { sno: 7, status: "VERIFIED", status_name: "Customer Verified", selectable: "Y", process: "Verification" },
            { sno: 8, status: "NOTVERIFIED", status_name: "Not Verified", selectable: "Y", process: "Verification" },
            { sno: 9, status: "PAYMENT", status_name: "Payment Received", selectable: "Y", process: "Collections" },
            { sno: 10, status: "PROMISE", status_name: "Payment Promise", selectable: "Y", process: "Collections" },
            { sno: 11, status: "REFUSED", status_name: "Payment Refused", selectable: "Y", process: "Collections" },
            { sno: 12, status: "SYSTEM", status_name: "System Status", selectable: "N", process: "General" }
        ];

        // DOM Elements
        const dispositionModal = document.getElementById('dispositionModal');
        const dispositionForm = document.getElementById('dispositionForm');
        const snoInput = document.getElementById('sno');
        const statusInput = document.getElementById('status');
        const statusNameInput = document.getElementById('statusName');
        const selectableInput = document.getElementById('selectable');
        const processInput = document.getElementById('process');
        const saveDispositionBtn = document.getElementById('saveDispositionBtn');
        const dispositionsTableBody = document.getElementById('dispositionsTableBody');
        const searchInput = document.getElementById('searchInput');
        const processFilter = document.getElementById('processFilter');
        const selectableFilter = document.getElementById('selectableFilter');
        const toastContainer = document.getElementById('toastContainer');
        const loadingOverlay = document.getElementById('loadingOverlay');

        // Statistics elements
        const totalDispositionsEl = document.getElementById('totalDispositions');
        const selectableDispositionsEl = document.getElementById('selectableDispositions');
        const nonSelectableDispositionsEl = document.getElementById('nonSelectableDispositions');
        const processCountEl = document.getElementById('processCount');
        const salesDispositionsEl = document.getElementById('salesDispositions');
        const supportDispositionsEl = document.getElementById('supportDispositions');
        const verificationDispositionsEl = document.getElementById('verificationDispositions');
        const collectionsDispositionsEl = document.getElementById('collectionsDispositions');

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderDispositionsTable();
            updateStatistics();
            setupEventListeners();
        });

        function setupEventListeners() {
            // Save disposition button
            saveDispositionBtn.addEventListener('click', function() {
                saveDisposition();
            });

            // Search input
            searchInput.addEventListener('input', function() {
                renderDispositionsTable();
            });

            // Process filter
            processFilter.addEventListener('change', function() {
                renderDispositionsTable();
            });

            // Selectable filter
            selectableFilter.addEventListener('change', function() {
                renderDispositionsTable();
            });
        }

        function renderDispositionsTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedProcess = processFilter.value;
            const selectedSelectable = selectableFilter.value;
            
            let filteredDispositions = dispositions.filter(disposition => {
                const matchesSearch = 
                    disposition.status.toLowerCase().includes(searchTerm) ||
                    disposition.status_name.toLowerCase().includes(searchTerm) ||
                    disposition.process.toLowerCase().includes(searchTerm);
                
                const matchesProcess = selectedProcess === '' || disposition.process === selectedProcess;
                const matchesSelectable = selectedSelectable === '' || disposition.selectable === selectedSelectable;
                
                return matchesSearch && matchesProcess && matchesSelectable;
            });

            dispositionsTableBody.innerHTML = '';

            if (filteredDispositions.length === 0) {
                dispositionsTableBody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No dispositions found</td></tr>';
                return;
            }

            filteredDispositions.forEach(disposition => {
                const row = document.createElement('tr');
                
                // Determine badge class for selectable status
                let selectableBadgeClass = 'bg-success';
                let selectableText = 'Yes';
                if (disposition.selectable === 'N') {
                    selectableBadgeClass = 'bg-secondary';
                    selectableText = 'No';
                }
                
                row.innerHTML = `
                    <td>${disposition.sno}</td>
                    <td><strong>${disposition.status}</strong></td>
                    <td>${disposition.status_name}</td>
                    <td><span class="badge ${selectableBadgeClass} selectable-badge">${selectableText}</span></td>
                    <td><span class="badge bg-primary">${disposition.process}</span></td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-action" onclick="editDisposition(${disposition.sno})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteDisposition(${disposition.sno})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                
                dispositionsTableBody.appendChild(row);
            });
        }

        function updateStatistics() {
            // Update main statistics
            totalDispositionsEl.textContent = dispositions.length;
            
            // Calculate selectable dispositions
            const selectableDispositions = dispositions.filter(d => d.selectable === 'Y');
            selectableDispositionsEl.textContent = selectableDispositions.length;
            
            // Calculate non-selectable dispositions
            const nonSelectableDispositions = dispositions.filter(d => d.selectable === 'N');
            nonSelectableDispositionsEl.textContent = nonSelectableDispositions.length;
            
            // Calculate process-specific statistics
            const salesDispositions = dispositions.filter(d => d.process === 'Sales');
            salesDispositionsEl.textContent = salesDispositions.length;
            
            const supportDispositions = dispositions.filter(d => d.process === 'Support');
            supportDispositionsEl.textContent = supportDispositions.length;
            
            const verificationDispositions = dispositions.filter(d => d.process === 'Verification');
            verificationDispositionsEl.textContent = verificationDispositions.length;
            
            const collectionsDispositions = dispositions.filter(d => d.process === 'Collections');
            collectionsDispositionsEl.textContent = collectionsDispositions.length;
            
            // Calculate unique process count
            const uniqueProcesses = [...new Set(dispositions.map(d => d.process))];
            processCountEl.textContent = uniqueProcesses.length;
        }

        function saveDisposition() {
            const id = snoInput.value ? parseInt(snoInput.value) : null;
            const status = statusInput.value.trim();
            const statusName = statusNameInput.value.trim();
            const selectable = selectableInput.value;
            const process = processInput.value;
            
            if (!status || !statusName || !selectable || !process) {
                showToast('Please fill in all required fields!', 'danger');
                return;
            }
            
            if (id) {
                // Update existing disposition
                const index = dispositions.findIndex(d => d.sno === id);
                if (index !== -1) {
                    dispositions[index] = {
                        sno: id,
                        status: status,
                        status_name: statusName,
                        selectable: selectable,
                        process: process
                    };
                    showToast('Disposition updated successfully!', 'success');
                }
            } else {
                // Add new disposition
                const newId = dispositions.length > 0 ? Math.max(...dispositions.map(d => d.sno)) + 1 : 1;
                dispositions.push({
                    sno: newId,
                    status: status,
                    status_name: statusName,
                    selectable: selectable,
                    process: process
                });
                showToast('Disposition added successfully!', 'success');
            }
            
            // Close modal and reset form
            const modal = bootstrap.Modal.getInstance(dispositionModal);
            modal.hide();
            resetForm();
            
            // Update UI
            renderDispositionsTable();
            updateStatistics();
        }

        function editDisposition(id) {
            const disposition = dispositions.find(d => d.sno === id);
            if (!disposition) return;
            
            snoInput.value = disposition.sno;
            statusInput.value = disposition.status;
            statusNameInput.value = disposition.status_name;
            selectableInput.value = disposition.selectable;
            processInput.value = disposition.process;
            
            // Update modal title
            document.getElementById('dispositionModalLabel').textContent = 'Edit Disposition';
            
            // Show modal
            const modal = new bootstrap.Modal(dispositionModal);
            modal.show();
        }

        function deleteDisposition(id) {
            if (confirm('Are you sure you want to delete this disposition?')) {
                dispositions = dispositions.filter(d => d.sno !== id);
                renderDispositionsTable();
                updateStatistics();
                showToast('Disposition deleted successfully!', 'success');
            }
        }

        function resetForm() {
            dispositionForm.reset();
            snoInput.value = '';
            document.getElementById('dispositionModalLabel').textContent = 'Add New Disposition';
        }

        function resetFilters() {
            searchInput.value = '';
            processFilter.value = '';
            selectableFilter.value = '';
            renderDispositionsTable();
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

        // Initialize DataTables
        $(document).ready(function() {
            $('#dispositionsTable').DataTable({
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                responsive: true,
                autoWidth: false,
                order: [[0, 'asc']]
            });
        });
    </script>
</body>
</html>