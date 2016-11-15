<?php

    /*
     * Function that adds the new Select2 field to the fields list
     * and also the list of fields that skip the meta-name check
     *
     * @since v.1.0.0
     *
     * @param array $fields     - The names of all the fields
     *
     * @return array
     *
     */
    function wppb_sl2_manage_field_types( $fields ) {
        $fields[] = 'Select2';

        return $fields;
    }
    add_filter( 'wppb_manage_fields_types', 'wppb_sl2_manage_field_types' );
    add_filter( 'wppb_skip_check_for_fields', 'wppb_sl2_manage_field_types' );


    /*
     * Function that adds the new Select2 (Multiple) field to the fields list
     * and also the list of fields that skip the meta-name check
     *
     * @since v.1.0.2
     *
     * @param array $fields     - The names of all the fields
     *
     * @return array
     *
     */
    function wppb_sl2m_manage_field_types( $fields ) {
        $fields[] = 'Select2 (Multiple)';

        return $fields;
    }
    add_filter( 'wppb_manage_fields_types', 'wppb_sl2m_manage_field_types' );
    add_filter( 'wppb_skip_check_for_fields', 'wppb_sl2m_manage_field_types' );



    /* Function adds the Select2 (Multiple) option to set a maximum selection size
    *
    * @since v.1.0.2
    *
    * @param array $fields - The current field properties
    *
    * @return array        - The field properties that now include the Select2 (Multiple) Limit field
    *
    */
    function wppb_sl2m_manage_fields( $fields ) {
        $fields[] = array( 'type' => 'text', 'slug' => 'select2-multiple-limit', 'title' => __( 'Maximum selections', 'profile-builder' ), 'description' => __( "Select2 multi-value select boxes can set restrictions regarding the maximum number of options selected.", 'profile-builder' ) );
        return $fields;
    }
    add_filter( 'wppb_manage_fields', 'wppb_sl2m_manage_fields' );
?>