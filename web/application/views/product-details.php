<?php include("web/assets/include/my-header.php");?>


  <main role="main" class="pro-details-main">
      
    <div class="container-fluid">

      <div class="row">
         <?php foreach ($result as $key => $row) { ?>
       <!-- Left side -->
        <div class="col-lg-5 col-xl-5"> 
        

<!-- Sticky section gallery -->
 <div class="fixedsticky">
  <div>
      
      
   <div class="prd-left-main">
       
       <div class="row">
       <div class="col-lg-2 col-xl-2">
          
            <ul class="recent_list">
              <?php foreach ($row['image_name'] as $key => $images) { ?>
                <li class="photo_container">
                    <a href="<?= CUSTOM_BASE_URL . 'admin/uploads/product_multimage/'.$images['image']; ?>" rel="gallerySwitchOnMouseOver: true, popupWin:'<?= CUSTOM_BASE_URL . 'admin/uploads/product_multimage/'.$images['image']; ?>', useZoom: 'cloudZoom', smallImage: '<?= CUSTOM_BASE_URL . 'admin/uploads/product_multimage/'.$images['image']; ?>'" class="cloud-zoom-gallery">
                        <img itemprop="image" src="<?= CUSTOM_BASE_URL . 'admin/uploads/product_multimage/'.$images['image']; ?>" class="img-responsive">
                    </a>
                </li>
                <?php } ?>            
            </ul> 
      </div>
           
      <div class="col-lg-8 col-xl-8">     
             <div class="gallery-sample">
            <a href="<?= CUSTOM_BASE_URL . 'admin/uploads/product_multimage/'.$row['image_name'][0]['image']; ?>" class="cloud-zoom" id="cloudZoom">
                <img src="<?= CUSTOM_BASE_URL . 'admin/uploads/product_multimage/'.$row['image_name'][0]['image']; ?>" class="img-responsive">
            </a>
           </div>      
      </div>
      <div class="col-lg-12 col-xl-12">    
          <div class="prd-control-out">
            <button value="<?= $row['id']; ?>" id="addtocart" class="prd-control-add" type="button">Add to cart</button>
            <button onclick="" class="prd-control-buy" type="button">buy now</button>
          </div>
      </div>       
           
           
    </div>
   </div>
  </div>
</div>

        <!-- /Sticky section gallery -->
   
       </div>
      <!-- /Left side -->       
 
      <!-- right side -->
        <div class="col-lg-7 col-xl-7">
          <div class="prd-right-main clearfix">
            <div class="row">
             <div class="col-sm-9 col-md-9 col-sm-9 col-lg-9 col-xl-9">
               <h1 class="prd-rt-head"><?= $row['stock_name']; ?></h1>      
             </div>
             <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                 
          
                 
                 
               <div class="prd-li-co-out">
                <div class="prd-size-radio">   
                 <input <?php if($wish_list=="1") { echo "checked"; }  ?> type="checkbox" name="ss" id="<?= $row['id']; ?>" class="check common_selector pop" value="1">
                 <label for="<?= $row['id']; ?>"><i class="glyph-icon flaticon-heart-shape-silhouette"></i></label>
                </div>
              
               </div>
               <div id="sucess" class="alert-su"></div>
             </div>
            </div>
             <div class="row">
             <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 amt-deta12">
              <div class="prd-pri-out">
                  <div class="prd-p">QR:  <span><?= $row['list_price']; ?></span></div>
              </div>
              <div class="prd-pri-out">
              <div class="prd-p-rgt">

              <?php if($row['discount']!=0) { ?>
                 <div class="prd-p-n">QR:  <span><?= $row['price']; ?></span></div>
                 <div class="prd-p-off">
                <span class="status"><?= $row['discount'].'% Off';?></span>
              </div>
              <?php } ?>

            </div>
              </div>   
             </div>

             </div>
            <div class="row prd-p-c-out">

              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <?php foreach ($row['option_name'] as $key => $options) { ?>
               <div class="prd-select">
                <h2><?= $options['name']; ?></h2>
                <?php foreach ($options['option_varriant'] as $key => $opt_varriants) { 

                  if($opt_varriants['status']==1)
                  {
                    $checked= "checked";
                  }
                  else{

                    $checked= "";

                  }

                  ?>
                <div class="prd-size-out">

              <?php if(!empty($opt_varriants['color_name'])){ ?>

                   <a href="<?= CUSTOM_BASE_URL . 'product-details/'.$opt_varriants['stock_id']; ?>">
                  <div class="prd-size-radio">
                    <input type="radio" name="test" id="<?= $opt_varriants['opt_var_id']; ?>" <?= $checked ?>>   
                    <label for="<?= $opt_varriants['opt_var_id']; ?>" style="background-color:<?= $opt_varriants['type_name']; ?>;"><?= $opt_varriants['color_name']; ?></label>
                  </div> </a>

              <?php } else{  ?>

                    <a href="<?= CUSTOM_BASE_URL . 'product-details/'.$opt_varriants['stock_id']; ?>">

                    <div class="prd-size-radio">
                    <input type="radio" name="test" id="<?= $opt_varriants['opt_var_id']; ?>" <?= $checked ?>>  
                    <label for="<?= $opt_varriants['opt_var_id']; ?>"><?= $opt_varriants['type_name']; ?></label>
                    </div> </a> 

              <?php } ?>

                </div>
                <?php } ?>
               </div> 
             <?php } ?>  
             </div>

            </div>
            <div class="row mar-top40">
            
             <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="prd-details-out">
                 <h3 class="font-w400">Highlights :</h3>
                   <div class="prd-de-co">
                    <ul>
                     <?php foreach ($row['highlights'] as $key => $highlight) { ?>

                     <li><?= $highlight['highlights']; ?></li>

                    <?php } ?>
                    </ul> 
                   </div>
                </div>
             </div>
           
            </div>
            <div class="row mar-top40">
             <div class="col-lg-12 col-xl-12">
                <div class="prd-details-out-b">
                 <h3 class="font-w400">Description :</h3>
                   <div class="prd-de-co-b">
                       <p><?= $row['description']; ?></p>
                    </div>
                </div>
             </div>
            </div>
             <div class="prd-tab-out clearfix">
               <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#specification" role="tab">Specification</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#product-description" role="tab">Product Description</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#more-details" role="tab">More Details</a>
                  </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="specification" role="tabpanel">
                    <div class="prd-tab-content">
                        
                      <div class="prd-tab-con-in">
                         <?php foreach ($row['feature_name'] as $key => $features) { ?>
                        <h3 class="prd-tab-de-h font-w600"><?= $features['group_name'];?></h3>
                        <div class="prd-tab-con-a">
                          <h3><?= $features['name'];?></h3>
                           <?php foreach ($features['feature_varriant'] as $key => $varriants) { ?>
                          <h4><?= $varriants['variants_name'];?></h4>
                          <?php } ?>
                        </div>
                        <?php } ?>
                      </div>
                      
                        
                    </div>
                  </div>
                  <div class="tab-pane" id="product-description" role="tabpanel">
                    <div class="prd-tab-content">
                   <?= $row['description']; ?>
                    </div> 
                  </div>
                  <div class="tab-pane" id="more-details" role="tabpanel">
                     <div class="prd-tab-content">
                     <?= $row['description']; ?>
                    </div>                    
                    
                  </div>
                </div> 
            </div>
            
            <?php if(!empty($rating_avg)) { ?>
              
            <div class="prd-rating-out clearfix">
              <h2 class="prd-rating-txt font-w400">Ratings and Reviews</h2>
              
                <div class="prd-rating-in">
                <div class="prd-rating-in-a">
                  <div class="prd-rating-in-a-b">
                     <div class="prd-rating-in-a-c">
                       <a><?php if(isset($rating_avg)){
                        echo $rating_avg;
                       } ?><label for="radio5">&#9733;</label></a><br>
                     </div>
                   <?php if(isset($rating)){
                        echo $rating.' '.'Ratings';
                        echo ' & ';
                        echo $rating.' '.'Reviews';
                       } ?>
                 </div>
                </div>

                <div class="prd-rating-in-b">
                    <div class="prd-progrees-rate-out">
                     <div class="prd-progrees-rate"><i class="glyph-icon flaticon-star"></i> <span>5</span></div>
                     <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                     <div class="prd-at-rate"><?php if(isset($ratingeach1)){
                        echo $ratingeach5;
                       } ?></div>
                    </div>
                    <div class="prd-progrees-rate-out">
                     <div class="prd-progrees-rate"><i class="glyph-icon flaticon-star"></i> <span>4</span></div>
                     <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                     <div class="prd-at-rate"><?php if(isset($ratingeach1)){
                        echo $ratingeach4;
                       } ?></div>
                    </div>
                    <div class="prd-progrees-rate-out">
                     <div class="prd-progrees-rate"><i class="glyph-icon flaticon-star"></i> <span>3</span></div>
                     <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="30"></div>
                     </div>
                     <div class="prd-at-rate"><?php if(isset($ratingeach1)){
                        echo $ratingeach3;
                       } ?></div>
                    </div>
                    <div class="prd-progrees-rate-out">
                     <div class="prd-progrees-rate"><i class="glyph-icon flaticon-star"></i> <span>2</span></div>
                     <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                     <div class="prd-at-rate"><?php if(isset($ratingeach1)){
                        echo $ratingeach2;
                       } ?></div>
                    </div>
                    <div class="prd-progrees-rate-out">
                     <div class="prd-progrees-rate"><i class="glyph-icon flaticon-star"></i> <span>1</span></div>
                     <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: 10%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                     <div class="prd-at-rate"><?php if(isset($ratingeach1)){
                        echo $ratingeach1;
                       } ?></div>
                    </div>
                </div>
              </div>
            </div>
            <?php } ?>
             
        </div>
      </div>
     <!-- /right side -->          
    <?php } ?>    
        
    </div> 
     <hr> 
<div class="container-fluid">
 <div class="row"> 
  <div class="col-lg-12 col-xl-12">
   <div class="pro-flt-main">        
        <div class="row justify-content-center mb-3 pb-3">
          <div class="col-md-12 heading-section text-center ftco-animate">
            <span class="subheading">Products</span>
            <h2 class="mb-4">Related Products</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
          </div>
        </div>      
     <div class="h-spm-out-a">
       <div class="row">
        <div class="col-lg-12 col-xl-12 ftco-animate">
          <div class="h-spm-slider">
           <div class="owl-carousel owl-carousel-flt-a owl-theme">
            
          <?php foreach ($similar_item as $key => $similar_rows) { 
          $mackratt = base64_encode($similar_rows['id'] .SALT_KEY.CKRAT_KEY);?>

            <div class="product">
              <a href="<?= CUSTOM_BASE_URL . 'product-details/'.$mackratt; ?>" class="img-prod"><img class="img-fluid" src="<?= CUSTOM_BASE_URL . 'admin/uploads/product_multimage/'.$similar_rows['image_name']; ?>" alt="Colorlib Template">
                <?php if($similar_rows['discount']!=0) { ?>

                <span class="status"><?= $similar_rows['discount'].'% Off';?></span>

                <?php } ?>
                
                <div class="overlay"></div>
              </a>
              <div class="text py-3 pb-4 px-3 text-center">
                <h3><a href="#"><?= mb_strimwidth($similar_rows['stock_name'], 0, 17, ".."); ?></a></h3>
                <div class="d-flex">
                  <div class="pricing">
                    <p class="price"><span class="mr-2 price-dc">QR: <?= $similar_rows['price']; ?></span><span class="price-sale">QR: <?= $similar_rows['list_price']; ?></span></p>
                  </div>
                </div>
                <div class="bottom-area d-flex px-3">
                  <div class="m-auto d-flex">
                    <a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                      <span><i class="ion-ios-menu"></i></span>
                    </a>
                    <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
                      <span><i class="ion-ios-cart"></i></span>
                    </a>
                    <a href="#" class="heart d-flex justify-content-center align-items-center ">
                      <span><i class="ion-ios-heart"></i></span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
          </div>
          <!-- <a class="button secondary playb">Play</a> 
          <a class="button secondary stopb">Stop</a> --> 
          </div> 
        </div>   
       </div>  
     </div>   
     </div>
    <!-- /product slider 1 --> 
      </div>
  </div>
   
 </main> 
 
   <script type="text/javascript">

  $(".check").change(function() {

      if($(this).prop('checked') === true){

          status=1;

      }else{

          status=0;
      }

          var rowid =$(this).attr('id');

          $.ajax({
                type: 'post',
                url: '<?= CUSTOM_BASE_URL . 'Account/addtowishlist' ?>', //Here you will fetch records 
                  data: 'rowid=' + rowid + '&status=' + status, //Pass $id
                success: function (data) {

                  if(data==1) {

                    $('#sucess').html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Moved to wishlist</div>");
                    $('#sucess').fadeOut(10*300);

                  }
                  else if(data==0) {

                    $('#sucess').html("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>remove from wishlist</div>");
                    $('#sucess').fadeOut(10*300);

                  }
                  else{

                     $('#sucess').html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>You need to login first</div>");

                  }
                  
                  var msgE = $("#sucess");

                        setTimeout(function() {
                            msgE.fadeOut("slow", function () {
                            msgE.empty().show();
                            });
                        }, 2500);



                }
          });

  });

</script>
 
 
 <?php include("web/assets/include/my-footer.php");?>
<script type="text/javascript">
  $("#addtocart").click(function () {//jquery cancel function when cancel button click
  
  var id = $(this).val();
  
  window.location = '<?= CUSTOM_BASE_URL . "add-to-cart/" ?>'+id;

});
</script>

<script type="text/javascript">
  $("#buynow").click(function () {//jquery cancel function when cancel button click
  
  var id = $(this).val();
  
  window.location = '<?= CUSTOM_BASE_URL . "buy-now/" ?>'+id;

});
</script>