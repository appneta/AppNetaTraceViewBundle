<?php
/**
 * @file
 * Contains EventSubscriber.
 */

namespace Drupal\tracelytics\EventSubscriber;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Default TraceView event subscriber.
 */
class EventSubscriber implements EventSubscriberInterface {

  /**
   * Insert comment.
   *
   * @param \Drupal\rdf\MapTypesFromInputEvent $event
   *   The mapping event.
   */

  public function onRespond(FilterResponseEvent $event) {
    oboe_log('info', array('Event' => 'Event!~', 'ResponseType' => $event->getRequestType()));
  }

  /**
   * Implements EventSubscriberInterface::getSubscribedEvents().
   */
  static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = array('onRespond');
    return $events;
  }
}

