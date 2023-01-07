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
                      <h1>Edit User</h1>
                    </section>

                      
                    <!-- Main content -->
            <section class="content">
                <!--            <div class="row">-->
                <div class="box box-primary">

                                 <form id="form" role="form" action="<?= CUSTOM_BASE_URL . 'user/update' ?>" method="post" enctype="multipart/form-data">
                                 <?php foreach ($profile as $row) { ?>
                                 <div class="container-fluid">    
                                <div class="row">
                                    <div class="col-sm-12 col-md-7">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input class="form-control" name="username" value="<?= set_value('username', isset($row['username']) ? $row['username'] : '') ?>">
                                            <?php echo form_error('username', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                                    
              
                                    <div class="col-sm-12 col-md-7">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select name="role" class="selectpicker form-control">
                                                    <option value="" selected> - Select Category - </option>

                                                   <option value="admin" <?= (set_value('admin') != '') ? set_select('admin', 'admin') : ($row['role'] == 'admin') ? "selected='selected'" : '' ?> >Admin</option>

                                                   <option value="blogger" <?= (set_value('blogger') != '') ? set_select('blogger', 'blogger') : ($row['role'] == 'blogger') ? "selected='selected'" : '' ?> >Blogger</option>
                                                  
                                            </select>
                                                <?php echo form_error('role', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>

                                      <div class="col-sm-12 col-md-7">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input readonly type="email" class="form-control" name="email" value="<?= set_value('email', isset($row['email']) ? $row['email'] : '') ?>">
                                            <?php echo form_error('email', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                                     

                                       <div class="col-sm-12 col-md-7">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input id="password" type="password" class="form-control" name="password" value="<?= set_value('password', isset($row['email']) ? $row['email'] : '') ?>">
                                            <?php echo form_error('password', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                                    
                                </div>

                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <?php } ?>
                                <input type="submit" class="btn btn-success" value="Publish">
                                <input type="button" id="cancel" class="btn btn-danger" value="Cancel">
                                </div>  
                               </form>
                              </div>
    <!-- /.box -->

    <!-- /.row -->
</section>

                      
      </div><!-- /.content-wrapper -->
        
       
        

       <footer class="main-footer clearfix">
        <div class="pull-right">
         <strong>Copyright &copy; 2019 <a target="_blank" href="#">Bangalore Bazaar</a></strong>.  All Rights Reserved.
        </div>
      </footer> 

      <!-- Control Sidebar -->

      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->




    <!-- jQuery 2.1.4 -->
     <?php include('assets/include/footer.php'); ?>
  
<script>
        $("#datepicker").datepicker({
            dateFormat: "M dd,yy"
        });

        //jquery cancel function when cancel button click
        $("#cancel").click(function () {
            window.location = '<?= CUSTOM_BASE_URL . "user" ?>';
        });


$(document).ready(function(){
   $('#password').bind("cut copy paste",function(e) {
      e.preventDefault();
   });
});


</script>
</body>

</html>
