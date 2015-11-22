Mattermost plugin for Kanboard
==============================

Receive Kanboard notifications on Mattermost.

Author
------

- Frederic Guillot
- License MIT

Installation
------------

- Create a folder **plugins/Mattermost** or uncompress the latest archive in the folder **plugins**
- Copy all files under this directory

Configuration
-------------

Firstly, you have to generate a new webhook url in Mattermost (**Integration Settings > Incoming Webhooks**).

### Receive project notifications to a room

- Go to the project settings then choose **Integrations > Mattermost**
- Copy and paste the webhook url from Mattermost or leave it blank if you want to use the global webhook url
- Use `channel` to override the webhook channel, example: **off-topic**
- Enable Mattermost in your project notifications **Notifications > Mattermost**

You can also define the webhook URL globally in the **Application settings > Integrations > Mattermost**.

### Mattermost configuration

- Change the config option `EnablePostUsernameOverride` to `true` to have Kanboard as username
- Change `EnablePostIconOverride` to `true` to see Kanboard icon

## Troubleshooting

- Enable the debug mode
- All connection errors with the Mattermost API are recorded in the log files `data/debug.log`
