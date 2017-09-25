<?php

namespace Kanboard\Plugin\Mattermost\Notification;

use Kanboard\Core\Base;
use Kanboard\Core\Notification\NotificationInterface;

/**
 * Mattermost Notification
 *
 * @package  notification
 * @author   Frederic Guillot
 */
class Mattermost extends Base implements NotificationInterface
{
    /**
     * Send notification to a user
     *
     * @access public
     * @param  array     $user
     * @param  string    $eventName
     * @param  array     $eventData
     */
    public function notifyUser(array $user, $eventName, array $eventData)
    {
    }

    /**
     * Send notification to a project
     *
     * @access public
     * @param  array     $project
     * @param  string    $event_name
     * @param  array     $event_data
     */
    public function notifyProject(array $project, $event_name, array $event_data)
    {
        $webhook = $this->projectMetadataModel->get($project['id'], 'mattermost_webhook_url', $this->configModel->get('mattermost_webhook_url'));
        $channel = $this->projectMetadataModel->get($project['id'], 'mattermost_webhook_channel');

        if (! empty($webhook)) {
            $this->sendMessage($webhook, $channel, $project, $event_name, $event_data);
        }
    }

    /**
     * Get message to send
     *
     * @access public
     * @param  array     $project
     * @param  string    $event_name
     * @param  array     $event_data
     * @return array
     */
    public function getMessage(array $project, $event_name, array $event_data)
    {
        if ($this->userSession->isLogged()) {
            $author = $this->helper->user->getFullname();
            $event_data['title'] = $this->notificationModel->getTitleWithAuthor($author, $event_name, $event_data);
        } else {
            $event_data['title'] = $this->notificationModel->getTitleWithoutAuthor($event_name, $event_data);
        }

        $event_data['project'] = $project;

        if ($this->configModel->get('application_url') !== '') {
            $event_data['url'] = $this->helper->url->to('TaskViewController', 'show', array('task_id' => $event_data['task']['id'], 'project_id' => $project['id']), '', true);
        }

        $message = $this->template->render('mattermost:notification/mattermost', $event_data);

        return array(
            'text' => $message,
            'username' => 'Kanboard',
            'icon_url' => 'https://kanboard.net/assets/img/favicon.png',
        );
    }

    /**
     * Send message to Mattermost
     *
     * @access private
     * @param  string    $webhook
     * @param  string    $channel
     * @param  array     $project
     * @param  string    $event_name
     * @param  array     $event_data
     */
    private function sendMessage($webhook, $channel, array $project, $event_name, array $event_data)
    {
        $payload = $this->getMessage($project, $event_name, $event_data);

        if (! empty($channel)) {
            $payload['channel'] = $channel;
        }

        $this->httpClient->postJsonAsync($webhook, $payload);
    }
}
