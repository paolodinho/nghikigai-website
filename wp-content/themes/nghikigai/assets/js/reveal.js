/**
 * Nghikigai — hiệu ứng fade-up khi cuộn (tinh tế, không loop CPU).
 * Thêm class .ngki-reveal bằng JS → nếu JS không chạy, nội dung vẫn hiện bình thường.
 */
(function () {
  'use strict';
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduce || !('IntersectionObserver' in window)) return;

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    var selectors = [
      '.entry-content > .wp-block-group',
      '.ngki-testi-card',
      '.woocommerce ul.products > li.product',
      '.entry-content .wp-block-columns > .wp-block-column',
      '.single-product .woocommerce-product-gallery',
      '.single-product .entry-summary'
    ];
    var els = [];
    selectors.forEach(function (s) {
      document.querySelectorAll(s).forEach(function (el) { els.push(el); });
    });
    if (!els.length) return;

    var io = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          // stagger nhẹ theo vị trí trong nhóm
          var idx = Array.prototype.indexOf.call(e.target.parentNode.children, e.target);
          e.target.style.transitionDelay = Math.min(idx % 6, 5) * 60 + 'ms';
          e.target.classList.add('is-visible');
          obs.unobserve(e.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -8% 0px' });

    els.forEach(function (el) { el.classList.add('ngki-reveal'); io.observe(el); });
  });
})();
