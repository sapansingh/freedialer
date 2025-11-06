<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
include('../../config/config.php');

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . mysqli_connect_error()]));
}

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Get the action parameter
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'getAll':
            getAllProcesses($conn);
            break;
        case 'get':
            $id = $_GET['id'] ?? 0;
            getProcess($conn, $id);
            break;
        case 'create':
            createProcess($conn);
            break;
        case 'update':
            updateProcess($conn);
            break;
        case 'delete':
            deleteProcess($conn);
            break;
        case 'getStats':
            getProcessStats($conn);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

mysqli_close($conn);

function getAllProcesses($conn) {
    $sql = "SELECT 
                sno, process, process_description, process_type, active, 
                callerid, outbound_type, outbound_broadcast_action, 
                outbound_broadcast_file_id, outbound_predictive_pacing, 
                outbound_predictive_drop_percentage, outbound_answering_machine_status, 
                outbound_cache_size, phone_1, phone_2, phone_3, phone_4, phone_5, 
                dispositions_set, breaks_set, inbound_did, inbound_greeting_file_id, 
                accept_input, inbound_type, timeout, retries, auto_fall_queue, 
                default_queue, inbound_queue_priority, inbound_queue_dtmf, 
                dial_prefix, extension, channels, crm_id, verifier_transfer, 
                verifier_queue, verifier_crm_id, verifier_mandatory_fields, 
                verifier_optional_fields, allow_q, agent_not_available_file, 
                buffer_level, lead_order, start_dialing, dialable_statuses, 
                auto_wrapup, auto_wrapup_time, dnc_check, script_name, 
                agent_tab_order, webform, webform_type, list_selection, 
                number_masking, outbound_route_id, progressive_dialing_sec, 
                rec_file_name_order, agent_wise_dialing, ndnc_check, 
                mandatory_disposition, mandatory_sub_disposition, 
                mandatory_sub_sub_disposition, auto_missed, auto_firstlogin, 
                auto_outbound, auto_missed_time, auto_firstlogin_time, 
                auto_outbound_time, chatbot
            FROM process_details 
            ORDER BY sno DESC";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $processes = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $processes[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $processes]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching processes: ' . mysqli_error($conn)]);
    }
}

function getProcess($conn, $id) {
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'Process ID is required']);
        return;
    }

    $id = (int)$id;
    $sql = "SELECT 
                sno, process, process_description, process_type, active, 
                callerid, outbound_type, outbound_broadcast_action, 
                outbound_broadcast_file_id, outbound_predictive_pacing, 
                outbound_predictive_drop_percentage, outbound_answering_machine_status, 
                outbound_cache_size, phone_1, phone_2, phone_3, phone_4, phone_5, 
                dispositions_set, breaks_set, inbound_did, inbound_greeting_file_id, 
                accept_input, inbound_type, timeout, retries, auto_fall_queue, 
                default_queue, inbound_queue_priority, inbound_queue_dtmf, 
                dial_prefix, extension, channels, crm_id, verifier_transfer, 
                verifier_queue, verifier_crm_id, verifier_mandatory_fields, 
                verifier_optional_fields, allow_q, agent_not_available_file, 
                buffer_level, lead_order, start_dialing, dialable_statuses, 
                auto_wrapup, auto_wrapup_time, dnc_check, script_name, 
                agent_tab_order, webform, webform_type, list_selection, 
                number_masking, outbound_route_id, progressive_dialing_sec, 
                rec_file_name_order, agent_wise_dialing, ndnc_check, 
                mandatory_disposition, mandatory_sub_disposition, 
                mandatory_sub_sub_disposition, auto_missed, auto_firstlogin, 
                auto_outbound, auto_missed_time, auto_firstlogin_time, 
                auto_outbound_time, chatbot
            FROM process_details 
            WHERE sno = $id";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $process = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'data' => $process]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Process not found']);
    }
}

function createProcess($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $required = ['process'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    // Escape all input values
    $process = mysqli_real_escape_string($conn, $input['process']);
    $process_description = mysqli_real_escape_string($conn, $input['process_description'] ?? '');
    $process_type = mysqli_real_escape_string($conn, $input['process_type'] ?? 'none');
    $active = mysqli_real_escape_string($conn, $input['active'] ?? 'N');
    $callerid = mysqli_real_escape_string($conn, $input['callerid'] ?? '');
    $outbound_type = mysqli_real_escape_string($conn, $input['outbound_type'] ?? 'none');
    $outbound_broadcast_action = mysqli_real_escape_string($conn, $input['outbound_broadcast_action'] ?? 'PFAH');
    $outbound_broadcast_file_id = (int)($input['outbound_broadcast_file_id'] ?? 0);
    $outbound_predictive_pacing = mysqli_real_escape_string($conn, $input['outbound_predictive_pacing'] ?? '1');
    $outbound_predictive_drop_percentage = (int)($input['outbound_predictive_drop_percentage'] ?? 3);
    $outbound_answering_machine_status = mysqli_real_escape_string($conn, $input['outbound_answering_machine_status'] ?? 'N');
    $outbound_cache_size = mysqli_real_escape_string($conn, $input['outbound_cache_size'] ?? '100');
    $phone_1 = mysqli_real_escape_string($conn, $input['phone_1'] ?? 'Y');
    $phone_2 = mysqli_real_escape_string($conn, $input['phone_2'] ?? 'N');
    $phone_3 = mysqli_real_escape_string($conn, $input['phone_3'] ?? 'N');
    $phone_4 = mysqli_real_escape_string($conn, $input['phone_4'] ?? 'N');
    $phone_5 = mysqli_real_escape_string($conn, $input['phone_5'] ?? 'N');
    $dispositions_set = mysqli_real_escape_string($conn, $input['dispositions_set'] ?? '');
    $breaks_set = mysqli_real_escape_string($conn, $input['breaks_set'] ?? '');
    $inbound_did = mysqli_real_escape_string($conn, $input['inbound_did'] ?? '');
    $inbound_greeting_file_id = (int)($input['inbound_greeting_file_id'] ?? 0);
    $accept_input = mysqli_real_escape_string($conn, $input['accept_input'] ?? 'N');
    $inbound_type = mysqli_real_escape_string($conn, $input['inbound_type'] ?? 'direct-transfer');
    $timeout = mysqli_real_escape_string($conn, $input['timeout'] ?? '1000');
    $retries = (int)($input['retries'] ?? 0);
    $auto_fall_queue = mysqli_real_escape_string($conn, $input['auto_fall_queue'] ?? '');
    $default_queue = mysqli_real_escape_string($conn, $input['default_queue'] ?? '');
    $inbound_queue_priority = mysqli_real_escape_string($conn, $input['inbound_queue_priority'] ?? 'Y');
    $inbound_queue_dtmf = mysqli_real_escape_string($conn, $input['inbound_queue_dtmf'] ?? 'N');
    $dial_prefix = mysqli_real_escape_string($conn, $input['dial_prefix'] ?? '');
    $extension = mysqli_real_escape_string($conn, $input['extension'] ?? '');
    $channels = (int)($input['channels'] ?? 0);
    $crm_id = mysqli_real_escape_string($conn, $input['crm_id'] ?? '');
    $verifier_transfer = mysqli_real_escape_string($conn, $input['verifier_transfer'] ?? 'N');
    $verifier_queue = mysqli_real_escape_string($conn, $input['verifier_queue'] ?? '');
    $verifier_crm_id = mysqli_real_escape_string($conn, $input['verifier_crm_id'] ?? '');
    $verifier_mandatory_fields = mysqli_real_escape_string($conn, $input['verifier_mandatory_fields'] ?? '');
    $verifier_optional_fields = mysqli_real_escape_string($conn, $input['verifier_optional_fields'] ?? '');
    $allow_q = mysqli_real_escape_string($conn, $input['allow_q'] ?? 'Yes');
    $agent_not_available_file = mysqli_real_escape_string($conn, $input['agent_not_available_file'] ?? '0');
    $buffer_level = (int)($input['buffer_level'] ?? 0);
    $lead_order = mysqli_real_escape_string($conn, $input['lead_order'] ?? 'leads_by_asc');
    $start_dialing = mysqli_real_escape_string($conn, $input['start_dialing'] ?? 'N');
    $dialable_statuses = mysqli_real_escape_string($conn, $input['dialable_statuses'] ?? '');
    $auto_wrapup = mysqli_real_escape_string($conn, $input['auto_wrapup'] ?? 'N');
    $auto_wrapup_time = (int)($input['auto_wrapup_time'] ?? 10);
    $dnc_check = mysqli_real_escape_string($conn, $input['dnc_check'] ?? 'Y');
    $script_name = mysqli_real_escape_string($conn, $input['script_name'] ?? '');
    $agent_tab_order = mysqli_real_escape_string($conn, $input['agent_tab_order'] ?? '');
    $webform = mysqli_real_escape_string($conn, $input['webform'] ?? '');
    $webform_type = mysqli_real_escape_string($conn, $input['webform_type'] ?? 'SHOW');
    $list_selection = mysqli_real_escape_string($conn, $input['list_selection'] ?? 'SERIAL');
    $number_masking = mysqli_real_escape_string($conn, $input['number_masking'] ?? 'N');
    $outbound_route_id = (int)($input['outbound_route_id'] ?? 0);
    $progressive_dialing_sec = (int)($input['progressive_dialing_sec'] ?? 1);
    $rec_file_name_order = mysqli_real_escape_string($conn, $input['rec_file_name_order'] ?? '');
    $agent_wise_dialing = mysqli_real_escape_string($conn, $input['agent_wise_dialing'] ?? 'Y');
    $ndnc_check = mysqli_real_escape_string($conn, $input['ndnc_check'] ?? 'N');
    $mandatory_disposition = mysqli_real_escape_string($conn, $input['mandatory_disposition'] ?? 'N');
    $mandatory_sub_disposition = mysqli_real_escape_string($conn, $input['mandatory_sub_disposition'] ?? 'N');
    $mandatory_sub_sub_disposition = mysqli_real_escape_string($conn, $input['mandatory_sub_sub_disposition'] ?? 'N');
    $auto_missed = mysqli_real_escape_string($conn, $input['auto_missed'] ?? 'N');
    $auto_firstlogin = mysqli_real_escape_string($conn, $input['auto_firstlogin'] ?? 'N');
    $auto_outbound = mysqli_real_escape_string($conn, $input['auto_outbound'] ?? 'N');
    $auto_missed_time = (int)($input['auto_missed_time'] ?? 10);
    $auto_firstlogin_time = (int)($input['auto_firstlogin_time'] ?? 10);
    $auto_outbound_time = (int)($input['auto_outbound_time'] ?? 10);
    $chatbot = mysqli_real_escape_string($conn, $input['chatbot'] ?? '');

    $sql = "INSERT INTO process_details (
                process, process_description, process_type, active, callerid, 
                outbound_type, outbound_broadcast_action, outbound_broadcast_file_id, 
                outbound_predictive_pacing, outbound_predictive_drop_percentage, 
                outbound_answering_machine_status, outbound_cache_size, phone_1, 
                phone_2, phone_3, phone_4, phone_5, dispositions_set, breaks_set, 
                inbound_did, inbound_greeting_file_id, accept_input, inbound_type, 
                timeout, retries, auto_fall_queue, default_queue, inbound_queue_priority, 
                inbound_queue_dtmf, dial_prefix, extension, channels, crm_id, 
                verifier_transfer, verifier_queue, verifier_crm_id, 
                verifier_mandatory_fields, verifier_optional_fields, allow_q, 
                agent_not_available_file, buffer_level, lead_order, start_dialing, 
                dialable_statuses, auto_wrapup, auto_wrapup_time, dnc_check, 
                script_name, agent_tab_order, webform, webform_type, list_selection, 
                number_masking, outbound_route_id, progressive_dialing_sec, 
                rec_file_name_order, agent_wise_dialing, ndnc_check, 
                mandatory_disposition, mandatory_sub_disposition, 
                mandatory_sub_sub_disposition, auto_missed, auto_firstlogin, 
                auto_outbound, auto_missed_time, auto_firstlogin_time, 
                auto_outbound_time, chatbot
            ) VALUES (
                '$process', '$process_description', '$process_type', '$active', '$callerid',
                '$outbound_type', '$outbound_broadcast_action', $outbound_broadcast_file_id,
                '$outbound_predictive_pacing', $outbound_predictive_drop_percentage,
                '$outbound_answering_machine_status', '$outbound_cache_size', '$phone_1',
                '$phone_2', '$phone_3', '$phone_4', '$phone_5', '$dispositions_set', '$breaks_set',
                '$inbound_did', $inbound_greeting_file_id, '$accept_input', '$inbound_type',
                '$timeout', $retries, '$auto_fall_queue', '$default_queue', '$inbound_queue_priority',
                '$inbound_queue_dtmf', '$dial_prefix', '$extension', $channels, '$crm_id',
                '$verifier_transfer', '$verifier_queue', '$verifier_crm_id',
                '$verifier_mandatory_fields', '$verifier_optional_fields', '$allow_q',
                '$agent_not_available_file', $buffer_level, '$lead_order', '$start_dialing',
                '$dialable_statuses', '$auto_wrapup', $auto_wrapup_time, '$dnc_check',
                '$script_name', '$agent_tab_order', '$webform', '$webform_type', '$list_selection',
                '$number_masking', $outbound_route_id, $progressive_dialing_sec,
                '$rec_file_name_order', '$agent_wise_dialing', '$ndnc_check',
                '$mandatory_disposition', '$mandatory_sub_disposition',
                '$mandatory_sub_sub_disposition', '$auto_missed', '$auto_firstlogin',
                '$auto_outbound', $auto_missed_time, $auto_firstlogin_time,
                $auto_outbound_time, '$chatbot'
            )";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Process created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating process: ' . mysqli_error($conn)]);
    }
}

function updateProcess($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input['sno'])) {
        echo json_encode(['success' => false, 'message' => 'Process ID is required for update']);
        return;
    }

    $required = ['process'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $sno = (int)$input['sno'];
    $process = mysqli_real_escape_string($conn, $input['process']);
    $process_description = mysqli_real_escape_string($conn, $input['process_description'] ?? '');
    $process_type = mysqli_real_escape_string($conn, $input['process_type'] ?? 'none');
    $active = mysqli_real_escape_string($conn, $input['active'] ?? 'N');
    $callerid = mysqli_real_escape_string($conn, $input['callerid'] ?? '');
    $outbound_type = mysqli_real_escape_string($conn, $input['outbound_type'] ?? 'none');
    $outbound_broadcast_action = mysqli_real_escape_string($conn, $input['outbound_broadcast_action'] ?? 'PFAH');
    $outbound_broadcast_file_id = (int)($input['outbound_broadcast_file_id'] ?? 0);
    $outbound_predictive_pacing = mysqli_real_escape_string($conn, $input['outbound_predictive_pacing'] ?? '1');
    $outbound_predictive_drop_percentage = (int)($input['outbound_predictive_drop_percentage'] ?? 3);
    $outbound_answering_machine_status = mysqli_real_escape_string($conn, $input['outbound_answering_machine_status'] ?? 'N');
    $outbound_cache_size = mysqli_real_escape_string($conn, $input['outbound_cache_size'] ?? '100');
    $phone_1 = mysqli_real_escape_string($conn, $input['phone_1'] ?? 'Y');
    $phone_2 = mysqli_real_escape_string($conn, $input['phone_2'] ?? 'N');
    $phone_3 = mysqli_real_escape_string($conn, $input['phone_3'] ?? 'N');
    $phone_4 = mysqli_real_escape_string($conn, $input['phone_4'] ?? 'N');
    $phone_5 = mysqli_real_escape_string($conn, $input['phone_5'] ?? 'N');
    $dispositions_set = mysqli_real_escape_string($conn, $input['dispositions_set'] ?? '');
    $breaks_set = mysqli_real_escape_string($conn, $input['breaks_set'] ?? '');
    $inbound_did = mysqli_real_escape_string($conn, $input['inbound_did'] ?? '');
    $inbound_greeting_file_id = (int)($input['inbound_greeting_file_id'] ?? 0);
    $accept_input = mysqli_real_escape_string($conn, $input['accept_input'] ?? 'N');
    $inbound_type = mysqli_real_escape_string($conn, $input['inbound_type'] ?? 'direct-transfer');
    $timeout = mysqli_real_escape_string($conn, $input['timeout'] ?? '1000');
    $retries = (int)($input['retries'] ?? 0);
    $auto_fall_queue = mysqli_real_escape_string($conn, $input['auto_fall_queue'] ?? '');
    $default_queue = mysqli_real_escape_string($conn, $input['default_queue'] ?? '');
    $inbound_queue_priority = mysqli_real_escape_string($conn, $input['inbound_queue_priority'] ?? 'Y');
    $inbound_queue_dtmf = mysqli_real_escape_string($conn, $input['inbound_queue_dtmf'] ?? 'N');
    $dial_prefix = mysqli_real_escape_string($conn, $input['dial_prefix'] ?? '');
    $extension = mysqli_real_escape_string($conn, $input['extension'] ?? '');
    $channels = (int)($input['channels'] ?? 0);
    $crm_id = mysqli_real_escape_string($conn, $input['crm_id'] ?? '');
    $verifier_transfer = mysqli_real_escape_string($conn, $input['verifier_transfer'] ?? 'N');
    $verifier_queue = mysqli_real_escape_string($conn, $input['verifier_queue'] ?? '');
    $verifier_crm_id = mysqli_real_escape_string($conn, $input['verifier_crm_id'] ?? '');
    $verifier_mandatory_fields = mysqli_real_escape_string($conn, $input['verifier_mandatory_fields'] ?? '');
    $verifier_optional_fields = mysqli_real_escape_string($conn, $input['verifier_optional_fields'] ?? '');
    $allow_q = mysqli_real_escape_string($conn, $input['allow_q'] ?? 'Yes');
    $agent_not_available_file = mysqli_real_escape_string($conn, $input['agent_not_available_file'] ?? '0');
    $buffer_level = (int)($input['buffer_level'] ?? 0);
    $lead_order = mysqli_real_escape_string($conn, $input['lead_order'] ?? 'leads_by_asc');
    $start_dialing = mysqli_real_escape_string($conn, $input['start_dialing'] ?? 'N');
    $dialable_statuses = mysqli_real_escape_string($conn, $input['dialable_statuses'] ?? '');
    $auto_wrapup = mysqli_real_escape_string($conn, $input['auto_wrapup'] ?? 'N');
    $auto_wrapup_time = (int)($input['auto_wrapup_time'] ?? 10);
    $dnc_check = mysqli_real_escape_string($conn, $input['dnc_check'] ?? 'Y');
    $script_name = mysqli_real_escape_string($conn, $input['script_name'] ?? '');
    $agent_tab_order = mysqli_real_escape_string($conn, $input['agent_tab_order'] ?? '');
    $webform = mysqli_real_escape_string($conn, $input['webform'] ?? '');
    $webform_type = mysqli_real_escape_string($conn, $input['webform_type'] ?? 'SHOW');
    $list_selection = mysqli_real_escape_string($conn, $input['list_selection'] ?? 'SERIAL');
    $number_masking = mysqli_real_escape_string($conn, $input['number_masking'] ?? 'N');
    $outbound_route_id = (int)($input['outbound_route_id'] ?? 0);
    $progressive_dialing_sec = (int)($input['progressive_dialing_sec'] ?? 1);
    $rec_file_name_order = mysqli_real_escape_string($conn, $input['rec_file_name_order'] ?? '');
    $agent_wise_dialing = mysqli_real_escape_string($conn, $input['agent_wise_dialing'] ?? 'Y');
    $ndnc_check = mysqli_real_escape_string($conn, $input['ndnc_check'] ?? 'N');
    $mandatory_disposition = mysqli_real_escape_string($conn, $input['mandatory_disposition'] ?? 'N');
    $mandatory_sub_disposition = mysqli_real_escape_string($conn, $input['mandatory_sub_disposition'] ?? 'N');
    $mandatory_sub_sub_disposition = mysqli_real_escape_string($conn, $input['mandatory_sub_sub_disposition'] ?? 'N');
    $auto_missed = mysqli_real_escape_string($conn, $input['auto_missed'] ?? 'N');
    $auto_firstlogin = mysqli_real_escape_string($conn, $input['auto_firstlogin'] ?? 'N');
    $auto_outbound = mysqli_real_escape_string($conn, $input['auto_outbound'] ?? 'N');
    $auto_missed_time = (int)($input['auto_missed_time'] ?? 10);
    $auto_firstlogin_time = (int)($input['auto_firstlogin_time'] ?? 10);
    $auto_outbound_time = (int)($input['auto_outbound_time'] ?? 10);
    $chatbot = mysqli_real_escape_string($conn, $input['chatbot'] ?? '');

    $sql = "UPDATE process_details SET
                process = '$process',
                process_description = '$process_description',
                process_type = '$process_type',
                active = '$active',
                callerid = '$callerid',
                outbound_type = '$outbound_type',
                outbound_broadcast_action = '$outbound_broadcast_action',
                outbound_broadcast_file_id = $outbound_broadcast_file_id,
                outbound_predictive_pacing = '$outbound_predictive_pacing',
                outbound_predictive_drop_percentage = $outbound_predictive_drop_percentage,
                outbound_answering_machine_status = '$outbound_answering_machine_status',
                outbound_cache_size = '$outbound_cache_size',
                phone_1 = '$phone_1',
                phone_2 = '$phone_2',
                phone_3 = '$phone_3',
                phone_4 = '$phone_4',
                phone_5 = '$phone_5',
                dispositions_set = '$dispositions_set',
                breaks_set = '$breaks_set',
                inbound_did = '$inbound_did',
                inbound_greeting_file_id = $inbound_greeting_file_id,
                accept_input = '$accept_input',
                inbound_type = '$inbound_type',
                timeout = '$timeout',
                retries = $retries,
                auto_fall_queue = '$auto_fall_queue',
                default_queue = '$default_queue',
                inbound_queue_priority = '$inbound_queue_priority',
                inbound_queue_dtmf = '$inbound_queue_dtmf',
                dial_prefix = '$dial_prefix',
                extension = '$extension',
                channels = $channels,
                crm_id = '$crm_id',
                verifier_transfer = '$verifier_transfer',
                verifier_queue = '$verifier_queue',
                verifier_crm_id = '$verifier_crm_id',
                verifier_mandatory_fields = '$verifier_mandatory_fields',
                verifier_optional_fields = '$verifier_optional_fields',
                allow_q = '$allow_q',
                agent_not_available_file = '$agent_not_available_file',
                buffer_level = $buffer_level,
                lead_order = '$lead_order',
                start_dialing = '$start_dialing',
                dialable_statuses = '$dialable_statuses',
                auto_wrapup = '$auto_wrapup',
                auto_wrapup_time = $auto_wrapup_time,
                dnc_check = '$dnc_check',
                script_name = '$script_name',
                agent_tab_order = '$agent_tab_order',
                webform = '$webform',
                webform_type = '$webform_type',
                list_selection = '$list_selection',
                number_masking = '$number_masking',
                outbound_route_id = $outbound_route_id,
                progressive_dialing_sec = $progressive_dialing_sec,
                rec_file_name_order = '$rec_file_name_order',
                agent_wise_dialing = '$agent_wise_dialing',
                ndnc_check = '$ndnc_check',
                mandatory_disposition = '$mandatory_disposition',
                mandatory_sub_disposition = '$mandatory_sub_disposition',
                mandatory_sub_sub_disposition = '$mandatory_sub_sub_disposition',
                auto_missed = '$auto_missed',
                auto_firstlogin = '$auto_firstlogin',
                auto_outbound = '$auto_outbound',
                auto_missed_time = $auto_missed_time,
                auto_firstlogin_time = $auto_firstlogin_time,
                auto_outbound_time = $auto_outbound_time,
                chatbot = '$chatbot'
            WHERE sno = $sno";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Process updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating process: ' . mysqli_error($conn)]);
    }
}

function deleteProcess($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['sno'])) {
        echo json_encode(['success' => false, 'message' => 'Process ID is required for deletion']);
        return;
    }

    $sno = (int)$input['sno'];
    $sql = "DELETE FROM process_details WHERE sno = $sno";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Process deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting process: ' . mysqli_error($conn)]);
    }
}

function getProcessStats($conn) {
    $stats = [];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM process_details");
    $row = mysqli_fetch_assoc($result);
    $stats['totalProcesses'] = $row['total'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as active FROM process_details WHERE active = 'Y'");
    $row = mysqli_fetch_assoc($result);
    $stats['activeProcesses'] = $row['active'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as inbound FROM process_details WHERE process_type = 'inbound'");
    $row = mysqli_fetch_assoc($result);
    $stats['inboundProcesses'] = $row['inbound'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as outbound FROM process_details WHERE process_type = 'outbound'");
    $row = mysqli_fetch_assoc($result);
    $stats['outboundProcesses'] = $row['outbound'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as blended FROM process_details WHERE process_type = 'blended'");
    $row = mysqli_fetch_assoc($result);
    $stats['blendedProcesses'] = $row['blended'];

    echo json_encode(['success' => true, 'data' => $stats]);
}
?>