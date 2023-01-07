<?php include("web/assets/include/my-header.php");?>

  <main role="main" class="my-profile-main">
    <div class="container-fluid">    
      <div class="row">
       <!-- Left side -->
        <div class="col-lg-3 col-xl-3">  
            
         <div class="my-profile-left">
                
          <ul class="my-name-lnk">
           <li>
            <a class="active" href="<?= CUSTOM_BASE_URL;?>contact">
             <div class="sid-ul-nam">Contact Us</div>   
             <span><img src="<?= FILES_BASE_URL;?>assets/images/left-arrow.svg"></span>   
            </a>
           </li>
           <li>
            <a href="<?= CUSTOM_BASE_URL;?>customer-care">
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
            <div class="contact_out-ab">
             <div class="row">
              <div class="col-lg-5 col-xl-5">
                  <div class="ma-con-out">
                   <h2 class="in-heda-ab">Contact Us</h2>    
                   <div class="ma-con-add-ab">
                    <i class="glyph-icon flaticon-signs-1"></i> 
                    <div class="ma-spm-ac"><b>Main Office:</b> Ainkhalid Umm Al Saneem,Doha Qatar</div>
                   </div>
                   <div class="ma-con-add-ab">
                    <i class="glyph-icon flaticon-technology"></i> 
                    <div class="ma-spm-ac"><a href="tel:+91-0000 00 00 00">(+974) 44505500</a></div>
                   </div>
                   <div class="ma-con-add-ab">
                    <i class="glyph-icon flaticon-contact"></i> 
                    <div class="ma-spm-ac"><a href="mailto:info@banglorebazaar.org">admin@ahlulkaif.com,hr@ahlulkaif.com</a></div>
                   </div>
                  </div>  
              </div>
              <div class="col-lg-7 col-xl-7">
               <div class="contact-map-ab">   
                <h3>Enquiry</h3>
                <form id="contact-form" class="contact-form" name="contact_form" method="POST">              
                 <div class="con-for12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="field-wrap12">
                                <input type="text" placeholder="Name" name="name" id="name_id">
                                <p class="error-msg" id="name"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="field-wrap12">
                                <input type="text" placeholder="Phone" name="phone" id="phone_id">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="field-wrap12">
                                <input type="text" placeholder="Email" name="email" id="email_id">
                                <p class="error-msg" id="email"></p>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="field-wrap12">
                                <textarea name="Message" placeholder="Message" name="msg" id="msg_id"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="field-wrap12">
                                <input type="hidden" id="cust_url" name="cust_url" value="<?= CUSTOM_BASE_URL;?>">
                              <button id="submit" type="button" class="round-btn transition">Send</button>
                               <div id="sucsMsg"></div>
                               <div class="clearfix"></div>
                               <div id="formERR"></div>
                               <p id="loading_img"></p>
                            </div>
                        </div>
                    </div>

                </div>
               </form>
               </div>
              </div>
              <div class="col-lg-12 col-xl-12">
                <div class="map-con12">


                 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3609.8757392773887!2d51.45890521500968!3d25.207412683891498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf3d5c732ffbdcf5c!2zMjXCsDEyJzI2LjciTiA1McKwMjcnMzkuOSJF!5e0!3m2!1sen!2sqa!4v1639897509753!5m2!1sen!2sqa" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>   
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
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

 
 <script type="text/javascript">
       
    $(document).ready(function(){

        var er = 0;

        $("#name_id").blur(function(){

            var name = $('#name_id').val();
            if (name == "") 
            {
                document.getElementById('name_id').style.border = '1px dashed red';
                er = 1;
            }
            else{
                document.getElementById('name_id').style.border = '';
            }

        });

        $("#phone_id").blur(function(){

            var phone = $('#phone_id').val();
            if (phone == "") 
            {
                document.getElementById('phone_id').style.border = '1px dashed red';
                er = 1;
            }
            else if(phone.length >=14)
            {
                document.getElementById("phone").innerHTML = "Please enter valid mobile number.";
                er = 1;
            }
            else if (phone.length <=4 ) {
                document.getElementById("phone").innerHTML = "Please enter valid mobile number.";
                er = 1;
            }
            else{
                document.getElementById('phone_id').style.border = '';
                document.getElementById("phone").innerHTML = "";
            }
        });

        $("#email_id").blur(function(){
            var email = $('#email_id').val();
            var AtPos = email.indexOf("@");
            var StopPos = email.lastIndexOf(".");

            if (email == "") 
            {
                document.getElementById('email_id').style.border = '1px dashed red';
                er = 1;
            }
            else if (email.indexOf('@') == '-1' || email.lastIndexOf('.') < 2) {
                document.getElementById("email").innerHTML = "Please fill valid email id";
                document.getElementById('email_id').style.border = '1px dashed red';
                er = 1;
            } else if (!((email.length - StopPos) > 2)) {
                document.getElementById("email").innerHTML = "Please fill valid email id";
                document.getElementById('email_id').style.border = '1px dashed red';
                er = 1;
            }
            else{
                document.getElementById("email").innerHTML = "";
                document.getElementById('email_id').style.border = '';
            }

        });
   
        $('#phone_id').keyup(function() {
            var phoneRegExp = new RegExp(/^(?=.*[0-9])[+0-9]+$/);
            var val = $(this).val();
            if ( !phoneRegExp.test( val ) ) {// Replace anything that isn't a number or a plus sign
                $(this).val( val.replace(/([^+0-9]+)/gi, '') );
            }
        });


        $("#submit").click(function(){

           var cust_url = $('#cust_url').val();//global variable 
            var er = 0;
            var name =  $('#name_id').val();
            var email = $('#email_id').val();
            var phone = $('#phone_id').val();
            var AtPos = email.indexOf("@");
            var StopPos = email.lastIndexOf(".");

            if (name == "" && email == "" && phone == "") 
            {
                
               $('#formERR').html("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Sorry ! </strong>Please fill in all the required fields</div>");

                document.getElementById('name_id').style.border = '1px solid red';
                document.getElementById('phone_id').style.border = '1px solid red';
                document.getElementById('email_id').style.border = '1px solid red';

                $('#name_id').focus();

                er = 1;

            }

            else if(name=="")
            {
                cument.getElementById('name_id').style.border = '1px solid red';
                er = 1;
            }

            else if(phone.length >=14)
            {
                document.getElementById("phone").innerHTML = "Please enter valid mobile number.";
                er = 1;
            }
            else if (phone.length <=4 ) {
                document.getElementById("phone").innerHTML = "Please enter valid mobile number.";
                er = 1;
            }

            else if (email.indexOf('@') == '-1' || email.lastIndexOf('.') < 2) {
                document.getElementById("email").innerHTML = "Please fill valid email id";
                document.getElementById('email_id').style.border = '1px solid red';
                er = 1;
            } else if (!((email.length - StopPos) > 2)) {
                document.getElementById("email").innerHTML = "Please fill valid email id";
                document.getElementById('email_id').style.border = '1px solid red';
                er = 1;
            }
           
            else{
                document.getElementById("formERR").innerHTML = "";
                document.getElementById('name_id').style.border = '';
                document.getElementById('phone_id').style.border = '';
                document.getElementById('email_id').style.border = '';
            }
            if (er == 0) 
            {
                var data = {
                    name: $("#name_id").val(),
                    email: $("#email_id").val(),
                    phone: $("#phone_id").val(),
                    message: $("#msg_id").val()
                };

                $.ajax({

                    type: "POST",
                    url: '<?= CUSTOM_BASE_URL . 'Main/email' ?>', //Here you will fetch records 
                    data: data,
                    success: function(data)
                    {
                        document.getElementById('loading_img').innerHTML = '<img src='+cust_url+'web/assets/images/loadingpro.gif />';

                        $('#loading_img').fadeOut(10*200);
                        document.getElementById("sucsMsg").innerHTML = data;

                            var msgE = $("#sucsMsg");
                            var img = $("#loading_img");

                        setTimeout(function() {
                            msgE.fadeOut("slow", function () {
                            msgE.empty().show();
                            });
                        }, 2500);

                        setTimeout(function() {
                            img.fadeOut("slow", function () {
                            img.empty().show();
                            });
                        }, 3000);

                        contact_form.reset();
                    }
                });
            }
        });
    });

</script> 
