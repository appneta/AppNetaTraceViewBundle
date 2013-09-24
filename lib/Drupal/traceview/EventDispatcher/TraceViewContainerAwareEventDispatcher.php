<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drupal\traceview\EventDispatcher;

use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\HttpKernelInterface;
/**
 * Lazily loads listeners and subscribers from the dependency injection
 * container
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bernhard Schussek <bschussek@gmail.com>
 * @author Jordan Alliot <jordan.alliot@gmail.com>
 */
class TraceViewContainerAwareEventDispatcher extends ContainerAwareEventDispatcher
{

    /**
     * {@inheritDoc}
     *
     * Lazily loads listeners for this event from the dependency injection
     * container.
     *
     * @throws \InvalidArgumentException if the service is not defined
     */
    public function dispatch($eventName, Event $event = null)
    {

        // Check whether this is a kernel request, response, or terminate.
        $is_request = ($eventName === "kernel.request");
        $is_response = ($eventName === "kernel.response");
        $is_terminate = ($eventName === "kernel.terminate");

        // On the start of a kernel request or terminate, enter a layer.
        if ($is_request) {
            oboe_log(($event->getRequestType() === HttpKernelInterface::MASTER_REQUEST) ? 'HttpKernel.master_request' : 'HttpKernel.sub_request', "entry", array(), TRUE);
        } elseif ($is_terminate) {
            oboe_log("HttpKernel.terminate", "entry", array(), TRUE);
        }
        // Enter a profile if the event has any listeners.
        elseif ($this->hasListeners($eventName)) {
            oboe_log("profile_entry", array('ProfileName' => $eventName), TRUE);
        }

        // Dispatch the event as normal.
        $ret = parent::dispatch($eventName, $event);

        // Capture controller/action information.
        if ($eventName === "kernel.controller") {
            $event_controller = $ret->getController();

            // Handle the closure case, as per LegacyControllerSubscriber.
            if (is_callable($event_controller) && is_object($event_controller)) {
                $router_item = $event->getRequest()->attributes->get('drupal_menu_item');
                $controller = $router_item['page_callback'];
                $action = (isset($router_item['page_arguments'][0])) ? $router_item['page_arguments'][0] : NULL;
            // Default to the object-based case.
            } else {
                $controller = $event_controller[0];
                $action = $event_controller[1];
            }
            // Report the C/A pair.
            oboe_log('info', array("Controller" => (is_object($controller)) ? get_class($controller) : $controller, "Action" => (is_object($action)) ? get_class($action) : $action));
        }

        // Exit the profile if the event has any listeners.
        if ($this->hasListeners($eventName)) {
            oboe_log("profile_exit", array('ProfileName' => $eventName));
        }

        // On the end of a kernel response or terminate, exit the layer.
        if ($is_response) {
            oboe_log(($event->getRequestType() === HttpKernelInterface::MASTER_REQUEST) ? 'HttpKernel.master_request' : 'HttpKernel.sub_request', "exit", array());
        } elseif ($is_terminate) {
            oboe_log('HttpKernel.terminate', "exit", array());
        }

        return $ret;
    }
}
