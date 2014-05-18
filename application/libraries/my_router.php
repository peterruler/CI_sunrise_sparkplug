<?php
 if (! defined('BASEPATH')) exit('No direct script access allowed');
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 14.05.14
 * Time: 06:48
 * project: https_docs
 * file: my_router.php
 */

class MY_Router extends CI_Router {
    var $suffix = 'Controller';

    function __construct() {
        parent::CI_Router();
    }

    function set_class($class) {
        $this->class = $class . $this->suffix;
    }

    function controller_name() {

        if (strstr($this->class, $this->suffix)) {
            return str_replace($this->suffix, '', $this->class);
        }
        else {
            return $this->class;
        }

    }
}