<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* User: ps
# copyright 2014 keepitnative.ch, io, all rights reserved to the author
* Date: 02.05.14
* Time: 20:33
* project: https_docs
* file: SparkPlugCtrl.php
* adaption to twitter bootstrap 3, html5 form elements and serverside validation and xss sanitize
*/

class SparkPlugCtrl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url','security'));
    }

    public function index() {
        redirect("Jobs/scaffolding");
    }

    private function getTable() {
        $url_string = xss_clean($this->uri->uri_string());
        $segments = explode("/", $url_string);
        $segments_length = count($segments);
        if($segments_length > 0) {
            try {
                $table = xss_clean($this->uri->segment(1));
                if($table != '' || !empty($table)) {
                    return $table;
                } else {
                    throw new \Exception("Controller in url not specified, please choose analog to view name, e.g http://domain.com/{controller-tablename}/scaffolding/{tablename}");

                }
            } catch (\Exception $e) {
                echo "<h3>An error occured!</h3><p>{$e->getMessage()}</p><p>".str_replace("\n","<br />", $e->getTraceAsString())."</p>";
            }
        } else {
            throw new \Exception("Controller in url not specified, please choose controller analog to view name, e.g http://domain.com/{controller-tablename}/scaffolding/{tablename}");
        }
    }
    public function scaffolding() {
        $table = $this->getTable();
        $this->load->library('SparkPlug',$table);
        //$this->sparkplug->scaffold();
        /* OR */
        $this->sparkplug->generate();
    }
}