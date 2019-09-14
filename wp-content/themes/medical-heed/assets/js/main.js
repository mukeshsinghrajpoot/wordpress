jQuery(document).ready(function($){
    
    /**
     * Header Search Popup
    */
    $('.main-nav-search').click(function() {
        $('.search-pop-up').toggleClass('active');
    });

    $(".side-info-button > span").click(function () {
        $('.side-info').toggleClass('info-slide-nav')
    })

    $(".closebtn").click(function () {
        $('.side-info').removeClass('info-slide-nav')
    })


    /**
     * Sub Menu
    */
    $('.nav-border-side .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-plus"></i> </span>');
    $('.nav-border-side .page_item_has_children').append('<span class="sub-toggle-children"> <i class="fa fa-plus"></i> </span>');

    $('.nav-border-side .sub-toggle').click(function() {
        $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        $(this).children('.fa-plus').first().toggleClass('fa-minus');
    });

    $('.nav-border-side .sub-toggle-children').click(function() {
        $(this).parent('.page_item_has_children').children('ul.children').first().slideToggle('1000');
        $(this).children('.fa-plus').first().toggleClass('fa-minus');
    });

    /**
     * Slicky Menu
    */
    $(".header-wrap").sticky({topSpacing: 0});

    /**
     * Banner Slider
    */
    if( $('.banner-slider').length > 0 ) {
        $('.banner-slider').flexslider({
            animation: "fade",
            animationSpeed: 500,
            animationLoop: true,
            prevText: '',
            nextText: '',
            before: function(slider) {
                $('.banner-caption').fadeOut().animate({top:'35%'},{queue:false, easing: 'swing', duration: 700});
                slider.slides.eq(slider.currentSlide).delay(500);
                slider.slides.eq(slider.animatingTo).delay(500);
            },
            after: function(slider) {
                $('.banner-caption').fadeIn().animate({top:'50%'},{queue:false, easing: 'swing', duration: 700});
            },
            useCSS: true
        });
    }


    $('.responsiveMenu > button').click(function () {
        var width = parseInt($('#side-menu').css('width'));

        if (width == 0) {
            width = width + 100;
        } else if (width != 0) {
            width = width - width
        }
        ;

        $('#side-menu').css('width', width + '%').fast;
    });


    $('.owl-testimonial').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        autoplay: false,
        autoplayHoverPause: true,
        autoplaySpeed: 600,
        responsive:true,
        responsive:{
            0:{
                items:1
            },
            480:{
                items:1
            },
            768:{
                items:1
            },
            1000:{
                items:2
            }
        }
    });


    /**
     * Sub Menu
     */
    $('.menu-item-has-children a').click(function () {
        $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle();
    });


    var accordion = (function () {

        var $accordion = $('.js-accordion');
        var $accordion_header = $accordion.find('.js-accordion-header');
        var $accordion_item = $('.js-accordion-item');

        // default settings
        var settings = {
            // animation speed
            speed: 400,

            // close all other accordion items if true
            oneOpen: false
        };

        return {
            // pass configurable object literal
            init: function ($settings) {
                $accordion_header.on('click', function () {
                    accordion.toggle($(this));
                });

                $.extend(settings, $settings);

                // ensure only one accordion is active if oneOpen is true
                if (settings.oneOpen && $('.js-accordion-item.active').length > 1) {
                    $('.js-accordion-item.active:not(:first)').removeClass('active');
                }

                // reveal the active accordion bodies
                $('.js-accordion-item.active').find('> .js-accordion-body').show();
            },
            toggle: function ($this) {

                if (settings.oneOpen && $this[0] != $this.closest('.js-accordion').find('> .js-accordion-item.active > .js-accordion-header')[0]) {
                    $this.closest('.js-accordion')
                        .find('> .js-accordion-item')
                        .removeClass('active')
                        .find('.js-accordion-body')
                        .slideUp()
                }

                // show/hide the clicked accordion item
                $this.closest('.js-accordion-item').toggleClass('active');
                $this.next().stop().slideToggle(settings.speed);
            }
        }
    })();
    accordion.init({speed: 300, oneOpen: true});
});

