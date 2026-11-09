=== WP Maximum Execution Time Exceeded — Afterware ===
Contributors: Johnnie2u, afterware
Requires at least: 6.8.3
Tested up to: 7.1.4
Requires PHP: 8.3.28
Stable tag: 1.0.3.1
License: GPLv2
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html

Requests a longer PHP execution time where your hosting provider permits it.

== Description ==

This independent Afterware fork is based on the original plugin by Johnnie J. O'Dell Jr. It asks PHP for a five-minute execution limit when the current limit is shorter. It leaves higher and unlimited PHP limits unchanged.

Your hosting provider, web server or proxy can impose a shorter limit that this plugin cannot change. If a timeout continues, ask your hosting provider which limit applies.

For compatibility with the original plugin, activation also adds the original Apache mod_php5 directive to .htaccess where the file is writable. Deactivation removes that directive. The directive has no effect on modern PHP-FPM configurations. Back up your site and .htaccess before installing or changing plugins.

== Installation ==

Install the Afterware build in place of the original plugin and activate it. Confirm your hosting configuration permits runtime changes to PHP's execution limit.

== Changelog ==

= 1.0.3.1 =
* Independent Afterware fork; retains original author credit.
* Fix configuration handling during activation and deactivation.
* Request a longer PHP execution time on supported modern hosting without shortening existing limits.
