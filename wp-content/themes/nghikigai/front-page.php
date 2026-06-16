<?php
/**
 * Front Page template - Nghikigai
 * Dùng get_header() / get_footer() → menu + footer đồng nhất với mọi trang.
 *
 * @package nghikigai
 */

add_filter( 'body_class', function( $classes ) {
	$classes[] = 'ngki-fp';
	return $classes;
} );

$raw_products = wc_get_products( [
	'limit'   => 8,
	'status'  => 'publish',
	'orderby' => 'popularity',
	'order'   => 'DESC',
] );

$cats = get_terms( [
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'exclude'    => [ absint( get_option( 'default_product_cat' ) ) ],
	'orderby'    => 'count',
	'order'      => 'DESC',
	'number'     => 5,
] );

/* --- Customizer values --- */
$h_badge   = get_theme_mod( 'ngki_hero_badge',    'Thương hiệu Việt Nam' );
$h_title1  = get_theme_mod( 'ngki_hero_title_1',  'Hương thơm' );
$h_title_em= get_theme_mod( 'ngki_hero_title_em', 'kể chuyện' );
$h_title2  = get_theme_mod( 'ngki_hero_title_2',  'của bạn' );
$h_desc    = get_theme_mod( 'ngki_hero_desc',      'Mỗi ngọn nến, mỗi chai tinh dầu là một câu chuyện riêng biệt. Nghikigai giúp bạn tìm thấy ý nghĩa trong từng khoảnh khắc bình yên nhất.' );
$h_cta1    = get_theme_mod( 'ngki_hero_cta1',     'Khám phá ngay' );
$h_cta2    = get_theme_mod( 'ngki_hero_cta2',     'Về chúng tôi' );

$w_num     = get_theme_mod( 'ngki_why_badge_num',   '21+' );
$w_lbl     = get_theme_mod( 'ngki_why_badge_label', 'sản phẩm độc quyền' );
$w_title   = get_theme_mod( 'ngki_why_title',       'Mỗi ngọn nến là một cam kết với bản thân' );
$w_desc    = get_theme_mod( 'ngki_why_desc',        'Nghikigai không chỉ bán hương thơm. Chúng tôi tạo ra những khoảnh khắc có ý nghĩa.' );
$why_items = [];
$why_defaults = [
	1 => [ '100% sáp tự nhiên, an toàn cho gia đình', 'Sáp cọ, sáp dừa và sáp ong thiên nhiên - cháy sạch, không khói đen, không độc hại. An tâm dùng trong nhà có trẻ nhỏ và thú cưng.' ],
	2 => [ 'Hương thơm phối trộn độc quyền, không đại trà', 'Tinh dầu Mỹ cao cấp, được phối chế riêng biệt cho từng sản phẩm. Bạn sẽ không tìm thấy mùi hương này ở bất kỳ thương hiệu nào khác.' ],
	3 => [ 'Câu chuyện riêng trong từng sản phẩm', 'Mỗi ngọn nến mang tên và câu chuyện có ý nghĩa: Bay đi Ikigai, A New Era of Me, Lost in Calm Forest...' ],
	4 => [ 'Quà tặng tùy chỉnh theo yêu cầu', 'Từ thông điệp bí ẩn trong nến, label riêng, đến hộp quà tặng theo chủ đề - tất cả đều có thể làm theo ý bạn muốn.' ],
];
$why_icons = [
	1 => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
	2 => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="m2 17 10 5 10-5"/><path d="m2 12 10 5 10-5"/></svg>',
	3 => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
	4 => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M12 8v8M8 12h8"/></svg>',
];
for ( $i = 1; $i <= 4; $i++ ) {
	$why_items[$i] = [
		'title' => get_theme_mod( "ngki_why_{$i}_title", $why_defaults[$i][0] ),
		'desc'  => get_theme_mod( "ngki_why_{$i}_desc",  $why_defaults[$i][1] ),
		'icon'  => $why_icons[$i],
	];
}

$testi_defaults = [
	1 => [ 'Nguyễn Thùy T.', 'A Cup of Peace - 220g', '"Mình mua nến kể chuyện \'A Cup of Peace\' để ngồi đọc sách buổi tối. Mùi hương thật sự rất diệu - nhẹ nhàng, thanh khiết. Lần sau nhất định mua thêm cho bạn bè."' ],
	2 => [ 'Trần Minh H.', 'Nước hoa độc bản - Flora', '"Mua nước hoa Flora làm quà sinh nhật cho người yêu, bạn ấy thích lắm. Điều mình thích là có thể khắc tên và viết lời nhắn riêng - rất chu đáo và ý nghĩa."' ],
	3 => [ 'Lê Phương L.', 'Nến thông điệp bí ẩn', '"Nến thông điệp là món quà độc đáo nhất mình từng tặng. Khi bạn mình đốt lên và đọc được thông điệp bên trong, bạn ấy xúc động lắm."' ],
];
$testis = [];
for ( $i = 1; $i <= 3; $i++ ) {
	$testis[$i] = [
		'name'    => get_theme_mod( "ngki_testi_{$i}_name",    $testi_defaults[$i][0] ),
		'product' => get_theme_mod( "ngki_testi_{$i}_product", $testi_defaults[$i][1] ),
		'text'    => get_theme_mod( "ngki_testi_{$i}_text",    $testi_defaults[$i][2] ),
	];
}

$cta_title = get_theme_mod( 'ngki_cta_title', 'Miễn phí vận chuyển nội thành TP.HCM' );
$cta_desc  = get_theme_mod( 'ngki_cta_desc',  'Đơn hàng từ 500.000đ - Giao hàng trong ngày - Đóng gói quà tặng miễn phí khi yêu cầu' );
$cta_btn1  = get_theme_mod( 'ngki_cta_btn1',  'Mua ngay' );
$cta_btn2  = get_theme_mod( 'ngki_cta_btn2',  'Liên hệ tư vấn' );

get_header();
?>
<style>
/* ===== FRONT PAGE SPECIFIC STYLES ===== */
.ngki-hero{background:var(--color-primary-tint);overflow:hidden}
.ngki-hero-inner{max-width:1280px;margin:0 auto;padding:0 32px;display:grid;grid-template-columns:5fr 7fr;gap:0;height:580px;align-items:center}
.ngki-hero-content{padding:40px 48px 40px 0}
.ngki-hero-badge{display:inline-block;background:var(--color-primary);color:#fff;font-size:11px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;padding:5px 14px;border-radius:var(--radius-sm);margin-bottom:24px}
.ngki-hero-title{font-family:var(--font-heading);font-size:clamp(32px,4vw,54px);font-weight:600;line-height:1.15;color:var(--color-dark);letter-spacing:-.02em;margin-bottom:20px}
.ngki-hero-title em{font-style:italic;color:var(--color-primary)}
.ngki-hero-desc{color:var(--color-muted);font-size:16px;line-height:1.7;max-width:400px;margin-bottom:36px}
.ngki-hero-cta{display:flex;gap:12px;flex-wrap:wrap}
.ngki-hero-images{height:580px;overflow:hidden}
.ngki-hero-img-grid{display:grid;grid-template-columns:1fr 1fr;grid-template-rows:1fr 1fr;gap:8px;height:100%;padding:24px 0 24px 24px}
.ngki-hero-img-grid img{width:100%;height:100%;object-fit:cover;border-radius:var(--radius-md)}
.ngki-hero-img-grid img:first-child{grid-row:1/3;border-radius:var(--radius-lg)}
/* categories */
.ngki-cats{background:#fff}
.ngki-cat-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px}
.ngki-cat-card{position:relative;border-radius:var(--radius-lg);overflow:hidden;aspect-ratio:3/4;cursor:pointer}
.ngki-cat-card img{width:100%;height:100%;object-fit:cover;transition:transform .45s ease}
.ngki-cat-card:hover img{transform:scale(1.06)}
.ngki-cat-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(30,30,30,.72) 0%,rgba(30,30,30,.12) 55%,transparent 100%)}
.ngki-cat-info{position:absolute;bottom:0;left:0;right:0;padding:20px 16px;color:#fff}
.ngki-cat-name{font-family:var(--font-heading);font-size:15px;font-weight:600;line-height:1.3;margin-bottom:4px}
.ngki-cat-count{font-size:12px;opacity:.8}
.ngki-cat-cta{display:inline-block;margin-top:8px;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#fff;border-bottom:1px solid rgba(255,255,255,.5);padding-bottom:1px;transition:border-color .2s}
.ngki-cat-card:hover .ngki-cat-cta{border-color:#fff}
/* products */
.ngki-products{background:var(--color-surface)}
.ngki-products-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.ngki-product-card{background:#fff;border-radius:var(--radius-lg);overflow:hidden;border:1px solid var(--color-border);transition:box-shadow .25s,transform .25s;cursor:pointer}
.ngki-product-card:hover{box-shadow:var(--shadow-mid);transform:translateY(-3px)}
.ngki-product-img{position:relative;aspect-ratio:1;overflow:hidden;background:var(--color-primary-tint)}
.ngki-product-img img{width:100%;height:100%;object-fit:cover;transition:transform .4s ease}
.ngki-product-card:hover .ngki-product-img img{transform:scale(1.05)}
.ngki-product-body{padding:16px}
.ngki-product-cat{font-size:11px;font-weight:700;color:var(--color-primary);letter-spacing:.08em;text-transform:uppercase;margin-bottom:6px}
.ngki-product-name{font-family:var(--font-heading);font-size:15px;font-weight:600;color:var(--color-dark);line-height:1.35;margin-bottom:8px;text-wrap:balance}
.ngki-product-desc{font-size:13px;color:var(--color-muted);line-height:1.55;margin-bottom:14px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.ngki-product-footer{display:flex;align-items:center;justify-content:space-between;gap:8px}
.ngki-price{font-size:17px;font-weight:700;color:var(--color-primary)}
.ngki-price .from{font-size:12px;font-weight:400;color:var(--color-muted)}
.ngki-btn-add{display:inline-flex;align-items:center;gap:5px;padding:8px 14px;background:var(--color-primary);color:#fff;border-radius:var(--radius-md);font-size:12px;font-weight:700;border:none;cursor:pointer;transition:background .18s;white-space:nowrap;font-family:var(--font-body)}
.ngki-btn-add:hover{background:var(--color-primary-dark);color:#fff}
.ngki-products-more{text-align:center;margin-top:44px}
/* why us */
.ngki-why{background:#fff}
.ngki-why-inner{display:grid;grid-template-columns:5fr 7fr;gap:80px;align-items:center}
.ngki-why-image{position:relative}
.ngki-why-image img{width:100%;height:480px;object-fit:cover;border-radius:var(--radius-lg)}
.ngki-why-badge{position:absolute;bottom:24px;right:-24px;background:var(--color-primary);color:#fff;border-radius:var(--radius-lg);padding:20px 24px;text-align:center;box-shadow:var(--shadow-high);min-width:130px}
.ngki-why-badge .num{font-family:var(--font-heading);font-size:36px;font-weight:600;line-height:1;margin-bottom:4px}
.ngki-why-badge .lbl{font-size:12px;line-height:1.3;opacity:.9}
.ngki-why-content .ngki-section-header{text-align:left}
.ngki-why-list{margin-top:40px;display:flex;flex-direction:column;gap:28px}
.ngki-why-item{display:flex;gap:20px;align-items:flex-start}
.ngki-why-icon{width:48px;height:48px;min-width:48px;background:var(--color-primary-tint);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;color:var(--color-primary)}
.ngki-why-icon svg{width:24px;height:24px}
.ngki-why-item-title{font-family:var(--font-heading);font-size:16px;font-weight:600;color:var(--color-dark);margin-bottom:5px}
.ngki-why-item-desc{font-size:14px;color:var(--color-muted);line-height:1.65}
/* testimonials */
.ngki-testi{background:var(--color-primary-tint)}
.ngki-testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.ngki-testi-card{background:#fff;border-radius:var(--radius-lg);padding:28px;box-shadow:var(--shadow-low);border:1px solid var(--color-border)}
.ngki-stars{color:#e8a020;font-size:16px;margin-bottom:16px;letter-spacing:2px}
.ngki-testi-text{font-size:14px;color:var(--color-text);line-height:1.7;font-style:italic;margin-bottom:20px}
.ngki-testi-author{display:flex;align-items:center;gap:12px}
.ngki-testi-avatar{width:44px;height:44px;border-radius:50%;background:var(--color-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-family:var(--font-heading);font-size:16px;font-weight:600}
.ngki-testi-name{font-size:14px;font-weight:700;color:var(--color-dark);margin-bottom:2px}
.ngki-testi-prod{font-size:12px;color:var(--color-primary)}
/* cta */
.ngki-cta{background:var(--color-primary);color:#fff;text-align:center;padding:72px 32px}
.ngki-cta .ngki-label{color:rgba(255,255,255,.7)}
.ngki-cta .ngki-section-title{color:#fff}
.ngki-cta .ngki-section-desc{color:rgba(255,255,255,.8)}
.ngki-cta-actions{margin-top:36px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
.ngki-btn-white{background:#fff;color:var(--color-primary);border:2px solid #fff}
.ngki-btn-white:hover{background:rgba(255,255,255,.9);color:var(--color-primary)}
.ngki-btn-outline-white{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.5)}
.ngki-btn-outline-white:hover{border-color:#fff;background:rgba(255,255,255,.08);color:#fff}
/* responsive */
@media(max-width:1024px){
  .ngki-hero-inner{grid-template-columns:1fr;height:auto}
  .ngki-hero-content{padding:48px 0 32px}
  .ngki-hero-images{height:360px}
  .ngki-hero-img-grid{padding:0;height:360px}
  .ngki-cat-grid{grid-template-columns:repeat(3,1fr)}
  .ngki-cat-grid .ngki-cat-card:nth-child(4),.ngki-cat-grid .ngki-cat-card:nth-child(5){display:none}
  .ngki-products-grid{grid-template-columns:repeat(2,1fr)}
  .ngki-why-inner{grid-template-columns:1fr;gap:40px}
  .ngki-why-badge{right:0}
}
@media(max-width:768px){
  /* sections */
  .ngki-section{padding:48px 0}
  .ngki-section-header{margin-bottom:32px}
  .ngki-section-title{font-size:22px}
  /* hero */
  .ngki-hero-inner{padding:0 20px}
  .ngki-hero-content{padding:36px 0 24px}
  .ngki-hero-title{font-size:26px}
  .ngki-hero-desc{font-size:14px;margin-bottom:28px}
  .ngki-hero-cta{flex-direction:column;align-items:stretch;gap:10px}
  .ngki-hero-cta .ngki-btn{justify-content:center}
  .ngki-hero-images{height:260px}
  .ngki-hero-img-grid{height:260px}
  /* categories */
  .ngki-cat-grid{grid-template-columns:repeat(2,1fr);gap:12px}
  .ngki-cat-grid .ngki-cat-card:nth-child(3),.ngki-cat-grid .ngki-cat-card:nth-child(4),.ngki-cat-grid .ngki-cat-card:nth-child(5){display:none}
  /* products */
  .ngki-products-grid{grid-template-columns:repeat(2,1fr);gap:12px}
  .ngki-product-body{padding:12px}
  .ngki-product-name{font-size:13px}
  .ngki-product-desc{display:none}
  .ngki-product-footer{flex-direction:column;gap:8px;align-items:flex-start}
  .ngki-price{font-size:15px}
  .ngki-btn-add{width:100%;justify-content:center;padding:8px 12px;font-size:12px}
  /* why */
  .ngki-why-image img{height:260px}
  .ngki-why-badge{bottom:16px;right:12px;padding:14px 18px;min-width:100px}
  .ngki-why-badge .num{font-size:28px}
  .ngki-why-list{gap:20px}
  /* testimonials */
  .ngki-testi-grid{grid-template-columns:1fr}
  /* cta */
  .ngki-cta{padding:48px 20px}
  .ngki-cta-actions{flex-direction:column;align-items:center;gap:10px;margin-top:28px}
  .ngki-cta-actions .ngki-btn{width:100%;max-width:280px;justify-content:center}
}
</style>

<!-- HERO -->
<section class="ngki-hero">
  <div class="ngki-hero-inner">
    <div class="ngki-hero-content">
      <?php if ( $h_badge ) : ?><span class="ngki-hero-badge"><?php echo esc_html( $h_badge ); ?></span><?php endif; ?>
      <h1 class="ngki-hero-title">
        <?php echo esc_html( $h_title1 ); ?><br>
        <em><?php echo esc_html( $h_title_em ); ?></em><br>
        <?php echo esc_html( $h_title2 ); ?>
      </h1>
      <?php if ( $h_desc ) : ?><p class="ngki-hero-desc"><?php echo esc_html( $h_desc ); ?></p><?php endif; ?>
      <div class="ngki-hero-cta">
        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="ngki-btn ngki-btn-primary">
          <?php echo esc_html( $h_cta1 ); ?>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
        <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about-us' ) ) ); ?>" class="ngki-btn ngki-btn-outline"><?php echo esc_html( $h_cta2 ); ?></a>
      </div>
    </div>
    <div class="ngki-hero-images">
      <div class="ngki-hero-img-grid">
        <img src="https://nghikigai.com/wp-content/uploads/2025/09/Nen-Matcha-Latte-01-1.webp" alt="Nến decor Matcha Latte">
        <img src="https://nghikigai.com/wp-content/uploads/2025/09/IMG_9650-scaled-jpg.webp" alt="Nến kể chuyện">
        <img src="https://nghikigai.com/wp-content/uploads/2025/09/NHDB-Flora-01-1.webp" alt="Nước hoa độc bản Flora">
      </div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="ngki-section ngki-cats">
  <div class="ngki-inner">
    <div class="ngki-section-header">
      <span class="ngki-label">Danh mục sản phẩm</span>
      <h2 class="ngki-section-title">Mua theo loại hương thơm bạn yêu thích</h2>
    </div>
    <div class="ngki-cat-grid">
      <?php foreach ( (array) $cats as $cat ) :
        $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
        $cat_img      = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : 'https://nghikigai.com/wp-content/uploads/2023/10/tai-xuong-9.webp';
      ?>
      <div class="ngki-cat-card">
        <img src="<?php echo esc_url( $cat_img ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>" loading="lazy">
        <div class="ngki-cat-overlay"></div>
        <div class="ngki-cat-info">
          <div class="ngki-cat-name"><?php echo esc_html( $cat->name ); ?></div>
          <div class="ngki-cat-count"><?php echo $cat->count; ?> sản phẩm</div>
          <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="ngki-cat-cta">Xem tất cả</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- BESTSELLERS -->
<section class="ngki-section ngki-products">
  <div class="ngki-inner">
    <div class="ngki-section-header">
      <span class="ngki-label">Được yêu thích nhất</span>
      <h2 class="ngki-section-title">Sản phẩm bán chạy</h2>
      <p class="ngki-section-desc">Những chai hương, ngọn nến được khách hàng tin tưởng và lựa chọn nhiều nhất tại Nghikigai.</p>
    </div>
    <div class="ngki-products-grid">
      <?php foreach ( $raw_products as $product ) :
        $img_url    = get_the_post_thumbnail_url( $product->get_id(), 'woocommerce_single' );
        $p_cats     = get_the_terms( $product->get_id(), 'product_cat' );
        $cats_str   = $p_cats ? implode( ', ', array_column( (array) $p_cats, 'name' ) ) : '';
        $is_variable = $product->is_type( 'variable' );
      ?>
      <div class="ngki-product-card">
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
          <div class="ngki-product-img">
            <?php if ( $img_url ) : ?>
              <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" loading="lazy">
            <?php endif; ?>
          </div>
          <div class="ngki-product-body">
            <div class="ngki-product-cat"><?php echo esc_html( $cats_str ); ?></div>
            <h3 class="ngki-product-name"><?php echo esc_html( $product->get_name() ); ?></h3>
            <p class="ngki-product-desc"><?php echo esc_html( wp_strip_all_tags( $product->get_short_description() ) ); ?></p>
            <div class="ngki-product-footer">
              <div class="ngki-price">
                <?php if ( $is_variable ) : ?><span class="from">Từ </span><?php endif; ?>
                <?php echo wc_price( $product->get_price() ); ?>
              </div>
              <button class="ngki-btn-add">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Thêm giỏ
              </button>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="ngki-products-more">
      <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="ngki-btn ngki-btn-outline">
        Xem tất cả sản phẩm
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- WHY US -->
<section class="ngki-section ngki-why">
  <div class="ngki-inner">
    <div class="ngki-why-inner">
      <div class="ngki-why-image">
        <img src="https://nghikigai.com/wp-content/uploads/2025/09/IMG_9650-scaled-jpg.webp" alt="Hương thơm Nghikigai" loading="lazy">
        <div class="ngki-why-badge">
          <div class="num"><?php echo esc_html( $w_num ); ?></div>
          <div class="lbl"><?php echo esc_html( $w_lbl ); ?></div>
        </div>
      </div>
      <div class="ngki-why-content">
        <div class="ngki-section-header">
          <span class="ngki-label">Lý do chọn chúng tôi</span>
          <h2 class="ngki-section-title"><?php echo esc_html( $w_title ); ?></h2>
          <?php if ( $w_desc ) : ?><p class="ngki-section-desc"><?php echo esc_html( $w_desc ); ?></p><?php endif; ?>
        </div>
        <div class="ngki-why-list">
          <?php foreach ( $why_items as $item ) : ?>
          <div class="ngki-why-item">
            <div class="ngki-why-icon"><?php echo $item['icon']; ?></div>
            <div>
              <div class="ngki-why-item-title"><?php echo esc_html( $item['title'] ); ?></div>
              <div class="ngki-why-item-desc"><?php echo esc_html( $item['desc'] ); ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="ngki-section ngki-testi">
  <div class="ngki-inner">
    <div class="ngki-section-header">
      <span class="ngki-label">Khách hàng nói gì</span>
      <h2 class="ngki-section-title">Cảm nhận từ những người đã trải nghiệm</h2>
    </div>
    <div class="ngki-testi-grid">
      <?php foreach ( $testis as $t ) : ?>
      <div class="ngki-testi-card">
        <div class="ngki-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="ngki-testi-text"><?php echo esc_html( $t['text'] ); ?></p>
        <div class="ngki-testi-author">
          <div class="ngki-testi-avatar"><?php echo esc_html( mb_substr( $t['name'], 0, 1 ) ); ?></div>
          <div>
            <div class="ngki-testi-name"><?php echo esc_html( $t['name'] ); ?></div>
            <div class="ngki-testi-prod"><?php echo esc_html( $t['product'] ); ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<div class="ngki-cta">
  <span class="ngki-label">Đặt hàng ngay hôm nay</span>
  <h2 class="ngki-section-title"><?php echo esc_html( $cta_title ); ?></h2>
  <?php if ( $cta_desc ) : ?><p class="ngki-section-desc"><?php echo esc_html( $cta_desc ); ?></p><?php endif; ?>
  <div class="ngki-cta-actions">
    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="ngki-btn ngki-btn-white"><?php echo esc_html( $cta_btn1 ); ?></a>
    <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact-us' ) ) ); ?>" class="ngki-btn ngki-btn-outline-white"><?php echo esc_html( $cta_btn2 ); ?></a>
  </div>
</div>

<?php get_footer(); ?>
