<?php foreach ($project as $row) 
  { 
  $ci_name=strtolower($this->router->fetch_class());?> 

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <img src="<?= CUSTOM_BASE_URL . 'uploads/'.$ci_name.'/'.$row['image_name']; ?>" class="img-responsive">
        </div>
      

    </div>
</div>
<?php } ?> 