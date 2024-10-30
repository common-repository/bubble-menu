<?php

namespace BubbleMenu\Update;

class ParamUpdater {
	private $param;

	public function __construct( $param ) {
		$this->param = $param;
	}

	public function update() {
		$this->update_main_settings();
		$this->update_items_settings();
		$this->update_rules_settings();

		return $this->param;
	}

	private function update_main_settings(): void {
		$this->param['open_menu'] = $this->param['hold_open'] ?? '';

		$this->param += [
			'label'         => '',
			'label_on'      => 0,
			'open'          => 0,
			'margin_block'  => 0,
			'margin_inline' => 0,
			'open_menu'     => 0,
			'hide_menus'    => 0,
			'close_menus'   => 0,
			'action'        => '',
		];

		// Update Position
		$position = $this->param['menu'] ?? '-left';

		$this->param['position'] = str_replace( [
			'wow-bmp-pos-t',
			'wow-bmp-pos-r',
			'wow-bmp-pos-b',
			'wow-bmp-pos-l',
			'wow-bmp-pos-tl',
			'wow-bmp-pos-tr',
			'wow-bmp-pos-br',
			'wow-bmp-pos-bl'
		], [
			'-top',
			'-right',
			'-bottom',
			'-left',
			'-top-left',
			'-top-right',
			'-bottom-right',
			'-bottom-left'
		], $position );


		//Update Shapes
		$shapes = empty( $this->param['shapes'] ) ? '-circle' : $this->param['shapes'];

		// Update position
		$this->param['shapes'] = str_replace( [
			'wow-bmp-shape-rsquare',
			'wow-bmp-shape-ellipse',
			'wow-bmp-shape-square'
		], [
			'-rounded',
			'-ellipse',
			'-square'
		], $shapes );

		$animation = ! empty( $this->param['animation'] ) ? $this->param['animation'] : '-effect-obo';
		if ( strpos( $animation, 'wow-bmp-effect-aao' ) === false ) {
			$animation .= ' -effect-obo';
		}

		$animation = str_replace( [ 'wow-bmp', 'wow-bmp-effect-aao' ], [ '', '' ], $animation );

		$this->param['animation'] = $animation;

		// Update Main Icon
		$this->param += [
			'icon_type'      => 'icon',
			'icon_rotate'    => 0,
			'icon_flip'      => '',
			'icon_animation' => '',
			'image'          => '',
			'image_alt'      => '',
			'icon_class'     => '',
			'emoji'          => '',
		];

		$this->param['icon'] = $this->param['menu_icon'] ?? 'fas fa-wand-magic-sparkles';

		if ( ! empty( $this->param['main_icon_custom'] ) ) {
			$this->param['icon_type'] = 'image';
			$this->param['image']     = $this->param['main_item_custom_link'];
			$this->param['image_alt'] = $this->param['main_image_alt'];
		}

		// Update Style
		$color_search = [
			'white',
			'grey',
			'black',
			'red',
			'orange',
			'yellow',
			'lime',
			'green',
			'cyan',
			'blue',
			'purple',
			'pink',
		];

		$color_replace = [
			'#ffffff',
			'#808080',
			'#000000',
			'#e3001b',
			'#ff6600',
			'#ffcc01',
			'#b1c903',
			'#27a22d',
			'#00b1e5',
			'#006bb3',
			'#ad007c',
			'#ea4c89'
		];

		$color      = $this->param['color'] ?? '#14102C';
		$background = $this->param['hcolor'] ?? '#ffffff';

		$this->param['color']            = str_replace( $color_search, $color_replace, $color );
		$this->param['background_color'] = str_replace( $color_search, $color_replace, $background );

		$this->param += [
			'size'                   => '-size-md',
			'shadow'                 => '',
			'label_position'         => '',
			'label_color'            => '#ffffff',
			'label_background_color' => '#14102C',
			'attribute_rel'          => '',
		];

		// Attributes
		$this->param['attribute_id']    = $this->param['main_id'] ?? '';
		$this->param['attribute_class'] = $this->param['main_class'] ?? '';
	}

	private function update_items_settings(): void {
		if ( empty( $this->param['item_type'] ) || ! is_array( $this->param['item_type'] ) ) {
			return;
		}

		$count = count( $this->param['item_type'] );
		for ( $i = 0; $i < $count; $i ++ ) {
			$this->update_item_settings( $i );
		}
	}

	private function update_item_settings( $i ): void {
		$this->param['item']['label'][ $i ]    = $this->param['item_tooltip'][ $i ] ?? '';
		$this->param['item']['label_on'][ $i ] = $this->param['item_tooltip_include'][ $i ] ?? '';
		$this->param['item']['open'][ $i ]     = ( isset( $this->param['item_tooltip_show'][ $i ] ) && $this->param['item_tooltip_show'][ $i ] === '2' ) ? 1 : 0;

		// Item type
		$this->param['item']['type'][ $i ]      = $this->param['item_type'][ $i ] ?? 'link';
		$this->param['item']['link'][ $i ]      = $this->param['item_link'][ $i ] ?? '';
		$this->param['item']['link_tab'][ $i ]  = ( isset( $this->param['open_link'][ $i ] ) && $this->param['open_link'][ $i ] === '_blank' ) ? 1 : 0;
		$this->param['item']['share'][ $i ]     = ! empty( $this->param['item_share'][ $i ] ) ? mb_strtolower( $this->param['item_share'][ $i ] ) : 'blogger';
		$this->param['item']['translate'][ $i ] = $this->param['gtranslate'][ $i ] ?? 'en';

		// Icon
		$this->param['item']['icon_type'][ $i ] = 'icon';
		$this->param['item']['icon'][ $i ]      = $this->param['item_icon'][ $i ] ?? '';

		$this->param['item']['image'][ $i ]     = '';
		$this->param['item']['image_alt'][ $i ] = '';

		if ( ! empty( $this->param['icon_custom'][ $i ] ) ) {
			$this->param['item']['icon_type'][ $i ] = 'image';
			$this->param['item']['image'][ $i ]     = $this->param['item_custom_link'][ $i ] ?? '';
			$this->param['item']['image_alt'][ $i ] = $this->param['image_alt'][ $i ] ?? '';
		}

		$this->param['item']['icon_class'][ $i ]     = '';
		$this->param['item']['emoji'][ $i ]          = '';
		$this->param['item']['icon_rotate'][ $i ]    = 0;
		$this->param['item']['icon_flip'][ $i ]      = '';
		$this->param['item']['icon_animation'][ $i ] = '';

		// Style
		$color_search = [
			'white',
			'grey',
			'black',
			'red',
			'orange',
			'yellow',
			'lime',
			'green',
			'cyan',
			'blue',
			'purple',
			'pink',
		];

		$color_replace = [
			'#ffffff',
			'#808080',
			'#000000',
			'#e3001b',
			'#ff6600',
			'#ffcc01',
			'#b1c903',
			'#27a22d',
			'#00b1e5',
			'#006bb3',
			'#ad007c',
			'#ea4c89'
		];

		$color      = $this->param['item_color'][ $i ] ?? '#14102C';
		$background = $this->param['item_hcolor'][ $i ] ?? '#ffffff';

		$this->param['item']['color'][ $i ]            = str_replace( $color_search, $color_replace, $color );
		$this->param['item']['background_color'][ $i ] = str_replace( $color_search, $color_replace, $background );

		$this->param['item']['label_position'][ $i ]         = '';
		$this->param['item']['label_color'][ $i ]            = '#ffffff';
		$this->param['item']['label_background_color'][ $i ] = '#14102C';

		// Attributes
		$this->param['item']['attribute_id'][ $i ]    = $this->param['button_id'][ $i ] ?? '';
		$this->param['item']['attribute_class'][ $i ] = $this->param['button_class'][ $i ] ?? '';
		$this->param['item']['attribute_rel'][ $i ]   = $this->param['link_rel'][ $i ] ?? '';

	}

	private function update_rules_settings(): void {
		// Devices
		$this->param['desktop_on'] = $this->param['include_more_screen'] ?? '';
		$this->param['desktop']    = $this->param['screen_more'] ?? '';
		$this->param['mobile_on']  = $this->param['include_mobile'] ?? '';
		$this->param['mobile']     = $this->param['screen'] ?? '';


		$this->param['fontawesome'] = ! empty( $this->param['disable_fontawesome'] ) ? 1 : 0;


		$show_old = ! empty( $this->param['show'] ) ? $this->param['show'] : 'everywhere';

		$this->param['show']      = [];
		$this->param['operator']  = [];
		$this->param['page_type'] = [];
		$this->param['ids']       = [];

		$this->param['show'][0]      = 'shortcode';
		$this->param['operator'][0]  = '1';
		$this->param['page_type'][0] = 'is_front_page';
		$this->param['ids'][0]       = ! empty( $this->param['id_post'] ) ? $this->param['id_post'] : '';

		switch ( $show_old ) {
			case 'all':
				$this->param['show'][0] = 'everywhere';
				break;
			case 'onlypost':
				$this->param['show'][0] = 'post_all';
				break;
			case 'posts':
				$this->param['show'][0] = 'post_selected';
				break;
			case 'postsincat':
				$this->param['show'][0] = 'post_category';
				break;
			case 'expost':
				$this->param['show'][0]     = 'post_selected';
				$this->param['operator'][0] = 0;
				break;
			case 'onlypage':
				$this->param['show'][0] = 'page_all';
				break;
			case 'pages':
				$this->param['show'][0] = 'page_selected';
				break;
			case 'expage':
				$this->param['show'][0]     = 'page_selected';
				$this->param['operator'][0] = 0;
				break;
			case 'homepage':
				$this->param['show'][0]      = 'page_type';
				$this->param['page_type'][0] = 'is_front_page';
				break;
			case 'searchpage':
				$this->param['show'][0]      = 'page_type';
				$this->param['page_type'][0] = 'is_search';
				break;
			case 'archivepage':
				$this->param['show'][0]      = 'page_type';
				$this->param['page_type'][0] = 'is_archive';
				break;
			case 'error_page':
				$this->param['show'][0]      = 'page_type';
				$this->param['page_type'][0] = 'is_404';
				break;
			case 'post_type':
				$custom_post            = $this->param['post_types'] ?? '';
				$this->param['show'][0] = 'custom_post_all_' . $custom_post;
				break;
			case 'taxonomy':
				$taxonomy               = $this->param['taxonomy'] ?? '';
				$this->param['show'][0] = 'custom_post_tax_|' . $taxonomy;
				break;
		}


	}
}