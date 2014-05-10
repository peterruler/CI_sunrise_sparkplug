<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 02.05.14
 * Time: 20:33
 * project: sparkplug
 * file: application/controllers/Jobs.php
 * adaption to twitter bootstrap 3, html5 form elements, serverside validation and xss sanitize
 */
class Jobs extends CI_Controller {

    private $table = "jobs";
    public function index() {
        redirect('jobs/show_list');
    }
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->model('Jobs_model');
        $this->load->helper(array('form','url','security'));
        $this->load->library(array('session', 'pagination', 'form_validation','encrypt'));

    }

    public function show_list() {

        $config['base_url'] = $this->config->item('base_url')."/Jobs/show_list";
        $config['total_rows'] = $this->db->get("jobs")->num_rows();
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<ul id="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['next_link'] = '&gt;';
        $config['prev_link'] = '&lt;';

        $url_string =xss_clean($this->uri->uri_string());
        $segments = explode("/",$url_string);
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
                break;
        }
        $this->pagination->initialize($config);
        $data['results'] = $this->Jobs_model->get_all("jobs",$config["per_page"],$offset);
        $index = 0;
        if(!isset($data["results"][0]["id"])) {
            foreach($data["results"] as $row) {
                //add record primary key assigned to id
                $data["results"][$index]["id"] = current($row);
                $index++;
            }
        }
        $this->load->view('header');
        $this->load->view('jobs/list', $data);
        $this->load->view('footer');
    }

    public function show($id) {
        $data['result'] = $this->Jobs_model->get($id);

        if(!isset($data["result"]["id"])) {
            foreach($data["result"] as $row) {
                //add record primary key assigned to id
                $data["result"]["id"] = current($row);
            }
        }

        $this->load->view('header');
        $this->load->view('jobs/show', $data);
        $this->load->view('footer');
    }

    public function new_entry() {

        	$this->form_validation->set_rules('id', 'id', 'is_unique[jobs1]|numeric|trim|min_length[5]|max_length[11]|xss_clean');









        if ($this->form_validation->run() == FALSE) {

                    $this->load->view('header');
                    $this->load->view('jobs/new');
                    $this->load->view('footer');
        } else {
                    redirect('jobs/show_list');
       }
    }

    public function create() {

        	$this->form_validation->set_rules('id', 'id', 'is_unique[jobs1]|numeric|trim|min_length[5]|max_length[11]|xss_clean');








        if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('msg', 'Error');
                $this->load->view('header');
                $this->load->view('jobs/new');
                $this->load->view('footer');
            } else {
                $this->Jobs_model->insert();
                $this->session->set_flashdata('msg', 'Entry Created');
                redirect('jobs/show_list');
            }
    }

    public function edit($id) {

        $res = $this->Jobs_model->get($id);
        $data["result"] = $res[0];
        if(!isset($data["result"]["id"])) {
            foreach($data["result"] as $row) {
                //add record primary key assigned to id
                $data["result"]["id"] = $row[0];
            }
        }
        	$this->form_validation->set_rules('id', 'id', 'is_unique[jobs1]|numeric|trim|min_length[5]|max_length[11]|xss_clean');









        if ($this->form_validation->run() == FALSE) {
                    $this->load->view('header');
                    $this->load->view('jobs/edit', $data);
                    $this->load->view('footer');
        } else {
                    redirect('jobs/show_list');
        }
    }

    public function update($id) {
        	$this->form_validation->set_rules('id', 'id', 'is_unique[jobs1]|numeric|trim|min_length[5]|max_length[11]|xss_clean');









        if ($this->form_validation->run() == FALSE)
        {
            $res = $this->Jobs_model->get($id);
            $data["result"] = $res[0];

            $this->session->set_flashdata('msg', 'Error');
            $this->load->view('header');
            $this->load->view('jobs/edit', $data);
            $this->load->view('footer');
        }
        else
        {
            $post = $this->input->post();
            $this->Jobs_model->update($id);
            $this->session->set_flashdata('msg', 'Entry Updated');
            redirect('jobs/show_list');
        }
    }

    public function delete($id) {
        $this->Jobs_model->delete($id);

        $this->session->set_flashdata('msg', 'Entry Deleted');
        redirect('jobs/show_list');
    }
    /**
     * @desc Validates a date format
     * @params format,delimiter
     * e.g. d/m/y,/ or y-m-d,-
     * http://tutsforweb.blogspot.ch/2012/05/date-validation-for-codeigniter-2.html
     */
     function valid_date($str, $params)
     {
      // setup
      $CI =&get_instance();
      $params = explode(",", $params);
      $delimiter = $params[1];
      $date_parts = explode($delimiter, $params[0]);

      // get the index (0, 1 or 2) for each part
      $di = $this->valid_date_part_index($date_parts, "d");
      $mi = $this->valid_date_part_index($date_parts, "m");
      $yi = $this->valid_date_part_index($date_parts, "y");

      // regex setup
      $dre =   "(0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31)";
      $mre = "(0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12)";
      $yre = "([0-9]{4})";
      $red = "".$delimiter; // escape delimiter for regex
      $rex = "/^[0]{$red}[1]{$red}[2]/";

      // do replacements at correct positions
      $rex = str_replace("[{$di}]", $dre, $rex);
      $rex = str_replace("[{$mi}]", $mre, $rex);
      $rex = str_replace("[{$yi}]", $yre, $rex);

      if (preg_match($rex, $str, $matches))
      {
       // skip 0 as it contains full match, check the date is logically valid
       if (checkdate($matches[$mi + 1], $matches[$di + 1], $matches[$yi + 1]))
       {
        return true;
       }
       else
       {
        // match but logically invalid
        $CI->form_validation->set_message("valid_date", "The date is invalid.");
        return false;
       }
      }

      // no match
      $CI->form_validation->set_message("valid_date", "The date format is invalid. Use {$params[0]}");
      return false;
     }

     function valid_date_part_index($parts, $search)
     {
      for ($i = 0; $i <= count($parts); $i++)
      {
       if ($parts[$i] == $search)
       {
        return $i;
       }
      }
     }
}