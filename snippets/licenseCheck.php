// Calls the custom License check function and returns the error message if applicable or continues with the code

$licenseValid = licenseCheck($params['configoption1']);
if ($licenseValid !== true) {
    // If the license check failed, return the error message
    return $licenseValid;
}

// Custom function for checking & caching the license key

