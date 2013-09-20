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
    if (!$container->hasDefinition('twig')) {
      return;
    }
    $twig = $container->getDefinition('twig');
    // Retrives the second argument, which is an array containing configuration.
    $twig_config = $twig->getArgument(1);
    $twig_config['base_template_class'] = 'Drupal\tracelytics\Template\TraceviewTwigTemplate';
    $twig->replaceArgument(1, $twig_config);
    return;
  }
}

