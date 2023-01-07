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
          <h1>Product</h1>
        </section>
          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">
     
     
            

                <!-- Wizard Content -->
                <form id="exampleFormContainer" action="<?php echo base_url()?>Product/create_stock" method="post" enctype="multipart/form-data" autocomplete="off" name="myform">
                  <div class="wizard-content">

                    <input type="hidden" value="<?= $cat_id; ?>" name="cat_id">

                    <input type="hidden" value="<?= $product_id; ?>" name="product_id">
                      
                <div class="wizard-pane active" id="exampleAccountOne" role="tabpanel">
                    <div class="container-fluid"> 
                    <div class="row">
                <div class="col-md-12">
                 <div class="form-group"> 
                  <div class="Upload-files">
                        <label class="form-control-label" for="inputUserName">Images</label>
                        <div class="inputs-wrap">
                          <div class="file-upload-templete">  
                            <label class="file-upload"> 
                              <div class="out-new-de">

                              <button class="new-pop" data-target="#upload-img" data-toggle="modal" type="button">
                                <img src="../../assets/images/upload.jpg"></button>
<p><br></p>
                                <a class="new-delete" href="#"><i class="icon wb-minus" aria-hidden="true"></i></a></div>
                              <input class="new-text" type="file" name="upl_files[]" multiple />
                              <?php echo form_error('upl_files[]', '<p class="invaild-9-field">', '</p>'); ?>
                            </label>
                          </div> 
                        </div>
                    </div>
                  </div>
                </div>

                 
                 
              <div class="col-md-6"> 
                <div class="form-group">
                 <label class="form-control-label" for="inputUserName">Stock Name <span class="man-in">*</span></label>
                 <input type="text" placeholder="Stock name" class="form-control" id="inputUserName" name="stock_name" value="<?= $product_name; ?>">
                  <?php echo form_error('stock_name', '<p class="invaild-9-field">', '</p>'); ?>
                </div> 

              </div>

              <div class="col-md-6"> 
                <div class="form-group">
                 <label class="form-control-label" for="inputUserName">MRP ($) <span class="man-in">*</span></label>
                 <input type="text" placeholder="0.00" class="form-control" id="inputUserName" name="price" value="<?php echo set_value('price') ?>">
                  <?php echo form_error('price', '<p class="invaild-9-field">', '</p>'); ?>
                </div>
              </div>


                <div class="col-md-6">                                        
                 <div class="form-group">
                  <label class="form-control-label" for="inputUserName">Sale price ($) </label>
                  <input type="text" placeholder="0.00" class="form-control" id="inputUserName" name="list_price" value="<?php echo set_value('list_price') ?>" >
                  <?php echo form_error('list_price', '<p class="invaild-9-field">', '</p>'); ?>
                  </div>
                 </div>

                <div class="col-md-6"> 
                 <div class="form-group">
                 <label class="form-control-label" for="inputUserName">Stock </label>
                 <input type="text" placeholder="0.00" class="form-control" id="inputUserName" name="stock" value="<?php echo set_value('stock'); ?>" >
                 <?php echo form_error('stock', '<p class="invaild-9-field">', '</p>'); ?>
                 </div>                  
                </div>



  <div class="col-md-12">
   <div class="form-group">
    <button type="submit" class="btn btn-success">Save</button>
    <input type="button" id="cancel" class="btn btn-danger" value="Exit">
   </div>
  </div>

                        </div>

        </div> 
   
                        
                 
                
  
    
  
</div>
<!-- /tab 3 --> 
 
            
</div> 
 <!-- /tab 5 -->                      

                </form>
</div>
</section>
</div>

      <footer class="main-footer clearfix">
        <div class="pull-right">
         <strong>Copyright &copy; 2019 <a target="_blank" href="#">Bangalore Bazaar</a></strong>.  All Rights Reserved.
        </div>
      </footer> 

</div>
    <!-- End Page -->

    <!-- ADD MODAL BODY -->
    <div class="modal fade sucs-modal" id="add_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4 class="modal-title" >Variant Added successfully</h4>
                    <p><h5>Add Next</h5></p>
                    <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
  <?php include('assets/include/footer.php'); ?>
 <script type="text/javascript">
      $(document).ready(function() {

    var MaxInputsph       = 6; //Número Maximo de Campos
    var contenedorph       = $("#1contenedor"); //ID del contenedor
    var AddButtonph       = $("#1agregarCampo"); //ID del Botón Agregar

    //var x = número de campos existentes en el contenedor
    var xx = $("#1contenedor div").length + 1;
    var FieldCountPhone = xx-1; //para el seguimiento de los campos

    $(AddButtonph).click(function (e) {
        if(xx <= MaxInputsph) //max input box allowed
        {
            FieldCountPhone++;
            //agregar campo
            $(contenedorph).append('<div><input class="form-control" type="text" name="highlights[]" id="campop_'+ FieldCountPhone +'" placeholder="Highlights '+ FieldCountPhone +'"/><a href="#" class="eliminarphone">&times;</a></div>');
            xx++; //text box increment
        }
        return false;
    });

    $("body").on("click",".eliminarphone", function(e){ //click en eliminar campo

        if( xx > 1 ) {
            $(this).parent('div').remove(); //eliminar el campo
            xx--;
        }
        return false;
    });
});

         $("#cancel").click(function () {//jquery cancel function when cancel button click
      window.location = '<?= CUSTOM_BASE_URL . "product" ?>';
    });//jquery cancel function end

   <?php if ($this->session->flashdata('add')) { ?>
    $("#add_confirm").modal('show');<?php } ?>

</script>

