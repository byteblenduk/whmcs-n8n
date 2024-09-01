<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
/**
 * Define module related meta data.
 *
 * Values returned here are used to determine module related abilities and
 * settings.
 *
 * @see https://developers.whmcs.com/provisioning-modules/meta-data-params/
 *
 * @return array
 */
function whmcs_n8n_MetaData()
{
    return array(
        'DisplayName' => 'n8n Provisioning Module',
        'APIVersion' => '1.1',
        'RequiresServer' => false,
    );
}

/**
 * Define product configuration options.
 *
 * The values you return here define the configuration options that are
 * presented to a user when configuring a product for use with the module. These
 * values are then made available in all module function calls with the key name
 * configoptionX - with X being the index number of the field from 1 to 24.
 *
 * You can specify up to 24 parameters, with field types:
 * * text
 * * password
 * * yesno
 * * dropdown
 * * radio
 * * textarea
 *
 * Examples of each and their possible configuration parameters are provided in
 * this sample function.
 *
 * @see https://developers.whmcs.com/provisioning-modules/config-options/
 *
 * @return array
 */
function whmcs_n8n_ConfigOptions()
{
    return array(
        'n8n Host' => array(
            'Type' => 'text',
            'Size' => '32',
            'Default' => 'http://localhost',
            'Description' => 'Enter the hostname for your n8n instance',
        ),
        'n8n Key' => array(
            'Type' => 'text',
            'Size' => '32',
            'Default' => 'api key',
            'Description' => 'Header authorisation 32 character bearer token',
        ),
        'Create Endpoint' => array(
            'Type' => 'text',
            'Size' => '32',
            'Default' => '/createaccount',
            'Description' => 'Create account endpoint, added onto host above',
        ),
        'Suspend Endpoint' => array(
            'Type' => 'text',
            'Size' => '32',
            'Default' => '/suspendaccount',
            'Description' => 'Suspend account endpoint, added onto host above',
        ),
        'Unsuspend Endpoint' => array(
            'Type' => 'text',
            'Size' => '32',
            'Default' => '/unsuspendaccount',
            'Description' => 'Unsuspend account endpoint, added onto host above',
        ),
        'Terminate Endpoint' => array(
            'Type' => 'text',
            'Size' => '32',
            'Default' => '/terminateaccount',
            'Description' => 'Terminate account endpoint, added onto host above',
        ),
        'Change Password Endpoint' => array(
            'Type' => 'text',
            'Size' => '32',
            'Default' => '/changepassword',
            'Description' => 'Change password endpoint, added onto host above',
        ),
    );
}

/**
 * Provision a new instance of a product/service.
 *
 * Attempt to provision a new instance of a given product/service. This is
 * called any time provisioning is requested inside of WHMCS. Depending upon the
 * configuration, this can be any of:
 * * When a new order is placed
 * * When an invoice for a new order is paid
 * * Upon manual request by an admin user
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return string "success" or an error message
 */
function whmcs_n8n_CreateAccount(array $params)
{
    $apiUrl = "{$params['configoption1']}{$params['configoption3']}";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $params['configoption2']
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


/**
 * Suspend an instance of a product/service.
 *
 * Called when a suspension is requested. This is invoked automatically by WHMCS
 * when a product becomes overdue on payment or can be called manually by admin
 * user.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return string "success" or an error message
 */
function whmcs_n8n_SuspendAccount(array $params)
{
    $apiUrl = "{$params['configoption1']}{$params['configoption4']}";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $params['configoption2']
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

/**
 * Un-suspend instance of a product/service.
 *
 * Called when an un-suspension is requested. This is invoked
 * automatically upon payment of an overdue invoice for a product, or
 * can be called manually by admin user.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return string "success" or an error message
 */
function whmcs_n8n_UnsuspendAccount(array $params)
{
    $apiUrl = "{$params['configoption1']}{$params['configoption5']}";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $params['configoption2']
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


/**
 * Terminate instance of a product/service.
 *
 * Called when a termination is requested. This can be invoked automatically for
 * overdue products if enabled, or requested manually by an admin user.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return string "success" or an error message
 */
function whmcs_n8n_TerminateAccount(array $params)
{
    $apiUrl = "{$params['configoption1']}{$params['configoption6']}";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $params['configoption2']
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

/**
 * Change the password for an instance of a product/service.
 *
 * Called when a password change is requested. This can occur either due to a
 * client requesting it via the client area or an admin requesting it from the
 * admin side.
 *
 * This option is only available to client end users when the product is in an
 * active status.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return string "success" or an error message
 */
function whmcs_n8n_ChangePassword(array $params)
{
    $apiUrl = "{$params['configoption1']}{$params['configoption7']}";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $params['configoption2']
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

/**
 * Upgrade or downgrade an instance of a product/service.
 *
 * Called to apply any change in product assignment or parameters. It
 * is called to provision upgrade or downgrade orders, as well as being
 * able to be invoked manually by an admin user.
 *
 * This same function is called for upgrades and downgrades of both
 * products and configurable options.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return string "success" or an error message
 */
function whmcs_n8n_ChangePackage(array $params)
{
    try {
        // Call the service's change password function, using the values
        // provided by WHMCS in `$params`.
        //
        // A sample `$params` array may be defined as:
        //
        // ```
        // array(
        //     'username' => 'The service username',
        //     'configoption1' => 'The new service disk space',
        //     'configoption3' => 'Whether or not to enable FTP',
        // )
        // ```
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'whmcs_n8n',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Renew an instance of a product/service.
 *
 * Attempt to renew an existing instance of a given product/service. This is
 * called any time a product/service invoice has been paid. 
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return string "success" or an error message
 */
function whmcs_n8n_Renew(array $params)
{
    try {
        // Call the service's provisioning function, using the values provided
        // by WHMCS in `$params`.
        //
        // A sample `$params` array may be defined as:
        //
        // ```
        // array(
        //     'domain' => 'The domain of the service to provision',
        //     'username' => 'The username to access the new service',
        //     'password' => 'The password to access the new service',
        //     'configoption1' => 'The amount of disk space to provision',
        //     'configoption2' => 'The new services secret key',
        //     'configoption3' => 'Whether or not to enable FTP',
        //     ...
        // )
        // ```
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'whmcs_n8n',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Test connection with the given server parameters.
 *
 * Allows an admin user to verify that an API connection can be
 * successfully made with the given configuration parameters for a
 * server.
 *
 * When defined in a module, a Test Connection button will appear
 * alongside the Server Type dropdown when adding or editing an
 * existing server.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return array
 */
function whmcs_n8n_TestConnection(array $params)
{
    try {
        // Call the service's connection test function.

        $success = true;
        $errorMsg = '';
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'whmcs_n8n',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        $success = false;
        $errorMsg = $e->getMessage();
    }

    return array(
        'success' => $success,
        'error' => $errorMsg,
    );
}

/**
 * Additional actions an admin user can invoke.
 *
 * Define additional actions that an admin user can perform for an
 * instance of a product/service.
 *
 * @see whmcs_n8n_buttonOneFunction()
 *
 * @return array
 */
function whmcs_n8n_AdminCustomButtonArray()
{
    return array(
        "Button 1 Display Value" => "buttonOneFunction",
        "Button 2 Display Value" => "buttonTwoFunction",
    );
}

/**
 * Additional actions a client user can invoke.
 *
 * Define additional actions a client user can perform for an instance of a
 * product/service.
 *
 * Any actions you define here will be automatically displayed in the available
 * list of actions within the client area.
 *
 * @return array
 */
function whmcs_n8n_ClientAreaCustomButtonArray()
{
    return array(
        "Action 1 Display Value" => "actionOneFunction",
        "Action 2 Display Value" => "actionTwoFunction",
    );
}

/**
 * Custom function for performing an additional action.
 *
 * You can define an unlimited number of custom functions in this way.
 *
 * Similar to all other module call functions, they should either return
 * 'success' or an error message to be displayed.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 * @see whmcs_n8n_AdminCustomButtonArray()
 *
 * @return string "success" or an error message
 */
function whmcs_n8n_buttonOneFunction(array $params)
{
    try {
        // Call the service's function, using the values provided by WHMCS in
        // `$params`.
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'whmcs_n8n',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Custom function for performing an additional action.
 *
 * You can define an unlimited number of custom functions in this way.
 *
 * Similar to all other module call functions, they should either return
 * 'success' or an error message to be displayed.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 * @see whmcs_n8n_ClientAreaCustomButtonArray()
 *
 * @return string "success" or an error message
 */
function whmcs_n8n_actionOneFunction(array $params)
{
    try {
        // Call the service's function, using the values provided by WHMCS in
        // `$params`.
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'whmcs_n8n',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Admin services tab additional fields.
 *
 * Define additional rows and fields to be displayed in the admin area service
 * information and management page within the clients profile.
 *
 * Supports an unlimited number of additional field labels and content of any
 * type to output.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 * @see whmcs_n8n_AdminServicesTabFieldsSave()
 *
 * @return array
 */
function whmcs_n8n_AdminServicesTabFields(array $params)
{
    try {
        // Call the service's function, using the values provided by WHMCS in
        // `$params`.
        $response = array();

        // Return an array based on the function's response.
        return array(
            'Number of Apples' => (int) $response['numApples'],
            'Number of Oranges' => (int) $response['numOranges'],
            'Last Access Date' => date("Y-m-d H:i:s", $response['lastLoginTimestamp']),
            'Something Editable' => '<input type="hidden" name="whmcs_n8n_original_uniquefieldname" '
                . 'value="' . htmlspecialchars($response['textvalue']) . '" />'
                . '<input type="text" name="whmcs_n8n_uniquefieldname"'
                . 'value="' . htmlspecialchars($response['textvalue']) . '" />',
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'whmcs_n8n',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        // In an error condition, simply return no additional fields to display.
    }

    return array();
}

/**
 * Execute actions upon save of an instance of a product/service.
 *
 * Use to perform any required actions upon the submission of the admin area
 * product management form.
 *
 * It can also be used in conjunction with the AdminServicesTabFields function
 * to handle values submitted in any custom fields which is demonstrated here.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 * @see whmcs_n8n_AdminServicesTabFields()
 */
function whmcs_n8n_AdminServicesTabFieldsSave(array $params)
{
    // Fetch form submission variables.
    $originalFieldValue = isset($_REQUEST['whmcs_n8n_original_uniquefieldname'])
        ? $_REQUEST['whmcs_n8n_original_uniquefieldname']
        : '';

    $newFieldValue = isset($_REQUEST['whmcs_n8n_uniquefieldname'])
        ? $_REQUEST['whmcs_n8n_uniquefieldname']
        : '';

    // Look for a change in value to avoid making unnecessary service calls.
    if ($originalFieldValue != $newFieldValue) {
        try {
            // Call the service's function, using the values provided by WHMCS
            // in `$params`.
        } catch (Exception $e) {
            // Record the error in WHMCS's module log.
            logModuleCall(
                'whmcs_n8n',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
            );

            // Otherwise, error conditions are not supported in this operation.
        }
    }
}

/**
 * Perform single sign-on for a given instance of a product/service.
 *
 * Called when single sign-on is requested for an instance of a product/service.
 *
 * When successful, returns a URL to which the user should be redirected.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return array
 */
function whmcs_n8n_ServiceSingleSignOn(array $params)
{
    try {
        // Call the service's single sign-on token retrieval function, using the
        // values provided by WHMCS in `$params`.
        $response = array();

        return array(
            'success' => true,
            'redirectTo' => $response['redirectUrl'],
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'whmcs_n8n',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return array(
            'success' => false,
            'errorMsg' => $e->getMessage(),
        );
    }
}

/**
 * Perform single sign-on for a server.
 *
 * Called when single sign-on is requested for a server assigned to the module.
 *
 * This differs from ServiceSingleSignOn in that it relates to a server
 * instance within the admin area, as opposed to a single client instance of a
 * product/service.
 *
 * When successful, returns a URL to which the user should be redirected to.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return array
 */
function whmcs_n8n_AdminSingleSignOn(array $params)
{
    try {
        // Call the service's single sign-on admin token retrieval function,
        // using the values provided by WHMCS in `$params`.
        $response = array();

        return array(
            'success' => true,
            'redirectTo' => $response['redirectUrl'],
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'whmcs_n8n',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return array(
            'success' => false,
            'errorMsg' => $e->getMessage(),
        );
    }
}

/**
 * Client area output logic handling.
 *
 * This function is used to define module specific client area output. It should
 * return an array consisting of a template file and optional additional
 * template variables to make available to that template.
 *
 * The template file you return can be one of two types:
 *
 * * tabOverviewModuleOutputTemplate - The output of the template provided here
 *   will be displayed as part of the default product/service client area
 *   product overview page.
 *
 * * tabOverviewReplacementTemplate - Alternatively using this option allows you
 *   to entirely take control of the product/service overview page within the
 *   client area.
 *
 * Whichever option you choose, extra template variables are defined in the same
 * way. This demonstrates the use of the full replacement.
 *
 * Please Note: Using tabOverviewReplacementTemplate means you should display
 * the standard information such as pricing and billing details in your custom
 * template or they will not be visible to the end user.
 *
 * @param array $params common module parameters
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return array
 */
function whmcs_n8n_ClientArea(array $params)
{
    // Determine the requested action and set service call parameters based on
    // the action.
    $requestedAction = isset($_REQUEST['customAction']) ? $_REQUEST['customAction'] : '';

    if ($requestedAction == 'manage') {
        $serviceAction = 'get_usage';
        $templateFile = 'templates/manage.tpl';
    } else {
        $serviceAction = 'get_stats';
        $templateFile = 'templates/overview.tpl';
    }

    try {
        // Call the service's function based on the request action, using the
        // values provided by WHMCS in `$params`.
        $response = array();

        $extraVariable1 = 'abc';
        $extraVariable2 = '123';

        return array(
            'tabOverviewReplacementTemplate' => $templateFile,
            'templateVariables' => array(
                'extraVariable1' => $extraVariable1,
                'extraVariable2' => $extraVariable2,
            ),
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'whmcs_n8n',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        // In an error condition, display an error page.
        return array(
            'tabOverviewReplacementTemplate' => 'error.tpl',
            'templateVariables' => array(
                'usefulErrorHelper' => $e->getMessage(),
            ),
        );
    }
}

/**
Custom function for license checking.
Not integrated yet and may be unused,
mainly for testing purposes.
*/
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