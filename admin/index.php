<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asterisk PBX | Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.0/css/dataTables.dateTime.min.css">
        <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="./assets/css/style.css">
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- API Status Indicator -->
    <div class="api-status alert alert-success" style="display: none;">
        <i class="fas fa-check-circle me-2"></i>API Connected
    </div>
 <?php include "navigation.php";?>
 <?php include "sidebar.php";?>
    <!-- Main Content -->
  <main class="main-content" id="main-content" style="margin-top: 40px; height: 100vh;">
        <div id="content-area" style="height: 100vh;">
            <!-- Loading Overlay -->
            <div class="loading-overlay">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="loading-text">Loading content...</div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    
<script>
const ApiService = {
    basePath: 'html/', // folder where your .php pages are located
    
    getPageUrl(page) {
        return `${this.basePath}${page}.php`;
    }
};

document.addEventListener('hidden.bs.modal', () => {
    const backdrops = document.querySelectorAll('.modal-backdrop');
    if (backdrops.length > 1) {
        backdrops.forEach((b, i) => { if (i < backdrops.length - 1) b.remove(); });
    }
});

$(document).ready(function() {
    
    // API status animation
    $('.api-status').fadeIn();
    setTimeout(() => $('.api-status').fadeOut(), 3000);

    // Load default content in iframe
    loadContent('dashboard');

    // Sidebar toggle
    $('#sidebarToggle').on('click', function() {
        $('#sidebar').toggleClass('collapse');
    });

    // Handle sidebar navigation
    $('.sidebar .nav-link').on('click', function(e) {
        if ($(this).attr('data-bs-toggle') === 'collapse') return;

        e.preventDefault();

        // Update active states
        $('.sidebar .nav-link').removeClass('active');
        $(this).addClass('active');

        if ($(this).parent().hasClass('submenu')) {
            $(this).closest('.collapse').siblings('.nav-link').addClass('active');
        }

        // Load content into iframe
        const content = $(this).data('content');
        if (content) loadContent(content);
    });

    // Function to load content in iframe
    function loadContent(contentType) {
        const iframeUrl = ApiService.getPageUrl(contentType);
        
        $('.loading-overlay').show();

        const contentArea = document.getElementById('content-area');
        contentArea.innerHTML = ''; // clear previous content

        const iframe = document.createElement('iframe');
        iframe.src = iframeUrl;
        iframe.style.width = '100%';
        iframe.style.border = 'none';
        iframe.style.display = 'block';

        // Set iframe height to match parent
        function resizeIframe() {
            iframe.style.height = contentArea.clientHeight + 'px';
           
        }

        // Initial size
        resizeIframe();

        
        // Resize on window resize
        window.addEventListener('resize', resizeIframe);

        iframe.onload = function() {
            $('.loading-overlay').fadeOut();
        };

        contentArea.appendChild(iframe);
    }

    // Global access
    window.loadContent = loadContent;
});

</script>

</body>
</html>