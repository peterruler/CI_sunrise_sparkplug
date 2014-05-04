<h1>Edit users</h1>
<? if (validation_errors() != ''): ?>
    <div class="alert alert-danger has-error has-feedback">
        <span class="alert glyphicon glyphicon-warning-sign"></span>

        <?php
        if ($this->session->flashdata('msg') != ""):
            ?>

            <div style="display:block;float: left;width:60%">
                <h3><?= $this->session->flashdata('msg') ?></h3>
            </div>
        <?php endif; ?>
        <div style="display:block;float: left;width:60%">
            <?= validation_errors(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>
<?= form_open('sparkplugCtrl/update/' . $result["id"], "formnovalidate='formnovalidate'") ?>
<input type="hidden" name="id" value=<?= $result["id"] ?>/>
<p>
    <label for="ip_address">Ip_address</label><br/>
    <input type="text" name="ip_address" value="<?= $result ["ip_address"] ?>" id="ip_address" placeholder="ip_address"
           maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>
<p>
    <label for="password">Password</label><br/>
    <input type="password" name="password" value="<?= $result ["password"] ?>" id="password" placeholder="password"
           maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="passconf">Password retype</label><br/>
    <input type="password" name="passconf" value="<?= $result ["password"] ?>" id="passconf" placeholder="passconf"
           maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>
<p>
    <label for="forgot_password">Forgot_password</label><br/>
    <input type="text" name="forgot_password" value="<?= $result ["forgot_password"] ?>" id="forgot_password"
           placeholder="forgot_password" maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="salt">Salt</label><br/>
    <input type="text" name="salt" value="<?= $result ["salt"] ?>" id="salt" placeholder="salt" maxlength="500"
           size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="email">Email</label><br/>
    <input type="email" name="email" value="<?= $result ["email"] ?>" id="email" placeholder="email" maxlength="500"
           size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="activation_code">Activation_code</label><br/>
    <input type="text" name="activation_code" value="<?= $result ["activation_code"] ?>" id="activation_code"
           placeholder="activation_code" maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="remember_code">Remember_code</label><br/>
    <input type="text" name="remember_code" value="<?= $result ["remember_code"] ?>" id="remember_code"
           placeholder="remember_code" maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="created_on">Created_on</label><br/>
    <input type="text" name="created_on" value="<?= $result ["created_on"] ?>" id="created_on" placeholder="created_on"
           maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="last_login">Last_login</label><br/>
    <input type="text" name="last_login" value="<?= $result ["last_login"] ?>" id="last_login" placeholder="last_login"
           maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="active">Active</label><br/>
    <input type="text" name="active" value="<?= $result ["active"] ?>" id="active" placeholder="active" maxlength="500"
           size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="first_name">First_name</label><br/>
    <input type="text" name="first_name" value="<?= $result ["first_name"] ?>" id="first_name" placeholder="first_name"
           maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="last_name">Last_name</label><br/>
    <input type="text" name="last_name" value="<?= $result ["last_name"] ?>" id="last_name" placeholder="last_name"
           maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="company">Company</label><br/>
    <input type="text" name="company" value="<?= $result ["company"] ?>" id="company" placeholder="company"
           maxlength="500" size="50" style="width:100%" class="form-control"/>
</p>

<p>
    <label for="phone">Phone</label><br/>
    <input type="tel" name="phone" value="<?= $result ["phone"] ?>" id="phone" placeholder="phone" maxlength="500"
           size="50" style="width:100%" class="form-control"/>
</p>
<p>
    <label for="phone">tinymce test</label><br/>
    <textarea cols="20" rows="10"><?= $result ["first_name"] ?></textarea>
</p>
<p>
    <?= form_submit('submit', 'Update', "class='btn btn-lg btn-default btn-block'") ?>
</p>
<?= form_close() ?>
<?= anchor("sparkplugCtrl/show_list", "Back", "class='btn btn-lg btn-default btn-block'") ?>