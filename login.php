<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asterisk PBX | Login Portal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
      <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Left Side - Branding & Info -->
            <div class="login-left">
                <div class="logo">
                    <i class="fas fa-server"></i>
                    Asterisk PBX
                </div>
                <p class="tagline">Enterprise-grade telephony solution with advanced call management</p>
                
                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-phone-volume"></i>
                        </div>
                        <div>Advanced Call Routing & IVR</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>Multi-level User Management</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>Comprehensive Analytics & Reporting</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>Enterprise Security & Reliability</div>
                    </div>
                </div>
                
                <div class="system-status">
                    <div class="status-title">System Status</div>
                    <div class="status-item">
                        <span><span class="status-indicator indicator-online"></span> PBX Core</span>
                        <span>Online</span>
                    </div>
                    <div class="status-item">
                        <span><span class="status-indicator indicator-online"></span> Database</span>
                        <span>Online</span>
                    </div>
                    <div class="status-item">
                        <span><span class="status-indicator indicator-online"></span> SIP Trunks</span>
                        <span>2/3 Online</span>
                    </div>
                    <div class="status-item">
                        <span><span class="status-indicator indicator-online"></span> Web Services</span>
                        <span>Online</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Login Forms -->
            <div class="login-right">
                <h2 class="form-title">Welcome Back</h2>
                <p class="form-subtitle">Select your role and sign in to your account</p>
                
                <!-- Role Selector -->
                <div class="role-selector">
                    <div class="role-card active" data-role="agent">
                        <div class="role-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="role-title">Agent</div>
                        <div class="role-desc">Call center agents</div>
                    </div>
                    <div class="role-card" data-role="admin">
                        <div class="role-icon">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <div class="role-title">Administrator</div>
                        <div class="role-desc">System administrators</div>
                    </div>
                    <div class="role-card" data-role="supervisor">
                        <div class="role-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="role-title">Supervisor</div>
                        <div class="role-desc">Team supervisors</div>
                    </div>
                </div>
                
                <!-- Agent Login Form -->
                <div class="login-form active" id="agent-form">
                    <div class="form-group">
                        <label class="form-label" for="agent-username">Username</label>
                        <input type="text" class="form-control" id="agent-username" placeholder="Enter your username">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="agent-password">Password</label>
                        <input type="password" class="form-control" id="agent-password" placeholder="Enter your password">
                    </div>
                    <!-- <div class="form-group">
                        <label class="form-label" for="agent-station">Station ID</label>
                        <input type="text" class="form-control" id="agent-station" placeholder="Enter your station ID">
                    </div> -->
                    <!-- <div class="form-group">
                        <label class="form-label" for="agent-admin">Admin Code</label>
                        <input type="text" class="form-control" id="agent-admin" placeholder="Enter admin code (if required)">
                    </div> -->
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="agent-remember">
                        <label class="form-check-label" for="agent-remember">Remember me</label>
                    </div>
                    <button class="btn btn-login" id="agent-login-btn">Sign In as Agent</button>
                </div>
                
                <!-- Admin Login Form -->
                <div class="login-form" id="admin-form">
                    <div class="form-group">
                        <label class="form-label" for="admin-username">Username</label>
                        <input type="text" class="form-control" id="admin-username" placeholder="Enter admin username">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="admin-password">Password</label>
                        <input type="password" class="form-control" id="admin-password" placeholder="Enter admin password">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="admin-remember">
                        <label class="form-check-label" for="admin-remember">Remember me</label>
                    </div>
                    <button class="btn btn-login" id="admin-login-btn">Sign In as Administrator</button>
                </div>
                
                <!-- Supervisor Login Form -->
                <div class="login-form" id="supervisor-form">
                    <div class="form-group">
                        <label class="form-label" for="supervisor-username">Username</label>
                        <input type="text" class="form-control" id="supervisor-username" placeholder="Enter supervisor username">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="supervisor-password">Password</label>
                        <input type="password" class="form-control" id="supervisor-password" placeholder="Enter supervisor password">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="supervisor-remember">
                        <label class="form-check-label" for="supervisor-remember">Remember me</label>
                    </div>
                    <button class="btn btn-login" id="supervisor-login-btn">Sign In as Supervisor</button>
                </div>
                
                <div class="login-footer">
                    <p>Need help? <a href="#" data-bs-toggle="modal" data-bs-target="#helpModal">Contact Support</a></p>
                    <p>&copy; 2024 Asterisk PBX. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="helpModalLabel">Login Assistance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Having trouble signing in?</h6>
                    <p>If you're experiencing issues with your login, please try the following:</p>
                    <ul>
                        <li>Ensure you've selected the correct role (Agent, Admin, or Supervisor)</li>
                        <li>Check that your username and password are entered correctly</li>
                        <li>Agents: Make sure your Station ID is correct</li>
                        <li>If problems persist, contact your system administrator</li>
                    </ul>
                    <p><strong>Support Contact:</strong><br>
                    Email: support@asteriskpbx.com<br>
                    Phone: +1 (555) 123-HELP</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // --- Role selection functionality ---
    $('.role-card').click(function() {
        $('.role-card').removeClass('active');
        $(this).addClass('active');

        const role = $(this).data('role');
        $('.login-form').removeClass('active');
        $(`#${role}-form`).addClass('active');

        setTimeout(() => {
            $(`#${role}-form input:first`).focus();
        }, 300);
    });

    // --- Login button handler ---
    $('.btn-login').click(function(e) {
        e.preventDefault();

        const role = $(this).attr('id').split('-')[0]; // agent/admin/supervisor
        let username = $(`#${role}-username`).val();
        let password = $(`#${role}-password`).val();

        if (!username || !password) {
            alert('Please fill in both username and password.');
            return;
        }

        // Disable button while authenticating
        $(this).prop('disabled', true).text('Authenticating...');

        // AJAX request to login_api.php
        $.ajax({
            url: 'login_api.php',
            type: 'POST',
            dataType: 'json',
            data: {
                role: role,
                username: username,
                password: password
            },
            success: function(response) {
                $('.btn-login').prop('disabled', false).text('Sign In');

                if (response.status === 'success') {
                    let msg = response.message;
                    if (response.station_assigned) {
                        msg += `\nStation Assigned: ${response.station_assigned}`;
                    }
                    alert(msg);
                    window.location.href = response.redirect;
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                $('.btn-login').prop('disabled', false).text('Sign In');
                alert('Server error. Please try again later.');
            }
        });
    });

});
</script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Role selection functionality
            const roleCards = document.querySelectorAll('.role-card');
            const loginForms = document.querySelectorAll('.login-form');
            
            roleCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove active class from all cards
                    roleCards.forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked card
                    this.classList.add('active');
                    
                    // Get selected role
                    const role = this.getAttribute('data-role');
                    
                    // Hide all login forms
                    loginForms.forEach(form => form.classList.remove('active'));
                    
                    // Show selected login form
                    document.getElementById(`${role}-form`).classList.add('active');
                });
            });
            
            // Login button functionality
            const loginButtons = document.querySelectorAll('.btn-login');
            
            loginButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const role = this.id.split('-')[0]; // agent, admin, or supervisor
                    
                    // Get form values
                    let username, password, station, adminCode;
                    
                    if (role === 'agent') {
                        username = document.getElementById('agent-username').value;
                        password = document.getElementById('agent-password').value;
                        // station = document.getElementById('agent-station').value;
                        // adminCode = document.getElementById('agent-admin').value;
                        
                        if (!username || !password || !station) {
                            alert('Please fill in all required fields for Agent login.');
                            return;
                        }
                        
                        // In a real application, you would send this to your backend
                        console.log('Agent Login:', { username, password, station, adminCode });
                        alert('Agent login submitted! In a real application, this would authenticate with the PBX system.');
                        
                    } else if (role === 'admin') {
                        username = document.getElementById('admin-username').value;
                        password = document.getElementById('admin-password').value;
                        
                        if (!username || !password) {
                            alert('Please enter both username and password for Admin login.');
                            return;
                        }
                        
                        // In a real application, you would send this to your backend
                        console.log('Admin Login:', { username, password });
                        alert('Admin login submitted! In a real application, this would authenticate with the PBX system.');
                        
                    } else if (role === 'supervisor') {
                        username = document.getElementById('supervisor-username').value;
                        password = document.getElementById('supervisor-password').value;
                        
                        if (!username || !password) {
                            alert('Please enter both username and password for Supervisor login.');
                            return;
                        }
                        
                        // In a real application, you would send this to your backend
                        console.log('Supervisor Login:', { username, password });
                        alert('Supervisor login submitted! In a real application, this would authenticate with the PBX system.');
                    }
                    
                    // Here you would typically redirect to the dashboard
                    // window.location.href = 'dashboard.html';
                });
            });
            
            // Add some visual effects
            const loginCard = document.querySelector('.login-card');
            
            loginCard.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease';
            });
            
            loginCard.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
            
            // Auto-focus on first input when form becomes active
            roleCards.forEach(card => {
                card.addEventListener('click', function() {
                    const role = this.getAttribute('data-role');
                    setTimeout(() => {
                        const firstInput = document.querySelector(`#${role}-form input`);
                        if (firstInput) firstInput.focus();
                    }, 300);
                });
            });

            
        });
    </script>
</body>
</html>