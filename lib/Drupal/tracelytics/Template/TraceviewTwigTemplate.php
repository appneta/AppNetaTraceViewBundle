<?php

/**
 * @file
 * Definition of Drupal\tracelytics\Template\TraceviewTwigTemplate.
 */

namespace Drupal\tracelytics\Template;

use Drupal\Core\Template\TwigTemplate;

/**
 * This is the base class for compiled Twig templates.
 */
abstract class TraceviewTwigTemplate extends TwigTemplate {
    /**
     * {@inheritdoc}
     */
    public function display(array $context, array $blocks = array())
    {
        oboe_log("profile_entry", array('ProfileName' => $this->getTemplateName()), TRUE);
        $this->displayWithErrorHandling($this->env->mergeGlobals($context), $blocks);
        oboe_log("profile_exit", array('ProfileName' => $this->getTemplateName()));
    }
}
