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

    public $default_table = "users";
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url','security'));
    }

    public function index() {
        redirect("SparkPlugCtrl/scaffolding");
    }

    private function getTable() {

        $url_string = xss_clean($this->uri->uri_string());
        $segments = explode("/", $url_string);
        $segments_length = count($segments);
        if($segments_length > 0) {
            try {
                $table = xss_clean($this->uri->segment(1));
                if (!$this->CI->db->table_exists($table)) {
                    return $this->detault_table;
                }
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
        return $table;
    }
    public function scaffolding() {
        $table = $this->getTable();
        $this->load->library('SparkPlug',$table);
        //$this->sparkplug->scaffold();
        /* OR */
        $this->sparkplug->generate();
    }
}