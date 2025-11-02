<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Call Center Dashboard - Fixed Sidebar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #f3f4f6;
      font-family: "Segoe UI", sans-serif;
      margin: 0;
      overflow-x: hidden;
    }

    /* Layout container */
    .dashboard-container {
      display: flex;
      flex-direction: row;
      min-height: 100vh;
      width: 100%;
    }

    /* Main content */
    .main-content {
      flex: 1;
      padding: 2rem;
      overflow-y: auto;
    }

    /* Sidebar */
    .sidebar {
      width: 340px;
      background: #ffffff;
      border-left: 3px solid #0d6efd;
      box-shadow: -3px 0 8px rgba(0, 0, 0, 0.1);
      padding: 1rem;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }

    /* Sidebar header */
    .sidebar h5 {
      color: #0d6efd;
      font-weight: 700;
      border-bottom: 2px solid #0d6efd;
      padding-bottom: 0.4rem;
      margin-bottom: 0.8rem;
    }

    /* Sidebar tables */
    .sidebar-table {
      width: 100%;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    .sidebar-table thead {
      background-color: #e9ecef;
    }

    .sidebar-table th,
    .sidebar-table td {
      padding: 6px 8px;
      text-align: left;
    }

    .sidebar-table tbody tr:nth-child(even) {
      background-color: #f8f9fa;
    }

    /* Cards */
    .status-card {
      border-radius: 10px;
      color: #fff;
      text-align: center;
      padding: 20px;
      font-weight: 600;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s;
    }
    .status-card:hover { transform: scale(1.03); }

    .status-idle { background: linear-gradient(135deg, #007bff, #0dcaf0); }
    .status-oncall { background: linear-gradient(135deg, #fd7e14, #ffc107); }
    .status-wrapup { background: linear-gradient(135deg, #198754, #20c997); }
    .status-break { background: linear-gradient(135deg, #dc3545, #fd6b83); }

    .filter-section {
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
    }

    .table th {
      background-color: #0d6efd;
      color: #fff;
      text-transform: uppercase;
      font-size: 0.8rem;
    }

    .badge-status {
      font-size: 0.75rem;
      border-radius: 6px;
      color: #fff;
      padding: 0.4em 0.6em;
    }

    .btn-logout {
      font-size: 0.75rem;
      padding: 3px 8px;
    }

    .toast-container {
      position: fixed;
      bottom: 1rem;
      right: 360px;
      z-index: 2000;
    }

    @media (max-width: 992px) {
      .dashboard-container {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        border-left: none;
        border-top: 3px solid #0d6efd;
        box-shadow: none;
      }
      .toast-container {
        right: 1rem;
      }
    }
  </style>
</head>

<body>
  <div class="dashboard-container">
    <!-- Main content -->
    <div class="main-content">
      <h3 class="mb-4 fw-bold text-center">📊 Live Agent Dashboard (Admin View)</h3>

      <!-- Status Summary -->
      <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6"><div class="status-card status-idle"><h4 id="idleCount">0</h4><p>Idle</p></div></div>
        <div class="col-md-3 col-sm-6"><div class="status-card status-oncall"><h4 id="oncallCount">0</h4><p>On Call</p></div></div>
        <div class="col-md-3 col-sm-6"><div class="status-card status-wrapup"><h4 id="wrapupCount">0</h4><p>Wrap-Up</p></div></div>
        <div class="col-md-3 col-sm-6"><div class="status-card status-break"><h4 id="breakCount">0</h4><p>Break</p></div></div>
      </div>

      <!-- Filters -->
      <div class="filter-section mb-4">
        <div class="row align-items-center">
          <div class="col-md-4 col-sm-12">
            <label for="processFilter" class="form-label fw-semibold">Filter by Process:</label>
            <select id="processFilter" class="form-select">
              <option value="all">All Processes</option>
            </select>
          </div>
          <div class="col-md-8 col-sm-12 text-md-end mt-3 mt-md-0">
            <button class="btn btn-primary me-2" onclick="renderTable()">🔄 Refresh</button>
            <button class="btn btn-outline-secondary" onclick="resetFilter()">Reset</button>
          </div>
        </div>
      </div>

      <!-- Agent Table -->
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
          <span>Active Agents</span>
          <span class="small">Auto-updates every 5s</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead>
                <tr>
                  <th>Agent</th>
                  <th>Mode</th>
                  <th>Process</th>
                  <th>Ext</th>
                  <th>Status</th>
                  <th>Duration</th>
                  <th>Total Calls</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="agentTable"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <h5>📞 Numbers Ringing</h5>
      <div class="table-responsive">
        <table class="table sidebar-table" id="ringingTable">
          <thead><tr><th>Phone</th><th>Duration</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>

      <h5>⏳ Calls Waiting</h5>
      <div class="table-responsive">
        <table class="table sidebar-table" id="queueTable">
          <thead><tr><th>Queue</th><th>Phone</th><th>Wait</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div class="toast-container">
    <div id="logoutToast" class="toast align-items-center text-bg-success border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body">✅ Agent logged out successfully!</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const agents = [
      { id: 1, name: "R7 Suman", mode: "Outbound", process: "merit_R7", ext: "1013", status: "Idle", duration: "00:00:58", totalCalls: 202 },
      { id: 2, name: "Mamta A", mode: "ProcessMode", process: "EMRI_PROCESS", ext: "1008", status: "On Call", duration: "00:00:08", totalCalls: 159 },
      { id: 3, name: "Lalit", mode: "ProcessMode", process: "EMRI_PROCESS", ext: "1030", status: "On Call", duration: "00:00:47", totalCalls: 7 },
      { id: 4, name: "Oed Mukesh", mode: "Outbound", process: "EMRI_PROCESS", ext: "1016", status: "Break", duration: "01:22:26", totalCalls: 0 },
      { id: 5, name: "R4 Aru", mode: "ProcessMode", process: "merit_R4", ext: "1021", status: "Wrap-Up", duration: "00:00:49", totalCalls: 153 },
      { id: 6, name: "Rahul IT", mode: "Outbound", process: "EMRI_PROCESS", ext: "1006", status: "On Call", duration: "00:00:40", totalCalls: 11 },
      { id: 7, name: "Sagar S", mode: "ProcessMode", process: "EMRI_PROCESS", ext: "1002", status: "Break", duration: "00:00:02", totalCalls: 37 },
      { id: 8, name: "Tejal", mode: "Inbound", process: "merit_R4", ext: "1007", status: "Wrap-Up", duration: "00:22:14", totalCalls: 1 }
    ];

    const ringingData = [
      { phone: "6376477273", duration: "00:06" },
      { phone: "9257038057", duration: "00:03" }
    ];

    const waitingQueue = [
      { queue: "EMRI Queue", phone: "9773377586", duration: "00:15" },
      { queue: "Emergency Queue", phone: "9257018851", duration: "00:09" }
    ];

    const counters = { Idle: 0, "On Call": 0, "Wrap-Up": 0, Break: 0 };
    const processFilter = document.getElementById("processFilter");
    const logoutToast = new bootstrap.Toast(document.getElementById("logoutToast"));

    function populateProcessFilter() {
      const unique = [...new Set(agents.map(a => a.process))];
      unique.forEach(p => {
        const opt = document.createElement("option");
        opt.value = p;
        opt.textContent = p;
        processFilter.appendChild(opt);
      });
    }

    function renderTable() {
      const tbody = document.getElementById("agentTable");
      tbody.innerHTML = "";
      Object.keys(counters).forEach(k => (counters[k] = 0));
      const filter = processFilter.value;
      const filtered = filter === "all" ? agents : agents.filter(a => a.process === filter);

      filtered.forEach(a => {
        counters[a.status]++;
        const color = { Idle: "primary", "On Call": "warning", "Wrap-Up": "success", Break: "danger" }[a.status];
        tbody.innerHTML += `
          <tr id="row-${a.id}">
            <td>${a.name}</td>
            <td>${a.mode}</td>
            <td>${a.process}</td>
            <td>${a.ext}</td>
            <td><span class="badge bg-${color}">${a.status}</span></td>
            <td>${a.duration}</td>
            <td>${a.totalCalls}</td>
            <td><button class="btn btn-sm btn-danger btn-logout" onclick="logoutAgent(${a.id})">Logout</button></td>
          </tr>`;
      });

      document.getElementById("idleCount").innerText = counters["Idle"];
      document.getElementById("oncallCount").innerText = counters["On Call"];
      document.getElementById("wrapupCount").innerText = counters["Wrap-Up"];
      document.getElementById("breakCount").innerText = counters["Break"];
    }

    function renderSidebar() {
      const ringBody = document.querySelector("#ringingTable tbody");
      const queueBody = document.querySelector("#queueTable tbody");
      ringBody.innerHTML = ringingData.map(r => `<tr><td>${r.phone}</td><td>${r.duration}</td></tr>`).join("");
      queueBody.innerHTML = waitingQueue.map(q => `<tr><td>${q.queue}</td><td>${q.phone}</td><td>${q.duration}</td></tr>`).join("");
    }

    function logoutAgent(id) {
      document.getElementById(`row-${id}`)?.remove();
      logoutToast.show();
    }

    function resetFilter() {
      processFilter.value = "all";
      renderTable();
    }

    function simulateLiveUpdate() {
      const statuses = ["Idle", "On Call", "Wrap-Up", "Break"];
      agents.forEach(a => (a.status = statuses[Math.floor(Math.random() * statuses.length)]));
      renderTable();
    }

    populateProcessFilter();
    renderTable();
    renderSidebar();
    setInterval(simulateLiveUpdate, 5000);
  </script>
</body>
</html>
