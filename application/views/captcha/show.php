<h1>Show captcha</h1>
            <? foreach ($result[0] as $field_name => $field_value): ?>
            <p>
                <b><?= ucfirst($field_name) ?>:</b> <?= $field_value ?>
            </p>
            <? endforeach; ?>
            <?= anchor("captcha/show_list", "Back", "class='btn btn-lg btn-default btn-block'") ?>