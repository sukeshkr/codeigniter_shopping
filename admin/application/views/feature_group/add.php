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
          <h1>Add Features Groups</h1>
        </section>
          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">


<form class="add-ca-in" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>feature_groups/create">
<!-- Tab panes -->
    
<div class="container-fluid">    
<div class="row">

  <div class="col-md-12">

     <div class="row regi-10-out">
      <div class="col-md-4">
        <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Name</label>
        </div>
      </div>
      <div class="col-md-6">
       <div class="form-group">
         <input type="text" class="form-control" name="group_name" value="<?php echo set_value('group_name') ?>">
         <?php echo form_error('group_name', '<p class="invaild-9-field">', '</p>'); ?>
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

</div>
    
    <div class="row regi-10-out"> 
     <div class="col-md-7">
      <div class="form-group">
        <input class="btn btn-success" type="submit" value="Create">
      </div>
     </div>
    </div>
    
</div>    
   




    </form>
        
        
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

   <!-- jQuery 2.1.4 -->
     <?php include('assets/include/footer.php'); ?>
  </body>
</html>