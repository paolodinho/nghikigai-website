<?php
/**
 * Nghikigai child theme (Kadence) - functions
 *
 * Nguyên tắc: chỉ enqueue style/script. KHÔNG hardcode nội dung.
 * Mọi nội dung trang/khối → chỉnh trong WP editor (khách tự làm được).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NGHIKIGAI_VERSION', '1.4.1' );

/**
 * Enqueue parent + child styles.
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'kadence-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'kadence' )->get( 'Version' )
	);

	wp_enqueue_style(
		'nghikigai-theme',
		get_stylesheet_directory_uri() . '/assets/css/theme.css',
		array( 'kadence-parent' ),
		NGHIKIGAI_VERSION
	);

	wp_enqueue_script(
		'nghikigai-reveal',
		get_stylesheet_directory_uri() . '/assets/js/reveal.js',
		array(),
		NGHIKIGAI_VERSION,
		true
	);
}, 20 );

/**
 * Sản phẩm chưa có giá (vd: Quà tặng theo yêu cầu) → hiển thị "Liên hệ".
 */
add_filter( 'woocommerce_get_price_html', function ( $price, $product ) {
	if ( '' === $product->get_price() || '0' === (string) $product->get_price() ) {
		return '<span class="ngki-contact-price">Liên hệ</span>';
	}
	// Rule Hiếu: không dùng em/en dash → khoảng giá dùng "-".
	return str_replace( array( '&ndash;', '&mdash;', '-', '-' ), '-', $price );
}, 10, 2 );

/**
 * Chuẩn hoá mọi gạch dài en/em dash → "-" trong khoảng giá (Price range: from-to).
 */
add_filter( 'gettext_with_context', function ( $translated, $text, $context, $domain ) {
	if ( 'woocommerce' === $domain && 'Price range: from-to' === $context ) {
		return '%1$s - %2$s';
	}
	return $translated;
}, 20, 4 );

add_filter( 'woocommerce_is_purchasable', function ( $purchasable, $product ) {
	// Cho phép thêm vào giỏ kể cả khi giá 0 (đơn theo yêu cầu) - giữ nút bấm hoạt động.
	return $purchasable;
}, 10, 2 );

/**
 * Rule Hiếu: KHÔNG để WordPress tự đổi " - " thành en/em dash (wptexturize).
 */
add_filter( 'run_wptexturize', '__return_false' );

/**
 * Tối ưu nhẹ: bỏ emoji script (không cần), giảm tải trang.
 */
add_action( 'init', function () {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
} );
