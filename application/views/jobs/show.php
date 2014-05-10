<h1>Show jobs</h1>
<? foreach ($result[0] as $field_name => $field_value): ?>
<p>
    <b><?= ucfirst($field_name) ?>:</b> <?= $field_value ?>
</p>
<? endforeach; ?>
<?= anchor("jobs/show_list", "Back", "class='btn btn-lg btn-default btn-block'") ?>