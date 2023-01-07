<?php foreach ($project as $row) 
  { 
  $ci_name=strtolower($this->router->fetch_class());?> 

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $row['module_name'];?></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <img src="<?= CUSTOM_BASE_URL . 'uploads/'.$ci_name.'/'.$row['image_name']; ?>" class="img-responsive">
        </div>
        <div class="col-md-12">
           
           
        </div>

    </div>
</div>
<?php } ?> 