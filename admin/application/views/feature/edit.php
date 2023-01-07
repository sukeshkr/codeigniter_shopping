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
          <h1>Features</h1>

        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">
                <div class="box-header">
                  <a class="btn bg-olive" href="<?= CUSTOM_BASE_URL;?>features/create">Add Features</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="nav nav-tabs" role="tablist">
  <li class="nav-item active">
    <a class="nav-link" data-toggle="tab" href="#home" role="tab">General</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Variants</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#messages" role="tab">Category</a>
  </li>

</ul>
 <form class="add-ca-in" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>Features/update">

<!-- Tab panes -->
<div class="tab-content panel-body">








<!--///////////////////////////////////////////////////-->
   <div class="tab-pane active" id="home" role="tabpanel">

    <?php foreach ($ftrList as $row) { ?>
 <input type="hidden" name="id" value="<?= $row['id']; ?>">
     <div class="row regi-10-out">
      <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Name</label> 
       </div>
      </div>
      <div class="col-md-6"> 
       <div class="form-group">  
         <input type="text" class="form-control" name="name" value="<?= (set_value('name') != '') ? set_value('name') : $row['name']; ?>">
         <?php echo form_error('name', '<p class="invaild-9-field">', '</p>'); ?>
       </div>
     </div>
    </div>

    <div class="row regi-10-out"> 
     <div class="col-md-4">
      <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Group</label> 
      </div>
     </div>
     <div class="col-md-6">
      <div class="form-group">
       <select name="group_name" class="form-control">
        <option value="" selected>Select</option>
       <?php foreach ($group as $groups) { ?>
              <option value="<?= $groups['grp_id'];?>" <?php if ($groups['grp_id'] == $row['f_grp_id']) { ?> selected="selected" <?php } ?>> <?php echo $groups['group_name']; ?></option>
            <?php } ?>
       </select>
       <?php echo form_error('type', '<p class="invaild-9-field">', '</p>'); ?>
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
       <div class="form-groupcol-md-7">
         <textarea name="description" class="form-control" rows="4" cols="50"><?= (set_value('description') != '') ? set_value('description') : $row['description']; ?></textarea>
         <?php echo form_error('description', '<p class="invaild-9-field">', '</p>'); ?>
      </div>
    </div>
    </div>
    <?php } ?>
     

   </div>
<!--///////////////////////////////////////////////////// -->

   <div class="tab-pane" id="profile" role="tabpanel">



        <div class="page-content">
    <div>
  <div class="add-out-g">
    <div id="todo-list">
       <div class="pal-add-ct">
        <div class="table-add-cate">


 <div class="multi-field-wrapper multi-add-ca"> 
  <div class="multi-fields">
   <div class="multi-field">           
    <div class="row">
      
      <div class="col-md-6">
       <div class="form-group"> 
       <div class="cel-add-cate"> 
        <input class="form-control" type="text" name="variants_name[]">
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

  <?php foreach ($ftrVariants as $lists) { ?>
         
    <div id="<?= 'remv_'.$lists['f_var_id']; ?>" class="multi-field"> 
    <div class="row">

      <div class="col-cu-2 col-sm-3 col-md-3">
       <div class="cel-add-cate"> 
         <input class="form-control" type="text" value="<?= $lists['variants_name']; ?>">
       </div>        
      </div>

       <div class="col-cu-4 col-sm-3 col-md-4">
          <a class="feature_remove btn btn-danger" sectionId="<?= $lists['f_var_id']; ?>" href="#" class="col-xl-2 eliminar1"><i class="fa  fa-trash-o" aria-hidden="true"></i></a> 
      </div>

        </div>
    </div>
  <?php } ?>

        </div>
              </div>
            </div>
          </div>


          </div>
      </div>
     
   </div>
<!--///////////////////////////////////////////////////// -->


  <div class="tab-pane" id="messages" role="tabpanel">


  

  <div class="add-out-g">
    <div id="todo-list">
     <div class="row">
      <div class="col-md-12">
       <div class="form-group">
        <select data-width="50%" title="All categories included" name="cat_name[]" class="selectpicker" multiple data-actions-box="true" data-live-search="true">
         <?php foreach ($catAllList as $catAllList) { ?>
            <option value="<?= $catAllList['cat_id'];?>"  <?php echo set_select('cat_name',$catAllList['cat_id'], False); ?> ><?= $catAllList['cat_name'] ?></option>
            <?php } ?>
        </select>
      </div>
     </div>
    </div>
    </div>
</div>
    
 



     
     <div class="add-out-g">
    <div id="todo-list">
     <div class="form-group col-md-12">
       <div class="page-content container-fluid">
  
        <?php foreach ($catList as $catLists) { ?>

        <div id="<?= 'rmv_'.$catLists['c_f_id']; ?>" class="row">

         
          <a  href=""><?= $catLists['cat_name']; ?><a/>

           <a class="remove" sectionId="<?= $catLists['c_f_id']; ?>" href="#" class="col-xl-2 eliminar1">&times;</a>
        
         </div>
        <?php } ?>

      </div>
      </div>
    </div>
</div> 
   </div>


</div>

 <div class="col-md-12">
  <div class="form-group">
      <input class="btn btn-success" type="submit" value="Update">
  </div>
 </div>

  </form>

    </div>
    </div>
    </div>
</div>
</div>

     <?php include('assets/include/footer.php'); ?>
<script type="text/javascript">
  $('.remove').click(function(){
     var sectionId = $(this).attr('sectionId');
     $.ajax({
              type: 'post',
              url: '<?= CUSTOM_BASE_URL . 'Features/deleteFeatureCatList' ?>', //Here you will fetch records 
              data: 'rowid=' + sectionId , //Pass $id
              success: function (data) {

              $('#rmv_'+sectionId).hide();
              // $('.fil-dele').html(data);//Show fetched data from database
              }
          });

}); 

    $('.feature_remove').click(function(){
   var sectionId = $(this).attr('sectionId');
   $.ajax({
            type: 'post',
            url: '<?= CUSTOM_BASE_URL . 'Features/deleteFeatureList' ?>', //Here you will fetch records 
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