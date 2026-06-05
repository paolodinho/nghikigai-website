<?php
/**
 * Import sản phẩm từ products_csv.json (parse từ CSV gốc WooCommerce).
 * Tạo: danh mục PHÂN CẤP, biến thể (tên thuộc tính thật), gallery đầy đủ, mô tả HTML, slug gốc.
 * Chạy: wp eval-file _export/import-from-csv.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$items   = json_decode( file_get_contents( __DIR__ . '/products_csv.json' ), true );
$slugmap = json_decode( file_get_contents( __DIR__ . '/slugmap.json' ), true );
if ( ! $items ) { WP_CLI::error( 'Không đọc được products_csv.json' ); }
$logo_id = (int) get_theme_mod( 'custom_logo' );

/* dọn sạch trước */
foreach ( get_posts( array( 'post_type' => array( 'product', 'product_variation' ), 'numberposts' => -1, 'post_status' => 'any', 'fields' => 'ids' ) ) as $pid ) { wp_delete_post( $pid, true ); }
foreach ( get_posts( array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => 'any', 'fields' => 'ids' ) ) as $aid ) { if ( $aid !== $logo_id ) { wp_delete_attachment( $aid, true ); } }
foreach ( get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false ) ) as $t ) { if ( $t->slug !== 'uncategorized' ) { wp_delete_term( $t->term_id, 'product_cat' ); } }
WP_CLI::log( 'Đã dọn sản phẩm/ảnh/danh mục cũ.' );

$img_cache = array();
function ngki_img( $url, $post_id, $title, &$cache ) {
	if ( ! $url ) { return 0; }
	if ( isset( $cache[ $url ] ) ) { return $cache[ $url ]; }
	$id = media_sideload_image( $url, $post_id, $title, 'id' );
	if ( is_wp_error( $id ) ) { WP_CLI::warning( "Ảnh lỗi: $url" ); return 0; }
	$cache[ $url ] = $id;
	return $id;
}
/* tạo cây danh mục, trả term_id của lá */
function ngki_cat_path( $path ) {
	$parent = 0; $leaf = 0;
	foreach ( $path as $name ) {
		$existing = get_term_by( 'name', $name, 'product_cat' );
		if ( $existing && (int) $existing->parent === (int) $parent ) {
			$leaf = (int) $existing->term_id;
		} else {
			$t = wp_insert_term( $name, 'product_cat', array( 'parent' => $parent ) );
			if ( is_wp_error( $t ) ) {
				// có thể trùng tên khác nhánh → lấy theo parent
				$found = get_terms( array( 'taxonomy' => 'product_cat', 'name' => $name, 'parent' => $parent, 'hide_empty' => false ) );
				$leaf = $found ? (int) $found[0]->term_id : 0;
			} else { $leaf = (int) $t['term_id']; }
		}
		$parent = $leaf;
	}
	return $leaf;
}

$n = 0;
foreach ( $items as $p ) {
	$is_var = ( $p['type'] === 'variable' && ! empty( $p['variations'] ) );
	$product = $is_var ? new WC_Product_Variable() : new WC_Product_Simple();
	$product->set_name( $p['name'] );
	$slug = $slugmap[ $p['id'] . '|' . $p['name'] ] ?? sanitize_title( $p['name'] );
	$product->set_slug( $slug );
	$product->set_status( 'publish' );
	$product->set_catalog_visibility( 'visible' );
	if ( ! empty( $p['featured'] ) && in_array( strtolower( $p['featured'] ), array( '1', 'yes', 'true' ), true ) ) { $product->set_featured( true ); }
	if ( $p['short'] !== '' ) { $product->set_short_description( $p['short'] ); }
	if ( $p['desc'] !== '' ) { $product->set_description( $p['desc'] ); }
	if ( $p['menu_order'] !== '' ) { $product->set_menu_order( (int) $p['menu_order'] ); }
	if ( ! empty( $p['sku'] ) ) { try { $product->set_sku( $p['sku'] ); } catch ( Exception $e ) {} }

	// danh mục (mọi path)
	$cat_ids = array();
	foreach ( (array) $p['cats'] as $path ) { $id = ngki_cat_path( $path ); if ( $id ) { $cat_ids[] = $id; } }
	if ( $cat_ids ) { $product->set_category_ids( array_values( array_unique( $cat_ids ) ) ); }

	if ( $is_var ) {
		$attribute = new WC_Product_Attribute();
		$attribute->set_id( 0 );
		$attribute->set_name( $p['attr_name'] ?: 'Size' );
		$attribute->set_options( $p['attr_values'] );
		$attribute->set_visible( true );
		$attribute->set_variation( true );
		$product->set_attributes( array( $attribute ) );
	} else {
		if ( $p['regular'] !== '' ) { $product->set_regular_price( (string) $p['regular'] ); }
		if ( $p['sale'] !== '' ) { $product->set_sale_price( (string) $p['sale'] ); }
	}
	$pid = $product->save();

	// ảnh
	$gids = array();
	foreach ( (array) $p['images'] as $url ) { $iid = ngki_img( $url, $pid, $p['name'], $img_cache ); if ( $iid ) { $gids[] = $iid; } }
	if ( $gids ) {
		$pr = wc_get_product( $pid );
		$pr->set_image_id( $gids[0] );
		if ( count( $gids ) > 1 ) { $pr->set_gallery_image_ids( array_slice( $gids, 1 ) ); }
		$pr->save();
	}

	// biến thể
	if ( $is_var ) {
		$akey = sanitize_title( $p['attr_name'] ?: 'Size' );
		foreach ( $p['variations'] as $v ) {
			if ( $v['value'] === '' ) { continue; }
			$var = new WC_Product_Variation();
			$var->set_parent_id( $pid );
			$var->set_attributes( array( $akey => $v['value'] ) );
			if ( $v['regular'] !== '' ) { $var->set_regular_price( (string) $v['regular'] ); }
			if ( $v['sale'] !== '' ) { $var->set_sale_price( (string) $v['sale'] ); }
			if ( ! empty( $v['images'][0] ) ) { $iid = ngki_img( $v['images'][0], $pid, $p['name'] . ' ' . $v['value'], $img_cache ); if ( $iid ) { $var->set_image_id( $iid ); } }
			$var->save();
		}
		WC_Product_Variable::sync( $pid );
	}
	$n++;
	WP_CLI::log( "OK [{$p['type']}] {$p['name']} #$pid (slug:$slug, " . count( $gids ) . " ảnh)" );
}
WP_CLI::success( "Import $n sản phẩm từ CSV gốc xong." );
