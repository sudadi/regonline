<?=form_open("auth/edit_group/".$id, 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo lang('edit_group_heading');?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo lang('edit_group_subheading');?></p>
                <div class="form-group">
                    <label class="control-label col-sm-3"><?php echo lang('edit_group_name_label', 'group_name');?></label>
                    <div class="col-sm-5">
                         <?php echo form_input($group_name, '', 'class="form-control" required');?>
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3"> <?php echo lang('edit_group_desc_label', 'description');?></label>
                    <div class="col-sm-8">
                        <?php echo form_input($group_description, '', 'class="form-control" required');?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <?php echo form_submit('submit', lang('edit_group_submit_btn'));?>
            </div>
        </div>
    </div>
<?=form_close();?>