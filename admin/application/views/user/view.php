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
          <h1>View User</h1>
        </section>

          
        <!-- Main content -->
<section class="content">
    <!--            <div class="row">-->
    <div class="box box-primary">

                
                <div class="row">
                  <div class="container-fluid">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="<?= CUSTOM_BASE_URL .'user/create'?>" class="btn btn-success">Add user</a>
                            </div>
                            <div class="panel-body panel-scroll">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#Serial</th>
                                            <th>username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php $val = 1; ?>
                                    <?php foreach ($profile as $row) { ?>
                                    
                                        <tr>
                                            <td><?= $val++ ?></td>
                                            <td><?= $row['username']; ?></td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= $row['role']; ?></td>
                                            <td>



                                               <a class="btn btn-warning" href="<?= CUSTOM_BASE_URL.'user/edit/'.$row['id'];?>"><i class="fa fa-edit" aria-hidden="true"></i></a>

                                                <a data-id="<?= $row['id']; ?>" data-toggle="modal" data-target="#del-modal" class="btn  btn-danger"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

   </section>
<!-- /.content -->
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

</div>


    <!-- jQuery 2.1.4 -->
    <!-- VIEW MODAL BODY -->
     <div class="modal fade view-modal" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tax Consultance Association,Kerala</h4>
                    <span>Oct 21, 2016</span>
                </div>
                <div class="modal-body">
                    <img src="<?php echo base_url();?>assets/dist/images/news-img.jpg" class="img-responsive">
                    <p>For mountain lovers and the vertically inclined the Himalayas represent nothing less than the crowning apex of nature's grandeur. Here dramatic forested gorges rise to skylines of snow-capped glaciated peaks through a landscape that ranges from high-altitude desert to dripping rhododendron forest. <br><br>Home to some 40 million people, this is no alpine wilderness, but rather a vibrant mosaic of peoples, cultures and communities, criss-crossed by ancient trading and pilgrimage routes that offer their own unique inspiration</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- DELETE MODAL BODY -->
     <div class="modal fade del-modal" id="del-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="user-dele"></div>
            </div>
        </div>
    </div>
    
    <!-- DELETE MODAL BODY -->
    <div class="modal fade sucs-modal" id="sucs-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4 class="modal-title">News updated successfully !</h4>
                    <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    
         <?php include('assets/include/footer.php'); ?>

    
    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url();?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(document).ready(function () {
        $('#del-modal').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?php echo site_url('User/delete'); ?>', //Here you will fetch records 
                data: 'rowid=' + rowid , //Pass $id
                success: function (data) {
                 $('.user-dele').html(data);//Show fetched data from database
                }
            });
        });
    });


    </script>

</body>

</html>
