<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* User: ps
# copyright 2014 keepitnative.ch, io, all rights reserved to the author
* Date: 02.05.14
* Time: 20:33
* project: https_docs
* file: SparkPlug.php
* adaption to twitter bootstrap 3, html5 form elements and serverside validation and xss sanitize
*/

class SparkplugCtrl extends CI_Controller
{

    var $table = "users";

    public function index()
    {
        redirect('sparkplugCtrl/show_list');
    }

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('Users');
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'pagination', 'form_validation'));

    }

    public function show_list()
    {

        $config['base_url'] = $this->config->item('base_url') . "/SparkplugCtrl/show_list";
        $config['total_rows'] = $this->db->get("users")->num_rows();
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<ul id="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['next_link'] = '&gt;';
        $config['prev_link'] = '&lt;';

        $url_string = xss_clean($this->uri->uri_string());
        $segments = explode("/", $url_string);
        $segments_length = count($segments);
        switch ($segments_length) {
            case 4:
                $offset = xss_clean($this->uri->segment(4));
                break;
            case 3:
                $offset = xss_clean($this->uri->segment(3));
                break;
            default:
                $offset = 1;
                $offset = 1;
                break;
        }
        $this->pagination->initialize($config);
        $data['results'] = $this->Users->get_all("users", $config["per_page"], $offset);
        $this->load->view('header');
        $this->load->view('sparkplugctrl/list', $data);
        $this->load->view('footer');
    }

    public function show($id)
    {
        $data['result'] = $this->Users->get($id);

        $this->load->view('header');
        $this->load->view('sparkplugctrl/show', $data);
        $this->load->view('footer');
    }

    public function new_entry()
    {
        $this->setRules();

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('header');
            $this->load->view('sparkplugctrl/new');
            $this->load->view('footer');
        } else {
            redirect('SparkPlugCtrl/show_list');
        }
    }

    public function create()
    {
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg', 'Error');
            $this->load->view('header');
            $this->load->view('sparkplugctrl/new');
            $this->load->view('footer');
        }
        else
        {
            $this->Users->insert();
            $this->session->set_flashdata('msg', 'Entry Created');
            redirect('SparkPlugCtrl/show_list');
        }
    }

    public function edit($id)
    {
        $res = $this->Users->get($id);
        $data['result'] = $res[0];

        $this->setRules();
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('header');
            $this->load->view('sparkplugctrl/edit', $data);
            $this->load->view('footer');
        }
        else
        {
            redirect('SparkPlugCtrl/show_list');
        }
    }
    public function update($id)
    {
        $this->setRules();
        if ($this->form_validation->run() == FALSE)
        {

            $res = $this->Users->get($id);
            $data['result'] = $res[0];
            $this->session->set_flashdata('msg', 'Error');
            $this->load->view('header');
            $this->load->view('sparkplugctrl/edit', $data);
            $this->load->view('footer');
        }
        else
        {
            $this->Users->update();
            $this->session->set_flashdata('msg', 'Entry Updated');
            redirect('SparkPlugCtrl/show_list');
        }
    }

    public function delete($id)
    {
        $this->Users->delete($id);

        $this->session->set_flashdata('msg', 'Entry Deleted');
        redirect('sparkplugCtrl/show_list');
    }

    public function setRules() {

        $this->form_validation->set_rules('id', 'id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('ip_address', 'ip_address', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|max_length[500]|xss_clean|matches[passconf]|sha1');
        $this->form_validation->set_rules('passconf', 'passconf', 'trim|required|sha1');
        $this->form_validation->set_rules('forgot_password', 'forgot_password', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('salt', 'salt', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'valid_email|trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('activation_code', 'activation_code', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('remember_code', 'remember_code', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('created_on', 'created_on', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('last_login', 'last_login', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('active', 'active', 'trim|required|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('first_name', 'first_name', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('last_name', 'last_name', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('company', 'company', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        $this->form_validation->set_rules('phone', 'phone', 'trim|required|min_length[5]|max_length[500]|xss_clean');

    }
}