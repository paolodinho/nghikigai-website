<?php
/**
 * Tạo favicon vuông từ logo + trang Workshop "Letter to Soul" + thêm vào menu.
 * Chạy: wp eval-file _export/build-workshop-favicon.php -- <duong_dan_logo_webp>
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once ABSPATH . 'wp-admin/includes/image.php';

/* ---------- FAVICON 512x512 ---------- */
$logo = $args[0] ?? '';
if ( $logo && file_exists( $logo ) && function_exists( 'imagecreatefromwebp' ) ) {
	$src = imagecreatefromwebp( $logo );
	$sw = imagesx( $src ); $sh = imagesy( $src );
	$canvas = imagecreatetruecolor( 512, 512 );
	$green = imagecolorallocate( $canvas, 64, 98, 71 ); // #406247 nền logo
	imagefilledrectangle( $canvas, 0, 0, 512, 512, $green );
	$lw = 460; $lh = (int) round( $lw * $sh / $sw );
	imagecopyresampled( $canvas, $src, (int) ( ( 512 - $lw ) / 2 ), (int) ( ( 512 - $lh ) / 2 ), 0, 0, $lw, $lh, $sw, $sh );
	$up = wp_upload_dir();
	$fav_path = $up['path'] . '/nghikigai-favicon.png';
	imagepng( $canvas, $fav_path );
	imagedestroy( $canvas ); imagedestroy( $src );

	$att = array( 'post_mime_type' => 'image/png', 'post_title' => 'Nghikigai favicon', 'post_status' => 'inherit' );
	$aid = wp_insert_attachment( $att, $fav_path );
	wp_update_attachment_metadata( $aid, wp_generate_attachment_metadata( $aid, $fav_path ) );
	update_option( 'site_icon', $aid );
	WP_CLI::log( "Favicon 512x512 #$aid đã set." );
} else {
	WP_CLI::warning( 'Bỏ qua favicon (thiếu logo hoặc GD webp).' );
}

/* ---------- WORKSHOP PAGE ---------- */
// ảnh nến cho hero (lấy featured của 1 sản phẩm nến)
$hero_img = '';
$cands = get_posts( array( 'post_type' => 'product', 'numberposts' => 1, 'tax_query' => array( array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => 'nen-ke-chuyen' ) ) ) );
if ( $cands ) { $tid = get_post_thumbnail_id( $cands[0]->ID ); if ( $tid ) { $hero_img = wp_get_attachment_image_url( $tid, 'large' ); } }

$w  = "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"64px\",\"bottom\":\"40px\"}},\"color\":{\"background\":\"#fff5f8\"}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group has-background\" style=\"background-color:#fff5f8;padding-top:64px;padding-bottom:40px\">\n";
$w .= "<!-- wp:heading {\"textAlign\":\"center\",\"level\":1} -->\n<h1 class=\"wp-block-heading has-text-align-center\">Workshop làm nến - Letter to Soul</h1>\n<!-- /wp:heading -->\n";
$w .= "<!-- wp:paragraph {\"align\":\"center\"} -->\n<p class=\"has-text-align-center\">Một buổi chiều chậm rãi: tự tay làm hũ nến thơm và viết những lời động viên gửi cho chính mình hoặc người thương.</p>\n<!-- /wp:paragraph -->\n";
if ( $hero_img ) { $w .= "<!-- wp:image {\"align\":\"center\",\"sizeSlug\":\"large\",\"style\":{\"border\":{\"radius\":\"16px\"}}} -->\n<figure class=\"wp-block-image aligncenter size-large has-custom-border\"><img src=\"$hero_img\" alt=\"Workshop nến Nghikigai\" style=\"border-radius:16px\"/></figure>\n<!-- /wp:image -->\n"; }
$w .= "</div>\n<!-- /wp:group -->\n";

$w .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"48px\",\"bottom\":\"48px\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\" style=\"padding-top:48px;padding-bottom:48px\">\n";
$w .= "<!-- wp:heading {\"level\":2} -->\n<h2 class=\"wp-block-heading\">Bạn sẽ trải nghiệm gì?</h2>\n<!-- /wp:heading -->\n";
$w .= "<!-- wp:list -->\n<ul class=\"wp-block-list\">"
	. "<!-- wp:list-item --><li>Tự tay làm một hũ nến thơm từ sáp thiên nhiên và tinh dầu độc quyền của Nghikigai.</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li>Viết “lời động viên” cho bản thân hoặc người đồng hành, đặt vào trong nến.</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li>Trò chuyện nhẹ nhàng về công việc, thử thách và những điều đang chờ phía trước.</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li>Mang về thành phẩm của riêng bạn cùng một khoảng lặng dễ chịu.</li><!-- /wp:list-item --></ul>\n<!-- /wp:list -->\n";
$w .= "<!-- wp:heading {\"level\":2} -->\n<h2 class=\"wp-block-heading\">Thông tin buổi workshop</h2>\n<!-- /wp:heading -->\n";
$w .= "<!-- wp:list -->\n<ul class=\"wp-block-list\">"
	. "<!-- wp:list-item --><li><strong>Thời lượng:</strong> ~2.5 giờ</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>Số lượng:</strong> tối đa 10 người/buổi (không gian ấm cúng)</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>Học phí tham khảo:</strong> 500.000đ/người (đã gồm nguyên liệu &amp; thành phẩm)</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>Địa điểm:</strong> Hẻm 341 Nguyễn Trãi, P. Nguyễn Cư Trinh, Quận 1, TP.HCM</li><!-- /wp:list-item --></ul>\n<!-- /wp:list -->\n";
$w .= "<!-- wp:paragraph -->\n<p>Lịch workshop mở theo đợt. Nhắn Nghikigai để biết lịch gần nhất và giữ chỗ nhé.</p>\n<!-- /wp:paragraph -->\n";
$w .= "<!-- wp:buttons {\"layout\":{\"type\":\"flex\"}} -->\n<div class=\"wp-block-buttons\">"
	. "<!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"/contact-us/\">Đăng ký / Tư vấn</a></div>\n<!-- /wp:button -->"
	. "<!-- wp:button {\"className\":\"is-style-outline\"} -->\n<div class=\"wp-block-button is-style-outline\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://zalo.me/g/scuniy748\">Tham gia nhóm Zalo</a></div>\n<!-- /wp:button -->"
	. "</div>\n<!-- /wp:buttons -->\n";
$w .= "</div>\n<!-- /wp:group -->\n";

$slug = 'workshop';
$existing = get_page_by_path( $slug, OBJECT, 'page' );
$data = array( 'post_title' => 'Workshop', 'post_name' => $slug, 'post_content' => $w, 'post_status' => 'publish', 'post_type' => 'page' );
if ( $existing ) { $data['ID'] = $existing->ID; $wid = wp_update_post( $data ); } else { $wid = wp_insert_post( $data ); }
WP_CLI::log( "Trang Workshop #$wid." );

/* ---------- Thêm Workshop vào menu (trước Liên hệ) ---------- */
$menu = wp_get_nav_menu_object( 'Menu chính' );
if ( $menu ) {
	$items = wp_get_nav_menu_items( $menu->term_id );
	$exists_ws = false;
	foreach ( $items as $it ) { if ( (int) $it->object_id === (int) $wid && $it->object === 'page' ) { $exists_ws = true; } }
	if ( ! $exists_ws ) {
		// đặt order ngay trước item "Liên hệ"
		$lien_he_order = null;
		foreach ( $items as $it ) { if ( $it->title === 'Liên hệ' ) { $lien_he_order = $it->menu_order; } }
		wp_update_nav_menu_item( $menu->term_id, 0, array(
			'menu-item-title'     => 'Workshop',
			'menu-item-type'      => 'post_type',
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $wid,
			'menu-item-status'    => 'publish',
			'menu-item-position'  => $lien_he_order ? $lien_he_order : 99,
		) );
		WP_CLI::log( 'Đã thêm Workshop vào menu.' );
	}
}

WP_CLI::success( 'Workshop + favicon + menu xong.' );
