//---------Product Carousel-----------
        $(".featured-carousel").owlCarousel({
            items: 4,
            autoplay: true,
            margin: 30,
            loop: true,
            dots: true,
            nav: true,
            navText: ["<i class='fa fa-angle-double-left'></i>", "<i class='fa fa-angle-double-right'></i>"],
            smartSpeed: 800,
            responsive : {
                0 : {
                    items: 1,
                },
                768 : {
                    items: 2,
                },
                992 : {
                    items: 3
                },
                1200 : {
                    items: 4
                }
            }
        });

(function($, window) {
    var Starrr;
    window.Starrr = Starrr = (function() {
        Starrr.prototype.defaults = {
            rating: void 0,
            max: 5,
            readOnly: false,
            emptyClass: 'fa fa-star-o',
            fullClass: 'fa fa-star',
            change: function(e, value) {}
        };

        function Starrr($el, options) {
            this.options = $.extend({}, this.defaults, options);
            this.$el = $el;
            this.createStars();
            this.syncRating();
            if (this.options.readOnly) {
                return;
            }
            this.$el.on('mouseover.starrr', 'a', (function(_this) {
                return function(e) {
                    return _this.syncRating(_this.getStars().index(e.currentTarget) + 1);
                };
            })(this));
            this.$el.on('mouseout.starrr', (function(_this) {
                return function() {
                    return _this.syncRating();
                };
            })(this));
            this.$el.on('click.starrr', 'a', (function(_this) {
                return function(e) {
                    return _this.setRating(_this.getStars().index(e.currentTarget) + 1);
                };
            })(this));
            this.$el.on('starrr:change', this.options.change);
        }

        Starrr.prototype.getStars = function() {
            return this.$el.find('a');
        };

        Starrr.prototype.createStars = function() {
            var j, ref, results;
            results = [];
            for (j = 1, ref = this.options.max; 1 <= ref ? j <= ref : j >= ref; 1 <= ref ? j++ : j--) {
                results.push(this.$el.append("<a href='javascript:;' />"));
            }
            return results;
        };

        Starrr.prototype.setRating = function(rating) {
            if (this.options.rating === rating) {
                rating = void 0;
            }
            this.options.rating = rating;
            this.syncRating();
            return this.$el.trigger('starrr:change', rating);
        };

        Starrr.prototype.getRating = function() {
            return this.options.rating;
        };

        Starrr.prototype.syncRating = function(rating) {
            var $stars, i, j, ref, results;
            rating || (rating = this.options.rating);
            $stars = this.getStars();
            results = [];
            for (i = j = 1, ref = this.options.max; 1 <= ref ? j <= ref : j >= ref; i = 1 <= ref ? ++j : --j) {
                results.push($stars.eq(i - 1).removeClass(rating >= i ? this.options.emptyClass : this.options.fullClass).addClass(rating >= i ? this.options.fullClass : this.options.emptyClass));
            }
            return results;
        };

        return Starrr;

    })();
    return $.fn.extend({
        starrr: function() {
            var args, option;
            option = arguments[0], args = 2 <= arguments.length ? slice.call(arguments, 1) : [];
            return this.each(function() {
                var data;
                data = $(this).data('starrr');
                if (!data) {
                    $(this).data('starrr', (data = new Starrr($(this), option)));
                }
                if (typeof option === 'string') {
                    return data[option].apply(data, args);
                }
            });
        }
    });
})(window.jQuery, window);

$('.shippingCheck').click(function(){
	 		$('.shipping-details-area').toggle();
	  	});
$('.home_brand_sel').click(function(){
var brandid = $(this).data("brandid");
	$('#manufacturer').val(brandid);
  jQuery('.home_brand_btn').click();
  jQuery('.brnad-side-filter li').removeClass('brand_selected');
    jQuery(this).parent().addClass("brand_selected");

});

var cartOpen = false;
var numberOfProducts = 0;
$(document).ready(function($) {
$('body').on('click', '.js-toggle-cart', toggleCart);
$('body').on('click', '.js-add-product', addProduct);
$('body').on('click', '.js-remove-product', removeProduct);

function toggleCart(e) {
  e.preventDefault();
  if(cartOpen) {
    closeCart();
    return;
  }
  openCart();
  console.log('1');
}

function openCart() {
  cartOpen = true;
  $('body').addClass('open');
}

function closeCart() {
  cartOpen = false;
  $('body').removeClass('open');
}

});




function addProduct(e) {
  e.preventDefault();
  openCart();
  $('.js-cart-empty').addClass('hide');
  var product = $('.js-cart-product-template').html();
  $('.js-cart-products').prepend(product);
  numberOfProducts++;
}

function removeProduct(e) {
  e.preventDefault();
  numberOfProducts--;
  $(this).closest('.js-cart-product').hide(250);
  if(numberOfProducts == 0) {
    $('.js-cart-empty').removeClass('hide');
  }
}
$(document).ready(function()
{
$(window).scroll(function(){
		if ($(this).scrollTop() > 100)
		{
			$('.scroll-top').fadeIn();
		}
		else
		{
			$('.scroll-top').fadeOut();
		}
	});
	$(".scroll-top").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        return false;
    });
});
