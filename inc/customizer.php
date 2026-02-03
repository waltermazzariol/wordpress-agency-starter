<?php
/**
 * wp_guarapo Theme Customizer
 *
 * @package wp_guarapo
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wp_guarapo_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'wp_guarapo_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'wp_guarapo_customize_partial_blogdescription',
			)
		);
	}

	// Custom color settings
	$wp_customize->add_setting('accent_color', array(
		'default'           => '#22577A',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	));

	$wp_customize->add_setting('footer_color', array(
		'default'           => '#DDDDDD',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	));

	$wp_customize->add_setting('footer_text_color', array(
		'default'           => '#000000',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
		'section' => 'colors',
		'label'   => esc_html__('Accent color', 'wp_guarapo'),
	)));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_color', array(
		'section' => 'colors',
		'label'   => esc_html__('Footer color', 'wp_guarapo'),
	)));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_text_color', array(
		'section' => 'colors',
		'label'   => esc_html__('Footer text color', 'wp_guarapo'),
	)));
}
add_action( 'customize_register', 'wp_guarapo_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function wp_guarapo_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function wp_guarapo_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wp_guarapo_customize_preview_js() {
	wp_enqueue_script( 'wp_guarapo-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'wp_guarapo_customize_preview_js' );
