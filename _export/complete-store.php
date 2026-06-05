<?php
/**
 * Hoàn thiện store: địa chỉ, thanh toán (COD + chuyển khoản), vận chuyển (free ship >500K + flat rate).
 * Chạy: wp eval-file _export/complete-store.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* 1. Địa chỉ store (cho tính phí ship) */
update_option( 'woocommerce_store_address', 'Hẻm 341 Nguyễn Trãi' );
update_option( 'woocommerce_store_address_2', 'P. Nguyễn Cư Trinh' );
update_option( 'woocommerce_store_city', 'Hồ Chí Minh' );
update_option( 'woocommerce_default_country', 'VN' );
update_option( 'woocommerce_store_postcode', '700000' );
update_option( 'woocommerce_allowed_countries', 'specific' );
update_option( 'woocommerce_specific_allowed_countries', array( 'VN' ) );
WP_CLI::log( 'Địa chỉ store + bán tại VN.' );

/* 2. Thanh toán: COD + Chuyển khoản */
update_option( 'woocommerce_cod_settings', array(
	'enabled'      => 'yes',
	'title'        => 'Thanh toán khi nhận hàng (COD)',
	'description'  => 'Trả tiền mặt cho đơn vị giao hàng khi nhận sản phẩm.',
	'instructions' => 'Cảm ơn bạn! Vui lòng chuẩn bị tiền mặt khi nhận hàng.',
	'enable_for_methods' => array(),
	'enable_for_virtual' => 'no',
) );
update_option( 'woocommerce_bacs_settings', array(
	'enabled'      => 'yes',
	'title'        => 'Chuyển khoản ngân hàng',
	'description'  => 'Chuyển khoản trước, đơn xử lý sau khi nhận thanh toán. Hỗ trợ Momo / ZaloPay (nhắn shop để lấy mã QR).',
	'instructions' => 'Nội dung CK: [Tên bạn] + [Mã đơn]. Sau khi CK vui lòng nhắn Nghikigai để xác nhận.',
) );
// Tài khoản BACS (placeholder - khách điền số thật trong Cài đặt WooCommerce)
update_option( 'woocommerce_bacs_accounts', array( array(
	'account_name'   => 'NGHIKIGAI',
	'account_number' => '(điền số TK thật)',
	'bank_name'      => '(điền tên ngân hàng)',
	'sort_code'      => '',
	'iban'           => '',
	'bic'            => '',
) ) );
WP_CLI::log( 'Thanh toán: COD + Chuyển khoản đã bật.' );

/* 3. Vận chuyển: zone Việt Nam (free ship >500K + flat rate 30k) */
$exists = false;
foreach ( WC_Shipping_Zones::get_zones() as $z ) { if ( $z['zone_name'] === 'Việt Nam' ) { $exists = true; } }
if ( ! $exists ) {
	$zone = new WC_Shipping_Zone();
	$zone->set_zone_name( 'Việt Nam' );
	$zone->set_zone_order( 1 );
	$zone->add_location( 'VN', 'country' );
	$zone->save();
	$zid = $zone->get_id();

	$flat_id = $zone->add_shipping_method( 'flat_rate' );
	update_option( 'woocommerce_flat_rate_' . $flat_id . '_settings', array(
		'title'      => 'Giao hàng tiêu chuẩn',
		'tax_status' => 'none',
		'cost'       => '30000',
	) );
	$free_id = $zone->add_shipping_method( 'free_shipping' );
	update_option( 'woocommerce_free_shipping_' . $free_id . '_settings', array(
		'title'      => 'Miễn phí vận chuyển',
		'requires'   => 'min_amount',
		'min_amount' => '500000',
		'ignore_discounts' => 'no',
	) );
	WP_CLI::log( "Shipping zone Việt Nam (#$zid): flat 30k + free >500K." );
} else {
	WP_CLI::log( 'Shipping zone Việt Nam đã có - bỏ qua.' );
}

/* 4. Bật tính phí ship + trang */
update_option( 'woocommerce_enable_shipping_calc', 'yes' );
update_option( 'woocommerce_calc_taxes', 'no' );

WP_CLI::success( 'Hoàn thiện store (địa chỉ + thanh toán + vận chuyển) xong.' );
