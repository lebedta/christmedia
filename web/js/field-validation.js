function call_error_message (message, obj) {
    if (obj) {
        obj.find('.custom_error_list').remove();
        obj.append(get_error_template(message));
        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
    } else {
    }
}

function get_error_template (message) {
    return '<ul class="custom_error_list special-list-position"><li onclick="jQuery(this).parent().remove();"><em></em>'+message+'</li></ul>';
}