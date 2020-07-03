var keepStandart = true; 


$( document ).ready(function() {
	// makeAjax( $('.from-group input:checked').attr('id'));

	// $('input').on('ifChecked', function(event){
 //  		if ($(this).hasClass('from-city')) {
 //  			makeAjax($(this).attr('id'));
 //  			keepStandart = false;
 //  		}
	// });

});

/**
 * Updates the hidden fields that we need on the next step [ first step ]
 * 
 * @return void
 */	
function updateHidden() {
	var from = $( "input[name='depart']:checked" ).attr('id'),
        to   = $( "input[name='arrive']:checked" ).attr('id');

	$('#tx_tours_vojage_from-place').val(from);
	$('#tx_tours_vojage_to-place').val( to.replace('arrive-','') );
	localStorage.departureLocation =  $('#ajax-container .checked').siblings('label').text();
}

/**
 * Makes ajax request with from city parameter
 * 
 * @more Ajax responce contains the array with cities that has related to passed parameter
 * @return void
 */	
function makeAjax(fromCity) {
	var request = $.ajax({
		url: _url,                // The url has been set in the ' Vojage/List' template
		type: 'POST',
		data: { 'from' : fromCity},
		dataType: 'html'
	});

	request.done(function(response) {
		var result = $.parseJSON(response);

		var to, toCityOnly, isExist, destinationList = [];

		$.each(result, function(uid, object) {
			$.each(object, function(key, value) {
				if (key === '_to') {   // Responce has a lot of different fields, we need only 'to' value
					to = value;
				}
			});

			isExist = $.inArray(to, destinationList); // Extract value only if we have not extracted it before
			if (isExist == -1 ) {
				destinationList.push(to);
			}
		});

		buildDestinationsByAjaxResponce(destinationList);

	});
}

/**
 * Creates the destination list options 
 * 
 * @param {Array} destinationList [ contains the titles of the destination cities ]
 * @return void
 */	
function buildDestinationsByAjaxResponce(destinationList) {
	var container = $('#ajax-container'),
		departureLocation = localStorage.departureLocation === null ? '' : localStorage.departureLocation;
		container.empty();

	$.each(destinationList, function(index, toCity) {
		if (typeof departureLocation !== 'undefined' && departureLocation.length > 0 && keepStandart !== false ) {
			if (departureLocation === toCity ) {
				container.append(buildActiveDestinationOption(toCity));
			} else {
				container.append(buildNormalDestinationOption(toCity));
			}

		} else {
			if (index === 0) {
				container.append(buildActiveDestinationOption(toCity));
			} else {
				container.append(buildNormalDestinationOption(toCity));
			}
		}

	});

	$('#ajax-container input').iCheck();

	if (!$('#ajax-container .iradio').hasClass('checked')) {
		$('#ajax-container .iradio').first().find('input').prop('checked', true);
		$('#ajax-container input').iCheck();
	}
}

/**
 * Returns the standart destination option
 * 
 * @param {String} toCity
 * @return void
 */	
function buildNormalDestinationOption(toCity) { 
	var option = '<div class="input-radio">' +
					'<input type="radio" class="to-city" name="arrive" id="arrive-' + toCity + '" />' +
					'<label for="arrive-' + toCity + '">' + toCity + '</label>' +
				'</div>';

	return option;
}

/**
 * Returns the active destination option
 * 
 * @param {String} toCity
 * @return void
 */	
function buildActiveDestinationOption(toCity) { 
	var option = '<div class="input-radio">' +
					'<input checked type="radio" class="to-city" name="arrive" id="arrive-' + toCity + '" />' +
					'<label for="arrive-' + toCity + '">' + toCity + '</label>' +
				'</div>';

	return option;
}