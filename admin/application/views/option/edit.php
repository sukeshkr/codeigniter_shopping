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
          <h1>Option Edit</h1>
        </section>
          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">
        <div class="container-fluid">
         <div class="row">
          <div class="col-md-12">
          <ul class="nav nav-tabs" role="tablist">
  <li class="nav-item active">
    <a class="nav-link" data-toggle="tab" href="#home" role="tab">General</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Variants</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#category" role="tab">Category</a>
  </li>
  
</ul>
<form class="add-ca-in" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>options/update">
<!-- Tab panes -->

  <?php foreach ($result as $row) { ?>

<input type="hidden" class="form-control" name="id" value="<?=  $row['option_id']; ?>" >

<div class="tab-content panel-body">
  <div class="tab-pane active" id="home" role="tabpanel">

     <div class="row regi-10-out">
      <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Name</label> 
       </div>
      </div>
         
      <div class="col-md-6">   
       <div class="form-group">  
         <input type="text" class="form-control" name="name" value="<?= (set_value('name') != '') ? set_value('name') : $row['name']; ?>" >
         <?php echo form_error('name', '<p class="invaild-9-field">', '</p>'); ?>
       </div>
      </div>
     </div>


     <div class="row regi-10-out">
      <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Go to Variant</label> 
       </div>
      </div>
         
      <div class="col-md-6">
       <div class="form-group">
        <input type="hidden" name="variant_check" value="0" />
        <input type="checkbox"  value="<?= $row['go_to_variant']; ?>" name="variant_check" <?php if($row['go_to_variant']=="1") { echo "checked"; }  ?>>
       </div>
      </div>
     </div>

     <div class="row regi-10-out">
      <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Description</label> 
       </div>
      </div>
         
      <div class="col-md-6">
       <div class="form-group">
         <textarea name="description" class="form-control" rows="4" cols="50"><?= (set_value('description') != '') ? set_value('description') : $row['description']; ?></textarea>
         <?php echo form_error('description', '<p class="invaild-9-field">', '</p>'); ?>
       </div>
      </div>
    </div>
    
  </div>


  <div class="tab-pane" id="profile" role="tabpanel">
  <div class="multi-field-wrapper multi-add-ca"> 
  <div class="multi-fields">
   <div class="multi-field">           
    <div class="row">
      
      <div class="col-md-9">
       <div class="form-group">
        <div class="cel-add-cate"> 
         <input class="form-control" type="text" name="variants_name[]" placeholder="Name">
        </div>
       </div>
      </div>
        
      <div class="col-md-3">
       <div class="form-group">    
        <button type="button" class="add-field btn btn-success add-cate-ad"><i class="icon wb-plus" aria-hidden="true"></i>Add</button>
        <a data-id="6" data-toggle="modal" data-target="#delModal" class="btn  btn-danger"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>   
       </div>
      </div>
    </div>

   </div>
  </div>
 </div>

  <?php foreach ($optionList as $options) { ?>

    <div id="<?= 'remv_'.$options['opt_var_id']; ?>" class="multi-field"> 
    <div class="row">
      <div class="col-md-9">
          <div class="form-group">
       <div class="cel-add-cate">
           <input class="form-control" type="text" value="<?= $options['type_name']; ?>">
       </div>  
       </div>
      </div>

        <div class="col-md-3">
            <div class="form-group">
          <a class="option_remove btn  btn-danger" sectionId="<?= $options['opt_var_id']; ?>" href="#" class="col-xl-2 eliminar1"><i class="fa  fa-trash-o" aria-hidden="true"></i></a> 
      </div>
      </div>
      </div>
   </div>

  <?php } ?>  

  </div>


    <div class="tab-pane" id="category" role="tabpanel">

    <div class="row">
      <div class="col-md-12">
        <select data-width="50%" title="All categories" name="cat_name[]" class="selectpicker" multiple data-actions-box="true" data-live-search="true">
         <?php foreach ($catAllList as $Lists) { ?>
            <option value="<?= $Lists['cat_id'];?>"  <?php echo set_select('cat_name',$Lists['cat_id'], False); ?> ><?= $Lists['cat_name'] ?></option>
            <?php } ?>
        </select>
      </div>
     </div>


      <div class="page-content">
  
        <?php foreach ($catList as $catLists) { ?>

        <div id="<?= 'rmv_'.$catLists['id']; ?>" class="op-ed12">

         
          <a class="op-cat-13" href=""><?= $catLists['cat_name']; ?><a/>

           <a class="remove" sectionId="<?= $catLists['id']; ?>" href="#" class="col-xl-2 eliminar1">&times;</a>
        
         </div>
        <?php } ?>

      </div>
    
  </div>
 
 
</div>
    
   <?php } ?>


  <div class="container-fluid">
    <div class="row regi-10-out">
     <div class="col-md-12">   
      <div class="form-group">
        <input class="btn btn-success" type="submit" value="Update">
      </div>
     </div>
    </div>
  </div>
    
    </form>
      </div>
    </div>
    </div>  
    </div>
    </div>
    </div>
</div>
</div>


    <!-- jQuery 2.1.4 -->
     <?php include('assets/include/footer.php'); ?>
  </body>
</html><script type="text/javascript">
  $('.remove').click(function(){
     var sectionId = $(this).attr('sectionId');
     $.ajax({
              type: 'post',
              url: '<?= CUSTOM_BASE_URL . 'Options/deleteOptcatList' ?>', //Here you will fetch records 
              data: 'rowid=' + sectionId , //Pass $id
              success: function (data) {
              $('#rmv_'+sectionId).hide();
              // $('.fil-dele').html(data);//Show fetched data from database
              }
          });

}); 

  $('.option_remove').click(function(){
   var sectionId = $(this).attr('sectionId');
   $.ajax({
            type: 'post',
            url: '<?= CUSTOM_BASE_URL . 'Options/deleteOptList' ?>', //Here you will fetch records 
            data: 'rowid=' + sectionId , //Pass $id
            success: function (data) {
            $('#remv_'+sectionId).empty().show();
            $('#remv_'+sectionId).hide();
            // $('.fil-dele').html(data);//Show fetched data from database
            }
        });

}); 
</script>

   
      <script>
      $('.multi-field-wrapper').each(function() {
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
        if ($('.multi-field', $wrapper).length > 1)
            $(this).parent('.multi-field').remove();
    });
});
      </script>