<?php
/*
 * Page Name: Items
 */

use BubbleMenu\Admin\CreateFields;

defined( 'ABSPATH' ) || exit;

$page_opt = include( 'options/2.items.php' );

$field = new CreateFields( $options, $page_opt );

$count = ( ! empty( $options['item']['type'] ) ) ? count( $options['item']['type'] ) : '0';
$prefix = 'item-';
?>
	<div class="wpie-items__list" id="wpie-items-list">
		<?php if ( $count > 0 ) :
			for ( $i = 0; $i < $count; $i ++ ):
				$order = $i + 1;
				$status = ! empty( $options['item_status'][ $i ] ) ? 1 : 0;
				$open = ! empty( $status ) ? ' open' : '';
				?>
				<details class="wpie-item menu-item"<?php echo esc_attr( $open ); ?>>
					<input type="hidden" name="param[item_status][]" class="wpie-item__toggle"
					       value="<?php echo absint( $status ); ?>">
					<summary class="wpie-item_heading">
						<span class="wpie-item_heading_icon"></span>
						<span class="wpie-item_heading_label"></span>
						<span class="wpie-item_heading_type"></span>
						<span class="wpie-item_heading_sub"></span>
						<span class="wpie-icon wpie_icon-chevron-expand-y"></span>
						<span class="wpie-icon wpie_icon-trash"></span>
						<span class="wpie-item_heading_toogle">
                            <span class="wpie-icon wpie_icon-chevron-down"></span>
                            <span class="wpie-icon wpie_icon-chevron-up "></span>
                        </span>
					</summary>
					<div class="wpie-item_content">

						<div class="wpie-fieldset">
							<div class="wpie-fields">
								<?php $field->create( $prefix . 'label', $i ); ?>
								<?php $field->create( $prefix . 'label_on', $i ); ?>
							</div>
						</div>

						<div class="wpie-tabs-wrapper">

							<div class="wpie-tabs-link">
								<a class="wpie-tab__link is-active"><?php esc_html_e( 'Type', 'bubble-menu' ); ?></a>
								<a class="wpie-tab__link"><?php esc_html_e( 'Icon', 'bubble-menu' ); ?></a>
								<a class="wpie-tab__link"><?php esc_html_e( 'Style', 'bubble-menu' ); ?></a>
								<a class="wpie-tab__link"><?php esc_html_e( 'Attributes', 'bubble-menu' ); ?></a>
							</div>

							<div class="wpie-tab-settings is-active">
								<div class="wpie-fieldset">
									<div class="wpie-fields">
										<?php $field->create( $prefix . 'type', $i ); ?>
										<?php $field->create( $prefix . 'link', $i ); ?>
									</div>
								</div>


							</div>

							<div class="wpie-tab-settings">
								<div class="wpie-fieldset">
									<div class="wpie-fields">
										<?php $field->create( $prefix . 'icon_type', $i ); ?>
										<?php $field->create( $prefix . 'icon', $i ); ?>
									</div>
								</div>

							</div>

							<div class="wpie-tab-settings">

                                <div class="wpie-fieldset">
                                    <div class="wpie-legend"><?php esc_html_e('Item colors', 'bubble-menu');?></div>
                                    <div class="wpie-fields">
	                                    <?php $field->create( $prefix . 'color', $i ); ?>
	                                    <?php $field->create( $prefix . 'background_color', $i ); ?>
                                    </div>
                                </div>
                                <div class="wpie-fieldset">
                                    <div class="wpie-legend"><?php esc_html_e('Label', 'bubble-menu');?></div>
                                    <div class="wpie-fields">
	                                    <?php $field->create( $prefix . 'label_position', $i ); ?>
                                    </div>
                                </div>

							</div>

							<div class="wpie-tab-settings">
								<div class="wpie-fieldset">
									<div class="wpie-fields">
										<?php $field->create( $prefix . 'attribute_id', $i ); ?>
										<?php $field->create( $prefix . 'attribute_class', $i ); ?>
										<?php $field->create( $prefix . 'attribute_rel', $i ); ?>
									</div>
								</div>
							</div>
						</div>


					</div>
				</details>
			<?php endfor; endif; ?>

		<hr class="wpie-buttons__hr">
		<div class="wpie-fields">
			<button class="button button-primary wpie-add-button"
			        type="button"><?php esc_html_e( 'Add Button', 'bubble-menu' ); ?></button>
		</div>

	</div>


	<template id="template-button">
		<details class="wpie-item menu-item" open>
			<input type="hidden" name="param[item_status][]" class="wpie-item__toggle" value="1">
			<summary class="wpie-item_heading">
				<span class="wpie-item_heading_icon"></span>
				<span class="wpie-item_heading_label"></span>
				<span class="wpie-item_heading_type"></span>
				<span class="wpie-item_heading_sub"></span>
				<span class="wpie-icon wpie_icon-chevron-expand-y"></span>
				<span class="wpie-icon wpie_icon-trash"></span>
				<span class="wpie-item_heading_toogle">
                    <span class="wpie-icon wpie_icon-chevron-down"></span>
                    <span class="wpie-icon wpie_icon-chevron-up "></span>
                </span>
			</summary>
			<div class="wpie-item_content">

				<div class="wpie-fieldset">
					<div class="wpie-fields">
						<?php $field->create( $prefix . 'label', -1 ); ?>
						<?php $field->create( $prefix . 'label_on', -1 ); ?>
					</div>
				</div>

				<div class="wpie-tabs-wrapper">

					<div class="wpie-tabs-link">
						<a class="wpie-tab__link is-active"><?php esc_html_e( 'Type', 'bubble-menu' ); ?></a>
						<a class="wpie-tab__link"><?php esc_html_e( 'Icon', 'bubble-menu' ); ?></a>
						<a class="wpie-tab__link"><?php esc_html_e( 'Style', 'bubble-menu' ); ?></a>
						<a class="wpie-tab__link"><?php esc_html_e( 'Attributes', 'bubble-menu' ); ?></a>
					</div>

					<div class="wpie-tab-settings is-active">
						<div class="wpie-fieldset">
							<div class="wpie-fields">
								<?php $field->create( $prefix . 'type', -1 ); ?>
								<?php $field->create( $prefix . 'link', -1 ); ?>
							</div>
						</div>


					</div>

					<div class="wpie-tab-settings">
						<div class="wpie-fieldset">
							<div class="wpie-fields">
								<?php $field->create( $prefix . 'icon_type', -1 ); ?>
								<?php $field->create( $prefix . 'icon', -1 ); ?>
							</div>
						</div>

					</div>

					<div class="wpie-tab-settings">
                        <div class="wpie-fieldset">
                            <div class="wpie-legend"><?php esc_html_e('Item colors', 'bubble-menu');?></div>
                            <div class="wpie-fields">
								<?php $field->create( $prefix . 'color', -1 ); ?>
								<?php $field->create( $prefix . 'background_color', -1 ); ?>
                            </div>
                        </div>
                        <div class="wpie-fieldset">
                            <div class="wpie-legend"><?php esc_html_e('Label', 'bubble-menu');?></div>
                            <div class="wpie-fields">
								<?php $field->create( $prefix . 'label_position', -1 ); ?>
                            </div>
                        </div>

					</div>

					<div class="wpie-tab-settings">
						<div class="wpie-fieldset">
							<div class="wpie-fields">
								<?php $field->create( $prefix . 'attribute_id', -1 ); ?>
								<?php $field->create( $prefix . 'attribute_class', -1 ); ?>
								<?php $field->create( $prefix . 'attribute_rel', -1 ); ?>
							</div>
						</div>
					</div>
                    
				</div>
			</div>
		</details>
	</template>

<?php
