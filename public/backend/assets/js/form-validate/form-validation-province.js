var FormProvinceValidation = function() {

    var handleProvinceValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var provinceForm = $('#provinceForm');
        var errorProvince = $('.alert-danger', provinceForm);
        var successProvince = $('.alert-success', provinceForm);

        provinceForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                description: {
                    required: true
                },
                code: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                description: {
                    required: "Por favor ingrese el nombre de la provincia"
                },
                code: {
                    required: "Por favor ingrese el código de la provincia",
                    digits: "Por favor ingrese un código de provincia válido"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successProvince.hide();
                errorProvince.show();
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
                successProvince.show();
                errorProvince.hide();
                var laddaProvinceBtn = Ladda.create(document.querySelector('#provinceBtn'));
                laddaProvinceBtn.start();
                laddaProvinceBtn.setProgress(0-1);
                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function(){
                      laddaProvinceBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                        renderSection(urlProvincesList);
                      }else{
                        swal({
                              title: 'BlaudCMS :: Provincias',
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
                      laddaProvinceBtn.stop();
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
                              title: 'BlaudCMS :: Provincias',
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
                      laddaProvinceBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleProvinceValidation();
        }
    };
}();

$(document).ready(function() {
    FormProvinceValidation.init();
});