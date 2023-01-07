
   <style>
   body
   {
    margin:0;
    padding:0;
    background-color:#f1f1f1;
   }
   .box
   {
    width:1270px;
    padding:20px;
    background-color:#fff;
    border:1px solid #ccc;
    border-radius:5px;
    margin-top:25px;
   }
   #page_list td
   {
    padding:16px;
    background-color:#f9f9f9;
    border:1px dotted #ccc;
    cursor:move;
    margin-top:12px;
   }
  #page_list tr
   {
    width:80%;
    border:1px dotted #ccc;
    cursor:move;
    margin-top:12px;
   }
  
  </style>

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
          <h1>Drag and Sort Menu Category</h1>
        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">

    <div class="page">
      <div class="page-content">
        <div class="panel">  
    
          <div class="panel-body">
              
          <div class="page-main">

        <!-- Contacts Content Header -->
    

        <!-- Contacts Content -->
        <div id="contactsContent" class="page-content page-content-table page-content-table-b" data-plugin="selectable">

          <!-- Actions -->
    
            
  <div class="container box">
   <br />
   
    <table width="80%">
      <thead>
                <tr>
                  <th>Slno</th>
                  <th>Category Name</th>
                </tr>
              </thead>
      <tbody id="page_list">
   <?php 
   $slNo = 1;
    foreach ($list as $row) { 
                 
    echo '<tr id="'.$row["cat_id"].'"><td >'.$slNo.'</td><td >'.$row["cat_name"].'</td></tr> ';
    echo '<input type="hidden" value="'.$row["cat_id"].'" id="page_order_list" />';
    $slNo++;
   }
   ?>
   </tbody>
  </table>
   <input type="hidden" name="page_order_list" id="page_order_list" />
  </div>   
        

        <!-- End Panel Basic -->             
        </div>
      </div>           
              
          </div>
        </div>
      </div>
    </div>    

    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
         <!-- DELETE MODAL BODY -->
     <div class="modal fade del-modal" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-7-de" role="document">
            <div class="modal-content cat-3-dele">
                  <div class="opt-dele"></div>
            </div>
        </div>
    </div>   

    <script src="<?php echo base_url() ?>layout/assets/javascript.js"></script>

     <?php include('assets/include/footer.php'); ?>

<script>
$(document).ready(function(){
 $( "#page_list" ).sortable({

  placeholder : "ui-state-highlight",
  update  : function(event, ui)
  {
   var rowid = new Array();
   $('#page_list tr').each(function(){
    rowid.push($(this).attr("id"));
   });

    var id = $('#page_order_list').val(); 

    $.ajax({
              type: 'post',
              url: '<?= CUSTOM_BASE_URL . 'Menu_category/order' ?>', //Here you will fetch records 
              data: 'rowid=' + rowid + '&id=' + id, //Pass $id
              success: function (data) {
                alert(data)
              // $('.ftr-dele').html(data);//Show fetched data from database
              }
          });
  }
 });

});
</script>
