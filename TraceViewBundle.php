<?php

/**
 * @file
 * Contains TraceViewBundle.
 */

namespace AppNeta\TraceView;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * TraceView dependency injection container.
 */
class TraceViewBundle extends Bundle {

  /**
   * Overrides Symfony\Component\HttpKernel\Bundle\Bundle::build().
   */
  public function build(ContainerBuilder $container) {
    // Event subscriber.
    $container->register('kernel.response', 'AppNeta\TraceView\KernelEventSubscriber\KernelEventSubscriber')
      ->addTag('event_subscriber');
  }
}

