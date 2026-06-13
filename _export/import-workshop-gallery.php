<?php
/**
 * Import ảnh thật buổi Workshop (folder WS Hiếu gửi) vào Media Library,
 * rồi dựng lại trang Workshop với tên & nội dung THẬT ("Tiny Treasures").
 * Chạy: ./_bin/wp.sh eval-file _export/import-workshop-gallery.php -- "<đường_dẫn_thư_mục_ws_images>"
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once ABSPATH . 'wp-admin/includes/image.php';

$dir = $args[0] ?? '';
if ( ! $dir || ! is_dir( $dir ) ) { WP_CLI::error( "Thiếu/không thấy thư mục ảnh: $dir" ); }

$files = glob( rtrim( $dir, '/' ) . '/ws-*.jpg' );
sort( $files );
if ( ! $files ) { WP_CLI::error( 'Không có file ws-*.jpg trong thư mục.' ); }

$alts = array(
	'ws-01' => 'Bộ tinh dầu thơm thương hiệu Nghikigai dùng trong workshop',
	'ws-02' => 'Wax melts Nghikigai (Rosemary & Lavender, Sakura) và đèn xông',
	'ws-03' => 'Ly thuỷ tinh trang trí thành phẩm tại workshop Nghikigai',
	'ws-04' => 'Bàn nguyên liệu làm nến: tinh dầu, sáp, hũ thuỷ tinh',
	'ws-05' => 'Tinh dầu và sáp trang trí nhiều màu cho buổi làm nến',
	'ws-06' => 'Giỏ nguyên liệu hoa khô, quế, tinh dầu của Nghikigai',
	'ws-07' => 'Không gian buổi workshop làm nến ấm cúng',
	'ws-08' => 'Không gian tổ chức workshop Nghikigai',
);

$up = wp_upload_dir();
$ids = array();
foreach ( $files as $src ) {
	$base = basename( $src );                 // ws-01.jpg
	$key  = preg_replace( '/\.jpg$/', '', $base );

	// idempotent: tìm theo meta _ngki_ws
	$found = get_posts( array(
		'post_type'   => 'attachment',
		'numberposts' => 1,
		'meta_key'    => '_ngki_ws',
		'meta_value'  => $key,
		'fields'      => 'ids',
	) );
	if ( $found ) { $ids[ $key ] = (int) $found[0]; WP_CLI::log( "Đã có $key (#{$found[0]}) - bỏ qua." ); continue; }

	$dst = trailingslashit( $up['path'] ) . $base;
	if ( ! @copy( $src, $dst ) ) { WP_CLI::warning( "Copy lỗi: $base" ); continue; }

	$alt = $alts[ $key ] ?? 'Workshop Nghikigai';
	$att = array(
		'post_mime_type' => 'image/jpeg',
		'post_title'     => 'Workshop Nghikigai - ' . $key,
		'post_status'    => 'inherit',
		'post_content'   => '',
		'post_excerpt'   => $alt,
	);
	$aid = wp_insert_attachment( $att, $dst );
	wp_update_attachment_metadata( $aid, wp_generate_attachment_metadata( $aid, $dst ) );
	update_post_meta( $aid, '_wp_attachment_image_alt', $alt );
	update_post_meta( $aid, '_ngki_ws', $key );
	$ids[ $key ] = (int) $aid;
	WP_CLI::log( "Import $key → #$aid" );
}

ksort( $ids );
$id_list = array_values( $ids );
if ( count( $id_list ) < 1 ) { WP_CLI::error( 'Không import được ảnh nào.' ); }

$hero_id  = $id_list[0];
$hero_url = wp_get_attachment_image_url( $hero_id, 'full' );

/* ---------- DỰNG NỘI DUNG TRANG WORKSHOP ---------- */
$c  = "";

// HERO cover (ảnh thật bộ tinh dầu)
$c .= "<!-- wp:cover {\"url\":\"$hero_url\",\"id\":$hero_id,\"dimRatio\":60,\"overlayColor\":\"black\",\"isDark\":true,\"minHeight\":420,\"className\":\"ngki-hero\",\"align\":\"full\"} -->\n";
$c .= "<div class=\"wp-block-cover alignfull is-dark ngki-hero\" style=\"min-height:420px\"><span aria-hidden=\"true\" class=\"wp-block-cover__background has-black-background-color has-background-dim-60 has-background-dim\"></span><img class=\"wp-block-cover__image-background wp-image-$hero_id\" alt=\"\" src=\"$hero_url\" data-object-fit=\"cover\"/><div class=\"wp-block-cover__inner-container\">\n";
$c .= "<!-- wp:heading {\"textAlign\":\"center\",\"level\":1,\"textColor\":\"white\"} -->\n<h1 class=\"wp-block-heading has-text-align-center has-white-color has-text-color\">Workshop @Nghikigai</h1>\n<!-- /wp:heading -->\n";
$c .= "<!-- wp:paragraph {\"align\":\"center\",\"textColor\":\"white\"} -->\n<p class=\"has-text-align-center has-white-color has-text-color\"><strong>Tiny Treasures</strong> - Balancing Life's Big Pressures</p>\n<!-- /wp:paragraph -->\n";
$c .= "</div></div>\n<!-- /wp:cover -->\n";

// Giới thiệu
$c .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"48px\",\"bottom\":\"24px\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\" style=\"padding-top:48px;padding-bottom:24px\">\n";
$c .= "<!-- wp:paragraph {\"align\":\"center\"} -->\n<p class=\"has-text-align-center\">Nghikigai tổ chức những buổi workshop nhẹ nhàng, hướng dẫn bạn tự tay làm đồ handmade: nến thơm, wax melts, nước hoa khô, nước hoa dạng xịt... Một khoảng lặng dễ chịu để cân bằng giữa những áp lực của cuộc sống.</p>\n<!-- /wp:paragraph -->\n";
$c .= "</div>\n<!-- /wp:group -->\n";

// "Nghikigai có" - nội dung thật từ flyer
$c .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"24px\",\"bottom\":\"24px\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\" style=\"padding-top:24px;padding-bottom:24px\">\n";
$c .= "<!-- wp:heading {\"level\":2} -->\n<h2 class=\"wp-block-heading\">Tại workshop, Nghikigai có</h2>\n<!-- /wp:heading -->\n";
$c .= "<!-- wp:list -->\n<ul class=\"wp-block-list\">"
	. "<!-- wp:list-item --><li><strong>Nến Stories &amp; Wax melts</strong> - tự tay đổ nến thơm và sáp thơm theo mùi yêu thích.</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>Đá khuếch tán hoa mẫu đơn</strong> làm từ Jesmonite - nguyên liệu gốc đất, an toàn cho sức khoẻ và thân thiện môi trường.</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>White sage &amp; viên xịt thư giãn</strong> - hương thơm giúp thư thái tinh thần.</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>Nước hoa handmade dạng xịt</strong> - pha mùi của riêng bạn.</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>Thiết kế phần quà theo dịp đặc biệt</strong> như Valentine, sinh nhật, kỷ niệm.</li><!-- /wp:list-item --></ul>\n<!-- /wp:list -->\n";
$c .= "</div>\n<!-- /wp:group -->\n";

// GALLERY ảnh thật
$g  = "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"16px\",\"bottom\":\"40px\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\" style=\"padding-top:16px;padding-bottom:40px\">\n";
$g .= "<!-- wp:heading {\"textAlign\":\"center\",\"level\":2} -->\n<h2 class=\"wp-block-heading has-text-align-center\">Khoảnh khắc tại workshop</h2>\n<!-- /wp:heading -->\n";
$g .= "<!-- wp:gallery {\"columns\":3,\"linkTo\":\"none\",\"sizeSlug\":\"large\"} -->\n<figure class=\"wp-block-gallery has-nested-images columns-3 is-cropped\">";
foreach ( $id_list as $aid ) {
	$url = wp_get_attachment_image_url( $aid, 'large' );
	$alt = get_post_meta( $aid, '_wp_attachment_image_alt', true );
	$g .= "<!-- wp:image {\"id\":$aid,\"sizeSlug\":\"large\",\"linkDestination\":\"none\"} -->\n<figure class=\"wp-block-image size-large\"><img src=\"$url\" alt=\"" . esc_attr( $alt ) . "\" class=\"wp-image-$aid\"/></figure>\n<!-- /wp:image -->";
}
$g .= "</figure>\n<!-- /wp:gallery -->\n";
$g .= "</div>\n<!-- /wp:group -->\n";
$c .= $g;

// Thông tin + CTA
$c .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"24px\",\"bottom\":\"48px\"}},\"color\":{\"background\":\"#f4f7f4\"}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group has-background\" style=\"background-color:#f4f7f4;padding-top:24px;padding-bottom:48px\">\n";
$c .= "<!-- wp:heading {\"level\":2} -->\n<h2 class=\"wp-block-heading\">Thông tin buổi workshop</h2>\n<!-- /wp:heading -->\n";
$c .= "<!-- wp:list -->\n<ul class=\"wp-block-list\">"
	. "<!-- wp:list-item --><li><strong>Thời lượng:</strong> khoảng 2-2.5 giờ</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>Số lượng:</strong> nhóm nhỏ, không gian ấm cúng</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>Bao gồm:</strong> nguyên liệu, dụng cụ và thành phẩm mang về</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li><strong>Địa điểm:</strong> Hẻm 341 Nguyễn Trãi, P. Nguyễn Cư Trinh, Quận 1, TP.HCM</li><!-- /wp:list-item --></ul>\n<!-- /wp:list -->\n";
$c .= "<!-- wp:paragraph -->\n<p>Lịch workshop mở theo đợt. Nhắn Nghikigai để biết lịch gần nhất và giữ chỗ nhé.</p>\n<!-- /wp:paragraph -->\n";
$c .= "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\">"
	. "<!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"/contact-us/\">Đăng ký / Tư vấn</a></div>\n<!-- /wp:button -->"
	. "<!-- wp:button {\"className\":\"is-style-outline\"} -->\n<div class=\"wp-block-button is-style-outline\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://zalo.me/g/scuniy748\">Tham gia nhóm Zalo</a></div>\n<!-- /wp:button -->"
	. "</div>\n<!-- /wp:buttons -->\n";
$c .= "</div>\n<!-- /wp:group -->\n";

$slug = 'workshop';
$existing = get_page_by_path( $slug, OBJECT, 'page' );
$data = array( 'post_title' => 'Workshop', 'post_name' => $slug, 'post_content' => $c, 'post_status' => 'publish', 'post_type' => 'page' );
if ( $existing ) { $data['ID'] = $existing->ID; $wid = wp_update_post( $data ); } else { $wid = wp_insert_post( $data ); }
update_post_meta( $wid, '_kad_post_title', 'hide' ); // ẩn title trùng (đã có H1 trong hero)
WP_CLI::success( "Workshop #$wid dựng xong với " . count( $id_list ) . " ảnh thật." );
