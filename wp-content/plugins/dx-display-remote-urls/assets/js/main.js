jQuery(document).ready(function($) {
    $('#search').on( 'click', function() {
        let url = $('#remote_url').val();
        let duration = $('#cache_duration').val();
        $.post( 
            main_object.main_url, { 
                data : { 
                    'remote_url' : url, 
                    'transient_duration': duration 
                }, 
                action : 'dx_display_input_url' 
            },
            function(status) {
                $('#output').html(status);
            });
    });
});