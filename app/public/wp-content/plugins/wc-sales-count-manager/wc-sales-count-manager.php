<?php
/**
Plugin Name: WooCommerce Sales Count Manager
Description: Display woocommerce number of sold items on product page. "WooCommerce Sales Count Manager" will worked only with WooCommerce plugin.
Author: WP Experts Team
Author URI: https://www.wp-experts.in
Plugin URI: https://www.wp-experts.in/products/woocommerce-sales-count-manager-addon/
Version: 1.9
License:GPL2
WC tested up to: 4.5.2
WC Sales Count Manager is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
WC Sales Count Manager is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Contact WC Sales Count Manager.
 * 
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(!class_exists('WcSalesCountManagerAdmin'))
{
    class WcSalesCountManagerAdmin
    {
	 /**
      * Construct the plugin object
      */
	   public function __construct()
	   {
		    // register actions
			add_action('admin_init', array(&$this, 'wcscm_register_settings'));
			add_action('admin_menu', array(&$this, 'register_wc_sales_counter_menu'));
			add_filter( "plugin_action_links_".plugin_basename( __FILE__ ), array(&$this,'wcscm_add_settings_link' ));
			if (isset($_GET['page']) && $_GET['page'] == 'wc-sales-coutner') {
			add_action('admin_footer',array(&$this,'init_wcscm_admin_scripts'));
			}
			/** register_activation_hook */
			register_activation_hook( __FILE__, array(&$this, 'init_activation_wcscm_plugins' ) );
			/** register_deactivation_hook */
			register_deactivation_hook( __FILE__, array(&$this, 'init_deactivation_wcscm_plugins' ) );
			
			add_action( 'admin_bar_menu', array(&$this,'toolbar_link_to_wpc'), 999 );
			remove_action( 'admin_notices', array(&$this,'wscm_offer_notice') );
			add_action( 'admin_enqueue_scripts', array(&$this,'wscm_backend_scripts'));
		}
		public function wscm_backend_scripts( $hook ) {
			wp_enqueue_style( 'wp-color-picker');
			wp_enqueue_script( 'wp-color-picker');
		}
		/**
		 * Display offer message on admin dashboard
		 */		
		public function wscm_offer_notice( $wp_admin_bar ){
			 $message = '<div class="notice notice-success is-dismissible">
               <a href="https://www.wp-experts.in/products/woocommerce-sales-count-manager-addon/?utm_source=wordpress.org&utm_medium=free-plugin&utm_campaign=wscm-20offer-sale" class="delete"><h2 style="display: inline-block;"><i class="dashicons-before dashicons-megaphone"></i> FLAT 20% Discount on WooCommerce Sales Count Manager Add-on</h2><em class="tagline"> No Coupon Code Required. Hurry! Limited Time Offer!</em></a>
              </div>';
             echo $message; //print message
		}
		/**
		 * hook to add link under adminmenu bar
		 */		
		public function toolbar_link_to_wpc( $wp_admin_bar ) {
			if (!current_user_can('administrator') && is_admin()) return;
			$args = array(
				'id'    => 'wcscm_menu_bar',
				'title' => 'WC Sales Counter',
				'href'  => admin_url('admin.php?page=wc-sales-coutner'),
				'meta'  => array( 'class' => 'wcscm-toolbar-page' )
			);
			$wp_admin_bar->add_node( $args );
			//second lavel
			$wp_admin_bar->add_node( array(
				'id'    => 'wcscm-second-sub-item',
				'parent' => 'wcscm_menu_bar',
				'title' => 'Settings',
				'href'  => admin_url('admin.php?page=wc-sales-coutner'),
				'meta'  => array(
					'title' => __('Settings'),
					'target' => '_self',
					'class' => 'wcscm_menu_item_class'
				),
			));
		}
	  /** register admin menu */
	   public function register_wc_sales_counter_menu()
	   {
		add_submenu_page('woocommerce','WooCommerce Sales Count Manager','Sales Manager','manage_options','wc-sales-coutner',array(&$this,'init_wc_sales_counter_admin_page_html'));
		}
	   // Add settings link to plugin list page in admin
       public function wcscm_add_settings_link( $links ) {
            $settings_link = array('<a href="admin.php?page=wc-sales-coutner">Settings</a> <br> <a href="https://www.wp-experts.in/products/woocommerce-sales-count-manager-addon/?utm_source=wordpress.org&utm_medium=free-plugin&utm_campaign=wscm-20offer-sale" class="delete"><h2><i class="dashicons-before dashicons-megaphone"></i> Get FLAT 20% Discount on WooCommerce Sales Count Manager Add-on</h2><em class="tagline">No Coupon Code Required. Hurry! Limited Time Offer!</em></a>');
            return array_merge( $links, $settings_link );;
        }
       /** register settings */
	   public function wcscm_register_settings() {
			register_setting( 'wcscm_options', 'wcscm_enable');
			register_setting( 'wcscm_options', 'wcscm-inlinecss');
			register_setting( 'wcscm_options', 'wcscm_0_order_text'); 
			register_setting( 'wcscm_options', 'wcscm_after_single'); 
			register_setting( 'wcscm_options', 'wcscm_text'); 
			register_setting( 'wcscm_options', 'wcscm_text_color'); 
			register_setting( 'wcscm_options', 'wcscm_count_color'); 
			register_setting( 'wcscm_options', 'wcscm_bg_color'); 
			register_setting( 'wcscm_options', 'wcscm_social_buttons'); 
		} 
	   /** options form HTMl */	
	   public function init_wc_sales_counter_admin_page_html()
		{
		   $wcscinlinecss = get_option('wcscm-inlinecss') ? get_option('wcscm-inlinecss') : '';
		   $wcscm_after_single = get_option('wcscm_after_single') ? get_option('wcscm_after_single') : '';
		   if($wcscinlinecss!='')
		   {
			$inlineCss=$wcscinlinecss;
			}else
			{
			$inlineCss='';
				}	
		?>
		<div style="width: 80%; padding: 10px; margin: 10px;"> 
		 <h1>WooCommerce Sales Count Manager</h1>
		 <!-- Start Options Form -->
		 <form action="options.php" method="post" id="wcscm-sidebar-admin-form">	
		 <script>(function( ) {jQuery(function() {jQuery('.color-field').wpColorPicker();});})( jQuery );</script>
		 <div id="wcscm-tab-menu"><a id="wcscm-general" class="wcscm-tab-links active" >General</a> <a  id="our-pugins" class="wcscm-tab-links">Support</a> 
		 <hr>
		 </div>
		<div class="wcscm-setting">
			<!-- General Setting -->	
			<div class="first wcscm-tab" id="div-wcscm-general">
			<h2>General Settings</h2>
			<table cellpadding="10"><tr>
			<td valign="top">
			<p><input type="checkbox" id="wcscm_enable" name="wcscm_enable" value="1" <?php checked(get_option('wcscm_enable'),1);?>/><label> Enable Sales Count</label></p>
			<p><label>Text color:</label> <br><input type="text" id="wcscm_text_color" name="wcscm_text_color" value="<?php echo get_option('wcscm_text_color');?>" placeholder="#ffffff" size="20" data-default-color="#111111" class="color-field" ></p>	
			<p><label>Count color:</label> <br><input type="text" id="wcscm_count_color" name="wcscm_count_color" value="<?php echo get_option('wcscm_count_color');?>" placeholder="Count color" size="20" data-default-color="#a46497" class="color-field" ></p>
			<p><label>Background color:</label> <br><input type="text" id="wcscm_bg_color" name="wcscm_bg_color" value="<?php echo get_option('wcscm_bg_color');?>" placeholder="BG color" size="20" data-default-color="" class="color-field" ></p>
			<p><input type="checkbox" id="wcscm_social_buttons" name="wcscm_social_buttons" value="1" <?php checked(get_option('wcscm_social_buttons'),1);?>/><label> Publish Social Share Buttons</label></p>
			<p><label> Message:</label><br> <input type="text" id="wcscm_0_order_text" name="wcscm_0_order_text" value="<?php echo get_option('wcscm_0_order_text');?>" placeholder="define a custom message for 0 order products" size="40"><br><i>defin custom message for 0 order</i></p>
			<p><label> Text:</label><br> <input type="text" id="wcscm_text" name="wcscm_text" value="<?php echo get_option('wcscm_text');?>" placeholder="Sales" size="40"></p>
			<p><label>Inline CSS </label><br><textarea rows="10" cols="50" id="wcscm-inlinecss" name="wcscm-inlinecss" ><?php echo $inlineCss;?></textarea> </p>
			<p><label>Product bottom tagline</label><br><textarea rows="10" cols="50" id="wcscm_after_single" name="wcscm_after_single" ><?php echo $wcscm_after_single;?></textarea><br><i>This message will display bottom of every single product content </i> </p>
			</td>
			<td>
			<div class="offer-announcement"><h2><i class="dashicons-before dashicons-megaphone"></i><a href="https://www.wp-experts.in/products/woocommerce-sales-count-manager-addon/?utm_source=wordpress.org&utm_medium=free-plugin&utm_campaign=wscm-offer-sale">FLAT 20% DISCOUNT ON PLUGIN ADD-ON</a></h2><em class="tagline">No Coupon Code Required. Hurry! Limited Time Offer!</em></div>
			<hr>
			<p><h2><a style="font-size: 22px;font-weight: bold;text-transform: uppercase;" href="http://www.wp-experts.in/products/woocommerce-sales-count-manager-addon/">Click here</a> to download addon.</h2></p>
			<h3>Addon Features</h3>
			<ol>
			 <li>Enable item sold counter for shop page</li>
			 <li>Enable item sold counter for Category/Tag pages</li>
			 <li>Disable Counter for specific Product Category pages</li>
			 <li>Enable item sold counter for product details page</li>
			 <li>Define/Manage custom sold item number for every product page</li>
			 <li>An option to define custom sold item number for each product individually</li>
			 <li>Shortcode to show sold item number anywhere of the website</li>
			 <li>Manage style of item sold counter section from admin</li>
			 <li>An opton to Add conversion tracking code for checkout thank you page</li>
			 <li>An opton to define your custom message to disaply with sold item number</li>
			 <li>An opton to define your custom message for all 0 sold item number products</li>
			 <li>Social Share Buttons(Facebook,Twitter,Linkedin,Pinterest,WhatsApp) for product details page</li>
			 <li>Preorder custom message feature availiable </li>
			</ol>
			<h3>Watch given below video to know more about addon features.</h3><iframe width="70%" height="315" src="https://www.youtube.com/embed/v2_qDwEvXeU?rel=0&autoplay=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></td>
			</tr>
			</table>
			</div>
			<!-- Our Plugins -->
			<div class="wcscm-tab" id="div-our-pugins">
			<table>
			<tr>
			<td width="50%" ><p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZEMSYQUZRUK6A" target="_blank" style="font-size: 17px; font-weight: bold;"><img src="<?php echo  plugins_url( 'images/btn_donate_LG.gif' , __FILE__ );?>" title="Donate for this plugin"></a></p>
			<p><strong>Plugin Author:</strong><br><a href="http://www.wp-experts.in" target="_blank">WP-EXPERTS.IN Team</a></p>
			<p><a href="mailto:raghunath.0087@gmail.com" target="_blank" class="contact-author">Contact Author</a></p></td>
			<td></td>
			</tr>
			</table>
			<h2>Our Other Plugins:</h2>
			<ol>
					<li><a href="https://wordpress.org/plugins/custom-share-buttons-with-floating-sidebar" target="_blank">Custom Share Buttons With Floating Sidebar</a></li>
					<li><a href="https://wordpress.org/plugins/seo-manager/" target="_blank">SEO Manager</a></li>
					<li><a href="https://wordpress.org/plugins/protect-wp-admin/" target="_blank">Protect WP-Admin</a></li>
					<li><a href="https://wordpress.org/plugins/wp-sales-notifier/" target="_blank">WP Sales Notifier</a></li>
					<li><a href="https://wordpress.org/plugins/wp-tracking-manager/" target="_blank">WP Tracking Manager</a></li>
					<li><a href="https://wordpress.org/plugins/wp-categories-widget/" target="_blank">WP Categories Widget</a></li>
					<li><a href="https://wordpress.org/plugins/wp-protect-content/" target="_blank">WP Protect Content</a></li>
					<li><a href="https://wordpress.org/plugins/wp-version-remover/" target="_blank">WP Version Remover</a></li>
					<li><a href="https://wordpress.org/plugins/wp-posts-widget/" target="_blank">WP Post Widget</a></li>
					<li><a href="https://wordpress.org/plugins/wp-importer" target="_blank">WP Importer</a></li>
					<li><a href="https://wordpress.org/plugins/optimizer-wp-website/" target="_blank">Optimize WP Website</a></li>
					<li><a href="https://wordpress.org/plugins/wp-testimonial/" target="_blank">WP Testimonial</a></li>
					<li><a href="https://wordpress.org/plugins/wc-sales-count-manager/" target="_blank">WooCommerce Sales Count Manager</a></li>
					<li><a href="https://wordpress.org/plugins/wp-social-buttons/" target="_blank">WP Social Buttons</a></li>
					<li><a href="https://wordpress.org/plugins/wp-youtube-gallery/" target="_blank">WP Youtube Gallery</a></li>
					<li><a href="https://wordpress.org/plugins/rg-responsive-gallery/" target="_blank">RG Responsive Slider</a></li>
					<li><a href="https://wordpress.org/plugins/cf7-advance-security" target="_blank">Contact Form 7 Advance Security WP-Admin</a></li>
					<li><a href="https://wordpress.org/plugins/wp-easy-recipe/" target="_blank">WP Easy Recipe</a></li>
			 </ol>
			 <p></p>
			</div>
			</div>
				<span class="submit-btn"><?php echo get_submit_button('Save Settings','button-primary','submit','','');?></span>
			<?php settings_fields('wcscm_options'); ?>
			</form>
		<!-- End Options Form -->
		</div>
		<?php
		}
		public function init_wcscm_admin_scripts()
		{
		wp_register_style( 'wcscm_admin_style', plugins_url( 'css/wcscm-admin-min.css',__FILE__ ) );
		wp_enqueue_style( 'wcscm_admin_style' );

		echo $script='<script type="text/javascript">
			/* Protect WP-Admin js for admin */
			jQuery(document).ready(function(){
				jQuery(".wcscm-tab").hide();
				jQuery("#div-wcscm-general").show();
				jQuery(".wcscm-tab-links").click(function(){
				var divid=jQuery(this).attr("id");
				jQuery(".wcscm-tab-links").removeClass("active");
				jQuery(".wcscm-tab").hide();
				jQuery("#"+divid).addClass("active");
				jQuery("#div-"+divid).fadeIn();
				});
				})
			</script>';
		}
	/** register_deactivation_hook */
    static function init_deactivation_wcscm_plugins(){
	delete_option('wcscm_enable');
	delete_option('wcscm_text');
	delete_option('wcscm-inlinecss');
    }
    /** register_activation_hook */
    static function init_activation_wcscm_plugins(){
		if ( !is_plugin_active('woocommerce/woocommerce.php')){
	    // Throw an error in the wordpress admin console
        $error_message = __('This plugin requires <a href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a> plugins to be active!', 'woocommerce');
        die($error_message);
		}
	}

    } // end WcSalesCountManager class
} // end if class WcSalesCountManager exit or not
// init WcSalesCountManager class
if(class_exists('WcSalesCountManagerAdmin')):
$WcSalesCountManager = new WcSalesCountManagerAdmin;
endif;
/** Include class file **/
require dirname(__FILE__).'/wc-scm-class.php';
?>
