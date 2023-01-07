
 <script>
   $(document).ready(function() {

    $(document).on("click","#ftr_checkbox",function(){

    	var data = [];
            $.each($("input[name='ftr_checkbox']:checked"), function(){            
                data.push($(this).val());
            });


      alert(data)
  
       var name = $('#search').val();

       if (name == "") {
  
           $("#key_display").html("");
 
       }
  
       else {
  
           $.ajax({
  
               type: "POST",
 
               url: '<?= CUSTOM_BASE_URL;?>Main/list_item',
   
               data: {
  
                   search: name
 
               },
  
               success: function(html) {

                   $("#key_display").html(html).show();
 
               }
 
           });
 
       }
 
   });
 
});
</script>