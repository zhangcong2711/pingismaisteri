(function ($) {
   
   $(document).ready( function() {
   
      $(".show-registrations").css("display", "inline");
      
      $(".show-table-rows").click( function(e) {
         e.preventDefault();
         
         $( $(this).attr("data-target") ).toggle(200);
         
      });
      
      $(".hidden-row").hide();
      
      $(".btn-group input").css("display", "none");
      
      $(".btn-group input[checked='checked']").parent().addClass("active");
      
      $(".dualslider").slider();
      
      $(".slider").css({"width" : "400px"});
      
      $('.datepicker').datepicker()
      
      $(".ajax-link").click(function(e) {
      
         e.preventDefault();
         
         var url = $(this).attr("data-url");
         var target = $(this).attr("data-target");
         
         $.get( url ).done( function(data) {
            
            var json = $.base64.btoa( data );
            var content = $.parseJSON( json );
            
            $(target).append( content );
            
         });
     
      });
      
      $(".new-row-link").click(function(e) {
      
         e.preventDefault();

         var url = $(this).attr("data-url");
         var target = $(this).attr("data-target");
         var count = $(this).attr("data-count");
         
         var i = $(count).length;
         
         var url = url + "/" + i;
         
         $.get( url ).done( function(data) {
            
            var json = $.base64.atob( data );
            
            var arr = $.parseJSON( json );
            
            $(target).append( arr.content );
            
         });
     
      });
      
      $(document).on("click", ".remove-form-row-button", function(e) {
         e.preventDefault();
         
         $(this).closest("tr").remove();
      });
      
      $(".delete-row").click(function(e) {
         e.preventDefault();
         
         if ( confirm("Haluatko varmasti poistaa tämänn luokan? Kaikki tiedot menetetään.") ) 
         {
            var url = $(this).attr("data-url");
            var delete_class = $(this).attr("data-class");
            var id = $(this).attr("data-id");
            
            var url = url + "/" + delete_class + "/" + id;
            
            console.log( $(this) );
            
            $.get( url );
            
            $(this).closest("tr").remove();
         }
      });
   
   });

})(jQuery);  