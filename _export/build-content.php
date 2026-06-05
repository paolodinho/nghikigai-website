<?php
/**
 * Dựng trang + menu + front page cho Nghikigai bằng block Gutenberg + shortcode Woo.
 * Chạy: wp eval-file _export/build-content.php
 * Idempotent: cập nhật theo slug nếu trang đã tồn tại.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function ngki_upsert_page( $slug, $title, $content, $template = '' ) {
	$existing = get_page_by_path( $slug, OBJECT, 'page' );
	$data = array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'page',
	);
	if ( $existing ) { $data['ID'] = $existing->ID; $id = wp_update_post( $data ); }
	else { $id = wp_insert_post( $data ); }
	if ( $template ) { update_post_meta( $id, '_kad_post_layout', $template ); }
	WP_CLI::log( "Trang: $title (#$id)" );
	return $id;
}

/* helpers block markup */
function h_heading( $text, $level = 2, $align = 'center' ) {
	return "<!-- wp:heading {\"textAlign\":\"$align\",\"level\":$level} -->\n<h$level class=\"wp-block-heading has-text-align-$align\">$text</h$level>\n<!-- /wp:heading -->\n";
}
function h_para( $text, $align = 'left' ) {
	$a = $align !== 'left' ? " {\"align\":\"$align\"}" : '';
	$c = $align !== 'left' ? " has-text-align-$align" : '';
	return "<!-- wp:paragraph$a -->\n<p class=\"$c\">$text</p>\n<!-- /wp:paragraph -->\n";
}
function h_shortcode( $sc ) {
	return "<!-- wp:shortcode -->\n$sc\n<!-- /wp:shortcode -->\n";
}
function h_details( $q, $a ) {
	return "<!-- wp:details -->\n<details class=\"wp-block-details\"><summary>" . esc_html( $q ) . "</summary>"
		. "<!-- wp:paragraph -->\n<p>" . esc_html( $a ) . "</p>\n<!-- /wp:paragraph --></details>\n<!-- /wp:details -->\n";
}
function h_button( $text, $url ) {
	return "<!-- wp:buttons {\"layout\":{\"type\":\"flex\",\"justifyContent\":\"center\"}} -->\n<div class=\"wp-block-buttons\">"
		. "<!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"$url\">$text</a></div>\n<!-- /wp:button -->"
		. "</div>\n<!-- /wp:buttons -->\n";
}

/* ---------------- TRANG CHỦ ---------------- */
$home  = '';
// Hero
$home .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"80px\",\"bottom\":\"80px\"}},\"color\":{\"background\":\"#fff5f8\"}},\"layout\":{\"type\":\"constrained\"}} -->\n"
	. "<div class=\"wp-block-group\" style=\"background-color:#fff5f8;padding-top:80px;padding-bottom:80px\">\n"
	. h_heading( 'Hương thơm kể chuyện', 1, 'center' )
	. h_para( 'Nến thơm cao cấp, nước hoa độc bản và tinh dầu nội thất - để bạn sống chậm lại và trân trọng từng khoảnh khắc an yên.', 'center' )
	. h_button( 'Khám phá sản phẩm', '/shop/' )
	. "</div>\n<!-- /wp:group -->\n";
// Sản phẩm chính (danh mục)
$home .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"60px\",\"bottom\":\"40px\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\" style=\"padding-top:60px;padding-bottom:40px\">\n"
	. h_heading( 'Sản phẩm chính', 2, 'center' )
	. h_shortcode( '[product_categories number="6" columns="3" parent="0" hide_empty="1"]' )
	. "</div>\n<!-- /wp:group -->\n";
// Bán chạy
$home .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"40px\",\"bottom\":\"40px\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\" style=\"padding-top:40px;padding-bottom:40px\">\n"
	. h_heading( 'Sản phẩm bán chạy', 2, 'center' )
	. h_para( 'Những sản phẩm Nghikigai được khách hàng yêu thích và lựa chọn nhiều nhất.', 'center' )
	. h_shortcode( '[products limit="10" columns="5" orderby="popularity" visibility="visible"]' )
	. "</div>\n<!-- /wp:group -->\n";
// Testimonials
$tts = json_decode( file_get_contents( __DIR__ . '/testimonials_clean.json' ), true );
$cols = '';
foreach ( $tts as $t ) {
	$cols .= "<!-- wp:column -->\n<div class=\"wp-block-column\">\n"
		. "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"24px\",\"right\":\"24px\",\"bottom\":\"24px\",\"left\":\"24px\"}},\"border\":{\"radius\":\"12px\"},\"color\":{\"background\":\"#ffffff\"}},\"layout\":{\"type\":\"constrained\"}} -->\n"
		. "<div class=\"wp-block-group has-background\" style=\"border-radius:12px;background-color:#ffffff;padding:24px\">\n"
		. "<!-- wp:heading {\"level\":4,\"style\":{\"color\":{\"text\":\"#e62a65\"}}} -->\n<h4 class=\"wp-block-heading has-text-color\" style=\"color:#e62a65\">" . esc_html( $t['title'] ) . "</h4>\n<!-- /wp:heading -->\n"
		. h_para( esc_html( $t['body'] ) )
		. "<!-- wp:paragraph {\"style\":{\"typography\":{\"fontStyle\":\"normal\",\"fontWeight\":\"700\"}}} -->\n<p style=\"font-weight:700\">" . esc_html( $t['name'] ) . " <span style=\"font-weight:400;color:#718096\">- " . esc_html( $t['role'] ) . "</span></p>\n<!-- /wp:paragraph -->\n"
		. "</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:column -->\n";
}
$home .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"60px\",\"bottom\":\"60px\"}},\"color\":{\"background\":\"#f7fafc\"}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group has-background\" style=\"background-color:#f7fafc;padding-top:60px;padding-bottom:60px\">\n"
	. h_heading( 'Feedback từ khách hàng', 2, 'center' )
	. "<!-- wp:columns {\"style\":{\"spacing\":{\"blockGap\":{\"left\":\"24px\"}}}} -->\n<div class=\"wp-block-columns\">\n" . $cols . "</div>\n<!-- /wp:columns -->\n"
	. "</div>\n<!-- /wp:group -->\n";
// Blog
$home .= "<!-- wp:group {\"style\":{\"spacing\":{\"padding\":{\"top\":\"60px\",\"bottom\":\"60px\"}}},\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group\" style=\"padding-top:60px;padding-bottom:60px\">\n"
	. h_heading( 'Blog', 2, 'center' )
	. h_para( 'Câu chuyện về hương thơm, sống chậm và những khoảnh khắc an yên.', 'center' )
	. "<!-- wp:latest-posts {\"postsToShow\":3,\"displayPostContentRadio\":\"excerpt\",\"displayPostDate\":true,\"displayFeaturedImage\":true,\"columns\":3,\"postLayout\":\"grid\"} /-->\n"
	. "</div>\n<!-- /wp:group -->\n";

$home_id = ngki_upsert_page( 'trang-chu', 'Trang chủ', $home, 'fullwidth' );

/* ---------------- VỀ CHÚNG TÔI ---------------- */
$about  = h_heading( 'Câu chuyện Nghikigai', 2, 'left' );
$about .= h_para( 'Nghikigai ra đời từ mong muốn đem đến cho mọi người những khoảnh khắc tĩnh lặng, nơi tâm hồn được chạm vào sự an yên. Cái tên được lấy cảm hứng từ “Ikigai” - triết lý sống Nhật Bản về việc tìm thấy ý nghĩa và niềm vui trong từng khoảnh khắc.' );
$about .= h_para( 'Mỗi sản phẩm của Nghikigai không chỉ là một món đồ trang trí hay hương thơm, mà còn là lời nhắn nhủ: hãy yêu thương bản thân, hãy sống chậm lại để trân trọng từng khoảnh khắc. Thương hiệu mong muốn khách hàng tìm thấy niềm vui trong những điều bình dị nhất, dù là dành cho bản thân hay tặng người yêu thương.' );
$about .= h_heading( 'Cam kết chất lượng', 2, 'left' );
$about .= h_para( 'Nghikigai xác định chất lượng là yếu tố cốt lõi để xây dựng niềm tin khách hàng. Các sản phẩm được chế tác từ:' );
$about .= "<!-- wp:list -->\n<ul class=\"wp-block-list\"><!-- wp:list-item --><li>Sáp đậu nành thiên nhiên an toàn</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li>Tinh dầu chuẩn IFRA, nhập từ Mỹ và châu Âu</li><!-- /wp:list-item -->"
	. "<!-- wp:list-item --><li>Trải qua quy trình kiểm định nghiêm ngặt</li><!-- /wp:list-item --></ul>\n<!-- /wp:list -->\n";
$about .= h_para( 'Thương hiệu coi trọng sự hài hòa giữa thẩm mỹ và công năng, đồng thời cam kết phát triển bền vững với bao bì thân thiện môi trường.' );
$about_id = ngki_upsert_page( 'about-us', 'Về chúng tôi', $about );

/* ---------------- FAQs ---------------- */
$faq_data = json_decode( file_get_contents( __DIR__ . '/faqs.json' ), true );
$faq = h_heading( 'Câu hỏi thường gặp', 2, 'center' );
foreach ( $faq_data as $group => $items ) {
	$faq .= h_heading( $group, 3, 'left' );
	foreach ( $items as $qa ) { $faq .= h_details( $qa[0], $qa[1] ); }
}
$faq_id = ngki_upsert_page( 'faqs', 'Câu hỏi thường gặp', $faq );

/* ---------------- LIÊN HỆ ---------------- */
$contact  = h_heading( 'Liên hệ Nghikigai', 2, 'center' );
$contact .= h_para( 'Nghikigai biến hương thơm thành ký ức, cảm xúc và những câu chuyện ở lại cùng bạn. Liên hệ với chúng tôi để được tư vấn.', 'center' );
$contact .= "<!-- wp:columns -->\n<div class=\"wp-block-columns\">\n";
$contact .= "<!-- wp:column -->\n<div class=\"wp-block-column\">"
	. h_heading( 'Thông tin', 3, 'left' )
	. h_para( '<strong>Hotline:</strong> 0382 475 611 · 0938 365 100' )
	. h_para( '<strong>Email:</strong> nghikigai@gmail.com' )
	. h_para( '<strong>Giờ mở cửa:</strong> 10:00 - 18:00 (T2-CN)' )
	. h_para( '<strong>Miễn ship</strong> nội thành TP.HCM cho đơn trên 500K.' )
	. "</div>\n<!-- /wp:column -->\n";
$contact .= "<!-- wp:column -->\n<div class=\"wp-block-column\">"
	. h_heading( 'Kết nối', 3, 'left' )
	. h_para( 'Facebook: <a href="https://facebook.com/nghikigai">facebook.com/nghikigai</a>' )
	. h_para( 'Instagram: <a href="https://instagram.com/nghikigai">instagram.com/nghikigai</a>' )
	. h_para( 'TikTok: <a href="https://tiktok.com/@nghikigai">tiktok.com/@nghikigai</a>' )
	. "</div>\n<!-- /wp:column -->\n";
$contact .= "</div>\n<!-- /wp:columns -->\n";
$contact_id = ngki_upsert_page( 'contact-us', 'Liên hệ', $contact );

/* ---------------- FRONT PAGE ---------------- */
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home_id );
WP_CLI::log( 'Đặt Trang chủ làm front page' );

/* ---------------- MENU ---------------- */
$menu_name = 'Menu chính';
$menu = wp_get_nav_menu_object( $menu_name );
if ( ! $menu ) { $menu_id = wp_create_nav_menu( $menu_name ); }
else { $menu_id = $menu->term_id; // xoá item cũ để dựng lại sạch
	foreach ( wp_get_nav_menu_items( $menu_id ) as $it ) { wp_delete_post( $it->ID, true ); } }

$shop = get_page_by_path( 'shop', OBJECT, 'page' );
$add = function( $title, $obj_id, $type = 'post_type', $object = 'page', $parent = 0, $url = '' ) use ( $menu_id ) {
	$args = array( 'menu-item-title'=>$title, 'menu-item-status'=>'publish', 'menu-item-parent-id'=>$parent );
	if ( $type === 'custom' ) { $args['menu-item-type']='custom'; $args['menu-item-url']=$url; }
	elseif ( $type === 'taxonomy' ) { $args['menu-item-type']='taxonomy'; $args['menu-item-object']=$object; $args['menu-item-object-id']=$obj_id; }
	else { $args['menu-item-type']='post_type'; $args['menu-item-object']=$object; $args['menu-item-object-id']=$obj_id; }
	return wp_update_nav_menu_item( $menu_id, 0, $args );
};
$add( 'Trang chủ', $home_id, 'post_type', 'page' );
if ( $shop ) { $add( 'Shop', $shop->ID, 'post_type', 'page' ); }
$dm = $add( 'Danh mục', 0, 'custom', 'page', 0, '/shop/' );
foreach ( get_terms( array( 'taxonomy'=>'product_cat', 'hide_empty'=>true ) ) as $term ) {
	if ( $term->slug === 'uncategorized' ) { continue; }
	$add( $term->name, $term->term_id, 'taxonomy', 'product_cat', $dm );
}
$add( 'Về chúng tôi', $about_id, 'post_type', 'page' );
$add( 'Câu hỏi thường gặp', $faq_id, 'post_type', 'page' );
$add( 'Liên hệ', $contact_id, 'post_type', 'page' );

$locations = get_theme_mod( 'nav_menu_locations', array() );
$locations['primary'] = $menu_id;
$locations['main'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );
WP_CLI::log( 'Menu chính đã dựng + gán vị trí primary' );

WP_CLI::success( 'Dựng nội dung + menu + front page hoàn tất.' );
