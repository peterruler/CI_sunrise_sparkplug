<?php
            class Users extends CI_Model {
                public $id	= '';
                public $ip_address	= '';
                public $password	= '';
                public $forgot_password	= '';
                public $salt	= '';
                public $email	= '';
                public $activation_code	= '';
                public $remember_code	= '';
                public $created_on	= '';
                public $last_login	= '';
                public $active	= '';
                public $first_name	= '';
                public $last_name	= '';
                public $company	= '';
                public $phone	= '';

                public function Users() {
                    parent::__construct();
                    $this->load->helper(array("security"));
                }

                public function insert() {
                    $this->id	= xss_clean($this->input->post('id',TRUE));
                    $this->ip_address	= xss_clean($this->input->post('ip_address',TRUE));
                    $this->password	= xss_clean($this->input->post('password',TRUE));
                    $this->forgot_password	= xss_clean($this->input->post('forgot_password',TRUE));
                    $this->salt	= xss_clean($this->input->post('salt',TRUE));
                    $this->email	= xss_clean($this->input->post('email',TRUE));
                    $this->activation_code	= xss_clean($this->input->post('activation_code',TRUE));
                    $this->remember_code	= xss_clean($this->input->post('remember_code',TRUE));
                    $this->created_on	= xss_clean($this->input->post('created_on',TRUE));
                    $this->last_login	= xss_clean($this->input->post('last_login',TRUE));
                    $this->active	= xss_clean($this->input->post('active',TRUE));
                    $this->first_name	= xss_clean($this->input->post('first_name',TRUE));
                    $this->last_name	= xss_clean($this->input->post('last_name',TRUE));
                    $this->company	= xss_clean($this->input->post('company',TRUE));
                    $this->phone	= xss_clean($this->input->post('phone',TRUE));

                    $this->db->insert('users', $this);
                }

                public function get($id) {
                    $id = (int) $id;
                    $query = $this->db->get_where('users', array('id' => (int) xss_clean($id)));
                    return $query->result_array();
                }

                public function get_all() {
                    $query = $this->db->get('users');
                    return $query->result_array();
                }

                public function get_field_data() {
                    return $this->db->field_data('users');
                }

                public function update() {
                    $this->id	= xss_clean($this->input->post('id',TRUE));
                    $this->ip_address	= xss_clean($this->input->post('ip_address',TRUE));
                    $this->password	= xss_clean($this->input->post('password',TRUE));
                    $this->forgot_password	= xss_clean($this->input->post('forgot_password',TRUE));
                    $this->salt	= xss_clean($this->input->post('salt',TRUE));
                    $this->email	= xss_clean($this->input->post('email',TRUE));
                    $this->activation_code	= xss_clean($this->input->post('activation_code',TRUE));
                    $this->remember_code	= xss_clean($this->input->post('remember_code',TRUE));
                    $this->created_on	= xss_clean($this->input->post('created_on',TRUE));
                    $this->last_login	= xss_clean($this->input->post('last_login',TRUE));
                    $this->active	= xss_clean($this->input->post('active',TRUE));
                    $this->first_name	= xss_clean($this->input->post('first_name',TRUE));
                    $this->last_name	= xss_clean($this->input->post('last_name',TRUE));
                    $this->company	= xss_clean($this->input->post('company',TRUE));
                    $this->phone	= xss_clean($this->input->post('phone',TRUE));

                    $this->db->update('users', $this, array('id' => xss_clean($this->input->post('id', TRUE))));
                }

                public function delete($id) {
                    $id = (int) $id;
                    $this->db->delete('users', array('id' => xss_clean($id)));
                }
            }