<?php
namespace Redstar\SkeletonAppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder extends ContainerAware
{
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Dashboard', array('route' => 'redstar_skeleton_app_homepage'));
        $menu->addChild('Usermanagement', array('route' => 'redstar_user_homepage'));

        return $menu;
    }
}