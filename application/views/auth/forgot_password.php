<?=form_open("auth/forgot_password", 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo lang('forgot_password_heading');?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
                <div class="form-group">
                    <label class="control-label col-sm-3"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label>
                    <div class="col-sm-5">
                         <?php echo form_input($identity, '', 'class="form-control" required');?>
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <?php echo form_submit('submit', lang('create_group_submit_btn'));?>
            </div>
        </div>
    </div>
<?=form_close();?>
