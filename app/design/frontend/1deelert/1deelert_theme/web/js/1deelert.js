define([
        "jquery",
        'slick'
    ], function ($) {
        "use strict";
       $(".social-chat").on('click', function () {
            $(this).toggleClass('social-active');
            $(this).next().toggleClass('active');
        });

        $(document).on('click', function (e) {
            $("html").removeClass("nav-before-open");
            if (e.target == $('.porto-icon-user-2')[0]) {
                $('.my-account.account-icon').toggleClass('account-active');
                $('.panel.header.show-icon-tablet').toggleClass('active');
            } else {
                $('.my-account.account-icon').removeClass('account-active');
                $('.panel.header.show-icon-tablet').removeClass('active');
            }
        });
        $('#switcher-language-trigger').on('click',function(e) {
            $('.my-account.account-icon').removeClass('account-active');
            $('.panel.header.show-icon-tablet').removeClass('active');
        });
        $('.action.showcart').on('click',function(e){
            $('.my-account.account-icon').removeClass('account-active');
            $('.panel.header.show-icon-tablet').removeClass('active');
         })

        $('#tabs li a:not(:first)').addClass('inactive');
        $('.container-acoount').hide();
        $('.container-acoount:first').show();
        $('.close-filter').click(function () {
            $('.sidebar-overlay').removeClass('active');
            $('html').removeClass('sidebar-opened');
        });
        $('#tabs li a').click(function () {
            var t = $(this).attr('id');
            if ($(this).hasClass('inactive')) { //this is the start of our condition 
                $('#tabs li a').addClass('inactive');
                $(this).removeClass('inactive');

                $('.container-acoount').hide();
                $('#' + t + 'C').fadeIn('slow');
            }
            if($(this).attr('id') == 'login'){
                $('.reg-breadcrums').hide();
                $('.login-breadcrums').show();
            }else{
                $('.reg-breadcrums').show();
            $('.login-breadcrums').hide();
            }
        });
       
        //Show hide passowrd 
         $("#showPasswordReg").click(function(){
            $(this).prop("checked") ?  $("#password").prop("type", "text") : $("#password").prop("type", "password");
            $(this).prop("checked") ?  $("#password-confirmation").prop("type", "text") : $("#password-confirmation").prop("type", "password");
        });
        
        var viewportWidth = $(window).width();
        
        $(document).ready(function () {
            var viewportWidth = $(window).width();
            
            if (viewportWidth > 767) {
            $('.relate-product-slick').slick({
                draggable: true,
                accessibility: false,
                slidesToShow: 6,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                swipeToSlide: true,
                infinite: true,
                speed: 900,
                responsive: [
                    {
                        breakpoint: 1470,
                        settings: {
                            slidesToShow: 5,
                        }
                        },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 4,
                        }
                        },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                            centerMode: true,
                            centerPadding: '50px',
                        }
                        },
                    {
                        breakpoint: 575,
                        settings: {
                            slidesToShow: 1,
                            centerMode: true,
                            centerPadding: '70px',
                        }
                        }
                    ]
            });
            }else{
                $('.relate-product-slick .product-item').each(function(i) {
                    if ( i < 4 ) {
                    $(this).addClass('active');
                    }
                });
                $('.show-more').on('click', function () {
                    $('.relate-product-slick .product-item').addClass('active');
                    $('.show-more').hide();
                })
            }
            $('.new-product-block .col-md-3').lenght
            $('.new-product-block .col-md-3').each(function(i) {
                if ( i < 9 ) {
                $(this).addClass('active');
                }
            });
            $('.new-product-cta .button-secondary').on('click', function () {
                $('.new-product-block .col-md-3').addClass('active');
                $('.new-product-cta .button-secondary').hide();
            });

            $(".latest-product-slider").slick({
                draggable: true,
                accessibility: false,
                slidesToShow: 6,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                swipeToSlide: true,
                infinite: true,
                speed: 900,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 5,
                        }
                        },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                        }
                        },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 3,
                            speed: 400,
                        }
                        },
                    ]
            });

            // promotion-section js
            if ($(window).width() <= 767) {
                $('.promotion-slider').slick({
                    draggable: true,
                    accessibility: false,
                    slidesToShow: 2,
                    centerMode: true,
                    centerPadding: '20px',
                    slidesToScroll: 1,
                    arrows: false,
                    dots: false,
                    swipeToSlide: true,
                    infinite: true,
                    speed: 500,
                });
            }

            // our article section js
            $(".article-slider").slick({
                draggable: true,
                accessibility: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                swipeToSlide: true,
                infinite: true,
                speed: 900,
                responsive: [
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2,
                        }
                        },
                    {
                        breakpoint: 575,
                        settings: {
                            slidesToShow: 1,
                        }
                        },
                    ]
            });

            $(window).scroll(function(){
                if ($(window).scrollTop() >= 300) {
                    $('body').addClass('fixed-header');
                    $('header.page-header').addClass('sticky-active');
                }
                else {
                    $('body').removeClass('fixed-header');
                    $('header.page-header').removeClass('sticky-active');
                }
            });
            
        });

       
        $("header.page-header.type2 .nav-sections .nav-sections-items .nav-sections-item-content ul.header.links:first-child li.authorization-link a[data-post]").parent().hide();

        if ($(window).width() < 991) {
            $('ul.slick-slider.menu-slider').hide();
            $('#category a').click(function(){
                $('ul.slick-slider.menu-slider').toggle();
                $(this).toggleClass('active-a');
            });
        }
       
});
