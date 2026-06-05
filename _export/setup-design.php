<?php
/**
 * Set Kadence global design cho Nghikigai: palette màu brand + font Jost/Nunito.
 * Chạy: wp eval-file _export/setup-design.php
 * An toàn chạy lại nhiều lần.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- 1. Palette màu ---------- */
$pal = function( $colors ) {
	$names = array(
		'palette1'=>'Palette Color 1','palette2'=>'Palette Color 2','palette3'=>'Palette Color 3',
		'palette4'=>'Palette Color 4','palette5'=>'Palette Color 5','palette6'=>'Palette Color 6',
		'palette7'=>'Palette Color 7','palette8'=>'Palette Color 8','palette9'=>'Palette Color 9',
	);
	$out = array();
	$i = 1;
	foreach ( $names as $slug => $name ) { $out[] = array( 'color'=>$colors[$i-1], 'slug'=>$slug, 'name'=>$name ); $i++; }
	return $out;
};
// 1 accent = XANH LOGO #406247, 2 accent-hover (xanh đậm), 3 heading dark, 4-9 trung tính mặc định Kadence
$colors = array( '#406247', '#2f4a35', '#1e1e1e', '#2D3748', '#4A5568', '#718096', '#EDF2F7', '#F7FAFC', '#ffffff' );
$p = $pal( $colors );
$palette = array(
	'palette'        => $p,
	'second-palette' => $p,
	'third-palette'  => $p,
	'active'         => 'palette',
);
update_option( 'kadence_global_palette', wp_json_encode( $palette ) );
WP_CLI::log( 'Palette đã set: accent #406247 (xanh logo)' );

/* ---------- 2. Typography ---------- */
function ngki_font( $family ) {
	return array(
		'size'          => array( 'desktop'=>'', 'tablet'=>'', 'mobile'=>'' ),
		'sizeType'      => 'px',
		'lineHeight'    => array( 'desktop'=>'', 'tablet'=>'', 'mobile'=>'' ),
		'lineType'      => '-',
		'letterSpacing' => array( 'desktop'=>'', 'tablet'=>'', 'mobile'=>'' ),
		'spacingType'   => 'em',
		'family'        => $family,
		'google'        => true,
		'weight'        => 'regular',
		'style'         => 'normal',
		'variant'       => 'regular',
		'color'         => '',
		'transform'     => '',
	);
}
// Body: Nunito (hỗ trợ tiếng Việt tốt)
set_theme_mod( 'base_font', ngki_font( 'Nunito' ) );
// Headings: Lora (serif ấm, hỗ trợ tiếng Việt đầy đủ - thay Jost vì Jost vỡ dấu)
$heading = ngki_font( 'Lora' );
$heading['weight'] = '600';
set_theme_mod( 'heading_font', $heading );
WP_CLI::log( 'Font: body=Nunito, heading=Lora' );

WP_CLI::success( 'Design global đã áp dụng.' );
