<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Center Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .card {
            border-radius: 0.5rem;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #4e73df, #224abe);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #1cc88a, #17a673);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f6c23e, #dda20a);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #e74a3b, #be2617);
        }

        .fade-in-up {
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
    </style>
</head>
<body>
    <main class="main-content" style="min-height: 100vh; padding: 2rem;">
        <div class="container-fluid py-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-chart-line me-2 text-primary"></i> Call Center Dashboard
                </h4>
                <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                </button>
            </div>

            <!-- KPI Cards -->
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 bg-gradient-primary text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-2">Total Calls Today</h6>
                            <h2 id="total-calls">1,248</h2>
                            <small><i class="fas fa-arrow-up text-success"></i> +8% from yesterday</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 bg-gradient-success text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-2">Active Agents</h6>
                            <h2 id="active-agents">34</h2>
                            <small><i class="fas fa-user-check me-1"></i> Working right now</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 bg-gradient-warning text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-2">Calls in Queue</h6>
                            <h2 id="calls-in-queue">12</h2>
                            <small><i class="fas fa-phone-volume me-1"></i> Waiting customers</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 bg-gradient-danger text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-2">Dropped Calls</h6>
                            <h2 id="dropped-calls">7</h2>
                            <small><i class="fas fa-exclamation-triangle me-1"></i> Last 1 hour</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Agent Section -->
            <div class="row mt-4">
                <div class="col-lg-8 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i> Call Volume (Last 7 Days)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="callVolumeChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-headset me-2 text-success"></i> Top Performing Agents</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush" id="topAgents">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Sarah Johnson
                                    <span class="badge bg-success rounded-pill">98%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    David Lee
                                    <span class="badge bg-success rounded-pill">95%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Priya Sharma
                                    <span class="badge bg-success rounded-pill">93%</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Queue Summary -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-list me-2 text-warning"></i> Queue Summary</h6>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Queue Name</th>
                                        <th>Waiting Calls</th>
                                        <th>Longest Wait</th>
                                        <th>Agents Available</th>
                                        <th>Service Level</th>
                                    </tr>
                                </thead>
                                <tbody id="queueSummary">
                                    <tr>
                                        <td>Sales Support</td>
                                        <td>4</td>
                                        <td>02:13</td>
                                        <td>5</td>
                                        <td><span class="badge bg-success">94%</span></td>
                                    </tr>
                                    <tr>
                                        <td>Technical Support</td>
                                        <td>6</td>
                                        <td>03:45</td>
                                        <td>3</td>
                                        <td><span class="badge bg-warning text-dark">78%</span></td>
                                    </tr>
                                    <tr>
                                        <td>Billing</td>
                                        <td>2</td>
                                        <td>01:32</td>
                                        <td>2</td>
                                        <td><span class="badge bg-success">96%</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Dashboard Chart Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('callVolumeChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Total Calls',
                        data: [210, 260, 290, 320, 370, 340, 390],
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0,123,255,0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</body>
</html>
