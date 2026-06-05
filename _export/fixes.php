<?php
/**
 * Fix sau khi review: ẩn tiêu đề trang chủ + gán thumbnail danh mục.
 * Chạy: wp eval-file _export/fixes.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* 1. Ẩn tiêu đề "Trang chủ" trên front page (Kadence) */
$home = get_page_by_path( 'trang-chu', OBJECT, 'page' );
if ( $home ) {
	update_post_meta( $home->ID, '_kad_post_title', 'hide' );
	update_post_meta( $home->ID, '_kad_post_layout', 'fullwidth' );
	WP_CLI::log( 'Đã ẩn tiêu đề trang chủ' );
}

/* 2. Gán thumbnail cho từng danh mục = ảnh sản phẩm đầu tiên trong danh mục */
$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) );
foreach ( $terms as $term ) {
	if ( $term->slug === 'uncategorized' ) { continue; }
	if ( get_term_meta( $term->term_id, 'thumbnail_id', true ) ) { continue; }
	$q = new WP_Query( array(
		'post_type'      => 'product',
		'posts_per_page' => 1,
		'tax_query'      => array( array( 'taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $term->term_id ) ),
		'meta_query'     => array( array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ) ),
	) );
	if ( $q->have_posts() ) {
		$pid = $q->posts[0]->ID;
		$thumb = get_post_thumbnail_id( $pid );
		if ( $thumb ) {
			update_term_meta( $term->term_id, 'thumbnail_id', $thumb );
			WP_CLI::log( "Thumbnail danh mục {$term->name} ← ảnh sp #$pid" );
		}
	}
	wp_reset_postdata();
}

/* 3. Quà tặng theo yêu cầu: bỏ giá 0 để hiện "Liên hệ" (filter ở functions.php) */
$gift = get_page_by_path( 'qua-tang-theo-yeu-cau', OBJECT, 'product' );
if ( $gift ) {
	$p = wc_get_product( $gift->ID );
	$p->set_regular_price( '' );
	$p->set_price( '' );
	$p->save();
	WP_CLI::log( 'Quà tặng: bỏ giá 0 → Liên hệ' );
}

WP_CLI::success( 'Fixes xong.' );
