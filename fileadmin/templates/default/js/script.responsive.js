jQuery(document).ready(function(){
	
	enquire.register("screen and (min-width: 320px) and (max-width: 949px)", {
		match : function() {
			jQuery('#logo img').attr('src', '/fileadmin/templates/default/images/logo-mobile.png');
			jQuery('#block-ligne').before(jQuery('#block-reservation'));
			jQuery('#block-ligne').after(jQuery('#block-discover'));
			jQuery('#block-difference').after(jQuery('#block-twitter'));
			jQuery('#block-network').after(jQuery('#contact-header'));
			jQuery('#logo').after(jQuery('#header-bottom'));
			jQuery('#middle-home .column-center').before(jQuery('#block-image'));
			
			jQuery('.body-booking #main-content').after(jQuery('#right #block-reservation'));

			limitText(jQuery('#list-news .news h2'), 60);
		
			jQuery('#go-top span').click(function(){
				jQuery('html, body').stop().animate({scrollTop: 0});
			});
		},  
		unmatch : function() {
			jQuery('#header-top').after(jQuery('#header-bottom'));
			jQuery('#header-menu').before(jQuery('#language'), jQuery('#space-menu'));
			jQuery('#header-menu').after(jQuery('#contact-header'));

			//jQuery('#block-ligne').after(jQuery('#block-reservation'));
			jQuery('#wrap-home .column-center').after(jQuery('#block-reservation'));
			//jQuery('#wrap-home .column-center').before(jQuery('#block-discover'));
			jQuery('#block-ligne').before(jQuery('#block-discover'));
			jQuery('#wrap-home #middle-home .content-inner').append(jQuery('#block-twitter'));
			jQuery('.body-booking #right').prepend(jQuery('#block-reservation'));
			jQuery('#block-image2').before(jQuery('#block-image'));

		}
	});	
	
	
	enquire.register("screen and (min-width: 320px) and (max-width: 739px)", {
		match : function() {
			resizeImg(jQuery('.slider-travel ul li'));
			jQuery('#detail-travel .slider-travel').after(jQuery('#detail-travel .info-travel'));
			jQuery('#block-network').after(jQuery('#contact-header'));
			jQuery('header .content-inner').after(jQuery('.right-header'));	
		},
		unmatch : function() {
			jQuery('#logo').after(jQuery('.right-header'));
			jQuery('#detail-travel .slider-travel').before(jQuery('#detail-travel .info-travel'));
			resizeImg(jQuery('.slider-travel ul li'));

		}
	});
	
	enquire.register("screen and (min-width: 320px) and (max-width: 499px)", {
		match : function() {
			jQuery('#header-bottom .hover-menu').prepend(jQuery('#space-menu'), jQuery('#language'));
		},  
		unmatch : function() {	

		}
	});
	
	enquire.register("screen and (min-width: 650px) and (max-width: 949px)", {
		match : function() {

		},
		unmatch : function(){
		
		}
	});
	
	
	enquire.register("screen and (min-width: 500px) and (max-width: 739px)", {
		match : function() {
			jQuery('#header-bottom').before(jQuery('#language'), jQuery('#space-menu'));
		},
		unmatch : function(){
		}
	});
	
	enquire.register("screen and (min-width: 740px) and (max-width: 949px)", {
		match : function() {
			jQuery('.right-header .content-header').prepend(jQuery('#language'), jQuery('#space-menu'));
			//jQuery('#block-reservation').after(jQuery('#contact-header'));
		},
		unmatch : function(){
		}
	});

});

jQuery(window).load(function(){

	enquire.register("screen and (min-width: 320px) and (max-width: 739px)", {
		match : function() {
			resizeImg(jQuery('.slider-travel ul li'));
		},
		unmatch : function() {
			resizeImg(jQuery('.slider-travel ul li'));
		}
	});
});