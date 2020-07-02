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
/***/
/***/
/***/
/**
 * Go to Shell.php to set custom settings and routing setup.
 */
namespace Sporozoa;

class Kernel
{

    private $wp = false;
    private $userdata = 'userdata';
    private $layout = 'example_layout';
    private $layout_file = 'layout.php';
    private $models = 'models';
    private $views = 'views';
    private $controllers = 'controllers';
    private $pnf404 = '404.php';
    private $dir = __DIR__;
    private $url = false;
    private $request_uri = null;
    private $settings_set = false;

    public function __construct()
    {

        if (strpos($_SERVER['REQUEST_URI'], '?') !== false) $uri = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
        else $uri = $_SERVER['REQUEST_URI'];
        
        if ($uri === '/') $this->request_uri = 'index';
        else $this->request_uri = trim($uri, '/');

        $this->url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];

    }

    public function set_settings(array $settings)
    {

        if ($this->settings_set) $result = false;
        else {

            if (isset($settings['wp_directory']) &&
                isset($settings['userdata_directory']) &&
                isset($settings['layout_directory']) &&
                isset($settings['layout_entrance']) &&
                isset($settings['models_directory']) &&
                isset($settings['views_directory']) &&
                isset($settings['controllers_directory']) &&
                isset($settings['page_404'])) {

                $this->wp = $settings['wp_directory'];
                $this->userdata = $settings['userdata_directory'];
                $this->layout = $settings['layout_directory'];
                $this->layout_file = $settings['layout_entrance'];
                $this->models = $settings['models_directory'];
                $this->views = $settings['views_directory'];
                $this->controllers = $settings['controllers_directory'];
                $this->pnf404 = $settings['page_404'];

                $this->settings_set = true;
                $result = true;

            } else $result = false;

        }

        return $result;

    }

    public function get_settings()
    {

        if ($this->settings_set) {

            $result = [
                'wp_directory' => $this->wp,
                'userdata_directory' => $this->userdata,
                'layout_directory' => $this->layout,
                'layout_entrance' => $this->layout_file,
                'models_directory' => $this->models,
                'views_directory' => $this->views,
                'controllers_directory' => $this->controllers,
                'page_404' => $this->pnf404,
                'root_directory' => $this->dir,
                'app_url' => $this->url,
                'requested_uri' => $this->request_uri
            ];

            $result['layout_boot'] = $result['root_directory'].'\\'.$result['userdata_directory'].'\\'.$result['layout_directory'].'\\'.$result['layout_entrance'];

        } else $result = false;

        return $result;

    }

    public function wp_directory()
    {

        if ($this->settings_set) return $this->wp;
        else return false;

    }

    public function userdata_directory()
    {

        if ($this->settings_set) return $this->userdata;
        else return false;

    }

    public function layout_directory()
    {

        if ($this->settings_set) return $this->layout;
        else return false;

    }

    public function layout_entrance()
    {

        if ($this->settings_set) return $this->layout_entrance;
        else return false;

    }

    public function models_directory()
    {

        if ($this->settings_set) return $this->models;
        else return false;

    }

    public function views_directory()
    {

        if ($this->settings_set) return $this->views;
        else return false;

    }

    public function controllers_directory()
    {

        if ($this->settings_set) return $this->controllers;
        else return false;

    }

    public function page_404()
    {

        if ($this->settings_set) return $this->pnf404;
        else return false;

    }

    public function root_directory()
    {

        return $this->dir;

    }

    public function app_url()
    {

        return $this->url;

    }

    public function requested_uri()
    {

        return $this->request_uri;

    }

    public function routing(array $route_details)
    {

        if (empty($route_details['view'])) {
            
            $route_details['view'] = $this->dir.'\\'.$this->userdata.'\\'.$this->views.'\\'.$this->pnf404;

            http_response_code(404);
        
        }
        else $route_details['view'] = $this->dir.'\\'.$this->userdata.'\\'.$this->views.'\\'.$route_details['view'];

        return $route_details;

    }

    public function htaccess_generate()
    {

        return "<IfModule mod_rewrite.c>\nRewriteEngine On\nRewriteBase /\nRewriteRule ^index\.php$ - [L]\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule .* /index.php [L]\n</IfModule>";

    }

    public function htaccess_wp_redirect(string $wp_dir)
    {

        return "\n\nRedirect 301 /".$wp_dir."/index.php /";

    }

}
