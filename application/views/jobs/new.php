<h1>New jobs</h1>
 <? if (validation_errors() != ""): ?>
    <div class="alert alert-danger has-error has-feedback">
        <span class="alert glyphicon glyphicon-warning-sign"></span>
        <?php
        if ($this->session->flashdata("msg") != ""):
            ?>

            <div style="display:block;float: left;width:60%">
                <h3><?= $this->session->flashdata("msg") ?></h3>
            </div>
        <?php endif; ?>
        <div style="display:block;float: left;width:60%">
            <?= validation_errors(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>
<?= form_open('jobs/create',"formnovalidate") ?>

	
<input type="hidden" name="id" value="" />

	
	
	<p>
<label for="name">Name</label><br/>
	<input type="text" name="name" value="<?= xss_clean($this->input->post("name"));?>" id="name" maxlength="75" size="50" style="width:100%" class="form-control" placeholder="name" required="required"  />
	
	<p>
<label for="contact_person">Contact_person</label><br/>
	<input type="text" name="contact_person" value="<?= xss_clean($this->input->post("contact_person"));?>" id="contact_person" maxlength="75" size="50" style="width:100%" class="form-control" placeholder="contact_person" required="required"  />
	
	<p>
<label for="startdate">Startdate</label><br/>
	<input type="date" name="startdate" value="<?= xss_clean($this->input->post("startdate"));?>" id="startdate" size="50" style="width:100%" class="form-control" placeholder="startdate"  />
	
	<p>
<label for="enddate">Enddate</label><br/>
	<input type="date" name="enddate" value="<?= xss_clean($this->input->post("enddate"));?>" id="enddate" size="50" style="width:100%" class="form-control" placeholder="enddate"  />
	
	<p>
<label for="notes">Notes</label><br/>
	<textarea name="notes" cols="50" rows="10" id="notes" maxlength="" row="20" style="width:100%" class="form-control" placeholder="notes" required="required" ><?= xss_clean($this->input->post("notes"));?></textarea>
	
	<p>
<label for="phone">Phone</label><br/>
	<input type="tel" name="phone" value="<?= xss_clean($this->input->post("phone"));?>" id="phone" maxlength="75" size="50" style="width:100%" class="form-control" placeholder="phone" required="required"  />
	
	<p>
<label for="email">Email</label><br/>
	<input type="email" name="email" value="<?= xss_clean($this->input->post("email"));?>" id="email" maxlength="75" size="50" style="width:100%" class="form-control" placeholder="email" required="required"  />
<p>
    <?= form_submit('submit', 'Create', "formnovalidate  class='btn btn-lg btn-default btn-block'") ?>
</p>
<?= form_close() ?>
<?= anchor("jobs/show_list", "Back", "class='btn btn-lg btn-default btn-block'") ?>