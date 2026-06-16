<?php
/**
 * Nghikigai child theme (Kadence) - functions
 *
 * Nguyên tắc: chỉ enqueue style/script. KHÔNG hardcode nội dung.
 * Mọi nội dung trang/khối → chỉnh trong WP editor (khách tự làm được).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NGHIKIGAI_VERSION', '1.4.1' );

/**
 * Enqueue parent + child styles.
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'kadence-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'kadence' )->get( 'Version' )
	);

	wp_enqueue_style(
		'nghikigai-theme',
		get_stylesheet_directory_uri() . '/assets/css/theme.css',
		array( 'kadence-parent' ),
		NGHIKIGAI_VERSION
	);

	wp_enqueue_script(
		'nghikigai-reveal',
		get_stylesheet_directory_uri() . '/assets/js/reveal.js',
		array(),
		NGHIKIGAI_VERSION,
		true
	);
}, 20 );

/**
 * Sản phẩm chưa có giá (vd: Quà tặng theo yêu cầu) → hiển thị "Liên hệ".
 */
add_filter( 'woocommerce_get_price_html', function ( $price, $product ) {
	if ( '' === $product->get_price() || '0' === (string) $product->get_price() ) {
		return '<span class="ngki-contact-price">Liên hệ</span>';
	}
	// Rule Hiếu: không dùng em/en dash → khoảng giá dùng "-".
	return str_replace( array( '&ndash;', '&mdash;', '-', '-' ), '-', $price );
}, 10, 2 );

/**
 * Chuẩn hoá mọi gạch dài en/em dash → "-" trong khoảng giá (Price range: from-to).
 */
add_filter( 'gettext_with_context', function ( $translated, $text, $context, $domain ) {
	if ( 'woocommerce' === $domain && 'Price range: from-to' === $context ) {
		return '%1$s - %2$s';
	}
	return $translated;
}, 20, 4 );

add_filter( 'woocommerce_is_purchasable', function ( $purchasable, $product ) {
	// Cho phép thêm vào giỏ kể cả khi giá 0 (đơn theo yêu cầu) - giữ nút bấm hoạt động.
	return $purchasable;
}, 10, 2 );

/**
 * Rule Hiếu: KHÔNG để WordPress tự đổi " - " thành en/em dash (wptexturize).
 */
add_filter( 'run_wptexturize', '__return_false' );

/**
 * Tối ưu nhẹ: bỏ emoji script (không cần), giảm tải trang.
 */
add_action( 'init', function () {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
} );

/**
 * CUSTOMIZER — Toàn bộ nội dung chỉnh tại Appearance > Customize.
 * Khách không cần đụng code: mọi text, link, số liệu đều chỉnh được.
 */
add_action( 'customize_register', function ( $wp ) {

	/* ── PANEL ── */
	$wp->add_panel( 'ngki_panel', [
		'title'    => 'Nghikigai - Cài đặt theme',
		'priority' => 25,
	] );

	/* helper tạo setting + control text/url/textarea */
	$add = function ( $id, $default, $label, $section, $type = 'text', $description = '' ) use ( $wp ) {
		$wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'wp_kses_post', 'transport' => 'refresh' ] );
		$wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => $type, 'description' => $description ] );
	};

	/* ── 1. TOPBAR ── */
	$wp->add_section( 'ngki_topbar', [ 'title' => 'Thông báo đầu trang', 'panel' => 'ngki_panel', 'priority' => 10 ] );
	$add( 'ngki_topbar_text',
		'Miễn ship nội thành TP.HCM cho đơn trên 500K',
		'Nội dung thông báo',
		'ngki_topbar', 'text',
		'Hiển thị thanh xanh trên cùng. Để trống để ẩn.' );

	/* ── 2. HERO ── */
	$wp->add_section( 'ngki_hero', [ 'title' => 'Trang chủ - Phần hero', 'panel' => 'ngki_panel', 'priority' => 20 ] );
	$add( 'ngki_hero_badge',   'Thương hiệu Việt Nam',              'Nhãn nhỏ trên tiêu đề',  'ngki_hero' );
	$add( 'ngki_hero_title_1', 'Hương thơm',                        'Tiêu đề - dòng 1',       'ngki_hero' );
	$add( 'ngki_hero_title_em','kể chuyện',                         'Tiêu đề - dòng in nghiêng','ngki_hero' );
	$add( 'ngki_hero_title_2', 'của bạn',                           'Tiêu đề - dòng 3',       'ngki_hero' );
	$add( 'ngki_hero_desc',    'Mỗi ngọn nến, mỗi chai tinh dầu là một câu chuyện riêng biệt. Nghikigai giúp bạn tìm thấy ý nghĩa trong từng khoảnh khắc bình yên nhất.',
		'Mô tả ngắn', 'ngki_hero', 'textarea' );
	$add( 'ngki_hero_cta1',    'Khám phá ngay',   'Nút CTA chính',    'ngki_hero' );
	$add( 'ngki_hero_cta2',    'Về chúng tôi',    'Nút CTA phụ',      'ngki_hero' );

	/* ── 3. VÌ SAO CHỌN ── */
	$wp->add_section( 'ngki_why', [ 'title' => 'Trang chủ - Vì sao chọn', 'panel' => 'ngki_panel', 'priority' => 30 ] );
	$add( 'ngki_why_badge_num',   '21+',                    'Số liệu nổi bật',          'ngki_why' );
	$add( 'ngki_why_badge_label', 'sản phẩm độc quyền',    'Nhãn dưới số liệu',        'ngki_why' );
	$add( 'ngki_why_title',       'Mỗi ngọn nến là một cam kết với bản thân', 'Tiêu đề', 'ngki_why' );
	$add( 'ngki_why_desc',        'Nghikigai không chỉ bán hương thơm. Chúng tôi tạo ra những khoảnh khắc có ý nghĩa.', 'Mô tả', 'ngki_why', 'textarea' );
	for ( $i = 1; $i <= 4; $i++ ) {
		$defaults = [
			1 => [ '100% sáp tự nhiên, an toàn cho gia đình', 'Sáp cọ, sáp dừa và sáp ong thiên nhiên - cháy sạch, không khói đen, không độc hại. An tâm dùng trong nhà có trẻ nhỏ và thú cưng.' ],
			2 => [ 'Hương thơm phối trộn độc quyền, không đại trà', 'Tinh dầu Mỹ cao cấp, được phối chế riêng biệt cho từng sản phẩm. Bạn sẽ không tìm thấy mùi hương này ở bất kỳ thương hiệu nào khác.' ],
			3 => [ 'Câu chuyện riêng trong từng sản phẩm', 'Mỗi ngọn nến mang tên và câu chuyện có ý nghĩa: Bay đi Ikigai, A New Era of Me, Lost in Calm Forest...' ],
			4 => [ 'Quà tặng tùy chỉnh theo yêu cầu', 'Từ thông điệp bí ẩn trong nến, label riêng, đến hộp quà tặng theo chủ đề - tất cả đều có thể làm theo ý bạn muốn.' ],
		];
		$add( "ngki_why_{$i}_title", $defaults[$i][0], "Lợi ích {$i} - Tiêu đề", 'ngki_why' );
		$add( "ngki_why_{$i}_desc",  $defaults[$i][1], "Lợi ích {$i} - Mô tả",   'ngki_why', 'textarea' );
	}

	/* ── 4. TESTIMONIALS ── */
	$wp->add_section( 'ngki_testi', [ 'title' => 'Trang chủ - Đánh giá', 'panel' => 'ngki_panel', 'priority' => 35 ] );
	$testi_defaults = [
		1 => [ 'Nguyễn Thùy T.', 'A Cup of Peace - 220g', '"Mình mua nến kể chuyện \'A Cup of Peace\' để ngồi đọc sách buổi tối. Mùi hương thật sự rất diệu - nhẹ nhàng, thanh khiết. Lần sau nhất định mua thêm cho bạn bè."' ],
		2 => [ 'Trần Minh H.', 'Nước hoa độc bản - Flora', '"Mua nước hoa Flora làm quà sinh nhật cho người yêu, bạn ấy thích lắm. Điều mình thích là có thể khắc tên và viết lời nhắn riêng - rất chu đáo và ý nghĩa."' ],
		3 => [ 'Lê Phương L.', 'Nến thông điệp bí ẩn', '"Nến thông điệp là món quà độc đáo nhất mình từng tặng. Khi bạn mình đốt lên và đọc được thông điệp bên trong, bạn ấy xúc động lắm."' ],
	];
	for ( $i = 1; $i <= 3; $i++ ) {
		$add( "ngki_testi_{$i}_name",    $testi_defaults[$i][0], "Đánh giá {$i} - Tên",       'ngki_testi' );
		$add( "ngki_testi_{$i}_product", $testi_defaults[$i][1], "Đánh giá {$i} - Sản phẩm",  'ngki_testi' );
		$add( "ngki_testi_{$i}_text",    $testi_defaults[$i][2], "Đánh giá {$i} - Nội dung",  'ngki_testi', 'textarea' );
	}

	/* ── 5. CTA BANNER ── */
	$wp->add_section( 'ngki_cta', [ 'title' => 'Trang chủ - Banner kêu gọi', 'panel' => 'ngki_panel', 'priority' => 40 ] );
	$add( 'ngki_cta_title',  'Miễn phí vận chuyển nội thành TP.HCM', 'Tiêu đề banner',   'ngki_cta' );
	$add( 'ngki_cta_desc',   'Đơn hàng từ 500.000đ - Giao hàng trong ngày - Đóng gói quà tặng miễn phí khi yêu cầu', 'Mô tả', 'ngki_cta', 'textarea' );
	$add( 'ngki_cta_btn1',   'Mua ngay',          'Nút CTA chính',  'ngki_cta' );
	$add( 'ngki_cta_btn2',   'Liên hệ tư vấn',   'Nút CTA phụ',    'ngki_cta' );

	/* ── 6. FOOTER - LIÊN HỆ ── */
	$wp->add_section( 'ngki_footer', [ 'title' => 'Footer - Thông tin liên hệ', 'panel' => 'ngki_panel', 'priority' => 50 ] );
	$add( 'ngki_footer_desc',    'Thương hiệu hương thơm Việt Nam - Mỗi ngọn nến, mỗi chai tinh dầu mang một câu chuyện riêng dành cho bạn. Được làm từ sáp tự nhiên, tinh dầu Mỹ cao cấp.',
		'Mô tả thương hiệu', 'ngki_footer', 'textarea' );
	$add( 'ngki_footer_address', 'Hẻm 341 Nguyễn Trãi, P. Nguyễn Cư Trinh, Quận 1, TP.HCM', 'Địa chỉ', 'ngki_footer' );
	$add( 'ngki_footer_phone',   '0382 475 611 - 0938 365 100', 'Hotline (dùng "-" giữa 2 số)', 'ngki_footer' );
	$add( 'ngki_footer_email',   'nghikigai@gmail.com', 'Email',         'ngki_footer', 'email' );
	$add( 'ngki_footer_hours',   '10:00 - 18:00 (T2-CN)', 'Giờ mở cửa', 'ngki_footer' );
	$add( 'ngki_footer_copy',    'Thiết kế bởi Digito Combat', 'Dòng credit', 'ngki_footer' );

	/* ── 7. MẠNG XÃ HỘI ── */
	$wp->add_section( 'ngki_social', [ 'title' => 'Mạng xã hội', 'panel' => 'ngki_panel', 'priority' => 55 ] );
	$add( 'ngki_social_fb',  'https://facebook.com/nghikigai',   'Facebook URL',  'ngki_social', 'url' );
	$add( 'ngki_social_ig',  'https://instagram.com/nghikigai',  'Instagram URL', 'ngki_social', 'url' );
	$add( 'ngki_social_tt',  'https://tiktok.com/@nghikigai',    'TikTok URL',    'ngki_social', 'url' );
} );
