jQuery(document).ready(function(){
	jQuery('input, textarea').placeholder();
	
	jQuery('input').iCheck();

	/*jQuery('.payment-list .iCheck-helper').on('click', function(){
		//alert('!!!!');
		jQuery('.submit-etape2').trigger('click');
		//jQuery( "#booking-step2" ).submit();
		
	});*/
	
	if(jQuery('#content-right').height() <= 0){
		jQuery('#main-content').addClass('center');
		jQuery('#content-right').hide();
	}
	
	/**** GOOGLE MAP ****/
	/*jQuery('.tx-go-maps-ext').each(function(){
		jQuery(this).parent().prepend("<a class='bt-pointer' href='#"+$(this).find('.js-map').attr('id')+"'>Voir l'arrêt</a>")
	});*/
	jQuery(document).on('click', '.position-google .bt-pointer', function(){
		jQuery(this).parent().find('.tx-go-maps-ext').dialog({
			modal: true,
			autoOpen: true,
			resizable: false,
			draggable: false,
			dialogClass: 'dialog-map',
			close: function(){
				jQuery('.ui-dialog .tx-go-maps-ext').dialog('destroy');
			},
			open: function(){
				jQuery(this).parent().find('.js-map').trigger('mapresize');
				//google.maps.event.trigger(jQuery(this).parent().find('.js-map'), 'resize');
			},
			show: { effect: "fadeIn", duration: 200 }
		});
	});
	/**** GOOGLE MAP ****/
	

	/**** COOKIES BAR ****/
	$('.cookie-message').cookieBar({
		domain: 'autocars-imbert.com'
	});
	/**** COOKIES BAR ****/
	
	
	/**** HREF LOGO ****/
	var currentLocation =  document.location.pathname;
	var lang = "/"+currentLocation.substring( 1 ,currentLocation.indexOf( "/", 2 ) );
	if(currentLocation.indexOf( "/", 2 ) == -1){
		$('#logo a').attr('href', "http://"+document.location.hostname);
	}
	else{
		$('#logo a').attr('href', "http://"+document.location.hostname+lang);
	}
	/**** FIN HREF LOGO ****/
	
	jQuery('.csc-textpic-imagewrap ul li').each(function(){
		if(jQuery(this).find('a').length > 0){
			jQuery(this).find('a').append(jQuery(this).find('.csc-textpic-caption'));
		}
	});
	
	var isIE11 = !!navigator.userAgent.match(/Trident.*rv[ :]*11\./)
	if(jQuery.browser['msie'] || isIE11){
		jQuery('html').addClass('ie');
	}
	
	
	/****** FORM DEMANDE D'INFORMATIONS ******/
	if(jQuery('#powermail_field_informationssurlevoyage').length > 0){
		var travel = decodeURIComponent(getUrlParameter('travel'));
		jQuery('#powermail_field_informationssurlevoyage').val(travel).attr('readonly', true);
	}

	/****** FIN FORM DEMANDE D'INFORMATIONS ******/
	
	
	/****** LIGHTBOX MODAL ******/
	dialogFullScreen(jQuery('.link-lightbox'), jQuery('.link-lightbox').attr('data-dialog'));
	/****** FIN LIGHTBOX MODAL ******/
	
	
	/****** MENU SUBMENU ******/
	menu_mobile();
	/****** FIN MENU SUBMENU ******/
	
	/****** SELECT CHECKBOX / FORMULAIRE RESERVATION ******/
	if(jQuery('#reservation-form .input-radio input[type="radio"].from-city__Paris').attr('checked')){
		$('.input-radio.paris').fadeIn();	
	}
	jQuery('#reservation-form .input-radio input[type="radio"].from-city').on('ifChecked', function(event){
		if(jQuery(this).attr('id') == 'Paris'){
			$('.input-radio.paris').fadeIn();
		}
		else{
			$('.input-radio.paris').fadeOut();
			$('.input-radio.paris').iCheck('uncheck');
		}
	});
	jQuery('.input-radio input[type="radio"]').on('ifChecked', function(event){
		
		if(jQuery(this).attr('name') == 'depart-res'){
			jQuery('#booking-step1 .info-datepicker .dest-datepicker').html(jQuery(this).parent().parent().find('>label').text());
		}
		if(jQuery(this).attr('name') == 'dest-res'){
			jQuery('#booking-step1 .info-datepicker .retour-datepicker').html(jQuery(this).parent().parent().find('>label').text());
		}
		if(jQuery(this).attr('name') == 'dest-more-res'){
			jQuery('#booking-step1 .info-datepicker .retour-datepicker').html("Le Queyras - "+jQuery(this).parent().parent().find('>label').text());
		}
		
		jQuery(this).parents('.radio-grp').find('.input-radio').removeClass('active');
		jQuery(this).parents('.input-radio').addClass('active');
		
		if(!jQuery('#queyras-res').parent().parent().hasClass('active')){
			jQuery('.form-booking fieldset').removeClass('animate');	
			jQuery('.input-radio .input-more-radio').stop().fadeOut();
		}
		if(jQuery(this).parent().parent().find('.input-more-radio').length > 0){
			jQuery(this).parent().parent().addClass('submenu');
		}
		if(jQuery(this).parents('.input-radio').find('.input-more-radio').length > 0){
			jQuery(this).parents('fieldset').addClass('animate');
			jQuery(this).parents('.input-radio').find('.input-more-radio').stop().fadeIn();
		}
		

	});
	jQuery('.input-radio #retour').on('ifChecked', function(){
		jQuery('#booking-step1 .fieldset-retour').fadeOut();
		jQuery('#block-reservation').fadeOut();
		/*jQuery('#block-reservation .input-second').fadeOut();
		jQuery('#block-reservation .from-group >label').html('Retour au départ de');*/
		
	});
	jQuery('.input-radio #retour').on('ifUnchecked', function(){
		jQuery('#booking-step1 .fieldset-retour').fadeIn();
		jQuery('#block-reservation').fadeIn();
		/*jQuery('#block-reservation .input-second').fadeIn();
		jQuery('#block-reservation .from-group >label').html('Aller / retour au départ de');*/
	});
	
	/*jQuery('.form-booking .payment-list input').on('ifChecked', function(){
		jQuery('.form-booking .payment-list ul li').removeClass('active');
		jQuery(this).parents('li').addClass('active');
	});*/
	if(jQuery('#type-res').length && jQuery('#type-res').val() == 'aller-simple'){
		jQuery('#block-reservation').hide();
	}
	/****** FIN SELECT CHECKBOX / FORMULAIRE RESERVATION ******/
	
	
	/****** SELECT JQUERY UI ******/
	jQuery('select').selectmenu({
		create: function( event, ui ) {
			jQuery(this).after(jQuery('#'+jQuery(this).attr('id')+'-menu').parent());
		},
                change: function( event, ui ){
			
                        if($(this).attr('id') == "destinationStart"){
                            $('.form-add-voyage').hide();
                            if($(this).val()!= 0){
                                $('#form-add-voyage-'+$(this).val()).show();
                            }
                        }
                }
	});
	/****** SELECT JQUERY UI ******/
	
	
	/****** DATEPICKER JQUERY UI ******/
	var events = [ 
			// { Date: new Date("10/08/2015") }, 
			// { Date: new Date("10/10/2015")}, 
			// { Date: new Date("10/11/2015")}, 
			// { Date: new Date("10/20/2015")}, 
			// { Date: new Date("10/25/2015")}, 
			// { Date: new Date("10/26/2015")}, 
			// { Date: new Date("11/26/2015")}, 
			// { Date: new Date("11/20/2015")}, 
			// { Date: new Date("12/12/2015")}, 
		]
	// jQuery('.block-datepicker').datepicker({
	// 	autoSize: true,
	// 	dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
	// 	dayNamesMin: [ "D", "L", "M", "M", "J", "V", "S" ],
	// 	monthNames: [ "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre" ],
	// 	monthNamesShort: [ "Jan", "Fev", "Mar", "Avr", "Mai", "Jui", "Jui", "Aoû", "Sep", "Oct", "Nov", "Dec" ],
	// 	showOtherMonths: false,
	// 	firstDay: 1,
	// 	dateFormat: 'dd MM yy',
	// 	beforeShowDay: function(date) {

	// 		var result = [true, '', null];
	// 		var matching = jQuery.grep(events, function(event) {
	// 			return event.Date.valueOf() === date.valueOf();
	// 		});

	// 		if (matching.length) {
	// 			result = [true, 'event', null];
	// 		}
	// 		return result;
	// 	},
	// 	onSelect: function(dateText, inst ) {
	// 		var date,
	// 		selectedDate = jQuery('#'+inst.id).datepicker('getDate'),
	// 		i = 0,
	// 		event = [];
	// 		/* Determine if the user clicked an event: */
	// 		while (i < events.length) {
	// 			date = events[i].Date;
	// 			if (selectedDate.valueOf() === date.valueOf()) {
	// 				event.push(events[i]);
	// 			}
	// 			i++;
	// 		}
	// 		if (event.length > 0) {
	// 			for(k=0; k<event.length; k++){
	// 				// Contenu de la lightbox
	// 				jQuery('#'+inst.id).parents('fieldset').find('.info-datepicker .date-datepicker').html(dateText);
	// 			}
	// 		}
	// 		else{
 //               swal("Erreur !", "Le jour demandé n'est pas possible", "error");
	// 		}
	// 	}
	// });

		// $('.block-datepicker').datepicker("setDate", new Date("10/26/2015") );
		// 		$('.block-datepicker').datepicker("setDate", new Date("11/26/2015") );

	/****** DATEPICKER JQUERY UI ******/
	
	
	/****** SLIDER DECOUVRIR ******/
	// var diaporama = '<ul class="bxslider">';
	// jQuery('#slider-discover >div').each(function(){
	// 	diaporama += '<li>'+jQuery(this).html()+'</li>';
		
	// });
	// diaporama += '</ul>';
	// jQuery('#slider-discover').empty().append(diaporama);
	slider_discover = jQuery('#slider-discover ul.bxslider').bxSlider({
		auto: true,
		pager: true,
		speed: 1000,
		pause: 7000,
		controls: true,
		responsive: true,
		adaptiveHeight: true,
		preloadImages: 'all'
	});
	jQuery('#slider-discover .bx-controls').on('click', 'a', function(e){
		restart=setTimeout(function(){
			slider_header.startAuto();
			},500);
		return false;
	});
	/****** FIN SLIDER DECOUVRIR ******/
	
	
	/****** SLIDER VOYAGE DETAIL ******/
	slider_travel = jQuery('.slider-travel ul').bxSlider({
		auto: true,
		pager: false,
		speed: 1000,
		pause: 7000,
		controls: true,
		responsive: true,
		adaptiveHeight: true,
		preloadImages: 'all',
		onSliderLoad: function(){
			resizeImg(jQuery('.slider-travel ul li'));
		}
	});
	jQuery('.slider-travel .bx-controls').on('click', 'a', function(e){
		restart=setTimeout(function(){
			slider_header.startAuto();
			},500);
		return false;
	});
	/****** FIN SLIDER VOYAGE DETAIL ******/
	
	$('.link-lightbox-ui').click(function(){
		dialog($(this));
		return false;
	});
	jQuery(document).on('click', '.ui-widget-overlay', function(){
		jQuery('.ui-dialog .lightbox-default-ui, .ui-dialog .csc-textpic-imagewrap, .ui-dialog .tx-go-maps-ext').dialog('destroy');
	});

});

jQuery(window).load(function(){	
	resizeImg(jQuery('#list-travel .travel .image'));
	resizeImg(jQuery('#list-news .news .image'));
});

function afterAjaxSubmit(){
	jQuery('input').iCheck();
}

function tooltips(div){
	/** Hover tooltips footer **/
	jQuery(div).hover(function(){
		attrTitle = jQuery(this).find('img').attr('alt');
		jQuery(this).append('<div class="tooltips"><p>'+jQuery(this).find('img').attr('alt')+'</p></div>');
		jQuery(this).find('img').attr('alt', '');
	}, function(){
		jQuery('.tooltips').remove();
		jQuery(this).find('img').attr('alt', attrTitle);
	});
}

function resizeImg(content){
	content.each(function(){
		if(jQuery(this).find('img').width() <= jQuery(this).width()){
			jQuery(this).find('img').css({
				height: "auto",
				width: "100%"
			});
			jQuery(this).find('img').css({
				marginLeft: "0",
				marginTop: -(jQuery(this).find('img').height() - jQuery(this).height())/2 +"px"
			});
		}
		if(jQuery(this).find('img').height() <= jQuery(this).height()){
			jQuery(this).find('img').css({
				width: "auto",
				height: "100%"
			});
			jQuery(this).find('img').css({
				marginTop: "0",
				marginLeft: -(jQuery(this).find('img').width() - jQuery(this).width())/2 +"px"
			});
		}
	});
}

function menu_mobile(){
	/** MENU PRINCIPAL MOBILE **/
	jQuery('#main-menu ul li').each(function(){
		if(jQuery(this).find('>ul').length > 0){
			jQuery(this).addClass('submenu');
		}
	});
	
	jQuery(document).on('click', '.mobile-menu', function(e){
		if(!jQuery('.hover-menu').is(':visible')){
			jQuery(this).addClass('active');
		}
		else{
			jQuery(this).removeClass('active');
		}
		jQuery('.hover-menu').slideToggle('normal');
		jQuery('#main-menu ul li').removeClass('active');
		return false;
	});
		
	jQuery(document).on('click touchend', '#main-menu >ul >li >a', function(e){
		jQuery('#main-menu >ul >li, #main-menu >ul >li >ul >li').removeClass('active');
		
		if(!jQuery(this).find('>ul').is(':visible')){
			jQuery('#main-menu >ul >li >ul, #main-menu >ul >li >ul >li >ul').stop().slideUp('normal');
			jQuery(this).parent().addClass('active');
		}
		jQuery(this).parent().find('>ul').stop().slideToggle('normal', function(){
			 jQuery(this).height("auto");
		});
		
		if(jQuery(this).parent().find('>ul').size() > 0){
			e.preventDefault();
		}
	});
		
	jQuery(document).on('click touchend', '#main-menu >ul >li >ul >li >a', function(e){	
		jQuery('#main-menu >ul >li >ul >li').removeClass('active');

		if(!jQuery(this).find('>ul').is(':visible')){
			jQuery('#main-menu >ul >li >ul >li >ul').stop().slideUp('normal');
			jQuery(this).parent().addClass('active');
		}
		jQuery(this).parent().find('>ul').stop().slideToggle('normal', function(){
			 jQuery(this).height("auto");
		});
		
		if(jQuery(this).parent().find('>ul').size() > 0){
			e.preventDefault();
		}
	});
}


function dialog(div){
	if($('.ui-dialog').is(':visible')){$('.lightbox').addClass('hidden');}
	if($('.ui-widget-overlay')){$('.ui-widget-overlay').hide();}
	$('#'+div.attr('data-dialog')).removeClass('hidden');
	$('#'+div.attr('data-dialog')).dialog({
		modal: true,
		autoOpen: true,
		resizable: false,
		draggable: false,
        show: { effect: "fadeIn", duration: 200 }
	});
     return false;
}

function dialogFullScreen(link, target){
	jQuery('body').append(jQuery('#'+target));
	jQuery('#'+target).addClass('loading');
	jQuery(window).load(function(){
		jQuery(link).animatedModal({
			modalTarget:target,
			animatedIn:'lightSpeedIn',
			animatedOut:'lightSpeedOut',
			color:'#0f4a71',
			beforeOpen: function() {
			},
			afterClose: function() {
			}
		});
		jQuery('#'+target).removeClass('loading');
	});
}

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}     

function limitText(div, number){
	div.each(function(){
		$(this).text(function(index, currentText) {
			if(currentText.length > number){
				return currentText.substr(0, number)+" ...";
			}
		});
	});
}


function addCalendarEvent(date) {
	$('.block-datepicker').datepicker("setDate", date );
}