<?php
 if (! defined('BASEPATH')) exit('No direct script access allowed');
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 02.05.14
 * Time: 20:33
 * project: https_docs
 * file: SparkPlug.php
 * adaption to twitter bootstrap 3, html5 form elements and serverside validation and xss sanitize
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