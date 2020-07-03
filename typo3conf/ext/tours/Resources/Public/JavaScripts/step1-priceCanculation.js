var includeBackway = true;


$( document ).ready(function() {
	// updatePrice();
    
    $( "#nb-adu, #nb-enf" ).change(function() { updatePrice(); });

	$('input').on('ifChecked', function(event){
  		if ( $(this).attr('id') === "aller/retour") {
  			 includeBackway = true;
  		}  else if ( $(this).attr('id') === "retour" ) {
 			includeBackway = false;
  		} 	
  		updatePrice();
	});

});

/**
 * Updates the label content that renders the price [ Shortly saying, updates the price in the cintainer ]
 * 
 * @return void
 */
function updatePrice() {
	var priceResult  = calculatePrice(0),
		backWayPrice = calculatePrice(1);

	if(includeBackway === true && !isNaN(backWayPrice) ) {
		priceResult+= backWayPrice;
	}

	if ( isNaN(priceResult) || priceResult < 0 ) {
		priceResult = 0;
	}
	$('#tx_tours_vojage_price').val(priceResult);
}

/**
 * Calculates the actual price by people count and ticket price
 * 
 * @param {Boolean} isBackway    [ If true calculates both ways ]
 * @return {Number}
 */
function calculatePrice(isBackway) {
	var container = $('.aller_arr-option:selected');

	if (isBackway) {
		container = $('.retour .aller_arr-option:selected');
	}

	var adultPrice    = $(container).attr('data-adult-price'),
	    childPrice    = $(container).attr('data-child-price'),
	    adultsCount   = $('#nb-adu').val(),
	    childrenCount = $('#nb-enf').val();
	return (adultsCount * adultPrice) + (childrenCount * childPrice);
}