<?php include("layout/header.php");?>

    <!-- Page -->
    <div class="page">
        <form id="exampleStandardForm" autocomplete="off" name="myform" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>Product/create"> 
   
        
              <div class="panel-body">
                <button type="submit" class="btn btn-success" id="validateButton2">Submit</button>
                <button type="submit" class="btn btn-primary" id="validateButton2">Cancel</button>
              </div>

               <div class="form-group col-md-12">
             <label class="form-control-label" for="inputBasicFirstName">Pick Your Seller</label>  
              <select name="register" class="form-control">
        <option value="">Select</option>
          <?php foreach ($result as $row) { ?>
          <option value="<?= $row['reg_id'];?>"  <?php echo set_select('register',$row['reg_id'], False); ?> ><?php echo $row['bus_name'] ?></option>
          <?php } ?>
       </select>

            </div>
             <?php echo form_error('register', '<p class="invaild-9-field">', '</p>'); ?>
          
          


    <!-- End Page -->
      </form>
    </div>

<?php include("layout/footer.php");?>

<script type="text/javascript">
  $('select.selectpicker').selectpicker({
        liveSearch: true
    }).on('hidden.bs.select',
        function () {
            $(this).data('selectpicker').$searchbox.val('').trigger('propertychange');
        });
</script>