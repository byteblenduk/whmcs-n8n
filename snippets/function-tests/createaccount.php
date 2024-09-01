<?php

/* Function called when creating a new account, including a license key
** check and 200 status code.
**
** Variables usually retrieved from $params will be set towards the end
** of the file, along with a test $params array
*/
function whmcs_n8n_CreateAccount(array $params)
{
    $licenseValid = licenseCheck($params['configoption1']);
    if ($licenseValid !== true) {
        // If the license check failed, return the error message
        return $licenseValid;
    }
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

function licenseCheck($licenseKey) {
    $cacheFile = __DIR__ . '/license_cache.json';
    $cacheLifetime = 600; // 10 minutes

    // Check if the cache file exists and is still valid
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheLifetime) {
        $cachedData = json_decode(file_get_contents($cacheFile), true);
        if ($cachedData['status'] === 'valid') {
            return true;
        }
    }

    // Perform API call to validate the license
    $apiUrl = "https://billing.vps.dfps.co.uk/api/guest/serviceapikey/get_info";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['key' => $licenseKey]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $errorMessage = curl_error($ch);
        logModuleCall('whmcs_n8n', __FUNCTION__, $licenseKey, $errorMessage, curl_getinfo($ch));
        curl_close($ch);
        return 'Failed: cURL Error: ' . $errorMessage;
    }
    curl_close($ch);

    $response = json_decode($response, true);

    // Handle the response
    if (isset($response['error']) && $response['error'] !== null) {
        if ($response['error']['message'] === 'API key does not exist') {
            if (file_exists($cacheFile)) {
                unlink($cacheFile);
            }
            return "Error: License key not found!";
        }
    }

    if (isset($response['result'])) {
        if ($response['result']['valid'] === false) {
            if (file_exists($cacheFile)) {
                unlink($cacheFile);
            }
            return "Error: License key no longer valid!";
        }

        if ($response['result']['valid'] === true && $response['result']['config']['software'] !== 'whmcsn8n') {
            if (file_exists($cacheFile)) {
                unlink($cacheFile);
            }
            return "Error: License key not for this software!";
        }

        if ($response['result']['valid'] === true && $response['result']['config']['software'] === 'whmcsn8n') {
            // License is valid and software matches, so proceed with the next steps
            $cacheData = [
                'timestamp' => time(),
                'license' => $licenseKey,
                'status' => 'valid'
            ];
            file_put_contents($cacheFile, json_encode($cacheData));
            return true;
        }
    }

    // If none of the conditions are met, return a generic error
    return "Error: Unexpected API response.";
}

$licenseKey = 'CF39DA59-F5649937-C8A6B525-747D3D80';
$apiKey = 'kAUXn9exMmsdW6fxnvhX62eCnDPFuVgR';
$params = [
    'configoption1' => $licenseKey,
    'configoption2' => 'https://n8n.vps.dfps.co.uk',
    'configoption3' => 'webhook-test/createaccount',
    'configoption4' => $apiKey
];

print_r($params);

testingResult = whmcs_n8n_createAccount($params);

echo $testingResult;