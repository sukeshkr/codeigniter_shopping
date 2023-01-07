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
          <h1>Add Product</h1>
        </section>
          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">
     

                <!-- Wizard Content -->
                <form id="exampleFormContainer" action="<?php echo base_url()?>Product/create" method="post" enctype="multipart/form-data" autocomplete="off" name="myform">
                  <div class="wizard-content">
                      
                      
                <div class="wizard-pane active" id="exampleAccountOne" role="tabpanel">
                    <div class="container-fluid">
                    <div class="row"> 
                        
                    <div class="col-md-4">

                      <div class="form-group">
                        <label class="form-control-label" for="inputUserName">Name <span class="man-in">*</span></label>
                        <input type="text" class="form-control" id="inputUserName" name="product_name">
                         <?php echo form_error('product_name', '<p class="invaild-9-field">', '</p>'); ?>
                      </div>
                    </div>

                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-control-label" for="inputUserName">Hsn Code <span class="man-in"></span></label>
                        <input type="text" class="form-control" id="inputUserName" name="hsn_code">
                         <?php echo form_error('hsn_code', '<p class="invaild-9-field">', '</p>'); ?>
                      </div>
                    </div>

                     <div class="col-md-5">
                      <div class="form-group">
                        <label class="form-control-label" for="inputUserName">Category</label>
                         <select data-live-search="true" class="form-control selectpicker" id="company" name="category" onChange="showSub(this);">
                          <option value="">Select</option>
                          <?php foreach ($category as $row) { ?>
                          <option value="<?= $row['cat_id'];?>"><?php echo $row['cat_name'] ?></option>
                          <?php } ?>

                        </select> 
                         <?php echo form_error('category', '<p class="invaild-9-field">', '</p>'); ?>
                      </div>    
                    </div>


                    <div class="col-md-4" >
                      <div class="form-group" id="output1">
                          
                      </div>    
                    </div>

                   
                </div> 
             </div> 
       
    <div class="container-fluid">
      <div class="row regi-10-out"> 

      <div class="form-group col-md-12">
      <div class="form-group">
        <label class="form-control-label" for="inputBasicFirstName">Highlights</label> 
      </div>
      <div class="form-group">
        <a id="1agregarCampo" class="btn btn-info" href="#">+</a>
      </div>
      <div id="1contenedor">
          <div class="added">
              <input class="form-control" type="text" name="highlights[]" id="campop_1" placeholder="Highlights" value=""/>
               <?php echo form_error('highlights[]', '<p class="invaild-9-field">', '</p>'); ?>
          </div>
      </div>
          </div>

    <div class="col-md-12">
     <div class="form-group">
      <label class="form-control-label" for="inputUserName">Description</label>
      <textarea rows="5" class="form-control" name="description" id="inputPassword"></textarea>
     </div>
    </div>
       
     <div class="col-md-12">
       <input type="submit" class="btn btn-success" value="Next">
     </div>     
       </div>   
      </div>                  
                
</div>
<!-- /tab 3 --> 


 
            
</div> 
 <!-- /tab 5 -->                      

                  </div>
                   

                </form>
              </div>
            </div>
          </div>   
        </div>
      </div>
    </div>
    <!-- End Page -->

  <?php include('assets/include/footer.php'); ?>
  </body>
</html> <script type="text/javascript">
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

</script>


<script type="text/javascript">

function showSub(sel) {

  var id = sel.options[sel.selectedIndex].value;  

  $("#output1").html( "" );
  if (id.length > 0 ) { 
 
   $.ajax({
      type: "POST",
      url: "<?= CUSTOM_BASE_URL . 'Product/getProductFeature' ?>",
      data: "id="+id,
      cache: false,
      beforeSend: function () { 
        $('#output1').html('<img src="loader.gif" alt="" width="24" height="24">');
      },
      success: function(html) {   

        $("#output1").html( html );
      }
    });
  } 
}

</script>