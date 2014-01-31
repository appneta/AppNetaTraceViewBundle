# v0.1.2
- Add an API stub so the bundle won't crash when php-oboe isn't present.
- Change the php-oboe requirement to a suggestion.
- Update oboe_log calls to use the most recent php-oboe (1.4.4) API.
- Don't collect data unless a request is being traced.
- Don't collect extraneous backtraces.
- Add `symfony/symfony` as a package requirement.
- Relicense as MIT.
- Improve the package description.
- Improve the README.

# v0.1.1
- Bug fix for mismatched layers.
- Match controller/action collection to the Symfony debug toolbar.
- Add support for kernel.finish_request in Symfony 2.4+.
- Remove deprecated Drupal 8 code.

# v0.1.0
Initial release.

- Trace event dispatching time.
- Trace Twig templating time.
- Report controller/action pairs.
