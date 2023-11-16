$('.galery_wrap').slick({
    infinite: true, 
    slidesToShow: 3,
    slidesToScroll: 3,
    prevArrow: $('.btn_left'),
    nextArrow: $('.btn_right'),
    dots: true,
    draggable: false,
    autoplay: false,
    autoplaySpeed: 1600,
    responsive: [
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots:false
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});