define([
        "jquery",
        'owl.carousel/owl.carousel.min'
    ], function($){
        "use strict";
       return function customFooter(config, element) {
         $(".social-chat").on('click',function(){
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

            $('.menu-slider').owlCarousel({
                margin: 45,
                autoWidth: true,
                responsiveClass: true,
                loop: false,
                nav: false,
                dots: false,
                autoplay: false,
                autoplayTimeout: 3000,
                smartSpeed: 1000,
                responsive:{
                    0:{
                      margin: 20,
                    },
                    768:{
                      margin: 30,
                    },
                    1500:{
                      margin: 45,
                    }
                }
           });

       }
});