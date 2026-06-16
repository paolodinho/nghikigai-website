<?php
/**
 * Footer template - Nghikigai
 * Áp dụng cho MỌI trang: footer đồng nhất.
 * Toàn bộ nội dung lấy từ Customizer → Appearance > Customize > Nghikigai - Cài đặt theme.
 *
 * @package nghikigai
 */
$cats_footer = get_terms( [
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'exclude'    => [ absint( get_option( 'default_product_cat' ) ) ],
	'orderby'    => 'count',
	'order'      => 'DESC',
	'number'     => 5,
] );

$fb      = get_theme_mod( 'ngki_social_fb',       'https://facebook.com/nghikigai' );
$ig      = get_theme_mod( 'ngki_social_ig',       'https://instagram.com/nghikigai' );
$tt      = get_theme_mod( 'ngki_social_tt',       'https://tiktok.com/@nghikigai' );
$desc    = get_theme_mod( 'ngki_footer_desc',     'Thương hiệu hương thơm Việt Nam - Mỗi ngọn nến, mỗi chai tinh dầu mang một câu chuyện riêng dành cho bạn. Được làm từ sáp tự nhiên, tinh dầu Mỹ cao cấp.' );
$address = get_theme_mod( 'ngki_footer_address',  'Hẻm 341 Nguyễn Trãi, P. Nguyễn Cư Trinh, Q.1, TP.HCM' );
$phone   = get_theme_mod( 'ngki_footer_phone',    '0983 797 186' );
$hours   = get_theme_mod( 'ngki_footer_hours',    'T2 - T7: 9:00 - 20:00' );
$copy    = get_theme_mod( 'ngki_footer_copy',     'Thiết kế bởi Digito Combat' );
?>

<!-- FOOTER -->
<footer class="ngki-footer">
  <div class="ngki-footer-inner">
    <div class="ngki-footer-brand">
      <div class="logo-text"><?php bloginfo( 'name' ); ?></div>
      <?php if ( $desc ) : ?><p><?php echo esc_html( $desc ); ?></p><?php endif; ?>
      <div class="ngki-footer-social">
        <?php if ( $fb ) : ?>
        <a href="<?php echo esc_url( $fb ); ?>" aria-label="Facebook" target="_blank" rel="noopener">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        </a>
        <?php endif; ?>
        <?php if ( $ig ) : ?>
        <a href="<?php echo esc_url( $ig ); ?>" aria-label="Instagram" target="_blank" rel="noopener">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </a>
        <?php endif; ?>
        <?php if ( $tt ) : ?>
        <a href="<?php echo esc_url( $tt ); ?>" aria-label="TikTok" target="_blank" rel="noopener">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.78a4.85 4.85 0 0 1-1.01-.09z"/></svg>
        </a>
        <?php endif; ?>
      </div>
    </div>
    <div class="ngki-footer-col">
      <h4>Sản phẩm</h4>
      <ul>
        <?php foreach ( (array) $cats_footer as $c ) : ?>
        <li><a href="<?php echo esc_url( get_term_link( $c ) ); ?>"><?php echo esc_html( $c->name ); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="ngki-footer-col">
      <h4>Hỗ trợ</h4>
      <ul>
        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about-us' ) ) ); ?>">Về chúng tôi</a></li>
        <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">Chính sách vận chuyển</a></li>
        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'faqs' ) ) ); ?>">Câu hỏi thường gặp</a></li>
        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact-us' ) ) ); ?>">Liên hệ</a></li>
      </ul>
    </div>
    <div class="ngki-footer-col ngki-footer-contact">
      <h4>Liên hệ</h4>
      <ul>
        <?php if ( $address ) : ?>
        <li>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <?php echo esc_html( $address ); ?>
        </li>
        <?php endif; ?>
        <?php if ( $phone ) : ?>
        <li>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18l3-.01a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.08 6.08l1.28-1.28a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          <a href="tel:<?php echo preg_replace('/\D/', '', $phone); ?>"><?php echo esc_html( $phone ); ?></a>
        </li>
        <?php endif; ?>
        <?php if ( $hours ) : ?>
        <li>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <?php echo esc_html( $hours ); ?>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
  <div class="ngki-footer-bottom">
    <p>© <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. Tất cả quyền được bảo lưu.</p>
    <?php if ( $copy ) : ?><p><?php echo esc_html( $copy ); ?></p><?php endif; ?>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
