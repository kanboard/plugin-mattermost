<?php

namespace Kanboard\Plugin\Mattermost\Notification;

use Kanboard\Core\Base;
use Kanboard\Notification\NotificationInterface;

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
     * @param  string    $event_name
     * @param  array     $event_data
     */
    public function notifyUser(array $user, $event_name, array $event_data)
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
        $webhook = $this->projectMetadata->get($project['id'], 'mattermost_webhook_url', $this->config->get('mattermost_webhook_url'));
        $channel = $this->projectMetadata->get($project['id'], 'mattermost_webhook_channel');

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
     */
    public function getMessage(array $project, $event_name, array $event_data)
    {
        if ($this->userSession->isLogged()) {
            $author = $this->helper->user->getFullname();
            $title = $this->notification->getTitleWithAuthor($author, $event_name, $event_data);
        } else {
            $title = $this->notification->getTitleWithoutAuthor($event_name, $event_data);
        }

        $message = '**['.$project['name']."]** ";
        $message .= '_'.$event_data['task']['title']."_\n";
        $message .= $title."\n";

        if ($this->config->get('application_url') !== '') {
            $message .= '['.t('View the task on Kanboard').']';
            $message .= '(';
            $message .= $this->helper->url->to('task', 'show', array('task_id' => $event_data['task']['id'], 'project_id' => $project['id']), '', true);
            $message .= ')';
        }

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
     * @param  srting    $webhook
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

        $this->httpClient->postJson($webhook, $payload);
    }
}
