<?php
/**
 * Param type 'hidden'.
 *
 * Used to create hidden field.
 *
 * @see https://kb.wpbakery.com/docs/inner-api/vc_map/#vc_map()-ParametersofparamsArray
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Hidden field param.
 *
 * @param array $settings
 * @param mixed $value
 *
 * @since 4.5
 * @return string - html string.
 */
function vc_hidden_form_field( $settings, $value ) {
	$value = is_string( $value ) ? $value : '';
	$value = htmlspecialchars( $value );

	return '<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value vc_hidden-field vc_param-name-' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '" type="hidden" value="' . esc_attr( $value ) . '"/>';
}

/**
 * Remove content before hidden field type input.
 *
 * @since 4.5
 *
 * @return string
 */
function vc_edit_form_fields_render_field_hidden_before() {
	return '<div class="vc_column vc_edit-form-hidden-field-wrapper">';
}

/**
 * Remove content after hidden field type input.
 *
 * @since 4.5
 *
 * @return string
 */
function vc_edit_form_fields_render_field_hidden_after() {
	return '</div>';
}
