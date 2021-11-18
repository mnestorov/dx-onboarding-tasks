/**
 * Asana task: https://app.asana.com/0/1201345304239951/1201345383490682/f
 */

$ = jQuery;

function setOutputField(value) {
    document.getElementById('output').innerHTML = value;
}

function setHtmlOutputIframe(value) {
    document.getElementById('output-frame').srcdoc = value;
}

function showUrlInput() {
    let data = {
        'action': 'displayInputUrl',
        'dataType': 'JSON',
        'url': document.getElementById('remote_url').value,
    };

    $.post(
        ajaxurl, 
        data, 
        function(response) {
            setHtmlOutputIframe(response);
        }
    );
}

function loadCachedHtml() {
    let data = {
        'action': 'displayCachedHtml',
        'dataType': 'JSON'
    };

    $.post(ajaxurl, data, function(response) {
        setHtmlOutputIframe(response);
        console.log(window.location.href);
    });
}

/* if (!window.location.href.localeCompare('http://wptest2.local/wp-admin/admin.php?page=display-remote-urls%2Fsanitized-links-admin.php')) {
    loadCachedHtml();
} */