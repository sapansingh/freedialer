<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disposition Set</title>
</head>
<body style="margin:0;padding:20px;font-family:Arial,sans-serif;background-color:#f5f5f5;">
    <div style="max-width:800px;margin:0 auto;background-color:white;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);padding:20px;">
        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <td colspan="7" align="center">
                    <fieldset style="width:84%;border-radius:8px;border:1px solid #ccc;padding:15px;">
                        <legend style="font-weight:bold;padding:0 10px;"><b>Disposition Set</b></legend>
                        <table width="90%" style="font-family:arial;" border="0">
                            <tbody>
                                <tr>
                                    <td colspan="3" align="center" nowrap>
                                        <button 
                                            title="Get Disposition" 
                                            onmouseover="this.style.cursor='pointer'" 
                                            style="padding:0;border:none;background:none;color:#81C081;" 
                                            onclick="openWindowpostURL('add_records.php?file=dispositions.php&amp;mode_form=EDITFORM&amp;action=add&amp;add_type=PROCESS&amp;process=ConVox_Process','Disposition_Details','width=800px,height=350px,top=150px,left=450px,scrollbars=yes');return false;">
                                            <span style="color:green;font-weight:bold;font-size:13px;text-decoration:underline;">Add Disposition</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="font-size:13px">
                                        <fieldset style="border-radius:8px;border:1px solid #ccc;padding:10px;">
                                            <legend style="font-weight:bold;padding:0 5px;"><b>Available Dispositions</b></legend>
                                            <select name="available_dispositions[]" id="available_dispositions" class="cool" size="5" multiple="multiple" style="width:190px;">
                                                <option value="DNC">DNC-Do Not Call</option>
                                                <option value="CB">CB-Call Back</option>
                                                <option value="Sale">Sale-Sale Made</option>
                                                <option value="Busy">Busy-Line Busy</option>
                                                <option value="NoAns">NoAns-No Answer</option>
                                            </select>
                                        </fieldset>
                                    </td>
                                    <td align="center" style="vertical-align:middle;">
                                        <br>
                                        <input type="button" value="&gt;" style="background:#0272a7;width:50px;border-radius:8px;color:white;border:none;padding:5px;cursor:pointer;" onclick="move_right('available_dispositions','selected_dispositions')">
                                        <br><br>
                                        <input type="button" value="&lt;" style="background:#0272a7;width:50px;border-radius:8px;color:white;border:none;padding:5px;cursor:pointer;" onclick="move_left('selected_dispositions','available_dispositions')">
                                    </td>
                                    <td align="center" style="font-size:13px">
                                        <fieldset style="border-radius:8px;border:1px solid #ccc;padding:10px;">
                                            <legend style="font-weight:bold;padding:0 5px;"><b>Selected Dispositions</b></legend>
                                            <select name="selected_dispositions[]" id="selected_dispositions" size="5" multiple="multiple" style="width:190px;">
                                                <option value="Test">Test-Test Call</option>
                                                <option value="NI">NI-Not Interested</option>
                                            </select>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center" style="padding-top:15px;">
                                        <button style="background:#0272a7;color:white;border:none;border-radius:8px;padding:8px 15px;cursor:pointer;" onclick="saveDispositions()">Save Dispositions</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>
    </div>

    <script>
        function move_right(fromId, toId) {
            const fromSelect = document.getElementById(fromId);
            const toSelect = document.getElementById(toId);
            
            for (let i = 0; i < fromSelect.options.length; i++) {
                if (fromSelect.options[i].selected) {
                    toSelect.appendChild(fromSelect.options[i]);
                    i--; // Adjust index after removal
                }
            }
        }

        function move_left(fromId, toId) {
            const fromSelect = document.getElementById(fromId);
            const toSelect = document.getElementById(toId);
            
            for (let i = 0; i < fromSelect.options.length; i++) {
                if (fromSelect.options[i].selected) {
                    toSelect.appendChild(fromSelect.options[i]);
                    i--; // Adjust index after removal
                }
            }
        }

        function openWindowpostURL(url, name, options) {
            // In a real implementation, this would open a popup window
            alert('In a real implementation, this would open: ' + url);
        }

        function saveDispositions() {
            const selectedDispositions = document.getElementById('selected_dispositions');
            const selectedValues = [];
            
            for (let i = 0; i < selectedDispositions.options.length; i++) {
                selectedValues.push(selectedDispositions.options[i].value);
            }
            
            alert('Selected dispositions: ' + selectedValues.join(', '));
            // In a real implementation, this would save to a server
        }
    </script>
</body>
</html>