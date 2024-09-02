# Setting Up a Respond to Webhook Node in n8n

The **Respond to Webhook** node in n8n allows you to send a response back to the sender (e.g., a WHMCS module) after processing a webhook. This is crucial for ensuring that the WHMCS module receives the correct success or failure response.

## Step-by-Step Instructions

### 1. Add a Webhook Node

1. **Drag and drop** a **Webhook** node into your n8n workflow.
2. Set the **HTTP Method** to `POST`
3. Configure the **Webhook URL** by setting the path according to the path rules documentation.
4. Set **Authentication** to `Header Auth` and create a **Credential**. This will be your bearer key needed when setting up a product.
5. Set **Respond** to `Using 'Respond to Webhook' Node`.

### 2. Process Incoming Data

1. Add any other nodes needed to process the data received from the webhook.
2. Ensure that your workflow processes the data as required before sending a response.

### 3. Add the Respond to Webhook Node

1. **Drag and drop** the **Respond to Webhook** node into your workflow after the processing nodes.
2. **Connect** it to the previous node(s) to ensure it runs after the data is processed.

### 4. Configure the Respond to Webhook Node

1. **Click on the Respond to Webhook node** to open its settings.

2. **Set the Response Mode:**
   - Choose `JSON` from the dropdown to manually specify the JSON response.
   - Click **Add option** and choose `Response Code`

3. **Configure the JSON Response:**
   - To respond with success:
     1. Set `Response Code` to `200`.
     2. Set the `Body` field to the following JSON:
        ```json
        {
            "success": true
        }
        ```
   - To respond with failure:
     1. Set `Response Code` to any non-200 status code (e.g., `400`).
     2. Set the `Body` field to the following JSON:
        ```json
        {
            "error": "Your error description here",
            "message": "Detailed error message explaining the issue."
        }
        ```


### 5. Save and Execute Workflow

1. **Save** your workflow configuration.
2. **Execute** the workflow to ensure everything is set up correctly.
3. Test the webhook by sending a request from your WHMCS module or any HTTP client (e.g., Postman).

### 6. Test and Debug

- Ensure that the WHMCS module logs a success or failure based on the response from this node.
- Use n8n’s **Execution List** to debug and ensure the workflow is responding as expected.

### Example Configuration for Success Response

Here’s a snapshot of how your Respond to Webhook node should be configured for a successful response:

- **Response Mode:** JSON
- **Response Code:** `200`
- **Body:**
  ```json
  {
      "success": true
  }
Example Configuration for Failure Response
For a failure response, configure the node as follows:

- **Response Mode:** JSON
- **Response Code:** `400` (or any non-200 code)
- **Body:**
  ```json
  {
      "error": "Invalid Data",
      "message": "Required fields are missing."
  }
Conclusion
With the Respond to Webhook node correctly set up, your n8n workflow will be able to communicate the outcome of its execution back to the WHMCS module or any other webhook sender. This ensures that success or failure is properly logged and displayed in WHMCS.
