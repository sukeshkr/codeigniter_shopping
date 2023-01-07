<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('assets/include/header.php');?>
    <link href="<?php echo base_url();?>assets/vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<!DOCTYPE html>
<html>
  <head>
    <?php include('assets/include/header.php'); ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

     
 <?php include('assets/include/navigation.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Add products</h1>
        </section>

          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">
                       <?php echo validation_errors(); ?>
                        <form role="form" action="<?= CUSTOM_BASE_URL . 'user/updatepassword' ?>" method="post">

                        <div class="container-fluid">    
                         <div class="row">
                                
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input class="form-control" type="password" name="currentPassword">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="form-control" type="password" name="newPassword">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Re-type New Password</label>
                                    <input class="form-control" type="password" name="confirmPassword">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Change</button>
                            </div>
                             
                            </div>
                           </div>
                            
                        </form>

                   </div>
    <!-- /.box -->

    <!-- /.row -->
</section>
<!-- /.content -->
      </div><!-- /.content-wrapper -->
        
       
        
      <footer class="main-footer clearfix">
        <div class="pull-right">
         <strong>Copyright &copy; 2019 <a target="_blank" href="#">Bangalore Bazaar</a></strong>.  All Rights Reserved.
        </div>
      </footer>

      <!-- Control Sidebar -->
     
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->




    <!-- jQuery 2.1.4 -->
     <?php include('assets/include/footer.php'); ?>
    <script src="<?php echo base_url();?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= CUSTOM_ADMIN_URL .'assets/crop/script.js'?>"></script>
<script>
        $("#datepicker").datepicker({
            dateFormat: "M dd,yy"
        });

        //jquery cancel function when cancel button click
        $("#cancel").click(function () {
            window.location = '<?= CUSTOM_ADMIN_URL . "user" ?>';
        });
</script>
</body>

</html>
