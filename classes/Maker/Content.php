<?php

namespace BubbleMenu\Maker;

defined( 'ABSPATH' ) || exit;

class Content {
	/**
	 * @var mixed
	 */
	private $id;
	/**
	 * @var mixed
	 */
	private $param;
	/**
	 * @var mixed
	 */
	private $title;

	public function __construct( $id, $param ) {
		$this->id    = $id;
		$this->param = $param;
	}

	public function init(): string {
		return $this->create();
	}

	private function create(): string {
		$id    = $this->id;
		$param = $this->param;

		$count = ! empty( $param['item']['type'] ) ? count( $param['item']['type'] ) : 0;

		if ( $count === 0 ) {
			return false;
		}

		$wrapper = $this->wrapper( $id, $param );

		$menu = $wrapper;

		$menu .= $this->button( $param );

		$menu .= '<ul class="bm-list">';

		$menu .= $this->elements( $count, $param );

		$menu .= '</ul></div>'; // close menu tags

		return $menu;
	}

	private function wrapper( $id, $param ): string {
		$position  = isset( $param['position'] ) ? ' ' . $param['position'] : ' -left';
		$shape     = isset( $param['shapes'] ) ? ' ' . $param['shapes'] : ' -circle';
		$size      = isset( $param['size'] ) ? ' ' . $param['size'] : ' -size-md';
		$shadow    = ! empty( $param['shadow'] ) ? ' -shadowless' : ' -shadow';
		$animation = isset( $param['animation'] ) ? ' ' . $param['animation'] : '';
		$open_menu = ! empty( $param['open_menu'] ) ? ' -active' : '';

		$menu_add_classes = $position . $shape . $size . $shadow . $animation . $open_menu;

		$action = '';

		$action_type = ! empty( $param['action'] ) ? $param['action'] : '';

		if ( $action_type === 'scroll_show' ) {
			$action           = ' data-behavior="showScroll:' . absint( $param['scroll'] ) . '"';
			$menu_add_classes .= ' -hidden';
		} elseif ( $action_type === 'scroll_hide' ) {
			$action = ' data-behavior="hideScroll:' . absint( $param['scroll'] ) . '"';
		} elseif ( $action_type === 'timer_show' ) {
			$action           = ' data-behavior="showDelay:' . absint( $param['timer'] ) * 1000 . '"';
			$menu_add_classes .= ' -hidden';
		} elseif ( $action_type === 'timer_hide' ) {
			$action = ' data-behavior="hideDelay:' . absint( $param['timer'] ) * 1000 . '"';
		}

		if ( ! empty( $param['hide_menus'] ) ) {
			$action .= ' data-bubbles-hide="true"';
		}

		if ( ! empty( $param['close_menus'] ) ) {
			$action .= ' data-bubble-toggle="true"';
		}

		$style = '';

		if ( ! empty( $param['zindex'] ) && $param['zindex'] !== '9' ) {
			$style .= '--z-index:' . absint( $param['zindex'] ) . ';';
		}

		if ( ! empty( $param['margin_block'] ) ) {
			$style .= '--margin-block:' . esc_attr( $param['margin_block'] ) . 'px;';
		}

		if ( ! empty( $param['margin_inline'] ) ) {
			$style .= '--margin-inline:' . esc_attr( $param['margin_inline'] ) . 'px;';
		}

		if ( ! empty( $param['label_color'] ) ) {
			$style .= '--label-color:' . esc_attr( $param['label_color'] ) . ';';
		}

		if ( ! empty( $param['label_background_color'] ) ) {
			$style .= '--label-background:' . esc_attr( $param['label_background_color'] ) . ';';
		}


		$style = ! empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '';

		$css = '';
		if ( ! empty( $param['mobile_on'] ) ) {
			$screen = ! empty( $param['mobile'] ) ? $param['mobile'] : 480;
			$css    .= '
					@media only screen and (max-width: ' . absint( $screen ) . 'px){
						#bubble-menu-' . absint( $id ) . ' {
							display:none;
						}
					}';
		}

		if ( ! empty( $param['desktop_on'] ) ) {
			$screen_more = ! empty( $param['desktop'] ) ? $param['desktop'] : 1200;
			$css         .= '
					@media only screen and (min-width: ' . absint( $screen_more ) . 'px){
						#bubble-menu-' . absint( $id ) . ' {
							display:none;
						}
					}';
		}
		if ( ! empty( $css ) ) {
			$css = '<style>' . trim( preg_replace( '~\s+~s', ' ', $css ) ) . '</style>';
		}

		return $css . '<div class="bubble-menu notranslate' . esc_attr( $menu_add_classes ) . '" id="bubble-menu-' . absint( $id ) . '"' . $action . $style . '>';
	}

	private function button( array $param ): string {
		$label = ! empty( $param['label_on'] ) ? $param['label'] : '';

		$style = '--color: ' . ( ! empty( $param['color'] ) ? esc_attr( $param['color'] ) : '#14102C' ) . ';';
		$style .= '--background: ' . ( ! empty( $param['background_color'] ) ? esc_attr( $param['background_color'] ) : '#ffffff' ) . ';';
		$style = ! empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '';

		$keep_on        = ! empty( $param['open'] ) ? ' -visible' : '';
		$paused         = ! empty( $param['icon_animation_paused'] ) ? ' -paused' : '';
		$stop           = ! empty( $param['icon_animation_open'] ) ? ' -stop-animation' : '';
		$label_position = ! empty( $param['label_position'] ) ? ' ' . esc_attr( $param['label_position'] ) : '';

		$out = '<button class="bm-toggle' . esc_attr( $keep_on . $paused . $stop . $label_position ) . '"';
		if ( ! empty( $label ) ) {
			$out .= ' data-label="' . esc_attr( $label ) . '"';
		}
		$out .= $style . '>';
		$out .= $this->create_btn_icon( $param );
		if ( ! empty( $label ) ) {
			$out .= '<span class="bm-label">' . esc_attr( $label ) . '</span>';
		}
		$out .= '</button>';

		return $out;
	}

	private function elements( $count, $param ): string {
		$elements = '';

		for ( $i = 0; $i < $count; $i ++ ) {

			$item_type = $param['item']['type'][ $i ];

			if ( $item_type === 'next_post' ) {
				$next_post = get_next_post( true );
				if ( empty( $next_post ) ) {
					continue;
				}
			} elseif ( $item_type === 'previous_post' ) {
				$previous_post = get_previous_post( true );
				if ( empty( $previous_post ) ) {
					continue;
				}
			}
			$style = '--color:' . esc_attr( $param['item']['color'][ $i ] ) . ';';
			$style .= '--background:' . esc_attr( $param['item']['background_color'][ $i ] ) . ';';

			$elements .= '<li class="bm-item" style="' . esc_attr( $style ) . '">';
			$elements .= $this->create_element( $param, $i, $item_type );
			$elements .= '</li>';

		}

		return $elements;
	}

	private function create_element( $param, $i, $item_type ): string {
		$icon  = $this->create_icon( $param, $i );
		$label = $this->create_label( $param, $i, $item_type );
		$link  = $this->create_link( $param, $i, $item_type, $icon, $label );

		return $link;
	}

	private function create_btn_icon( $param ): string {
		$icon      = '';
		$type      = $param['icon_type'] ?? 'icon';
		$animation = ! empty( $param['icon_animation'] ) ? ' ' . esc_attr( $param['icon_animation'] ) : '';
		$flip      = ! empty( $param['icon_flip'] ) ? ' ' . esc_attr( $param['icon_flip'] ) : '';

		$style = '';

		if ( ! empty( $param['icon_rotate'] ) ) {
			$style .= '--icon-rotate: ' . esc_attr( $param['icon_rotate'] ) . 'deg;';
		}

		if ( ! empty( $param['icon_animation_delay'] ) ) {
			$style .= '--icon-delay: ' . absint( $param['icon_animation_delay'] ) . 's;';
		}

		if ( ! empty( $param['icon_animation_duration'] ) ) {
			$style .= '--icon-duration: ' . absint( $param['icon_animation_duration'] ) . 's;';
		}

		if ( ! empty( $param['icon_animation_count'] ) ) {
			$style .= '--icon-count: ' . absint( $param['icon_animation_count'] ) . ';';
		}

		$style = ! empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '';

		if ( $type === 'icon' ) {
			$icon = '<span class="bm-icon ' . esc_attr( $param['icon'] ) . $animation . $flip . '"' . $style . '></span>';
		}

		if ( $type === 'image' ) {
			$img_alt  = ! empty( $param['image_alt'] ) ? $param['image_alt'] : '';
			$img_link = $param['image'];
			$icon     = '<img class="bm-icon' . esc_attr( $animation . $flip ) . '" src="' . esc_url( $img_link ) . '" alt="' . esc_attr( $img_alt ) . '"' . $style . '>';
		}

		if ( $type === 'class' ) {
			$icon = '<span class="bm-icon ' . esc_attr( $param['icon_class'] . $animation . $flip ) . '"' . $style . '></span>';
		}

		if ( $type === 'emoji' ) {
			$icon = '<span class="bm-icon' . esc_attr( $animation . $flip ) . '"' . $style . '>' . wp_kses_post( $param['emoji'] ) . '</span>';
		}

		return $icon;
	}

	private function create_icon( $param, $i ): string {
		$icon      = '';
		$icon_type = $param['item']['icon_type'][ $i ] ?? 'icon';

		$animation = ! empty( $param['item']['icon_animation'][ $i ] ) ? ' ' . esc_attr( $param['item']['icon_animation'][ $i ] ) : '';
		$flip      = ! empty( $param['item']['icon_flip'][ $i ] ) ? ' ' . esc_attr( $param['item']['icon_flip'][ $i ] ) : '';

		$style = '';

		if ( ! empty( $param['item']['icon_rotate'][ $i ] ) ) {
			$style .= '--icon-rotate: ' . esc_attr( $param['item']['icon_rotate'][ $i ] ) . 'deg;';
		}

		if ( ! empty( $param['item']['icon_animation_delay'][ $i ] ) ) {
			$style .= '--icon-delay: ' . absint( $param['item']['icon_animation_delay'][ $i ] ) . 's;';
		}

		if ( ! empty( $param['item']['icon_animation_duration'][ $i ] ) ) {
			$style .= '--icon-duration: ' . absint( $param['item']['icon_animation_duration'][ $i ] ) . 's;';
		}

		if ( ! empty( $param['item']['icon_animation_count'][ $i ] ) ) {
			$style .= '--icon-count: ' . absint( $param['item']['icon_animation_count'][ $i ] ) . ';';
		}

		$style = ! empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '';

		if ( $icon_type === 'icon' ) {
			$icon = '<span class="bm-icon ' . esc_attr( $param['item']['icon'][ $i ] . $animation . $flip ) . '"' . $style . '></span>';
		}

		if ( $icon_type === 'image' ) {
			$img_alt  = ! empty( $param['item']['image_alt'][ $i ] ) ? $param['item']['image_alt'][ $i ] : '';
			$img_link = $param['item']['image'][ $i ];
			$icon     = '<img class="bm-icon' . esc_attr( $animation . $flip ) . '" src="' . esc_url( $img_link ) . '" alt="' . esc_attr( $img_alt ) . '"' . $style . '>';
		}

		if ( $icon_type === 'class' ) {
			$icon = '<span class="bm-icon ' . esc_attr( $param['item']['icon_class'][ $i ] . $animation . $flip ) . '"' . $style . '></span>';
		}

		if ( $icon_type === 'emoji' ) {
			$icon = '<span class="bm-icon' . esc_attr( $animation . $flip ) . '"' . $style . '>' . wp_kses_post( $param['item']['emoji'][ $i ] ) . '</span>';
		}

		return $icon;
	}

	private function create_label( $param, $i, $item_type ): string {
		$label = '';
		$text  = ! empty( $param['item']['label_on'][ $i ] ) ? $param['item']['label'][ $i ] : '';

		if ( $item_type === 'email' ) {
			$text = is_email( $text ) ? antispambot( $text ) : $text;
		}

		$label = ! empty( $text ) ? '<span class="bm-label">' . esc_html( $text ) . '</span>' : '';

		return $label;
	}

	private function create_link( $param, $i, $item_type, $icon, $tooltip ): string {
		$link_param = $this->link_param( $param, $i );
		$menu       = '';
		$text       = ! empty( $param['item']['label_on'][ $i ] ) ? $param['item']['label'][ $i ] : '';
		if ( ! empty( $text ) ) {
			$link_param .= ' data-label="' . esc_attr( $text ) . '"';
		}

		switch ( $item_type ) {
			case 'link':
				$target = ! empty( $param['item']['link_tab'][ $i ] ) ? '_blank' : '_self';
				$link   = ! empty( $param['item']['link'][ $i ] ) ? $param['item']['link'][ $i ] : '#';
				$menu   .= '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu   .= $icon . $tooltip;
				$menu   .= '</a>';
				break;
			case 'download':
				$link     = ! empty( $param['item']['link'][ $i ] ) ? $param['item']['link'][ $i ] : '#';
				$download = ! empty( $param['item']['download'][ $i ] ) ? ' download="' . esc_attr( $param['item']['download'][ $i ] ) . '"' : ' download';
				$menu     .= '<a href="' . esc_attr( $link ) . '"' . $download . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu     .= $icon . $tooltip;
				$menu     .= '</a>';
				break;
			case 'share':
				$share_service = mb_strtolower( $param['item']['share'][ $i ] );
				$menu          .= '<a href="#" data-action="share" data-target="' . esc_attr( $share_service ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu          .= $icon . $tooltip;
				$menu          .= '</a>';
				break;
			case 'translate':
				$glang = $param['item']['translate'][ $i ];
				$menu  .= '<a href="#" data-action="translate" data-target="' . esc_attr( $glang ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu  .= $icon . $tooltip;
				$menu  .= '</a>';
				break;
			case 'print':
			case 'totop':
			case 'tobottom':
			case 'goback':
			case 'goforward':
			case 'copyUrl':
			case 'bookmark':
				$menu .= '<a href="#" data-action="' . esc_attr( $item_type ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'smoothscroll':
				$link = ! empty( $param['item']['link'][ $i ] ) ? $param['item']['link'][ $i ] : '#';
				$menu .= '<a href="' . esc_attr( $link ) . '" data-action="' . esc_attr( $item_type ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'scrollSpy':
				$link = ! empty( $param['item']['link'][ $i ] ) ? $param['item']['link'][ $i ] : '#';
				$menu .= '<a href="' . esc_attr( $link ) . '" data-action="scrollSpy"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'login':
			case 'logout':
			case 'lostpassword':
				$link = call_user_func( 'wp_' . $item_type . '_url', $param['item']['link'][ $i ] );
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'register':
				$link = wp_registration_url();
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'telephone':
				$link = 'tel:' . $param['item']['link'][ $i ];
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'email':
				$email   = $param['item']['link'][ $i ];
				$link    = is_email( $email ) ? 'mailto:' . antispambot( $email ) : $email;
				$tooltip = is_email( $tooltip ) ? antispambot( $tooltip ) : $tooltip;
				$menu    .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu    .= $icon . $tooltip;
				$menu    .= '</a>';
				break;
			case 'next_post':
				$target    = ! empty( $param['item']['link_tab'][ $i ] ) ? '_blank' : '_self';
				$next_post = get_next_post( true );
				$link      = get_permalink( $next_post );
				$menu      .= '<a href="' . esc_attr( $link ) . '" target="' . esc_attr( $target ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu      .= $icon . $tooltip;
				$menu      .= '</a>';
				break;
			case 'previous_post':
				$target        = ! empty( $param['item']['link_tab'][ $i ] ) ? '_blank' : '_self';
				$previous_post = get_previous_post( true );
				$link          = get_permalink( $previous_post );
				$menu          .= '<a href="' . esc_attr( $link ) . '" target="' . esc_attr( $target ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu          .= $icon . $tooltip;
				$menu          .= '</a>';
				break;
			case 'font':
				$action = ! empty( $param['item']['font'][ $i ] ) ? $param['item']['font'][ $i ] : 'increase';
				$menu   .= '<a href="#" data-action="' . esc_attr( $item_type ) . '" data-target="' . esc_attr( $action ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu   .= $icon . $tooltip;
				$menu   .= '</a>';
				break;
			case 'popover':
				$link = 'bm-popover-' . $this->id . '-' . $i;
				$menu .= '<a href="#' . esc_attr( $link ) . '" data-action="popover"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';

				$style = '--popover-size:' . absint( $param['item']['popup_size'][ $i ] ) . 'px;';
				$style .= '--popover-inline:' . absint( $param['item']['popup_width'][ $i ] ) . 'px;';
				$style .= '--popover-block:' . absint( $param['item']['popup_height'][ $i ] ) . 'px;';
				$style .= '--popover-padding:' . absint( $param['item']['popup_padding'][ $i ] ) . 'px;';
				$style .= '--popover-border-color:' . esc_attr( $param['item']['popup_border_color'][ $i ] ) . ';';
				$style .= '--popover-backdrop:' . esc_attr( $param['item']['popup_backdrop'][ $i ] ) . ';';
				$menu  .= '<div id="' . esc_attr( $link ) . '" popover style="' . esc_attr( $style ) . '">';
				$menu  .= wpautop( do_shortcode( wp_kses_post( $param['item']['popup'][ $i ] ) ) );
				$menu  .= '</div>';
				break;
			case 'skype_call':
				$link = 'skype:' . $param['item']['link'][ $i ] . '?call';
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'skype_chat':
				$link = 'skype:' . $param['item']['link'][ $i ] . '?chat';
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'whatsapp_call':
				$link = 'whatsapp://call?number=' . $param['item']['link'][ $i ];
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'whatsapp_chat':
				$link = 'https://wa.me/' . $param['item']['link'][ $i ];
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'viber_call':
				$link = 'viber://call?number=' . $param['item']['link'][ $i ];
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'viber_chat':
				$link = 'viber://chat?number=' . $param['item']['link'][ $i ];
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'imessage_chat':
				$link = 'imessage:' . $param['item']['link'][ $i ];
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'telegram_chat':
				$link = 'https://t.me/' . $param['item']['link'][ $i ];
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;

		}

		return $menu;
	}

	private function generate_link(
		$url,
		$target = '',
		$icon = '',
		$tooltip = '',
		$link_param = '',
		$data_attr = '',
		$data_value = ''
	): string {
		$link = '<a href="' . esc_url( $url ) . '" ' . wp_specialchars_decode( $link_param, 'double' );
		$link .= ! empty( $target ) ? ' target="' . esc_attr( $target ) . '"' : '';
		$link .= ! empty( $data_attr ) ? ' ' . esc_attr( $data_attr ) . '="' . esc_attr( $data_value ) . '"' : '';
		$link .= '>';
		$link .= $icon . $tooltip;
		$link .= '</a>';

		return $link;
	}

	private function link_param( $param, $i ): string {
		$style = '';
		if ( ! empty( $param['item']['label_color'][ $i ] ) ) {
			$style .= '--label-color:' . esc_attr( $param['item']['label_color'][ $i ] ) . ';';
		}

		if ( ! empty( $param['item']['label_background_color'][ $i ] ) ) {
			$style .= '--label-background:' . esc_attr( $param['item']['label_background_color'][ $i ] ) . ';';
		}

		$style = ! empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '';

		$button_class = $param['item']['attribute_class'][ $i ];
		$class_add    = ' class="bm-link';
		$class_add    .= ! empty( $button_class ) ? ' ' . esc_attr( $button_class ) : '';
		if ( ! empty( $param['item']['open'][ $i ] ) ) {
			$class_add .= ' -visible';
		}
		if ( ! empty( $param['item']['icon_animation_paused'][ $i ] ) ) {
			$class_add .= ' -paused';
		}

		if ( ! empty( $param['item']['label_position'][ $i ] ) ) {
			$class_add .= ' ' . esc_attr( $param['item']['label_position'][ $i ] );
		}

		$class_add .= '"';
		$button_id = $param['item']['attribute_id'][ $i ];
		$id_add    = ! empty( $button_id ) ? ' id="' . esc_attr( $button_id ) . '"' : '';
		$link_rel  = ! empty( $param['item']['attribute_rel'][ $i ] ) ? ' rel="' . esc_attr( $param['item']['attribute_rel'][ $i ] ) . '"' : '';

		return $id_add . $class_add . $link_rel . $style;
	}

}