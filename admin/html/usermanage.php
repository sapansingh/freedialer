<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Agent Details</title>
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
        
        .user-type-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
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
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--success-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .permission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .permission-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
        }
        
        .permission-item .form-check {
            margin-bottom: 0;
        }
        
        .call-mode-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .call-mode-process { background: var(--success-color); }
        .call-mode-inbound { background: var(--info-color); }
        .call-mode-outbound { background: var(--warning-color); }
        
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
            
            .permission-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .select2-container--default .select2-selection--single {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #e1e5e9;
            height: auto;
        }
        
        .select2-container--default .select2-selection--multiple {
            border-radius: 10px;
            border: 1px solid #e1e5e9;
        }
        
        .user-profile-preview {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 15px;
            color: white;
            margin-bottom: 20px;
        }
        
        .user-profile-preview .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2rem;
            border: 3px solid white;
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

    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <div>
                    <h1 class="h3 mb-1"><i class="fas fa-users-cog me-2 text-primary"></i>User Management</h1>
                    <p class="text-muted mb-0">Manage agents, supervisors, and administrators</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                    <i class="fas fa-user-plus me-1"></i> Add New User
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number text-primary" id="totalUsers">0</div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="stat-number text-info" id="activeAgents">0</div>
                    <div class="stat-label">Active Agents</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="stat-number text-warning" id="supervisors">0</div>
                    <div class="stat-label">Supervisors</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-number text-secondary" id="admins">0</div>
                    <div class="stat-label">Administrators</div>
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
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search users...">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label small fw-bold">Status Filter</label>
                        <select id="statusFilter" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="Y">Active</option>
                            <option value="N">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label small fw-bold">User Type</label>
                        <select id="typeFilter" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="ADMIN">Administrator</option>
                            <option value="SUPERVISOR">Supervisor</option>
                            <option value="MIS">MIS</option>
                            <option value="AGENT">Agent</option>
                            <option value="SUPPORT">Support</option>
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
                <table id="usersTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Agent ID</th>
                            <th>Extension</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th>Call Mode</th>
                            <th>Groups</th>
                            <th>Phone</th>
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

    <!-- User Modal Form -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-user-plus me-2"></i>Add New User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                <i class="fas fa-user me-1"></i> Basic Info
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab">
                                <i class="fas fa-shield-alt me-1"></i> Permissions
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="call-settings-tab" data-bs-toggle="tab" data-bs-target="#call-settings" type="button" role="tab">
                                <i class="fas fa-phone me-1"></i> Call Settings
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" type="button" role="tab">
                                <i class="fas fa-cogs me-1"></i> Advanced
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-4" id="userTabsContent">
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <form id="userForm">
                                <input type="hidden" id="sno" name="sno">
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-id-card"></i> User Identification
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="agent_id" class="form-label required-field">Agent ID</label>
                                                        <input type="text" class="form-control" id="agent_id" name="agent_id" required maxlength="15" placeholder="e.g., AG001">
                                                        <small class="form-text text-muted">Unique identifier for the agent</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="agent_name" class="form-label required-field">Full Name</label>
                                                        <input type="text" class="form-control" id="agent_name" name="agent_name" required maxlength="50" placeholder="e.g., John Smith">
                                                        <small class="form-text text-muted">Agent's full name</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password" class="form-label required-field">Password</label>
                                                        <input type="password" class="form-control" id="password" name="password" required maxlength="20" placeholder="Enter password">
                                                        <small class="form-text text-muted">Login password</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="extension" class="form-label required-field">Extension</label>
                                                        <input type="text" class="form-control" id="extension" name="extension" required maxlength="10" placeholder="e.g., 1001">
                                                        <small class="form-text text-muted">Phone extension number</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-users"></i> Group & Access
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="groups" class="form-label">Groups</label>
                                                        <input type="text" class="form-control" id="groups" name="groups" maxlength="20" placeholder="e.g., Sales, Support">
                                                        <small class="form-text text-muted">User groups</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="user_type" class="form-label required-field">User Type</label>
                                                        <select class="form-select" id="user_type" name="user_type" required onchange="togglePermissions()">
                                                            <option value="AGENT">Agent</option>
                                                            <option value="SUPERVISOR">Supervisor</option>
                                                            <option value="ADMIN">Administrator</option>
                                                            <option value="MIS">MIS</option>
                                                            <option value="SUPPORT">Support</option>
                                                        </select>
                                                        <small class="form-text text-muted">User role and permissions level</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="process" class="form-label">Process</label>
                                                        <textarea class="form-control" id="process" name="process" rows="3" placeholder="Process description"></textarea>
                                                        <small class="form-text text-muted">Assigned process or campaign</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="assigned_queues" class="form-label">Assigned Queues</label>
                                                        <textarea class="form-control" id="assigned_queues" name="assigned_queues" rows="3" placeholder="Queue names"></textarea>
                                                        <small class="form-text text-muted">Call queues assigned to this user</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="user-profile-preview">
                                            <div class="avatar" id="userAvatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <h5 id="previewName">User Name</h5>
                                            <div class="badge bg-light text-dark mb-2" id="previewType">AGENT</div>
                                            <div class="small">
                                                <div>ID: <span id="previewId">AG001</span></div>
                                                <div>Ext: <span id="previewExt">1001</span></div>
                                                <div>Status: <span id="previewStatus" class="badge bg-success">Active</span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-server"></i> System Settings
                                            </div>
                                            <div class="form-group">
                                                <label for="server_ip" class="form-label">Server IP</label>
                                                <input type="text" class="form-control" id="server_ip" name="server_ip" maxlength="20" placeholder="e.g., 192.168.1.100">
                                                <small class="form-text text-muted">Assigned server IP address</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="call_priority" class="form-label">Call Priority</label>
                                                <input type="number" class="form-control" id="call_priority" name="call_priority" value="0" min="0" max="100">
                                                <small class="form-text text-muted">Call handling priority (0-100)</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="active" class="form-label required-field">Status</label>
                                                <select class="form-select" id="active" name="active" required>
                                                    <option value="Y">Active</option>
                                                    <option value="N">Inactive</option>
                                                </select>
                                                <small class="form-text text-muted">User account status</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="permissions" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-user-shield"></i> Access Permissions
                                </div>
                                
                                <div class="permission-grid">
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allow_manual_dial" name="allow_manual_dial" value="Y">
                                            <label class="form-check-label" for="allow_manual_dial">Manual Dial</label>
                                        </div>
                                        <small class="text-muted">Allow manual number dialing</small>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allow_transfer" name="allow_transfer" value="Y">
                                            <label class="form-check-label" for="allow_transfer">Call Transfer</label>
                                        </div>
                                        <small class="text-muted">Allow call transfer to other agents</small>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="click_to_call" name="click_to_call" value="Y" checked>
                                            <label class="form-check-label" for="click_to_call">Click to Call</label>
                                        </div>
                                        <small class="text-muted">Enable click-to-call functionality</small>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="edit_record" name="edit_record" value="Y" checked>
                                            <label class="form-check-label" for="edit_record">Edit Records</label>
                                        </div>
                                        <small class="text-muted">Allow editing call records</small>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="manual_outbound" name="manual_outbound" value="Y">
                                            <label class="form-check-label" for="manual_outbound">Manual Outbound</label>
                                        </div>
                                        <small class="text-muted">Allow manual outbound calls</small>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="show_recent_calls" name="show_recent_calls" value="Y" checked>
                                            <label class="form-check-label" for="show_recent_calls">Recent Calls</label>
                                        </div>
                                        <small class="text-muted">Show recent call history</small>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allow_offline_crm" name="allow_offline_crm" value="Y">
                                            <label class="form-check-label" for="allow_offline_crm">Offline CRM</label>
                                        </div>
                                        <small class="text-muted">Allow offline CRM access</small>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allow_remotelogin" name="allow_remotelogin" value="Y">
                                            <label class="form-check-label" for="allow_remotelogin">Remote Login</label>
                                        </div>
                                        <small class="text-muted">Allow remote system login</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-phone"></i> Callback Permissions
                                </div>
                                
                                <div class="permission-grid">
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="agent_only_callbacks" name="agent_only_callbacks" value="Y" checked>
                                            <label class="form-check-label" for="agent_only_callbacks">Agent Callbacks</label>
                                        </div>
                                        <small class="text-muted">Allow agent-only callbacks</small>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allow_anyone_callbacks" name="allow_anyone_callbacks" value="Y">
                                            <label class="form-check-label" for="allow_anyone_callbacks">Anyone Callbacks</label>
                                        </div>
                                        <small class="text-muted">Allow callbacks by anyone</small>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allow_auto_callbacks" name="allow_auto_callbacks" value="Y">
                                            <label class="form-check-label" for="allow_auto_callbacks">Auto Callbacks</label>
                                        </div>
                                        <small class="text-muted">Allow automatic callbacks</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="call-settings" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-sliders-h"></i> Call Handling Settings
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="call_mode" class="form-label required-field">Call Mode</label>
                                            <select class="form-select" id="call_mode" name="call_mode" required>
                                                <option value="processmode">Process Mode</option>
                                                <option value="inbound">Inbound</option>
                                                <option value="outbound">Outbound</option>
                                            </select>
                                            <small class="form-text text-muted">Primary call handling mode</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="call_allowed" class="form-label">Call Types Allowed</label>
                                            <select class="form-select" id="call_allowed" name="call_allowed">
                                                <option value="Local">Local Only</option>
                                                <option value="STD">STD</option>
                                                <option value="All">All Calls</option>
                                            </select>
                                            <small class="form-text text-muted">Types of calls allowed</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number" maxlength="50" placeholder="e.g., +1-555-0123">
                                            <small class="form-text text-muted">User's phone number</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="remote_server_ip" class="form-label">Remote Server IP</label>
                                            <input type="text" class="form-control" id="remote_server_ip" name="remote_server_ip" maxlength="20" placeholder="e.g., 192.168.1.200">
                                            <small class="form-text text-muted">Remote server for login</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="advanced" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-code"></i> Custom Access Settings
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="user_access" class="form-label">Custom Access Rules</label>
                                            <textarea class="form-control" id="user_access" name="user_access" rows="8" placeholder="Enter custom access rules in JSON or key-value format..."></textarea>
                                            <small class="form-text text-muted">Custom access permissions and restrictions</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">
                        <i class="fas fa-save me-1"></i> Save User
                    </button>
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
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // API Configuration
        const API_BASE_URL = 'api/users/'; // Adjust this to your API endpoint
        
        // Sample data for demonstration
        let sampleUsers = [
            {
                sno: 1,
                agent_id: 'AG001',
                agent_name: 'John Smith',
                password: 'password123',
                extension: '1001',
                groups: 'Sales',
                user_access: '{"reports": true, "export": true}',
                user_type: 'AGENT',
                process: 'Sales Campaign',
                active: 'Y',
                call_priority: 5,
                server_ip: '192.168.1.100',
                assigned_queues: 'sales, support',
                call_mode: 'outbound',
                allow_manual_dial: 'N',
                agent_only_callbacks: 'Y',
                allow_anyone_callbacks: 'N',
                allow_auto_callbacks: 'N',
                show_recent_calls: 'Y',
                click_to_call: 'Y',
                edit_record: 'Y',
                manual_outbound: 'N',
                call_allowed: 'Local',
                allow_transfer: 'N',
                entry_date: '2024-01-15 10:30:00',
                allow_offline_crm: 'N',
                allow_remotelogin: 'N',
                phone_number: '+1-555-0101',
                remote_server_ip: ''
            },
            {
                sno: 2,
                agent_id: 'SUP001',
                agent_name: 'Sarah Johnson',
                password: 'admin123',
                extension: '2001',
                groups: 'Management',
                user_access: '{"reports": true, "monitor": true, "export": true}',
                user_type: 'SUPERVISOR',
                process: 'Team Management',
                active: 'Y',
                call_priority: 10,
                server_ip: '192.168.1.100',
                assigned_queues: 'sales, support, billing',
                call_mode: 'inbound',
                allow_manual_dial: 'Y',
                agent_only_callbacks: 'Y',
                allow_anyone_callbacks: 'Y',
                allow_auto_callbacks: 'Y',
                show_recent_calls: 'Y',
                click_to_call: 'Y',
                edit_record: 'Y',
                manual_outbound: 'Y',
                call_allowed: 'All',
                allow_transfer: 'Y',
                entry_date: '2024-01-10 09:15:00',
                allow_offline_crm: 'Y',
                allow_remotelogin: 'Y',
                phone_number: '+1-555-0102',
                remote_server_ip: '192.168.1.200'
            },
            {
                sno: 3,
                agent_id: 'ADM001',
                agent_name: 'Michael Brown',
                password: 'securepass',
                extension: '3001',
                groups: 'IT',
                user_access: '{"all": true}',
                user_type: 'ADMIN',
                process: 'System Administration',
                active: 'Y',
                call_priority: 15,
                server_ip: '192.168.1.100',
                assigned_queues: 'all',
                call_mode: 'processmode',
                allow_manual_dial: 'Y',
                agent_only_callbacks: 'Y',
                allow_anyone_callbacks: 'Y',
                allow_auto_callbacks: 'Y',
                show_recent_calls: 'Y',
                click_to_call: 'Y',
                edit_record: 'Y',
                manual_outbound: 'Y',
                call_allowed: 'All',
                allow_transfer: 'Y',
                entry_date: '2024-01-05 08:00:00',
                allow_offline_crm: 'Y',
                allow_remotelogin: 'Y',
                phone_number: '+1-555-0103',
                remote_server_ip: '192.168.1.200'
            }
        ];

        // Initialize DataTable
        let usersTable;
        $(document).ready(function() {
            // Initialize Select2
            $('.form-select').select2({
                width: '100%',
                theme: 'bootstrap-5'
            });
            
            usersTable = $('#usersTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search users..."
                },
                columns: [
                    { data: 'sno' },
                    { 
                        data: null,
                        render: function(data, type, row) {
                            const initials = row.agent_name.split(' ').map(n => n[0]).join('').toUpperCase();
                            return `
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">${initials}</div>
                                    <div>
                                        <div class="fw-bold">${row.agent_name}</div>
                                        <small class="text-muted">${row.groups || 'No Group'}</small>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    { data: 'agent_id' },
                    { data: 'extension' },
                    { 
                        data: 'user_type',
                        render: function(data, type, row) {
                            let badgeClass = 'bg-primary';
                            if (data === 'SUPERVISOR') badgeClass = 'bg-warning';
                            if (data === 'ADMIN') badgeClass = 'bg-danger';
                            if (data === 'MIS') badgeClass = 'bg-info';
                            if (data === 'SUPPORT') badgeClass = 'bg-secondary';
                            
                            return `<span class="user-type-badge ${badgeClass}">${data}</span>`;
                        }
                    },
                    { 
                        data: 'active',
                        render: function(data, type, row) {
                            return data === 'Y' 
                                ? '<span class="status-badge bg-success">Active</span>' 
                                : '<span class="status-badge bg-danger">Inactive</span>';
                        }
                    },
                    { 
                        data: 'call_mode',
                        render: function(data, type, row) {
                            let modeClass = 'call-mode-process';
                            let modeText = 'Process';
                            if (data === 'inbound') {
                                modeClass = 'call-mode-inbound';
                                modeText = 'Inbound';
                            } else if (data === 'outbound') {
                                modeClass = 'call-mode-outbound';
                                modeText = 'Outbound';
                            }
                            
                            return `<span><span class="${modeClass}"></span>${modeText}</span>`;
                        }
                    },
                    { data: 'groups' },
                    { data: 'phone_number' },
                    {
                        data: 'sno',
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-action" onclick="editUser(${data})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-info btn-action" onclick="viewUser(${data})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning btn-action" onclick="resetPassword(${data})" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-action" onclick="deleteUser(${data})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        },
                        orderable: false
                    }
                ]
            });

            // Load initial data
            loadUsers();
            
            // Initialize form event listeners
            initializeFormListeners();
        });

        // Initialize form event listeners for real-time updates
        function initializeFormListeners() {
            // Update preview when form fields change
            $('#agent_name, #agent_id, #extension, #user_type, #active').on('input change', function() {
                updateUserPreview();
            });
            
            // Toggle permissions based on user type
            $('#user_type').on('change', function() {
                togglePermissions();
            });
        }

        // Toggle permissions based on user type
        function togglePermissions() {
            const userType = $('#user_type').val();
            
            // Enable/disable permissions based on user type
            if (userType === 'ADMIN') {
                // Admins get all permissions
                $('.form-check-input').prop('checked', true).prop('disabled', false);
            } else if (userType === 'SUPERVISOR') {
                // Supervisors get most permissions
                $('.form-check-input').prop('checked', true).prop('disabled', false);
                $('#manual_outbound').prop('checked', false);
            } else if (userType === 'AGENT') {
                // Agents get limited permissions
                $('.form-check-input').prop('checked', false).prop('disabled', false);
                $('#click_to_call, #edit_record, #show_recent_calls, #agent_only_callbacks').prop('checked', true);
            } else {
                // Other types - enable all but uncheck by default
                $('.form-check-input').prop('checked', false).prop('disabled', false);
            }
        }

        // Update user preview
        function updateUserPreview() {
            const name = $('#agent_name').val() || 'User Name';
            const id = $('#agent_id').val() || 'AG001';
            const ext = $('#extension').val() || '1001';
            const type = $('#user_type').val() || 'AGENT';
            const status = $('#active').val() === 'Y' ? 'Active' : 'Inactive';
            const statusClass = $('#active').val() === 'Y' ? 'bg-success' : 'bg-danger';
            
            // Update avatar with initials
            const initials = name.split(' ').map(n => n[0]).join('').toUpperCase();
            $('#userAvatar').html(initials || '<i class="fas fa-user"></i>');
            
            // Update preview text
            $('#previewName').text(name);
            $('#previewId').text(id);
            $('#previewExt').text(ext);
            $('#previewType').text(type);
            $('#previewStatus').text(status).removeClass('bg-success bg-danger').addClass(statusClass);
        }

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // API Functions
        async function loadUsers() {
            showLoading(true);
            try {
                // In a real application, you would fetch from your API
                // const response = await fetch(`${API_BASE_URL}users.php?action=getAll`);
                // const result = await response.json();
                
                // For demonstration, we're using sample data
                const result = { success: true, data: sampleUsers };
                
                if (result.success) {
                    usersTable.clear().rows.add(result.data).draw();
                    updateStatistics(result.data);
                } else {
                    showNotification('Failed to load users: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error loading users:', error);
                showNotification('Error loading users. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        async function getUser(id) {
            showLoading(true);
            try {
                // In a real application, you would fetch from your API
                // const response = await fetch(`${API_BASE_URL}users.php?action=get&id=${id}`);
                // const result = await response.json();
                
                // For demonstration, we're using sample data
                const user = sampleUsers.find(u => u.sno == id);
                const result = { success: !!user, data: user };
                
                if (result.success) {
                    return result.data;
                } else {
                    showNotification('Failed to load user: ' + result.message, 'danger');
                    return null;
                }
            } catch (error) {
                console.error('Error loading user:', error);
                showNotification('Error loading user. Please check console.', 'danger');
                return null;
            } finally {
                showLoading(false);
            }
        }

        async function saveUser() {
            const formData = new FormData(document.getElementById('userForm'));
            const data = Object.fromEntries(formData);
            
            // Add checkbox values
            $('.form-check-input').each(function() {
                data[this.name] = this.checked ? 'Y' : 'N';
            });
            
            // Validation
            if (!data.agent_id.trim()) {
                alert('Please enter an Agent ID');
                return;
            }
            
            if (!data.agent_name.trim()) {
                alert('Please enter a full name');
                return;
            }
            
            if (!data.password.trim()) {
                alert('Please enter a password');
                return;
            }
            
            if (!data.extension.trim()) {
                alert('Please enter an extension');
                return;
            }

            showLoading(true);
            try {
                const action = data.sno ? 'update' : 'create';
                
                // In a real application, you would send to your API
                // const response = await fetch(`${API_BASE_URL}users.php?action=${action}`, {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify(data)
                // });
                // const result = await response.json();
                
                // For demonstration, we're simulating API response
                let result;
                if (action === 'create') {
                    const newId = Math.max(...sampleUsers.map(u => u.sno)) + 1;
                    data.sno = newId;
                    data.entry_date = new Date().toISOString().slice(0, 19).replace('T', ' ');
                    sampleUsers.push(data);
                    result = { success: true, message: 'User created successfully' };
                } else {
                    const index = sampleUsers.findIndex(u => u.sno == data.sno);
                    if (index !== -1) {
                        sampleUsers[index] = data;
                        result = { success: true, message: 'User updated successfully' };
                    } else {
                        result = { success: false, message: 'User not found' };
                    }
                }
                
                if (result.success) {
                    showNotification(`User ${data.sno ? 'updated' : 'created'} successfully!`, 'success');
                    loadUsers();
                    
                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
                } else {
                    showNotification('Failed to save user: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error saving user:', error);
                showNotification('Error saving user. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        async function deleteUser(id) {
            if (!confirm('Are you sure you want to delete this user?')) {
                return;
            }

            showLoading(true);
            try {
                // In a real application, you would send to your API
                // const response = await fetch(`${API_BASE_URL}users.php?action=delete`, {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify({ sno: id })
                // });
                // const result = await response.json();
                
                // For demonstration, we're simulating API response
                const index = sampleUsers.findIndex(u => u.sno == id);
                let result;
                if (index !== -1) {
                    sampleUsers.splice(index, 1);
                    result = { success: true, message: 'User deleted successfully' };
                } else {
                    result = { success: false, message: 'User not found' };
                }
                
                if (result.success) {
                    showNotification('User deleted successfully!', 'success');
                    loadUsers();
                } else {
                    showNotification('Failed to delete user: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error deleting user:', error);
                showNotification('Error deleting user. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        // UI Functions
        async function editUser(id) {
            const user = await getUser(id);
            if (!user) return;

            // Populate form
            Object.keys(user).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    if (element.type === 'checkbox') {
                        element.checked = user[key] === 'Y';
                    } else {
                        element.value = user[key];
                    }
                }
            });

            // Update modal title
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit User';
            
            // Update permissions and preview
            togglePermissions();
            updateUserPreview();

            // Show modal and activate first tab
            const modal = new bootstrap.Modal(document.getElementById('userModal'));
            modal.show();
            const firstTab = new bootstrap.Tab(document.getElementById('basic-tab'));
            firstTab.show();
        }

        async function viewUser(id) {
            const user = await getUser(id);
            if (!user) return;

            // Create a detailed view modal
            let detailsHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Basic Information</h6>
                        <p><strong>Agent ID:</strong> ${user.agent_id}</p>
                        <p><strong>Name:</strong> ${user.agent_name}</p>
                        <p><strong>Extension:</strong> ${user.extension}</p>
                        <p><strong>User Type:</strong> <span class="badge bg-primary">${user.user_type}</span></p>
                        <p><strong>Status:</strong> <span class="badge ${user.active === 'Y' ? 'bg-success' : 'bg-danger'}">${user.active === 'Y' ? 'Active' : 'Inactive'}</span></p>
                        <p><strong>Groups:</strong> ${user.groups || 'None'}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Call Settings</h6>
                        <p><strong>Call Mode:</strong> ${user.call_mode}</p>
                        <p><strong>Call Priority:</strong> ${user.call_priority}</p>
                        <p><strong>Call Types:</strong> ${user.call_allowed}</p>
                        <p><strong>Phone:</strong> ${user.phone_number || 'Not set'}</p>
                        <p><strong>Process:</strong> ${user.process || 'Not set'}</p>
                        <p><strong>Queues:</strong> ${user.assigned_queues || 'Not set'}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">Permissions</h6>
                        <div class="d-flex flex-wrap gap-2">
                            ${user.allow_manual_dial === 'Y' ? '<span class="badge bg-success">Manual Dial</span>' : ''}
                            ${user.allow_transfer === 'Y' ? '<span class="badge bg-success">Call Transfer</span>' : ''}
                            ${user.click_to_call === 'Y' ? '<span class="badge bg-success">Click to Call</span>' : ''}
                            ${user.edit_record === 'Y' ? '<span class="badge bg-success">Edit Records</span>' : ''}
                            ${user.manual_outbound === 'Y' ? '<span class="badge bg-success">Manual Outbound</span>' : ''}
                            ${user.allow_offline_crm === 'Y' ? '<span class="badge bg-success">Offline CRM</span>' : ''}
                            ${user.allow_remotelogin === 'Y' ? '<span class="badge bg-success">Remote Login</span>' : ''}
                        </div>
                    </div>
                </div>
            `;

            const viewModal = `
                <div class="modal fade" id="viewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">User Details - ${user.agent_name}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${detailsHtml}
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" onclick="editUser(${user.sno}); bootstrap.Modal.getInstance(document.getElementById('viewModal')).hide();">
                                    <i class="fas fa-edit me-2"></i>Edit User
                                </button>
                                <button class="btn btn-warning" onclick="resetPassword(${user.sno})">
                                    <i class="fas fa-key me-2"></i>Reset Password
                                </button>
                                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('viewModal');
            if (existingModal) existingModal.remove();

            // Add modal to DOM and show it
            document.body.insertAdjacentHTML('beforeend', viewModal);
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }

        function resetPassword(id) {
            if (confirm('Are you sure you want to reset this user\'s password?')) {
                showLoading(true);
                // Simulate password reset
                setTimeout(() => {
                    showLoading(false);
                    showNotification('Password reset successfully! New password sent to user.', 'success');
                }, 1500);
            }
        }

        function updateStatistics(users) {
            const total = users.length;
            const active = users.filter(u => u.active === 'Y').length;
            const supervisors = users.filter(u => u.user_type === 'SUPERVISOR').length;
            const admins = users.filter(u => u.user_type === 'ADMIN').length;
            
            document.getElementById('totalUsers').textContent = total;
            document.getElementById('activeAgents').textContent = active;
            document.getElementById('supervisors').textContent = supervisors;
            document.getElementById('admins').textContent = admins;
        }

        // Search functionality
        $('#searchInput').on('keyup', function() {
            usersTable.search(this.value).draw();
        });

        // Filter by status
        $('#statusFilter').on('change', function() {
            usersTable.column(5).search(this.value).draw();
        });

        // Filter by type
        $('#typeFilter').on('change', function() {
            usersTable.column(4).search(this.value).draw();
        });

        function resetFilters() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#typeFilter').val('');
            usersTable.search('').columns().search('').draw();
        }

        function showNotification(message, type = 'info') {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-bg-${type === 'success' ? 'success' : type === 'danger' ? 'danger' : 'primary'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            document.getElementById('toastContainer').appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        // Reset form when modal is hidden
        document.getElementById('userModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('userForm').reset();
            document.getElementById('sno').value = '';
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-user-plus me-2"></i>Add New User';
            togglePermissions();
            updateUserPreview();
        });
    </script>
</body>
</html>