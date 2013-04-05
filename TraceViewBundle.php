<?php

/**
 * @file
 * Contains TracelyticsBundle.
 */

namespace Drupal\tracelytics;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * TraceView dependency injection container.
 */
class TracelyticsBundle extends Bundle {

  /**
   * Overrides Symfony\Component\HttpKernel\Bundle\Bundle::build().
   */
  public function build(ContainerBuilder $container) {
    // Event subscriber.
    $container->register('kernel.response', 'Drupal\tracelytics\EventSubscriber\EventSubscriber')
      ->addTag('event_subscriber');
  }
}

