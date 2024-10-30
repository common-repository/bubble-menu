<?php
/**
 * Page Name: Tools
 *
 */

use BubbleMenu\Admin\ImporterExporter;
use BubbleMenu\Admin\ManageCapabilities;
use BubbleMenu\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;

?>

    <div class="wpie-block-tool">

        <div class="inside">
            <h3><span class="dashicons dashicons-database-export wpie-color-orange"></span>
                <span><?php esc_html_e( 'Export Settings', 'bubble-menu' ); ?></span></h3>
            <div class="inside">
                <p><?php
					/* translators: %s: plugin name */
					printf( esc_html__( 'Export the  settings for %s as a .json file. This allows you to easily import the configuration into another site.', 'bubble-menu' ), '<b>' . esc_attr( WOWP_Plugin::info( 'name' ) ) . '</b>' ); ?></p>
				<?php ImporterExporter::form_export(); ?>
            </div>
        </div>
        <hr>

        <div class="inside">
            <h3><span class="dashicons dashicons-database-import wpie-color-orange"></span>
                <span><?php esc_html_e( 'Import Settings', 'bubble-menu' ); ?></span></h3>
            <div class="inside">
                <p><?php
					/* translators: %s: plugin name */
					printf( esc_html__( 'Import the %s settings from a .json file. This file can be obtained by exporting the settings on another site using the form above.', 'bubble-menu' ), '<b>' . esc_attr( WOWP_Plugin::info( 'name' ) ) . '</b>    ' ); ?></p>
				<?php ImporterExporter::form_import(); ?>
            </div>
        </div>

	    <?php if ( current_user_can( 'manage_options' ) ): ?>
            <hr/>
            <div class="inside">
                <h3><span class="dashicons dashicons-admin-users wpie-color-orange"></span>
                    <span><?php esc_html_e( 'Manage Capabilities', 'bubble-menu' ); ?></span></h3>
                <div class="inside">
                    <p><?php esc_html_e( 'Manage the visibility of the plugin for users based on their Manage User Capabilities.', 'bubble-menu' ); ?></p>
				    <?php ManageCapabilities::form(); ?>
                </div>
            </div>
	    <?php endif; ?>

    </div>

<?php
