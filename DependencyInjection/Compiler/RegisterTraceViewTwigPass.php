<?php

/**
 * @file
 * Contains \AppNeta\TraceViewBundle\DependencyInjection\Compiler\RegisterTraceViewTwigPass.
 */

namespace AppNeta\TraceViewBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Register a TraceView-modified version of Twig.
 */
class RegisterTraceViewTwigPass implements CompilerPassInterface {

  /**
   * Adds services tagged 'twig.extension' to the Twig service container.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
   *   The container to process.
   */
  public function process(ContainerBuilder $container) {
    if (!$container->hasDefinition('twig')) {
      return;
    }

    $twig = $container->getDefinition('twig');

    // Modify the second argument, which is an array containing configuration.
    $twig_config = $twig->getArgument(1);
    $twig_config['base_template_class'] = 'AppNeta\TraceViewBundle\Template\TraceViewTwigTemplate';
    $twig->replaceArgument(1, $twig_config);
    return;
  }
}
