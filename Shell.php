<?php
/**
 * Sporozoa
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
namespace Sporozoa;

class Shell
{
    /**
     * This method is used to declare user settings.
     * These settings can be obtained through an array $sporozoa_settings (the names of the keys are the same) 
     * or object $sporozoa_kernel methods (the names of the methods are identical to the names of the keys).
     * 
     * If you want to add additional settings, you must write a separate method 
     * (you can access it through the object $sporozoa_shell) and processing script for them.
     */
    public function declare_settings()
    {
        /**
         * Name of the WordPress folder, if used. Leave the false value, if not.
         */
        $settings['wp_directory'] = false;

        /**
         * Name of the custom code files folder, necessarily.
         */
        $settings['userdata_directory'] = 'userdata';

        /**
         * Names of layout folder and entrance point file. Layout folder should be located in the user data folder,
         * and the entrance point file should be located in the layout folder. Necessarily.
         */
        $settings['layout_directory'] = 'example_layout';
        $settings['layout_entrance'] = 'layout.php';

        /** 
         * Names of the models, views and controllers folders. Necessarily too.
         */
        $settings['models_directory'] = 'models';
        $settings['views_directory'] = 'views';
        $settings['controllers_directory'] = 'controllers';

        /**
         * Name of the view file with custom 404 error page. This file should be located in the views folder. Certainly necessary.
         */
        $settings['page_404'] = '404.php';

        return $settings;

    }
    /**
     * This method sets the data for routing. You can add your own routes by adding custom cases.
     * Also, you can add additional dynamic page elements by adding elements to the array $result.
     * 
     * The 'view' element is required in the $result and must contain the actual name of the file, which located in the views folder.
     */
    public function routes($uri)
    {

        switch ($uri) {
            /**
             * The main page case.
             */
            case 'index':
                $result = [
                    'title' => 'This is Sporozoa!',
                    'view' => 'main.php'
                ];
                break;
            
            /**
             * This is the 404 error page case. Leave the 'view' empty (so that the result of processing this value
             * by the empty() will be true).
             */
            default:
                $result = [
                    'title' => 'Sporozoa — Page not found',
                    'view' => null
                ];
                break;
        }

        return $result;

    }

}
