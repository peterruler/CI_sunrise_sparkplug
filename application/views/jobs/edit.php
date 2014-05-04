<h1>Edit Jobs</h1>
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
            <?= form_open("Jobs/update/".$result["id"],"formnovalidate=formnovalidate") ?>
            
	
<input type="hidden" name="id" value="" />

	
	
	<p>
<label for="name">Name</label><br/>
	<input type="text" name="name" value="<?= $result["name"];?>" id="name" maxlength="75" size="50" style="width:100%" class="form-control" placeholder="name" required="required"  />
	
	<p>
<label for="contact_person">Contact_person</label><br/>
	<input type="text" name="contact_person" value="<?= $result["contact_person"];?>" id="contact_person" maxlength="75" size="50" style="width:100%" class="form-control" placeholder="contact_person" required="required"  />
	
	<p>
<label for="startdate">Startdate</label><br/>
	<input type="date" name="startdate" value="<?= $result["startdate"];?>" id="startdate" size="50" style="width:100%" class="form-control" placeholder="2014:05:Sun"  />
	
	<p>
<label for="enddate">Enddate</label><br/>
	<input type="date" name="enddate" value="<?= $result["enddate"];?>" id="enddate" size="50" style="width:100%" class="form-control" placeholder="2014:05:Sun"  />
	
	<p>
<label for="notes">Notes</label><br/>
	<textarea name="notes" cols="50" rows="10" id="notes" row="20" style="width:100%" class="form-control" placeholder="notes" ><?= $result["notes"];?></textarea>
	
	<p>
<label for="phone">Phone</label><br/>
	<input type="tel" name="phone" value="<?= $result["phone"];?>" id="phone" maxlength="75" size="50" style="width:100%" class="form-control" placeholder="phone" required="required"  />
	
	<p>
<label for="email">Email</label><br/>
	<input type="email" name="email" value="<?= $result["email"];?>" id="email" maxlength="75" size="50" style="width:100%" class="form-control" placeholder="email" required="required"  />
            <p>
                <?= form_submit('submit', 'Update', "formnovalidate  class='btn btn-lg btn-default btn-block'") ?>
            </p>
            <?= form_close() ?>
            <?= anchor("Jobs/show_list", "Back", "class='btn btn-lg btn-default btn-block'") ?>