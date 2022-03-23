<?php

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Woncep_Elementor' ) ) :

	/**
	 * The Woncep Elementor Integration class
	 */
	class Woncep_Elementor {
		private $suffix = '';

		public function __construct() {
			$this->suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			add_action( 'wp', [ $this, 'register_auto_scripts_frontend' ] );
			add_action( 'elementor/init', array( $this, 'add_category' ) );
			add_action( 'wp_enqueue_scripts', [ $this, 'add_scripts' ], 15 );
			add_action('elementor/widgets/widgets_registered', array($this, 'customs_widgets'));
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'include_widgets' ) );
			add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'add_js' ] );

			// Custom Animation Scroll
			add_filter( 'elementor/controls/animations/additional_animations', [ $this, 'add_animations_scroll' ] );

			// Elementor Fix Noitice WooCommerce
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'woocommerce_fix_notice' ) );

			// Backend
			add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'add_style_editor' ], 99 );
//
//			// Add Icon Custom
			add_action( 'elementor/icons_manager/native', [ $this, 'add_icons_native' ] );
			add_action( 'elementor/controls/controls_registered', [ $this, 'add_icons' ] );

			add_filter( 'elementor/fonts/additional_fonts', [ $this, 'update_google_fonts' ] );
            add_action('wp_enqueue_scripts', [$this, 'elementor_kit']);
		}


        public function elementor_kit() {
            $active_kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
            Elementor\Plugin::$instance->kits_manager->frontend_before_enqueue_styles();
            $myvals = get_post_meta($active_kit_id, '_elementor_page_settings', true);

            if (!empty($myvals)) {
                $css = '';
                foreach ($myvals['system_colors'] as $key => $value) {
                    $css .= $value['color'] !== '' ? '--' . $value['_id'] . ':' . $value['color'] . ';' : '';
                }

                $var = "body{{$css}}";
                wp_add_inline_style('woncep-style', $var);
            }
        }

		public function update_google_fonts( $fonts ) {
			$fonts["Cerebri Sans Pro"] = 'system';
			$fonts["Futura PT Demi"] = 'system';

			return $fonts;
		}

		public function add_js() {
			global $woncep_version;
			wp_enqueue_script( 'woncep-elementor-frontend', get_theme_file_uri( '/assets/js/elementor-frontend.js' ), [], $woncep_version );
		}

		public function add_style_editor() {
			global $woncep_version;
			wp_enqueue_style( 'woncep-elementor-editor-icon', get_theme_file_uri( '/assets/css/admin/elementor/icons.css' ), [], $woncep_version );
		}

		public function add_scripts() {
			global $woncep_version;
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			wp_enqueue_style( 'woncep-elementor', get_template_directory_uri() . '/assets/css/base/elementor.css', '', $woncep_version );
			wp_style_add_data( 'woncep-elementor', 'rtl', 'replace' );

			// Add Scripts
			wp_register_script( 'tweenmax', get_theme_file_uri( '/assets/js/vendor/TweenMax.min.js' ), array( 'jquery' ), '1.11.1' );
			wp_register_script( 'parallaxmouse', get_theme_file_uri( '/assets/js/vendor/jquery-parallax.js' ), array( 'jquery' ), $woncep_version );

			if ( woncep_elementor_check_type( 'animated-bg-parallax' ) ) {
				wp_enqueue_script( 'tweenmax' );
				wp_enqueue_script( 'jquery-panr', get_theme_file_uri( '/assets/js/vendor/jquery-panr' . $suffix . '.js' ), array( 'jquery' ), '0.0.1' );
			}
		}


		public function register_auto_scripts_frontend() {
            global $woncep_version;
            wp_register_script('woncep-elementor-brand', get_theme_file_uri('/assets/js/elementor/brand.js'), array('jquery','elementor-frontend'), $woncep_version, true);
            wp_register_script('woncep-elementor-countdown', get_theme_file_uri('/assets/js/elementor/countdown.js'), array('jquery','elementor-frontend'), $woncep_version, true);
            wp_register_script('woncep-elementor-posts-grid', get_theme_file_uri('/assets/js/elementor/posts-grid.js'), array('jquery','elementor-frontend'), $woncep_version, true);
            wp_register_script('woncep-elementor-product-deal', get_theme_file_uri('/assets/js/elementor/product-deal.js'), array('jquery','elementor-frontend'), $woncep_version, true);
            wp_register_script('woncep-elementor-product-tab', get_theme_file_uri('/assets/js/elementor/product-tab.js'), array('jquery','elementor-frontend'), $woncep_version, true);
            wp_register_script('woncep-elementor-products', get_theme_file_uri('/assets/js/elementor/products.js'), array('jquery','elementor-frontend'), $woncep_version, true);
            wp_register_script('woncep-elementor-testimonial', get_theme_file_uri('/assets/js/elementor/testimonial.js'), array('jquery','elementor-frontend'), $woncep_version, true);
            wp_register_script('woncep-elementor-video', get_theme_file_uri('/assets/js/elementor/video.js'), array('jquery','elementor-frontend'), $woncep_version, true);
           
        }

		public function add_category() {
			Elementor\Plugin::instance()->elements_manager->add_category(
				'woncep-addons',
				array(
					'title' => esc_html__( 'Woncep Addons', 'woncep' ),
					'icon'  => 'fa fa-plug',
				),
				1 );
		}

		public function add_animations_scroll( $animations ) {
			$animations['Woncep Animation'] = [
				'opal-move-up'    => 'Move Up',
				'opal-move-down'  => 'Move Down',
				'opal-move-left'  => 'Move Left',
				'opal-move-right' => 'Move Right',
				'opal-flip'       => 'Flip',
				'opal-helix'      => 'Helix',
				'opal-scale-up'   => 'Scale',
				'opal-am-popup'   => 'Popup',
			];

			return $animations;
		}

		public function customs_widgets() {
			$files = glob(get_theme_file_path('/inc/elementor/custom-widgets/*.php'));
			foreach ($files as $file) {
				if (file_exists($file)) {
					require_once $file;
				}
			}
		}

		/**
		 * @param $widgets_manager Elementor\Widgets_Manager
		 */
		public function include_widgets( $widgets_manager ) {
			$files = glob( get_theme_file_path( '/inc/elementor/widgets/*.php' ) );
			foreach ( $files as $file ) {
				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}
		}

		public function woocommerce_fix_notice() {
			if ( woncep_is_woocommerce_activated() ) {
				remove_action( 'woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5 );
				remove_action( 'woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_account_content', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10 );
			}
		}

		public function add_icons( $manager ) {
            $new_icons = json_decode( '{"woncep-icon-badge-percent":"badge-percent","woncep-icon-adobe":"adobe","woncep-icon-amazon":"amazon","woncep-icon-android":"android","woncep-icon-angular":"angular","woncep-icon-apper":"apper","woncep-icon-apple":"apple","woncep-icon-atlassian":"atlassian","woncep-icon-behance":"behance","woncep-icon-bitbucket":"bitbucket","woncep-icon-bitcoin":"bitcoin","woncep-icon-bity":"bity","woncep-icon-bluetooth":"bluetooth","woncep-icon-btc":"btc","woncep-icon-centos":"centos","woncep-icon-chrome":"chrome","woncep-icon-codepen":"codepen","woncep-icon-cpanel":"cpanel","woncep-icon-discord":"discord","woncep-icon-dochub":"dochub","woncep-icon-docker":"docker","woncep-icon-dribbble":"dribbble","woncep-icon-dropbox":"dropbox","woncep-icon-drupal":"drupal","woncep-icon-ebay":"ebay","woncep-icon-facebook":"facebook","woncep-icon-figma":"figma","woncep-icon-firefox":"firefox","woncep-icon-google-plus":"google-plus","woncep-icon-google":"google","woncep-icon-grunt":"grunt","woncep-icon-gulp":"gulp","woncep-icon-html5":"html5","woncep-icon-jenkins":"jenkins","woncep-icon-joomla":"joomla","woncep-icon-link-brand":"link-brand","woncep-icon-linkedin":"linkedin","woncep-icon-mailchimp":"mailchimp","woncep-icon-opencart":"opencart","woncep-icon-paypal":"paypal","woncep-icon-pinterest-p":"pinterest-p","woncep-icon-reddit":"reddit","woncep-icon-skype":"skype","woncep-icon-slack":"slack","woncep-icon-snapchat":"snapchat","woncep-icon-spotify":"spotify","woncep-icon-trello":"trello","woncep-icon-twitter":"twitter","woncep-icon-vimeo":"vimeo","woncep-icon-whatsapp":"whatsapp","woncep-icon-wordpress":"wordpress","woncep-icon-yoast":"yoast","woncep-icon-youtube":"youtube","woncep-icon-clock":"clock","woncep-icon-angle-down":"angle-down","woncep-icon-angle-left":"angle-left","woncep-icon-angle-right":"angle-right","woncep-icon-angle-up":"angle-up","woncep-icon-arrow-circle-down":"arrow-circle-down","woncep-icon-arrow-circle-left":"arrow-circle-left","woncep-icon-arrow-circle-right":"arrow-circle-right","woncep-icon-arrow-circle-up":"arrow-circle-up","woncep-icon-bars":"bars","woncep-icon-caret-down":"caret-down","woncep-icon-caret-left":"caret-left","woncep-icon-caret-right":"caret-right","woncep-icon-caret-up":"caret-up","woncep-icon-cart-empty":"cart-empty","woncep-icon-check-square":"check-square","woncep-icon-chevron-circle-left":"chevron-circle-left","woncep-icon-chevron-circle-right":"chevron-circle-right","woncep-icon-chevron-down":"chevron-down","woncep-icon-chevron-left":"chevron-left","woncep-icon-chevron-right":"chevron-right","woncep-icon-chevron-up":"chevron-up","woncep-icon-circle":"circle","woncep-icon-cloud-download-alt":"cloud-download-alt","woncep-icon-comment":"comment","woncep-icon-comments":"comments","woncep-icon-contact":"contact","woncep-icon-credit-card":"credit-card","woncep-icon-dot-circle":"dot-circle","woncep-icon-edit":"edit","woncep-icon-envelope":"envelope","woncep-icon-expand-alt":"expand-alt","woncep-icon-external-link-alt":"external-link-alt","woncep-icon-eye":"eye","woncep-icon-file-alt":"file-alt","woncep-icon-file-archive":"file-archive","woncep-icon-filter":"filter","woncep-icon-folder-open":"folder-open","woncep-icon-folder":"folder","woncep-icon-free_ship":"free_ship","woncep-icon-frown":"frown","woncep-icon-gift":"gift","woncep-icon-grip-horizontal":"grip-horizontal","woncep-icon-heart-fill":"heart-fill","woncep-icon-heart":"heart","woncep-icon-history":"history","woncep-icon-home":"home","woncep-icon-info-circle":"info-circle","woncep-icon-instagram":"instagram","woncep-icon-level-up-alt":"level-up-alt","woncep-icon-map-marker-check":"map-marker-check","woncep-icon-meh":"meh","woncep-icon-minus-circle":"minus-circle","woncep-icon-mobile-android-alt":"mobile-android-alt","woncep-icon-money-bill":"money-bill","woncep-icon-pencil-alt":"pencil-alt","woncep-icon-plus-circle":"plus-circle","woncep-icon-plus":"plus","woncep-icon-quote":"quote","woncep-icon-random":"random","woncep-icon-reply-all":"reply-all","woncep-icon-reply":"reply","woncep-icon-search-plus":"search-plus","woncep-icon-search":"search","woncep-icon-shield-check":"shield-check","woncep-icon-shopping-basket-1":"shopping-basket-1","woncep-icon-shopping-basket":"shopping-basket","woncep-icon-shopping-cart":"shopping-cart","woncep-icon-sign-out-alt":"sign-out-alt","woncep-icon-sliders-v":"sliders-v","woncep-icon-smile":"smile","woncep-icon-spinner":"spinner","woncep-icon-square":"square","woncep-icon-star":"star","woncep-icon-stopwatch":"stopwatch","woncep-icon-store":"store","woncep-icon-sync":"sync","woncep-icon-tachometer-alt":"tachometer-alt","woncep-icon-th-large":"th-large","woncep-icon-th-list":"th-list","woncep-icon-thumbtack":"thumbtack","woncep-icon-times-circle":"times-circle","woncep-icon-times":"times","woncep-icon-trophy-alt":"trophy-alt","woncep-icon-truck":"truck","woncep-icon-user-headset":"user-headset","woncep-icon-user-shield":"user-shield","woncep-icon-user":"user","woncep-icon-envelope-open":"envelope-open","woncep-icon-gift-1":"gift-1","woncep-icon-grid":"grid","woncep-icon-headphones-alt":"headphones-alt","woncep-icon-list":"list","woncep-icon-location-circle":"location-circle","woncep-icon-long-arrow-down":"long-arrow-down","woncep-icon-long-arrow-left":"long-arrow-left","woncep-icon-long-arrow-right":"long-arrow-right","woncep-icon-long-arrow-up":"long-arrow-up","woncep-icon-map-marker-alt":"map-marker-alt","woncep-icon-mitten":"mitten","woncep-icon-mobile":"mobile","woncep-icon-music-1":"music-1","woncep-icon-padlock":"padlock","woncep-icon-paw-alt":"paw-alt","woncep-icon-payment_1":"payment_1","woncep-icon-payment_2":"payment_2","woncep-icon-payment_3":"payment_3","woncep-icon-payment_4":"payment_4","woncep-icon-payment_5":"payment_5","woncep-icon-payment_6":"payment_6","woncep-icon-phone-rotary":"phone-rotary","woncep-icon-rating":"rating","woncep-icon-rings-wedding":"rings-wedding","woncep-icon-rocket":"rocket","woncep-icon-shapes":"shapes","woncep-icon-star_01":"star_01","woncep-icon-tire":"tire","woncep-icon-tracking_1":"tracking_1","woncep-icon-tracking_2":"tracking_2","woncep-icon-tracking_3":"tracking_3","woncep-icon-tshirt":"tshirt","woncep-icon-tv":"tv","woncep-icon-volleyball-ball":"volleyball-ball"}', true );
			$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
			$new_icons = array_merge(
				$new_icons,
				$icons
			);
			// Then we set a new list of icons as the options of the icon control
			$manager->get_control( 'icon' )->set_settings( 'options', $new_icons ); 
        }

		public function add_icons_native( $tabs ) {
			global $woncep_version;
			$tabs['opal-custom'] = [
				'name'          => 'woncep-icon',
				'label'         => esc_html__( 'Woncep Icon', 'woncep' ),
				'prefix'        => 'woncep-icon-',
				'displayPrefix' => 'woncep-icon-',
				'labelIcon'     => 'fab fa-font-awesome-alt',
				'ver'           => $woncep_version,
				'fetchJson'     => get_theme_file_uri( '/inc/elementor/icons.json' ),
				'native'        => true,
			];

			return $tabs;
		}
	}

endif;

return new Woncep_Elementor();
