<?php
            class SparkPlugCtrl extends CI_Controller {

                var $table = "users";
                public function index() {
                    redirect('SparkPlugCtrl/show_list');
                }
                public function __construct() {
                    parent::__construct();

                    $this->load->database();
                    $this->load->model('Users');
                    $this->load->helper(array('form','url'));
                    $this->load->library(array('session', 'form_validation'));
                }

                public function show_list() {
                    $data['results'] = $this->Users->get_all();
                    $this->load->view('header');
                    $this->load->view('sparkplugctrl/list', $data);
                    $this->load->view('footer');
                }

                public function show($id) {
                    $data['result'] = $this->Users->get($id);

                    $this->load->view('header');
                    $this->load->view('sparkplugctrl/show', $data);
                    $this->load->view('footer');
                }

                public function new_entry() {$this->form_validation->set_rules('id', 'id', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('ip_address', 'ip_address', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('forgot_password', 'forgot_password', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('salt', 'salt', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('email', 'email', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('activation_code', 'activation_code', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('remember_code', 'remember_code', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('created_on', 'created_on', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('last_login', 'last_login', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('active', 'active', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('first_name', 'first_name', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('last_name', 'last_name', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('company', 'company', 'trim|required|min_length[5]|max_length[500]|xss_clean');$this->form_validation->set_rules('phone', 'phone', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        if ($this->form_validation->run() == FALSE) {

                    $this->load->view('header');
                    $this->load->view('sparkplugctrl/new');
                    $this->load->view('footer');
        } else {
                    redirect('SparkPlugCtrl/show_list');
        }
                }

                public function create() {
                    $this->Users->insert();

                    $this->session->set_flashdata('msg', 'Entry Created');
                    redirect('SparkPlugCtrl/show_list');
                }

                public function edit($id) {
                    $res = $this->Users->get($id);
                    $data['result'] = $res[0];
                
        $query = $this->db->get($this->table);
        $fields = $this->db->list_fields($this->table);

        foreach ($fields as $field) {
        $this->form_validation->set_rules('phone', 'phone', 'trim|required|min_length[5]|max_length[500]|xss_clean');

        }
        if ($this->form_validation->run() == FALSE) {
                    $this->load->view('header');
                    $this->load->view('sparkplugctrl/edit', $data);
                    $this->load->view('footer');
        } else {
                    redirect('SparkPlugCtrl/show_list');
        }
                }

                public function update() {
                    $this->Users->update();

                    $this->session->set_flashdata('msg', 'Entry Updated');
                    redirect('SparkPlugCtrl/show_list');
                }

                public function delete($id) {
                    $this->Users->delete($id);

                    $this->session->set_flashdata('msg', 'Entry Deleted');
                    redirect('SparkPlugCtrl/show_list');
                }
            }