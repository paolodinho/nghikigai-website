<?php
/**
 * Dọn dẹp + tối ưu site: địa chỉ thật, header search+cart, dọn demo, shop gọn gàng.
 * Chạy: wp eval-file _export/optimize.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$ADDR = 'Hẻm 341 Nguyễn Trãi, P. Nguyễn Cư Trinh, Quận 1, TP.HCM';

/* 1. HEADER: thêm tìm kiếm + giỏ hàng vào bên phải (dễ tìm sản phẩm) */
$desktop = get_theme_mod( 'header_desktop_items' );
if ( is_array( $desktop ) ) {
	$desktop['main']['main_right'] = array( 'search', 'navigation', 'cart' );
	set_theme_mod( 'header_desktop_items', $desktop );
}
$mobile = get_theme_mod( 'header_mobile_items' );
if ( is_array( $mobile ) ) {
	$mobile['main']['main_right'] = array( 'cart', 'popup-toggle' );
	set_theme_mod( 'header_mobile_items', $mobile );
}
// search dạng dropdown icon, cart dạng icon
set_theme_mod( 'search_visibility', 'dropdown' );
set_theme_mod( 'header_cart_label', '' );
WP_CLI::log( 'Header: thêm tìm kiếm + giỏ hàng.' );

/* 2. FOOTER: thêm địa chỉ */
$footer =
	'<strong>Nghikigai</strong> - Hương thơm kể chuyện<br>'
	. 'Địa chỉ: ' . $ADDR . '<br>'
	. 'Hotline: 0382 475 611 · 0938 365 100 &nbsp;|&nbsp; Email: nghikigai@gmail.com<br>'
	. 'Giờ mở cửa: 10:00-18:00 &nbsp;|&nbsp; '
	. '<a href="https://facebook.com/nghikigai">Facebook</a> · '
	. '<a href="https://instagram.com/nghikigai">Instagram</a> · '
	. '<a href="https://tiktok.com/@nghikigai">TikTok</a><br>'
	. '<span style="opacity:.7">© {year} Nghikigai. All rights reserved.</span>';
set_theme_mod( 'footer_html_content', $footer );

/* 3. CONTACT page: địa chỉ thật + bản đồ + workshop */
$map = 'https://www.google.com/maps?q=' . rawurlencode( '341 Nguyễn Trãi, Phường Nguyễn Cư Trinh, Quận 1, Hồ Chí Minh' ) . '&output=embed';
$contact  = "<!-- wp:heading {\"textAlign\":\"center\"} -->\n<h2 class=\"wp-block-heading has-text-align-center\">Liên hệ Nghikigai</h2>\n<!-- /wp:heading -->\n";
$contact .= "<!-- wp:paragraph {\"align\":\"center\"} -->\n<p class=\"has-text-align-center\">Nghikigai biến hương thơm thành ký ức, cảm xúc và những câu chuyện ở lại cùng bạn. Ghé thăm hoặc nhắn tin để được tư vấn nhé.</p>\n<!-- /wp:paragraph -->\n";
$contact .= "<!-- wp:columns -->\n<div class=\"wp-block-columns\">\n";
$contact .= "<!-- wp:column -->\n<div class=\"wp-block-column\">"
	. "<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">Thông tin</h3>\n<!-- /wp:heading -->\n"
	. "<!-- wp:paragraph -->\n<p><strong>Địa chỉ:</strong> $ADDR</p>\n<!-- /wp:paragraph -->\n"
	. "<!-- wp:paragraph -->\n<p><strong>Hotline:</strong> 0382 475 611 · 0938 365 100</p>\n<!-- /wp:paragraph -->\n"
	. "<!-- wp:paragraph -->\n<p><strong>Email:</strong> nghikigai@gmail.com</p>\n<!-- /wp:paragraph -->\n"
	. "<!-- wp:paragraph -->\n<p><strong>Giờ mở cửa:</strong> 10:00 - 18:00 (T2-CN)</p>\n<!-- /wp:paragraph -->\n"
	. "<!-- wp:paragraph -->\n<p><strong>Miễn ship</strong> nội thành TP.HCM cho đơn trên 500K.</p>\n<!-- /wp:paragraph -->\n"
	. "<!-- wp:paragraph -->\n<p>Facebook · Instagram · TikTok: <a href=\"https://facebook.com/nghikigai\">@nghikigai</a></p>\n<!-- /wp:paragraph -->\n"
	. "</div>\n<!-- /wp:column -->\n";
$contact .= "<!-- wp:column -->\n<div class=\"wp-block-column\">"
	. "<!-- wp:html -->\n<div style=\"position:relative;padding-bottom:75%;height:0;border-radius:12px;overflow:hidden\"><iframe src=\"$map\" style=\"position:absolute;top:0;left:0;width:100%;height:100%;border:0\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe></div>\n<!-- /wp:html -->\n"
	. "</div>\n<!-- /wp:column -->\n";
$contact .= "</div>\n<!-- /wp:columns -->\n";
$cp = get_page_by_path( 'contact-us', OBJECT, 'page' );
if ( $cp ) { wp_update_post( array( 'ID' => $cp->ID, 'post_content' => $contact ) ); WP_CLI::log( 'Contact: thêm địa chỉ + bản đồ.' ); }

/* 4. Dọn demo */
$ref = get_page_by_path( 'refund_returns', OBJECT, 'page' );
if ( $ref ) { wp_trash_post( $ref->ID ); WP_CLI::log( 'Trash trang Refund mẫu.' ); }
$unc = get_term_by( 'slug', 'uncategorized', 'product_cat' );
if ( $unc && (int) $unc->count === 0 ) { wp_delete_term( $unc->term_id, 'product_cat' ); WP_CLI::log( 'Xoá danh mục Uncategorized.' ); }

/* 5. Shop gọn gàng: 3 cột, 4 hàng, sắp theo độ phổ biến */
update_option( 'woocommerce_catalog_columns', 3 );
update_option( 'woocommerce_catalog_rows', 4 );
update_option( 'woocommerce_default_catalog_orderby', 'popularity' );
set_theme_mod( 'product_archive_columns', 3 );
WP_CLI::log( 'Shop: 3 cột, sắp theo phổ biến.' );

WP_CLI::success( 'Tối ưu + dọn dẹp xong.' );
