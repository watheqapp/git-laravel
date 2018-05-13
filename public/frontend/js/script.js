// JavaScript Document
$(function(){
	
	$('body').scrollspy({ target: '.navbar-default' })
		$('[data-spy="scroll"]').each(function () {
  var $spy = $(this).scrollspy('refresh')
})
	});
	

//--------------------------------------------
$(function() {
  $('a[href^="#home"]').on('click', function(event) {

    var target = $( $(this).attr('href') );

    if( target.length ) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: target.offset().top-70
        }, 1000);
    }

});
});
//--------------------------------------------
$(function() {
  $('a[href^="#serv"]').on('click', function(event) {

    var target = $( $(this).attr('href') );

    if( target.length ) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: target.offset().top
        }, 1000);
    }

});
});
//--------------------------------------------
$(function() {
  $('a[href^="#contact"]').on('click', function(event) {

    var target = $( $(this).attr('href') );

    if( target.length ) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: target.offset().top
        }, 1000);
    }

});
});
//--------------------------------------------
$(function() {
  $('a[href^="#docs"]').on('click', function(event) {

    var target = $( $(this).attr('href') );

    if( target.length ) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: target.offset().top-60
        }, 1000);
    }

});
});
//--------------------------------------------


 $(document).ready(function() {
    $('#myCarousel').carousel({interval: 4000,cycle:true,pause: "false"});
	
  });
	

//--------------------------------------


 $(document).ready(function() {
    $('#myCarousel2').carousel({interval: 4000});
	
  });
	
$(document).ready(function() {
    $('#myCarousel3').carousel({interval: 4000,cycle:true,pause: "false"});
	
  });
//--------------------------------------

$('[data-toggle="tooltip"]').tooltip({'placement': 'top'});


//--------------------------------------------------------popup team log in ---------///

jQuery(document).ready(function() {
	
var $header_top = $('.header-top');
var $nav = $('nav');





// fullpage customization
$('#fullpage').fullpage({
  sectionsColor: ['#f5cb39', '#ffffff', '#ffffff', '#ffffff', '#ffffff', '#ffffff', 'ffffff','#f5cb39'],
  sectionSelector: '.vertical-scrolling',
  slideSelector: '.horizontal-scrolling',
  navigation: true,
  slidesNavigation: false,
  controlArrows: false,
  anchors: ['firstSection', 'secondSection', 'thirdSection', 'fourthSection', 'fifthSection' ,'sixthSection' ,'seventhSection','eightthSection','ninethSection'],
  menu: '#menu',
	  
  afterLoad: function(anchorLink, index) {
    $header_top.css('background', 'rgba(0, 47, 77, .0)');
    $nav.css('background', 'rgba(0, 47, 77, .25)');
    /*if (index == 5) {
        $('#fp-nav').hide();
      }*/
	if (index == 1 || index == 2 || index == 4 || index == 5) 
	{
        $('#fp-nav ul li a.active span').css({'background':'#fff'});
        $('#fp-nav ul li a span').css({'border':'1px solid #fff'});
    }
	else
	{
		$('.toggle-menu i').css({'background':'#f5cb39'});
	}	
  },

  onLeave: function(index, nextIndex, direction) {
    if(index == 5) {
      $('#fp-nav').show();
    }
	
	if (index == 1 || index == 2 || index == 4 || index == 5) 
	{
        $('#fp-nav ul li a.active span').css({'background':'transparent'});
        $('#fp-nav ul li a span').css({'border':'1px solid #f5cb39'});
    }
	else
	{
		$('.toggle-menu i').css({'background':'#fff'});
	}	
  },

  afterSlideLoad: function( anchorLink, index, slideAnchor, slideIndex) {
    if(anchorLink == 'fifthSection' && slideIndex == 1) {
      $.fn.fullpage.setAllowScrolling(false, 'up');
      $header_top.css('background', 'transparent');
      $nav.css('background', 'transparent');
      $(this).css('background', '#f5cb39');
      $(this).find('h2').css('color', 'white');
      $(this).find('h3').css('color', 'white');
      $(this).find('p').css(
        {
          'color': '#DC3522',
          'opacity': 1,
          'transform': 'translateY(0)'
        }
      );
    }
  },

  onSlideLeave: function( anchorLink, index, slideIndex, direction) {
    if(anchorLink == 'fifthSection' && slideIndex == 1) {
      $.fn.fullpage.setAllowScrolling(true, 'up');
      $header_top.css('background', 'rgba(0, 47, 77, .3)');
      $nav.css('background', 'rgba(0, 47, 77, .25)');
    }
  } 
});

});
