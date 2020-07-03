/**
 * Parses the data attributes and returns the data list that already sorted
 * 
 * API
 * @param {String} fromTitle 
 * @param {Boolean} isBackway 
 * @return {Array}
 */
function getDatesList(isBackway, fromTitle) {
	var events  = [];

	if(isBackway === false) {
		$('.aller_arr-option').each(function() {
			events.push( { Date: new Date($(this).attr('data-time')) } );
		});
	} else {
		$('.retour_arr-option').each(function() {
			events.push( { Date: new Date($(this).attr('data-time')) } );
		});	
	}

	return getSortedDates(events);
}


/**
 *  Returns invalid dates from array 
 * 
 * @param {Array} dates 
 * @return {Array}
 */
function removeInvalidDates(dates) {
	var currentDate = new Date();

 	for( var i = 0; i < dates.length; ++i) {
 		
 		if ( isNaN(dates[i].Date.getFullYear()) === true ) {
 			dates.splice(i,1);
 		}
 	}
 	return dates;
}


/**
 *  Returns the sorted dates list and removes the invalid dates from array
 * 
 * @param {Array} unsorted 
 * @return {Array}
 */
function getSortedDates(unsorted) {
	
	if( unsorted.length > 0) {
		unsorted.sort(function(a,b) { 
			return new Date(a.Date) - new Date(b.Date);
		});
	}
	return removeInvalidDates(unsorted);
}