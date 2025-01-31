;(function($) {
    'use strict';
    $(window).on( 'elementor/frontend/init', function() {


        var GlobalJSLoad = function() {

            if ($("[data-bg-src]").length > 0) {
                $("[data-bg-src]").each(function () {
                    var src = $(this).attr("data-bg-src");
                    $(this).css("background-image", "url(" + src + ")");
                    $(this).removeAttr("data-bg-src").addClass("background-image");
                });
            }
              
            if ($('[data-mask-src]').length > 0) {
              $('[data-mask-src]').each(function () {
                  var mask = $(this).attr('data-mask-src');
                  $(this).css({
                      'mask-image': 'url(' + mask + ')',
                      '-webkit-mask-image': 'url(' + mask + ')'
                  });
                  $(this).addClass('bg-mask');
                  $(this).removeAttr('data-mask-src');
              });
          };            

            $.fn.shapeMockup = function () {
                var $shape = $(this);
                $shape.each(function() {
                  var $currentShape = $(this),
                  shapeTop = $currentShape.data('top'),
                  shapeRight = $currentShape.data('right'),
                  shapeBottom = $currentShape.data('bottom'),
                  shapeLeft = $currentShape.data('left');
                  $currentShape.css({
                    top: shapeTop,
                    right: shapeRight,
                    bottom: shapeBottom,
                    left: shapeLeft,
                  }).removeAttr('data-top')
                  .removeAttr('data-right')
                  .removeAttr('data-bottom')
                  .removeAttr('data-left')
                  // .closest('.elementor-widget').css('position', 'static')
                  .closest('.elementor-widget , .elementor-widget-wrap, .elementor-widget-container' ).css('position', 'static')
                  .closest('section').addClass('shape-mockup-wrap');
                });
            };
        
            if ($('.shape-mockup')) {
                $('.shape-mockup').shapeMockup(); 
            }

                // skill 
            $(function () {

                $('.progress-bar').each(function () {
                    $(this).find('.progress-content').animate({
                        width: $(this).attr('data-percentage')
                    }, 2000);

                    $(this).find('.progress-number-mark').animate({
                        left: $(this).attr('data-percentage')
                    }, {
                        duration: 2000,
                        step: function (now, fx) {
                            var data = Math.round(now);
                            $(this).find('.percent').html(data + '%');
                        }
                    });
                });
            });

             /*---------- Circle Progress ----------*/  
            $(document).ready(function () {
                function animateElements() {
                    $('.progressbar').each(function () {
                        var elementPos = $(this).offset().top;
                        var topOfWindow = $(window).scrollTop();
                        var percent = $(this).find('.circle').attr('data-percent');
                        var percentage = parseInt(percent, 10) / parseInt(100, 10);
                        var animate = $(this).data('animate');
                        if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                            $(this).data('animate', true);
                            $(this).find('.circle').circleProgress({
                            startAngle: -Math.PI / 2,
                            value: percent / 100,
                            size: 130,  
                            thickness: 4,
                            emptyFill: "#ECF1F5", 
                            fill: {
                                color: '#0181F5' 
                            }
                            }).on('circle-animation-progress', function (event, progress, stepValue) {
                            $(this).find('.circle-num').text((stepValue*100).toFixed(0) + "%");
                            }).stop();
                        }
                    });
                }
            
                // Show animated elements
                animateElements();
                $(window).scroll(animateElements);
            });


          $(".filter-active").imagesLoaded(function () {
            var $filter = ".filter-active", $filterItem = ".filter-item", $filterMenu = ".filter-menu-active";
    
            if ($($filter).length > 0) {
                var $grid = $($filter).isotope({
                    itemSelector: $filterItem,
                    filter: "*",
                    masonry: {
                        // use outer width of grid-sizer for columnWidth
                        columnWidth: 1,
                    },
                });
    
                // filter items on button click
                $($filterMenu).on("click", "button", function () {
                    var filterValue = $(this).attr("data-filter");
                    $grid.isotope({
                        filter: filterValue,
                    });
                });
    
                // Menu Active Class
                $($filterMenu).on("click", "button", function (event) {
                    event.preventDefault();
                    $(this).addClass("active");
                    $(this).siblings(".active").removeClass("active");
                });
            }
        });
    
          $(".masonary-active").imagesLoaded(function () {
              var $filter = ".masonary-active", $filterItem = ".filter-item";
      
              if ($($filter).length > 0) {
                  $($filter).isotope({
                      itemSelector: $filterItem,
                      filter: "*",
                      masonry: {
                          // use outer width of grid-sizer for columnWidth
                          columnWidth: 1,
                      },
                  });
              }
          });


          if ($(".odometer").length) {
                $(".odometer").appear();
                $(document.body).on("appear", ".odometer", function (e) {
                    var odo = $(".odometer");
                    odo.each(function () {
                        var countNumber = $(this).attr("data-count");
                        $(this).html(countNumber);
                    });
                    window.odometerOptions = {
                        format: "d",
                    };
                });
          }

			
        };

        elementorFrontend.hooks.addAction('frontend/element_ready/global', GlobalJSLoad);
        
        var GlobalSlider = function() {

            $(".th-carousel").each(function () {
                var thSlide = $(this);
        
                // Collect Data
                function d(data) {
                    return thSlide.data(data);
                }
        
                // Custom Arrow Button
                var prevButton = '<button type="button" class="slick-prev"><i class="' +
                    d("prev-arrow") +
                    '"></i></button>', nextButton = '<button type="button" class="slick-next"><i class="' +
                        d("next-arrow") +
                        '"></i></button>';
        
                // Function For Custom Arrow Btn
                $("[data-slick-next]").each(function () {
                    $(this).on("click", function (e) {
                        e.preventDefault();
                        $($(this).data("slick-next")).slick("slickNext");
                    });
                });
        
                $("[data-slick-prev]").each(function () {
                    $(this).on("click", function (e) {
                        e.preventDefault();
                        $($(this).data("slick-prev")).slick("slickPrev");
                    });
                });
        
                // Check for arrow wrapper
                if (d("arrows") == true) {
                    if (!thSlide.closest(".arrow-wrap").length) {
                        thSlide.closest(".container").parent().addClass("arrow-wrap");  
                    }
                }
        
                thSlide.not('.slick-initialized').slick({
                    dots: d("dots") ? true : false,
                    fade: d("fade") ? true : false,
                    arrows: d("arrows") ? true : false,
                    speed: d("speed") ? d("speed") : 1000,
                    asNavFor: d("asnavfor") ? d("asnavfor") : false,
                    autoplay: d("autoplay") == false ? false : true,
                    infinite: d("infinite") == false ? false : true,
                    slidesToShow: d("slide-show") ? d("slide-show") : 1,
                    adaptiveHeight: d("adaptive-height") ? true : false,
                    centerMode: d("center-mode") ? true : false,
                    autoplaySpeed: d("autoplay-speed") ? d("autoplay-speed") : 8000,
                    centerPadding: d("center-padding") ? d("center-padding") : "0",
                    focusOnSelect: d("focuson-select") == false ? false : true,
                    pauseOnFocus: d("pauseon-focus") ? true : false,
                    pauseOnHover: d("pauseon-hover") ? true : false,
                    variableWidth: d("variable-width") ? true : false,
                    vertical: d("vertical") ? true : false,
                    verticalSwiping: d("vertical") ? true : false,
                    prevArrow: d("prev-arrow") ?
                        prevButton : '<button type="button" class="slick-prev"><i class="far fa-arrow-left"></i></button>',
                    nextArrow: d("next-arrow") ?
                        nextButton : '<button type="button" class="slick-next"><i class="far fa-arrow-right"></i></button>',
                    rtl: $("html").attr("dir") == "rtl" ? true : false,
                    responsive: [{
                        breakpoint: 1600,
                        settings: {
                            arrows: d("xl-arrows") ? true : false,
                            dots: d("xl-dots") ? true : false,
                            slidesToShow: d("xl-slide-show") ?
                                d("xl-slide-show") : d("slide-show"),
                            centerMode: d("xl-center-mode") ? true : false,
                            centerPadding: "0",
                        },
                    },
                    {
                        breakpoint: 1400,
                        settings: {
                            arrows: d("ml-arrows") ? true : false,
                            dots: d("ml-dots") ? true : false,
                            slidesToShow: d("ml-slide-show") ?
                                d("ml-slide-show") : d("slide-show"),
                            centerMode: d("ml-center-mode") ? true : false,
                            centerPadding: 0,
                        },
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            arrows: d("lg-arrows") ? true : false,
                            dots: d("lg-dots") ? true : false,
                            slidesToShow: d("lg-slide-show") ?
                                d("lg-slide-show") : d("slide-show"),
                            centerMode: d("lg-center-mode") ?
                                d("lg-center-mode") : false,
                            centerPadding: 0,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            arrows: d("md-arrows") ? true : false,
                            dots: d("md-dots") ? true : false,
                            slidesToShow: d("md-slide-show") ?
                                d("md-slide-show") : 1,
                            centerMode: d("md-center-mode") ?
                                d("md-center-mode") : false,
                            centerPadding: 0,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: d("sm-arrows") ? true : false,
                            dots: d("sm-dots") ? true : false,
                            slidesToShow: d("sm-slide-show") ?
                                d("sm-slide-show") : 1,
                            centerMode: d("sm-center-mode") ?
                                d("sm-center-mode") : false,
                            centerPadding: 0,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            arrows: d("xs-arrows") ? true : false,
                            dots: d("xs-dots") ? true : false,
                            slidesToShow: d("xs-slide-show") ?
                                d("xs-slide-show") : 1,
                            centerMode: d("xs-center-mode") ?
                                d("xs-center-mode") : false,
                            centerPadding: 0,
                        },
                    },
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ],
                });
            });

            var thSlider = $(this);
        var settings = $(this).data('slider-options');

        // Store references to the navigation Slider
        var prevArrow = thSlider.find('.slider-prev');
        var nextArrow = thSlider.find('.slider-next');
        var paginationEl = thSlider.find('.slider-pagination');
        var paginationElN = thSlider.find('.slider-pagination.pagi-number');

        var paginationType = settings['paginationType'] ? settings['paginationType'] : 'bullets';

        var autoplayconditon = settings['autoplay'];

        var sliderDefault = {
            slidesPerView: 1,
            spaceBetween: settings['spaceBetween'] ? settings['spaceBetween'] : 24,
            loop: settings['loop'] == false ? false : true,
            speed: settings['speed'] ? settings['speed'] : 1000,
            autoplay: autoplayconditon ? autoplayconditon : {delay: 6000, disableOnInteraction: false},
            navigation: {
                nextEl: nextArrow.get(0),
                prevEl: prevArrow.get(0),  
            },
            pagination: {
                el: paginationEl.get(0),
                type: paginationType,
                clickable: true, 
                renderBullet: function (index, className) {
                    var number = index + 1;
                    var formattedNumber = number < 10 ? '0' + number : number;
                    if (paginationElN.length) {
                        return '<span class="' + className + ' number">' + formattedNumber + '</span>';
                    } else {
                        return '<span class="' + className + '" aria-label="Go to Slide ' + formattedNumber + '"></span>';
                    }
                },
            },
            on: {
                slideChange: function() {
                    setTimeout(function () {
                        swiper.params.mousewheel.releaseOnEdges = false;
                    }, 500);
                },
                reachEnd: function() {
                    setTimeout(function () {
                        swiper.params.mousewheel.releaseOnEdges = true;
                    }, 750);
                }
            }
        };

        var options = JSON.parse(thSlider.attr('data-slider-options'));
        options = $.extend({}, sliderDefault, options);
        var swiper = new Swiper(thSlider.get(0), options); // Assign the swiper variable

        if ($('.slider-area').length > 0) {
            $('.slider-area').closest(".container").parent().addClass("arrow-wrap");
        }


        
        
            /*----------- 08. Custom Animaiton For Slider ----------*/
            $('[data-ani-duration]').each(function () {
                var durationTime = $(this).data('ani-duration');
                $(this).css('animation-duration', durationTime);
            });
        
            $('[data-ani-delay]').each(function () {
                var delayTime = $(this).data('ani-delay');
                $(this).css('animation-delay', delayTime);
            });
        
            $('[data-ani]').each(function () {
                var animaionName = $(this).data('ani');
                $(this).addClass(animaionName);
                $('.slick-current [data-ani]').addClass('th-animated');
            });
        
            $('.th-carousel').on('afterChange', function (event, slick, currentSlide, nextSlide) {
                $(slick.$slides).find('[data-ani]').removeClass('th-animated');
                $(slick.$slides[currentSlide]).find('[data-ani]').addClass('th-animated');
            });
      


            /*---------- 17. AS Tab ----------*/
            $.fn.thTab = function (options) {
                var opt = $.extend(
                    {
                        sliderTab: false,
                        tabButton: "button",
                    },
                    options
                );
        
                $(this).each(function () {
                    var $menu = $(this);
                    var $button = $menu.find(opt.tabButton);
        
                    // Append indicator
                    $menu.append('<span class="indicator"></span>');
                    var $line = $menu.find(".indicator");
        
                    // On Click Button Class Remove and indecator postion set
                    $button.on("click", function (e) {
                        e.preventDefault();
                        var cBtn = $(this);
                        cBtn.addClass("active").siblings().removeClass("active");
                        if (opt.sliderTab) {
                            $(slider).slick("slickGoTo", cBtn.data("slide-go-to"));
                        } else {
                            linePos();
                        }
                    });
        
                    // Work With slider
                    if (opt.sliderTab) {
                        var slider = $menu.data("asnavfor"); // select slider
        
        
                        // Select All button and set attribute
                        var i = 0;
                        $button.each(function () {
                            var slideBtn = $(this);
                            slideBtn.attr("data-slide-go-to", i);
                            i++;
        
                            // Active Slide On load > Actived Button
                            if (slideBtn.hasClass("active")) {
                                $(slider).slick(
                                    "slickGoTo",
                                    slideBtn.data("slide-go-to")
                                );
                            }
        
                            // Change Indicator On slide Change
                            $(slider).on(
                                "beforeChange",
                                function (event, slick, currentSlide, nextSlide) {
                                    $menu
                                        .find(
                                            opt.tabButton +
                                            '[data-slide-go-to="' +
                                            nextSlide +
                                            '"]'
                                        )
                                        .addClass("active")
                                        .siblings()
                                        .removeClass("active");
                                    linePos();
                                }
                            );
                        });
                    }
        
                    // Indicator Position
                    function linePos() {
                        var $btnActive = $menu.find(opt.tabButton + ".active"), $height = $btnActive.css("height"), $width = $btnActive.css("width"), $top = $btnActive.position().top + "px", $left = $btnActive.position().left + "px";
        
                        $line.get(0).style.setProperty("--height-set", $height);
                        $line.get(0).style.setProperty("--width-set", $width);
                        $line.get(0).style.setProperty("--pos-y", $top);
                        $line.get(0).style.setProperty("--pos-x", $left);
        
                        if ($($button).first().position().left ==
                            $btnActive.position().left) {
                            $line
                                .addClass("start")
                                .removeClass("center")
                                .removeClass("end");
                        } else if ($($button).last().position().left ==
                            $btnActive.position().left) {
                            $line
                                .addClass("end")
                                .removeClass("center")
                                .removeClass("start");
                        } else {
                            $line
                                .addClass("center")
                                .removeClass("start")
                                .removeClass("end");
                        }
                    }
                    linePos();
                });
            };
    
            if ($('.testi-card-tab').length) {
                $('.testi-card-tab').thTab({
                    sliderTab: true,
                    tabButton: '.tab-btn'
                });
            }

        
        };

        elementorFrontend.hooks.addAction('frontend/element_ready/global', GlobalSlider);


    });
}(jQuery));
