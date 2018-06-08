=== Simple DNS Prefetch ===
Contributors: andrewmoof
Tags: dns, dns-prefetch, prefetch, optimization, speed
Requires at least: 4.1
Tested up to: 4.9.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds (or removes) DNS prefetching meta tags to your site and speeds up your page load speed.

== Description ==

DNS resolution time can lead to a significant amount of user perceived latency. The time that DNS resolution takes is highly variable.  Latency delays range from around 1ms (locally cached results) to commonly reported times of several seconds.

DNS prefetching is an attempt to resolve domain names before a user tries to follow a link. This is done using the computer's normal DNS resolution mechanism. Once a domain name has been resolved, if the user does navigate to that domain, there will be no effective delay due to DNS resolution time. When we encounter hyperlinks in pages, we extract the domain name from each one and resolving each domain to an IP address.  All this work is done in parallel with the user's reading of the page, using minimal CPU and network resources.  When a user clicks on any of these pre-resolved names, they will on average save about 200 milliseconds in their navigation (assuming the user hadn't already visited the domain recently). More importantly than the average savings, users won't tend to experience the "worst case" delays for DNS resolution, which are regularly over 1 second.

== Installation ==

1. Upload plugin file through the WordPress interface.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use the Settings->Simple DNS Prefetch screen to configure the plugin.

== Frequently Asked Questions ==

= How do I use the plugin? =

Go to Settings &raquo; Simple DNS Prefetch and enter any domains you want to be prefetched. Make sure the "Disable" checkbox is unchecked.

== Screenshots ==

1. Settings.
2. Page source.

== Changelog ==

= 0.5.2 =
- PHP Warning fix

= 0.5.1 =
- PHP Warning fix

= 0.5.0 =
- added "X-DNS-Prefetch-Control" meta-tag control

= 0.4.2 =
- code fix

= 0.4.1 =
- confirmed compatibility with WordPres 4.1

= 0.4.0 =
- minor code optimizations

= 0.3.0 =
- code fix

= 0.2.1 = 
- code fix 

= 0.2.0 = 
- minor code optimizations, changed load behavior

= 0.0.1 =
- created
- verified compatibility with WP 4.0

