$(document).ready(function() {
  $("#tablesearch").hide();
  // Search
  $("input#name").keyup(function(){
    var query_value = $('input#name').val();
    if(query_value !== ''){
      $.ajax({
        type: "POST",
        url: "searching_arrival_booking.php",
        data: { query: query_value },
        cache: false,
        success: function(html){
          //alert(html);
          //$("div#tablesearch_top").hide();
          $("table#resultTable tbody").html(html);
        }
      });
    }return false;
  });

  $("input#name").on("keyup", function(e) {
   
    var search_string = $(this).val();
    // Do Search
    if (search_string == '') {
      $("#tablesearch_top").show();
      $("#tablesearch").hide();
    }else{
      $("#tablesearch_top").hide();
      $("#tablesearch").show();
      //$(this).data('timer', setTimeout(search, 100));
    };
  });

});
