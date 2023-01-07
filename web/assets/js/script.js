/// Manage Address toggle start

$(document).ready(function(){  
  $("#hidea").click(function(){
    $("#man-add-ac").hide();
    $("#showa").show();
    $("#hidea").hide();
  });
  $("#showa").click(function(){
    $("#man-add-ac").show();
    $("#showa").hide();
    $("#hidea").show();  
  });
});

/// Manage Address toggle end