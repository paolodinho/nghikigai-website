<?php
/**
 * Dựng lại Menu chính với danh mục PHÂN CẤP (subcat lồng dưới Nến thơm cao cấp).
 * Chạy: wp eval-file _export/rebuild-menu.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$menu_name = 'Menu chính';
$menu = wp_get_nav_menu_object( $menu_name );
$menu_id = $menu ? $menu->term_id : wp_create_nav_menu( $menu_name );
foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $it ) { wp_delete_post( $it->ID, true ); }

$add = function ( $args ) use ( $menu_id ) {
	return wp_update_nav_menu_item( $menu_id, 0, array_merge( array( 'menu-item-status' => 'publish' ), $args ) );
};
$page = function ( $slug ) { $p = get_page_by_path( $slug, OBJECT, 'page' ); return $p ? $p->ID : 0; };

$home = $page( 'trang-chu' );
if ( $home ) { $add( array( 'menu-item-title' => 'Trang chủ', 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $home ) ); }
$shop = $page( 'shop' );
if ( $shop ) { $add( array( 'menu-item-title' => 'Shop', 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $shop ) ); }

// Danh mục (cha = link tới shop) + subcat lồng
$parent_item = $add( array( 'menu-item-title' => 'Danh mục', 'menu-item-type' => 'custom', 'menu-item-url' => '/shop/' ) );
$top = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true ) );
foreach ( $top as $t ) {
	if ( $t->slug === 'uncategorized' ) { continue; }
	$ti = $add( array( 'menu-item-title' => $t->name, 'menu-item-type' => 'taxonomy', 'menu-item-object' => 'product_cat', 'menu-item-object-id' => $t->term_id, 'menu-item-parent-id' => $parent_item ) );
	foreach ( get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $t->term_id, 'hide_empty' => true ) ) as $c ) {
		$add( array( 'menu-item-title' => $c->name, 'menu-item-type' => 'taxonomy', 'menu-item-object' => 'product_cat', 'menu-item-object-id' => $c->term_id, 'menu-item-parent-id' => $ti ) );
	}
}

foreach ( array( array( 'about-us', 'Về chúng tôi' ), array( 'faqs', 'Câu hỏi thường gặp' ), array( 'contact-us', 'Liên hệ' ) ) as $pg ) {
	$id = $page( $pg[0] );
	if ( $id ) { $add( array( 'menu-item-title' => $pg[1], 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $id ) ); }
}

$loc = get_theme_mod( 'nav_menu_locations', array() );
$loc['primary'] = $menu_id; $loc['main'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $loc );
WP_CLI::success( 'Menu phân cấp dựng lại xong.' );
