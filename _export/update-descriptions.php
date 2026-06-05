<?php
/**
 * Dọn lại MÔ TẢ sản phẩm: thay nội dung bằng bản đã làm sạch (bỏ "n" rác từ \n literal, bỏ span builder).
 * Chạy: wp eval-file _export/update-descriptions.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$data = json_decode( file_get_contents( __DIR__ . '/clean_desc.json' ), true );
if ( ! $data ) { WP_CLI::error( 'Không đọc được clean_desc.json' ); }

$n = 0;
foreach ( $data as $slug => $d ) {
	$p = get_page_by_path( $slug, OBJECT, 'product' );
	if ( ! $p ) { WP_CLI::warning( "Không thấy sp: $slug" ); continue; }
	$prod = wc_get_product( $p->ID );
	// lưu raw đã sạch - trang sản phẩm tự chạy wpautop khi hiển thị
	$prod->set_description( $d['desc'] );
	if ( $d['short'] !== '' ) { $prod->set_short_description( $d['short'] ); }
	$prod->save();
	$n++;
}
WP_CLI::success( "Đã dọn mô tả $n sản phẩm." );
