<?php

class SparkPlugCtrl extends CI_Controller
{

    function index()
    {
        $this->load->database();
        $db = array();
        include(APPPATH . 'config/database' . EXT);
        $dbname = $db['default']['database'];

        $sql = "SHOW TABLES FROM $dbname";
        $query = $this->db->query($sql);
        $data['tables'] = $query->result();
        $this->load->view('header');
        $this->load->view('SparkPlugCtrl', $data);
        $this->load->view('footer');
    }

    function generateController($table)
    {
        $this->load->helper('file');
        $data = '<?php
if (!defined("BASEPATH")) exit("No direct script access allowed");

/*
* User: ps
# copyright 2014 keepitnative.ch, io, all rights reserved to the author
* Date: ' . date("d.m.Y") . '
* Time: ' . date("H:m") . '
* project: https_docs
* version 0.0.3
* file: ' . $table . '.php
* adaption to twitter bootstrap 3, html5 form elements and serverside validation and xss sanitize
*/

class '.ucfirst($table).' extends CI_Controller {

    var $CI; // CI Super Object
    public $default_table =  null;
    public function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->load->helper(array("url","security"));
        $this->default_table = "' . $table . '";
    }

    public function index() {
        redirect("' . $table . '/scaffolding");
    }

    private function getTable() {

        $url_string = xss_clean($this->uri->uri_string());
        $segments = explode("/", $url_string);
        $segments_length = count($segments);
        if($segments_length > 0) {
            try {
                $table = xss_clean($this->uri->segment(1));
                if (! $this->CI->db->table_exists($table)) {
                    return $this->default_table;
                }
                if($table != "" || !empty($table)) {
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
        return $table;
    }
    public function scaffolding() {
    $table = $this->getTable();
    $this->load->library("SparkPlug",$table);
    //$this->sparkplug->scaffold();
    /* OR */
    $this->sparkplug->generate();
}
}';
        if ( ! write_file(preg_replace('/system\//','',BASEPATH.APPPATH.'controllers/'.$table.'.php'), $data))
        {
            echo "Unable to write the file";
        }
        else
        {
            redirect("/".$table."/scaffolding/".$table);
            echo "File written!";
        }
    }
}
