$(document).ready(function () {  
    
    //viewport height 
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            $('.banner').addClass("top-fixed");
            $('.header-home .menu-second .icon-menu-second').css('display','block');
        } else {
            $('.banner').removeClass("top-fixed");
            $('.header-home .menu-second .icon-menu-second').css('display','none');
        }
    });  
    //expand submenu 
    $('.info-ft .ft-row .list-item-ft .title-ft .btn-submenu').click(function() {
        var grand = $(this).parent().parent();
        var root = $(this).parent().parent().parent();
        if ($(this).hasClass("fa-plus")) {
            $(this).removeClass("fa-plus");
            $(this).addClass("fa-minus");
            $('.list-item-ft.mobile-active > .list-link',$(root)).slideUp();
            $('.list-item-ft.mobile-active > .title-ft > .btn-submenu',$(root)).removeClass("fa-minus");
            $('.list-item-ft.mobile-active > .title-ft > .btn-submenu',$(root)).addClass("fa-plus");
            $('.list-item-ft',$(root)).removeClass("mobile-active");
            $(grand).addClass("mobile-active");
            $('.list-link',$(grand)).slideDown(); 
        } else {
            $(this).removeClass("fa-minus");
            $(this).addClass("fa-plus");
            $(grand).removeClass("mobile-active");
            $('.list-link',$(grand)).slideUp(); 
        }
        return false;
    });

    $('nav#menu').mmenu({
       offCanvas: {
        position: "left",
        zposition: "front"
       }
      }, {
       offCanvas: {
        pageNodeType: "form"
       }
    });   
    
    // Click menu left News page
    $('.main-menu .alias-submenu > ul > li').mouseenter(function () {
        $('.main-menu .alias-submenu > ul > li').removeClass('active');
        $(this).addClass('active');
    });
    $('.main-menu .alias-submenu > ul > li').mouseleave(function () {
        $('.main-menu .alias-submenu > ul > li').removeClass('active');
    });
    $('.main-menu .alias-submenu > ul').mouseleave(function (){
        $('.main-menu .alias-submenu > ul > li:first-child').addClass('active');
    });
    // Slider Detail
    $('#imageslider').owlCarousel({
        loop:false,
        margin:0,
        responsiveClass:true,
        nav:true,
        dots:false,
        autoplay:true,
        autoHeight:false,
        autoplayTimeout:4000,
        autoplayHoverPause:false,
        navText: false,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 3
            }, 
            1200:{
                items: 4
            }
        },
        onInitialize: function (event) {
          var viewport = $(window).width();
          if ($('#imageslider .pi-item').length <= 4 && viewport >=1200) {
            this.settings.loop = false;
          }
          if ($('#imageslider .pi-item').length <= 3 && viewport >= 768) {
            this.settings.loop = false;
          }
          if ($('#imageslider .pi-item').length <= 1) {
            this.settings.loop = false;
          }
        }
    }); 

    //heartslider
    $('#slide-list').owlCarousel({ 
        loop: true,
        margin: 30,
        responsiveClass: false,
        nav: true,
        dots: false,
        autoplay: true,
        autoHeight: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        navText: false,
        responsive: {
            0: {
                items: 1
            },
            375:{
                items: 2  
            },
            640: {
                items: 3
            },
            767: {
                items: 3
            }, 
            1200: {
                items: 5
            }
        }
    });

    $('#salelider').owlCarousel({ 
        loop: true,
        margin: 30,
        responsiveClass: false,
        nav: true,
        dots: false,
        autoplay: true,
        autoHeight: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        navText: false,
        responsive: {
            0: {
                items: 1
            },
            640: {
                items: 1
            },
            767: {
                items: 2
            }, 
            1200: {
                items: 3
            }
        }
    });
    $('#banner-slider').owlCarousel({ 
        items: 1,
        loop: true,
        margin: 0,
        responsiveClass: false,
        nav: true,
        dots: false,
        autoplay: true,
        autoHeight: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        navText: false,
    });
     
    //heartslider
    $('#slider-ft').owlCarousel({ 
        loop: true,
        margin: 10,
        responsiveClass: false,
        nav: true,
        dots: false,
        autoplay: true,
        autoHeight: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        navText: false,
        responsive: {
            0: {
                items: 1
            },
            414: {
                items: 3
            },
            1200: {
                items: 5
            }
        }
    });
    $("#customer-slider").owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: false,
        nav: true,
        dots: false,
        autoplay: true,
        autoHeight: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        navText: false,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1200: {
                items: 3
            }
        }
    });
    /*filter-scroll*/
    $('.filter-scroll').slimScroll({
        height: '150px',
    });

  if($('.backdrop').length > 0){
    var backdropHeight = $('.backdrop .backdrop-popup').height();
    var marginTop = -(backdropHeight)/2;
    $('.backdrop .backdrop-popup').css({
      'margin-top': marginTop,
      'top': '50%'
    });
  }

});