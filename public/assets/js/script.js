/**
 * BubbleMenu
 * A JavaScript class for creating customizable side menus.
 *
 * @version 4.0.0
 * @license MIT License
 * @author Dmytro Lobov
 * @url https://wow-estore.com/item/bubble-menu-pro/
 */

'use strict';


const BubbleMenu = () => {
    const menus = document.querySelectorAll('.bubble-menu');
    if (menus.length === 0) return;

    const ITEM_PADDING = 15;
    const BASE_ANGLE_NON_POSITIONED = Math.PI;
    const BASE_ANGLE_POSITIONED = Math.PI / 2;

    menus.forEach(menu => {
        initializeMenu(menu);
    });

    function initializeMenu(menu) {
        menu.classList.add('-show');
        const toggle = getElement(menu, '.bm-toggle');
        const items = getElements(menu, '.bm-item');
        const links = getElements(menu, '.bm-link');
        const itemWidth = getItemWidth(items);
        const isPositioned = isPositionedMenu(menu);
        const angleIncrement = calculateAngleIncrement(items.length, isPositioned);
        let radius = calculateOptimalRadius(itemWidth, angleIncrement);
        const minRadius = itemWidth * 1.5;

        if(radius < minRadius) {
            radius = minRadius;
        }

        setMenuProperties(menu, items, angleIncrement, radius);
        updateMenuStatus(menu, links);
        attachEventListeners(menu, toggle, links);
    }

    function getElement(parent, selector) {
        return parent.querySelector(selector);
    }

    function getElements(parent, selector) {
        return parent.querySelectorAll(selector);
    }

    function getItemWidth(items) {
        return items[0].offsetWidth + ITEM_PADDING;
    }

    function isPositionedMenu(menu) {
        const positions = ['-top-left', '-top-right', '-bottom-left', '-bottom-right'];
        return positions.some(position => menu.classList.contains(position));
    }

    function calculateAngleIncrement(itemCount, isPositioned) {
        const baseAngle = isPositioned ? BASE_ANGLE_POSITIONED : BASE_ANGLE_NON_POSITIONED;
        return baseAngle / (itemCount - 1);
    }

    function calculateOptimalRadius(itemWidth, angleIncrement) {
        return (itemWidth / 2) / Math.sin(angleIncrement / 2);
    }

    function setMenuProperties(menu, items, angleIncrement, radius) {
        items.forEach((item, index) => {
            const reverseIndex = items.length - 1 - index;
            const angle = determineAngleForMenu(menu, angleIncrement, index, reverseIndex);
            styleMenuItem(item, menu, radius, angle, index);
        });
    }

    function determineAngleForMenu(menu, angleIncrement, index, reverseIndex) {
        if (menu.classList.contains('-top')) return angleIncrement * reverseIndex;
        if (menu.classList.contains('-top-right')) return angleIncrement * reverseIndex + Math.PI / 2;
        if (menu.classList.contains('-top-left')) return angleIncrement * index;
        if (menu.classList.contains('-left')) return angleIncrement * index - Math.PI / 2;
        if (menu.classList.contains('-right')) return angleIncrement * reverseIndex + Math.PI / 2;
        if (menu.classList.contains('-bottom')) return angleIncrement * reverseIndex * -1;
        if (menu.classList.contains('-bottom-right')) return angleIncrement * reverseIndex + Math.PI;
        if (menu.classList.contains('-bottom-left')) return angleIncrement * index - Math.PI / 2;
        return angleIncrement * index - Math.PI / 2;
    }

    function styleMenuItem(item, menu, radius, angle, index) {
        const labelPosition = determineLabelPosition(menu, angle);
        const link = item.querySelector('.bm-link');
        link.classList.add(labelPosition);
        applyToggleClass(menu);
        const x = radius * Math.cos(angle);
        const y = radius * Math.sin(angle);
        item.style.setProperty('--x', `${x}px`);
        item.style.setProperty('--y', `${y}px`);
        if (index > 0) {
            item.style.setProperty('--delay', `0.${index}s`);
        }
    }

    function applyToggleClass(menu) {
        const toggle = menu.querySelector('.bm-toggle');
        if (menu.classList.contains('-top-right') || menu.classList.contains('-bottom-right') || menu.classList.contains('-right')) {
            toggle.classList.add('-left');
        } else {
            toggle.classList.add('-right');
        }
    }

    function determineLabelPosition(menu, angle) {
        if (menu.classList.contains('-bottom')) return angle < -1.571 ? '-top-left' : '-top-right';
        if (menu.classList.contains('-top')) return angle < 1.571 ? '-bottom-right' : '-bottom-left';
        if (menu.classList.contains('-bottom-left')) return '-top-right';
        if (menu.classList.contains('-top-left')) return '-bottom-right';
        if (menu.classList.contains('-bottom-right')) return '-top-left';
        if (menu.classList.contains('-top-right')) return '-bottom-left';
        if (menu.classList.contains('-right')) return angle < 2.36 ? '-bottom-left' : angle < 3.92 ? '-left' : '-top-left';
        if (menu.classList.contains('-left')) return angle < -0.78 ? '-top-right' : angle < 0.78 ? '-right' : '-bottom-right';
    }

    function updateMenuStatus(menu, links) {
        const isActive = menu.classList.contains('-active');
        links.forEach(link => link.setAttribute('tabindex', isActive ? '0' : '-1'));
        const updateVisibility = (bubble) => {
            if(!bubble.classList.contains('-active')) {
                bubble.classList.remove('-show');
            } else {
                bubble.classList.add('-show');
            }
        };

        if(isActive && menu.hasAttribute('data-bubbles-hide')) {
            menus.forEach(updateVisibility);
        } else {
            menus.forEach(bubble => bubble.classList.add('-show'));
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('[data-bubble-toggle]')) {
                menus.forEach((bubble) => {
                    if(bubble.hasAttribute('data-bubble-toggle')) {
                        bubble.classList.remove('-active');
                    }
                    bubble.classList.add('-show');
                });
            }
        });
    }

    function attachEventListeners(menu, toggle, links) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('-active');
            updateMenuStatus(menu, links);
        });

        document.addEventListener('keydown', event => {
            if ((event.key === 'Enter' || event.key === ' ') && document.activeElement === toggle) {
                menu.classList.toggle('-active');
                updateMenuStatus(menu, links);
                event.preventDefault();
            }
        });
    }
};

BubbleMenu();
