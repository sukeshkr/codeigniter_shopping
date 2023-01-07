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
          <h1>Banner Edit</h1>
        </section>

          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">
        <!-- /.box-header -->
         <?php foreach ($result as $row) { 
              $ci_name=strtolower($this->router->fetch_class());?>
     <form class=" add-ca-in" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>cart_banner/update">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Banner Name</label> 
       </div>
      </div>
      <div class="col-md-6">
       <div class="form-group">  
         <input type="text" class="form-control" name="banner_name" value="<?= set_value('banner_name', isset($row['banner_name']) ? $row['banner_name'] : '') ?>">
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
         <select title="None" class="form-control selectpicker" name="banner_type" onChange="showSub(this);">
                

  <option value="general" <?= (set_value('general') != '') ? set_select('general', 'general') : ($row['banner_type'] == 'general') ? "selected='selected'" : '' ?> >General</option>

  <option value="category" <?= (set_value('category') != '') ? set_select('category', 'category') : ($row['banner_type'] == 'category') ? "selected='selected'" : '' ?> >Category</option>

  <option value="product" <?= (set_value('product') != '') ? set_select('product', 'product') : ($row['banner_type'] == 'product') ? "selected='selected'" : '' ?> >Product</option>

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
           <a data-toggle="modal" data-target="#cropModal"><img height="100" width="100" src="<?= CUSTOM_BASE_URL . 'uploads/cart_banner/'.$row['image']; ?>" class="img-responsive"></a>
          <?php echo form_error('image_file', '<p class="help-block error-info">', '</p>'); ?>
          <div class="error"></div>
          <div class="sucess" style="color:green;font-weight:bold;"></div>
          <p id="error_img" class="help-block error-info"></p>
        </div>
      </div>
    </div>

        <!--  Profile  picture  -->
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
        <input name="submit" class="btn btn-success" type="submit" value="Update">
       </div>
      </div>
    </div>
  </div>

     <input type="hidden" name="id" value="<?= $row['id']; ?>">

    </form>
         <?php } ?>
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

<script type="text/javascript" src="<?= CUSTOM_BASE_URL .'assets/plugins/crop/script_banner.js'?>"></script>

    <!-- jQuery 2.1.4 -->
  <?php include('assets/include/footer.php'); ?>
    <script type="text/javascript" src="<?= CUSTOM_BASE_URL .'assets/plugins/crop/script_banner.js'?>"></script>
  <script>

    $("#cancel").click(function () {//jquery cancel function when cancel button click
      window.location = '<?= CUSTOM_BASE_URL . "other_banners" ?>';
    });//jquery cancel function end

    function validation() //java script checkForm function when click submit for validation
    {
      var img = $('#image_file').val();
      var status=true;  

      if(img!="")
      {
          if (!parseInt($('#w').val()))
      {
           $('.error').html('Please select a crop region and then press Save').show();
          return false;
      }

      }
      return status; 
    }


  $(function () 
  {
      $(".select2").select2();
      //Datemask dd/mm/yyyy
      $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
      //Datemask2 mm/dd/yyyy
      $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
      //Money Euro
      $("[data-mask]").inputmask();
        //Colorpicker
      $(".my-colorpicker1").colorpicker();
      //color picker with addon
      $(".my-colorpicker2").colorpicker();
        
        $('#datepic').datepicker({
          format: "dd - M - yy",
      });

    var currentDate = new Date();  
      $('#cropModal').on('shown.bs.modal', function () {
          $(this).find('.modal-dialog').css({
              width:'auto',
              height:'auto', 
              'max-height':'80%'
          });
      });
  });


  $(".close").click(function()
  {
    $('#filediv').load(document.URL +  ' #filediv');
  });

</script>
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
