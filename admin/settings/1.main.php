<?php
/*
 * Page Name: Main
 */

use BubbleMenu\Admin\CreateFields;

defined( 'ABSPATH' ) || exit;

$page_opt = include( 'options/1.main.php' );

$field = new CreateFields( $options, $page_opt );

?>
    <details class="wpie-item menu-item" open>
        <summary class="wpie-item_heading">
            <span class="wpie-item_heading_icon"></span>
            <span class="wpie-item_heading_label"></span>
            <span class="wpie-item_heading_type"></span>
            <span class="wpie-item_heading_sub"></span>
        </summary>
        <div class="wpie-item_content">

            <div class="wpie-fieldset">
                <div class="wpie-fields">
					<?php $field->create( 'label' ); ?>
					<?php $field->create( 'label_on' ); ?>
                </div>
            </div>

            <div class="wpie-tabs-wrapper">

                <div class="wpie-tabs-link">
                    <a class="wpie-tab__link is-active"><?php esc_html_e( 'Settings', 'bubble-menu' ); ?></a>
                    <a class="wpie-tab__link"><?php esc_html_e( 'Icon', 'bubble-menu' ); ?></a>
                    <a class="wpie-tab__link"><?php esc_html_e( 'Style', 'bubble-menu' ); ?></a>
                    <a class="wpie-tab__link"><?php esc_html_e( 'Attributes', 'bubble-menu' ); ?></a>
                </div>

                <div class="wpie-tab-settings is-active">
                    <div class="wpie-fieldset">
                        <div class="wpie-fields">
							<?php $field->create( 'position' ); ?>
                        </div>
                    </div>
                </div>

                <div class="wpie-tab-settings">
                    <div class="wpie-fieldset">
                        <div class="wpie-fields">
							<?php $field->create( 'icon_type' ); ?>
							<?php $field->create( 'icon' ); ?>
                        </div>
                    </div>
                </div>

                <div class="wpie-tab-settings">
                    <div class="wpie-fieldset">
                        <div class="wpie-fields">
							<?php $field->create( 'animation' ); ?>
							<?php $field->create( 'shapes' ); ?>
							<?php $field->create( 'size' ); ?>
							<?php $field->create( 'shadow' ); ?>
                        </div>
                    </div>
                    <div class="wpie-fieldset">
                        <div class="wpie-legend"><?php esc_html_e('Item', 'bubble-menu');?></div>
                        <div class="wpie-fields">
							<?php $field->create( 'color' ); ?>
							<?php $field->create( 'background_color' ); ?>
                        </div>
                    </div>
                    <div class="wpie-fieldset">
                        <div class="wpie-legend"><?php esc_html_e('Label', 'bubble-menu');?></div>
                        <div class="wpie-fields">
			                <?php $field->create( 'label_position' ); ?>
			                <?php $field->create( 'label_color' ); ?>
			                <?php $field->create( 'label_background_color' ); ?>
                        </div>
                    </div>
                </div>

                <div class="wpie-tab-settings">
                    <div class="wpie-fieldset">
                        <div class="wpie-fields">
							<?php $field->create( 'attribute_id' ); ?>
							<?php $field->create( 'attribute_class' ); ?>
							<?php $field->create( 'attribute_rel' ); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </details>
<?php
