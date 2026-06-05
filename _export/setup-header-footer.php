<?php
/**
 * Thêm thanh banner ship (top bar) + nội dung footer liên hệ cho Kadence.
 * Chạy: wp eval-file _export/setup-header-footer.php
 * Khách sửa được: Customizer → Header → Top Row → HTML / Footer → HTML.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- HEADER: bật top row + HTML free-ship ---------- */
$desktop = array(
	'top' => array(
		'top_left' => array(), 'top_left_center' => array(),
		'top_center' => array( 'html' ),
		'top_right_center' => array(), 'top_right' => array(),
	),
	'main' => array(
		'main_left' => array( 'logo' ), 'main_left_center' => array(),
		'main_center' => array(),
		'main_right_center' => array(), 'main_right' => array( 'navigation' ),
	),
	'bottom' => array(
		'bottom_left' => array(), 'bottom_left_center' => array(),
		'bottom_center' => array(),
		'bottom_right_center' => array(), 'bottom_right' => array(),
	),
);
set_theme_mod( 'header_desktop_items', $desktop );

$mobile = array(
	'popup' => array( 'popup_content' => array( 'mobile-navigation' ) ),
	'top'   => array( 'top_left' => array(), 'top_center' => array( 'html' ), 'top_right' => array() ),
	'main'  => array( 'main_left' => array( 'mobile-logo' ), 'main_center' => array(), 'main_right' => array( 'popup-toggle' ) ),
	'bottom'=> array( 'bottom_left' => array(), 'bottom_center' => array(), 'bottom_right' => array() ),
);
set_theme_mod( 'header_mobile_items', $mobile );

set_theme_mod( 'header_html_content', 'Miễn ship khu vực nội thành TP.HCM cho toàn bộ đơn hàng trên 500K' );
set_theme_mod( 'header_html_wpautop', false );
// Nền hồng brand cho top row
set_theme_mod( 'header_top_row_background', array( 'desktop' => array( 'color' => '#e62a65' ) ) );
WP_CLI::log( 'Top bar free-ship đã bật.' );

/* ---------- FOOTER: nội dung liên hệ ---------- */
$footer_html =
	'<strong>Nghikigai</strong> - Hương thơm kể chuyện<br>'
	. 'Hotline: 0382 475 611 · 0938 365 100 &nbsp;|&nbsp; Email: nghikigai@gmail.com<br>'
	. 'Giờ mở cửa: 10:00-18:00 &nbsp;|&nbsp; '
	. '<a href="https://facebook.com/nghikigai">Facebook</a> · '
	. '<a href="https://instagram.com/nghikigai">Instagram</a> · '
	. '<a href="https://tiktok.com/@nghikigai">TikTok</a><br>'
	. '<span style="opacity:.7">© {year} Nghikigai. All rights reserved.</span>';
set_theme_mod( 'footer_html_content', $footer_html );
set_theme_mod( 'footer_html_wpautop', false );
WP_CLI::log( 'Footer liên hệ đã set.' );

WP_CLI::success( 'Header top bar + Footer hoàn tất.' );
