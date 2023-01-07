<?php include("web/assets/include/my-header.php");?>

  <main role="main" class="my-profile-main">
    <div class="container-fluid">    
      <div class="row">
       <!-- Left side -->
        <div class="col-lg-3 col-xl-3">  
            
         <div class="my-profile-left">
                
          <ul class="my-name-lnk">
          <?php foreach ($store_data as $key => $stores): 

            $directoryURI = $_SERVER['REQUEST_URI'];
            $path = parse_url($directoryURI, PHP_URL_PATH);
            $components = explode('/', $path);
            $first_part = strtolower($components[3]);

            $address = substr($stores->address, 0, 20).'...';

            $stckratt = base64_encode($stores->id .SALT_KEY.CKRAT_KEY);


            if(strtolower($first_part)==strtolower($stckratt))
            {
              $active = 'active';

            } else {
              
              $active = '';
            }

            ?>
            
           <li>
            <a class="<?= $active;?>" href="<?= CUSTOM_BASE_URL . 'store-details/'.$stckratt; ?>">
             <div class="sid-ul-nam"><?= $stores->location;?> -<?= $address;?></div>
             <span><img src="<?= FILES_BASE_URL;?>assets/images/left-arrow.svg"></span>   
            </a>
           </li>
         <?php endforeach ?>
          </ul>
             
         </div>

        </div>
        <!-- /Left side -->          
          
        <div class="col-lg-9 col-xl-9">
         <div class="my-profile-right clearfix">
          <div class="mange-add-ac">
        <?php foreach ($store_list as $key => $store_rows) { ?>
           <h2 class="in-heda-ab"> <?= $store_rows->location ?></h2>
            <div class="str-dts-out12">
             <div class="row">
                 
              <div class="col-md-6 col-lg-6 col-xl-6">
                  <div class="brch-img12">
                      <img src="<?= CUSTOM_BASE_URL . 'admin/uploads/store/crop/'.$store_rows->og_image; ?>" alt="ahlul kaif">
                  </div>  
              </div>
                 
              <div class="col-md-6 col-lg-6 col-xl-6">
                  <div class="str-deta-con13">
                      
                   <div class="str-abt14"><b><?= $store_rows->description ?></b></div>
                   <div class="ma-con-add-ab">
                    <i class="glyph-icon flaticon-signs-1"></i> 
                    <div class="ma-spm-ac"><?= $store_rows->address ?></div>
                   </div>
                   <div class="ma-con-add-ab">
                    <i class="glyph-icon flaticon-technology"></i> 
                    <div class="ma-spm-ac"><a href="tel:+91-0000 00 00 00"><?= $store_rows->phone ?></a></div>
                   </div>
                   <div class="ma-con-add-ab">
                    <i class="glyph-icon flaticon-contact"></i> 
                    <div class="ma-spm-ac"><a href="mailto:info@banglorebazaar.org"><?= $store_rows->email ?></a></div>
                   </div>
                  </div>  
              </div>

              <div class="col-lg-12 col-xl-12">
                <div class="str-de-map15">
                  <iframe src="<?= $store_rows->map; ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div> 
              </div>

                 
 
             </div>
            </div>  
            <?php } ?>
          </div>
         </div>  
        </div>
        <!-- /Right side -->
          
      </div>    
    </div> 
        
 </main>    
 <?php include("web/assets/include/my-footer.php");?>
