<?php

/**
 * @file
 * Contains \Drupal\traceview\TraceviewServiceProvider.
 */

namespace Drupal\traceview;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Drupal\traceview\DependencyInjection\Compiler\RegisterTraceViewTwigPass;
/**
 * TraceView dependency injection container.
 */
class TraceviewServiceProvider implements ServiceProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    // Add a compiler pass to replace the default Twig template with a TraceView version.
    $container->addCompilerPass(new RegisterTraceViewTwigPass());
  }
}
