$( document ).ready(function() {
	//var cbBox   = $('.payment-list li:first'),
        cbInput = $('#submit-etape2');

	//$(cbBox).css('opacity', '0.1');
	cbInput.attr('disabled', 'disabled');

	$('input').on('ifChecked', function(event){
  		if ($(this).attr('id') === 'cdg') {
  			//$(cbBox).css('opacity', '1');
  			cbInput.removeAttr('disabled');
  		}
	});

	$('input').on('ifUnchecked', function(event){
  		if ($(this).attr('id') === 'cdg') {
  			//$(cbBox).css('opacity', '0.1');
  			cbInput.attr('disabled', 'disabled');
  			cbInput.removeAttr('selected');
  		}
	});
        
        $("#booking-step2").submit(function(e){
            e.preventDefault();

            //vérification des champs obligatoires
            if($("#booking-step2 input[name='tx_tours_vojage[newUsers][lastName]']").val()==''){
                swal("Erreur !", "Merci de saisir votre nom !", "error");
                return false;
            }
            if($("#booking-step2 input[name='tx_tours_vojage[newUsers][firstName]']").val()==''){
                swal("Erreur !", "Merci de saisir votre prénom !", "error");
                return false;
            }
            if($("#booking-step2 input[name='tx_tours_vojage[newUsers][email]']").val()==''){
                swal("Erreur !", "Merci de saisir votre email !", "error");
                return false;
            }
            if($("#booking-step2 input[name='tx_tours_vojage[newUsers][telephone]']").val()==''){
                swal("Erreur !", "Merci de saisir votre téléphone !", "error");
                return false;
            }
            if($("#booking-step2 input[name='tx_tours_vojage[newUsers][address]']").val()==''){
                swal("Erreur !", "Merci de saisir votre adresse !", "error");
                return false;
            }
            if($("#booking-step2 input[name='tx_tours_vojage[newUsers][zip]']").val()==''){
                swal("Erreur !", "Merci de saisir votre code postal !", "error");
                return false;
            }
            if($("#booking-step2 input[name='tx_tours_vojage[newUsers][city]']").val()==''){
                swal("Erreur !", "Merci de saisir votre ville !", "error");
                return false;
            }

            //appel ajax
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");

            $.ajax({
                        type: "POST",
                        url: formURL,
                        dataType: 'json',
                        data: postData,
                        success: function(result) {
                                //on supprime le loader
                                //removeLoader();
                                if(result['status'] == 'ok'){
                                    //on met à jour les champs du formulaire de la banque
                                    $("#pay_form").empty();
                                    $("#pay_form").html(result['pay_form']);

                                    //submit vers la banque
                                    $("#pay_form").submit();
                                }else if(result['status'] == 'resa'){
                                    swal({
                                        title: "Enregistré!",
                                        text : "La réservation a été prise en compte !", 
                                        type : "success",
                                    },
                                    function(){
                                        document.location.href=result["url"];
                                    });
                                }else{
                                    vMsg = "Une erreur s'est produite !";
                                    if(result['msg']){
                                        vMsg = result['msg'];
                                    }
                                    swal("Erreur !", vMsg, "error");
                                }

                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                                swal("Erreur !", "Une erreur système s'est produite !", "error");

                                //on supprime le loader
                                //removeLoader();
    //console.log("passe dans le error ==>"+textStatus+" "+errorThrown);
                        }
            });

            return false;
        });
});