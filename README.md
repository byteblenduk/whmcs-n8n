# whmcs-n8n
WHMCS Plugin to trigger n8n flows using api requests

# WHMCS Provisioning Module for n8n

## Introduction

This WHMCS provisioning module allows you to trigger workflows within an [n8n](https://n8n.io/) instance directly from WHMCS. It is designed to automate processes by triggering n8n flows upon specific events in WHMCS. 

**Note:** This module has been tested with self-hosted n8n instances. Compatibility with n8n's hosted (cloud) version has not been confirmed.

## Features

- **Trigger n8n Flows**: Automatically trigger workflows in your n8n instance based on actions within WHMCS.
- **WebHooks Integration**: Utilises n8n's Webhooks feature to initiate flows.
- **Status Handling**: Returns success only if n8n responds with a `200 OK` status; otherwise, a failure message is returned.
- **Customisable**: Easy to configure with any n8n workflow by adjusting the module settings.

## Requirements

Ensure your environment meets the following requirements before installation:

- **WHMCS Version**: 7.0 or higher
- **PHP Version**: 7.2 or higher
- **MySQL Version**: 5.6 or higher
- **n8n Instance**: Self-hosted n8n instance with flows created for receiving webhooks
- **Curl Enabled**: Yes

## n8n Setup

Before configuring the WHMCS module, you'll need to prepare your n8n instance:

1. **Create a Bearer token within n8n**: Set webhooks authentication to header auth, with "Authorization" as the name and "Bearer {your_token_here}" as the value. A token of 32 characters is recommended.
2. **Create a Workflow**: Design your workflow within n8n that will be triggered by WHMCS. 
3. **Set Webhook URL**: The workflow should start with a webhook node, which will be triggered by the WHMCS module. Note down the webhook URL.
4. **Configure Response**: Ensure that the n8n workflow is set up to return a `200 OK` status code upon successful completion. Any other status code or response will be interpreted as a failure by WHMCS.

## Installation

### Step 1: Download the Module

Clone the repository from GitHub:

```bash
git clone https://github.com/yourusername/whmcs-n8n-provisioning-module.git