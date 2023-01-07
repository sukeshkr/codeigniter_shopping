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
          <h1>Combo Offer</h1>
        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">
                <div class="box-header">
                  <a class="btn bg-olive" href="<?= CUSTOM_BASE_URL;?>combo_offer/create">Create</a>
                </div><!-- /.box-header -->
                <div class="box-body">
           <table width="100%" class="table table-striped table-bordered table-hover" id="tree-table">
                                    <thead>
                                        <tr>
                                          <th>#Serial</th>
                                          <th>Caption name</th>
                                          <th>Actual Price</th>
                                          <th>Offer Price</th>
                                          <th>Offer start</th>
                                          <th>Offer end</th>
                                          <th>Image</th>
                                          <th>Action</th>
                                          
                                        </tr>
                                    </thead>
                                </table>
          </div>
  </div>
 </div>   
  </div>
  </div>
</div>
</div>


          </div>
      </div>
      <footer class="main-footer clearfix">
        <div class="pull-right">
         <strong>Copyright &copy; 2019 <a target="_blank" href="#">Bangalore Bazaar</a></strong>.  All Rights Reserved.
        </div>
      </footer>  
    </div>
    <!-- End Page -->


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

         <!-- DELETE MODAL BODY -->
     <div class="modal fade del-modal" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-7-de" role="document">
            <div class="modal-content">
                  <div class="reg-dele"></div>
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
        "url": '<?php echo site_url('Combo_offer/combo_list'); ?>',
        "type": "POST",
        },
        });
    });


</script>

<script>

    $(document).ready(function () {

        $('#view-modal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?php echo site_url('Combo_offer/view'); ?>',
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.view-modal').html(data);
                }
            });
        });
    });
</script> 

<script type="text/javascript">

    $(document).ready(function () {//delete_casestudy modal when edit button click
        $('#delModal').on('show.bs.modal', function (e) 
        {
            var rowid = $(e.relatedTarget).data('id');
            
            $.ajax({
                type: 'post',
                url: '<?= CUSTOM_BASE_URL . 'Combo_offer/delete' ?>', //Here you will fetch records 
                data: 'rowid=' + rowid, //Pass $id
                success: function (data) {
                 $('.reg-dele').html(data);//Show fetched data from database
                }
            });
        });
    });

</script>