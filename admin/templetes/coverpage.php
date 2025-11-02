<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Selection Interface</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-header {
            background: white;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-left: 4px solid #4361ee;
        }
        
        .page-header h1 {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .process-selection-table {
            border: 2px solid #6BCBCA;
            border-radius: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            margin: 10px 0;
        }

        .fieldset-legend {
            font-family: arial;
            font-size: 13px;
            margin-left: 15px;
        }

        .convox-button {
            background: #0272a7;
            border-radius: 8px;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
            width: 50px;
        }

        .convox-button:hover {
            background: #025a87;
        }
        
        .form-select {
            height: 120px;
        }
        
        .login-box {
            border: 1px solid blue;
            background-color: #d6d7d8;
            border-radius: 15px;
            margin: 0 auto;
            padding: 0;
        }

        .login-box th {
            background: #0272a7;
            border-radius: 15px 15px 0 0;
            font-size: 16px;
            color: white;
            padding: 10px;
        }

        .login-box td {
            padding: 8px 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1 class="h3 mb-1"><i class="fas fa-cogs me-2 text-primary"></i>Process Selection Interface</h1>
            <p class="text-muted mb-0">Select and manage processes for user assignment</p>
        </div>
        
        <div class="login-box">
            <table class="w-100">
                <tr> 
                    <th align="center" colspan="8"><font color="White">&nbsp;PROCESS SELECTION</font></th>
                    <th align="right" style="background:#0272a7;border-radius:0px 15px 0px 0px;">
                        <button type="button" class="btn-close btn-close-white" style="background:none; border:none; color:white; font-size:1.2rem;">×</button>
                    </th> 
                </tr>	
                <tr>
                    <td colspan="9">
                        <div class="process-selection-table">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td name="process_all_td" id="process_all_td" style="">
                                            <input type="checkbox" name="process_all" id="process_all" value="ALL" class="form-check-input"> 
                                            <label class="form-check-label">ALL</label>
                                        </td>
                                        <td>
                                            <table id="super_process_table" class="w-100">
                                                <tbody>
                                                    <tr name="process_admin" id="process_admin">
                                                        <td>
                                                            <fieldset class="border p-2">
                                                                <legend class="fieldset-legend">Available Processes</legend>
                                                                <select name="processfrom" id="processfrom" size="5" multiple="multiple" class="form-select">
                                                                    <option value="Complaint">Complaint</option>
                                                                    <option value="ConVox_Process">ConVox_Process</option>
                                                                    <option value="EMRI_PROCESS">EMRI_PROCESS</option>
                                                                    <option value="merit_A1">merit_A1</option>
                                                                    <option value="merit_R1">merit_R1</option>
                                                                    <option value="merit_R10">merit_R10</option>
                                                                    <option value="merit_R11">merit_R11</option>
                                                                    <option value="Merit_R13">Merit_R13</option>
                                                                    <option value="Merit_R14">Merit_R14</option>
                                                                    <option value="Merit_R15">Merit_R15</option>
                                                                    <option value="Merit_R16">Merit_R16</option>
                                                                    <option value="Merit_R17">Merit_R17</option>
                                                                    <option value="merit_R2">merit_R2</option>
                                                                    <option value="merit_R3">merit_R3</option>
                                                                    <option value="merit_R4">merit_R4</option>
                                                                    <option value="merit_R5">merit_R5</option>
                                                                    <option value="merit_R5_1">merit_R5_1</option>
                                                                    <option value="merit_R6">merit_R6</option>
                                                                    <option value="merit_R7">merit_R7</option>
                                                                    <option value="merit_R8">merit_R8</option>
                                                                    <option value="merit_R9">merit_R9</option>
                                                                    <option value="merit_tool">merit_tool</option>
                                                                    <option value="vehicle_release">vehicle_release</option>
                                                                </select>
                                                            </fieldset>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="convox-button mb-2" onclick="moveProcessRight()">&gt;</button><br>
                                                            <button type="button" class="convox-button" onclick="moveProcessLeft()">&lt;</button>
                                                            <br><br>
                                                            <button type="button" class="convox-button mb-2" onclick="moveAllProcessRight()">&gt;&gt;</button><br>
                                                            <button type="button" class="convox-button" onclick="moveAllProcessLeft()">&lt;&lt;</button>
                                                        </td>
                                                        <td>
                                                            <fieldset class="border p-2">
                                                                <legend class="fieldset-legend">Selected Processes</legend>
                                                                <select name="processto" id="processto" size="5" multiple="multiple" class="form-select"></select>
                                                            </fieldset>
                                                            <input type="hidden" name="admin_process" id="admin_process" value="">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="9" class="pt-3 pb-3">
                        <button type="button" class="convox-button me-3" style="width: auto; padding: 8px 20px;" onclick="saveSelection()">SAVE SELECTION</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="clearSelection()">CLEAR ALL</button>
                    </td> 
                </tr>
            </table>
        </div>
        
        <div class="mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Selected Processes</h5>
                </div>
                <div class="card-body">
                    <div id="selectedProcessesDisplay">No processes selected</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    
    <script>
        // Process movement functions
        function moveProcessRight() {
            const fromSelect = document.getElementById('processfrom');
            const toSelect = document.getElementById('processto');
            
            for (let i = 0; i < fromSelect.options.length; i++) {
                if (fromSelect.options[i].selected) {
                    toSelect.appendChild(fromSelect.options[i]);
                    i--;
                }
            }
            updateProcessSelection();
        }

        function moveProcessLeft() {
            const fromSelect = document.getElementById('processto');
            const toSelect = document.getElementById('processfrom');
            
            for (let i = 0; i < fromSelect.options.length; i++) {
                if (fromSelect.options[i].selected) {
                    toSelect.appendChild(fromSelect.options[i]);
                    i--;
                }
            }
            updateProcessSelection();
        }

        function moveAllProcessRight() {
            const fromSelect = document.getElementById('processfrom');
            const toSelect = document.getElementById('processto');
            
            while (fromSelect.options.length > 0) {
                toSelect.appendChild(fromSelect.options[0]);
            }
            updateProcessSelection();
        }

        function moveAllProcessLeft() {
            const fromSelect = document.getElementById('processto');
            const toSelect = document.getElementById('processfrom');
            
            while (fromSelect.options.length > 0) {
                toSelect.appendChild(fromSelect.options[0]);
            }
            updateProcessSelection();
        }

        function updateProcessSelection() {
            const selectedProcesses = document.getElementById('processto');
            const processes = [];
            for (let i = 0; i < selectedProcesses.options.length; i++) {
                processes.push(selectedProcesses.options[i].value);
            }
            document.getElementById('admin_process').value = processes.join(', ');
            
            // Update display
            const displayElement = document.getElementById('selectedProcessesDisplay');
            if (processes.length > 0) {
                displayElement.innerHTML = '<div class="d-flex flex-wrap gap-2">' + 
                    processes.map(process => `<span class="badge bg-primary">${process}</span>`).join('') + 
                    '</div>';
            } else {
                displayElement.textContent = 'No processes selected';
            }
        }

        function saveSelection() {
            const selectedProcesses = document.getElementById('processto');
            const processes = [];
            for (let i = 0; i < selectedProcesses.options.length; i++) {
                processes.push(selectedProcesses.options[i].value);
            }
            
            if (processes.length === 0) {
                alert('Please select at least one process');
                return;
            }
            
            alert('Processes saved successfully: ' + processes.join(', '));
            console.log('Selected processes:', processes);
        }

        function clearSelection() {
            const fromSelect = document.getElementById('processto');
            const toSelect = document.getElementById('processfrom');
            
            while (fromSelect.options.length > 0) {
                toSelect.appendChild(fromSelect.options[0]);
            }
            updateProcessSelection();
        }

        // Handle ALL checkbox
        document.getElementById('process_all').addEventListener('change', function() {
            if (this.checked) {
                moveAllProcessRight();
            } else {
                moveAllProcessLeft();
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateProcessSelection();
        });
    </script>
</body>
</html>