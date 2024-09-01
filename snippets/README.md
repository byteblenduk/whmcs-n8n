# License Check Snippet

This PHP snippet is designed to perform license validation for your WHMCS module using an external API. The script includes a custom function, `licenseCheck`, which checks if a license key is valid, caches the result, and allows further code execution based on the validation result.

## Contents

### 1. License Validation

The script begins by calling the `licenseCheck` function, passing in the license key stored in `$params['configoption1']`.

```php
$licenseValid = licenseCheck($params['configoption1']);
if ($licenseValid !== true) {
    // If the license check failed, return the error message
    return $licenseValid;
}
```

- **If the license is valid:** The script continues with the execution of subsequent code.
- **If the license is invalid:** The function returns an appropriate error message, preventing further code execution.

### 2. `licenseCheck` Function

The `licenseCheck` function performs the following steps:

1. **Cache Validation:**
   - Checks if a cache file (`license_cache.json`) exists and is still valid (less than 10 minutes old).
   - If the cache is valid and indicates the license is valid, the function returns `true`.

2. **API Call:**
   - If no valid cache is found, the function makes an API call to the FOSSBilling service to validate the license key.

3. **Response Handling:**
   - The function checks the API response for various conditions:
     - If the license key does not exist, it deletes the cache file and returns an error.
     - If the license key is invalid or does not match the expected software (`whmcsn8n`), it deletes the cache file and returns an appropriate error message.
     - If the license is valid and matches the software, it caches the result and returns `true`.

4. **Error Handling:**
   - If the API call fails (e.g., due to a cURL error), the function logs the error and returns an error message.
   - If none of the expected conditions are met, a generic error message is returned.

### Example Response Handling:

```php
if (isset($response['error']) && $response['error'] !== null) {
    if ($response['error']['message'] === 'API key does not exist') {
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
        return "Error: License key not found!";
    }
}
```

## Usage

To use this snippet:

1. Save the `licenseCheck.php` file in your desired location within your project.
2. Include or require this file in your WHMCS module where license validation is needed.
3. Replace `$params['configoption1']` with the actual parameter holding your license key if necessary.

This function ensures your software's license is validated and cached efficiently, providing a secure mechanism for controlling access to licensed features.

## License

This script is open for modification and integration into your project as needed.

---
