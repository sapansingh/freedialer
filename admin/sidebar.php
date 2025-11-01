

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#dashboard" class="nav-link active" data-content="dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <!-- User Management with Collapsible Submenu -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#userManagementSubmenu" role="button" aria-expanded="false">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
                    <i class="fas fa-chevron-down ms-auto submenu-toggle"></i>
                </a>
                <div class="collapse" id="userManagementSubmenu">
                    <div class="submenu">
                        <a href="#users-list" class="nav-link" data-content="users">User List</a>
                        <a href="#users-roles" class="nav-link" data-content="roles">Roles & Permissions</a>
                        <a href="#users-teams" class="nav-link" data-content="teams">Teams</a>
                    </div>
                </div>
            </li>
            
            <!-- Reports with Collapsible Submenu -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#reportsSubmenu" role="button" aria-expanded="false">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports & Analytics</span>
                    <i class="fas fa-chevron-down ms-auto submenu-toggle"></i>
                </a>
                <div class="collapse" id="reportsSubmenu">
                    <div class="submenu">
                        <a href="#reports-call" class="nav-link" data-content="call-reports">Call Analytics</a>
                        <a href="#reports-agent" class="nav-link" data-content="agent-reports">Agent Performance</a>
                        <a href="#reports-queue" class="nav-link" data-content="queue-reports">Queue Metrics</a>
                    </div>
                </div>
            </li>
            
            <!-- System with Collapsible Submenu -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#systemSubmenu" role="button" aria-expanded="false">
                    <i class="fas fa-cogs"></i>
                    <span>System Setting</span>
                    <i class="fas fa-chevron-down ms-auto submenu-toggle"></i>
                </a>
                <div class="collapse" id="systemSubmenu">
                    <div class="submenu">
                        <h4>System Config</h4>
                        <a href="#system-health" class="nav-link" data-content="servers">Servers</a>
                        <a href="#system-config" class="nav-link" data-content="webserver">Web Servers</a>
                         <a href="#system-config" class="nav-link" data-content="wsstation">Ws Station</a>
                          <a href="#system-logs" class="nav-link" data-content="wsremotestation">WS Remote Station</a>
                        <a href="#system-logs" class="nav-link" data-content="wsinternal">WS Internal Station</a>
                              <hr>
                              <h4>INBOUND ROUTES</h4>
                               <a href="#system-health" class="nav-link" data-content="INBOUNDROUTES">INBOUND ROUTES</a>
                        <a href="#system-config" class="nav-link" data-content="OUTBOUNDTRUNKS">OUTBOUND TRUNKS</a>
                         <a href="#system-config" class="nav-link" data-content="OUTBOUNDROUTE">OUTBOUND ROUTES</a>
                        
                               <hr>
                              <h4>IVR Setting</h4>
                               <a href="#system-health" class="nav-link" data-content="audiomanageivr">Audio Files</a>
                         <a href="#system-config" class="nav-link" data-content="ivrmanagement">IVRS Management</a>
                 
                         
                         <hr>
                              <h4>ACD and Queue</h4>
                               <a href="#system-health" class="nav-link" data-content="usermanage">Users</a>
                        <a href="#system-config" class="nav-link" data-content="proceesmanagement">Process</a>
                         <a href="#system-config" class="nav-link" data-content="Queues">Queues</a>
                          <a href="#system-logs" class="nav-link" data-content="Breaks">Breaks</a>
                        <a href="#system-logs" class="nav-link" data-content="Dispositions">Dispositions</a>
                         <a href="#system-logs" class="nav-link" data-content="Sub_Disposition"> Sub Disposition</a>
                          <a href="#system-logs" class="nav-link" data-content="Sub-Sub_Disposition">Sub-Sub Disposition</a>
                         
                    </div>
                </div>
            </li>

            
        </ul>
    </div>
