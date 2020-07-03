function updateBackWayCalendar() {
	var events = getDatesList(true, toCity);

	if (events.length === 0 ) {
		return;
	}

	initCalendar(1, events);
	// $('#to-date').html(events[0].Date.getDate() + ' ' + monthList[events[0].Date.getMonth()] + ' ' + events[0].Date.getFullYear());
}


/**
 * Creates and inits calendar
 * 
 * @param {bool} isBackwayCalendar  If set, inits the backway calendar
 * @param {array} events Contains all the event dates 
 * @return void
 */
function initCalendar(isBackwayCalendar, events) {

	var container = $('.aller-datepicker'),
		from      = typeof fromCity === 'undefined' ? '' : fromCity,
		to        = typeof toCity === 'undefined' ? '' : toCity;
	if (isBackwayCalendar) {
		container = $('.retour-datepicker');	
	}

	$(container).datepicker( "destroy" );
	jQuery(container).datepicker({
		autoSize: true,
		dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
		dayNamesMin: [ "D", "L", "M", "M", "J", "V", "S" ],
		monthNames: monthList,
		monthNamesShort: [ "Jan", "Fev", "Mar", "Avr", "Mai", "Jui", "Jui", "Aoû", "Sep", "Oct", "Nov", "Dec" ],
		showOtherMonths: false,
		firstDay: 1,
		dateFormat: 'dd MM yy',
		defaultDate: events.length > 0 ? events[0].Date : '',
		beforeShowDay: function(date) {
			
			var result = [true, '', null];
			var matching = jQuery.grep(events, function(event) {
				return event.Date.valueOf() === date.valueOf();
			});

			if (matching.length) {
				result = [true, 'event', null];
			}
			return result;
			updateHiddenFields();
		},
		onSelect: function(dateText, inst ) {
			var date,
			selectedDate = jQuery('#'+inst.id).datepicker('getDate'),
			i = 0,
			event = [];
			/* Determine if the user clicked an event: */
			while (i < events.length) {
				date = events[i].Date;
				if (selectedDate.valueOf() === date.valueOf()) {
					event.push(events[i]);
				}
				i++;
			}
			if (event.length > 0) {
				for ( k=0; k < event.length; k++ ) {
					jQuery('#'+inst.id).parents('fieldset').find('.info-datepicker .date-datepicker').html(dateText);
				}
				// updatePrice();
				if (isBackwayCalendar) {
					makeAjaxOnDateChanges(to, from, selectedDate.toDateString(),  1);
				$('.aller-departure').selectmenu("refresh");
				} else {
					makeAjaxOnDateChanges(from , to, selectedDate.toDateString(), 0 ); 
					removeAllEventsBefore(dateText, to, from, selectedDate);
				}

			}
			else{
	           swal("Erreur !", "Le jour demandé n'est pas possible", "error");
			}
			updateHiddenFields();
		}
	});
	
	$('.retour-datepicker .ui-state-active').click();
}


/**
 * Disables all dates from backway calendar that are lower, than passed one.
 * 
 * @param {string} date  | new date
 * @return void
 */
function removeAllEventsBefore(date, to, from, dateFormat) {
	if ($('#retour').parent().hasClass('checked') === false ) {
		$( ".retour-datepicker" ).datepicker("option", "minDate", date );
		if(typeof($( ".retour-datepicker .event" ).not('.ui-datepicker-unselectable')[0]) == "undefined"){	
			var newMonth = true;
			$('.retour-datepicker').datepicker("setDate", 'c+1m')	
		}
		else{newMonth = false;}
		
		var year = $( ".retour-datepicker .event" ).not('.ui-datepicker-unselectable')[0].getAttribute('data-year');
		var month = $( ".retour-datepicker .event" ).not('.ui-datepicker-unselectable')[0].getAttribute('data-month');
		//var day = $( ".retour-datepicker .event" ).not('.ui-datepicker-unselectable')[0].innerText;
		var day = $( ".retour-datepicker .event" ).not('.ui-datepicker-unselectable').first().text();
		if(newMonth){
			$( ".retour-datepicker" ).datepicker("setDate", day+' '+monthList[month]+' '+year );
			jQuery('.fieldset-retour .info-datepicker #to-date').html(day+' '+monthList[month]+' '+year);
			makeAjaxOnDateChanges(to, from, $('.retour-datepicker').datepicker("getDate").toDateString(),  1);
		}
		if(new Date(dateFormat).getTime() >= $( ".retour-datepicker" ).datepicker("getDate").getTime() ){
			jQuery('.fieldset-retour .info-datepicker #to-date').html(day+' '+monthList[month]+' '+year);
			$( ".retour-datepicker" ).datepicker("setDate", day+' '+monthList[month]+' '+year );
			makeAjaxOnDateChanges(to, from, $('.retour-datepicker').datepicker("getDate").toDateString(),  1);
		}
	}
}