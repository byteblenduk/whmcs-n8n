<?php
function n8n_CreateAccount($params) {
    $apiUrl = "{$params['configoption2']}{$params['configoption4']}";
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $params['configoption3']
        ));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        $errorMessage = curl_error($ch);
        logModuleCall('whmcs_n8n',__FUNCTION__,$params,$errorMessage,curl_getinfo($ch));
        curl_close($ch);
        return 'Failed: cURL Error: ' . $errorMessage;
    }
    curl_close($ch);
    if ($httpCode == 200) {
        return 'success';
    } else {
        return "Failed: Request failed with status code: " . $httpCode;
    }
}
