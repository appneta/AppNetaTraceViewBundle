<?php

/**
 * @file
 * Definition of AppNeta\TraceViewBundle\Template\TraceViewTwigTemplate.
 */

namespace AppNeta\TraceViewBundle\Template;

/**
 * This is the base class for compiled Twig templates.
 */
abstract class TraceViewTwigTemplate extends \Twig_Template {
    /**
     * {@inheritdoc}
     */
    public function display(array $context, array $blocks = array())
    {
        oboe_log(NULL, "profile_entry", array('ProfileName' => $this->getTemplateName()), TRUE);
        parent::display($context, $blocks);
        oboe_log(NULL, "profile_exit", array('ProfileName' => $this->getTemplateName()), FALSE);
    }
}
