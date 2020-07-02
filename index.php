<?php
/**
 * Sporozoa v0.3
 * Author: Dmitry Shumilin
 * 
 * Copyright (C) 2020  Dmitry Shumilin (dmitri.shumilinn@yandex.ru)
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
/***/
/***/
/***/
/**
 * Go to Shell.php to set custom settings and routing setup.
 */
use Sporozoa\Kernel;
use Sporozoa\Shell;

require_once __DIR__.'\\Kernel.php';
require_once __DIR__.'\\Shell.php';

$sporozoa_kernel = new Kernel;
$sporozoa_shell = new Shell;

$sporozoa_settings = $sporozoa_kernel->set_settings($sporozoa_shell->declare_settings());

if ($sporozoa_settings) $sporozoa_settings = $sporozoa_kernel->get_settings();
else die('Sporozoa error: bad settings!');

$htaccess_generate = $sporozoa_kernel->htaccess_generate();

if (file_exists($sporozoa_settings['root_directory'].'\\.htaccess')) $htaccess_exists = file_get_contents($sporozoa_settings['root_directory'].'\\.htaccess');
else $htaccess_exists = false;

if ($htaccess_exists) {

    if (strpos($htaccess_exists, $htaccess_generate) === false) file_put_contents($sporozoa_settings['root_directory'].'\\.htaccess', $htaccess_exists."\n\n".$htaccess_generate);

} else file_put_contents($sporozoa_settings['root_directory'].'\\.htaccess', $htaccess_generate);

$htaccess_exists = file_get_contents($sporozoa_settings['root_directory'].'\\.htaccess');

if ($sporozoa_settings['wp_directory']) {

    if (file_exists($sporozoa_settings['root_directory'].'\\'.$sporozoa_settings['wp_directory'].'\\wp-load.php')) {

        require_once $sporozoa_settings['root_directory'].'\\'.$sporozoa_settings['wp_directory'].'\\wp-load.php';

        $htaccess_wp_hide = $sporozoa_kernel->htaccess_wp_redirect($sporozoa_settings['wp_directory']);

        if (strpos($htaccess_exists, $htaccess_wp_hide) === false) {
            
            file_put_contents($sporozoa_settings['root_directory'].'\\.htaccess', $htaccess_exists.$htaccess_wp_hide);

            $htaccess_exists = file_get_contents($sporozoa_settings['root_directory'].'\\.htaccess');
        
        }

    } else die('Sporozoa error: WordPress core not found!');

}

$routing_data = $sporozoa_kernel->routing($sporozoa_shell->routes($sporozoa_settings['requested_uri']));

/**
 * Custom code should be located here if needed.
 */

if (file_exists($sporozoa_settings['layout_boot'])) require_once $sporozoa_settings['layout_boot'];
else {

    if ($sporozoa_settings['wp_directory']) wp_die('Layout entrance not found!', 'Sporozoa error');
    else die('Sporozoa error: layout entrance not found!');

}
