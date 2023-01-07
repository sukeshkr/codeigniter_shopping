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
          <h1>Edit Product</h1>
        </section>
          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">
     

                <!-- Wizard Content -->
                <form id="exampleFormContainer" action="<?php echo base_url()?>Product/update_product" method="post" enctype="multipart/form-data" autocomplete="off" name="myform">
           <div class="container-fluid">
           <?php foreach ($product as $row) { ?> 

             <input type="hidden" name="id" value="<?= $row['id'];?>" >

                  <div class="wizard-content">
                      
                      
                <div class="wizard-pane active" id="exampleAccountOne" role="tabpanel">


                    <div class="row"> 

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label" for="inputUserName">Name <span class="man-in">*</span></label>
                        <input value="<?= (set_value('product_name') != '') ? set_value('product_name') : $row['product_name']; ?>" type="text" class="form-control" id="inputUserName" name="product_name">
                        <?php echo form_error('product_name', '<p class="invaild-9-field">', '</p>'); ?>
                      </div>
                    <div class="form-group">
                        <label class="form-control-label" for="inputUserName">Category</label>
                         <select class="form-control" id="company" name="category" onChange="showSub(this);">
                          <option value="">Select</option>
                          <?php foreach ($category as $rows) { ?>
                        <option value="<?= $rows['cat_id'];?>" <?php if ($rows['cat_id'] == $row['cat_id']) { ?> selected="selected" <?php } ?>><?= $rows['cat_name'];?></option>
                         <?php } ?>

                        </select> 
                    </div>  


                    </div>
                     <div class="col-md-4">
                      <div class="form-group">
                         <div id="output1"></div> 
                      </div>    
                    </div>  
                      

  
  
        
       <div class="col-md-12">
        <div class="form-group">
        <label>Highlights</label>
        <div><a id="1agregarCampo" class="btn btn-info" href="#">+</a></div>
         
        <div id="1contenedor">
             <?php foreach ($highlights as $res) { ?>
          <div class="added">
         <a href="#" class="eliminarphone" sectionId="<?= $res['id']; ?>">&times;</a>
          <div class="form-group">
          <input class="form-control" type="text" name="highlights[]" id="campop_1" placeholder="Highlight 1" value="<?= set_value('highlights[]', isset($res['highlights']) ? $res['highlights'] : '') ?>"/>
          <?php echo form_error('highlights[]', '<p class="invaild-9-field">', '</p>'); ?>
          </div>
          </div>
        <?php } ?>
        </div>
        
        </div>
      </div>

            
                <!--     <div class="col-md-6">

                      <label class="form-control-label" for="inputUserName">Features</label>

                    <div class="form-group">
                      

                          <?php foreach ($features as $key => $rowftr) { print_r($rowftr->name) ?>

                         <select class="form-control" id="company" name="features[]">
                          <option value="">Select</option>

                          <?php foreach ($rowftr->sub as $rowsub) {  ?>

                         <option value="<?= $rowsub->var_id;?>"  <?php if(!empty($row['feature'][$key]))
                            { if ($rowsub->var_id == $row['feature'][$key]->var_id) { ?> selected="selected" <?php } } ?> ><?php echo $rowsub->var_name ?></option>

                           <?php } ?>
                       
                        </select> 
                      <?php } ?>
                    </div>    

                    </div> -->

    <div class="col-md-12">
     <div class="form-group">
     <label class="form-control-label" for="inputUserName">Description</label>
     <textarea class="form-control" name="description" id="inputPassword"><?= (set_value('description') != '') ? set_value('description') : $row['description']; ?></textarea>
     <?php echo form_error('description', '<p class="invaild-9-field">', '</p>'); ?>
    </div> 
    </div> 
    <div class="col-md-12">
     <div class="form-group">        
      <input type="submit" class="btn btn-success" value="Update">
     </div>
   </div>                        
  </div>              
         
</div>
<!-- /tab 3 --> 


 
            
</div> 
 <!-- /tab 5 -->                      

                  </div>


                 <?php } ?>
</div>
                </form>
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
    </div>
    <!-- End Page -->

  <?php include('assets/include/footer.php'); ?>
 <script type="text/javascript">
      $(document).ready(function() {

    var MaxInputsph       = 10; //Número Maximo de Campos
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
            $(contenedorph).append('<div><input class="form-control" type="text" name="highlights[]" id="campop_'+ FieldCountPhone +'" placeholder="Highlight '+ FieldCountPhone +'"/><a href="#" class="eliminarphone">&times;</a></div>');
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
      $('.eliminarphone').click(function(){
   var sectionId = $(this).attr('sectionId');
   $.ajax({
          type: 'post',
          url: '<?= CUSTOM_BASE_URL . 'Product/deleteHighlights' ?>', //Here you will fetch records 
          data: 'rowid=' + sectionId , //Pass $id
          success: function (data) {
          $('#remv_'+sectionId).empty().show();
          $('#remv_'+sectionId).hide();
          // $('.fil-dele').html(data);//Show fetched data from database
          }
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