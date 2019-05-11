<?php

namespace PaulCartSave\Subscriber;

use Enlight\Event\SubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerPath implements SubscriberInterface
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
                        'Enlight_Controller_Dispatcher_ControllerPath_Frontend_PaulCartSave' => 'onGetControllerPathFrontend',        );
    }



    /**
     * Register the frontend controller
     *
     * @param   \Enlight_Event_EventArgs $args
     * @return  string
     * @Enlight\Event Enlight_Controller_Dispatcher_ControllerPath_Frontend_PaulCartSave     */
    public function onGetControllerPathFrontend(\Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Frontend/PaulCartSave.php';
    }
}
