function loadCorruptionCase(caseDetailUrl){
	$.ajax({
        type: 'GET',
        url: caseDetailUrl,
        dataType: 'json',
        beforeSend: function(){

        },
        success: function (data) {
          	if(data.status === true){
          		var oCorruptionCase = data.oCorruptionCase;
				      $('#corruptionCaseImg').html('<img class=\'d-block w-100 h-100\' src=\''+oCorruptionCase.main_multimedia+'\' alt=\''+oCorruptionCase.title+'\'>');
				      $('#corruptionCaseTitle').html(oCorruptionCase.title);
				      $('#corruptionCaseSummary').html(oCorruptionCase.summary);
				      $('#corruptionCaseCaseStage').html(oCorruptionCase.case_stage);
				      $('#corruptionCaseCaseStageDetail').html(oCorruptionCase.case_stage_detail);
				      $('#corruptionCaseInvolvedNumber').html(oCorruptionCase.involved_number + ' personas');
				      $('#corruptionCasePeriod').html(oCorruptionCase.period);
				      $('#corruptionCaseStateFunction').html(oCorruptionCase.state_function);
				      $('#corruptionCaseProvince').html(oCorruptionCase.province);
				      $('#corruptionCaseUrl').html('<a href=\''+oCorruptionCase.url+'\' role=\'button\' class=\'btn btn-info btn-sm\'>¿Quieres conocer más?</a>');
				
				      var linkedInstitutionsCmb = $('#corruptionCaseLinkedInstitutions');
				      linkedInstitutionsCmb.empty();
				      $.each(oCorruptionCase.linked_institutions, function(index, linkedInstitution){
                linkedInstitutionsCmb.append('<option>'+linkedInstitution+'</option>');
				      });

				      var publicOfficialsInvolvedCmb = $('#corruptionCasePublicOfficialsInvolved');
				      publicOfficialsInvolvedCmb.empty();
				      $.each(oCorruptionCase.public_officials_involved, function(index, publicOfficialInvolved){
                publicOfficialsInvolvedCmb.append('<option>'+publicOfficialInvolved+'</option>');
				      });
          	}else{
            	swal({
	            	title: 'Casos de Corrupción',
	              	text: data.message,
	              	type: 'error',
	              	allowOutsideClick: true,
	              	showConfirmButton: true,
	              	showCancelButton: false,
	              	confirmButtonClass: 'text-danger',
	              	cancelButtonClass: '',
	              	closeOnConfirm: true,
	              	closeOnCancel: true,
	              	confirmButtonText: 'OK',
	              	cancelButtonText: '',
	            });
          	}
        },
        error: function(errors){
          	swal({
            	title: 'Casos de Corrupción',
              	text: 'El sistema no está disponible en estos momentos o se encuentra en mantenimiento, por favor intentelo nuevamente luego de unos minutos.',
              	type: 'error',
              	allowOutsideClick: true,
              	showConfirmButton: true,
              	showCancelButton: false,
              	confirmButtonClass: 'text-danger',
              	cancelButtonClass: '',
              	closeOnConfirm: true,
              	closeOnCancel: true,
              	confirmButtonText: 'OK',
              	cancelButtonText: '',
            });
        }
    });
}

function showAlert(title, message, type){
    swal({   
        title: title,   
        text: message,   
        type: type,
        confirmButtonText: 'OK',   
        closeOnConfirm: true 
    });
}