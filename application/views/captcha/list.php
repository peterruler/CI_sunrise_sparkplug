<h1>List captcha</h1>
            <p>
            <?php
            if ($this->session->flashdata("msg") != ""):
            ?>
            <div class="alert alert-success has-error has-feedback">
            <?= $this->session->flashdata("msg") ?>
            <span class="alert glyphicon glyphicon-ok"></span>
            </div>
            <?php endif; ?>
            </p>
            <div class="table-responsive">
            <table class="table table table-bordered table-striped table-hover">
                <tr>
                <?
                if(count($results) != 0) :
                foreach(array_keys($results[0]) as $key): ?>
                    <th><?= ucfirst($key) ?></th>
                <? endforeach;
                endif;
                ?>
                <th>View</th>
                <th>Edit</th>
                <th>Delete</th>
                </tr>
           <?
           if(count($results) != 0) :
           foreach ($results as $row):
                ?>
                <tr>
                <? foreach ($row as $field_value): ?>
                    <td><?= $field_value ?></td>
                <? endforeach; ?>
                    <td> <?= anchor("captcha/show/".$row['id'], 'View', "class='btn btn-sm btn-success'") ?></td>
                    <td> <?= anchor("captcha/edit/".$row['id'], 'Edit', "class='btn btn-sm btn-warning'") ?></td>
                    <td> <?= anchor("captcha/delete/".$row['id'], 'Delete', "class='btn btn-sm btn-danger'") ?></td>
                </tr>
            <? endforeach;
            endif;
            ?>
            </table>
            <br />
                <?= $this->pagination->create_links();?>
                <br />
            </div><br />
            <div class="col-lg-4 col-md-4 col-sm-12">
            <?= anchor("captcha/new_entry", "New", "class='btn btn-lg btn-default btn-block'") ?>
            </div>
            