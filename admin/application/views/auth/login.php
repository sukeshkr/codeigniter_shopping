<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>
  
    <?php include('assets/include/header.php'); ?>
  </head>
 
    <!-- Site wrapper -->
      
        
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        
      </div><!-- /.login-logo -->
      <div class="login-box-body">
          <a  href="../../index2.html"><img style="display:block;margin:10px auto;" src="<?= CUSTOM_BASE_URL.'assets/dist/img/logo.png'?>" class="log-log13" alt=""></a>
         <p class="login-box-msg">  <?php 
                            echo $this->session->flashdata('msg');
                            echo form_error('email', '<p class="help-block error-info">', '</p>');
                            echo form_error('password', '<p class="help-block error-info">', '</p>');
                        ?></p>
        <form action="<?php echo base_url();?>login/do_login" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Register Email id" name="email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
            
            
          <div class="row">
            <div class="col-xs-8">
              <div class="log-remin14 checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
            
            
        </form>

        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <?php include('assets/include/footer.php'); ?>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });

  $(document).ready(function () {
      //Disable cut copy paste
      $('body').bind('cut copy paste', function (e) {
          e.preventDefault();
      });
     
      //Disable mouse right click
      $("body").on("contextmenu",function(e){
          return false;
      });
  });
  </script>
  </body>
</html>