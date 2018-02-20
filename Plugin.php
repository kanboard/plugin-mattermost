<?php

namespace Kanboard\Plugin\Mattermost;

use Kanboard\Core\Translator;
use Kanboard\Core\Plugin\Base;

/**
 * Mattermost Plugin
 *
 * @package  mattermost
 * @author   Frederic Guillot
 */
class Plugin extends Base
{
    public function initialize()
    {
        $this->template->hook->attach('template:config:integrations', 'mattermost:config/integration');
        $this->template->hook->attach('template:project:integrations', 'mattermost:project/integration');
        $this->projectNotificationTypeModel->setType('mattermost', t('Mattermost'), '\Kanboard\Plugin\Mattermost\Notification\Mattermost');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginDescription()
    {
        return 'Receive notifications on Mattermost';
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.5';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-mattermost';
    }

    public function getCompatibleVersion()
    {
        return '>=1.0.37';
    }
}
