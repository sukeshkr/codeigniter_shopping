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
          <h1>Banner List</h1>
        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">
                <div class="box-header">
                  <a class="btn bg-olive" href="<?= CUSTOM_BASE_URL;?>cart_banner/create">Create</a>
                </div><!-- /.box-header -->
                <div class="box-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="table">
                                    <thead>
                                        <tr>
                                            <th>#Serial</th>
                                            <th>Banner name</th>
                                            <th>Banner Type</th>
                                            <th>Banner Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
               
          </section>
<!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a target="_blank" href="http://softlinksolution.com">softlinksolution</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
     
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <!-- jQuery 2.1.4 -->
     <!-- DataTables JavaScript -->


       <!-- VIEW MODAL BODY -->
    <div class="modal fade view-modal" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="project-view"></div>
            </div>
        </div>
    </div>

     <!-- DELETE MODAL BODY -->
     <div class="modal fade del-modal" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                  <div class="pro-dele"></div>
            </div>
        </div>
    </div>
    <!--confirm project delete-->
    <div class="modal fade sucs-modal" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4 class="modal-title" >Deleted successfully !</h4>
                    <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!--confirm project edit-->
    <div class="modal fade sucs-modal" id="update_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4 class="modal-title" >updated successfully !</h4>
                    <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!--confirm project add-->
      <div class="modal fade sucs-modal" id="add_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4 class="modal-title" >Added successfully !</h4>
                    <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

         <div class="modal fade sucs-modal" id="exist_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              
                <div class="alert alert-danger">
                  <a href="#" data-dismiss="alert" class="close" aria-label="close" title="close">×</a>
                   <strong>Duplicate !!</strong> Sorry... This module you already added ..You can only Edit this item..
                </div>
        
            </div>
        </div>
    </div>


     <?php include('assets/include/footer.php'); ?>
     <script>





    $(document).ready(function () {//delete_casestudy modal when edit button click
        $('#delModal').on('show.bs.modal', function (e) 
        {
            var rowid = $(e.relatedTarget).data('id');
           // var name = $(e.relatedTarget).data('name');
           // var cropname = $(e.relatedTarget).data('cropname');
            $.ajax({
                type: 'post',
                url: '<?= CUSTOM_BASE_URL . 'Cart_banner/delete' ?>', //Here you will fetch records 
                data: 'rowid=' + rowid , //Pass $id
                //data: 'rowid=' + rowid + '&name=' + name + '&cropname=' + cropname, //Pass $id
                success: function (data) {
                 $('.pro-dele').html(data);//Show fetched data from database
                }
            });
        });
    });


    $(document).ready(function () {

        $('#view-modal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //alert(rowid);
            $.ajax({
          type: 'post',
          url: '<?= CUSTOM_BASE_URL . 'Other_banners/view' ?>', //Here you will fetch records 
          data: 'rowid=' + rowid, //Pass $id
          success: function (data) {
             $('.project-view').html(data);//Show fetched data from database
          }
      });
        });
    });

 
    </script>
  </body>
</html>



     <script>


    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>


<script type="text/javascript">
    var table;
    $(document).ready(function() {
        //datatables id
        table = $('#table').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
        "url": '<?php echo site_url('Cart_banner/bannerlist'); ?>',
        "type": "POST",
        },
        });
    });

    //sucessfuly add edit delete popup with fals data
<?php if ($this->session->flashdata('add')) { ?>
    $("#add_confirm").modal('show');<?php } ?>
<?php if ($this->session->flashdata('update')) { ?>
    $("#update_confirm").modal('show');<?php } ?>
<?php if ($this->session->flashdata('delete')) { ?>
    $("#delete_confirm").modal('show');<?php } ?>



      $(function () {

        $("#example1").DataTable();

        $('#example2').DataTable({

          "paging": true,

          "lengthChange": false,

          "searching": false,

          "ordering": true,

          "info": true,

          "autoWidth": false

        });

      });


    </script>
