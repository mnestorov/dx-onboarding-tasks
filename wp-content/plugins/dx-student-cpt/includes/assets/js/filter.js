jQuery(document).ready(function($) {
    $('#filters_checkbox').on('click', function () {
        let postData = {
            action: 'enable_filters',
            is_checked: $('#filters_checkbox').is(":checked") ? 'checked' : ''
        }
        $.ajax({
            type: "POST",
            data: postData,
            dataType: "json",
            url: enabled_filters_object.enabled_filters_url,
        })
    })
});