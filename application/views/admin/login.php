<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Login page
            <small>it all starts here</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
            <li class="active"><a href="#">Login</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">               
            <div class="box-body">
                <div class="login-box">
                   <div class="login-box-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <?php echo form_open($action, 'method="POST"');?>
                      <div class="form-group has-feedback">
                        <?php echo form_input($identity);?>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                        <?php echo form_input($password);?>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="row">
                        <div class="col-xs-8">
                          <div class="checkbox icheck">
                            <label>
                              <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?> Remember Me
                            </label>
                          </div>
                        </div>
                        <div class="col-xs-4">
                            <?php echo form_submit('submit', lang('login_submit_btn'),'class="btn btn-primary btn-block btn-flat"');?>
                        </div>
                      </div>
                    </form>
                    <a href="#" id="forgotpass">I forgot my password</a><br>
                  </div>
                </div>
            </div>
            <div class="box-footer">
                
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-login"></div>
<script>
$("#forgotpass").click(function() {
    $.ajax({
        url: "<?=base_url('auth/forgot_password');?>",
        method: "GET",
        datatype: "html",
        success: function(data){
            $("#modal-login").html(data);
            $("#modal-login").modal();
        }
    })
});
</script>