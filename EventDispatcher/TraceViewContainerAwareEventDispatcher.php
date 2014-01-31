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
        // Store whether this event had any listeners when dispatch started. This
        // prevents broken traces as a result of adding/removing listeners.
        $had_listeners = $this->hasListeners($eventName);

        // Check whether this is a kernel request, response, or terminate.
        $is_request = ($eventName === "kernel.request");
        $is_response = ($eventName === "kernel.response");
        $is_terminate = ($eventName === "kernel.terminate");

        // If this event is being listened to, report a layer or profile entry.
        if ($had_listeners) {
            // On the start of a kernel request or terminate, enter a layer.
            if ($is_request) {
                oboe_log(($event->getRequestType() === HttpKernelInterface::MASTER_REQUEST) ? 'HttpKernel.master_request' : 'HttpKernel.sub_request', "entry", array(), TRUE);
            } elseif ($is_terminate) {
                oboe_log("HttpKernel.terminate", "entry", array(), TRUE);
            }
            // Otherwise, enter a profile (unless this is a response).
            elseif (!$is_response)  {
                oboe_log("profile_entry", array('ProfileName' => $eventName), TRUE);
            }
        }

        // Dispatch the event as normal.
        $ret = parent::dispatch($eventName, $event);

        // If the event is a kernel controller, report controller/action information.
        if ($eventName === "kernel.controller") {
            $event_controller = $ret->getController();

            // We use the same logic as the Symfony debug toolbar to parse out controller/action.
            if (is_array($event_controller)) {
                $controller = $event_controller[0];
                $action = $event_controller[1];
            } elseif ($controller instanceof \Closure) {
                $r = new \ReflectionFunction($event_controller);
                $controller = $r->getName();
                $action = NULL;
            } else {
                $controller = (string) $event_controller ?: NULL;
                $action = NULL;
            }

            // Report the C/A pair.
            oboe_log('info', array("Controller" => (is_object($controller)) ? get_class($controller) : $controller, "Action" => (is_object($action)) ? get_class($action) : $action));
        }

        // If this event was being listened to, report a layer or profile exit.
        if ($had_listeners) {
            // On the end of a kernel response or terminate, exit a layer.
            if ($is_response) {
                oboe_log(($event->getRequestType() === HttpKernelInterface::MASTER_REQUEST) ? 'HttpKernel.master_request' : 'HttpKernel.sub_request', "exit", array());
            } elseif ($is_terminate) {
                oboe_log('HttpKernel.terminate', "exit", array());
            // Otherwise, exit a profile (unless this is a request).
            } elseif (!$is_request) {
                oboe_log("profile_exit", array('ProfileName' => $eventName));
            }
        }

        return $ret;
    }
}
