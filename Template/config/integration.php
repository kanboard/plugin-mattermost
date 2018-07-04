<h3><img src="<?= $this->url->dir() ?>plugins/Mattermost/mattermost-icon.png"/>&nbsp;Mattermost</h3>
<div class="panel">
    <?= $this->form->label(t('Webhook URL'), 'mattermost_webhook_url') ?>
    <?= $this->form->text('mattermost_webhook_url', $values) ?>

    <p class="form-help"><a href="https://github.com/kanboard/plugin-mattermost#configuration" target="_blank"><?= t('Help on Mattermost integration') ?></a></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
