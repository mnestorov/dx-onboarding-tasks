/**
 * Asana task: https://app.asana.com/0/1201345304239951/1201345383459199/f
 */

jQuery(document).ready(function($) {
    $('#dx_filters_checkbox').on('click', function () {
        let postData = {
            action: 'dx_enable_filters',
            is_checked: $('#dx_filters_checkbox').is(":checked") ? 'checked' : ''
        }
        $.ajax({
            type: "POST",
            data: postData,
            dataType: "json",
            url: dx_enabled_filters_object.dx_enabled_filters_url
        })
    })
});