<?php include("web/assets/include/my-header.php");?>

  <main role="main" class="my-profile-main">
    <div class="container-fluid">    
      <div class="row">          
          
        <div class="col-lg-12 col-xl-12">
         <div class="my-profile-right clearfix">
          <div class="mange-add-ac">
           <h2 class="in-heda-ab">Stores</h2>
            <div class="stores-out12">
             <div class="row">
                 
            <?php foreach ($store_list as $key => $store_rows) {  
                
                $stckratt = base64_encode($store_rows->id .SALT_KEY.CKRAT_KEY);
            
            ?>
            
              <div class="col-lg-6 col-xl-6">
                  <div class="str-con-out">
                     <div class="sto-img13" style="background-image: url(<?= CUSTOM_BASE_URL . 'admin/uploads/store/crop/'.$store_rows->og_image; ?>);">
                     </div>
                     <div class="sto-txt14">
                       <h2><?= $store_rows->location ?></h2>
                       <p><b>Location:</b> <?= $store_rows->address ?></p>
                       <a class="transition sto-deta15" href="<?= CUSTOM_BASE_URL . 'store-details/'.$stckratt; ?>">View details</a>
                     </div>
                  </div>  
              </div>
                 
            <?php } ?>
 
             </div>
            </div>       
          </div>
         </div>  
        </div>
        <!-- /Right side -->
          
      </div>    
    </div> 
        
 </main>    
 <?php include("web/assets/include/my-footer.php");?>
