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
          <h1>Stock Report</h1>
        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">
                <div class="box-body">
<div><a class="btn  btn-primary" href="<?= CUSTOM_BASE_URL . 'Report/stock_report_print' ?>">Download</a></div></br>
            <table width="100%" class="table table-striped table-bordered table-hover" id="tree-table">
                                    <thead>
                                        <tr>
                                          <th>#Serial</th>
                                          <th>Product name</th>
                                          <th>Stock Name</th>
                                          <th>Stock</th>
                                          <th>Price</th>
                                          <th>List Price</th>
                                          <th>Discount</th>
                                          
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
         
        </div>
      </div>
    </div>    


         <!-- DELETE MODAL BODY -->
     <div class="modal fade del-modal" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-7-de" role="document">
            <div class="modal-content">
                  <div class="pro-dele"></div>
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
        "url": '<?php echo site_url('Report/stock_report'); ?>',
        "type": "POST",
        },
        });
    });


</script>



<script type="text/javascript">

  function checkPrice(rowid) {

    var value=document.getElementById(rowid+"price").value

    $.ajax({
          type: 'post',
          url: '<?= CUSTOM_BASE_URL . 'Stock_update/setPrice' ?>', //Here you will fetch records 
            data: 'rowid=' + rowid + '&value=' + value, //Pass $id
          success: function (data) {

          }
    });
  }

</script>

<script type="text/javascript">

  function checkListPrice(rowid) {

    var value=document.getElementById(rowid+"list_price").value

    $.ajax({
          type: 'post',
          url: '<?= CUSTOM_BASE_URL . 'Stock_update/setListPrice' ?>', //Here you will fetch records 
            data: 'rowid=' + rowid + '&value=' + value, //Pass $id
          success: function (data) {

          }
    });
  }

</script>

<script type="text/javascript">

  function checkStock(rowid) {

    var value=document.getElementById(rowid+"stock").value

    $.ajax({
          type: 'post',
          url: '<?= CUSTOM_BASE_URL . 'Stock_update/setStock' ?>', //Here you will fetch records 
            data: 'rowid=' + rowid + '&value=' + value, //Pass $id
          success: function (data) {

          }
    });
  }

</script>

<script type="text/javascript">
$(document).ready(function(){

    $('#save').on('click', function(){
        var fileInput = $('#file_input')[0];
        if( fileInput.files.length > 0 ){
            var formData = new FormData();
            $.each(fileInput.files, function(k,file){
                formData.append('images[]', file);
            });
            $.ajax({
                method: 'post',
                url: '<?= CUSTOM_BASE_URL . 'Stock_update/multi_uploader' ?>', //Here you will fetch records 
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                }
            });
        }else{
            console.log('No Files Selected');
        }
    });

});
</script>

<script type="text/javascript">



     $(document).ready(function () {//delete_casestudy modal when edit button click
        $('#priceModal').on('show.bs.modal', function (e) 
        {
            var rowid = $(e.relatedTarget).data('id');
            var fileInput = $('#file_input'+rowid)[0];
        if( fileInput.files.length > 0 ){
            var formData = new FormData();
            $.each(fileInput.files, function(k,file){
                formData.append('images[]', file);
            });
            formData.append('rowid', rowid);

            $.ajax({
                method: 'post',
                url: '<?= CUSTOM_BASE_URL . 'Stock_update/process' ?>', //Here you will fetch records
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                  alert(response)
                    //console.log(response);
                }
            });
        }else{
            console.log('No Files Selected');
        }
        });
     });

</script>

