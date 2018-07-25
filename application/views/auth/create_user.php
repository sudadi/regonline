<?=form_open("auth/create_user", 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo lang('create_user_heading');?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo lang('create_user_subheading');?></p>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo lang('create_user_fname_label', 'first_name');?><i class="text-red">*</i></label>
                    <div class="col-sm-7">
                         <?php echo form_input($first_name, '', 'class="form-control" required');?>
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo lang('create_user_lname_label', 'last_name');?></label>
                    <div class="col-sm-7">
                        <?php echo form_input($last_name, '', 'class="form-control"');?>
                    </div>
                </div>
                <?php if($identity_column!=='email') { ?>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo lang('create_user_identity_label', 'identity');?><i class="text-red">*</i></label>
                    <div class="col-sm-7">
                        <?php
                        echo form_error('identity', '', 'class="form-control" required');
                        echo form_input($identity, '', 'class="form-control" required');?>
                    </div>
                </div>
                <?php }; ?>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo lang('create_user_company_label', 'company');?></label>
                    <div class="col-sm-7">
                        <?php echo form_input($company, '', 'class="form-control"');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo lang('create_user_email_label', 'email');?><i class="text-red">*</i></label>
                    <div class="col-sm-7">
                        <?php echo form_input($email, '', 'class="form-control" required');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo lang('create_user_phone_label', 'phone');?><i class="text-red">*</i></label>
                    <div class="col-sm-7">
                        <?php echo form_input($phone, '', 'class="form-control" required');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo lang('create_user_password_label', 'password');?><i class="text-red">*</i></label>
                    <div class="col-sm-7">
                        <?php echo form_input($password, '', 'class="form-control" required');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"><?php echo lang('create_user_password_confirm_label', 'password_confirm');?><i class="text-red">*</i></label>
                    <div class="col-sm-7">
                        <?php echo form_input($password_confirm, '', 'class="form-control" required');?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <?php echo form_submit('submit', lang('create_user_submit_btn'));?>
            </div>
        </div>
    </div>
<?=form_close();?>
<div id="infoMessage"><?php echo $message;?></div>