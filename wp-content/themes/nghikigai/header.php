<?php
/**
 * Header template - Nghikigai
 * Áp dụng cho MỌI trang: topbar + sticky nav đồng nhất.
 *
 * @package nghikigai
 */
$logo_id  = get_theme_mod( 'custom_logo' );
$logo_url = $logo_id ? wp_get_attachment_url( $logo_id ) : '';
$cats_nav = get_terms( [
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'exclude'    => [ absint( get_option( 'default_product_cat' ) ) ],
	'orderby'    => 'count',
	'order'      => 'DESC',
	'number'     => 5,
] );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<style>
/* ===== NGHIKIGAI — GLOBAL DESIGN SYSTEM ===== */
:root{--color-primary:#406247;--color-primary-dark:#2f4a35;--color-primary-tint:#f1f6f2;--color-primary-light:#e8f0ea;--color-dark:#1e1e1e;--color-text:#3a3a3a;--color-muted:#6b7c6e;--color-border:#dde8de;--color-bg:#ffffff;--color-surface:#f8faf8;--font-heading:'Lora',Georgia,serif;--font-body:'Nunito',sans-serif;--radius-sm:4px;--radius-md:8px;--radius-lg:14px;--shadow-low:0 1px 3px rgba(64,98,71,.08);--shadow-mid:0 4px 16px rgba(64,98,71,.11);--shadow-high:0 8px 32px rgba(64,98,71,.14)}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body.ngki-site,body.ngki-fp{font-family:var(--font-body);color:var(--color-text);background:var(--color-bg);line-height:1.6;font-size:15px}
img{max-width:100%;display:block}
a{color:inherit;text-decoration:none}
ul{list-style:none}
/* admin bar */
body.admin-bar .ngki-topbar{margin-top:32px}
body.admin-bar .ngki-header{top:32px}
@media screen and (max-width:782px){body.admin-bar .ngki-topbar{margin-top:46px}body.admin-bar .ngki-header{top:46px}}
/* topbar */
.ngki-topbar{background:var(--color-primary);color:#fff;text-align:center;padding:9px 20px;font-size:13px;font-weight:600;letter-spacing:.04em}
/* header */
.ngki-header{background:#fff;border-bottom:1px solid var(--color-border);position:sticky;top:0;z-index:100}
.ngki-header-inner{max-width:1280px;margin:0 auto;padding:0 32px;display:flex;align-items:center;justify-content:space-between;gap:24px;height:70px}
.ngki-logo img{height:44px;width:auto;object-fit:contain}
.ngki-logo .logo-text{font-family:var(--font-heading);font-size:22px;font-weight:600;color:var(--color-primary);letter-spacing:-.02em}
.ngki-nav ul{display:flex;align-items:center;gap:8px}
.ngki-nav a{font-size:14px;font-weight:600;color:var(--color-dark);padding:8px 12px;border-radius:var(--radius-sm);white-space:nowrap;transition:color .18s,background .18s}
.ngki-nav a:hover,.ngki-nav a.current{color:var(--color-primary);background:var(--color-primary-tint)}
.ngki-header-actions{display:flex;align-items:center;gap:4px}
.ngki-header-actions a{display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;color:var(--color-dark);transition:background .18s,color .18s}
.ngki-header-actions a:hover{background:var(--color-primary-tint);color:var(--color-primary)}
.ngki-btn-cart{background:var(--color-primary)!important;color:#fff!important;border-radius:var(--radius-md)!important;width:auto!important;padding:0 16px!important;gap:6px;font-size:13px;font-weight:700;white-space:nowrap}
.ngki-btn-cart:hover{background:var(--color-primary-dark)!important}
/* buttons */
.ngki-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:var(--radius-md);font-family:var(--font-body);font-size:14px;font-weight:700;letter-spacing:.02em;cursor:pointer;border:2px solid transparent;transition:all .2s;white-space:nowrap}
.ngki-btn-primary{background:var(--color-primary);color:#fff;border-color:var(--color-primary)}
.ngki-btn-primary:hover{background:var(--color-primary-dark);border-color:var(--color-primary-dark);color:#fff}
.ngki-btn-outline{background:transparent;color:var(--color-primary);border-color:var(--color-primary)}
.ngki-btn-outline:hover{background:var(--color-primary-tint)}
/* sections */
.ngki-section{padding:80px 0}
.ngki-inner{max-width:1280px;margin:0 auto;padding:0 32px}
.ngki-section-header{text-align:center;margin-bottom:52px}
.ngki-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--color-primary);margin-bottom:12px}
.ngki-section-title{font-family:var(--font-heading);font-size:clamp(24px,3vw,38px);font-weight:600;color:var(--color-dark);line-height:1.2;letter-spacing:-.02em;text-wrap:balance}
.ngki-section-desc{color:var(--color-muted);margin-top:12px;max-width:520px;margin-left:auto;margin-right:auto;line-height:1.7}
/* footer */
.ngki-footer{background:var(--color-dark);color:rgba(255,255,255,.75);padding:64px 0 0}
.ngki-footer-inner{max-width:1280px;margin:0 auto;padding:0 32px;display:grid;grid-template-columns:2.5fr 1fr 1fr 1.5fr;gap:48px}
.ngki-footer-brand .logo-text{font-family:var(--font-heading);font-size:20px;font-weight:600;color:#fff;margin-bottom:14px}
.ngki-footer-brand p{font-size:13px;line-height:1.7;max-width:280px}
.ngki-footer-social{margin-top:20px;display:flex;gap:10px}
.ngki-footer-social a{width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.75);transition:background .18s,color .18s}
.ngki-footer-social a:hover{background:var(--color-primary);color:#fff}
.ngki-footer-col h4{font-family:var(--font-heading);font-size:15px;font-weight:600;color:#fff;margin-bottom:18px}
.ngki-footer-col ul{display:flex;flex-direction:column;gap:9px}
.ngki-footer-col a{font-size:13px;transition:color .18s}
.ngki-footer-col a:hover{color:#fff}
.ngki-footer-contact li{font-size:13px;display:flex;gap:10px;align-items:flex-start;margin-bottom:10px}
.ngki-footer-contact li svg{min-width:16px;margin-top:2px;color:var(--color-primary)}
.ngki-footer-bottom{max-width:1280px;margin:48px auto 0;padding:20px 32px;border-top:1px solid rgba(255,255,255,.08);display:flex;align-items:center;justify-content:space-between;gap:16px;font-size:12px}
.ngki-footer-bottom p{opacity:.5}
/* hamburger + mobile drawer */
.ngki-hamburger{display:none;align-items:center;justify-content:center;width:40px;height:40px;border-radius:var(--radius-sm);background:none;border:none;cursor:pointer;color:var(--color-dark);padding:0;flex-shrink:0}
.ngki-hamburger:hover{background:var(--color-primary-tint);color:var(--color-primary)}
.ngki-hamburger svg{display:block}
.ngki-drawer-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:200;opacity:0;transition:opacity .25s}
.ngki-drawer-overlay.open{opacity:1}
.ngki-drawer{position:fixed;top:0;left:0;bottom:0;width:280px;background:#fff;z-index:201;transform:translateX(-100%);transition:transform .28s ease;display:flex;flex-direction:column;overflow-y:auto}
.ngki-drawer.open{transform:translateX(0)}
.ngki-drawer-head{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--color-border)}
.ngki-drawer-logo{font-family:var(--font-heading);font-size:18px;font-weight:600;color:var(--color-primary)}
.ngki-drawer-close{width:36px;height:36px;border-radius:50%;border:none;background:var(--color-surface);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--color-dark)}
.ngki-drawer-close:hover{background:var(--color-primary-tint);color:var(--color-primary)}
.ngki-drawer-nav{padding:12px 0;flex:1}
.ngki-drawer-nav a{display:block;padding:13px 20px;font-size:15px;font-weight:600;color:var(--color-dark);border-left:3px solid transparent;transition:all .15s}
.ngki-drawer-nav a:hover,.ngki-drawer-nav a.current{color:var(--color-primary);background:var(--color-primary-tint);border-left-color:var(--color-primary)}
.ngki-drawer-nav .ngki-drawer-divider{height:1px;background:var(--color-border);margin:8px 20px}
.ngki-drawer-footer{padding:20px;border-top:1px solid var(--color-border)}
.ngki-drawer-footer a{display:flex;align-items:center;gap:8px;padding:11px 16px;background:var(--color-primary);color:#fff;border-radius:var(--radius-md);font-size:14px;font-weight:700;justify-content:center;white-space:nowrap}
/* responsive header/footer */
@media(max-width:1024px){
  .ngki-footer-inner{grid-template-columns:1fr 1fr;gap:32px}
  .ngki-footer-brand{grid-column:1/-1}
}
@media(max-width:768px){
  .ngki-inner,.ngki-header-inner{padding:0 20px}
  .ngki-nav{display:none}
  .ngki-hamburger{display:flex}
  .ngki-btn-cart span.cart-label{display:none}
  .ngki-footer-inner{grid-template-columns:1fr;gap:28px}
  .ngki-footer-inner .ngki-footer-col:last-child{display:none}
}
</style>
</head>
<body <?php body_class( 'ngki-site' ); ?>>
<?php wp_body_open(); ?>

<!-- TOP BAR -->
<div class="ngki-topbar">
  Miễn phí vận chuyển nội thành TP.HCM - Đơn hàng từ 500.000đ
</div>

<!-- HEADER -->
<header class="ngki-header">
  <div class="ngki-header-inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ngki-logo">
      <?php if ( $logo_url ) : ?>
        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
      <?php else : ?>
        <span class="logo-text"><?php bloginfo( 'name' ); ?></span>
      <?php endif; ?>
    </a>
    <nav class="ngki-nav">
      <ul>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php is_front_page() ? print ' class="current"' : ''; ?>>Trang chủ</a></li>
        <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"<?php is_shop() ? print ' class="current"' : ''; ?>>Shop</a></li>
        <?php foreach ( (array) $cats_nav as $cat ) : ?>
        <li><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
        <?php endforeach; ?>
        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about-us' ) ) ); ?>">Về chúng tôi</a></li>
        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact-us' ) ) ); ?>">Liên hệ</a></li>
      </ul>
    </nav>
    <div class="ngki-header-actions">
      <a href="<?php echo esc_url( get_search_link() ); ?>" title="Tìm kiếm">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      </a>
      <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="Tài khoản">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </a>
      <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="ngki-btn-add ngki-btn-cart">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
        <span class="cart-label">Giỏ hàng<?php $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; if ( $count ) echo ' (' . $count . ')'; ?></span>
      </a>
      <button class="ngki-hamburger" id="ngki-hamburger-btn" aria-label="Mở menu" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </div>
</header>

<!-- MOBILE DRAWER -->
<div class="ngki-drawer-overlay" id="ngki-overlay"></div>
<nav class="ngki-drawer" id="ngki-drawer" aria-label="Menu di động">
  <div class="ngki-drawer-head">
    <span class="ngki-drawer-logo"><?php bloginfo('name'); ?></span>
    <button class="ngki-drawer-close" id="ngki-drawer-close" aria-label="Đóng menu">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  </div>
  <div class="ngki-drawer-nav">
    <a href="<?php echo esc_url( home_url('/') ); ?>"<?php is_front_page() ? print ' class="current"' : ''; ?>>Trang chủ</a>
    <a href="<?php echo esc_url( get_permalink( wc_get_page_id('shop') ) ); ?>"<?php is_shop() ? print ' class="current"' : ''; ?>>Shop</a>
    <div class="ngki-drawer-divider"></div>
    <?php foreach ( (array) $cats_nav as $cat ) : ?>
    <a href="<?php echo esc_url( get_term_link($cat) ); ?>"><?php echo esc_html($cat->name); ?></a>
    <?php endforeach; ?>
    <div class="ngki-drawer-divider"></div>
    <a href="<?php echo esc_url( get_permalink( get_page_by_path('about-us') ) ); ?>">Về chúng tôi</a>
    <a href="<?php echo esc_url( get_permalink( get_page_by_path('contact-us') ) ); ?>">Liên hệ</a>
  </div>
  <div class="ngki-drawer-footer">
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
      Giỏ hàng<?php $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; if ( $count ) echo ' (' . $count . ')'; ?>
    </a>
  </div>
</nav>
<script>
(function(){
  var btn=document.getElementById('ngki-hamburger-btn');
  var overlay=document.getElementById('ngki-overlay');
  var drawer=document.getElementById('ngki-drawer');
  var closeBtn=document.getElementById('ngki-drawer-close');
  function open(){drawer.classList.add('open');overlay.style.display='block';requestAnimationFrame(function(){overlay.classList.add('open');});btn.setAttribute('aria-expanded','true');document.body.style.overflow='hidden';}
  function close(){drawer.classList.remove('open');overlay.classList.remove('open');btn.setAttribute('aria-expanded','false');document.body.style.overflow='';setTimeout(function(){overlay.style.display='none';},260);}
  if(btn){btn.addEventListener('click',open);}
  if(closeBtn){closeBtn.addEventListener('click',close);}
  if(overlay){overlay.addEventListener('click',close);}
  document.addEventListener('keydown',function(e){if(e.key==='Escape')close();});
})();
</script>
