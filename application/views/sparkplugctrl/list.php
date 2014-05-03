<p ><?php if($this->session->flashdata('msg')!=""): ?><div class="alert alert-success"><?= $this->session->flashdata('msg') ?></div><?php endif; ?></p>

            <h1>List users</h1>
            <div class="table-responsive">
            <table class="table">
                <tr>
                <? foreach(array_keys($results[0]) as $key): ?>
                    <th><?= ucfirst($key) ?></th>
                <? endforeach; ?>
                </tr>

            <? foreach ($results as $row): ?>
                <tr>
                <? foreach ($row as $field_value): ?>
                    <td><?= $field_value ?></td>
                <? endforeach; ?>
                    <td> <?= anchor("SparkPlugCtrl/show/".$row['id'], 'View', "class='btn btn-sm btn-success'") ?></td>
                    <td> <?= anchor("SparkPlugCtrl/edit/".$row['id'], 'Edit', "class='btn btn-sm btn-warning'") ?></td>
                    <td> <?= anchor("SparkPlugCtrl/delete/".$row['id'], 'Delete', "class='btn btn-sm btn-danger'") ?></td>
                </tr>
            <? endforeach; ?>
            </table>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
            <?= anchor("SparkPlugCtrl/new_entry", "New", "class='btn btn-lg btn-primary btn-block'") ?>
            </div>
            