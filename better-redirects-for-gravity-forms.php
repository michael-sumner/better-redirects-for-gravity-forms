<?php

/**
 * @wordpress-plugin
 * Plugin Name: Better Redirects for Gravity Forms
 * Description: Avoid 404 errors in your form confirmation redirects. Specify your confirmation redirect URL with this plugin, and your confirmation redirects will never 404 again.
 * Version: 1.2.0
 * Requires at least: 4.0
 * Requires PHP: 5.6
 * Author: Michael Bryan Sumner
 * Author URI: https://smnr.co/better-redirects-for-gravity-forms
 * License: GPL-2.0+
 * Text Domain: better-redirects-for-gravity-forms
 * Domain Path: /languages
 *
 * @link https://smnr.co/better-redirects-for-gravity-forms
 * @since 1.2.0
 * @package BetterRedirectsGF
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die('Hey there...');
}

define('BETTER_REDIRECTS_GF_VERSION', '1.2.0');

if ( ! class_exists( 'BetterRedirectsGF' ) ) {
    class BetterRedirectsGF
    {
        /**
         * The current version of the plugin.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         * @access protected
         * @var string $version The current version of the plugin.
         */
        protected $version;
    
        /**
         * Define the core functionality of the plugin.
         *
         * Set the plugin version that can be used throughout the plugin.
         * Set the hooks.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         */
        public function __construct()
        {
            if (defined('BETTER_REDIRECTS_GF_VERSION')) {
                $this->version = BETTER_REDIRECTS_GF_VERSION;
            } else {
                $this->version = '1.2.0';
            }
    
            // Activate hooks
            $this->activate_actions();
            $this->activate_filters();
        }
    
        /**
         * Register listeners for actions.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         * @return void
         */
        private function activate_actions()
        {
            add_action('save_post', array($this, 'update_url'), 10, 3);
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 10);
            add_action('wp_ajax_better_redirects_gf', array($this, 'get_post_id_from_url'));
            add_action('wp_ajax_nopriv_better_redirects_gf', array($this, 'get_post_id_from_url'));
        }
    
        /**
         * Register listeners for filters.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         * @return void
         */
        private function activate_filters()
        {
            add_filter('gform_confirmation_settings_fields', array($this, 'confirmation_setting'), 10, 3);
            add_filter('gform_pre_confirmation_save', array($this, 'confirmation_save'), 10, 2);
        }
    
        /**
         * Retrieve the version number of the plugin.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         * @return string The version number of the plugin.
         */
        public function get_version()
        {
            return $this->version;
        }
    
        /**
         * Add plugin HTML to Gravity forms form confirmation settings.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         * @param mixed $fields
         * @param mixed $confirmation
         * @param mixed $form
         * @return mixed $fields The form confirmation field UI settings.
         */
        public function confirmation_setting( $fields, $confirmation, $form )
        {
            $fields[0]['fields'][] = array(
                'title'    => esc_html__( 'Better Redirect', 'better-redirects-for-gravity-forms' ),
                'type'     => 'custom',
                'callback' => array( 'BetterRedirectsGF', 'meta_box_better_redirects' ),
                'context'  => 'normal',

                // for callback
                'confirmation' => $confirmation,
            );
            return $fields;
        }

        public static function meta_box_better_redirects( $args, $metabox )
        {
            // vars
            $confirmation = '';
            $post_id      = '';
            $post_url     = '';
            $confirmation = $args['confirmation'];
    
            $post_id  = rgar($confirmation, 'betterRedirectsGf-field-value-post-id');
            $post_url = rgar($confirmation, 'betterRedirectsGf-field-value-post-url');

            if (isset($_POST['_gform_setting_betterRedirectsGf-field-value-post-id'])) {
                $post_id = rgpost('_gform_setting_betterRedirectsGf-field-value-post-id');
            }
    
            if (isset($_POST['_gform_setting_betterRedirectsGf-field-value-post-url'])) {
                $post_url = rgpost('_gform_setting_betterRedirectsGf-field-value-post-url');
            }

            // Gravity Forms will upgrade this `tr` to the new UI, if available.
            ?>
            <tr>
                <td>
                    <div class="gform-settings-field">
                        <div class="gform-settings-field__header">
                            <label class="gform-settings-label">Better Redirect</label>
                        </div>
                        <span class="gform-settings-description"><p>If specified, this will override your <strong>Redirect Confirmation URL</strong> with the below URL.<br>So that anytime the URL changes, your redirect will <strong>never become a 404, ever, again</strong>. 🤩</p><p>Make sure that <strong>Confirmation Type</strong> is set to <strong>Redirect</strong>.</p></span>
                        <div class="gform-settings-input__container">
                            <p>
                                <div class="gform-button c-betterRedirectsGf-result js-c-betterRedirectsGf-result gform-visually-hidden">
                                    <span class="c-betterRedirectsGf-result__button button gform-button__icon gform-icon gform-icon--create"></span>
                                    <span class="c-betterRedirectsGf-result__input"><span>Your redirect is now set to <strong>ID <span class="js-c-betterRedirectsGf-result-id"><?php echo esc_html($post_id); ?></span></strong>:&nbsp;</span><a href="" class="js-c-betterRedirectsGf-result-url" target="_blank"><?php echo esc_url($post_url); ?></a></span>
                                    <span class="c-betterRedirectsGf-result__button button gform-button__icon gform-icon gform-icon--delete js-c-betterRedirectsGf-result-remove"></span>
                                </div>
                                <input type="hidden" name="_gform_setting_betterRedirectsGf-field-value-post-id" id="betterRedirectsGf-field-value-post-id" value="<?php echo esc_attr($post_id); ?>" _gform_setting="">
                                <input type="hidden" name="_gform_setting_betterRedirectsGf-field-value-post-url" id="betterRedirectsGf-field-value-post-url" value="<?php echo esc_attr($post_url); ?>" _gform_setting="">
                            </p>
                            <a href="javascript:void(0);" class="gform_settings_button button js-c-betterRedirectsGf-button-selectLink">Select Link</a>
                            <textarea name="" id="c-betterRedirectsGf-mce-dummy" style="display:none !important;"></textarea>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
        }
    
        /**
         * Modify form confirmation redirect URL, from plugin options array.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         * @param mixed $confirmation
         * @param mixed $form
         * @return mixed $confirmation The form confirmation.
         */
        public function confirmation_save($confirmation, $form)
        {
            // vars
            $form_id         = (int) $form['id'];
            $confirmation_id = $confirmation['id'];
    
            // todo save values for later, until gform_confirmation_settings_fields filter issue can be resolved.
            // todo the issue is that newly appended confirmation type radio is not set as checked=checked.
            $confirmation['betterRedirectsGf-field-value-post-id']  = rgpost('_gform_setting_betterRedirectsGf-field-value-post-id');
            $confirmation['betterRedirectsGf-field-value-post-url'] = rgpost('_gform_setting_betterRedirectsGf-field-value-post-url');
    
            // update plugin options.
            $form_confirmations = $form['confirmations'];
    
            foreach ($form_confirmations as $key => $value) {
                if ($key === $confirmation_id) {
                    $form_confirmations[$key]['betterRedirectsGf-field-value-post-id']  = $confirmation['betterRedirectsGf-field-value-post-id'];
                    $form_confirmations[$key]['betterRedirectsGf-field-value-post-url'] = $confirmation['betterRedirectsGf-field-value-post-url'];
                }
            }
    
            // todo find a way to access each form using GF API, and if it's more performant.
            if (!get_option('better_redirects_gf')) {
                $better_redirects_gf_option = array(
                    array(
                        'form_id'       => $form_id,
                        'confirmations' => $form_confirmations,
                    ),
                );
                add_option('better_redirects_gf', $better_redirects_gf_option);
            } else {
                $better_redirects_gf_option = get_option('better_redirects_gf');
                $form_exists_in_option      = false;
                foreach ($better_redirects_gf_option as $key => $value) {
                    if ($form_id === $value['form_id']) {
                        $form_exists_in_option = true;

                        // update form array.
                        $better_redirects_gf_option[$key]['confirmations'] = $form_confirmations;
                    }
                }
                if (!$form_exists_in_option) {
                    // add form array if not exists yet.
                    $better_redirects_gf_option[] = array(
                        'form_id'       => $form_id,
                        'confirmations' => $form_confirmations,
                   );
                }
                update_option('better_redirects_gf', $better_redirects_gf_option);
            }
    
            return $confirmation;
        }
    
        /**
         * Check if URL has changed, then update it within options.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         * @param int $post_id
         * @param mixed $post
         * @param bool $update
         * @return void
         */
        public function update_url($post_id, $post, $update)
        {
            // only accept posts that are having their URLs modified.
            if (!$update) {
                return;
            }
    
            $url = esc_url(get_permalink($post_id));
    
            // check if $post_id is the same in the form.
            if (get_option('better_redirects_gf')) {
                // vars
                $better_redirects_gf_option = get_option('better_redirects_gf');
    
                foreach ($better_redirects_gf_option as $key => $value) {
                    // vars
                    $confirmations = $value['confirmations'];
                    $form_id       = $value['form_id'];
                    $form          = GFFormsModel::get_form_meta($form_id);
                    
                    // loop within each confirmations, and update the urls given post_id
                    foreach ($confirmations as $confirmation_id => $confirmation) {
                        // vars
                        $confirmation_post_id = intval($confirmation['betterRedirectsGf-field-value-post-id']);
    
                        if ($post_id === $confirmation_post_id) {
                            $form['confirmations'][$confirmation_id]['betterRedirectsGf-field-value-post-url'] = $url;
                            $form['confirmations'][$confirmation_id]['url']                                    = $url;
    
                            GFFormsModel::update_form_meta($form_id, $form['confirmations'], 'confirmations');
    
                            $better_redirects_gf_option[$key]['confirmations'][$confirmation_id]['betterRedirectsGf-field-value-post-url'] = $url;
                            $better_redirects_gf_option[$key]['confirmations'][$confirmation_id]['url']                                    = $url;
                        }
                    }
                }
                update_option('better_redirects_gf', $better_redirects_gf_option);
            }
        }
    
        /**
         * Enqueue admin scripts.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         * @return void
         */
        public function enqueue_scripts()
        {
            // vars
            $current_screen  = get_current_screen();
    
            if ('toplevel_page_gf_edit_forms' !== $current_screen->id) {
                return;
            }
            wp_enqueue_style('better_redirects_gf', plugin_dir_url(__FILE__) . 'css/admin.css', array(), $this->get_version());
            wp_enqueue_script('better_redirects_gf', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), $this->get_version(), true);
            wp_localize_script('better_redirects_gf', 'better_redirects_gf', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('better_redirects_gf_nonce'),
           ));
        }
    
        /**
         * Ajax. Get Post ID from URL.
         *
         * @since 1.2.0 Better Redirects for Gravity Forms
         * @return mixed $data
         */
        public function get_post_id_from_url()
        {
            check_ajax_referer('better_redirects_gf_nonce');
    
            $data = array(
                'debug_message' => '',
                'post_id'       => 0,
           );
    
            if (empty($_POST['post_url'])) {
                $data['debug_message'] = __('post_url does not exist.', 'better-redirects-for-gravity-forms');
                wp_send_json_error($data);
            }
    
            // vars
            $post_url = sanitize_text_field($_POST['post_url']);
            $post_id  = (int) url_to_postid(esc_url($post_url));
    
            if (!$post_id) {
                $data['debug_message'] = __('post_id does not exist.', 'better-redirects-for-gravity-forms');
                wp_send_json_error($data);
            }
    
            $data['post_id'] = $post_id;
            wp_send_json_success($data);
        }
    }
}

if ( class_exists( 'GFForms' ) ) {
    $better_redirects = new BetterRedirectsGF();
}
