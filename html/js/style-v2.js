//var window width
var viewportGlobal = $(window).width();

//function js scroll header
var scrollHeader = function(){
  var nav = $('.l-nav');
  var body = $('body');
  if(nav.length > 0){
    $(window).scroll(function(){
      if($(this).scrollTop() > 0){
        nav.addClass('has-fixed');
        body.addClass('has-padding');
      }
      if($(this).scrollTop() <= 0){
        nav.removeClass('has-fixed');
        body.removeClass('has-padding');
      }
    });
  }
};

//function js alias mobile expand
var aliasMobileExpand = function(){
  if($('.c-alias').length > 0){
    $('.js-menu-expand').click(function(e) {
      e.preventDefault();
      var body = $('body');
      var menu = $('.c-alias__expand');
      var page = $('body');
      var ovelay = $('.js-app-ovelay');
      if (page.hasClass('has-page-open')) {
        page.removeClass('has-page-open');
        ovelay.removeClass('has-ovelay-show');
        menu.removeClass('has-menu-open');
        body.removeClass('has-body-open');
        $(this).removeClass('is-active');
      } else {
        page.addClass('has-page-open');
        ovelay.addClass('has-ovelay-show');
        menu.addClass('has-menu-open');
        body.addClass('has-body-open');
        $(this).addClass('is-active');
      }
    });
    $('.js-app-ovelay, .js-alias-close').click(function() {
      var body = $('body');
      var menu = $('.c-alias__expand');
      var page = $('body');
      var ovelay = $('.js-app-ovelay');
      page.removeClass("has-page-open");
      ovelay.removeClass("has-ovelay-show");
      menu.removeClass("has-menu-open");
      body.removeClass("has-body-open");
      $('.js-menu-expand').removeClass('is-active');
      return false;
    });
  }
};

//function alias mobile sub expand
var aliasMobileSubExpand = function(){
  if($('.c-alias').length > 0){
    $('.c-alias-mobile__expand-sub').click(function(e) {
      e.preventDefault();
      var parent = $(this).parent().parent();
      if(parent.hasClass('is-mobile-active')){
        $('.c-alias-sub',parent).slideUp();
        $(this).removeClass('fa-minus').addClass('fa-plus');
        parent.removeClass('is-mobile-active');
      }else {
        $('li.is-mobile-active a .c-alias-mobile__expand-sub','.c-alias__expand').removeClass('fa-minus').addClass('fa-plus');
        $('li.is-mobile-active .c-alias-sub','.c-alias__expand').slideUp();
        $('li.is-mobile-active','.c-alias__expand').removeClass('is-mobile-active');
        $('.c-alias-sub',parent).slideDown();
        $(this).removeClass('fa-plus').addClass('fa-minus');
        parent.addClass('is-mobile-active');
      }
    });
  }
};

//function js main slider
var mainSlider = function(){
  if($('.js-main-slider').length > 0){
    $('.js-main-slider').owlCarousel({
      items:1,
      loop:true,
      margin:0,
      responsiveClass:false,
      nav:true,
      dots:true,
      autoplay:true,
      autoHeight:false,
      autoplayTimeout:8000,
      autoplaySpeed:1000,
      autoplayHoverPause:false,
      navText:false,
    });
  }
};

//function js footer content expand
var footerContentExpand = function(){
  if($('.c-footer-label').length > 0){
    $('.c-footer-label .fa').click(function() {
      var grand = $(this).parent().parent();
      if ($(this).hasClass('fa-plus')) {
        $(this).removeClass('fa-plus');
        $(this).addClass('fa-minus');
        $('.c-footer-content',$(grand)).slideDown();
      } else {
        $(this).removeClass('fa-minus');
        $(this).addClass('fa-plus');
        $('.c-footer-content',$(grand)).slideUp();
      }
    });
  }
};

//function js product hot slider
var productHotSlider = function(){
  if($('.js-product-hot').length > 0){
    $('.js-product-hot').owlCarousel({
      loop:true,
      margin:0,
      responsiveClass:false,
      nav:true,
      dots:false,
      autoplay:false,
      autoHeight:false,
      autoplayTimeout:8000,
      autoplaySpeed:1000,
      autoplayHoverPause:false,
      navText:false,
      responsive:{
        0:{
          items:2,
          margin:6,
          stagePadding: 30
        },
        576:{
          items:3,
          margin:6
        },
        768:{
          items:4,
          margin:10
        },
        1200:{
          items:6,
          margin:10
        }
      }
    });
  }
};

//function js promotion hot slider
var promotionHotSlider = function(){
  if($('.js-promotion-hot').length > 0){
    $('.js-promotion-hot').owlCarousel({
      loop:true,
      margin:0,
      responsiveClass:false,
      nav:true,
      dots:false,
      autoplay:false,
      autoHeight:false,
      autoplayTimeout:8000,
      autoplaySpeed:1000,
      autoplayHoverPause:false,
      navText:false,
      responsive:{
        0:{
          items:1,
          margin:0
        },
        576:{
          items:3,
          margin:6
        },
        768:{
          items:4,
          margin:10
        },
        1200:{
          items:5,
          margin:10
        }
      }
    });
  }
};

//function js browse slider
var browseSlider = function(){
  if($('.c-browse-slider').length > 0){
    $('.js-browse-slider').owlCarousel({
      items:1,
      loop:true,
      margin:0,
      responsiveClass:false,
      nav:true,
      dots:true,
      autoplay:true,
      autoHeight:false,
      autoplayTimeout:8000,
      autoplaySpeed:1000,
      autoplayHoverPause:false,
      navText:false,
    });
  }
};

//function widget close
var widgetClose = function(){
  if($('.c-widget').length > 0){
    $('.c-widget__close').click(function(e) {
      var rootBox = $(this).parent().parent();
      if(rootBox.hasClass('is-close')){
        rootBox.removeClass('is-close');
        $('.c-widget__content',rootBox).slideDown();
      }else {
        rootBox.addClass('is-close');
        $('.c-widget__content',rootBox).slideUp();
      }
    });
  }
};

//function js filter mobile expand
var filterMobileExpand = function(){
  if($('.c-sidebar-filter').length > 0){
    $('.c-filter-mobile ul li a').click(function(e) {
      e.preventDefault();
      var body = $('body');
      var id = $(this).attr('href');
      var menu = $(id);
      var page = $('body');
      var ovelay = $('.js-sidebar-ovelay');
      if (page.hasClass('has-pagefilter-open')) {
        page.removeClass('has-pagefilter-open');
        ovelay.removeClass('has-ovelay-show');
        menu.removeClass('has-menufilter-open');
        body.removeClass('has-body-open');
        $(this).removeClass('is-active');
      } else {
        page.addClass('has-pagefilter-open');
        ovelay.addClass('is-active');
        menu.addClass('has-menufilter-open');
        body.addClass('has-body-open');
        $(this).addClass('is-active');
      }
    });
    $('.js-sidebar-ovelay, .js-sidebar-close').click(function() {
      var body = $('body');
      var menu = $('.c-sidebar-filter');
      var page = $('body');
      var ovelay = $('.js-sidebar-ovelay');
      page.removeClass("has-pagefilter-open");
      ovelay.removeClass("is-active");
      menu.removeClass("has-menufilter-open");
      body.removeClass("has-body-open");
      return false;
    });
  }
};

//function filter expand
var filterExpand = function(){
  if($('.c-choose-more').length > 0){
    $('.c-choose-more a').click(function(e) {
      e.preventDefault();
      var rootBox = $(this).parent().parent();
      if(rootBox.hasClass('is-active')){
        rootBox.removeClass('is-active');
        $('.checkbox', rootBox).each(function () {
          if(!$(this).hasClass('is-active')){
            $(this).hide();
          }
        });
        $(this).html('<i class="fa fa-angle-double-right"></i>Xem thêm');
      }else {
        rootBox.addClass('is-active');
        $('.checkbox', rootBox).each(function () {
          if(!$(this).hasClass('is-active')){
            $(this).show();
          }
        });
        $(this).html('<i class="fa fa-angle-double-right"></i>Ẩn đi');
      }
    });
  }
};

//function filter scroll
var filterScroll = function(){
  if($('.js-filter-scroll').length > 0){
    $('.js-filter-scroll').slimScroll({
      height: 147
    });
  }
};

//function load thumb slider
var loadThumbSlider = function(){
  //detail left thumb slider
  if($('.c-product-thumb').length > 0){
    $('#product-thumb-id').owlCarousel({
      loop:false,
      margin:0,
      responsiveClass:true,
      nav:true,
      dots:false,
      autoplay:false,
      autoHeight:false,
      autoplayTimeout:4000,
      autoplayHoverPause:false,
      navText:false,
      responsive:{
        0:{
          items:3
        },
        768:{
          items:4
        },
        1200:{
          items:5
        }
      }
    });
  }
  //CloudZoom
  CloudZoom.quickStart();
};

//function js cat slider
var catSlider = function(){
  if($('.js-cat-slider').length > 0){
    $('.js-cat-slider').owlCarousel({
      loop:true,
      margin:0,
      responsiveClass:false,
      nav:true,
      dots:false,
      autoplay:false,
      autoHeight:false,
      autoplayTimeout:8000,
      autoplaySpeed:1000,
      autoplayHoverPause:false,
      navText:false,
      responsive:{
        0:{
          items:2
        },
        576:{
          items:4
        },
        768:{
          items:6
        },
        1200:{
          items:8
        },
        1400:{
          items:10
        }
      }
    });
  }
};

//function js place checkout click
var vatClick = function(){
  if($('.js-vat').length > 0){
    $('.js-vat').click(function(){
      var parent = $(this).parent();
      var vatForm = $('.c-form-vat');
      if(!$(this).hasClass('active')){
        $('.c-radio-item.active .c-radio-item__icon',parent).removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        $('.c-radio-item.active',parent).removeClass('active');
        $('.c-radio-item__icon',$(this)).removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        $(this).addClass('active');
        vatForm.slideDown();
      }else {
        $('.c-radio-item__icon',$(this)).removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        $(this).removeClass('active');
        vatForm.slideUp();
      }
    });
  }
};

//function js payments click
var paymentsClick = function(){
  if($('.c-payments').length > 0){
    $('.c-payments .c-payments-item .c-payments-item__title').click(function(e){
      e.preventDefault();
      var parent = $(this).parent();
      var grand = $('.c-payments');
      if (!$(parent).hasClass('active')) {
        $('.c-payments-item.active .c-payments-item__content',$(grand)).slideUp();
        $('.c-payments-item.active',$(grand)).removeClass('active');
        $(parent).addClass('active');
        $('.c-payments-item__content',$(parent)).slideDown();
      }
    });
  }
};

//---------run js-------------//
//var function init call
var initReady = function(){
  //function run
  scrollHeader();
  aliasMobileExpand();
  aliasMobileSubExpand();
  mainSlider();
  footerContentExpand();
  productHotSlider();
  promotionHotSlider();
  browseSlider();
  widgetClose();
  filterMobileExpand();
  filterExpand();
  filterScroll();
  loadThumbSlider();
  catSlider();
  vatClick();
  paymentsClick();
};

var initResize = function(){
  //function run
};

//document ready before js
$(document).ready(function(){

  //js autoload when document ready
  initReady();

});

//window resize before js
$(window).resize(function() {

  //js autoload when window resize
  initResize();

});