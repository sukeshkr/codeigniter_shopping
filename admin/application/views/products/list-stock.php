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
          <h1>Stock Varriants</h1>
        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">
              
        <div class="box-body">
        <div class="page-header-actions">
          <a href ="<?= CUSTOM_BASE_URL.'product/stock_create/'.base64_encode($product_name .SALT_KEY).'/'.$product_id.'/'.$cat_id?>"><button type="submit" class="btn btn-success" id="validateButton2">Add Variant</button></a>
        </div>

                     <input type="hidden" value="<?= $cat_id; ?>" name="cat_id">

                    <input type="hidden" value="<?= $product_id; ?>" name="product_id">

                    <input type="hidden" value="<?= $product_name; ?>" name="product_name">
        
                

          <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
               <thead>
                                <tr>
                                    <th>#Serial</th>
                                    <th>Stock Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>List price/th>
                                    <th>Discount</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $slNo = 1;
                                foreach ($stock as $row) { ?>

                                  <tr>
                                        <td><?= $slNo ?></td>
                                        <td><?= $row['stock_name'] ?></td>
                                        <td><?= $row['stock'] ?></td>
                                        <td><?= $row['price'] ?></td>
                                        <td><?= $row['list_price'] ?></td>
                                        <td><?= $row['discount'] ?></td>
                                        <td><img height="100" width="100" src="<?= CUSTOM_BASE_URL . 'uploads/product_multimage/'.$row['image']; ?>"></td>
                                        <td>
                                          <?php 
                                          if($row['status']==1){ 
                                            echo "Active"; 
                                          } 
                                          if($row['status']==2){ 
                                            echo "Active"; 
                                          }
                                          if($row['status']==0){ 
                                            echo "Deleted"; 
                                          }
                                         ?></td>
                                        <td class="actions">
                                        <a href="<?= CUSTOM_BASE_URL . 'product/edit/'.$row['id'].'/'.base64_encode($product_name .SALT_KEY).'/'.$cat_id; ?>" class="cte-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a data-id="<?= $row['id'] ?>" data-name="<?= $row['image'] ?>" data-toggle="modal"  data-target="#delModal" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a> </td>
                                       
                                        
                                    </tr>
                                    <?php
                                    $slNo++;
                                }
                                ?>
                            </tbody>
            </table>
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
</div>
</div>


          </div>
      </div>
    </div>
    <!-- End Page -->

         <!-- DELETE MODAL BODY -->
     <div class="modal fade del-modal" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-7-de" role="document">
            <div class="modal-content">
                  <div class="reg-dele"></div>
            </div>
        </div>
    </div>

     <?php include('assets/include/footer.php'); ?>

<script type="text/javascript">

    $(document).ready(function () {//delete_casestudy modal when edit button click
        $('#delModal').on('show.bs.modal', function (e) 
        {
            var rowid = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('name');
            $.ajax({
                type: 'post',
                url: '<?= CUSTOM_BASE_URL . 'Product/stock_delete' ?>', //Here you will fetch records 
                data: 'rowid=' + rowid + '&name=' + name, //Pass $id
                success: function (data) {
                  alert(data)
                 location.reload();
                }
            });
        });
    });

</script>


  <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>