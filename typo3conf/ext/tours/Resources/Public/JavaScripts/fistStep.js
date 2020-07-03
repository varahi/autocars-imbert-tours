var monthList = [ "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre" ];
var monthShort = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
var dayList = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];


$( document ).ready(function() {
	var events = getDatesList(false, '');

	if ( $('.retour option').length === 0 ) {
		$('.fieldset-retour').hide();
	}
 
	$('#booking-step1').submit(function(){
		updateHiddenFields();
	});

	$( "#toTheSecondStep" ).click(function(e) {
		updatePrice();

		var price = parseInt($('#tx_tours_vojage_price').val());

		if ( price <= 0 ) {
			e.preventDefault();

			if ($('#nb-adu').text().length === 0 ) {
				$('#nb-adu').attr('style', 'border: solid 2px red').focus();
			}
		} 

	});

	//on laisse le bloc réservation même pour un trajet simple vu avec Corinne le 01/08/2017 par téléphone
	//au final trop complexe de créer un nouveau bloc pour le trajet simple, surtout que le bloc orange fait redondance avec les listes déroulantes
	//du coup on le cache pour le trajet simple
	if ( typeof fromCity !=='undefined' && fromCity === 'all') {
		$('#block-reservation').css('display', 'none');
	}//*/


	$('#retour').on('ifChecked', function(event){
		var href = $(this).parents('a').attr('href');
		window.open(href, '_self');
	});
	$('#aller-retour').on('ifChecked', function(event){
		/*var href = $(this).parents('a').attr('href');
		window.open(href, '_self');*/
		  			updateHidden();
		  			$( "#reservation-form" ).submit();
	});


	$("#toTheSecondStep").click(function(){
    		//Options fields
		$('#tx_tours_vojage_from--option').val($('.aller option:selected').text());
		$('#tx_tours_vojage_from--option-2').val( $('.aller-departure option:selected').text() );
		$('#tx_tours_vojage_to--option').val( $('.retour option:selected').eq(0).text() );
		$('#tx_tours_vojage_to--option-2').val( $('.retour option:selected').eq(1).text() );
	});



	$("#nb-adu").focusout(function(){
    	$(this).attr('style', '');
	});

	initCalendar(0, events);

	if ( events.length > 0) {

		var firstCalendarDate = dayList[events[0].Date.getDay()] + ' ' + monthShort[events[0].Date.getMonth()] + ' ' + events[0].Date.getDate() + ' ' + events[0].Date.getFullYear();
		$('#from-date').html(events[0].Date.getDate() + ' ' + monthList[events[0].Date.getMonth()] + ' ' + events[0].Date.getFullYear());
		
		setTimeout(function() {
			makeAjaxOnDateChanges( fromCity , toCity, firstCalendarDate);
			// setTimeout(function() { findDestinationByArea(1, $('select[name="aller_from_location"] option').first().attr('data-uid')); }, 1000);
			updateBackWayCalendar();

			restoreStateAfterBackAction();
		}, 1000);


		setTimeout(function() {
			$(".aller-departure option").each( function(){
				 var $option = $(this);  

				 $option.siblings()
				        .filter( function(){ return $(this).val() == $option.val() } )
				        .remove()
			});
			$('.aller-departure').selectmenu("refresh");

			$('.retour').not('[name="retour_from_location"]').find('option').each( function(){
				 var $option = $(this);  

				 $option.siblings()
				        .filter( function(){ return $(this).val() == $option.val() } )
				        .remove()
			});
			$('.retour').not('[name="retour_from_location"]').selectmenu("refresh");


			}, 5500);

	}
    
	//jQuery('.lightbox-default-ui .block-datepicker').datepicker('destroy');
	jQuery('.lightbox-default-ui .block-datepicker').datepicker({
		autoSize: true,
		dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
		dayNamesMin: [ "D", "L", "M", "M", "J", "V", "S" ],
		monthNames: monthList,
		monthNamesShort: [ "Jan", "Fev", "Mar", "Avr", "Mai", "Jui", "Jui", "Aoû", "Sep", "Oct", "Nov", "Dec" ],
		showOtherMonths: false,
		firstDay: 1,
		dateFormat: 'dd MM yy',
		defaultDate: events.length > 0 ? events[0].Date : '',
		onSelect: function(dateText, inst ) {
			var d = new Date($(this).datepicker('getDate'));
			var newDate = $.datepicker.formatDate("yy-mm-dd", d);
			
			$(this).parent('div').find('.text-datepicker').html(dateText);
			$(this).parent('div').find('input[type=hidden]').val(newDate);
			
			if($(this).parents('.block-add-voyage').is(':first-child')){
				jQuery('.lightbox-default-ui .block-add-voyage').find('.text-datepicker').html(dateText);
				jQuery('.lightbox-default-ui .block-add-voyage').find('input[type=hidden]').val(newDate);
				jQuery('.lightbox-default-ui .block-add-voyage').find('.block-datepicker').datepicker("setDate", d);
			}
		}
	});
		
        $('.add-datepicker').datepicker({
		autoSize: true,
		dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
		dayNamesMin: [ "D", "L", "M", "M", "J", "V", "S" ],
		monthNames: monthList,
		monthNamesShort: [ "Jan", "Fev", "Mar", "Avr", "Mai", "Jui", "Jui", "Aoû", "Sep", "Oct", "Nov", "Dec" ],
		showOtherMonths: false,
		firstDay: 1,
		dateFormat: 'dd MM yy',
		defaultDate: events.length > 0 ? events[0].Date : '',
		onSelect: function(dateText, inst ) {
			
		},
		onClose: function(dateText, inst ) {
                    var d = new Date($(this).datepicker('getDate'));
                    var newDate = $.datepicker.formatDate("yy-mm-dd", d);
                    
                    $(this).parent('div').find('input[type=hidden]').val(newDate);
		}
	});


});


function restoreStateAfterBackAction() {
	if ( $('.fieldset-transport label').eq(1).siblings().hasClass('checked') && !$('.fieldset-transport label').eq(1).siblings().parent().hasClass('active') ) {
		$('.fieldset-transport label').eq(0).click();
		$('.fieldset-transport label').eq(1).click()
	}

	var fromDate = $('#tx_tours_vojage_from-time').val();

	if ( fromDate.length > 0) {
		$('.aller-datepicker').datepicker("setDate", fromDate);
		$('.aller-datepicker .ui-state-active').click();
	}

	var toDate = $('#tx_tours_vojage_to-time').val();

	if ( toDate.length > 0) {
		$('.retour-datepicker').datepicker("setDate", toDate);
		$('.retour-datepicker .ui-state-active').click();
	}

}

function updateOptionsAfterBackStep() {
	var from1 = $('#tx_tours_vojage_from--option').val();
	if ( from1.length) {
		var to1 = $('#tx_tours_vojage_from--option-2').val();
		var select1 = $('select[name="aller_from_location"] option[name="' + from1 + '"]');
		$(select1).prop('selected', 'selected');
		$('select[name="aller_from_location"]').selectmenu('refresh');
		findDestinationByArea(0, $(select1).attr('data-uid'));

		setTimeout(function() {
			var select2 = $('.fieldset-aller .aller-departure option[name="' + to1 + '"]');
			$(select2).prop('selected', 'selected');

			$('select[name="aller_from_location"]').selectmenu('refresh');

			setTimeout(function() {
				$('.aller-departure').selectmenu('refresh');
				
				$('#tx_tours_vojage_from--option').val("");
				$('#tx_tours_vojage_from--option-2').val("");
				removeOptionsDublicates();
				updatePrice();

			}, 500);
		}, 2000);				

	}

	var from2 = $('#tx_tours_vojage_to--option').val();
	if ( from2.length) {
		var to2 = $('#tx_tours_vojage_to--option-2').val();

		var select3 = $('select[name="retour_from_location"] option[name="' + from2 + '"]');
		$(select3).prop('selected', 'selected');

		$('select[name="retour_from_location"]').selectmenu('refresh');

		findDestinationByArea(1, $(select3).attr('data-uid'));

		setTimeout(function() {
			var select4 = $('.fieldset-retour [name="' + to2 + '"]').first();
			$(select4).prop('selected', 'selected');
			$('select[name="retour_from_location"]').selectmenu('refresh');

			setTimeout(function() {
				$('.retour').selectmenu('refresh');
				$('#tx_tours_vojage_to--option').val("");
				$('#tx_tours_vojage_to--option-2').val("");
				removeOptionsDublicates();
				updatePrice();
			}, 1000);	

		}, 2000);	

	}
}

function removeOptionsDublicates() {
	var exist = {};
	$('select option').each(function() {
	    if (exist[$(this).val()]){
	        $(this).remove();
	    }else{
	        exist[$(this).val()] = true;
	    }
	});
	$('select').selectmenu('refresh');
}


function findDestinationByArea(isBackway, uid) {
	var request = $.ajax({
		url: findDestinationByAreaDateAndArrivalCity,
		type: 'POST',
		data: { 
			'uid': uid,
			'isAll': $('#retour').is(':checked')
	    },
		dataType: 'html'
	});

	request.done(function(response) {
		var result = $.parseJSON(response),
			freshOption,
			title, child, adult, tstamp, city;

			//console.log(result);
			var options = [];
			$.each(result, function(uid, object) {
				$.each(object, function(key, value) {
					if (key === 'title') { 
						title = value;
					} else if (key === 'uid') {
						uid = value;
					} else if( key === 'child') {
						child = value;
					} else if( key === 'adult') {
						adult = value;
					} else if( key === 'tstamp') {
						tstamp = value;
					}else if( key === 'city') {
						city = value;
					}
				});

			var theCity = isBackway ? fromCity : toCity;
			var fromPrefix = title.lastIndexOf(theCity) === -1 ? theCity + ' - ' : '';

			options.push( 
				{ 
					'title': title, 
					'uid':   uid,
					'child': child,
					'adult': adult,
					'tstamp': tstamp,
					'city': city,
					'isBackway': isBackway
				}
			);
		});

		$.each(options, function() {
			freshOption = $("<option></option>");
			freshOption.attr("value", this.title).text(this.title).attr('name', this.title).addClass('aller_arr-option').attr('data-uid', this.uid).attr('data-adult-price', this.adult).attr('data-child-price', this.child).attr('data-tstamp', this.tstamp).attr('data-city', this.city);
			if (this.isBackway) {
				// freshOption.attr("value", title).text(title).attr('name', title).addClass('retour_arr-option').attr('data-uid', uid).attr('data-adult-price', adult).attr('data-child-price', child);
				$('.retour').not('[name="retour_from_location"]').append(freshOption);
				freshOption.each(function(){
					if($(this).attr('data-city') == $('select[name="aller_from_location"] option:selected').attr('data-city')){
						$('select[name="retour_to_location"]').val($(this).val());
					}
				});
				$('.retour').selectmenu('refresh');
			} else {
				$('.aller-departure').append(freshOption);
				$('select[name="retour_from_location"] option').each(function(){
					if($(this).attr('data-city') == $('select[name="aller-departure_to_location"] option:selected').attr('data-city')){
						$('select[name="retour_from_location"]').val($(this).val());
					}
				});
				$('.aller-departure').selectmenu('refresh'); 
				if($('.fieldset-retour').is(':visible')){
					$('select[name="retour_from_location"]').selectmenu('refresh'); //ça plante sur le trajet simple
				}
			}

		});
		updateHiddenFields();

	});
}

/**
 * Makes ajax request
 * 
 * @return void
 */	
function makeAjaxOnDateChanges(fromCity, toCity, tstamp, isBackway) {
	//console.log(fromCity+" : "+toCity+" : "+tstamp+" : "+isBackway);
	var request = $.ajax({
		url: filterByDate,
		type: 'POST',
		data: { 
			'from'   : fromCity,
            'to'     : toCity,
            'tstamp' : tstamp 
	    },
		dataType: 'html'
	});

	request.done(function(response) {
		var result = $.parseJSON(response),
			title, uid, child, adult, time, city,
			options = [];
			//console.log(response);
		$.each(result, function(uid, object) {
			$.each(object, function(key, value) {
				if (key === 'title') { 
					title = value;
				} else if( key === 'uid') {
					uid = value;
				} else if( key === 'time') {
					time = value;
				} else if( key === 'city') {
					city = value;
				}
			});
			options.push( 
				{ 
					'title' : title, 
					'uid': uid,
					'city': city,
					'time': time
				}
			);

		});
		updateOptions(isBackway, options);
		updateOptionsAfterBackStep();
		
		if ( $('#tx_tours_vojage_from--option').val().length === 0 ) {
			if (isBackway) {
				$('.retour').first().find('option').first().attr('selected', 'selected');
				$('.retour').first().selectmenu("refresh");
				$('.fieldset-retour .ui-menu-item').first().click();
			} else {
				$('.aller').first().find('option').first().attr('selected', 'selected');
				setTimeout(function() {
					$('.aller').first().selectmenu("refresh");
					$('.fieldset-aller .ui-menu-item').first().click();
				}, 500);	
			}

			

		}

	});

}

function updateOptions(isBackway, newOptions) {
	var container = $('select[name="aller_from_location"]');

	if (isBackway) {
		container = $('select[name="retour_from_location"]'); 
	}
	updateOptionsInContainer(isBackway, container, newOptions );

}

function updateOptionsInContainer(isBackway, container, options) {
	var freshOption;
	
	destroyOptionsAndCreateFresh(isBackway, container);
	$.each(options, function() {
		freshOption = $("<option></option>");

		var theCity = isBackway ? toCity : fromCity;
		var fromPrefix = this.title.lastIndexOf(theCity) == -1 ? theCity + ' - ' : '';

		if (theCity === 'all') {
			fromPrefix = '';
		}
		freshOption.attr("value", fromPrefix + this.title).text( fromPrefix + this.title).attr('name', fromPrefix + this.title).attr('data-uid', this.uid).attr('data-city', fromPrefix + this.city);
		$(container).append(freshOption);
	});
}


function destroyOptionsAndCreateFresh(isBackway, container) {
	$(container).find('option').remove();
	$(container).parents('.fieldset-aller').find('.aller_arr-option').remove();
	//$('.aller_arr-option').remove();
	if (isBackway) {
		$('.retour_departure-option').remove();
	}
	clearToOptions(getToOptionsContainer(isBackway));
	$(container).selectmenu( "destroy" );
	$(container).selectmenu({
		create: function( event, ui ) {
			jQuery(this).after(jQuery('#'+jQuery(this).attr('id')+'-menu').parent());
			updateHiddenFields();
		},
		select: function( event, ui ) {
			var _isBackway = !$(this).is('[name="aller_from_location"]');
			var fromOptionSelected = $('select[name="aller_from_location"] option:selected');
			if($(this).is('[name="aller_from_location"]')){
				toOption = $('select[name="retour_to_location"]');
			} else toOption = '';
			if (_isBackway) {
				fromOptionSelected = $('select[name="retour_from_location"] option:selected');
			}
			var obj = $(this);
			if(toOption != ''){
				toOption.find('option').each(function(){
					if($(this).attr('data-city') == obj.find('option:selected').attr('data-city')){
						toOption.val($(this).val());
						toOption.selectmenu('refresh');
					}
				});
			}
			clearToOptions(getToOptionsContainer(_isBackway));
			findDestinationByArea(_isBackway, $(fromOptionSelected).attr('data-uid'));
			updateHiddenFields();
		}
	});
}

function getToOptionsContainer(isBackway) {
	var toOptionsContainer = $('.aller-departure');

	if (isBackway) {
		toOptionsContainer = $('.retour').not('[name="retour_from_location"]');
	}
	return toOptionsContainer;
}


function clearToOptions(container) {
	$(container).find('option').remove();

	$(container).selectmenu("destroy");
	$(container).selectmenu({
		create: function( event, ui ) {
			jQuery(this).after(jQuery('#'+jQuery(this).attr('id')+'-menu').parent());
			updateHiddenFields();
		},
		select: function( event, ui ) {
			if($(this).is('[name="aller-departure_to_location"]')){
				toOption = $('select[name="retour_from_location"]');
			} else toOption = '';
			var obj = $(this);
			if(toOption != ''){
				toOption.find('option').each(function(){
					if($(this).attr('data-city') == obj.find('option:selected').attr('data-city')){
						toOption.val($(this).val());
						toOption.selectmenu('refresh');
					}
				});
			}
			updatePrice();
			updateHiddenFields();
		}
	});
}


function makeFirstOptionSelected(to) {
	var container   = $('.aller-departure'),
	    firstOption = $('.fieldset-aller .ui-menu-item').first();
	if ( to === true ) {
		container = $('.retour').first();
		firstOption = $('.fieldset-retour .ui-menu-item').first();
	}

	firstOption.click();
	$(container).find('option').first().attr('selected', 'selected');
	$(container).selectmenu("refresh");
}

/**
 * Sets the hidden fields
 * 
 * @more Calls anytime when 'toTheNextStep' button has been triggered
 * @return void
 */
function updateHiddenFields() {
    setTimeout(function(){
		$('#tx_tours_vojage_from-time').val($('.fieldset-aller .date-datepicker').text());

		if($('.aller option:selected')){
			var eventHour = $('.aller option:selected').text();
		}
		else{
			var eventHour = $('.aller option:first-child').text();
		}
		eventHour = eventHour.substr(eventHour.lastIndexOf('-') + 2);

		if($('.retour option:selected')){
			var eventHourBack = $('.retour option:selected').eq(0).text();
		}
		else{
			var eventHourBack = $('.retour option:first-child').eq(0).text();
		}
		
		eventHourBack = eventHourBack.substr(eventHourBack.lastIndexOf('-') + 2);
		
		if($('.aller-departure option:selected')){
			$('#tx_tours_vojage_from-id').val($('.aller-departure option:selected').attr('data-uid'));
		}
		else{
			$('#tx_tours_vojage_from-id').val($('.aller-departure option:first-child').attr('data-uid'));
		}
		
		if($('.aller option:selected')){
			$('#tx_tours_vojage_from-city').val($('.aller option:selected').text().substr(0,$('.aller option:selected').text().lastIndexOf('-')));
		}
		else{
			$('#tx_tours_vojage_from-city').val($('.aller option:first-child').text().substr(0,$('.aller option:first-child').text().lastIndexOf('-')));
		}	
		$('#tx_tours_vojage_from-hour').val(eventHour);
			
		$('#tx_tours_vojage_to-time').val($('.fieldset-retour .date-datepicker').text());
		$('#tx_tours_vojage_to-hour').val(eventHourBack);

		// $('#tx_tours_vojage_price').val($('.bg-orange p ').text());

		//var  fromCity2 = $('.aller-departure option:selected').text();
		var  fromCity2 = $('.aller-departure').parent().find('.ui-selectmenu-button .ui-selectmenu-text').text();
		// $('#tx_tours_vojage_from-city2').val( fromCity2.substr(0, fromCity2.indexOf('-')) );
		//$('#tx_tours_vojage_from-city2').val( $('.fieldset-aller select option:selected').eq(1).text().substr(0,$('.fieldset-aller select option:selected').eq(1).text().lastIndexOf('-')) );
		$('#tx_tours_vojage_from-city2').val( fromCity2.substr(0,fromCity2.lastIndexOf('-')) );
		$('#tx_tours_vojage_from-hour2').val( fromCity2.substr(fromCity2.lastIndexOf('-') + 2) );
		$('#tx_tours_vojage_from-time2').val($('.fieldset-aller .date-datepicker').text());
		// console.log(fromCity2.substr(0,fromCity2.lastIndexOf('-')));
		//var  toCity2 = $('.retour').eq(1).text();
		var  toCity2 = $('.retour').eq(1).parent().find('.ui-selectmenu-button .ui-selectmenu-text').text();
		// $('#tx_tours_vojage_to-city2').val(toCity2.substr(0, toCity2.indexOf('-')) );
		//$('#tx_tours_vojage_to-city2').val($('.fieldset-retour select option:selected').eq(1).text().substr(0,$('.fieldset-retour select option:selected').eq(1).text().lastIndexOf('-')));
		$('#tx_tours_vojage_to-city2').val(toCity2.substr(0,toCity2.lastIndexOf('-')));

		$('#tx_tours_vojage_to-hour2').val( toCity2.substr(toCity2.lastIndexOf('-') + 2));
		$('#tx_tours_vojage_to-time2').val($('.fieldset-retour .date-datepicker').text() );

		if ( !$('#retour').parent().hasClass('checked') ) { 
			if($('.retour[name="retour_to_location"] option:selected')){
				$('#tx_tours_vojage_to-id').val($('.retour[name="retour_to_location"] option:selected').attr('data-uid'));
			}
			else{
				$('#tx_tours_vojage_to-id').val($('.retour[name="retour_to_location"] option:first-child').attr('data-uid'));
			}
			if($('.fieldset-retour select option:selected')){
				$('#tx_tours_vojage_to-city').val( $('.fieldset-retour select option:selected').eq(0).text().substr(0,$('.fieldset-retour select option:selected').eq(0).text().lastIndexOf('-'))  );
			}
			else{
				$('#tx_tours_vojage_to-city').val( $('.fieldset-retour select option:first-child').eq(0).text().substr(0,$('.fieldset-retour select option:first-child').eq(0).text().lastIndexOf('-'))  );
			}
		} else  {
			$('#tx_tours_vojage_to-id').val('');
			$('#tx_tours_vojage_to-city').val('');
		}
	}, 1000);
}

