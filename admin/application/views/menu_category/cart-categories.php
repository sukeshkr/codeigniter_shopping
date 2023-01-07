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
          <h1>Set Home Category</h1>
        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">

               <div class="box-header">
                  <a class="btn bg-olive" href="<?= CUSTOM_BASE_URL;?>Menu_category/menu_category_wise">Menu Order</a>
                </div><!-- /.box-header -->
              
                <div class="box-body">

             <table width="100%" class="table table-striped table-bordered table-hover" id="tree-table">
                        <thead>
                            <tr>
                              <th>#Serial</th>
                              <th>Category</th>
                              <th>Display name</th>
                               <th>Action</th>
                            </tr>
                        </thead>
                    </table>

              </div>
        </div>
              
        </div>
      <footer class="main-footer clearfix">
        <div class="pull-right">
         <strong>Copyright &copy; 2019 <a target="_blank" href="#">Bangalore Bazaar</a></strong>.  All Rights Reserved.
        </div>
      </footer> 
      </div>           
            
      <!-- VIEW MODAL BODY -->
        <div class="modal fade" id="view-modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content model_gallery">
                    <div class="modal-body">
                        <div class="row">
                            <!----modal calling div-->
                            <div class="view-modal"></div>
                 
                            <!----end modal calling div-->
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

 
    <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script> 
    <script src="<?php echo base_url() ?>layout/assets/javascript.js"></script>

     <?php include('assets/include/footer.php'); ?>
  
<script type="text/javascript">

    var table;

    $(document).ready(function() {
        //datatables id
        table = $('#tree-table').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
        "url": '<?php echo site_url('Menu_category/cat_list'); ?>',
        "type": "POST",
        },
        });
    });


</script>
<script type="text/javascript">

  function Check(rowid) {

   // var chkPassport = document.getElementById("chkPassport");

    var lfckv = document.getElementById(rowid+"lifecheck").checked;

    if (lfckv) {

      status=1;

    } else {

      status=0;
    }

    $.ajax({
          type: 'post',
          url: '<?= CUSTOM_BASE_URL . 'Menu_category/setCartTopCat' ?>', //Here you will fetch records 
            data: 'rowid=' + rowid + '&status=' + status, //Pass $id
          success: function (data) {

            alert(data)

          }
    });
  }

</script>