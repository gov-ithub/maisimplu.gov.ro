
/**
 * Function that adds the Select2 field to the global fields object
 * declared in assets/js/jquery-manage-fields-live-change.js
 *
 * @since v.1.0.0
 */
function wppb_sl2_add_field() {
    if (typeof fields == "undefined") {
        return false;
    }
    fields["Select2"] = {
        'show_rows'	:	[
            '.row-field-title',
            '.row-meta-name',
            '.row-description',
            '.row-default-option',
            '.row-required',
            '.row-overwrite-existing',
            '.row-options',
            '.row-labels'
        ]
    };
}


/**
 * Function that adds the Select2 (Multiple) field to the global fields object
 * declared in assets/js/jquery-manage-fields-live-change.js
 *
 * @since v.1.0.2
 */
function wppb_sl2m_add_field() {
    if (typeof fields == "undefined") {
        return false;
    }
    fields["Select2 (Multiple)"] = {
        'show_rows' :   [
            '.row-field-title',
            '.row-meta-name',
            '.row-description',
            '.row-default-options',
            '.row-required',
            '.row-overwrite-existing',
            '.row-options',
            '.row-labels',
            '.row-select2-multiple-limit'
        ]
    };
}


jQuery( function() {
    wppb_sl2_add_field();
    wppb_sl2m_add_field();

    // we need run this again after adding the Email Confirmation field to the global fields object
    wppb_hide_properties_for_already_added_fields( '#container_wppb_manage_fields' );
});
