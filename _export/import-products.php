<?php
/**
 * Import sản phẩm Nghikigai từ products.json vào WooCommerce.
 * Chạy: wp eval-file _export/import-products.php
 * Idempotent: bỏ qua sản phẩm đã tồn tại theo slug.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$json = file_get_contents( __DIR__ . '/products.json' );
$items = json_decode( $json, true );
if ( ! $items ) { WP_CLI::error( 'Không đọc được products.json' ); }

$ATTR = 'Phân loại'; // nhãn biến thể (size/scent) - khách đổi được
$attr_key = sanitize_title( $ATTR ); // 'phan-loai'

// cache ảnh đã sideload theo URL để khỏi tải trùng
$img_cache = array();
function ngki_image( $url, $post_id, $title, &$cache ) {
	if ( ! $url ) { return 0; }
	if ( isset( $cache[ $url ] ) ) { return $cache[ $url ]; }
	$id = media_sideload_image( $url, $post_id, $title, 'id' );
	if ( is_wp_error( $id ) ) { WP_CLI::warning( "Ảnh lỗi: $url - " . $id->get_error_message() ); return 0; }
	$cache[ $url ] = $id;
	return $id;
}

function ngki_term( $name ) {
	$t = term_exists( $name, 'product_cat' );
	if ( ! $t ) { $t = wp_insert_term( $name, 'product_cat' ); }
	if ( is_wp_error( $t ) ) { return 0; }
	return (int) $t['term_id'];
}

$created = 0; $skipped = 0;
foreach ( $items as $p ) {
	$slug = $p['slug'];
	$existing = get_page_by_path( $slug, OBJECT, 'product' );
	if ( $existing ) { $skipped++; WP_CLI::log( "SKIP (đã có): $slug" ); continue; }

	$cat_id = ngki_term( $p['category'] );
	$is_var = ( $p['type'] === 'variable' && ! empty( $p['variations'] ) );

	$product = $is_var ? new WC_Product_Variable() : new WC_Product_Simple();
	$product->set_name( $p['name'] );
	$product->set_slug( $slug );
	$product->set_status( 'publish' );
	$product->set_catalog_visibility( 'visible' );
	if ( ! empty( $p['short'] ) ) { $product->set_short_description( wpautop( $p['short'] ) ); }
	if ( ! empty( $p['long'] ) )  { $product->set_description( wpautop( $p['long'] ) ); }
	if ( $cat_id ) { $product->set_category_ids( array( $cat_id ) ); }
	if ( ! empty( $p['sku'] ) ) { try { $product->set_sku( $p['sku'] . '-' . substr( $slug, 0, 6 ) ); } catch ( Exception $e ) {} }

	if ( $is_var ) {
		$options = array();
		foreach ( $p['variations'] as $v ) { if ( $v['size'] ) { $options[] = $v['size']; } }
		$options = array_values( array_unique( $options ) );
		$attribute = new WC_Product_Attribute();
		$attribute->set_id( 0 );
		$attribute->set_name( $ATTR );
		$attribute->set_options( $options );
		$attribute->set_visible( true );
		$attribute->set_variation( true );
		$product->set_attributes( array( $attribute ) );
	} else {
		$product->set_regular_price( (string) ( $p['price'] ?: '0' ) );
	}

	$pid = $product->save();

	// ảnh featured + gallery
	$gallery_ids = array();
	foreach ( (array) $p['gallery'] as $i => $url ) {
		$iid = ngki_image( $url, $pid, $p['name'], $img_cache );
		if ( $iid ) { $gallery_ids[] = $iid; }
	}
	if ( $gallery_ids ) {
		$product = wc_get_product( $pid );
		$product->set_image_id( $gallery_ids[0] );
		if ( count( $gallery_ids ) > 1 ) { $product->set_gallery_image_ids( array_slice( $gallery_ids, 1 ) ); }
		$product->save();
	}

	// biến thể
	if ( $is_var ) {
		foreach ( $p['variations'] as $v ) {
			if ( ! $v['size'] ) { continue; }
			$var = new WC_Product_Variation();
			$var->set_parent_id( $pid );
			$var->set_attributes( array( $attr_key => $v['size'] ) );
			$price = $v['regular'] ?: $v['price'];
			if ( $price ) { $var->set_regular_price( (string) $price ); }
			if ( ! empty( $v['img'] ) ) {
				$iid = ngki_image( $v['img'], $pid, $p['name'] . ' ' . $v['size'], $img_cache );
				if ( $iid ) { $var->set_image_id( $iid ); }
			}
			$var->save();
		}
		WC_Product_Variable::sync( $pid );
	}

	$created++;
	WP_CLI::log( "OK: {$p['name']} ({$p['category']}) #$pid" );
}
WP_CLI::success( "Tạo $created sản phẩm, bỏ qua $skipped." );
