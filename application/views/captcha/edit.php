<h1>Edit captcha</h1>
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
            <?= form_open("captcha/update/".$result["id"],"formnovalidate=formnovalidate") ?>
            
	
<input type="hidden" name="captcha_id" value="" />

	
	
	<p>
<label for="captcha_time">Captcha_time</label><br/>
	<input type="number" name="captcha_time" value="<?= $result["captcha_time"];?>" id="captcha_time" maxlength="10" size="50" style="width:100%" class="form-control" placeholder="captcha_time" required="required"  />
	
	<p>
<label for="ip_address">Ip_address</label><br/>
	<input type="text" name="ip_address" value="<?= $result["ip_address"];?>" id="ip_address" maxlength="16" size="50" style="width:100%" class="form-control" placeholder="ip_address" required="required"  />
	
	<p>
<label for="word">Word</label><br/>
	<input type="text" name="word" value="<?= $result["word"];?>" id="word" maxlength="20" size="50" style="width:100%" class="form-control" placeholder="word" required="required"  />
            <p>
                <?= form_submit('submit', 'Update', "formnovalidate  class='btn btn-lg btn-default btn-block'") ?>
            </p>
            <?= form_close() ?>
            <?= anchor("captcha/show_list", "Back", "class='btn btn-lg btn-default btn-block'") ?>