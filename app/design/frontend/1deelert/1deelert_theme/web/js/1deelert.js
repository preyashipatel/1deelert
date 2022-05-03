define([
        "jquery",
        'slick'
    ], function ($) {
    "use strict";
    return function customFooter(config, element) {
        $(".social-chat").on('click', function () {
            $(this).toggleClass('social-active');
            $(this).next().toggleClass('active');
        });
        $(".account-icon").on('click', function () {
            $(this).toggleClass('account-active');
            $(this).next().toggleClass('active');
        });
        $('#tabs li a:not(:first)').addClass('inactive');
        $('.container-acoount').hide();
        $('.container-acoount:first').show();

        $('#tabs li a').click(function () {
            var t = $(this).attr('id');
            if ($(this).hasClass('inactive')) { //this is the start of our condition 
                $('#tabs li a').addClass('inactive');
                $(this).removeClass('inactive');

                $('.container-acoount').hide();
                $('#' + t + 'C').fadeIn('slow');
            }
        });
        //Show hide passowrd 
         $("#showPasswordReg").click(function(){
            console.log('call');
            $(this).prop("checked") ?  $("#password").prop("type", "text") : $("#password").prop("type", "password");
            $(this).prop("checked") ?  $("#password-confirmation").prop("type", "text") : $("#password-confirmation").prop("type", "password");
        });
        
        $('.category-lists').hide();
        $(".down-arrow").click(function(){
            $('.category-lists').toggle();
            $(this).toggleClass('arrow-active');
        });

        var viewportWidth = $(window).width();
        if (viewportWidth > 767) {
            $('.menu-slider').slick({
                draggable: true,
                accessibility: false,
                variableWidth: true,
                slidesToShow: 1,
                arrows: false,
                dots: false,
                swipeToSlide: true,
                infinite: false,
                speed: 500,
            });
        }
        $('.menu-slider-custom').slick({
            draggable: true,
            accessibility: false,
            variableWidth: true,
            slidesToShow: 1,
            arrows: false,
            dots: false,
            swipeToSlide: true,
            infinite: false,
            speed: 500,
        });

        $(document).ready(function () {
            var viewportWidth = $(window).width();
            $('.flaseSale').slick({
                draggable: true,
                accessibility: false,
                slidesToShow: 6,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                swipeToSlide: true,
                infinite: true,
                speed: 500,
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
                            centerPadding: '90px',
                        }
                        }
                    ]
            });
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
                speed: 500,
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
                speed: 500,
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
                speed: 500,
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


            // sticky js
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

    }
});
