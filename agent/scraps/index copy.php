<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Center Agent Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-bg: #343a40;
        }
        
        body {
            font-size: 0.875rem; /* Small font size */
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-weight: 600;
        }
        
        .sidebar {
            background-color: var(--secondary-color);
            color: white;
            height: calc(100vh - 56px);
            position: fixed;
            overflow-y: auto;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }
        
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }
        
        .stat-card {
            text-align: center;
            padding: 1rem;
        }
        
        .stat-card .value {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        
        .stat-card .label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
        }
        
        .dial-pad {
            background-color: var(--light-bg);
            border-radius: 0.5rem;
            padding: 1.5rem;
        }
        
        .dial-btn {
            width: 100%;
            height: 50px;
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
            border: 1px solid #dee2e6;
            background-color: white;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        
        .dial-btn:hover {
            background-color: #e9ecef;
        }
        
        .dial-btn.call {
            background-color: var(--success-color);
            color: white;
            border: none;
        }
        
        .dial-btn.call:hover {
            background-color: #27ae60;
        }
        
        .dial-btn.end {
            background-color: var(--danger-color);
            color: white;
            border: none;
        }
        
        .dial-btn.end:hover {
            background-color: #c0392b;
        }
        
        .phone-number-display {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1.5rem;
            padding: 0.75rem;
            background-color: white;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
        }
        
        .call-status {
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-available {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success-color);
        }
        
        .status-busy {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--danger-color);
        }
        
        .status-break {
            background-color: rgba(243, 156, 18, 0.2);
            color: var(--warning-color);
        }
        
        .customer-info-card {
            border-left: 4px solid var(--primary-color);
        }
        
        .customer-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .call-history-item {
            border-left: 3px solid transparent;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            background-color: white;
            border-radius: 0.375rem;
        }
        
        .call-history-item.incoming {
            border-left-color: var(--primary-color);
        }
        
        .call-history-item.outgoing {
            border-left-color: var(--success-color);
        }
        
        .call-history-item.missed {
            border-left-color: var(--danger-color);
        }
        
        .call-duration {
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-headset me-2"></i>CallCenter Pro
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> John Doe
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-phone"></i> Dialer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-history"></i> Call History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users"></i> Contacts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-bar"></i> Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li>
                    </ul>
                    
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                        <span>Status</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="call-status status-available">Available</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="call-status status-busy">Busy</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="call-status status-break">On Break</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Agent Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-sync-alt me-1"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <i class="fas fa-phone text-primary fa-2x"></i>
                                <div class="value">24</div>
                                <div class="label">Calls Today</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <i class="fas fa-clock text-warning fa-2x"></i>
                                <div class="value">12.4m</div>
                                <div class="label">Avg. Call Time</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <i class="fas fa-check-circle text-success fa-2x"></i>
                                <div class="value">78%</div>
                                <div class="label">Success Rate</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <i class="fas fa-user-clock text-info fa-2x"></i>
                                <div class="value">5.2m</div>
                                <div class="label">Avg. Wait Time</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Dialer Section -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-phone me-2"></i> Dialer
                            </div>
                            <div class="card-body">
                                <div class="phone-number-display" id="phoneNumber">+1 (555) 123-4567</div>
                                
                                <div class="dial-pad">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="1">1</button>
                                        </div>
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="2">2<span class="d-block small">ABC</span></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="3">3<span class="d-block small">DEF</span></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="4">4<span class="d-block small">GHI</span></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="5">5<span class="d-block small">JKL</span></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="6">6<span class="d-block small">MNO</span></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="7">7<span class="d-block small">PQRS</span></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="8">8<span class="d-block small">TUV</span></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="9">9<span class="d-block small">WXYZ</span></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="*">*</button>
                                        </div>
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="0">0</button>
                                        </div>
                                        <div class="col-4">
                                            <button class="dial-btn" data-number="#">#</button>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <button class="dial-btn call" id="callButton">
                                                <i class="fas fa-phone me-1"></i> Call
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button class="dial-btn end" id="endCallButton">
                                                <i class="fas fa-phone-slash me-1"></i> End
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Quick Contact Form -->
                                <div class="mt-4">
                                    <h6 class="mb-3">Quick Contact</h6>
                                    <form id="contactForm">
                                        <div class="mb-3">
                                            <input type="text" class="form-control form-control-sm" placeholder="Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="tel" class="form-control form-control-sm" placeholder="Phone Number" required>
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control form-control-sm" rows="2" placeholder="Notes"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-save me-1"></i> Save Contact
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info & Recent Calls -->
                    <div class="col-lg-6">
                        <!-- Customer Information -->
                        <div class="card customer-info-card mb-4">
                            <div class="card-header">
                                <i class="fas fa-user me-2"></i> Current Customer
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/60" alt="Customer" class="customer-avatar me-3">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Robert Johnson</h5>
                                        <p class="mb-1 text-muted">Premium Customer</p>
                                        <div class="d-flex">
                                            <span class="badge bg-primary me-2">VIP</span>
                                            <span class="badge bg-success">Active</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Phone:</strong> +1 (555) 123-4567</p>
                                        <p class="mb-1"><strong>Email:</strong> robert.j@example.com</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Account:</strong> #A-7842</p>
                                        <p class="mb-1"><strong>Last Contact:</strong> 2 days ago</p>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <h6>Recent Notes</h6>
                                    <p class="small text-muted">Customer inquired about upgrade options for their current plan. Needs follow-up in 3 days.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Calls -->
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-history me-2"></i> Recent Calls
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <div class="call-history-item incoming">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Sarah Williams</h6>
                                            <small>10:24 AM</small>
                                        </div>
                                        <p class="mb-1">+1 (555) 987-6543</p>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">Incoming</small>
                                            <span class="call-duration">12:34</span>
                                        </div>
                                    </div>
                                    <div class="call-history-item outgoing">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Michael Brown</h6>
                                            <small>09:45 AM</small>
                                        </div>
                                        <p class="mb-1">+1 (555) 456-7890</p>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">Outgoing</small>
                                            <span class="call-duration">08:12</span>
                                        </div>
                                    </div>
                                    <div class="call-history-item missed">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Jennifer Lee</h6>
                                            <small>Yesterday</small>
                                        </div>
                                        <p class="mb-1">+1 (555) 234-5678</p>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">Missed</small>
                                            <span class="call-duration">--:--</span>
                                        </div>
                                    </div>
                                    <div class="call-history-item incoming">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">David Miller</h6>
                                            <small>Yesterday</small>
                                        </div>
                                        <p class="mb-1">+1 (555) 345-6789</p>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">Incoming</small>
                                            <span class="call-duration">05:43</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Dial pad functionality
        document.addEventListener('DOMContentLoaded', function() {
            const phoneNumberDisplay = document.getElementById('phoneNumber');
            const dialButtons = document.querySelectorAll('.dial-btn[data-number]');
            const callButton = document.getElementById('callButton');
            const endCallButton = document.getElementById('endCallButton');
            
            let phoneNumber = '';
            
            // Add number to display when dial button is clicked
            dialButtons.forEach(button => {
                button.addEventListener('click', function() {
                    phoneNumber += this.getAttribute('data-number');
                    phoneNumberDisplay.textContent = formatPhoneNumber(phoneNumber);
                });
            });
            
            // Call button functionality
            callButton.addEventListener('click', function() {
                if (phoneNumber) {
                    alert(`Calling ${formatPhoneNumber(phoneNumber)}...`);
                    // In a real application, you would integrate with a telephony API here
                    
                    // Update UI to show active call
                    callButton.disabled = true;
                    endCallButton.disabled = false;
                    phoneNumberDisplay.classList.add('text-success');
                } else {
                    alert('Please enter a phone number first.');
                }
            });
            
            // End call button functionality
            endCallButton.addEventListener('click', function() {
                alert('Call ended.');
                
                // Reset UI
                callButton.disabled = false;
                endCallButton.disabled = true;
                phoneNumberDisplay.classList.remove('text-success');
                
                // Optionally clear the number after call ends
                // phoneNumber = '';
                // phoneNumberDisplay.textContent = formatPhoneNumber(phoneNumber);
            });
            
            // Format phone number for display
            function formatPhoneNumber(number) {
                // Simple formatting for demo purposes
                if (number.length <= 3) {
                    return number;
                } else if (number.length <= 6) {
                    return `(${number.substring(0, 3)}) ${number.substring(3)}`;
                } else {
                    return `(${number.substring(0, 3)}) ${number.substring(3, 6)}-${number.substring(6, 10)}`;
                }
            }
            
            // Contact form submission
            document.getElementById('contactForm').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Contact saved successfully!');
                this.reset();
            });
        });
    </script>
</body>
</html>