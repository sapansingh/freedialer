<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Selection Interface</title>
    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .container {
            max-width: 900px;
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #4361ee;
        }
        
        .queue-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding: 0.5rem;
            background-color: #e9ecef;
            border-radius: 6px;
        }
        
        .selected-count {
            font-weight: 600;
            color: #0272a7;
        }
        
        .queue-search {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-list me-2"></i>Queue Selection Interface</h1>
            <p class="text-muted">Select and manage queues for user assignment</p>
        </div>
        
        <div class="queue-search">
            <div class="input-group input-group-sm">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" id="queueSearch" class="form-control" placeholder="Search queues..." onkeyup="filterQueues()">
            </div>
        </div>
        
        <table style="border:2px solid #6BCBCA;border-radius:15px; width:100%;"> 
            <tbody>
                <tr> 
                    <td width="120px" align="center">
                        <font color="#000000">Queues <b>:</b> </font>
                    </td>
                    <td width="200px" align="center">
                        <fieldset style="font-family:arial;font-size:13px;border-radius:15px;">
                            <legend style="margin-left:15px;">Available Queues</legend>
                            <select name="queue_from[]" id="queue_from" size="5" multiple="multiple" style="width:150px;">
                                <option value="Sales_Queue">Sales Queue</option>
                                <option value="Support_Queue">Support Queue</option>
                                <option value="Billing_Queue">Billing Queue</option>
                                <option value="Technical_Queue">Technical Queue</option>
                                <option value="Emergency_Queue">Emergency Queue</option>
                                <option value="VIP_Queue">VIP Queue</option>
                                <option value="General_Queue">General Queue</option>
                                <option value="Callback_Queue">Callback Queue</option>
                                <option value="Outbound_Queue">Outbound Queue</option>
                                <option value="Inbound_Queue">Inbound Queue</option>
                                <option value="Service_Queue">Service Queue</option>
                                <option value="Complaint_Queue">Complaint Queue</option>
                                <option value="Feedback_Queue">Feedback Queue</option>
                                <option value="Retention_Queue">Retention Queue</option>
                                <option value="Collection_Queue">Collection Queue</option>
                            </select>
                        </fieldset>
                    </td>
                    <td width="80px" align="center" valign="middle">
                        <input type="button" value="&gt;" style="background:#0272a7;width:50px;border-radius:8px;color:white;" onclick="move_right();"><br> <br>
                        <input type="button" value="&lt;" style="background:#0272a7;width:50px;border-radius:8px;color:white;" onclick="move_left();">
                        <br><br>
                        <input type="button" value="&gt;&gt;" style="background:#0272a7;width:50px;border-radius:8px;color:white;" onclick="move_all_right();"><br> <br>
                        <input type="button" value="&lt;&lt;" style="background:#0272a7;width:50px;border-radius:8px;color:white;" onclick="move_all_left();">
                    </td>
                    <td width="200px" align="center">
                        <fieldset style="border-radius:15px;font-family:arial;font-size:13px;">
                            <legend style="margin-left:15px;">Selected Queues</legend>
                            <select name="selected_queues[]" id="selected_queues" size="5" multiple="multiple" style="width:150px;">			
                                <!-- Selected queues will appear here -->
                            </select>
                        </fieldset>	
                    </td>
                    <td width="100px" align="center">
                        <input type="button" style="border-radius:8px;width:70px;background:#0272a7;color:white;" name="top" id="top" value="Top" onclick="move_top()">
                        <br>
                        <input type="button" style="border-radius:8px;width:70px;background:#0272a7;color:white;" name="up" id="up" value="Up" onclick="move_up()">
                        <br>
                        <input type="button" style="border-radius:8px;width:70px;background:#0272a7;color:white;" name="down" id="down" value="Down" onclick="move_down()">
                        <br>
                        <input type="button" style="width:70px;border-radius:8px;background:#0272a7;color:white;" name="bottom" id="bottom" value="Bottom" onclick="move_bottom()">
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="queue-info">
            <div>
                <span id="selectedCount" class="selected-count">0</span> queues selected
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearAll()">
                <i class="fas fa-trash me-1"></i> Clear All
            </button>
        </div>
        
        <div class="mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Selected Queues Preview</h5>
                </div>
                <div class="card-body">
                    <div id="selectedQueuesDisplay">No queues selected</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script>
        // Queue movement functions
        function move_right() {
            const fromSelect = document.getElementById('queue_from');
            const toSelect = document.getElementById('selected_queues');
            
            for (let i = 0; i < fromSelect.options.length; i++) {
                if (fromSelect.options[i].selected) {
                    toSelect.appendChild(fromSelect.options[i]);
                    i--; // Adjust index after removal
                }
            }
            updateAssignedQueues();
        }

        function move_left() {
            const fromSelect = document.getElementById('selected_queues');
            const toSelect = document.getElementById('queue_from');
            
            for (let i = 0; i < fromSelect.options.length; i++) {
                if (fromSelect.options[i].selected) {
                    toSelect.appendChild(fromSelect.options[i]);
                    i--; // Adjust index after removal
                }
            }
            updateAssignedQueues();
        }

        function move_all_right() {
            const fromSelect = document.getElementById('queue_from');
            const toSelect = document.getElementById('selected_queues');
            
            while (fromSelect.options.length > 0) {
                toSelect.appendChild(fromSelect.options[0]);
            }
            updateAssignedQueues();
        }

        function move_all_left() {
            const fromSelect = document.getElementById('selected_queues');
            const toSelect = document.getElementById('queue_from');
            
            while (fromSelect.options.length > 0) {
                toSelect.appendChild(fromSelect.options[0]);
            }
            updateAssignedQueues();
        }

        function move_top() {
            const select = document.getElementById('selected_queues');
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].selected) {
                    select.insertBefore(select.options[i], select.firstChild);
                }
            }
            updateAssignedQueues();
        }

        function move_up() {
            const select = document.getElementById('selected_queues');
            for (let i = 1; i < select.options.length; i++) {
                if (select.options[i].selected && !select.options[i-1].selected) {
                    select.insertBefore(select.options[i], select.options[i-1]);
                }
            }
            updateAssignedQueues();
        }

        function move_down() {
            const select = document.getElementById('selected_queues');
            for (let i = select.options.length - 2; i >= 0; i--) {
                if (select.options[i].selected && !select.options[i+1].selected) {
                    select.insertBefore(select.options[i+1], select.options[i]);
                }
            }
            updateAssignedQueues();
        }

        function move_bottom() {
            const select = document.getElementById('selected_queues');
            for (let i = 0; i < select.options.length - 1; i++) {
                if (select.options[i].selected) {
                    select.appendChild(select.options[i]);
                    i--; // Adjust index after removal
                }
            }
            updateAssignedQueues();
        }

        function clearAll() {
            const fromSelect = document.getElementById('selected_queues');
            const toSelect = document.getElementById('queue_from');
            
            while (fromSelect.options.length > 0) {
                toSelect.appendChild(fromSelect.options[0]);
            }
            updateAssignedQueues();
        }

        function filterQueues() {
            const input = document.getElementById('queueSearch');
            const filter = input.value.toLowerCase();
            const select = document.getElementById('queue_from');
            
            for (let i = 0; i < select.options.length; i++) {
                const option = select.options[i];
                const text = option.text.toLowerCase();
                option.style.display = text.includes(filter) ? '' : 'none';
            }
        }

        function updateAssignedQueues() {
            const selectedQueues = document.getElementById('selected_queues');
            const queues = [];
            for (let i = 0; i < selectedQueues.options.length; i++) {
                queues.push(selectedQueues.options[i].value);
            }
            document.getElementById('selectedCount').textContent = queues.length;
            
            // Update display
            const displayElement = document.getElementById('selectedQueuesDisplay');
            if (queues.length > 0) {
                displayElement.innerHTML = '<div class="d-flex flex-wrap gap-2">' + 
                    queues.map(queue => `<span class="badge bg-primary">${queue}</span>`).join('') + 
                    '</div>';
            } else {
                displayElement.textContent = 'No queues selected';
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateAssignedQueues();
        });
    </script>
</body>
</html>