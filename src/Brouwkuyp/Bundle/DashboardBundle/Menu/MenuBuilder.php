<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

/**
 * MenuBuilder
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'nav-pills',
                'role' => 'tablist'
            ]
        ]);

        $menu->addChild('Recepten', ['route' => 'recipe_index']);
        $menu->addChild('Brouwsels', ['route' => 'batch_index']);

        return $menu;
    }
}
