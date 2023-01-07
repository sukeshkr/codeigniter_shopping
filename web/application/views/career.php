<?php include("web/assets/include/my-header.php");?>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<section id="home-section" class="hero">
      <div class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url(<?= FILES_BASE_URL;?>assets/images/career-banner.jpg);">
          <div class="overlay"></div>
          <div class="container">
            <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

              <div class="col-md-12 ftco-animate text-center">
                <h2 class="subheading mb-4">WELCOME, AND JOIN US AT Ahlul Kaif Qatar Group</h2>
                <p><a href="#" class="btn btn-primary">APPLY</a></p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section> 

  <main role="main" class="career-main">
    <div class="container-fluid">    
     <section class="career-out">
        <h2 class="career-head">EXPLORE OPPORTUNITIES HERE</h2>
        <div class="row-career">

          <?php foreach ($career as $key => $career_list) { ?>
             
         <div class="col-career">
           <div class="career-vac-out">
            <h3>Position: <?= $career_list['position']; ?></h3>
            <h6><b>Qualification:</b> <?= $career_list['qualification']; ?></h6>
            <h6><b>Experience:</b> <?= $career_list['experience']; ?> Years</h6>
            <div class="career-loc"><b>Location:</b><i class="glyph-icon flaticon-facebook-placeholder-for-locate-places-on-maps"></i><?= $career_list['location']; ?></div>
            <div class="career-btm">
             <div class="career-nos"><?= $career_list['vaccancy']; ?> nos</div>
             <div class="career-apy"><button type="button" class="hda-ma" data-toggle="modal" data-target="#apply-job">Apply</button></div>
            </div>
           </div>
         </div> 

       <?php } ?>
            
        </div>
     </section>
        
    <section class="career-outb">
      <h2>WELCOME, AND JOIN US AT <span>Ahlul Kaif Qatar Group</span></h2> 
       <div class="career-outb-team">
        <img src="<?= FILES_BASE_URL;?>assets/images/career-team.jpg" alt="ahlulkaif"> 
       </div>
    </section>
    </div> 
        
 </main>


 <!-- Apply job model-->
<div class="modal fade career-model" id="apply-job" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-head" id="exampleModalLabel">Join our team</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="glyph-icon flaticon-cancel"></span>
        </button>
      </div>
      <div class="modal-body">

      <form id="contact-form" class="contact-form" name="career" method="POST" action="<?= CUSTOM_BASE_URL . 'career-post' ?>" enctype="multipart/form-data">              

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Full name:</label>
            <input required type="text" class="form-control" name="name">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Phone number:</label>
            <input required type="number" class="form-control" name="phone">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">What position are you applying for?</label>
              <select required class="form-control" name="position">
                <option value="">-Select-</option>
                <option value="Manager">Manager</option>
                <option value="Superwiser">Superwiser</option>
                <option value="Account">Account</option>
                <option value="Cashier">Cashier</option>
                <option value="Office Staff">Office Staff</option>
                <option value="IT Department">IT Department</option>
                <option value="Driver">Driver</option>
                <option value="Cook">Cook</option>
                <option value="Sales Man">Sales man</option>
                <option value="Cleaning">Cleaning</option>
                <option value="Others">Others</option>
              </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea name="message" class="form-control" id="message-text"></textarea>
          </div>
          <div class="form-group career-upload">
            <label for="recipient-name" class="col-form-label">Upload CV</label>
            <input required type="file" name="image_file" accept="image/*" class="form-control">
          </div>
      </div>
      <div class="modal-footer">
      <button id="submit" type="submit" class="round-btn transition">Apply</button>
      </div>
      </form>
    </div>
  </div>
</div>


  <!-- ADD MODAL BODY -->
  <div class="modal fade sucs-modal" id="add_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                  <h4 class="modal-title" >Successfully !</h4>
                  <p>We will contact you soon</p>
                  <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
              </div>
          </div>
      </div>
  </div>

<!-- Apply job model--> 
<?php include("web/assets/include/my-footer.php");?>

<script type="text/javascript">
  <?php if ($this->session->flashdata('add')) { ?>
    $("#add_confirm").modal('show');<?php } ?>
</script>