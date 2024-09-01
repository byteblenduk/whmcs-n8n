<?php

/* Function called when creating a new account, including a license key
** check and 200 status code.
**
** Variables usually retrieved from $params will be set towards the end
** of the file, along with a test $params array
*/
function whmcs_n8n_CreateAccount(array $params)
{
    $apiUrl = "{$params['configoption2']}{$params['configoption3']}";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $params['configoption4']
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
        return 'Failed: Request failed with status code: ' . $httpCode;
    }
}

$licenseKey = 'CF39DA59-F5649937-C8A6B525-747D3D80';
$apiKey = 'kAUXn9exMmsdW6fxnvhX62eCnDPFuVgR';
$params = [
    'configoption1' => $licenseKey,
    'configoption2' => 'https://n8n.vps.dfps.co.uk',
    'configoption3' => 'test/createaccount',
    'configoption4' => $apiKey
];

print_r($params);

testingResult = whmcs_n8n_createAccount($params)

echo $testingResult