(function($){
    $('#frm-agenda').validate({

        submitHandler: function(form) {

            var data = {
                'action'        : 'quijauaagenda_save_event',
                'title'         : $('#title').val(),
                'description'   : $('#description').val(),
                'evt_date'      : $('#evt_date').val(),
                'evt_time'      : $('#evt_time').val(),
                'evt_place'     : $('#evt_place').val(),
            };

            $.ajax({
                type: "POST",
                url: quijauaagenda_ajax.ajax_url,
                data :data,
                dataType : 'json',
            })
                .done(function(response) {
                    if(1 === response.status) {
                        swal("Sucesso", "Evento enviado com sucesso. Aguarde moderação!", "success")
                        return;
                    }
                    swal("Oops...", "Ocorreu um erro ao enviar o evento. Por favor, tente novamente.", "error");
                    return;
                });
        }

    });


})(jQuery);
