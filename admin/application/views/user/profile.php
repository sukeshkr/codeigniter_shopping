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
                      <h1>User Profile</h1>
                    </section>

                      
            <!-- Main content -->
            <section class="content">
                <div class="box box-primary">
                                 <form id="form" role="form" action="<?= CUSTOM_BASE_URL . 'user/update_profile' ?>" method="post" enctype="multipart/form-data">
                                     
                                 <div class="container-fluid">    
                                <div class="row">

                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Change image</label>
                                          <a data-id='' data-toggle="modal" data-target="#cropModall" href="#">
                                          <img src="<?= CUSTOM_BASE_URL . 'uploads/products/small/'?>" class="img-responsive" id="previews"></a>
                                          <div class="help-block sucess" style="color:green;font-weight:bold;"></div>
                                          <?php echo form_error('image_file', '<p class="help-block error-info">', '</p>'); ?>
                                          <div class="error"></div>
                                          <input type="file" name="img" >
                                  </div>
                              </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User name</label>
                                            <input class="form-control" name="phone" value="<?php echo set_value('phone'); ?>">
                                            <?php echo form_error('phone', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input class="form-control" name="phone" value="<?php echo set_value('phone'); ?>">
                                            <?php echo form_error('phone', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                              
                                       <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input id="location" type="location" class="form-control" name="location" value="<?php echo set_value('location'); ?>">
                                            <?php echo form_error('location', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>

                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>">
                                            <?php echo form_error('email', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                                     

                                         <div class="col-md-6">
                                        <div class="form-group">
                                            <label>FaceBook</label>
                                            <input type="facebook" class="form-control" name="facebook" value="<?php echo set_value('facebook'); ?>">
                                            <?php echo form_error('facebook', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                               <div class="col-md-12">
                                <input type="submit" class="btn btn-success" value="Publish">
                                <input type="button" id="cancel" class="btn btn-danger" value="Cancel">
                               </div>
                                 </div>   
                                </div>    
                            </form>
                          </div>

                        </section>
             
                        </div>
        
       
            <!-- UPDATE MODAL BODY -->
    <div class="modal fade sucs-modal" id="update_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4 class="modal-title" >Updated successfully !</h4>
                    <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


      <!-- Control Sidebar -->
     
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
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


<?php if ($this->session->flashdata('update')) { ?>
    $("#update_confirm").modal('show');<?php } ?>

</script>
</body>

</html>
