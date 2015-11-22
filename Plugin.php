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

        $this->projectNotificationType->setType('mattermost', t('Mattermost'), '\Kanboard\Plugin\Mattermost\Notification\Mattermost');

        $this->on('session.bootstrap', function($container) {
            Translator::load($container['config']->getCurrentLanguage(), __DIR__.'/Locale');
        });
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
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-mattermost';
    }
}
