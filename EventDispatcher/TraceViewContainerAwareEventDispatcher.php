<?php

/*
 * Replace the standard Symfony EventDispatcher with one that reports data to TraceView.
 */

namespace AppNeta\TraceViewBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Evaluate dependency injection container events, wrapped in TraceView events.
 */
class TraceViewContainerAwareEventDispatcher extends ContainerAwareEventDispatcher
{
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
