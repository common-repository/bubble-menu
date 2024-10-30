'use strict';
(function ($) {

    $.fn.wowpMenuLiveBuilder = function () {
        this.each(function (index, element) {
            const icon = $(this).find('.wpie-item_heading_icon');
            const label = $(this).find('.wpie-item_heading_label');
            const type = $(this).find('.wpie-item_heading_type');

            const labelText = $(this).find('[data-field|="label"], [data-field|="item-label"]').val();
            const typeText = $(this).find('[data-field="item-type"] option:selected').text();
            const color = $(this).find('[data-field|="color"], [data-field|="item-color"]').val();
            const bg = $(this).find('[data-field|="background_color"], [data-field|="item-background_color"]').val();

            icon.css({'color': color, 'background': bg});

            icon.on('mouseenter', () => {
                icon.css({'color': bg, 'background': color});
            }).on( "mouseleave", () => {
                icon.css({'color': color, 'background': bg});
            } );

            const iconValue = getIcon(this);

            label.text(labelText);
            icon.html(iconValue);
            type.text(typeText);

        });

        function getIcon(element) {
            const iconRotate = $(element).find('[data-field|="icon_rotate"], [data-field|="item-icon_rotate"]').val();
            const iconFlip = $(element).find('[data-field|="icon_flip"], [data-field|="item-icon_flip"]').val();
            let style = ' style="';
            if(iconRotate !== '' || iconRotate !== '0') {
                style += `rotate: ${iconRotate}deg;`;
            }

            if(iconFlip !== '') {
                if(iconFlip === '-flip-horizontal') {
                    style += `scale: -1 1;`;
                }
                if(iconFlip === '-flip-vertical') {
                    style += `scale: 1 -1;`;
                }
                if(iconFlip === '-flip-both') {
                    style += `scale: -1 -1;`;
                }
            }

            style += '"';

            const type = $(element).find('[data-field|="icon_type"], [data-field|="item-icon_type"]').val();

            if(type === 'icon') {
                let icon = $(element).find('.selected-icon').html();
                if(icon === undefined || $.trim(icon) === '<i class="fip-icon-block"></i>') {
                    icon = $(element).find('[data-field|="icon"], [data-field|="item-icon"]').val();
                    icon = `<i class="${icon}"></i>`;
                }
                icon = icon.replace('class=', style + ' class=');
                return icon;
            }

            if(type === 'image') {
                let icon = $(element).find('[data-field|="image"], [data-field|="item-image"]').val();
                return `<img src="${icon}" ${style}>`;
            }

            if(type === 'class') {
                let icon = $(element).find('[data-field|="icon_class"], [data-field|="item-icon_class"]').val();
                return `<i class="dashicons dashicons-camera-alt" ${style}></i>`;
            }

            if(type === 'emoji') {
                let icon = $(element).find('[data-field|="emoji"], [data-field|="item-emoji"]').val();
                return `<span ${style}>${icon}</span>`;
            }

            return '';
        }
    }

}(jQuery));