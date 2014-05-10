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

            class Captcha_model extends CI_Model {
                public $captcha_id	= '';
                public $captcha_time	= '';
                public $ip_address	= '';
                public $word	= '';

                public function Captcha_model() {
                    parent::__construct();
                    $this->load->helper(array("security"));
                    $this->load->library(array("encrypt"));
                }

                public function getPrimaryKeyFieldName() {
                 $fields = $this->db->field_data("captcha");

                    $primary_key_name = $fields[0]->name;
                    return $primary_key_name;
                }

                public function insert() {
                    $this->captcha_id	= xss_clean($this->input->post('captcha_id',TRUE));
                    $this->captcha_time	= xss_clean($this->input->post('captcha_time',TRUE));
                    $this->ip_address	= xss_clean($this->input->post('ip_address',TRUE));
                    $this->word	= xss_clean($this->input->post('word',TRUE));

                    $this->db->insert('captcha', $this);
                }

                public function get($id) {
                    $id = (int) $id;
                    $primary_key = $this->getPrimaryKeyFieldName();

                    $query = $this->db->get_where('captcha', array("$primary_key" => (int) xss_clean($id)));
                    return $query->result_array();
                }

                public function get_all($table="captcha", $limit_per_page=10, $offset_limit=1 ) {
                    $this->db->limit($limit_per_page, $offset_limit);
                    $query = $this->db->get('captcha');
                    return $query->result_array();
                }

                public function get_field_data() {
                    return $this->db->field_data('captcha');
                }

                public function update($id) {
                    $this->captcha_id	= xss_clean($this->input->post('captcha_id',TRUE));
                    $this->captcha_time	= xss_clean($this->input->post('captcha_time',TRUE));
                    $this->ip_address	= xss_clean($this->input->post('ip_address',TRUE));
                    $this->word	= xss_clean($this->input->post('word',TRUE));

                    $primary_key = $this->getPrimaryKeyFieldName();

                    $this->db->set($this);
                    $this->db->where( "$primary_key" ,$id);//@FIMXE sec? $this->$primary_key
                    $this->db->update('captcha', $this);
                }

                public function delete($id) {
                    $id = (int) $id;
                    $primary_key = $this->getPrimaryKeyFieldName();
                    $this->db->delete('captcha', array("$primary_key" => xss_clean($id)));
                }
            }