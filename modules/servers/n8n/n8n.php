<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

// Require any libraries needed for the module to function.
// require_once __DIR__ . '/path/to/library/loader.php';
//
// Also, perform any initialization required by the service's library.

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
function n8n_MetaData()
{
    return array(
        'DisplayName' => 'n8n Provisioning Module',
        'APIVersion' => '1.1', // Use API Version 1.1
        'RequiresServer' => false, // Set true if module requires a server to work
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
function n8n_ConfigOptions()
{
    return array(
        'n8nUrl' => array(
            'Type' => 'text',
            'Size' => '25',
            'Default' => 'n8nurl.here',
            'Description' => 'Set your n8n instance url here, this will be to your login page and not to an individual webhook. Must be a https connection.',
            'Name' => 'n8n Instance Url',
            'SimpleMode' => true,
        ),
        'n8nApiKey' => array(
            'Type' => 'password',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Enter your header authorisation key here, read the docs to see how to set this up within n8n.',
            'Name' => 'n8n Authorisation Key',
            'SimpleMode' => true,
        ),
        'baseEndpoint' => array(
            'Type' => 'text',
            'Size' => '25',
            'Default' => 'whmcs',
            'Description' => 'Your base webhook endpoint as set in your n8n flows webhook path. Read the docs to check how this is used.',
            'Name' => 'n8n Webhook Base Endpoint',
            'SimpleMode' => true,
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
function n8n_CreateAccount(array $params) {
    $result = n8n_WebhookPostRequest($params,__FUNCTION__);
    logModuleCall('n8n', __FUNCTION__, $params, $result, null, array($params['configoption2']));
    return $result;
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
function n8n_SuspendAccount(array $params) {
$result = n8n_WebhookPostRequest($params,__FUNCTION__);
    logModuleCall('n8n', __FUNCTION__, $params, $result, null, array($params['configoption2']));
    return $result;
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
function n8n_UnsuspendAccount(array $params) {
$result = n8n_WebhookPostRequest($params,__FUNCTION__);
    logModuleCall('n8n', __FUNCTION__, $params, $result, null, array($params['configoption2']));
    return $result;
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
function n8n_TerminateAccount(array $params) {
$result = n8n_WebhookPostRequest($params,__FUNCTION__);
    logModuleCall('n8n', __FUNCTION__, $params, $result, null, array($params['configoption2']));
    return $result;
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
function n8n_ChangePassword(array $params) {
$result = n8n_WebhookPostRequest($params,__FUNCTION__);
    logModuleCall('n8n', __FUNCTION__, $params, $result, null, array($params['configoption2']));
    return $result;
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
function n8n_ChangePackage(array $params) {
$result = n8n_WebhookPostRequest($params,__FUNCTION__);
    logModuleCall('n8n', __FUNCTION__, $params, $result, null, array($params['configoption2']));
    return $result;
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
function n8n_Renew(array $params) {
$result = n8n_WebhookPostRequest($params,__FUNCTION__);
    logModuleCall('n8n', __FUNCTION__, $params, $result, null, array($params['configoption2']));
    return $result;
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
function n8n_TestConnection(array $params) {
$result = n8n_WebhookPostRequest($params,__FUNCTION__);
    logModuleCall('n8n', __FUNCTION__, $params, $result, null, array($params['configoption2']));
    return $result;
}
/**
 * Additional actions an admin user can invoke.
 *
 * Define additional actions that an admin user can perform for an
 * instance of a product/service.
 *
 * @see n8n_buttonOneFunction()
 *
 * @return array
 */
/**
function n8n_AdminCustomButtonArray()
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
/**
function n8n_ClientAreaCustomButtonArray()
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
 * @see n8n_AdminCustomButtonArray()
 *
 * @return string "success" or an error message
 */
/**
function n8n_buttonOneFunction(array $params)
{
    try {
        // Call the service's function, using the values provided by WHMCS in
        // `$params`.
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'n8n',
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
 * @see n8n_ClientAreaCustomButtonArray()
 *
 * @return string "success" or an error message
 */
/**
function n8n_actionOneFunction(array $params)
{
    try {
        // Call the service's function, using the values provided by WHMCS in
        // `$params`.
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'n8n',
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
 * @see n8n_AdminServicesTabFieldsSave()
 *
 * @return array
 */
/**
function n8n_AdminServicesTabFields(array $params)
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
            'Something Editable' => '<input type="hidden" name="n8n_original_uniquefieldname" '
                . 'value="' . htmlspecialchars($response['textvalue']) . '" />'
                . '<input type="text" name="n8n_uniquefieldname"'
                . 'value="' . htmlspecialchars($response['textvalue']) . '" />',
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'n8n',
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
 * @see n8n_AdminServicesTabFields()
 */
/**
function n8n_AdminServicesTabFieldsSave(array $params)
{
    // Fetch form submission variables.
    $originalFieldValue = isset($_REQUEST['n8n_original_uniquefieldname'])
        ? $_REQUEST['n8n_original_uniquefieldname']
        : '';

    $newFieldValue = isset($_REQUEST['n8n_uniquefieldname'])
        ? $_REQUEST['n8n_uniquefieldname']
        : '';

    // Look for a change in value to avoid making unnecessary service calls.
    if ($originalFieldValue != $newFieldValue) {
        try {
            // Call the service's function, using the values provided by WHMCS
            // in `$params`.
        } catch (Exception $e) {
            // Record the error in WHMCS's module log.
            logModuleCall(
                'n8n',
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
/**
function n8n_ServiceSingleSignOn(array $params)
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
            'n8n',
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
/**
function n8n_AdminSingleSignOn(array $params)
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
            'n8n',
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
/*
function n8n_ClientArea(array $params)
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
            'n8n',
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
*/
function n8n_WebhookPostRequest($params,$functionCalled) {
    // Get the function name, remove 'n8n_' prefix, and convert to lowercase
    $function = strtolower(str_replace('n8n_', '', $functionCalled));
    
    // Retrieve and sanitize the host configuration option
    $host = $params['configoption1'];
    // Remove 'http://' or 'https://' from the beginning of the URL
    $host = preg_replace('#^https?://#', '', $host);
    // Remove trailing slash if present
    $host = rtrim($host, '/');
    
    // Retrieve and sanitize the base endpoint configuration option
    $baseEndpoint = isset($params['configoption3']) ? $params['configoption3'] : '';
    // Remove leading slash if present
    $baseEndpoint = ltrim($baseEndpoint, '/');
    // Remove trailing slash if present
    $baseEndpoint = rtrim($baseEndpoint, '/');
    
    // Construct the API URL
    if (empty($baseEndpoint)) {
        // If base endpoint is empty, construct URL without it
        $apiUrl = "https://{$host}/webhook/{$function}";
    } else {
        // If base endpoint is provided, include it in the URL
        $apiUrl = "https://{$host}/webhook/{$baseEndpoint}/{$function}";
    }

    // Prepare the cURL request
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    // Encode the parameters as JSON
    $jsonPayload = json_encode($params);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return 'Failed: JSON encoding error: ' . json_last_error_msg();
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);

    // Set the headers, including authorization
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $params['configoption2']
    ));

    // Set timeout and enable SSL verification
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Handle cURL errors
    if (curl_errno($ch)) {
        $errorMessage = curl_error($ch);
        logModuleCall('n8n', __FUNCTION__, $jsonPayload, $errorMessage, null, array($params['configoption2']));
        curl_close($ch);
        return 'Failed: cURL Error: ' . $errorMessage;
    }

    curl_close($ch);

    // Log and handle the API response
    $decodedResponse = json_decode($response, true);
    if ($httpCode == 200) {
        if (json_last_error() === JSON_ERROR_NONE && isset($decodedResponse['success']) && $decodedResponse['success']) {
            logModuleCall('n8n', __FUNCTION__, $jsonPayload, $response, $decodedResponse, array($params['configoption2']));
            return 'success';
        } else {
            $errorMessage = isset($decodedResponse['message']) ? $decodedResponse['message'] : 'Unknown error';
            logModuleCall('n8n', __FUNCTION__, $jsonPayload, $response, $decodedResponse, array($params['configoption2']));
            return "Failed: " . $errorMessage;
        }
    } else {
        logModuleCall('n8n', __FUNCTION__, $jsonPayload, $response, $decodedResponse, array($params['configoption2']));
        return $httpCode . ": " . $decodedResponse['message'];
    }
}
