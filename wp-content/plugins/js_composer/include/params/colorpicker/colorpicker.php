<?php
/**
 * Param type 'colorpicker'.
 *
 * Used to create colorpicker field.
 *
 * @see https://kb.wpbakery.com/docs/inner-api/vc_map/#vc_map()-ParametersofparamsArray
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Param 'colorpicker' field
 *
 * @param array $settings
 * @param string $value
 *
 * @return string
 * @since 4.4
 */
function vc_colorpicker_form_field( $settings, $value ) {
	return sprintf( '<div class="color-group"><div class="wpb-color-picker"></div><input name="%s" class="wpb_vc_param_value wpb-textinput %s %s_field vc_color-control vc_ui-hidden" type="text" value="%s" data-default-value="%s"/></div>', $settings['param_name'], $settings['param_name'], $settings['type'], $value, $settings['value'] );
}