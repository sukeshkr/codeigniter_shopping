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
          <h1>Add Feature</h1>
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
    <a class="nav-link" data-toggle="tab" href="#cat" role="tab">Category</a>
  </li>
  
</ul>
<form class="add-ca-in" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>Features/create">
<!-- Tab panes -->
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
         <input type="text" class="form-control" name="name" value="<?php echo set_value('name') ?>">
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
        <option value="0">-None-</option>
       <?php foreach ($group as $row) { ?>
            <option value="<?= $row['grp_id'];?>"  <?php echo set_select('group_name',$row['grp_id'], False); ?> ><?php echo $row['group_name'] ?></option>
            <?php } ?>
        </select>
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
        <input type="checkbox" name="variant_check" value="1" checked> 
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
         <textarea name="description" class="form-control" rows="4" cols="50"></textarea>
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
         <input type="text" class="form-control" name="variants_name[]" placeholder="Name">
         <?php echo form_error('variants_name[]', '<p class="invaild-9-field">', '</p>'); ?>
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
            


    
  </div>


  <div class="tab-pane" id="cat" role="tabpanel">

  <div class="add-out-g">
    <div class="pb-20" id="todo-list">
    <div class="row">   
     <div class="col-md-12">
       <div class="form-group">  
        <select data-width="50%" title="All categories included" name="cat_name[]" class="selectpicker" multiple data-actions-box="true" data-live-search="true">
         <?php foreach ($catList as $catLists) { ?>
            <option value="<?= $catLists['cat_id'];?>"  <?php echo set_select('cat_name',$catLists['cat_id'], False); ?> ><?= $catLists['cat_name'] ?></option>
            <?php } ?>
        </select>
       </div>
      </div>
     </div>
       <?php echo form_error('cat_name[]', '<p class="invaild-9-field">', '</p>'); ?>
    </div>
</div>
    
  </div>

</div>
    
    <div class="row regi-10-out"> 
     <div class="form-group col-md-12">
      <div class="form-group col-md-12">
       <input class="btn btn-success" type="submit" value="Create">
      </div>
     </div>
    </div>
    
    </form>
    </div>
    </div>
     </div>
      </div>
    <!-- /.box -->

</section>
<!-- /.content -->
          
           
      </div><!-- /.content-wrapper --> 
      <footer class="main-footer clearfix">
        <div class="pull-right">
         <strong>Copyright &copy; 2019 <a target="_blank" href="#">Bangalore Bazaar</a></strong>.  All Rights Reserved.
        </div>
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
     <?php include('assets/include/footer.php'); ?>
  </body>
</html>

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