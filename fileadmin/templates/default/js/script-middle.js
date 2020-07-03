$(document).ready(function(){
	$('#middle-office-list .bt-save').click(function(e){
		//récupération des données
		$('#edit-placeMax input[name="tx_tours_vojage[placeMax]"] ').val($(this).parents('tr').find('input[name="tx_tours_vojage[placeMax]"]').val());
		$('#edit-placeMax .list-voyages').remove();
		$(this).parents('tr').find('.list-voyages').clone().appendTo('#edit-placeMax');
		
		$('#edit-placeMax').submit();

        return false;
	});
	
	$('#edit-placeMax').submit(function(e){
		e.preventDefault();
		
		//on affiche le loader
		//initLoaderWithImage();
		
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
                            
                                swal({
                                    title: "Enregistré!",
                                    text : "La modification a été prise en compte !", 
                                    type : "success",
                                },
                                function(){
                                    location.reload();
                                });
                            }else{
                                swal("Erreur !", result['msg'], "error");
                            }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                            swal("Erreur !", "Une erreur s'est produite !", "error");

                            //on supprime le loader
                            //removeLoader();
//console.log("passe dans le error ==>"+textStatus+" "+errorThrown);
                    }
        });
		
		return false;
	});
	
	$('#middle-office-list .bt-delete').click(function(e){
		//récupération des données
		$('#delete-voyage .list-voyages').remove();
		$(this).parents('tr').find('.list-voyages').clone().appendTo('#delete-voyage');
		
		$('#delete-voyage').submit();

        return false;
	});
	
	$('#delete-voyage').submit(function(e){
		e.preventDefault();
		
		//on affiche le loader
		//initLoaderWithImage();
		
		//appel ajax
                var postData = $(this).serializeArray();
                var formURL = $(this).attr("action");

                swal(
                        {
                            title: "Êtes-vous sûr ?",   
                            text: "Vous allez supprimer ce voyage !",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonText: "Oui, je veux !",   
                            cancelButtonText: "Annuler",   
                            closeOnConfirm: false 
                        }, 
                        function(){
                                $.ajax({
                                        type: "POST",
                                        url: formURL,
                                        dataType: 'json',
                                        data: postData,
                                        success: function(result) {
                                                //on supprime le loader
                                                //removeLoader();

                                                if(result['status'] == 'ok'){

                                                        swal({
                                                                title: "Supprimé !",
                                                                text : "Le voyage a été supprimé !", 
                                                                type : "success",
                                                        },
                                                        function(){
                                                                location.reload();
                                                        });
                                                }else{
                                                        swal("Erreur !", result['msg'], "error");
                                                }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown)
                                        {
                                                swal("Erreur !", "Une erreur s'est produite !", "error");

                                                //on supprime le loader
                                                //removeLoader();
    //console.log("passe dans le error ==>"+textStatus+" "+errorThrown);
                                        }
                                });
                        }
                );

            return false;
	});

	$('#middle-office-list .bt-hidden').click(function(e){
		//récupération des données
		$('#hidden-voyage .list-voyages').remove();
		$(this).parents('tr').find('.list-voyages').clone().appendTo('#hidden-voyage');
		
		$('#hidden-voyage').submit();

        return false;
	});
	
	$('#hidden-voyage').submit(function(e){
		e.preventDefault();
		
		//on affiche le loader
		//initLoaderWithImage();
		
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

									swal({
											title: "Caché !",
											text : "Le voyage a été caché !", 
											type : "success",
									},
									function(){
											location.reload();
									});
							}else{
									swal("Erreur !", result['msg'], "error");
							}
					},
					error: function(jqXHR, textStatus, errorThrown)
					{
							swal("Erreur !", "Une erreur s'est produite !", "error");

							//on supprime le loader
							//removeLoader();
//console.log("passe dans le error ==>"+textStatus+" "+errorThrown);
					}
			});

            return false;
	});
	
	$('#middle-office-list .bt-show').click(function(e){
		//récupération des données
		$('#show-voyage .list-voyages').remove();
		$(this).parents('tr').find('.list-voyages').clone().appendTo('#show-voyage');
		
		$('#show-voyage').submit();

        return false;
	});
	
	$('#show-voyage').submit(function(e){
		e.preventDefault();
		
		//on affiche le loader
		//initLoaderWithImage();
		
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

									swal({
											title: "Affiché !",
											text : "Le voyage est maintenant affiché !", 
											type : "success",
									},
									function(){
											location.reload();
									});
							}else{
									swal("Erreur !", result['msg'], "error");
							}
					},
					error: function(jqXHR, textStatus, errorThrown)
					{
							swal("Erreur !", "Une erreur s'est produite !", "error");

							//on supprime le loader
							//removeLoader();
//console.log("passe dans le error ==>"+textStatus+" "+errorThrown);
					}
			});

            return false;
	});
        
	$('#middle-office-list .bt-print').click(function(e){
		//récupération des données
		$('#export-resa .list-voyages').remove();
		$(this).parents('tr').find('.list-voyages').clone().appendTo('#export-resa');
		
		$('#export-resa').submit();

        return false;
	});
	
	/*$('#export-resa').submit(function(e){
		e.preventDefault();
		
		//on affiche le loader
		//initLoaderWithImage();
		
		//appel ajax
                var postData = $(this).serializeArray();
                var formURL = $(this).attr("action");

                $.ajax({
                        type: "POST",
                        url: formURL,
                        dataType: 'text/csv',
                        data: postData,
                        success: function(result) {
                                //on supprime le loader
                                //removeLoader();

                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                                swal("Erreur !", "Une erreur s'est produite !", "error");

                                //on supprime le loader
                                //removeLoader();
//console.log("passe dans le error ==>"+textStatus+" "+errorThrown);
                        }
                });

            return false;
	});//*/
});