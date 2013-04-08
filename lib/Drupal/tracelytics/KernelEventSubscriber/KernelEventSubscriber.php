<?php
/**
 * @file
 * Subscribe to HTTPKernel events in order to trace them.
 */

namespace Drupal\tracelytics\KernelEventSubscriber;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * TraceView HTTPKernel event subscriber.
 */
class KernelEventSubscriber implements EventSubscriberInterface {

  /**
   * Enter the KernelEvents::REQUEST profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The response event.
   */

  public function beforeRequest(GetResponseEvent $event) {
    // TODO: Collect more info here.
    oboe_log(($event->getRequestType() === HttpKernelInterface::MASTER_REQUEST) ? 'symfony.master_request' : 'symfony.sub_request', 'entry', array());

    oboe_log('profile_entry', array('ProfileName' => 'request'));
  }

  /**
   * Exit the KernelEvents::REQUEST profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The response event.
   */

  public function afterRequest(GetResponseEvent $event) {
    oboe_log('profile_exit', array('ProfileName' => 'request'));
  }

  /**
   * Enter the KernelEvents::VIEW profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent $event
   *   The view event.
   */

  public function beforeView(GetResponseForControllerResultEvent $event) {
    oboe_log('profile_entry', array('ProfileName' => 'view'));
  }

  /**
   * Exit the KernelEvents::VIEW profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent $event
   *   The view event.
   */

  public function afterView(GetResponseForControllerResultEvent $event) {
    oboe_log('profile_exit', array('ProfileName' => 'view'));
  }

  /**
   * Enter the KernelEvents::CONTROLLER profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
   *   The controller event.
   */

  public function beforeController(FilterControllerEvent $event) {
    oboe_log('profile_entry', array('ProfileName' => 'controller'));
  }

  /**
   * Exit the KernelEvents::CONTROLLER profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
   *   The controller event.
   */

  public function afterController(FilterControllerEvent $event) {
    oboe_log('profile_exit', array('ProfileName' => 'controller'));
  }

  /**
   * Enter the KernelEvents::RESPONSE profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The response event.
   */

  public function beforeResponse(FilterResponseEvent $event) {
    oboe_log('profile_entry', array('ProfileName' => 'response'));
  }

  /**
   * Exit the KernelEvents::RESPONSE profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The response event.
   */

  public function afterResponse(FilterResponseEvent $event) {
    oboe_log('profile_exit', array('ProfileName' => 'response'));

    // TODO: Collect more info here.
    oboe_log(($event->getRequestType() === HttpKernelInterface::MASTER_REQUEST) ? 'symfony.master_request' : 'symfony.sub_request', 'exit', array());
  }

  /**
   * Enter the KernelEvents::TERMINATE profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\PostResponseEvent $event
   *   The terminate event.
   */

  public function beforeTerminate(PostResponseEvent $event) {
    oboe_log('profile_entry', array('ProfileName' => 'terminate'));
  }

  /**
   * Exit the KernelEvents::TERMINATE profile.
   *
   * @param \Symfony\Component\HttpKernel\Event\PostResponseEvent $event
   *   The terminate event.
   */

  public function afterTerminate(PostResponseEvent $event) {
    oboe_log('profile_exit', array('ProfileName' => 'terminate'));
  }

  /**
   * Respond to a KernelEvents::EXCEPTION event.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
   *   The exception event.
   */

  public function onException(GetResponseForExceptionEvent $event) {
    oboe_log('info', array('ErrorClass' => FALSE, 'ErrorMsg' => FALSE));
  }

  /**
   * Implements EventSubscriberInterface::getSubscribedEvents().
   */
  static function getSubscribedEvents() {
    // Register before and after listeners for the primary kernel events.
    $events[KernelEvents::REQUEST][] = array('beforeRequest', 255);
    $events[KernelEvents::REQUEST][] = array('afterRequest', -255);
    $events[KernelEvents::VIEW][] = array('beforeView', 255);
    $events[KernelEvents::VIEW][] = array('afterView', -255);
    $events[KernelEvents::CONTROLLER][] = array('beforeController', 255);
    $events[KernelEvents::CONTROLLER][] = array('afterController', -255);
    $events[KernelEvents::RESPONSE][] = array('beforeResponse', 255);
    $events[KernelEvents::RESPONSE][] = array('afterResponse', -255);
    $events[KernelEvents::TERMINATE][] = array('beforeTerminate', 255);
    $events[KernelEvents::TERMINATE][] = array('afterTerminate', -255);
    // Exceptions are handled differently.
    $events[KernelEvents::EXCEPTION][] = array('onException', -255);
    return $events;
  }
}

