<?php

/**
 * @file
 * Contains TraceViewBundle.
 */

namespace AppNeta\TraceViewBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use AppNeta\TraceViewBundle\DependencyInjection\Compiler\RegisterTraceViewTwigPass;

/**
 * TraceView dependency injection container.
 */
class TraceViewBundle extends Bundle {

  /**
   * Overrides Symfony\Component\HttpKernel\Bundle\Bundle::build().
   */
  public function build(ContainerBuilder $container) {
    // Add Twig template support to the container.
    parent::build($container);
    $container->addCompilerPass(new RegisterTraceViewTwigPass());
  }
}

