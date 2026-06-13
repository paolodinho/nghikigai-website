<?php
/**
 * 1) Chèn 1 strip "Trải nghiệm workshop" vào trang chủ (trước phần testimonials).
 * 2) Tạo 1 bài blog thật về workshop, dùng ảnh WS đã import.
 * Idempotent: chạy lại không nhân đôi.
 * Chạy: ./_bin/wp.sh eval-file _export/add-workshop-content.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Lấy ID ảnh WS theo meta _ngki_ws
function ngki_ws_id( $key ) {
	$p = get_posts( array( 'post_type' => 'attachment', 'numberposts' => 1, 'meta_key' => '_ngki_ws', 'meta_value' => $key, 'fields' => 'ids' ) );
	return $p ? (int) $p[0] : 0;
}
$img = array();
foreach ( array( 'ws-01','ws-02','ws-03','ws-04','ws-05','ws-06','ws-07','ws-08' ) as $k ) { $img[ $k ] = ngki_ws_id( $k ); }
if ( ! $img['ws-03'] ) { WP_CLI::error( 'Chưa thấy ảnh WS đã import. Chạy import-workshop-gallery.php trước.' ); }

function ngki_url( $id, $size = 'large' ) { return wp_get_attachment_image_url( $id, $size ); }
function ngki_alt( $id ) { return esc_attr( get_post_meta( $id, '_wp_attachment_image_alt', true ) ); }

/* ---------- 1) HOMEPAGE STRIP ---------- */
$front = (int) get_option( 'page_on_front' );
$content = get_post_field( 'post_content', $front );
if ( strpos( $content, 'ngki-workshop-strip' ) === false ) {
	$mid  = $img['ws-03'];
	$murl = ngki_url( $mid, 'large' );
	$strip  = "<!-- wp:media-text {\"mediaId\":$mid,\"mediaType\":\"image\",\"mediaPosition\":\"right\",\"className\":\"ngki-workshop-strip\",\"style\":{\"spacing\":{\"padding\":{\"top\":\"8px\",\"bottom\":\"8px\"}}}} -->\n";
	$strip .= "<div class=\"wp-block-media-text alignwide has-media-on-the-right is-stacked-on-mobile ngki-workshop-strip\" style=\"padding-top:8px;padding-bottom:8px\"><div class=\"wp-block-media-text__content\">";
	$strip .= "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Trải nghiệm tự tay làm nến</h2>\n<!-- /wp:heading -->\n";
	$strip .= "<!-- wp:paragraph -->\n<p>Workshop <strong>Tiny Treasures</strong> của Nghikigai đưa bạn vào một buổi chiều chậm rãi: chọn mùi hương, đổ nến, làm wax melts và nước hoa khô. Một khoảng lặng nhỏ giữa những bộn bề.</p>\n<!-- /wp:paragraph -->\n";
	$strip .= "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"/workshop/\">Xem workshop</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->\n";
	$strip .= "</div><figure class=\"wp-block-media-text__media\"><img src=\"$murl\" alt=\"" . ngki_alt( $mid ) . "\" class=\"wp-image-$mid size-large\"/></figure></div>\n<!-- /wp:media-text -->\n";

	// chèn trước phần "Khách hàng nói gì" (group wrapper gần nhất)
	$pos = strpos( $content, 'Khách hàng nói gì' );
	if ( $pos !== false ) {
		$gpos = strrpos( substr( $content, 0, $pos ), '<!-- wp:group' );
		if ( $gpos !== false ) {
			$content = substr( $content, 0, $gpos ) . $strip . substr( $content, $gpos );
		} else { $content .= $strip; }
	} else { $content .= $strip; }

	wp_update_post( array( 'ID' => $front, 'post_content' => $content ) );
	WP_CLI::log( 'Homepage: đã chèn strip workshop.' );
} else {
	WP_CLI::log( 'Homepage: strip workshop đã có - bỏ qua.' );
}

/* ---------- 2) BLOG POST ---------- */
$slug = 'workshop-lam-nen-tiny-treasures';
$exist = get_page_by_path( $slug, OBJECT, 'post' );

$b  = "<!-- wp:paragraph -->\n<p>Có những buổi chiều, điều chữa lành nhất lại đến từ việc tự tay làm một món đồ nhỏ. Đó là tinh thần của <strong>Tiny Treasures</strong> - chuỗi workshop làm nến và đồ thơm handmade do Nghikigai tổ chức.</p>\n<!-- /wp:paragraph -->\n";

$b .= "<!-- wp:image {\"id\":{$img['ws-01']},\"sizeSlug\":\"large\",\"linkDestination\":\"none\"} -->\n<figure class=\"wp-block-image size-large\"><img src=\"" . ngki_url( $img['ws-01'] ) . "\" alt=\"" . ngki_alt( $img['ws-01'] ) . "\" class=\"wp-image-{$img['ws-01']}\"/></figure>\n<!-- /wp:image -->\n";

$b .= "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Bạn sẽ làm gì trong buổi workshop?</h2>\n<!-- /wp:heading -->\n";
$b .= "<!-- wp:paragraph -->\n<p>Mỗi buổi, Nghikigai chuẩn bị sẵn nguyên liệu thật: sáp thiên nhiên, tinh dầu thương hiệu (White tea, Oakwood &amp; Spiced rose, Pine wood...), hoa khô, quế và các khuôn sáp trang trí nhiều màu. Bạn được tự chọn mùi hương và tự tay hoàn thiện thành phẩm của riêng mình.</p>\n<!-- /wp:paragraph -->\n";

$b .= "<!-- wp:gallery {\"columns\":2,\"linkTo\":\"none\",\"sizeSlug\":\"large\"} -->\n<figure class=\"wp-block-gallery has-nested-images columns-2 is-cropped\">";
foreach ( array( 'ws-04','ws-06','ws-05','ws-02' ) as $k ) {
	$id = $img[ $k ]; if ( ! $id ) continue;
	$b .= "<!-- wp:image {\"id\":$id,\"sizeSlug\":\"large\",\"linkDestination\":\"none\"} -->\n<figure class=\"wp-block-image size-large\"><img src=\"" . ngki_url( $id ) . "\" alt=\"" . ngki_alt( $id ) . "\" class=\"wp-image-$id\"/></figure>\n<!-- /wp:image -->";
}
$b .= "</figure>\n<!-- /wp:gallery -->\n";

$b .= "<!-- wp:list -->\n<ul class=\"wp-block-list\">"
	. "<!-- wp:list-item --><li>Đổ nến thơm &amp; wax melts theo mùi yêu thích</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li>Làm đá khuếch tán hoa mẫu đơn từ Jesmonite an toàn, thân thiện môi trường</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li>Pha nước hoa khô / nước hoa dạng xịt của riêng bạn</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li>Mang về thành phẩm cùng một khoảng lặng dễ chịu</li><!-- /wp:list-item --></ul>\n<!-- /wp:list -->\n";

$b .= "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Thành phẩm xinh xắn mang về</h2>\n<!-- /wp:heading -->\n";
$b .= "<!-- wp:image {\"id\":{$img['ws-03']},\"sizeSlug\":\"large\",\"linkDestination\":\"none\"} -->\n<figure class=\"wp-block-image size-large\"><img src=\"" . ngki_url( $img['ws-03'] ) . "\" alt=\"" . ngki_alt( $img['ws-03'] ) . "\" class=\"wp-image-{$img['ws-03']}\"/></figure>\n<!-- /wp:image -->\n";

$b .= "<!-- wp:paragraph -->\n<p>Lịch workshop mở theo đợt với nhóm nhỏ. Nếu bạn muốn tham gia, hãy <a href=\"/contact-us/\">nhắn Nghikigai</a> để biết lịch gần nhất và giữ chỗ nhé.</p>\n<!-- /wp:paragraph -->\n";

$b .= "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"/workshop/\">Xem chi tiết workshop</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->\n";

$post = array(
	'post_title'   => 'Tiny Treasures - buổi workshop làm nến chữa lành tại Nghikigai',
	'post_name'    => $slug,
	'post_content' => $b,
	'post_status'  => 'publish',
	'post_type'    => 'post',
	'post_excerpt' => 'Một buổi chiều chậm rãi tự tay làm nến, wax melts và nước hoa khô cùng Nghikigai - chuỗi workshop Tiny Treasures.',
);
if ( $exist ) { $post['ID'] = $exist->ID; $pid = wp_update_post( $post ); } else { $pid = wp_insert_post( $post ); }
set_post_thumbnail( $pid, $img['ws-01'] );

// gán category "Tin tức" (tạo nếu chưa có)
$cat = get_term_by( 'name', 'Tin tức', 'category' );
if ( ! $cat ) { $r = wp_insert_term( 'Tin tức', 'category', array( 'slug' => 'tin-tuc' ) ); $cat_id = is_wp_error( $r ) ? 0 : $r['term_id']; }
else { $cat_id = $cat->term_id; }
if ( $cat_id ) { wp_set_post_categories( $pid, array( (int) $cat_id ) ); }

WP_CLI::success( "Blog post #$pid (Tiny Treasures) xong. Featured + gallery ảnh thật." );
