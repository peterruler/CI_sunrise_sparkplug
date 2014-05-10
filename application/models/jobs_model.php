<?php
 if (! defined('BASEPATH')) exit('No direct script access allowed');
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 02.05.14
 * Time: 20:33
 * project: sparkplug
 * file: application/models/{ucf_controller}.php
 * adaption to twitter bootstrap 3, html5 form elements, serverside validation and xss sanitize
 */

class Jobs_model extends CI_Model {
    public $id	= '';
    public $name	= '';
    public $contact_person	= '';
    public $startdate	= '';
    public $enddate	= '';
    public $notes	= '';
    public $phone	= '';
    public $email	= '';

    public function Jobs_model() {
        parent::__construct();
        $this->load->helper(array("security"));
        $this->load->library(array("encrypt"));
    }

    public function getPrimaryKeyFieldName() {
     $fields = $this->db->field_data("jobs");

        $primary_key_name = $fields[0]->name;
        return $primary_key_name;
    }

    public function insert() {
        $this->id	= xss_clean($this->input->post('id',TRUE));
        $this->name	= xss_clean($this->input->post('name',TRUE));
        $this->contact_person	= xss_clean($this->input->post('contact_person',TRUE));
        $this->startdate	= xss_clean($this->input->post('startdate',TRUE));
        $this->enddate	= xss_clean($this->input->post('enddate',TRUE));
        $this->notes	= xss_clean($this->input->post('notes',TRUE));
        $this->phone	= xss_clean($this->input->post('phone',TRUE));
        $this->email	= xss_clean($this->input->post('email',TRUE));

        $this->db->insert('jobs', $this);
    }

    public function get($id) {
        $id = (int) $id;
        $primary_key = $this->getPrimaryKeyFieldName();

        $query = $this->db->get_where('jobs', array("$primary_key" => (int) xss_clean($id)));
        return $query->result_array();
    }

    public function get_all($table="jobs", $limit_per_page=10, $offset_limit=1 ) {
        $this->db->limit($limit_per_page, $offset_limit);
        $query = $this->db->get('jobs');
        return $query->result_array();
    }

    public function get_field_data() {
        return $this->db->field_data('jobs');
    }

    public function update($id) {
        $this->id	= xss_clean($this->input->post('id',TRUE));
        $this->name	= xss_clean($this->input->post('name',TRUE));
        $this->contact_person	= xss_clean($this->input->post('contact_person',TRUE));
        $this->startdate	= xss_clean($this->input->post('startdate',TRUE));
        $this->enddate	= xss_clean($this->input->post('enddate',TRUE));
        $this->notes	= xss_clean($this->input->post('notes',TRUE));
        $this->phone	= xss_clean($this->input->post('phone',TRUE));
        $this->email	= xss_clean($this->input->post('email',TRUE));

        $primary_key = $this->getPrimaryKeyFieldName();

        $this->db->set($this);
        $this->db->where( "$primary_key" ,$id);//@FIMXE sec? $this->$primary_key
        $this->db->update('jobs', $this);
    }

    public function delete($id) {
        $id = (int) $id;
        $primary_key = $this->getPrimaryKeyFieldName();
        $this->db->delete('jobs', array("$primary_key" => xss_clean($id)));
    }
}