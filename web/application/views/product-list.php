<?php include("web/assets/include/my-header.php");?>
  
  <main role="main" class="filter-main">
    <div class="container-fluid">    
      <div class="row">
       <!-- Left side -->
        <div class="col-lg-3 col-xl-2">

<div class="flt-left-main clearfix">
  <a href="#flt-toggle-menu" id="flt-toggle"><span></span><h1>Category Filters</h1></a>
    <div id="flt-toggle-menu">
   
          <div class="flt-out-m">   
           <h1 class="flt-cate-txt had-non-s"><b>Filters</b></h1><hr>
              
      <ul id="accordion" class="flt-accordion">
		<li class="default open">
            <div class="link"><a>Category</a><i class="glyph-icon flaticon-down-arrow fa-chevron-down"></i></div>
			<ul class="submenu">
				 <?php foreach ($category as $key => $categorys) {  
				     
				     $catmackratt = base64_encode($categorys->cat_id .SALT_KEY.CKRAT_KEY);
				 ?>
				<li><a href="<?= CUSTOM_BASE_URL. 'product-list/'.$catmackratt; ?>"><?= $categorys->cat_name;?></a></li>
         <?php } ?>
			</ul>
		</li>

  <li class="default open">
   	<div class="link"><a>Price</a><i class="glyph-icon flaticon-down-arrow fa-chevron-down"></i></div>   
    <ul class="submenu price-max14">
     <input type="hidden" id="hidden_minimum_price" value="<?= $min_price; ?>" />
     <input type="hidden" id="hidden_maximum_price" value="<?= $max_price; ?>" />
     <p id="price_show"><b>QR: </b><span class="price-s12"> <?= $min_price; ?> </span> - <span class="price-s13"> <?= $max_price; ?></span></p>
     <div id="price_range"></div>
    </ul>
  </li>
  
  	<li>
    	<div class="list-group">
        <?php foreach($feature as $features) { ?>
        <div class="link"><a><?= $features['name']; ?></a><i class="glyph-icon flaticon-down-arrow fa-chevron-down"></i></div>
			<ul class="submenu">
              <div class="">
                  <?php foreach($features['feature_var'] as $ftr_rows) { ?>
                  <div class="flt-check-out">
                      <label class="flt-con"> 
                        <input type="checkbox" class="common_selector feature" value="<?php echo $ftr_rows['f_var_id']; ?>" > 
                        <span class="checkmark"></span>
                      </label>
                      <span><?php echo $ftr_rows['variants_name']; ?></span>
                  </div>
                  <?php } ?>
                </div>
			</ul>
			</div>
			 <?php  } ?> 
		</li>
  
  
	<li class="default open">
        <?php foreach($option as $options) { ?>
        <div class="link"><a><?= $options['name']; ?></a><i class="glyph-icon flaticon-down-arrow fa-chevron-down"></i></div>
			<ul class="submenu">
              <div class="">
                  <?php foreach($options['option_var'] as $option_rows) { ?>
                  <div class="flt-check-out">
                      <label class="flt-con"> 
                        <input type="checkbox" class="common_selector option" value="<?php echo $option_rows['opt_var_id']; ?>" >
                        <span class="checkmark"></span>
                      </label>
                      <span><?php echo $option_rows['type_name']; ?></span>
                  </div>
                  <?php } ?>
                </div>
			</ul>
			 <?php  } ?> 
		</li>

		<li>
      <div class="link">Availability<i class="glyph-icon flaticon-down-arrow fa-chevron-down"></i></div>
			<ul class="submenu">
              <div class="">
                  <div class="flt-check-out">
                      <label class="flt-con"> 
                        <input type="checkbox" class="common_selector availability" value="1" >
                        <span class="checkmark"></span>
                      </label>
                      <span>Include Out of Stock</span>
                  </div>
                </div>
			</ul>
		</li>          
	</ul>  
 </div>       
</div>
  </div>
    </div>
            
        <div class="col-lg-9 col-xl-10">
          <div class="flt-right-main clearfix">
           <h2 class="fil-head-txt"><?php if(isset($cat_name)) { echo $cat_name;  } ?></h2>
              
            <!-- Nav tabs -->
          
            <div class="product-nav clearfix"> 
            
                <div class="filter-ty12">
                    <div class="prd-size-radio">
                       <input type="radio" class="common_selector pop" id="toggle-11" value="1" name="group1" checked="checked" >  
                       <label for="toggle-11">Popularity</label> 
                    </div>
                    <div class="prd-size-radio">
                       <input type="radio" class="common_selector high" id="toggle-12" value="2" name="group1" >   
                       <label for="toggle-12">Low to High</label> 
                    </div>
                    <div class="prd-size-radio">
                       <input type="radio" class="common_selector low" id="toggle-13" value="3" name="group1" >
                       <label for="toggle-13">High to Low</label> 
                    </div>
                    <div class="prd-size-radio">
                       <input type="radio" class="common_selector first" id="toggle-14" value="4" name="group1" >
                       <label for="toggle-14">Newest First</label>   
                    </div>
                </div> 
<!--            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <input type="radio" class="common_selector pop" value="1" name="group1" checked="checked" >Popularity
              </li>
              <li class="nav-item">
                <input type="radio" class="common_selector high" value="2" name="group1" >Low to High
              </li>
              <li class="nav-item">
                  <input type="radio" class="common_selector low" value="3" name="group1" >High to Low
              </li>
              <li class="nav-item">
                 <input type="radio" class="common_selector first" value="4" name="group1" >Newest First
              </li>
            </ul>-->
            <!-- /Nav tabs -->

        <!-- Tab panes -->
       
             <!--- box 1 --->
                <div class="filter_data">

                </div>
     
             <!--- /box 1 --->   
            
                  
      </div>  
    <!-- /Tab panes -->
  
     <div class="col-md-12">
      <div align="center" id="pagination_link" class="pro-pge16"></div>
     </div>
  
    
    
    </div> 
          
 </div>  
 
        </div>
       <!-- /Left side -->    
      </div>

 </main>   
 
<style>
#loading
{
 text-align:center; 
 background: url('<?php echo CUSTOM_BASE_URL.'web/assets/loader.gif';?>') no-repeat center;
 background-size:70px;
 height: 150px;
 padding-top:250px;
}
</style>

<script>
$(document).ready(function(){

    filter_data(1);

    function filter_data(page)
    {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var feature = get_filter('feature');
        var option = get_filter('option');
        var availability = get_filter('availability');
        var pop = get_filter('pop');
        var high = get_filter('high');
        var low = get_filter('low');
        var first = get_filter('first');
        var cat_id = <?php echo $cat_id ?>;
        
        $.ajax({
            url: '<?= CUSTOM_BASE_URL;?>Product_list/fetch_data/'+page,
            method:"POST",
            dataType:"JSON",
            data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, feature:feature, option:option,cat_id:cat_id,availability:availability, pop:pop, high:high, low:low, first:first},
            success:function(data)
            {
                $('.filter_data').html(data.product_list);
                $('#pagination_link').html(data.pagination_link);
                
                
            }
        })
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $(document).on('click', '.pagination li a', function(event){
        event.preventDefault();
        var page = $(this).data('ci-pagination-page');
        filter_data(page);
    });

    $('.common_selector').click(function(){
        filter_data(1);
    });

    $('#price_range').slider({
        range:true,
        min:<?= $min_price; ?>,
        max:<?= $max_price; ?>,
        values:[<?= $min_price; ?>,<?= $max_price; ?>],
        step:1,
        stop:function(event, ui)
        {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data(1);
        }

    });

});
</script>


 <?php include("web/assets/include/my-footer.php");?>