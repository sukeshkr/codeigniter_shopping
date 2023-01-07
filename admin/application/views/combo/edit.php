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
          <h1>Edit Offer</h1>
        </section>

        <!-- Main content -->
          <section class="content">
            <div class="box">
               
                <div class="box-body">

<form class="add-ca-in" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>combo_offer/update">
    
    <div class="container-fluid">

  <?php foreach ($result as $row) { ?>

   <input type="hidden" name="id" value="<?= $row['id'] ?>">


      <div class="row regi-10-out">
       <div class="col-md-4">   
        <div class="form-group">
          <label class="form-control-label" for="inputBasicFirstName">Change image</label>
        </div>
      </div>
      <div class="col-md-6">
         <div class="form-group"> 
          <a data-id='' data-toggle="modal" data-target="#cropModall" href="#">
          <img src="<?= CUSTOM_BASE_URL . 'uploads/combo_offer/'.$row['image']; ?>" class="img-responsive" id="previews"></a>
          <div class="help-block sucess" style="color:green;font-weight:bold;"></div>
          <?php echo form_error('image_file', '<p class="help-block error-info">', '</p>'); ?>
          <div class="error"></div>
          </div>
     </div>
    </div>

    
    <div class="row regi-10-out">
     <div class="col-md-4">
      <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Caption</label> 
       </div>
     </div>
     <div class="col-md-6">
      <div class="form-group">   
         <input type="text" class="form-control" name="caption" value="<?= set_value('caption', isset($row['caption']) ? $row['caption'] : '') ?>">
         <?php echo form_error('caption', '<p class="invaild-9-field">', '</p>'); ?>
      </div>
     </div>
    </div>

    <div class="row regi-10-out">
     <div class="col-md-4">
      <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Choose Product</label> 
      </div>
     </div>
     <div class="col-md-6">
      <div class="form-group"> 
          <select multiple title=" Select Product" class="form-control selectpicker" data-live-search="true" name="product_name" onchange="getval(this)" id="foo">
               
               <?php foreach ($list as $row_item) { ?>
            <option value="<?= $row_item['id'];?>"  <?php echo set_select('stock_name',$row_item['id'], False); ?> ><?php echo $row_item['stock_name'] ?></option>
            <?php } ?>
               
            </select>
         <?php echo form_error('business_category', '<p class="invaild-9-field">', '</p>'); ?>
         </div>
      </div>
    </div>
    



    <div class="row regi-10-out">
     <div class="col-md-4">
       <div class="form-group">
          <label class="form-control-label" for="inputBasicFirstName">Actual Price</label>
       </div>
    </div>
    
     <div class="col-md-3">
       <div class="form-group">
            <input id="list_price" class="form-control controls" type="text" placeholder="Actual Price" name="actual_price" value="<?= set_value('actual_price', isset($row['actual_price']) ? $row['actual_price'] : '') ?>">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
            <input  class="form-control controls" type="text" placeholder="Offer price" name="offer_price" value="<?= set_value('offer_price', isset($row['offer_price']) ? $row['offer_price'] : '') ?>">
     </div>
    </div>

    </div>



    <div class="row regi-10-out">
     <div class="col-md-4">
       <div class="form-group">
          <label class="form-control-label" for="inputBasicFirstName">Min Purchase</label> 
       </div>
    </div>
    <div class="col-md-6">
       <div class="form-group">
            <input class="form-control controls" type="text" placeholder="Min Purchase" name="min_purchase" value="<?= set_value('min_purchase', isset($row['min_purchase']) ? $row['min_purchase'] : '') ?>">
       </div>       
    </div>
    </div>



    <div class="row regi-10-out">
     <div class="col-md-4">
       <div class="form-group">
          <label class="form-control-label" for="inputBasicFirstName">Deal Qty</label> 
       </div>
    </div>
     <div class="col-md-6">
       <div class="form-group">
            <input  class="form-control controls" type="text" placeholder="Deal Qty" name="deal_qty" value="<?= set_value('order_qty', isset($row['order_qty']) ? $row['order_qty'] : '') ?>">
       </div>  
    </div>
    </div>

         
    <div class="row regi-10-out">  
     <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Offer start</label> 
       </div>
    </div>
    <div class="col-md-6">
       <div class="form-group">
         <input type="datetime-local" class="form-control" name="offer_start" value="<?= set_value('offer_start', isset($row['offer_start']) ? $row['offer_start'] : '') ?>">
         <?php echo form_error('offer_start', '<p class="invaild-9-field">', '</p>'); ?>
      </div>
    </div>
  </div>

    <div class="row regi-10-out">  
     <div class="col-md-4">
       <div class="form-group">
         <label class="form-control-label" for="inputBasicFirstName">Offer End</label> 
       </div>
     </div>
     <div class="col-md-6">
       <div class="form-group">
         <input type="datetime-local" class="form-control" name="offer_end" value="<?= set_value('offer_end', isset($row['offer_end']) ? $row['offer_end'] : '') ?>">
         <?php echo form_error('offer_end', '<p class="invaild-9-field">', '</p>'); ?>
      </div>
     </div>
    </div>


      <div class="row regi-10-out">
     <div class="col-md-4">
       <div class="form-group">
          <label class="form-control-label" for="inputBasicFirstName">Discription</label> 
       </div>
     </div>
     <div class="col-md-6">
       <div class="form-group">
            <textarea placeholder="Enter Discription" name="description" class="form-control controls"><?= set_value('description', isset($row['description']) ? $row['description'] : '') ?></textarea> 
     </div>      
    </div>

  </div>

        <!--  Profile  picture  -->
                    <div class="modal fade" id="cropModall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Image Croping</h4>
                            
                             </div>
                        <div class="modal-body">
                                    <div class="form-group">
                                        <label>image</label>
                                        <input type="hidden" id="x1" name="x1" />
                                        <input type="hidden" id="y1" name="y1" />
                                        <input type="hidden" id="x2" name="x2" />
                                        <input type="hidden" id="y2" name="y2" />
                                        <input type="hidden" id="admin_url" name="admin_url" value=" <?= CUSTOM_BASE_URL.'assets/images/loading.gif';?> " />
                                        <div  class="form-group">
                                        <input accept="image/x-png,image/jpeg" type="file"  name="image_file" id="image_file" onChange="fileSelectHandler()"  class="form-control"/>
                                        </div>
                                                <div id="loading"></div>
                                                <div class="error"></div>
                                                <img id="preview" />  
                                        <div class="step2">
                                        <h5>Please select a crop region</h5>

                                        <div class="info">
                                         <!-- <h4><a class="btn btn-primary" data-dismiss="modal">Add Image</a></h4>   -->
                                        <input type="hidden" id="filesize" name="filesize" />
                                        <input type="hidden" id="filetype" name="filetype" />
                                        <input type="hidden" id="filedim" name="filedim" />
                                        <input type="hidden" id="w" name="w" />
                                        <input type="hidden" id="h" name="h" />
                                        <input type="hidden" id="admin_url" value="<?= CUSTOM_BASE_URL.'assets/images/loading.gif';?>">
                                    </div>
                                    <a class="btn btn-primary" data-dismiss="modal">Add Image</a>
                                </div>
                            </div>
                             </div>
                        </div>
                    </div>
                </div>
    

    <div class="row regi-10-out"> 
      <div class="form-group col-md-7 offset-md-5">
        <input class="btn btn-success" type="submit" name="submit" value="Update">
      </div>
    </div>
      <?php } ?>
      </div>
    </form>

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



<script type="text/javascript" src="<?= CUSTOM_BASE_URL .'assets/plugins/crop/script_combo.js'?>"></script>

     <?php include('assets/include/footer.php'); ?>
 <!--crop jss -->

<!-- <script type="text/javascript">
function getval(sel)
{

  var sectionId = sel.value;

  alert(sectionId)

    $.ajax({
        
            type: 'post',
     
           
            url: '<?= CUSTOM_BASE_URL . 'Discounts/SelectPriceList' ?>', //Here you will fetch records 
             dataType:"json",
            data: 'rowid=' + sectionId , //Pass $id
            success: function (data) {

               $('#price').val(data[0]['price']);
               $('#list_price').val(data[0]['list_price']);
               $('#discount').val(data[0]['discount']);

            }
    });
}

</script> -->

<script type="text/javascript">


// $('#dog').on('click', function(){
//     var selected=$("#foo option:selected").map(function(){ return this.value }).get();
//     selected.push(2);// 2 is the val I set for Dog
//     $('#foo').val(selected);
// });


function getval(sel) {

  var opts = [],
  opt;
  var len = sel.options.length;

  for (var i = 0; i < len; i++) {

    opt = sel.options[i];

    if (opt.selected) {

      opts.push(opt.value);
    }
  }

     $.ajax({
        
            type: 'post',
           
            url: '<?= CUSTOM_BASE_URL . 'Combo_offer/getPriceList' ?>', //Here you will fetch records 
            data: 'rowid=' + opts , //Pass $id
            success: function (data) {

                $('#list_price').val(data);

            }
    });

}
</script>