<?=form_open("auth/deactivate/".$user->id, 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo lang('deactivate_heading');?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
                <div class="form-group">
                    <div class="col-xs-6 text-right">    
                        <label>
                            <?php echo lang('deactivate_confirm_y_label', 'confirm');?>&nbsp;&nbsp;
                            <input type="radio" name="confirm" value="yes" checked="checked" />
                        </label>
                    </div>
                    <div class="col-xs-6">  
                        <label> 
                            <?php echo lang('deactivate_confirm_n_label', 'confirm');?>&nbsp;&nbsp;
                            <input type="radio" name="confirm" value="no" />
                        </label>
                    </div>
                </div>
            </div>
            <?php 
            echo form_hidden($csrf); 
            echo form_hidden(array('id'=>$user->id)); ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <?php echo form_submit('submit', lang('deactivate_submit_btn'));?>
            </div>
        </div>
    </div>
<?=form_close();?>
