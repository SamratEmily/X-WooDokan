<p class="form-row form-group form-row-wide">
    <label for="business_license_id"><?php esc_html_e( 'Business License ID', 'myplugin' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="business_license_id" id="business_license_id" value="<?php echo isset( $_POST['business_license_id'] ) ? esc_attr( wp_unslash( $_POST['business_license_id'] ) ) : ''; ?>" required />
</p>