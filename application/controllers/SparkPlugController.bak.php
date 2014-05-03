<?php
 if (! defined('BASEPATH')) exit('No direct script access allowed');
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 02.05.14
 * Time: 21:35
 * project: https_docs
 * file: Scaffold_test.php
 * generate with:
 * https://myproject.01.proto.oauth.my/SparkPlugCtrl/scaffolding
 */

class SparkPlugCtrl extends CI_Controller {

    function index($table='users') {
        parent::__construct();
        //redirect("SparkPlugCtrl/scaffolding");
    }
    function scaffolding($table='users') {
        $this->load->library('SparkPlug','users');
        //$this->sparkplug->scaffold();
        /* OR */
        $this->sparkplug->generate();
    }
}