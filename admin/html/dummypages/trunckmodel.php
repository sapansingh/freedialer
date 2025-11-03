<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Outbound Trunk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .required::after {
            content: " *";
            color: #e53e3e;
        }
        
        .info-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .trunk-type-section {
            background-color: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid #0272a7;
            padding: 20px;
            margin: 20px 0;
        }
        
        .trunk-type-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: #2d3748;
        }
        
        .fieldset {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg border-0 w-100" style="max-width: 950px; border-radius: 16px;">
            <div class="card-header bg-primary text-white py-3" style="border-radius: 16px 16px 0 0;">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0 fw-semibold">
                        <i class="fas fa-server me-2"></i>Modify Outbound Trunk
                    </h1>
                    <button class="btn btn-sm btn-light rounded-circle p-2" onclick="postURL('/ConVoxCCS/Admin/index.php?mode=VIEW&user_sel_menu=Outbound Trunks','false');return false;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="card-body p-4">
                <form id="trunkForm">
                    <input type="hidden" name="mode" value="SAVE">
                    <input type="hidden" name="user_sel_menu" value="Outbound Trunks">
                    <input type="hidden" name="trunk_id" id="trunk_id" value="5">
                    <input type="hidden" name="current_page" id="current_page" value="0">
                    <input type="hidden" name="pcount" id="pcount" value="1">
                    <input type="hidden" name="search_box" id="search_box" value="">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trunk_name" class="form-label fw-semibold required">Trunk Name</label>
                                <input type="text" class="form-control form-control-lg rounded-3" id="trunk_name" name="trunk_name" value="airtel" placeholder="Enter trunk name">
                                <div class="info-text">Unique identifier for this trunk</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trunk_description" class="form-label fw-semibold">Trunk Description</label>
                                <input type="text" class="form-control form-control-lg rounded-3" id="trunk_description" name="trunk_description" value="airtel" style="max-width: 200px;" placeholder="Short description">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="trunk_active" class="form-label fw-semibold">Trunk Status</label>
                                <select class="form-select form-select-lg rounded-3" id="trunk_active" name="trunk_active">
                                    <option value="Y" selected>Active</option>
                                    <option value="N">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="channels" class="form-label fw-semibold required">Channels</label>
                                <input type="number" class="form-control form-control-lg rounded-3" id="channels" name="channels" value="30" min="1" max="999" style="max-width: 120px;" placeholder="e.g. 30">
                                <div class="info-text">Maximum concurrent calls</div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="trunk_type" class="form-label fw-semibold required">Trunk Type</label>
                                <select class="form-select form-select-lg rounded-3" id="trunk_type" name="trunk_type" onchange="showRequiredFields(this.value,'PSTN,VOIP,Direct-IP');">
                                    <option value="PSTN">PSTN</option>
                                    <option value="VOIP" selected>VOIP</option>
                                    <option value="Direct-IP">Direct-IP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Direct-IP Settings -->
                    <div id="Direct-IP_span" class="trunk-type-section d-none">
                        <h5 class="trunk-type-title"><i class="fas fa-network-wired me-2"></i>Direct-IP Configuration</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="direct_ip_address" class="form-label fw-semibold required">IP Address</label>
                                    <input type="text" class="form-control rounded-3" id="direct_ip_address" name="direct_ip_address" value="" placeholder="e.g. 192.168.1.100">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- PSTN Settings -->
                    <div id="PSTN_span" class="trunk-type-section d-none">
                        <h5 class="trunk-type-title"><i class="fas fa-phone-alt me-2"></i>PSTN Configuration</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pstn_technology" class="form-label fw-semibold">Technology</label>
                                    <select class="form-select rounded-3" id="pstn_technology" name="pstn_technology">
                                        <option value="dahdi">DAHDI</option>
                                        <option value="zap">Zap</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pstn_zap_dahdi_id" class="form-label fw-semibold required">DAHDI/Zap ID</label>
                                    <input type="text" class="form-control rounded-3" id="pstn_zap_dahdi_id" name="pstn_zap_dahdi_id" value="" style="max-width: 120px;" placeholder="e.g. g0">
                                    <div class="info-text">Example: r0, r1, g0, g1, etc.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- VOIP Settings -->
                    <div id="VOIP_span" class="trunk-type-section">
                        <h5 class="trunk-type-title"><i class="fas fa-voicemail me-2"></i>VOIP Configuration</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Custom Settings</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="custom_setting_yes" name="voip_custom_settings" value="Y" onclick="showRequiredFields(this.id,'custom_setting_yes,custom_setting_no_1,custom_setting_no_2,custom_setting_no_3');" checked>
                                    <label class="form-check-label fw-medium" for="custom_setting_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="custom_setting_no" name="voip_custom_settings" value="N" onclick="showRequiredFields(this.id,'custom_setting_yes,custom_setting_no_1,custom_setting_no_2,custom_setting_no_3');">
                                    <label class="form-check-label fw-medium" for="custom_setting_no">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Custom Settings Yes -->
                        <div id="custom_setting_yes_span" class="fieldset">
                            <div class="mb-3">
                                <label for="voip_account_details" class="form-label fw-semibold required">SIP Account Configuration</label>
                                <textarea class="form-control rounded-3" id="voip_account_details" name="voip_account_details" rows="8" placeholder="Enter SIP account configuration">[airtel]
host=rj.ims.airtel.in
username=+911414397100@rj.ims.airtel.in
fromuser=+911414397100@rj.ims.airtel.in
secret=Emrigr#1
type=peer
qualify=yes
insecure=port,invite
disallow=all
allow=alaw
dtmfmode=rfc2833
fromdomain=rj.ims.airtel.in
outboundproxy=10.5.109.101
context=from-pstn
sendrpid=yes</textarea>
                                <div class="info-text">Enter the complete SIP account configuration</div>
                            </div>
                        </div>
                        
                        <!-- Custom Settings No -->
                        <div id="custom_setting_no_1_span" class="d-none">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="voip_account_id" class="form-label fw-semibold required">Account ID</label>
                                        <input type="text" class="form-control rounded-3" id="voip_account_id" name="voip_account_id" value="" placeholder="Enter account ID">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="voip_password" class="form-label fw-semibold required">Password</label>
                                        <input type="password" class="form-control rounded-3" id="voip_password" name="voip_password" value="" placeholder="Enter password">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="voip_host_ip_address" class="form-label fw-semibold required">Host/Provider IP Address</label>
                                        <input type="text" class="form-control rounded-3" id="voip_host_ip_address" name="voip_host_ip_address" value="" placeholder="e.g. 192.168.1.100">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="voip_type" class="form-label fw-semibold">Type</label>
                                        <select class="form-select rounded-3" id="voip_type" name="voip_type">
                                            <option value="peer">Peer</option>
                                            <option value="friend">Friend</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="voip_context" class="form-label fw-semibold">Context</label>
                                <input type="text" class="form-control rounded-3" id="voip_context" name="voip_context" value="" placeholder="Enter context">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                        <button type="button" class="btn btn-secondary btn-lg px-4 rounded-3" onclick="postURL('/ConVoxCCS/Admin/index.php?current_page=0&pcount=1&search_box=&user_sel_menu=Outbound Trunks','false');return false;">
                            <i class="fas fa-times me-2"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg px-4 rounded-3" onclick="return formValidation();">
                            <i class="fas fa-save me-2"></i> Update Trunk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showRequiredFields(value, fields) {
            // Hide all fields first
            const fieldArray = fields.split(',');
            for (const field of fieldArray) {
                const element = document.getElementById(field + '_span');
                if (element) {
                    element.classList.add('d-none');
                }
            }
            
            // Show the selected field
            const selectedElement = document.getElementById(value + '_span');
            if (selectedElement) {
                selectedElement.classList.remove('d-none');
            }
            
            // Handle radio button case
            if (value === 'custom_setting_yes') {
                document.getElementById('custom_setting_yes_span').classList.remove('d-none');
                document.getElementById('custom_setting_no_1_span').classList.add('d-none');
            } else if (value === 'custom_setting_no') {
                document.getElementById('custom_setting_yes_span').classList.add('d-none');
                document.getElementById('custom_setting_no_1_span').classList.remove('d-none');
            }
        }
        
        function allowValidKey(event, type) {
            // In a real implementation, this would validate key input
            return true;
        }
        
        function isExists(field, table, column, idField, idValue, formType) {
            // In a real implementation, this would check if value exists in database
            return true;
        }
        
        function formValidation() {
            // In a real implementation, this would validate the form
            const trunkName = document.getElementById('trunk_name').value;
            const channels = document.getElementById('channels').value;
            
            if (!trunkName) {
                alert('Please enter a trunk name');
                return false;
            }
            
            if (!channels || channels < 1) {
                alert('Please enter a valid number of channels');
                return false;
            }
            
            // Show success message
            alert('Trunk configuration updated successfully!');
            return true;
        }
        
        function postURL(url, param) {
            // In a real implementation, this would navigate to the URL
            if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                alert('Would navigate to: ' + url);
            }
            return false;
        }
        
        // Initialize form based on current selections
        document.addEventListener('DOMContentLoaded', function() {
            showRequiredFields('VOIP', 'PSTN,VOIP,Direct-IP');
        });
    </script>
</body>
</html>