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
          <h1>Features Groups</h1>
        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">
                <div class="box-header">
                  <a class="btn bg-olive" href="<?= CUSTOM_BASE_URL;?>Feature_groups/create">Create</a>
                </div><!-- /.box-header -->
                <div class="box-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th>Slno</th>
                  <th>Group name</th>
                  <th>Action</th>
                </tr>
              </thead>
        
              <tbody>
                 <?php
                $slNo = 1;
                foreach ($list as $row) { ?>
                <tr>
                  <td><?= $slNo ?></td>
                  <td><?= $row['group_name'];  ?></td>
                     <td>
                          <a class="btn btn-warning" href="<?= CUSTOM_BASE_URL.'Feature_groups/edit/'.$row['grp_id'];?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
                          <a data-id="<?= $row['grp_id']; ?>" data-toggle="modal" data-target="#delModal" class="btn  btn-danger"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php  $slNo++; } ?>
              </tbody>
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
              
          </div>

        </div>
      </div>
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
              url: '<?= CUSTOM_BASE_URL . 'Feature_groups/delete' ?>', //Here you will fetch records 
              data: 'rowid=' + rowid , //Pass $id
              success: function (data) {
               $('.ftr-dele').html(data);//Show fetched data from database
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