<?php
/**
 * Tổ chức lại menu khoa học hơn:
 *  Header (5 mục): Trang chủ · Sản phẩm (▸ danh mục) · Workshop · Về chúng tôi · Liên hệ
 *  Footer: quick links gồm FAQ + chính sách.
 * Chạy: wp eval-file _export/reorganize-menu.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$menu = wp_get_nav_menu_object( 'Menu chính' );
$menu_id = $menu ? $menu->term_id : wp_create_nav_menu( 'Menu chính' );
foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $it ) { wp_delete_post( $it->ID, true ); }

$add = function ( $args ) use ( $menu_id ) {
	return wp_update_nav_menu_item( $menu_id, 0, array_merge( array( 'menu-item-status' => 'publish' ), $args ) );
};
$page = function ( $slug ) { $p = get_page_by_path( $slug, OBJECT, 'page' ); return $p ? $p->ID : 0; };

// 1. Trang chủ
if ( $h = $page( 'trang-chu' ) ) { $add( array( 'menu-item-title' => 'Trang chủ', 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $h ) ); }

// 2. Sản phẩm (link /shop/) + danh mục lồng
$sp = $add( array( 'menu-item-title' => 'Sản phẩm', 'menu-item-type' => 'custom', 'menu-item-url' => '/shop/' ) );
foreach ( get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true ) ) as $t ) {
	if ( $t->slug === 'uncategorized' ) { continue; }
	$ti = $add( array( 'menu-item-title' => $t->name, 'menu-item-type' => 'taxonomy', 'menu-item-object' => 'product_cat', 'menu-item-object-id' => $t->term_id, 'menu-item-parent-id' => $sp ) );
	foreach ( get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $t->term_id, 'hide_empty' => true ) ) as $cc ) {
		$add( array( 'menu-item-title' => $cc->name, 'menu-item-type' => 'taxonomy', 'menu-item-object' => 'product_cat', 'menu-item-object-id' => $cc->term_id, 'menu-item-parent-id' => $ti ) );
	}
}

// 3-5. Workshop · Về chúng tôi · Liên hệ
foreach ( array( array( 'workshop', 'Workshop' ), array( 'about-us', 'Về chúng tôi' ), array( 'contact-us', 'Liên hệ' ) ) as $pg ) {
	if ( $id = $page( $pg[0] ) ) { $add( array( 'menu-item-title' => $pg[1], 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $id ) ); }
}

$loc = get_theme_mod( 'nav_menu_locations', array() );
$loc['primary'] = $menu_id; $loc['main'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $loc );
WP_CLI::log( 'Header menu: 5 mục (Trang chủ · Sản phẩm ▸ · Workshop · Về chúng tôi · Liên hệ).' );

/* Footer: thêm hàng quick links (gồm FAQ) */
$footer =
	'<strong>Nghikigai</strong> - Hương thơm kể chuyện<br>'
	. 'Địa chỉ: Hẻm 341 Nguyễn Trãi, P. Nguyễn Cư Trinh, Quận 1, TP.HCM<br>'
	. 'Hotline: 0382 475 611 · 0938 365 100 &nbsp;|&nbsp; Email: nghikigai@gmail.com<br>'
	. 'Giờ mở cửa: 10:00-18:00<br>'
	. '<span style="display:inline-block;margin:10px 0 6px">'
	. '<a href="/shop/">Sản phẩm</a> · <a href="/workshop/">Workshop</a> · <a href="/about-us/">Về chúng tôi</a> · '
	. '<a href="/faqs/">Câu hỏi thường gặp</a> · <a href="/contact-us/">Liên hệ</a></span><br>'
	. '<a href="https://facebook.com/nghikigai">Facebook</a> · <a href="https://instagram.com/nghikigai">Instagram</a> · <a href="https://tiktok.com/@nghikigai">TikTok</a><br>'
	. '<span style="opacity:.7">© {year} Nghikigai. All rights reserved.</span>';
set_theme_mod( 'footer_html_content', $footer );
WP_CLI::log( 'Footer: thêm quick links (gồm FAQ).' );

WP_CLI::success( 'Tổ chức lại menu xong.' );
