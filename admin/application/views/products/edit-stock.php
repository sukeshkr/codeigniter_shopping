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
          <h1>Edit Stock</h1>
        </section>
          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">
     
     
            
     
            
             <div class="container-fluid">
                <!-- Wizard Content -->
                <form id="exampleFormContainer" action="<?php echo base_url()?>Product/update" method="post" enctype="multipart/form-data" autocomplete="off" name="myform">
                  <div class="wizard-content">

                    <?php foreach ($product as $key => $row) {  ?>

                      <input value="<?= $row['id'];?>" type="hidden" name="id" />
                      <input value="<?= $row['product_id'];?>" type="hidden" name="product_id" />
                      <input value="<?= $cat_id;?>" type="hidden" name="cat_id" />
                      
                <div class="wizard-pane active" id="exampleAccountOne" role="tabpanel">
                    <div class="row"> 


                  <div class="col-md-12"> 
                      <label class="form-control-label" for="inputUserName">Images</label>
                      <br>
                      <?php foreach ($row['image'] as $key => $rowImg) { ?>

                      <a id="<?= 'rmv_'.$rowImg['id']; ?>" class="remove" sectionId="<?= $rowImg['id']; ?>" href="#" class="col-xl-2 eliminar1">&times;</a>

                      <img id="<?= 'rmv1_'.$rowImg['id']; ?>" height="100" width="80" src="<?= CUSTOM_BASE_URL . 'uploads/product_multimage/'.$rowImg['image']; ?>">

                       <?php } ?>
                  </div>

                <div class="col-md-12"> 
                 <div class="form-group">
                  <div class="Upload-files">
                        <label class="form-control-label" for="inputUserName">Add New</label>
                        <div class="inputs-wrap">
                          <div class="file-upload-templete">  
                            <label class="file-upload"> 
                              <input class="new-text" type="file" name="upl_files[]" multiple />
                            </label>
                          </div> 
                        </div>
                    </div>
                   </div>
                  </div>


                <div class="col-md-6"> 
                  <div class="form-group">
                 <label class="form-control-label" for="inputUserName">Stock Name</label>
                <input type="text" class="form-control" id="inputUserName" name="stock_name" value="<?= (set_value('stock_name') != '') ? set_value('stock_name') : $row['stock_name']; ?>" >
                </div> 
              </div>

              <div class="col-md-6"> 

                <div class="form-group">
                 <label class="form-control-label" for="inputUserName">Price ($) <span class="man-in">*</span></label>
                 <input type="text" placeholder="90.90" class="form-control" id="inputUserName" name="price" value="<?= (set_value('price') != '') ? set_value('price') : $row['price']; ?>">
                </div>  
                </div> 

                <div class="col-md-6">                  
                <div class="form-group">
                 <label class="form-control-label" for="inputUserName">List price ($) </label>
                <input type="text" class="form-control" id="inputUserName" name="list_price" value="<?= (set_value('list_price') != '') ? set_value('list_price') : $row['list_price']; ?>" >
                </div> 
              </div>

              <div class="col-md-6"> 
                 <div class="form-group">
                 <label class="form-control-label" for="inputUserName">Stock </label>
                <input type="text" class="form-control" id="inputUserName" name="stock" value="<?= (set_value('stock') != '') ? set_value('stock') : $row['stock']; ?>" >
                </div> 
                                    
                </div>

        </div> 
   
                        
                 
                
  
    
  
</div>
<!-- /tab 3 --> 
 <?php } ?>
            
</div> 
 <!-- /tab 5 -->                      

 <button type="submit" class="btn btn-success">Save</button>

 <input type="button" id="cancel" class="btn btn-danger" value="Exit">


                </form>
               </div> 
              </div>
            </div>
            
            
      <footer class="main-footer clearfix">
        <div class="pull-right">
         <strong>Copyright &copy; 2019 <a target="_blank" href="#">Bangalore Bazaar</a></strong>.  All Rights Reserved.
        </div>
      </footer>
            
            
          </div>   
        </div>
      </div>
    </div>
    <!-- End Page -->

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

   

</script>

<script type="text/javascript">
  $('.remove').click(function(){
     var sectionId = $(this).attr('sectionId');
     $.ajax({
              type: 'post',
              url: '<?= CUSTOM_BASE_URL . 'product/deleteImage' ?>', //Here you will fetch records 
              data: 'rowid=' + sectionId , //Pass $id
              success: function (data) {
              $('#rmv_'+sectionId).hide();
               $('#rmv1_'+sectionId).hide();
              // $('.fil-dele').html(data);//Show fetched data from database
              }
          });

}); 

</script>

