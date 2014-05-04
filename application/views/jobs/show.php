<h1>Show Jobs</h1>
            <? foreach ($result[0] as $field_name => $field_value): ?>
            <p>
                <b><?= ucfirst($field_name) ?>:</b> <?= $field_value ?>
            </p>
            <? endforeach; ?>
            <?= anchor("Jobs/show_list", "Back", "class='btn btn-lg btn-default btn-block'") ?>