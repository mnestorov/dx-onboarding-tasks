jQuery(document).ready(function($) {
    $('#search').on( 'click', function() {
        let url = $('#remote_url').val();
        let duration = $('#cache_duration').val();
        let postData = { 
            'remote_url' : url, 
            'transient_duration': duration,
            'action' : 'dx_get_remote_url'
        }
        $.ajax({
            type: "POST",
            data: postData,
            dataType: "json",
            url: main_object.main_url
        }).success(function(response) {
            $('#output').html(response.data);
        });
    });
});