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
          <h1>Stock Update</h1>
        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">
                <div class="box-body">
            <div><a data-toggle="modal"  data-target="#search" class="btn  btn-primary" href="#">Search</a></div></br>
            <form enctype="multipart/form-data" method="post" name="report" action="<?= CUSTOM_BASE_URL . 'Report/product_wise_report_print' ?>" >
            <?php if(!empty($cat)) ?>
            <input type="text" name="category" value="<?php echo $cat; ?>">
            <input type="submit" class="btn  btn-primary" value="Download"></br>
            </form>
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
                                    
                                                                        <? $no='';
                                           foreach ($list as $order) { ?>

                                    <tbody>        
                                	     <?php  $no++; ?>
                                	        
                                	        <td><?php echo $no; ?></td>
                                	        <td><?php echo $order->product_name; ?></td>
                                	        <td><?php echo $order->stock_name; ?></td>
                                	        <td><?php echo $order->stock; ?></td>
                                	        <td><?php echo $order->price; ?></td>
                                	        <td><?php echo $order->list_price; ?></td>
                                	        <td><?php echo $order->discount; ?></td>
  
                                	        
                                	        
                                	 </tbody>       
                                	 <?php } ?>
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



	 <div id="search" class="modal fade sucs-modal" role="dialog">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
                <div class="modal-header">
                	
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                	<div class="row">
               	<form class="form-input-style book-now_web" style="width:90%;margin-left:5%;box-shadow: none;padding-top: 0" autocomplete="off" name="search" enctype="multipart/form-data" method="post" action="<?= CUSTOM_BASE_URL;?>report/product_wise_index">
						<div class="row">

							<div class="col-md-6">
								<h4><b>SEARCH</b></h4><br />
								  <div class="form-group">

                            <label class="form-control-label" for="inputBasicFirstName">Status</label> 

								<select class="form-control selectpicker" name="category" id="category" >
                                    <option value="">Select</option>
                                    <?php foreach($category as $list) { ?>
                                    <option value="<?php echo $list->cat_id;?>"><?php echo $list->cat_name;?></option>

                                    <? } ?>
                                </select>
								   
							</div>
							  	
  
							</div>
						</div>
							
						
						<div class="row">
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-success"><b>SEARCH</b></button>
							</div>
						</div>
					</form>
				</div>
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

