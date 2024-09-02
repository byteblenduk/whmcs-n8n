# n8n Webhook Integration Module Documentation

## Logging Responses

This module interacts with an n8n webhook to handle requests and log the outcomes. The logging behaviour depends on the JSON response returned by the webhook.

### Successful Responses

For a response to be logged as **successful**, the webhook in n8n must:

1. **Respond with a JSON body** containing `"success": true`.
2. **Return an HTTP status code of `200`**.

#### Example JSON Response for Success

```json
{
    "success": true
}
```

When the webhook returns this response, the module will log the request as successful and return `'success'` to the WHMCS page.

### Failure Responses

For a response to be logged as a **failure**, the webhook in n8n must:

1. **Respond with a JSON body** containing both an `"error"` and a `"message"` field.
2. **Return any HTTP status code other than `200`**.

#### Example JSON Response for Failure

```json
{
    "error": "Invalid request",
    "message": "The request data was missing required fields."
}
```

When the webhook returns this response:

- The module will log the request as failed.
- The failure message displayed on the WHMCS page will be formatted as: 
  ```
  statusCode: message details
  ```
  For example, `400: The request data was missing required fields.`

### Summary of Requirements

- **Success:**
  - JSON body: `"success": true`
  - HTTP status code: `200`

- **Failure:**
  - JSON body: `"error": ""`, `"message": ""`
  - Any HTTP status code other than `200`

Ensure that your n8n workflows are configured to return the appropriate JSON body and status codes based on the success or failure of the task, as outlined above.
```

### Notes:
- Replace `"data": "Additional optional data here"` with any other optional data you may want to include in the successful response.
- Make sure that your n8n workflow nodes are correctly configured to return the JSON body and HTTP status codes as described.
