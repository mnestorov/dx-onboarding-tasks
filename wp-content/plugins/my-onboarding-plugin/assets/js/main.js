jQuery(document).ready(function($) {
    var data = {
        'action': 'mop_enable_filters',
        'is_checked': mop_enabled_filters_object.is_checked
    };

    jQuery.post(mop_enabled_filters_object.mop_enabled_filters_url, data, function(response) {
        $('#mop_filters_checkbox').on('click', function () {
            let postData = {
                action: 'mop_enable_filters',
                is_checked: $('#mop_filters_checkbox').is(":checked") ? 'checked' : ''
            }

            $.ajax({
                type: "POST",
                data: postData,
                dataType: "json",
                url: mop_enabled_filters_object.mop_enabled_filters_url
            })
        })
    });
});