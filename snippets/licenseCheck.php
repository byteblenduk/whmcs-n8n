<?php
// Calls the custom License check function and returns the error message if applicable or continues with the code

$licenseValid = licenseCheck($params['configoption1']);
if ($licenseValid !== true) {
    // If the license check failed, return the error message
    return $licenseValid;
}

// Custom function for checking & caching the license key

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