<h1>New users</h1>
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

<?= form_open('sparkplugCtrl/create',"formnovalidate='formnovalidate'") ?>
<input type="hidden" name="id" value="" id="id" class="form-control"/>
<p>
    <label for="ip_address">Ip_address</label><br/>
    <input type="text" name="ip_address" value="" id="ip_address" placeholder="ip_address" maxlength="500" size="50"
           style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="password">Password</label><br/>
    <input type="password" name="password" value="" id="password" placeholder="password" maxlength="500" size="50"
           style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="forgot_password">Forgot_password</label><br/>
    <input type="password" name="forgot_password" value="" id="forgot_password" placeholder="forgot_password"
           maxlength="500" size="50" style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="salt">Salt</label><br/>
    <input type="text" name="salt" value="" id="salt" placeholder="salt" maxlength="500" size="50" style="width:100%"
           class="form-control" required=""/></p>

<p>
    <label for="email">Email</label><br/>
    <input type="text" name="email" value="" id="email" placeholder="email" maxlength="500" size="50" style="width:100%"
           class="form-control" required=""/></p>

<p>
    <label for="activation_code">Activation_code</label><br/>
    <input type="text" name="activation_code" value="" id="activation_code" placeholder="activation_code"
           maxlength="500" size="50" style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="remember_code">Remember_code</label><br/>
    <input type="text" name="remember_code" value="" id="remember_code" placeholder="remember_code" maxlength="500"
           size="50" style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="created_on">Created_on</label><br/>
    <input type="text" name="created_on" value="" id="created_on" placeholder="created_on" maxlength="500" size="50"
           style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="last_login">Last_login</label><br/>
    <input type="text" name="last_login" value="" id="last_login" placeholder="last_login" maxlength="500" size="50"
           style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="active">Active</label><br/>
    <input type="text" name="active" value="" id="active" placeholder="active" maxlength="500" size="50"
           style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="first_name">First_name</label><br/>
    <input type="text" name="first_name" value="" id="first_name" placeholder="first_name" maxlength="500" size="50"
           style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="last_name">Last_name</label><br/>
    <input type="text" name="last_name" value="" id="last_name" placeholder="last_name" maxlength="500" size="50"
           style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="company">Company</label><br/>
    <input type="text" name="company" value="" id="company" placeholder="company" maxlength="500" size="50"
           style="width:100%" class="form-control" required=""/></p>

<p>
    <label for="phone">Phone</label><br/>
    <input type="text" name="phone" value="" id="phone" placeholder="phone" maxlength="500" size="50" style="width:100%"
           class="form-control" required=""/></p>

<p>
    <?= form_submit('submit', 'Create', "formnovalidate='formnovalidate' class='btn btn-lg btn-default btn-block'") ?>
</p>
<?= form_close() ?>
<?= anchor("sparkplugCtrl/show_list", "Back", "class='btn btn-lg btn-default btn-block'") ?>