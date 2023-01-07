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
          <h1>Add Banner</h1>
        </section>
          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">


        <form class="add-ca-in" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>cart_banner/create"  onSubmit="return checkForm()">
<div class="container-fluid">
    
     <div class="row">
      <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Banner Name</label> 
       </div>
      </div>
      <div class="col-md-6">
       <div class="form-group">  
         <input type="text" class="form-control" name="banner_name" value="<?php echo set_value('banner_name') ?>">
         <?php echo form_error('banner_name', '<p class="invaild-9-field">', '</p>'); ?>
       </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Banner Type</label> 
       </div>
      </div>
      <div class="col-md-6">
       <div class="form-group">  
         <select title="General" class="form-control selectpicker" name="banner_type" onChange="showSub(this);">
                 <option selected value="category">General</option>
                 <option value="category">Category</option>
                 <option value="product">Product</option>
         </select>
       </div>      
      </div>
    </div>

    <div id="output1"></div> 

     <div class="row">
      <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Expiary Date</label> 
       </div>
      </div>
      <div class="col-md-6">
       <div class="form-group"> 
         <input type="text" class="form-control" name="exp_date" value="<?php echo date("Y/m/d"); ?>">
         <?php echo form_error('exp_date', '<p class="invaild-9-field">', '</p>'); ?>
       </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Banner Pic</label> 
       </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
           <a class="btn btn-block btn-default cropModal" data-toggle="modal" data-target="#cropModal"><i class="fa fa-picture-o" aria-hidden="true"></i> crop Image</a>
          <?php echo form_error('image_file', '<p class="help-block error-info">', '</p>'); ?>
          <div class="error"></div>
          <div class="sucess" style="color:green;font-weight:bold;"></div>
          <p id="error_img" class="help-block error-info"></p>
        </div>
      </div>
    </div>

       <!--  Profile  picture  -->
                <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Image Croping</h4>
                            
                             </div>
                        <div class="modal-body">
                                    <div class="form-group">
                                        <label>image</label>
                                        <input type="hidden" id="x1" name="x1" />
                                        <input type="hidden" id="y1" name="y1" />
                                        <input type="hidden" id="x2" name="x2" />
                                        <input type="hidden" id="y2" name="y2" />
                                        <input type="hidden" id="admin_url" name="admin_url" value=" <?= CUSTOM_BASE_URL.'assets/images/loading.gif';?> " />
                                        <div  class="form-group">
                                        <input accept="image/x-png,image/jpeg" type="file"  name="image_file" id="image_file" onChange="fileSelectHandler()"  class="form-control"/>
                                        </div>
                                                <div id="loading"></div>
                                                <div class="error"></div>
                                                <img id="preview" />  
                                        <div class="step2">
                                        <h5>Please select a crop region</h5>

                                        <div class="info">
                                         <!-- <h4><a class="btn btn-primary" data-dismiss="modal">Add Image</a></h4>   -->
                                        <input type="hidden" id="filesize" name="filesize" />
                                        <input type="hidden" id="filetype" name="filetype" />
                                        <input type="hidden" id="filedim" name="filedim" />
                                        <input type="hidden" id="w" name="w" />
                                        <input type="hidden" id="h" name="h" />
                                        <input type="hidden" id="admin_url" value="<?= CUSTOM_BASE_URL.'assets/images/loading.gif';?>">
                                    </div>
                                    <a class="btn btn-primary" data-dismiss="modal">Add Image</a>
                                </div>
                            </div>
                             </div>
                        </div>
                    </div>
                </div>
        <!-- Cover image     -->

          <div class="modal fade" id="coverModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Cover Croping</h4>
                   </div>
              <div class="modal-body">
                          <div class="form-group">
                              <input accept="image/x-png,image/jpeg" type="file"  name="image_file_cover" id="image_file_cover"  class="form-control"/>
                          </div>
                          <a class="btn btn-primary" data-dismiss="modal">Add Image</a>
                   </div>
              </div>
          </div>
          </div>
        </div>
  <div class="container-fluid">
    <div class="row regi-10-out">
     <div class="col-md-12"> 
      <div class="form-group">
        <input class="btn btn-success" type="submit" value="Create">
      </div>
     </div>
    </div>
  </div>

    </form>

        <!-- /.box-body -->
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


<script type="text/javascript" src="<?= CUSTOM_BASE_URL .'assets/plugins/crop/script_banner.js'?>"></script>


    <!-- jQuery 2.1.4 -->
     <?php include('assets/include/footer.php'); ?>
  </body>
</html>


<script type="text/javascript">

function showSub(sel) {

  var id = sel.options[sel.selectedIndex].value;  

  $("#output1").html( "" );
  if (id.length > 0 ) { 
 
   $.ajax({
      type: "POST",
      url: "<?= CUSTOM_BASE_URL . 'Cart_banner/setBannerType' ?>",
      data: "id="+id,
      cache: false,
      beforeSend: function () { 
        $('#output1').html('<img src="loader.gif" alt="" width="24" height="24">');
      },
      success: function(html) { 
        
        if(html) {

          $("#output1").html(html);
          
        }
      }
    });
  } 
}

</script>
