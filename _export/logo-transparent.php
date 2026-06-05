<?php
/**
 * Tạo logo chữ XANH trên nền TRONG SUỐT từ logo gốc (chữ trắng / nền xanh),
 * import vào Media + đặt làm Site Logo → header tinh tế, không còn khối xanh thô.
 * Chạy: wp eval-file _export/logo-transparent.php -- <logo_webp_goc>
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once ABSPATH . 'wp-admin/includes/image.php';

$path = $args[0] ?? '';
if ( ! $path || ! file_exists( $path ) || ! function_exists( 'imagecreatefromwebp' ) ) {
	WP_CLI::error( 'Thiếu logo gốc hoặc GD webp.' );
}
$src = imagecreatefromwebp( $path );
$w = imagesx( $src ); $h = imagesy( $src );

// upscale 2x cho nét trên màn retina
$scale = 2; $W = $w * $scale; $H = $h * $scale;
$out = imagecreatetruecolor( $W, $H );
imagealphablending( $out, false );
imagesavealpha( $out, true );
imagefill( $out, 0, 0, imagecolorallocatealpha( $out, 0, 0, 0, 127 ) );

// màu chữ đích = xanh logo #406247
$TR = 0x40; $TG = 0x62; $TB = 0x47;
$lumaBg = 85.0;   // luma nền xanh ~ (64,98,71)
$lumaTx = 255.0;  // luma chữ trắng

for ( $y = 0; $y < $H; $y++ ) {
	for ( $x = 0; $x < $W; $x++ ) {
		$sx = (int) ( $x / $scale ); $sy = (int) ( $y / $scale );
		$rgb = imagecolorat( $src, $sx, $sy );
		$r = ( $rgb >> 16 ) & 0xFF; $g = ( $rgb >> 8 ) & 0xFF; $b = $rgb & 0xFF;
		$luma = 0.299 * $r + 0.587 * $g + 0.114 * $b;
		$a = ( $luma - $lumaBg ) / ( $lumaTx - $lumaBg ); // 0 ở nền, 1 ở chữ
		if ( $a < 0 ) { $a = 0; } if ( $a > 1 ) { $a = 1; }
		if ( $a <= 0.02 ) { continue; } // nền → trong suốt
		$alpha127 = (int) round( ( 1 - $a ) * 127 );
		imagesetpixel( $out, $x, $y, imagecolorallocatealpha( $out, $TR, $TG, $TB, $alpha127 ) );
	}
}
$up = wp_upload_dir();
$file = $up['path'] . '/nghikigai-logo-green.png';
imagepng( $out, $file );
imagedestroy( $out ); imagedestroy( $src );

$aid = wp_insert_attachment( array(
	'post_mime_type' => 'image/png',
	'post_title'     => 'Nghikigai logo (xanh, nền trong suốt)',
	'post_status'    => 'inherit',
), $file );
wp_update_attachment_metadata( $aid, wp_generate_attachment_metadata( $aid, $file ) );
set_theme_mod( 'custom_logo', $aid );
WP_CLI::success( "Logo trong suốt #$aid đã đặt làm Site Logo ($W x $H)." );
