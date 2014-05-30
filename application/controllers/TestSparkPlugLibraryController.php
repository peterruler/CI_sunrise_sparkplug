<?php
 if (! defined('BASEPATH')) exit('No direct script access allowed');
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 30.05.14
 * Time: 11:50
 * project: https_docs
 * file: TestSparkPlugLibraryController.php
 */

class TestSparkPlugLibraryController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function setUp() {
        //require_once ('SparkPlugController.php');
        //$sparkplug_ctrl = new SparkPlugController();
        //$sparkplug_ctrl->generateController($this->table);
    }

    public function tearDown() {

    }
} 