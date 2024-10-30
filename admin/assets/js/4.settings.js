'use strict';

jQuery(document).ready(function ($) {

    const prefix = 'item-';

    const selectors = {
        settings: '#wpie-settings',
        color_picker: '.wpie-color',
        full_editor: '.wpie-fulleditor',
        short_editor: '.wpie-texteditor',
        checkbox: '.wpie-field input[type="checkbox"]',
        item_heading: '.wpie-item .wpie-item_heading',
        image_download: '.wpie-image-download',

        items_list: '.wpie-items__list',

        item: '.menu-item',

        icon_type: `[data-field-box*="icon_type"] select, [data-field-box*="${prefix}icon_type"] select`,
        item_type: `[data-field="${prefix}type"]`,
        action: `[data-field="action"]`,
        icon_animation: `[data-field-box*="icon_animation"] select, [data-field-box*="${prefix}icon_animation"] select`,

        enable_tracking: '[data-field="${prefix}enable_tracking"]',
        add_item: '.wpie-add-button',
        item_remove: '.wpie-item_heading .wpie_icon-trash',

    };


    function set_up() {

        $(selectors.full_editor).wowFullEditor();
        $(selectors.short_editor).wowTextEditor();

        $(selectors.color_picker).wpColorPicker({
            change: function (event, ui) {
                $(selectors.item).wowpMenuLiveBuilder();
            },
        });

        $(selectors.item).wowpMenuLiveBuilder();

        $('.wpie-icon-box').wowIconPicker();

        $(selectors.items_list).sortable({
            items: '> .wpie-item',
            placeholder: "wpie-item ui-state-highlight",
            axis: "y",
            cursor: "move",
            handle: '.wpie-item_heading',
            cancel: '.wpie-item_content',
            update: function (event, ui) {

            }
        });

        $(selectors.color_picker).wpColorPicker();
        $(selectors.image_download).wowImageDownload();
        $(selectors.checkbox).each(set_checkbox);

        $(selectors.icon_type).each(icon_type);
        $(selectors.item_type).each(item_type);
        $(selectors.icon_animation).each(icon_animation);
        $(selectors.action).each(action);

        $(selectors.enable_tracking).each(enable_tracking);



    }

    function initialize_events() {
        $(selectors.settings).on('change', selectors.checkbox, set_checkbox);
        $(selectors.settings).on('click', selectors.item_heading, item_toggle);

        $(selectors.settings).on('change', selectors.item_type, item_type);
        $(selectors.settings).on('change', selectors.icon_type, icon_type);
        $(selectors.settings).on('change', selectors.icon_animation, icon_animation);
        $(selectors.settings).on('change', selectors.action, action);

        $(selectors.settings).on('change', selectors.enable_tracking, enable_tracking);
        $(selectors.settings).on('click', selectors.add_item, clone_button);
        $(selectors.settings).on('click', selectors.item_remove, item_remove);


        $(selectors.settings).on('change click keyup', selectors.item, function () {
            $(selectors.item).wowpMenuLiveBuilder();
        });

    }

    //region Main
    function initialize() {
        set_up();
        initialize_events();
    }

    // Set the checkboxes
    function set_checkbox() {
        const next = $(this).next('input[type="hidden"]');
        if ($(this).is(':checked')) {
            next.val('1');
        } else {
            next.val('0');
        }
    }

    function item_toggle() {
        const parent = get_parent_fields($(this), '.wpie-item');
        const val = $(parent).attr('open') ? '0' : '1';
        $(parent).find('.wpie-item__toggle').val(val);
    }

    function get_parent_fields($el, $class = '.wpie-fields') {
        return $el.closest($class);
    }

    function get_field_box($el, $class = '.wpie-field') {
        return $el.closest($class);
    }

    //endregion

    //region Plugin
    function icon_type() {
        const type = $(this).val();
        const box = get_field_box($(this));
        const parent = get_parent_fields($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');

        const fieldMap = {
            icon: ['icon', 'item-icon'],
            image: ['image', 'image_alt', 'item-image', 'item-image_alt'],
            class: ['icon_class', 'item-icon_class'],
            emoji: ['emoji', 'item-emoji'],
        }

        if (fieldMap[type]) {
            const fieldsToShow = fieldMap[type];
            fieldsToShow.forEach(field => {
                parent.find(`[data-field-box|="${field}"]`).removeClass('is-hidden');
            });
        }
    }


    function item_type() {
        const type = $(this).val();
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        const parentTab = get_parent_fields($(this), '.wpie-tabs-wrapper');

        parentTab.find('.wpie-tab__type-menu').addClass('is-hidden');
        fields.addClass('is-hidden');

        const linkText = parent.find(`[data-field-box="${prefix}link"] .wpie-field__title`);
        linkText.text('Link');

        // Mapping menu types to the respective field boxes.
        const typeFieldMapping = {
            link: [`${prefix}link`, `${prefix}link_tab`],
            next_post: [`${prefix}link_tab`],
            previous_post: [`${prefix}link_tab`],
            share: [`${prefix}share`],
            translate: [`${prefix}translate`],
            smoothscroll: [`${prefix}link`],
            scrollSpy: [`${prefix}link`],
            download: [`${prefix}link`, `${prefix}download`],
            login: [`${prefix}link`],
            logout: [`${prefix}link`],
            lostpassword: [`${prefix}link`],
            email: [`${prefix}link`],
            telephone: [`${prefix}link`],
            font: [`${prefix}font`],
            popover: [],
            skype_call: [`${prefix}link`],
            skype_chat: [`${prefix}link`],
            whatsapp_call: [`${prefix}link`],
            whatsapp_chat: [`${prefix}link`],
            viber_call: [`${prefix}link`],
            viber_chat: [`${prefix}link`],
            telegram_chat: [`${prefix}link`],
            imessage_chat: [`${prefix}link`],
        };

        // Customize the link text for certain types
        const linkTextMapping = {
            login: 'Redirect URL',
            logout: 'Redirect URL',
            lostpassword: 'Redirect URL',
            email: 'Email',
            telephone: 'Phone number',
            download: 'File URL',
            skype_call: 'Username',
            skype_chat: 'Username',
            whatsapp_call: 'Phone number',
            whatsapp_chat: 'Phone number',
            viber_call: 'Phone number',
            viber_chat: 'Phone number',
            telegram_chat: 'Username',
            imessage_chat: 'Phone number',
        };

        if (type === 'popover') {
            parentTab.find('.wpie-tab__type-menu').removeClass('is-hidden');
        } else if (typeFieldMapping[type]) {
            const fieldsToShow = typeFieldMapping[type];
            fieldsToShow.forEach(field => {
                parent.find(`[data-field-box|="${field}"]`).removeClass('is-hidden');
            });

            if (linkTextMapping[type]) {
                linkText.text(linkTextMapping[type]);
            }

        }
    }

    // Position
    function icon_animation() {
        const type = $(this).val();
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');

        if(type !== '') {
            fields.removeClass('is-hidden');
        }
    }

    function action() {
        const type = $(this).val();
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');

        if(type === 'scroll_show' || type === 'scroll_hide') {
            parent.find('[data-field-box="scroll"]').removeClass('is-hidden');
        }

        if(type === 'timer_show' || type === 'timer_hide') {
            parent.find('[data-field-box="timer"]').removeClass('is-hidden');
        }
    }

    // Enable Event Tracking
    function enable_tracking() {
        const fieldset = get_parent_fields($(this), '.wpie-fieldset');
        const tracking_field = fieldset.find('.wpie-event-tracking');
        tracking_field.addClass('is-hidden');
        if ($(this).is(':checked')) {
            tracking_field.removeClass('is-hidden');
        }
    }


    function item_remove() {
        const userConfirmed = confirm("Are you sure you want to remove this element?");
        if (userConfirmed) {
            const parent = $(this).closest('.wpie-item');
            $(parent).remove();
            set_up();
        }
    }


    // Clone menu item
    function clone_button(e) {
        e.preventDefault();
        const parent = get_parent_fields($(this), '.wpie-items__list');
        const selector = $(parent).find('.wpie-buttons__hr');
        const template = $('#template-button').clone().html();

        $(template).insertBefore($(selector));

        set_up();
    }


    initialize();
});