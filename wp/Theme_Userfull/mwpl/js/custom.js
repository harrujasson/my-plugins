    jQuery(document).ready(function ($) {
        $('#serviceSlider').owlCarousel({
            items: 4,
            animateOut: 'fadeOut',
            loop: true,
            margin: 30,
            autoplay: true,
            dots: false,
            responsive: {
                0: {
                    items: 1,
                },
                // breakpoint from 480 up
                480: {
                    items: 2,
                },
                // breakpoint from 768 up
                768: {
                    items: 3,
                }, // breakpoint from 768 up
                991: {
                    items: 4,
                }
            }
        }); /* serviceSlider slider */

        $('#workSlider').owlCarousel({
            items: 4,
            loop: true,
            autoplay: true,
            dots: false,
            responsive: {
                0: {
                    items: 1,
                    margin: 10,
                },
                750: {
                    items: 2,
                    margin: 30,
                },
                1199: {
                    items: 3,
                    margin: 40,
                },
                1509: {
                    items: 4,
                    margin: 80,
                }
            }
        }); /* workSlider slider */

        $('#testimonialsSlider').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            dots: false,
            animateOut: 'zoomOutDown',
            animateIn: 'fadeIn',
        }); /* testimonialsSlider slider */

        $('#blogSlider').owlCarousel({
            items: 4,
            loop: true,
            margin: 30,
            autoplay: true,
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 1,
                },
                // breakpoint from 480 up
                480: {
                    items: 2,
                },
                // breakpoint from 768 up
                768: {
                    items: 3,
                }, // breakpoint from 768 up
                991: {
                    items: 4,
                }
            }
        }); /* blogSlider slider */

        $('#brandSlider').owlCarousel({
            items: 7,
            loop: true,
            margin: 30,
            autoplay: true,
            dots: false,
            responsive: {
                0: {
                    items: 2,
                },
                // breakpoint from 480 up
                480: {
                    items: 3,
                },
                // breakpoint from 768 up
                768: {
                    items: 3,
                }, // breakpoint from 991 up
                991: {
                    items: 5,
                }, // breakpoint from 1199 up
                1366: {
                    items: 7,
                }
            }
        }); /* brandSlider slider */

        $('#historySlider').owlCarousel({
            items: 1,
            loop: true,
            margin: 30,
            autoplay: true,
            dots: true,
            responsive: {

            }
        }); /* brandSlider slider */

        $('#projectdetailSlider').owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            responsive: {}
        }); /* projectdetailSlider slider */
    })

    //    var a = 0;
    //    $(window).scroll(function () {
    //
    //    var oTop = $('#counter').offset().top - window.innerHeight;
    //    if (a == 0 && $(window).scrollTop() > oTop) {
    //        $('.counter-value').each(function () {
    //            var $this = $(this),
    //                countTo = $this.attr('data-count');
    //            $({
    //                countNum: $this.text()
    //            }).animate({
    //                    countNum: countTo
    //                },
    //
    //                {
    //
    //                    duration: 2000,
    //                    easing: 'swing',
    //                    step: function () {
    //                        $this.text(Math.floor(this.countNum));
    //                    },
    //                    complete: function () {
    //                        $this.text(this.countNum);
    //                        //alert('finished');
    //                    }
    //
    //                });
    //        });
    //        a = 1;
    //    }
    //    }); /* auto increment counter */
    //
    //    });
    //
        wow = new WOW({
            animateClass: 'animated',
            offset: 100,
            callback: function (box) {
                console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
            }
        });
        wow.init(); /* wow animate js */
