<?php
/**
 * Cập nhật nội dung TRANG CHỦ cho gọn gàng, dễ đọc, dễ tìm sản phẩm.
 * Không đụng menu/các trang khác. Chạy: wp eval-file _export/update-homepage.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function hb_btn( $text, $url, $center = true ) {
	$lay = $center ? ' {"layout":{"type":"flex","justifyContent":"center"}}' : '';
	$cls = $center ? '' : '';
	return "<!-- wp:buttons$lay -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"$url\">$text</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->\n";
}
function hb_h( $t, $l = 2 ) { return "<!-- wp:heading {\"textAlign\":\"center\",\"level\":$l} -->\n<h$l class=\"wp-block-heading has-text-align-center\">$t</h$l>\n<!-- /wp:heading -->\n"; }
function hb_p( $t ) { return "<!-- wp:paragraph {\"align\":\"center\"} -->\n<p class=\"has-text-align-center\">$t</p>\n<!-- /wp:paragraph -->\n"; }
function hb_sec_open( $pt, $pb, $bg = '', $extra = '' ) {
	$style = "padding-top:{$pt};padding-bottom:{$pb}";
	$bgc = $bg ? ",\"color\":{\"background\":\"$bg\"}" : '';
	$cls = ( $bg ? ' has-background' : '' ) . ( $extra ? ' ' . $extra : '' );
	$bgs = $bg ? "background-color:$bg;" : '';
	$cnAttr = $extra ? ",\"className\":\"$extra\"" : '';
	return "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"$pt\",\"bottom\":\"$pb\"}}$bgc}$cnAttr,\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group$cls\" style=\"$bgs$style\">\n";
}
$close = "</div>\n<!-- /wp:group -->\n";

$h = '';
// Hero - cover ảnh phủ full-width (thay nền phẳng cho đỡ trống)
$hid = 281; $hurl = wp_get_attachment_image_url( $hid, 'full' );
if ( ! $hurl ) { $gp = get_page_by_path( 'nen-ke-chuyen-a-cup-of-peace', OBJECT, 'product' ); $hid = $gp ? get_post_thumbnail_id( $gp->ID ) : 0; $hurl = wp_get_attachment_image_url( $hid, 'full' ); }
$h .= "<!-- wp:cover {\"url\":\"$hurl\",\"id\":$hid,\"dimRatio\":55,\"customOverlayColor\":\"#2f4a35\",\"minHeight\":520,\"isDark\":true,\"align\":\"full\",\"style\":{\"spacing\":{\"padding\":{\"top\":\"100px\",\"bottom\":\"100px\"}}}} -->\n"
	. "<div class=\"wp-block-cover alignfull is-dark ngki-hero\" style=\"padding-top:100px;padding-bottom:100px;min-height:520px\"><span aria-hidden=\"true\" class=\"wp-block-cover__background has-background-dim-50 has-background-dim\" style=\"background-color:#2f4a35\"></span>"
	. "<img class=\"wp-block-cover__image-background wp-image-$hid\" alt=\"\" src=\"$hurl\" data-object-fit=\"cover\"/>"
	. "<div class=\"wp-block-cover__inner-container\">"
	. "<!-- wp:heading {\"textAlign\":\"center\",\"level\":1,\"style\":{\"color\":{\"text\":\"#ffffff\"}}} -->\n<h1 class=\"wp-block-heading has-text-align-center has-text-color\" style=\"color:#ffffff\">Hương thơm kể chuyện</h1>\n<!-- /wp:heading -->\n"
	. "<!-- wp:paragraph {\"align\":\"center\",\"style\":{\"color\":{\"text\":\"#eef3ef\"}}} -->\n<p class=\"has-text-align-center has-text-color\" style=\"color:#eef3ef\">Nến thơm cao cấp, nước hoa độc bản và tinh dầu nội thất - để bạn sống chậm lại và trân trọng từng khoảnh khắc an yên.</p>\n<!-- /wp:paragraph -->\n"
	. hb_btn( 'Khám phá sản phẩm', '/shop/' )
	. "</div></div>\n<!-- /wp:cover -->\n";

// Mua theo danh mục
$h .= hb_sec_open( '64px', '32px' );
$h .= hb_h( 'Mua theo danh mục' );
$h .= hb_p( 'Chọn nhanh dòng sản phẩm bạn yêu thích.' );
$h .= "<!-- wp:shortcode -->\n[product_categories number=\"6\" columns=\"3\" parent=\"0\" hide_empty=\"1\"]\n<!-- /wp:shortcode -->\n";
$h .= $close;

// Bán chạy
$h .= hb_sec_open( '32px', '56px' );
$h .= hb_h( 'Sản phẩm bán chạy' );
$h .= hb_p( 'Những sản phẩm được khách hàng yêu thích và lựa chọn nhiều nhất.' );
$h .= "<!-- wp:shortcode -->\n[products limit=\"8\" columns=\"4\" orderby=\"popularity\" visibility=\"visible\"]\n<!-- /wp:shortcode -->\n";
$h .= hb_btn( 'Xem tất cả sản phẩm', '/shop/' );
$h .= $close;

// Vì sao chọn Nghikigai - 3 card có số (nền xanh nhạt, card trắng - đỡ thưa, trông chủ đích)
$h .= hb_sec_open( '60px', '60px', '#f1f6f2' );
$h .= hb_h( 'Vì sao chọn Nghikigai' );
$h .= hb_p( 'Ba lý do khách hàng tin chọn Nghikigai.' );
$h .= "<!-- wp:columns {\"style\":{\"spacing\":{\"blockGap\":{\"left\":\"24px\"},\"margin\":{\"top\":\"12px\"}}}} -->\n<div class=\"wp-block-columns\" style=\"margin-top:12px\">\n";
$cards = array(
	array( '01', 'Nguyên liệu an toàn', 'Sáp đậu nành thiên nhiên, tinh dầu chuẩn IFRA nhập từ Mỹ &amp; châu Âu.' ),
	array( '02', 'Hương thơm độc bản', 'Mỗi mùi là một câu chuyện, có thể cá nhân hoá theo yêu cầu của bạn.' ),
	array( '03', 'Đóng gói chỉn chu', 'Gói ghém tinh tế kèm thông điệp - sẵn sàng làm quà tặng ý nghĩa.' ),
);
foreach ( $cards as $c ) {
	$h .= "<!-- wp:column -->\n<div class=\"wp-block-column\">"
		. "<!-- wp:group {\"className\":\"ngki-value-card\",\"style\":{\"spacing\":{\"padding\":{\"top\":\"28px\",\"right\":\"24px\",\"bottom\":\"28px\",\"left\":\"24px\"}},\"border\":{\"radius\":\"16px\"},\"color\":{\"background\":\"#ffffff\"}},\"layout\":{\"type\":\"constrained\"}} -->\n"
		. "<div class=\"wp-block-group ngki-value-card has-background\" style=\"border-radius:16px;background-color:#ffffff;padding:28px 24px\">\n"
		. "<!-- wp:paragraph {\"className\":\"ngki-value-num\"} -->\n<p class=\"ngki-value-num\">{$c[0]}</p>\n<!-- /wp:paragraph -->\n"
		. "<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">{$c[1]}</h3>\n<!-- /wp:heading -->\n"
		. "<!-- wp:paragraph -->\n<p>{$c[2]}</p>\n<!-- /wp:paragraph -->\n"
		. "</div>\n<!-- /wp:group -->\n"
		. "</div>\n<!-- /wp:column -->\n";
}
$h .= "</div>\n<!-- /wp:columns -->\n" . $close;

// Testimonials - lưới gọn (CSS grid 3 cột, tự xuống dòng)
$tts = json_decode( file_get_contents( __DIR__ . '/testimonials_clean.json' ), true );
$cards = '';
foreach ( $tts as $t ) {
	$cards .= "<!-- wp:group {\"className\":\"ngki-testi-card\",\"style\":{\"spacing\":{\"padding\":{\"top\":\"22px\",\"right\":\"22px\",\"bottom\":\"22px\",\"left\":\"22px\"}},\"border\":{\"radius\":\"14px\"},\"color\":{\"background\":\"#ffffff\"}},\"layout\":{\"type\":\"constrained\"}} -->\n"
		. "<div class=\"wp-block-group ngki-testi-card has-background\" style=\"border-radius:14px;background-color:#ffffff;padding:22px\">\n"
		. "<!-- wp:paragraph {\"className\":\"ngki-testi-title\",\"style\":{\"color\":{\"text\":\"#406247\"},\"typography\":{\"fontWeight\":\"700\"}}} -->\n<p class=\"ngki-testi-title has-text-color\" style=\"color:#406247;font-weight:700\">“" . esc_html( $t['title'] ) . "”</p>\n<!-- /wp:paragraph -->\n"
		. "<!-- wp:paragraph {\"className\":\"ngki-testi-body\"} -->\n<p class=\"ngki-testi-body\">" . esc_html( $t['body'] ) . "</p>\n<!-- /wp:paragraph -->\n"
		. "<!-- wp:paragraph {\"className\":\"ngki-testi-name\",\"style\":{\"typography\":{\"fontWeight\":\"700\"}}} -->\n<p class=\"ngki-testi-name\" style=\"font-weight:700\">" . esc_html( $t['name'] ) . " <span style=\"font-weight:400;color:#718096\">- " . esc_html( $t['role'] ) . "</span></p>\n<!-- /wp:paragraph -->\n"
		. "</div>\n<!-- /wp:group -->\n";
}
$h .= hb_sec_open( '56px', '56px', '#f7fafc' );
$h .= hb_h( 'Khách hàng nói gì về Nghikigai' );
$h .= "<!-- wp:group {\"className\":\"ngki-testi-grid\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group ngki-testi-grid\">\n" . $cards . "</div>\n<!-- /wp:group -->\n";
$h .= $close;

// CTA cuối - nền xanh đậm logo
$h .= hb_sec_open( '56px', '64px', '#2f4a35' );
$h .= "<!-- wp:heading {\"textAlign\":\"center\",\"level\":2,\"style\":{\"color\":{\"text\":\"#ffffff\"}}} -->\n<h2 class=\"wp-block-heading has-text-align-center has-text-color\" style=\"color:#ffffff\">Tìm một mùi hương cho riêng bạn</h2>\n<!-- /wp:heading -->\n";
$h .= "<!-- wp:paragraph {\"align\":\"center\",\"style\":{\"color\":{\"text\":\"#d9d9d9\"}}} -->\n<p class=\"has-text-align-center has-text-color\" style=\"color:#d9d9d9\">Nhắn Nghikigai để được tư vấn mùi hương phù hợp, hoặc đặt làm theo yêu cầu.</p>\n<!-- /wp:paragraph -->\n";
$h .= hb_btn( 'Liên hệ tư vấn', '/contact-us/' );
$h .= $close;

$home = get_page_by_path( 'trang-chu', OBJECT, 'page' );
wp_update_post( array( 'ID' => $home->ID, 'post_content' => $h ) );
WP_CLI::success( 'Trang chủ cập nhật gọn gàng xong (#' . $home->ID . ').' );
