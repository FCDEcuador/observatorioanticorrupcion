var FormCaseStageDetailValidation = function() {

    var handleCaseStageDetailValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var caseStageDetailForm = $('#caseStageDetailForm');
        var errorCaseStageDetail = $('.alert-danger', caseStageDetailForm);
        var successCaseStageDetail = $('.alert-success', caseStageDetailForm);

        caseStageDetailForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                description: {
                    required: true
                },
                catalogue_id: {
                    required: true
                }
            },
            messages: {
                description: {
                    required: "Por favor ingrese el nombre de la etapa del caso"
                },
                catalogue_id: {
                    required: "Por favor seleccione la etapa actual del caso"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successCaseStageDetail.hide();
                errorCaseStageDetail.show();
            },

            errorPlacement: function(error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-danger'); // set error class to the control group
                $(element)
                    .closest('.form-control').addClass('form-control-danger'); // set error class to the control group
            },

            unhighlight: function(element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-danger'); // set error class to the control group
                $(element)
                    .closest('.form-control').removeClass('form-control-danger'); // set error class to the control group
            },

            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-danger'); // set success class to the control group
                label
                    .closest('.form-control').removeClass('form-control-danger'); // set success class to the control group
            },

            submitHandler: function(form) {
                successCaseStageDetail.show();
                errorCaseStageDetail.hide();
                var laddaCaseStageDetailBtn = Ladda.create(document.querySelector('#caseStageDetailBtn'));
                laddaCaseStageDetailBtn.start();
                laddaCaseStageDetailBtn.setProgress(0-1);
                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function(){
                      laddaCaseStageDetailBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                        renderSection(urlCaseStageDetailsList);
                      }else{
                        swal({
                              title: 'BlaudCMS :: Etapas del Caso',
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
                            }
                        );
                      }
                      laddaCaseStageDetailBtn.stop();
                    },
                    error: function(errors){
                      var resp = '';
                      var errorsHtml = '';
                      var errors = errors.responseJSON;
                      $.each(errors.errors, function (key, value) {
                        errorsHtml += '\n'+value;
                      });
                      if(errorsHtml != ''){
                        resp = 'Ups! no se pudo actualizar la informacion debido a los siguientes errores: '+errorsHtml;
                      }else{
                        resp = 'Ups! parece que de momento el sistema no está disponible, por favor intentalo nuevamente en unos minutos.';
                      }
                      swal({
                              title: 'BlaudCMS :: Etapas del Caso',
                              text: resp,
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
                            }
                        );
                      laddaCaseStageDetailBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleCaseStageDetailValidation();
        }
    };
}();

$(document).ready(function() {
    FormCaseStageDetailValidation.init();
    $(".select2").select2();
});