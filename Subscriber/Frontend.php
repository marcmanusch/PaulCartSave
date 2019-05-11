<?php

namespace PaulCartSave\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Template_Manager;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Frontend implements SubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendPostDispatch'
        );
    }

    public function onFrontendPostDispatch(\Enlight_Event_EventArgs $args)
    {
        $this->container->get('template')->addTemplateDir(__DIR__ . '/../Resources/views/');

        /** @var $controller \Enlight_Controller_Action */
        $controller = $args->getSubject();
        $view = $controller->View();

        $config = $this->container->get('shopware.plugin.config_reader')->getByPluginName('PaulCartSave');
        $active_cart_save = $config['active_cart_save'];

        $view->active_cart_save = $active_cart_save;

    }
}
