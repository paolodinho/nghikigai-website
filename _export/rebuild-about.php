<?php
/**
 * Dựng lại trang Về chúng tôi: hero ảnh phủ + bố cục text-ảnh xen kẽ + CTA (đỡ trống, giàu hình).
 * Chạy: wp eval-file _export/rebuild-about.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function img_url( $id, $fallback_slug = 'nen-ke-chuyen-a-cup-of-peace' ) {
	$u = wp_get_attachment_image_url( $id, 'large' );
	if ( $u ) { return array( $id, $u ); }
	$p = get_page_by_path( $fallback_slug, OBJECT, 'product' );
	if ( $p ) { $t = get_post_thumbnail_id( $p->ID ); return array( $t, wp_get_attachment_image_url( $t, 'large' ) ); }
	return array( 0, '' );
}
list( $heroId, $hero )   = img_url( 286 );
list( $storyId, $story ) = img_url( 262 );
list( $commId, $comm )   = img_url( 266 );

$c = '';

/* HERO: cover ảnh + overlay xanh + tiêu đề trắng */
$c .= "<!-- wp:cover {\"url\":\"$hero\",\"id\":$heroId,\"dimRatio\":60,\"overlayColor\":\"\",\"customOverlayColor\":\"#2f4a35\",\"minHeight\":420,\"isDark\":true,\"align\":\"full\",\"style\":{\"spacing\":{\"padding\":{\"top\":\"80px\",\"bottom\":\"80px\"}}}} -->\n"
	. "<div class=\"wp-block-cover alignfull is-dark\" style=\"padding-top:80px;padding-bottom:80px;min-height:420px\"><span aria-hidden=\"true\" class=\"wp-block-cover__background has-background-dim-60 has-background-dim\" style=\"background-color:#2f4a35\"></span>"
	. "<img class=\"wp-block-cover__image-background wp-image-$heroId\" alt=\"\" src=\"$hero\" data-object-fit=\"cover\"/>"
	. "<div class=\"wp-block-cover__inner-container\">"
	. "<!-- wp:heading {\"textAlign\":\"center\",\"level\":1,\"textColor\":\"white\",\"style\":{\"color\":{\"text\":\"#ffffff\"}}} -->\n<h1 class=\"wp-block-heading has-text-align-center has-text-color\" style=\"color:#ffffff\">Về chúng tôi</h1>\n<!-- /wp:heading -->\n"
	. "<!-- wp:paragraph {\"align\":\"center\",\"style\":{\"color\":{\"text\":\"#e8efe9\"}}} -->\n<p class=\"has-text-align-center has-text-color\" style=\"color:#e8efe9\">Hương thơm kể chuyện - nơi mỗi mùi hương là một khoảnh khắc an yên dành cho bạn.</p>\n<!-- /wp:paragraph -->\n"
	. "</div></div>\n<!-- /wp:cover -->\n";

/* CÂU CHUYỆN: text trái + ảnh phải */
$c .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"64px\",\"bottom\":\"32px\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\" style=\"padding-top:64px;padding-bottom:32px\">\n"
	. "<!-- wp:columns {\"verticalAlignment\":\"center\",\"style\":{\"spacing\":{\"blockGap\":{\"left\":\"48px\"}}}} -->\n<div class=\"wp-block-columns are-vertically-aligned-center\">\n"
	. "<!-- wp:column {\"verticalAlignment\":\"center\",\"width\":\"58%\"} -->\n<div class=\"wp-block-column is-vertically-aligned-center\" style=\"flex-basis:58%\">"
	. "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Câu chuyện Nghikigai</h2>\n<!-- /wp:heading -->\n"
	. "<!-- wp:paragraph -->\n<p>Nghikigai ra đời từ mong muốn đem đến cho mọi người những khoảnh khắc tĩnh lặng, nơi tâm hồn được chạm vào sự an yên. Cái tên được lấy cảm hứng từ “Ikigai” - triết lý sống Nhật Bản về việc tìm thấy ý nghĩa và niềm vui trong từng khoảnh khắc.</p>\n<!-- /wp:paragraph -->\n"
	. "<!-- wp:paragraph -->\n<p>Mỗi sản phẩm không chỉ là một món hương thơm, mà còn là lời nhắn nhủ: hãy yêu thương bản thân, sống chậm lại để trân trọng từng khoảnh khắc - dù là dành cho mình hay tặng người thương.</p>\n<!-- /wp:paragraph -->\n"
	. "</div>\n<!-- /wp:column -->\n"
	. "<!-- wp:column {\"verticalAlignment\":\"center\",\"width\":\"42%\"} -->\n<div class=\"wp-block-column is-vertically-aligned-center\" style=\"flex-basis:42%\">"
	. "<!-- wp:image {\"id\":$storyId,\"sizeSlug\":\"large\",\"style\":{\"border\":{\"radius\":\"16px\"}}} -->\n<figure class=\"wp-block-image size-large has-custom-border\"><img src=\"$story\" alt=\"Nghikigai\" class=\"wp-image-$storyId\" style=\"border-radius:16px\"/></figure>\n<!-- /wp:image -->\n"
	. "</div>\n<!-- /wp:column -->\n"
	. "</div>\n<!-- /wp:columns -->\n</div>\n<!-- /wp:group -->\n";

/* CAM KẾT: ảnh trái + text phải (nền nhạt) */
$c .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"56px\",\"bottom\":\"56px\"}},\"color\":{\"background\":\"#f1f6f2\"}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group has-background\" style=\"background-color:#f1f6f2;padding-top:56px;padding-bottom:56px\">\n"
	. "<!-- wp:columns {\"verticalAlignment\":\"center\",\"style\":{\"spacing\":{\"blockGap\":{\"left\":\"48px\"}}}} -->\n<div class=\"wp-block-columns are-vertically-aligned-center\">\n"
	. "<!-- wp:column {\"verticalAlignment\":\"center\",\"width\":\"42%\"} -->\n<div class=\"wp-block-column is-vertically-aligned-center\" style=\"flex-basis:42%\">"
	. "<!-- wp:image {\"id\":$commId,\"sizeSlug\":\"large\",\"style\":{\"border\":{\"radius\":\"16px\"}}} -->\n<figure class=\"wp-block-image size-large has-custom-border\"><img src=\"$comm\" alt=\"Cam kết chất lượng Nghikigai\" class=\"wp-image-$commId\" style=\"border-radius:16px\"/></figure>\n<!-- /wp:image -->\n"
	. "</div>\n<!-- /wp:column -->\n"
	. "<!-- wp:column {\"verticalAlignment\":\"center\",\"width\":\"58%\"} -->\n<div class=\"wp-block-column is-vertically-aligned-center\" style=\"flex-basis:58%\">"
	. "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Cam kết chất lượng</h2>\n<!-- /wp:heading -->\n"
	. "<!-- wp:paragraph -->\n<p>Chất lượng là yếu tố cốt lõi để Nghikigai xây dựng niềm tin với khách hàng:</p>\n<!-- /wp:paragraph -->\n"
	. "<!-- wp:list -->\n<ul class=\"wp-block-list\"><!-- wp:list-item --><li>Sáp đậu nành thiên nhiên an toàn.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Tinh dầu chuẩn IFRA, nhập từ Mỹ và châu Âu.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Trải qua quy trình kiểm định nghiêm ngặt.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Bao bì thân thiện môi trường, đóng gói chỉn chu.</li><!-- /wp:list-item --></ul>\n<!-- /wp:list -->\n"
	. "</div>\n<!-- /wp:column -->\n"
	. "</div>\n<!-- /wp:columns -->\n</div>\n<!-- /wp:group -->\n";

/* CTA */
$c .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"56px\",\"bottom\":\"64px\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\" style=\"padding-top:56px;padding-bottom:64px\">\n"
	. "<!-- wp:heading {\"textAlign\":\"center\"} -->\n<h2 class=\"wp-block-heading has-text-align-center\">Bắt đầu hành trình hương thơm của bạn</h2>\n<!-- /wp:heading -->\n"
	. "<!-- wp:buttons {\"layout\":{\"type\":\"flex\",\"justifyContent\":\"center\"}} -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"/shop/\">Khám phá sản phẩm</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->\n"
	. "</div>\n<!-- /wp:group -->\n";

$p = get_page_by_path( 'about-us', OBJECT, 'page' );
wp_update_post( array( 'ID' => $p->ID, 'post_content' => $c ) );
update_post_meta( $p->ID, '_kad_post_title', 'hide' );   // ẩn dải tiêu đề trống của Kadence
update_post_meta( $p->ID, '_kad_post_layout', 'fullwidth' ); // hero phủ tràn
WP_CLI::success( 'About dựng lại (hero ảnh + text-ảnh + CTA), ẩn dải tiêu đề trống. #' . $p->ID );
