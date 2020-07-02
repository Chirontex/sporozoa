# Sporozoa

Sporozoa is an extremely micro MVC-framework which you can use with WordPress. It is simple as possible.

**Actual version: 0.3**

## Requirements
PHP 7.0+

## How to start
1. Copy Sporozoa files to the root directory of your site.
2. Open Shell.php and customize it or just read the comments.
3. Open userdata\example-layout\layout.php and take a look. I'm sure you will quickly figure out how it works.

## Just several reminders
1. You can use __$sporozoa_settings['app_url']__ or __$sporozoa_kernel->app_url()__ to get the full URL of your site. Also, you can use __$sporozoa_settings['root_directory']__ or __$sporozoa_kernel->root_directory()__ to get the full path to the root directory of your site, and __$sporozoa_settings['requested_uri']__ or __$sporozoa_kernel->requested_uri()__ to get the URI from user's request.
2. Besides, you can get any setting from __$sporozoa_settings__ or __$sporozoa_kernel__ previously declared in Shell.php in a similar way.
3. __$routing_data['view']__ contains full path to view file.