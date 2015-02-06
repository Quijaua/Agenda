var clndr = {};
moment.locale("pt-br");
(function($){
    $('#evt_date').mask('99/99/9999');
    $('#evt_time').mask('99:99');
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
                        $('#frm-agenda')[0].reset();
                        return;
                    }
                    swal("Oops...", "Ocorreu um erro ao enviar o evento. Por favor, tente novamente.", "error");
                    return;
                });
        }

    });

    clndr.passInATemplate = $('#pass-in-a-template').clndr({
        template: $('#clndr-template').html(),
        events: quijauaagenda_ajax.events,
         clickEvents: {
          click: function(target) {
            if(target.events.length) {
              var daysContainer = $('#mini-clndr').find('.days-container');
              daysContainer.toggleClass('show-events', true);
              $('#mini-clndr').find('.x-button').click( function() {
                daysContainer.toggleClass('show-events', false);
              });
            }
          }
        },
        adjacentDaysChangeMonth: true,
    });

})(jQuery);
