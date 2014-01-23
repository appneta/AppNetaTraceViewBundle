TraceViewBundle
=======

The `AppNeta\TraceViewBundle` bundle provides additional information about Symfony2 components to AppNeta TraceView. It can currently support:

- Reporting a controller and action
- Tracking kernel events as layers
- Tracking other event listeners as profiles
- Tracking Twig template rendering as profiles

# Installing

First, you'll need to pull in the `TraceViewBundle` as one of your app's
dependencies using [Composer](https://getcomposer.org/). In your `composer.json`
file, modify the `"require"` section to include the bundle:
```
    "require": {
        "php": ">=5.3.3",
        "symfony/symfony": "~2.4",
        "doctrine/orm": "~2.2,>=2.2.3",
        "doctrine/doctrine-bundle": "~1.2",
        "twig/extensions": "~1.0",
        [...]
        "appneta/traceview-bundle": "master@dev" # Or whatever version you prefer.
        [...]
    },
```

If installing directly from GitHub, rather than from Packagist, you can add the
extra repository to your `composer.json` in a top-level key of `repositories`
structured like so:
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/appneta/AppNetaTraceViewBundle"
    }
]
```

After using Composer to pull in the bundle, you'll need to make it available to
your app. Add it to `app/AppKernel.php`, looking something like this:
```
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            [...]
            new AppNeta\TraceViewBundle\TraceViewBundle(),
            [...]
        );

        return $bundles;
    }
```

To enable controller/action and event listener tracking, modify your `config.yml` as follows:
```
services:
  event_dispatcher:
    class: AppNeta\TraceViewBundle\EventDispatcher\TraceViewContainerAwareEventDispatcher
    arguments: ['@service_container']
```

To enable Twig template tracking, modify your `config.yml` like so:
```
twig:
    base_template_class: AppNeta\TraceViewBundle\Template\TraceViewTwigTemplate
```

# Known issues

- Friendlier controller/action name, perhaps using the same codebase as the Symfony debug toolbar
- Event dispatcher replacement currently conflicts with the Symfony debug toolbar
- User-configurable settings for which events to whitelist/blacklist for tracking

# Contributing

The best way to improve this bundle is to work with the people using it! We
actively encourage patches, pull requests, feature requests, and bug reports.
Current goals include Symfony developer toolbar integration and performance or
architectural improvements where possible.

This bundle is distributed with the AppNeta license; check out `Resources/meta/LICENSE` for the terms.
