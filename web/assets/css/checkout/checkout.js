$(document).ready(function() {
  $(document).foundation();
  $('.next-tab').click(function() {
      $('.tabs li.is-active').next().children('a').click();
    });

    $('.prev-tab').click(function() {
      $('.tabs li.is-active').prev().children('a').click();
    });
  });