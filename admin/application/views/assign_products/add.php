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
          <h1>Add Option</h1>
        </section>
          
 
          
        <!-- Main content -->
<section class="content">

    <div class="box box-primary">
    <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
     
<form class="add-ca-in" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>assign_products/create">
<!-- Tab panes -->
<div class="tab-content panel-body">

  
  

    <div class="add-out-g">
      <div class="pb-20" id="todo-list">
        <div class="form-group"> 
           <label>From</label>
          <select data-width="50%" title="Select Store" name="store_name" class="selectpicker"  data-live-search="true">
           <?php foreach ($list as $stores) { ?>
              <option value="<?= $stores['id'];?>"  <?php echo set_select('location',$stores['id'], False); ?> ><?= $stores['location'] ?></option>
              <?php } ?>
          </select>
          </div>
         <?php echo form_error('location', '<p class="invaild-9-field">', '</p>'); ?>
      </div>
    </div>

        <div class="add-out-g">
      <div class="pb-20" id="todo-list">
        <div class="form-group">
         <label>To</label> 
          <select data-width="50%" title="Select Store" name="assign_store_name" class="selectpicker"  data-live-search="true">
           <?php foreach ($list as $stores) { ?>
              <option value="<?= $stores['id'];?>"  <?php echo set_select('location',$stores['id'], False); ?> ><?= $stores['location'] ?></option>
              <?php } ?>
          </select>
          </div>
         <?php echo form_error('location', '<p class="invaild-9-field">', '</p>'); ?>
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
    </div>
          </div>
      </div>
          

</section>
   
        
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




    <!-- jQuery 2.1.4 -->
     <?php include('assets/include/footer.php'); ?>
      
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
  </body>
</html>