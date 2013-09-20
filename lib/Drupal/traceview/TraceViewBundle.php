<?php

/**
 * @file
 * Contains TraceViewBundle.
 */

namespace Drupal\traceview;

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
    if (!$container->hasDefinition('twig')) {
      return;
    }
    $twig = $container->getDefinition('twig');
    // Retrives the second argument, which is an array containing configuration.
    $twig_config = $twig->getArgument(1);
    $twig_config['base_template_class'] = 'Drupal\traceview\Template\TraceViewTwigTemplate';
    $twig->replaceArgument(1, $twig_config);
    return;
  }
}

