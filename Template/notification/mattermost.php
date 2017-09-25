**[<?= $this->text->e($project['name'])?>]** _<?= $task['title'] ?>_
<?= $title ?>;
<?php if (! empty($url)): ?>
[<?= t('View the task on Kanboard') ?>](<?= $url ?>)
<?php endif ?>