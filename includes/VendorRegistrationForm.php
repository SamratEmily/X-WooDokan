<?php

namespace WeLabs\XWoodokan;

class VendorRegistrationForm {
    public function __construct() {
        // Registration form
        add_action( 'dokan_seller_registration_after_shopurl_field', [ $this, 'add_custom_fields' ] );
        add_action( 'dokan_new_seller_created', [ $this, 'x_woodokan_dokan_vendor_registration_save' ], 5, 2 );

        // Store settings form (frontend dashboard)
        add_filter( 'dokan_settings_after_store_phone', [ $this, 'x_woodokan_add_store_settings_field' ], 2, 2 );
        add_action( 'dokan_seller_meta_fields_save', [ $this, 'x_woodokan_save_store_settings_field' ], 10, 2 );

        // Storefront display
        // add_action( 'dokan_store_profile_frame_after_social', [ $this, 'x_woodokan_dokan_store_profile_frame_after_social' ], 10, 2 );    
    }

    /**
     * Add Business License ID field to vendor registration
     */
    public function add_custom_fields() {
        require_once X_WOODOKAN_TEMPLATE_DIR . '/vendor-registration-form.php';
    }

    /**
     * Validate and save Business License ID on vendor registration
     */
    public function x_woodokan_dokan_vendor_registration_save( $user_id, $data ) {
        if ( empty( $_POST['business_license_id'] ) ) {
            return new \WP_Error( 'business_license_id_error', __( 'Business License ID is required', 'myplugin' ) );
        }
        update_user_meta( $user_id, 'business_license_id', sanitize_text_field( wp_unslash( $_POST['business_license_id'] ) ) );
    }

    /**
     * Add Business License ID field in Store Settings (Vendor Dashboard)
     */
    public function x_woodokan_add_store_settings_field( $store_user, $profile_info ) {
        $business_license_id = get_user_meta( $store_user, 'business_license_id', true );
        ?>
        <div class="dokan-form-group">
            <label class="dokan-w3 dokan-control-label" for="business_license_id">
                <?php esc_html_e( 'Business License ID', 'myplugin' ); ?>
            </label>
            <div class="dokan-w5 dokan-text-left">
                <input id="business_license_id"
                       name="business_license_id"
                       type="text"
                       class="dokan-form-control"
                       value="<?php echo esc_attr( $business_license_id ); ?>" />
            </div>
        </div>
        <?php
    }

    /**
     * Save Business License ID from Store Settings
     */
    public function x_woodokan_save_store_settings_field( $store_id, $dokan_settings ) {
        if ( isset( $dokan_settings['business_license_id'] ) ) {
            update_user_meta(
                $store_id,
                'business_license_id',
                sanitize_text_field( $dokan_settings['business_license_id'] )
            );
        }
    }

    /**
     * Show Business License ID on vendor store page
     */
    public function x_woodokan_dokan_store_profile_frame_after_social( $store_user, $store_info ) {
        $business_license_id = get_user_meta( $store_user->ID, 'business_license_id', true );
        if ( ! empty( $business_license_id ) ) {
            echo '<div class="dokan-store-business-license">';
            echo '<strong>' . esc_html__( 'Business License ID:', 'myplugin' ) . '</strong> ' . esc_html( $business_license_id );
            echo '</div>';
        }
    }
}
