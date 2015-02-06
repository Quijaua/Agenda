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

            $.post(
                quijauaagenda_ajax.ajax_url,
                data,
                function(response) {
                    console.log(response);
                }
            )
        }

    });


})(jQuery);
