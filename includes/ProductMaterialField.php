<?php

namespace WeLabs\XWoodokan;

class ProductMaterialField {
    
    public function __construct() {
        // Add Product Material field to Simple and Variable products
        add_action( 'dokan_new_product_after_product_tags', [ $this, 'add_product_material_field' ], 10, 2 );
        add_action( 'dokan_product_edit_after_product_tags', [ $this, 'add_product_material_field' ], 10, 2 );

        /**
         * Save product material meta field.
         */
        add_action( 'dokan_new_product_added', array( $this, 'x_woodokan_save_product_material' ), 10, 2 );
        add_action( 'dokan_product_updated', array( $this, 'x_woodokan_save_product_material' ), 10, 2 );

        /**
         * Display product material in product listing table
         */
        add_filter( 'dokan_product_listing_table_columns', [ $this, 'add_material_column' ], 999, 1 );
        add_action( 'dokan_product_listing_table_column_product_material', [ $this, 'display_material_column_content' ], 999, 1 );

        /**
         * Display Product Material on single product page.
         */
        add_action( 'woocommerce_single_product_summary', array( $this, 'display_product_material_on_single_product_page'), 25);
        
    }

    /**
     * Add Product Material field to Simple products
     */
    public function add_product_material_field( $post, $post_id ) {
        $product_material = $post_id ? get_post_meta( $post_id, '_product_material', true ) : '';
        ?>
        <div class="dokan-form-group">
            <label for="product_material" class="form-label"><?php esc_html_e( 'Product Material', 'x-woodokan' ); ?></label>
            <input type="text" class="dokan-form-control" name="product_material" id="product_material"
                value="<?php echo esc_attr( $product_material ); ?>" placeholder="<?php esc_attr_e( 'e.g., Organic Cotton, Leather, Wood', 'x-woodokan' ); ?>" />
        </div>
        <?php
    }

    public function x_woodokan_save_product_material( $product_id, $data ) {
        if ( isset( $data['product_material'] ) ) {
            update_post_meta( $product_id, '_product_material', sanitize_text_field( wp_unslash( $data['product_material'] ) ) );
        }
    }

    /**
     * Add "Material" column header.
     */
    public function add_material_column( $columns ) {
        dd($columns);
        // Add a new column key that matches the render action suffix
        $columns['product_material'] = __( 'Material', 'x-woodokan' );
        return $columns;
    }

    /**
     * Add "Material" column content.
     */
    public function display_material_column_content( $item ) {
        $material = get_post_meta( $item->get_id(), '_product_material', true );
        echo $material ? esc_html( $material ) : '<span class="na">—</span>';
    }

    public function display_product_material_on_single_product_page() {
        global $product;
        if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
            return;
        }

        $material = get_post_meta( $product->get_id(), '_product_material', true );

        if ( $material ) {
            echo '<p class="product-material"><strong>' . esc_html__( 'Material:', 'x-woodokan' ) . '</strong> ' . esc_html( $material ) . '</p>';
        }
    }
}
