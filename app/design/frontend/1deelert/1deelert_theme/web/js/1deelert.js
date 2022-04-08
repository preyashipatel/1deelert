define([
        "jquery"
    ], function($){
        "use strict";
       return function customFooter(config, element) {
         $(".social-chat").on('click',function(){
            // $('.footer-social-icon').toggleClass("show");
            // $('.close-icon').toggleClass("show");
            $(this).toggleClass('social-active');
            $(this).next().toggleClass('active');
         });

            $('#tabs li a:not(:first)').addClass('inactive');
            $('.container-acoount').hide();
            $('.container-acoount:first').show();
                
            $('#tabs li a').click(function(){
                var t = $(this).attr('id');
                console.log(t);
              if($(this).hasClass('inactive')){ //this is the start of our condition 
                $('#tabs li a').addClass('inactive');           
                $(this).removeClass('inactive');
                
                $('.container-acoount').hide();
                $('#'+ t + 'C').fadeIn('slow');
             }
            });
        
       }

       return function headerTab(config, element) {
        console.log('call');
        
       }
});