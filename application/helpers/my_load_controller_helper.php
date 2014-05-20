<?php
 if (! defined('BASEPATH')) exit('No direct script access allowed');
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 17.05.14
 * Time: 19:32
 * project: https_docs
 * file: load_controller_helper.php
  * http://stackoverflow.com/questions/6091100/codeigniter-load-controller-within-controller
 */

if (!function_exists('load_controller'))
{
    function load_controller($controller, $method = 'index')
    {
        require_once(FCPATH . APPPATH . 'controllers/' . $controller . '.php');

        $controller = new $controller();

        return $controller->$method();
    }
}