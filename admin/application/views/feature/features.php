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
            <table width="100%" class="table table-striped table-bordered table-hover" id="tree-table">
                                    <thead>
                                        <tr>
                                          <th>#Serial</th>
                                          <th>Name</th>
                                          <th>group_name</th>
                                          <th>Action</th>
                                          
                                        </tr>
                                    </thead>
                                </table>
          </div>

              
              </div>
          </section>
        
          
          
        </div>
        
       <footer class="main-footer clearfix">
        <div class="pull-right">
         <strong>Copyright &copy; 2019 <a target="_blank" href="#">Bangalore Bazaar</a></strong>.  All Rights Reserved.
        </div>
      </footer> 
        
      </div>
   
          
           
  

 


          <!-- DELETE MODAL BODY -->
     <div class="modal fade del-modal" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-7-de" role="document">
            <div class="modal-content cat-3-dele">
                  <div class="ftr-dele"></div>
            </div>
        </div>
    </div>   
     <?php include('assets/include/footer.php'); ?>
<script type="text/javascript">
  $(document).ready(function () {
      $('#delModal').on('show.bs.modal', function (e) 
      {
          var rowid = $(e.relatedTarget).data('id');
          $.ajax({
              type: 'post',
              url: '<?= CUSTOM_BASE_URL . 'Features/delete' ?>', //Here you will fetch records 
              data: 'rowid=' + rowid , //Pass $id
              success: function (data) {
               $('.ftr-dele').html(data);//Show fetched data from database
              }
          });
      });
  });

</script>

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
        "url": '<?php echo site_url('Features/feature_list'); ?>',
        "type": "POST",
        },
        });
    });


</script>