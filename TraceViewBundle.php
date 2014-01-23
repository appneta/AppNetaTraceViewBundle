<?php

/**
 * @file
 * Contains TraceViewBundle.
 */

namespace AppNeta\TraceViewBundle;

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
    parent::build($container);
    // Currently a no-op, but here's where you'd add compiler passes.
    #$container->addCompilerPass(new CompilerPass());
  }
}

