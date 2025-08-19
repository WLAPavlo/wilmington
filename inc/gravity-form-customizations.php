<?php
// Display GravityForms fields label if it set to Hidden
function display_gf_fields_label() {
    echo '<style>.hidden_label label.gfield_label{visibility:visible;line-height:inherit;}.theme-overlay .theme-version{display: none;}</style>';
}

add_action( 'admin_head', 'display_gf_fields_label' );

/**
 * Enable GF Honeypot for all forms
 *
 * @param $form
 * @param $is_new
 */
function enable_honeypot_on_new_form_creation( $form, $is_new ) {
    if ( $is_new ) {
        $form['enableHoneypot'] = true;
        $form['is_active']      = 1;
        GFAPI::update_form( $form );
    }
}

add_action( 'gform_after_save_form', 'enable_honeypot_on_new_form_creation', 10, 2 );

/**
 * Disable date field autocomplete popup
 *
 * @param string $input field HTML markup
 * @param object $field GForm field object
 *
 * @return string
 */
function gform_remove_date_autocomplete( $input, $field ) {
    if ( is_admin() ) {
        return $input;
    }
    if ( GFFormsModel::is_html5_enabled() && $field->type == 'date' ) {
        $input = str_replace( '<input', '<input autocomplete="off" ', $input );
    }

    return $input;
}

add_filter( 'gform_field_content', 'gform_remove_date_autocomplete', 11, 2 );

// Prevent page jumping on form submit
add_filter( 'gform_confirmation_anchor', '__return_false' );

// Show Gravity Form field label appearance dropdown
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// Replace standard form input with button
function form_submit_button( $button, $form ) {
    if ( $form['button']['type'] == 'image' && ! empty( $form['button']['imageUrl'] ) ) {
        return $button;
    }

    $button_inner = $form['button']['text'] ?: __( 'Submit', 'default' );

    return str_replace( array( 'input', '/>' ), array( 'button', '>' ), $button ) . "{$button_inner}</button>";
}

add_filter( "gform_submit_button", "form_submit_button", 10, 2 );

// Add ADA support on Gravity form error message
function form_submit_error_ada_notice( $msg ) {
    return str_replace( "class=", "role='alert' class=", $msg );
}

add_filter( 'gform_validation_message', 'form_submit_error_ada_notice' );

// Add ADA support on Gravity form success message
function form_submit_success_ada_notice( $msg ) {
    return str_replace( "id='gform_confirmation_message", "role='alert' id='gform_confirmation_message", $msg );
}

add_filter( 'gform_confirmation', 'form_submit_success_ada_notice' );