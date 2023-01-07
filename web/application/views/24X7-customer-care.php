<?php include("web/assets/include/my-header.php");?>

  <main role="main" class="my-profile-main">
    <div class="container-fluid">    
      <div class="row">
       <!-- Left side -->
        <div class="col-lg-3 col-xl-3">  
            
         <div class="my-profile-left">
                
          <ul class="my-name-lnk">
           <li>
            <a href="<?= CUSTOM_BASE_URL;?>contact">
             <div class="sid-ul-nam">Contact Us</div>   
             <span><img src="<?= FILES_BASE_URL;?>assets/images/left-arrow.svg"></span>   
            </a>
           </li>
           <li>
            <a class="active" href="<?= CUSTOM_BASE_URL;?>customer-care">
             <div class="sid-ul-nam">Customer Care</div>   
             <span><img src="<?= FILES_BASE_URL;?>assets/images/left-arrow.svg"></span>   
            </a>
           </li>
          </ul>
             
         </div>

        </div>
        <!-- /Left side -->          
          
        <div class="col-lg-9 col-xl-9">
         <div class="my-profile-right clearfix">
          <div class="mange-add-ac">
           <h2 class="in-heda-ab">Customer Care</h2>
            <div class="customer_out-ab">
             <div class="row">
              <div class="col-lg-6 col-xl-6">
               <div class="ma-con-out">
                <p>Ahlul Kaif Group has a dedicated customer care department that addresses all kinds of customer issues and queries.<br>
                    Please call our 24x7 customer care centre on the following number.<br><br></p>
                <div class="custe-num-ad">Customer Care No: <a href="#">(+974)44505500</a></div>  


               </div>  
              </div>
              <div class="col-lg-6 col-xl-6">
               <div class="contact-map-ab">   
                <img src="<?= FILES_BASE_URL;?>assets/images/24x7customer.png" style="max-width:100%;">
               </div>
              </div>   
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
