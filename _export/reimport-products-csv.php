<?php
/**
 * Import lại sản phẩm từ CSV GỐC do WooCommerce export (dữ liệu chuẩn 100%).
 * - Xoá sản phẩm crawl cũ + danh mục phẳng + ảnh sản phẩm (giữ logo id 10)
 * - Chạy chính WC_Product_CSV_Importer (tự map header tiếng Việt, tải ảnh, tạo danh mục phân cấp)
 * Chạy: wp eval-file _export/reimport-products-csv.php -- <duong_dan_csv>
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$csv = $args[0] ?? '';
if ( ! $csv || ! file_exists( $csv ) ) { WP_CLI::error( "Không thấy CSV: $csv" ); }
$logo_id = (int) get_theme_mod( 'custom_logo' );

/* 1. Xoá product + variation cũ */
$old = get_posts( array( 'post_type' => array( 'product', 'product_variation' ), 'numberposts' => -1, 'post_status' => 'any', 'fields' => 'ids' ) );
foreach ( $old as $pid ) { wp_delete_post( $pid, true ); }
WP_CLI::log( 'Đã xoá ' . count( $old ) . ' product/variation cũ' );

/* 2. Xoá ảnh (trừ logo) */
$atts = get_posts( array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => 'any', 'fields' => 'ids' ) );
$del_att = 0;
foreach ( $atts as $aid ) { if ( $aid === $logo_id ) { continue; } wp_delete_attachment( $aid, true ); $del_att++; }
WP_CLI::log( "Đã xoá $del_att ảnh (giữ logo #$logo_id)" );

/* 3. Xoá danh mục sản phẩm cũ (trừ uncategorized) */
foreach ( get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false ) ) as $t ) {
	if ( $t->slug === 'uncategorized' ) { continue; }
	wp_delete_term( $t->term_id, 'product_cat' );
}
WP_CLI::log( 'Đã xoá danh mục sản phẩm cũ' );

/* 4. Importer của WooCommerce */
require_once WC_ABSPATH . 'includes/import/class-wc-product-csv-importer.php';
require_once WC_ABSPATH . 'includes/admin/importers/class-wc-product-csv-importer-controller.php';

// raw headers
$fh = fopen( $csv, 'r' );
$raw_headers = fgetcsv( $fh );
fclose( $fh );
if ( $raw_headers ) { $raw_headers[0] = preg_replace( '/^\xEF\xBB\xBF/', '', $raw_headers[0] ); } // bỏ BOM

// Map thủ công theo THỨ TỰ CỘT (CSV WooCommerce tiếng Việt) → tránh auto-map fail.
$fields_by_index = array(
	'id', 'type', 'sku', 'global_unique_id', 'name', 'published', 'featured', 'catalog_visibility',
	'short_description', 'description', 'date_on_sale_from', 'date_on_sale_to', 'tax_status', 'tax_class',
	'stock_status', 'stock', 'low_stock_amount', 'backorders', 'sold_individually', 'weight', 'length',
	'width', 'height', 'reviews_allowed', 'purchase_note', 'sale_price', 'regular_price', 'category_ids',
	'tag_ids', 'shipping_class_id', 'images', 'download_limit', 'download_expiry', 'parent_id',
	'grouped_products', 'upsell_ids', 'cross_sell_ids', 'product_url', 'button_text', 'menu_order',
	'', '', // 40 Thương hiệu, 41 Sản phẩm thương hiệu (bỏ qua)
	'attributes:name1', 'attributes:value1', 'attributes:visible1', 'attributes:taxonomy1',
);
$mapping = array();
foreach ( $raw_headers as $i => $h ) {
	$mapping[ $h ] = isset( $fields_by_index[ $i ] ) ? $fields_by_index[ $i ] : '';
}

$importer = new WC_Product_CSV_Importer( $csv, array(
	'mapping'          => $mapping,
	'parse'            => true,
	'update_existing'  => false,
	'delimiter'        => ',',
	'lines'            => -1,
	'prevent_timeouts' => true,
) );
$results = $importer->import();

WP_CLI::log( 'Imported: ' . count( $results['imported'] ) . ' | Failed: ' . count( $results['failed'] ) . ' | Updated: ' . count( $results['updated'] ) . ' | Skipped: ' . count( $results['skipped'] ) );
foreach ( $results['failed'] as $f ) {
	WP_CLI::warning( is_wp_error( $f ) ? $f->get_error_message() : wp_json_encode( $f ) );
}
WP_CLI::success( 'Re-import từ CSV gốc xong.' );
