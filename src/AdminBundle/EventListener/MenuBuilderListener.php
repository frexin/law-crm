<?php

namespace AdminBundle\EventListener;

use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;
use Sonata\AdminBundle\Event\ConfigureMenuEvent;

class MenuBuilderListener
{
    public function addMenuItems(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->setChildrenAttributes(['class' => 'nav side-menu']);

        $firstItem = new MenuItem('main', new MenuFactory());
        $firstItem->setChildrenAttribute('href', '/');
        $firstItem->setLabel('Main');
        $firstItem->setUri('/dashboard');
        $firstItem->setExtra('icon', '<i class="fa fa-home"></i>');

        $menu->addChild($firstItem);
        //$menu->reorderChildren(['main', 'Персонал', 'Магазины', 'Каталог', 'Покупатели', 'Продажи', 'Розничные Сети', 'Баннеры', 'Сообщения', 'Награды', 'Дополнительно']);
        $menu->reorderChildren(['main', 'Personal', 'Shops', 'Catalog', 'Clients', 'Sales', /*'Retail Networks',*/ 'Banners', 'Messages', 'Rewards', 'Additionally']);

        $icons = ['home', 'male', 'shopping-bag', 'cart-plus', 'user', 'first-order', /*'list',*/ 'list', 'list', 'list', 'folder'];
        $counter = 0;

        foreach ($menu->getChildren() as &$item) {
            $icon = $icons[$counter];
            $item->setExtra('icon', '<i class="fa fa-' . $icon . '"></i>');

            if ($item->hasChildren()) {
                $item->setChildrenAttributes(['class' => 'nav child_menu']);
            }

            $counter++;
        }
    }
}