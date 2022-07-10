$(function ($) {
    "use strict";


    $(document).ready(function () {

        $('.sellyourart').on( "click", function() {
	$('#vendorloginModal').modal('show');
	$('.mm-ocd--left').removeClass('mm-ocd--open');
	});

	$('.custlogin').on( "click", function() {
	$('#loginModal').modal('show');
	$('.mm-ocd--left').removeClass('mm-ocd--open');

	});

	$('.custsignup').on( "click", function() {
	$('#signInModal').modal('show');
	$('.mm-ocd--left').removeClass('mm-ocd--open');
	});

var menu = new MmenuLight(
				document.querySelector( '#mobilemenuContent' ),
				'all'
			);

			var navigator = menu.navigation({
				// selectedClass: 'Selected',
				// slidingSubmenus: true,
				// theme: 'dark',
				// title: 'Menu'
			});

			var drawer = menu.offcanvas({
				// position: 'left'
			});

			//	Open the menu.
			document.querySelector( 'a[href="#mobilemenuContent"]' )
				.addEventListener( 'click', evnt => {
					evnt.preventDefault();
					drawer.open();
				});




     /*------addClass/removeClass categories-------*/
        var windowWidth = window.innerWidth;
var slickverticale = true;
$('.slider-for-mainphoto').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	fade: true,
	asNavFor: '.slider-nav-smallphoto'
	});
$('.slider-nav-smallphoto').slick({
	slidesToShow: 3,
	slidesToScroll: 1,
	asNavFor: '.slider-for-mainphoto',
	dots: false,
	arrows: true,
	centerMode: true,
	focusOnSelect: true,
	vertical: false,
	});






$('.slider-for-mainphoto').lightGallery(
{
    selector: '.gal-item',
	download:false
}
);


});
















});
