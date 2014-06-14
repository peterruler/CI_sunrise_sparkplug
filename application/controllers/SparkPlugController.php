<?php

class SparkPlugController extends CI_Controller
{
    private $uc_first_nosufix = "";
    function index()
    {
        $this->load->database();
        $db = array();
        include(APPPATH . 'config/database' . EXT);
        $dbname = $db['mysqli']['database'];

        $sql = "SHOW TABLES FROM $dbname";
        $query = $this->db->query($sql);
        $data['tables'] = $query->result();
        $data['crud_html'] = $this->load->view('SparkPlugView', $data, true);
        $this->load->view('base_template',$data);
    }

    function generateController($table)
    {
        $uc_first_ctrl = ucfirst($table).'Controller';
        $this->uc_first_nosufix = ucfirst($table);
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

class '.$uc_first_ctrl.' extends CI_Controller {

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
        $table = xss_clean($this->uri->segment(3));
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
        if ( ! write_file(preg_replace('/system\//','',BASEPATH.APPPATH.'controllers/'.$uc_first_ctrl.'.php'), $data))
        {
            echo "Unable to write the file";
        }
        else
        {
            redirect("/".$this->uc_first_nosufix."/scaffolding/".$table);
            echo "File written!";
        }
    }
}
