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

/**
 * SparkPlug
 * http://code.google.com/p/sparkplug/
 *
 * Generator:
 * Generates a basic CRUD environment for any given database table
 * Generated code is defined by the templates found at the bottom of the class
 *
 * Dynamic:
 * Creates a dynamic CRUD environment for any given database table
 *
 * @author Pascal Kriete
 *
 **/
class SparkPlug
{
    var $CI; // CI Super Object
    var $table; // Table specified in the constructor

    /* Generated */
    var $ucf_controller; //Name of controller (ucfirst)
    var $controller; // What the route says the controller's name is
    var $model_name; // Name of the model (strtolower, ucfirst)

    /* Dynamic */
    var $base_uri; // URI string of the calling constructor/function (all forms submit to this uri)
    var $request; // Array of added segments


    /**
     * Constructor
     */
    function SparkPlug()
    {
        $this->CI =& get_instance();

        $this->CI->load->database();
        $this->CI->load->library('session', 'database');
        $this->CI->load->helper('form');
        $this->CI->load->helper('url');

        $table = $this->getTable();
        if (!$this->CI->db->table_exists($table)) {
            //die('Table <strong>' . $table . '</strong> does not exist.');
        }

        $this->table = $table;
    }

    private function getTable()
    {
        $url_string = xss_clean($this->CI->uri->uri_string());
        $segments = explode("/", $url_string);
        $segments_length = count($segments);
        if ($segments_length > 0) {
            try {
                $table = xss_clean($this->CI->uri->segment(3));
                if ($table != '' || !empty($table)) {
                    return $table;
                } else {
                    throw new \Exception("Controller in url not specified, please choose analog to view name, e.g http://domain.com/{controller-tablename}/scaffolding/{tablename}");

                }
            } catch (\Exception $e) {
                echo "<h3>An error occured!</h3><p>{$e->getMessage()}</p><p>" . str_replace("\n", "<br />", $e->getTraceAsString()) . "</p>";
            }
        } else {
            throw new \Exception("Controller in url not specified, please choose controller analog to view name, e.g http://domain.com/{controller-tablename}/scaffolding/{tablename}");
        }
    }

    /**
     * Public Function
     *
     * Starts the dynamic scaffolding process
     */
    function scaffold()
    {
        /* Get rid of the CI default nonsense and set real path */
        $route =& load_class('Router');
        $base_url = $this->CI->config->site_url();
        if ($route->directory != '') {
            $base_url .= '/';
        }

        $this->base_uri = $route->directory . '/' . $route->class . '/' . $route->method;

        /* Did we call a subfunction - catch it here */
        $segs = $this->CI->uri->segment_array();
        $last = array_search($route->method, $segs); // Everything beyond this is ours

        $this->request = array('');
        if ($last < count($segs)) {
            $this->request = array_slice($segs, $last);
        }

        $this->_processRequest();

        exit; //Prevent loading of index function if we're in the constructor
    }


    /**
     * Public Function
     *
     * Starts the code generation process
     */
    function generate()
    {
        /* Create model name based on table */
        $this->model_name = ucfirst(strtolower($this->table));

        /* Figure out the calling controller - that's the one we want to fix */
        $route =& load_class('Router');
        $this->controller = $route->class;
        $this->ucf_controller = ucfirst($route->class);

        $this->_generate(); //** FUNCTION FOUND BELOW (l.370) **//
    }


    /************************************** * * * * * **************************************/
    /**************************************           **************************************/
    /**************************************  DYNAMIC  **************************************/
    /**************************************           **************************************/
    /************************************** * * * * * **************************************/

    /**
     * Process any additional uri-segments
     *
     * If we have no extra segments we check if anything was submitted
     */
    function _processRequest()
    {

        /* Check if something was submitted */
        $action = xss_clean($this->CI->input->post('action', TRUE));

        switch ($action) {
            case 'add':
                $this->_db_insert();
                break;
            case 'edit':
                $this->_db_edit();
                break;
            case 'delete':
                $id = (int)xss_clean($this->input->post("id", TRUE));
                $this->_db_delete($id);
                break;
        }

        /* All forms submit to index, so we may be somewhere else */
        switch ($this->request[0]) {
            case 'show':
                $this->_dynamic('show');
                break;
            case 'add':
                $this->_dynamic('insert');
                break;
            case 'edit':
                $this->_dynamic('edit');
                break;
            case 'delete':
                $this->_dynamic('delete');
                break;
            default:
                // Nope, seems we really wanted index (or entered an invalid url);
                $this->_dynamic();
        }
    }

    /*****                                *****/
    /*****        PROCESS DB ACTIONS        *****/
    /*****                                *****/

    function _db_insert()
    {
        $post = xss_clean($this->input->post('', TRUE));
        unset($post['action']);
        unset($post['submit']);

        $this->CI->db->insert($this->table, $post);

        $this->CI->session->set_flashdata('msg', 'Entry Added');
        redirect($this->base_uri);
    }

    function _db_edit()
    {
        $post = xss_clean($this->input->post('', TRUE));
        unset($post['action']);
        unset($post['submit']);

        $this->CI->db->where('id', $post['id']);
        $this->CI->db->update($this->table, $post);

        $this->CI->session->set_flashdata('msg', 'Entry Modified');
        redirect($this->base_uri);
    }

    function _db_delete($id)
    {
        $id = (int)xss_clean($id);
        $this->CI->db->where('id', $id);
        $this->CI->db->delete($this->table);

        $this->CI->session->set_flashdata('msg', 'Entry Deleted');
        redirect($this->base_uri);
    }


    /*****                                *****/
    /*****        SHOW FORMS AND DATA        *****/
    /*****                                *****/

    function _dynamic($action = 'list')
    { //action comes from _processRequests

        switch ($action) {
            case 'list':
                $this->_list();
                break;
            case 'show':
                $this->_show();
                break;
            case 'insert':
                $this->_insert();
                break;
            case 'edit':
                $this->_edit();
                break;
            case 'delete':
                $this->_delete();
            default:
                $this->_list();
        }

    }

    //Special case - here so that "Delete" can be a link instead of a button
    function _delete()
    {
        $id = $this->request[1];
        $this->_db_delete($id);
    }

    function _list()
    {
        $query = $this->CI->db->get($this->table);
        $fields = $this->CI->db->list_fields($this->table);

        $this->_header();
        echo "<h1>List " . (string)$this->table . "</h1>";
        $table = '<div class="table-responsive">';
        $table .= '<table class="table"><tr>';
        foreach ($fields as $field)
            $table .= '<th>' . ucfirst($field) . '</th>';
        $table .= '</tr>';

        foreach ($query->result_array() as $row) {
            $table .= '<tr>';
            foreach ($fields as $field)
                $table .= '<td>' . $row[$field] . '</td>';

            $table .= '<td>' . $this->_show_link($row['id']) . '</td>' .
                '<td>' . $this->_edit_link($row['id']) . '</td>' .
                '<td>' . $this->_delete_link($row['id']) . '</td>';

            $table .= '</tr>';
        }
        $table .= '</table></div>';
        echo $table;

        echo $this->_insert_link();
        $this->_footer();

    }

    function _show()
    {
        echo $this->load->view('header', '', TRUE);
        echo '<h1>Show ' . (string)$this->table . '</h1>';

        $id = (int)$this->request[1]; //@todo santitize
        $this->CI->db->where('id', $id);
        $query = $this->CI->db->get($this->table);

        $data = $query->result_array();

        foreach ($data[0] as $field_name => $field_value) {
            echo '<p>
			  <b>' . ucfirst($field_name) . ':</b>' . $field_value . '
			  </p>';
        }
        echo $this->_back_link();

        echo $this->load->view('footer', '', TRUE);
    }

    function _insert()
    {
        echo '<h1>New</h1>';

        $fields = $this->CI->db->field_data($this->table);
        $form = form_open($this->base_uri);

        foreach ($fields as $field) {
            $form .= $this->_insertMarkup($field);
        }

        $form .= form_hidden('action', 'add');
        $form .= form_submit('submit', 'Insert', "formnovalidate ") . '</p>';
        $form .= form_close();
        echo $form;

        echo $this->_back_link();
    }

    function _edit()
    {
        echo '<h1>Edit</h1>';

        $id = xss_clean($this->request[1]);
        $this->CI->db->where('id', $id);
        $query = $this->CI->db->get($this->table);

        $data = $query->result_array();

        $fields = $this->CI->db->field_data($this->table);

        $form = form_open($this->base_uri);

        foreach ($fields as $field) {
            $form .= $this->_editMarkup($field, $data[0]);
        }

        $form .= form_hidden('action', 'edit');
        $form .= '<p>' . $this->_back_link();
        $form .= form_submit('submit', 'Update', "formnovalidate ") . '</p>';
        $form .= form_close();
        echo $form;
    }

    /**
     * Dynamic Forms
     */

    function _insertMarkup($field)
    {
        $form_markup = '<?php';
        $form_markup .= '\n\t';
        $form_markup = '$size = 50;';
        $form_markup .= '\n\t';
        $form_markup = '$style = \'width:100%;\'';
        $form_markup .= '\n\t';
        $form_markup = '$css-class = \'form-control\'';
        $form_markup .= '\n\t';
        $form_markup .= '\n\t';
        $form_markup = '$cols = $size';
        $form_markup .= '\n\t';
        $form_markup = '$rows = 20';
        $form_markup .= '\n\t';
        if ($field->primary_key) {
            $form_markup .= 'echo form_hidden(' . $field->name . ', \'\')';
            $form_markup .= '\n\t';
        } else {
            if ($field->type != 'boolean') {
                $form_markup .= '\n\t';
                $form_markup .= '?><p><?php';
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\',\'' . $field->name . '\')';
                $form_markup .= '\n\t';
                $form_markup .= '?><br/><?php';
            } else if ($field->type == 'boolean') {
                $form_markup .= '\n\t';
                $form_markup .= '?><p><?php';
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\',\'' . $field->name . '\')';
                $form_markup .= '\n\t';
                $form_markup .= '?><p><?php';
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\',\'' . ucfirst('true') . '\')';
                $form_markup .= '?><p><?php';
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\',\'' . ucfirst('false') . '\')';
                $form_markup .= '\n\t';
                $form_markup .= '?><br/><?php';
            }

            switch ($field->type) {
                case 'int':
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'number\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    switch ($field->primary_key) :
                        case 'id':
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input($options);';
                            $form_markup .= '\n\t';
                            break;
                        default:
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input($options);';
                            $form_markup .= '\n\t';
                            break;
                    endswitch;
                    break;
                case 'string':
                    $name = strtolower($field->name);
                    switch ($name) :
                        case 'email':
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'email\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input($options);';
                            $form_markup .= '\n\t';
                            break;
                        case 'url':
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'url\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input($options);';
                            $form_markup .= '\n\t';
                            break;
                        case 'password':
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'password\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input($options);';
                            $form_markup .= '\n\t';

                            $form_markup .= '//reenter password';
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'passconf\',
\'id\' => \'passconf\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'password\',
\'placeholder\' => \'passconf\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input($options);';
                            $form_markup .= '\n\t';
                            break;
                        case 'phone':
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'tel\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input($options);';
                            $form_markup .= '\n\t';
                            break;
                        default:
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'text\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input($options);';
                            $form_markup .= '\n\t';
                            break;
                    endswitch;
                    break;
                case 'text':
                case 'blob':
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'cols\' => $cols,
\'row\' => $rows,
\'style\' => "$style",
\'class\' => "$css-class",
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_textarea($options);';
                    break;
                case 'datetime' :
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'datetime\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_input($options);';
                    $form_markup .= '\n\t';

                    break;
                case 'boolean':
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '[]\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'true\',),
\'checked\',\'checked\',
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'radio\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_radio($options);';
                    $form_markup .= '\n\t';

                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '[]\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'false\',),
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'radio\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_radio($options);';
                    $form_markup .= '\n\t';

                    break;
                default :
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'text\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_input($options);';
                    $form_markup .= '\n\t';
                    break;
            }
        }
        return $form_markup;
    }

    function _editMarkup($field, $data)
    {

        $form_markup = '<?php';
        $form_markup .= '\n\t';
        $form_markup = '$size = 50;';
        $form_markup .= '\n\t';
        $form_markup = '$style = \'width:100%;\'';
        $form_markup .= '\n\t';
        $form_markup = '$css-class = \'form-control\'';
        $form_markup .= '\n\t';
        $form_markup .= '\n\t';
        $form_markup = '$cols = $size';
        $form_markup .= '\n\t';
        $form_markup = '$rows = 20';
        $form_markup .= '\n\t';
        if ($field->primary_key) {
            $form_markup .= 'echo form_hidden(' . $field->name . ', \'\')';
            $form_markup .= '\n\t';
        } else {
            if ($field->type != 'boolean') {
                $form_markup .= '\n\t';
                $form_markup .= '?><p><?php';
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\',\'' . $field->name . '\')';
                $form_markup .= '\n\t';
                $form_markup .= '?><br/><?php';
            } else if ($field->type == 'boolean') {
                $form_markup .= '\n\t';
                $form_markup .= '?><p><?php';
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\',\'' . $field->name . '\')';
                $form_markup .= '\n\t';
                $form_markup .= '?><p><?php';
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\',\'' . ucfirst('true') . '\')';
                $form_markup .= '?><p><?php';
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\',\'' . ucfirst('false') . '\')';
                $form_markup .= '\n\t';
                $form_markup .= '?><br/><?php';
            }

            switch ($field->type) {
                case 'int':
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'number\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    switch ($field->primary_key) :
                        case 'id':
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input( $options);';
                            $form_markup .= '\n\t';
                            break;
                        default:
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input( $options);';
                            $form_markup .= '\n\t';
                            break;
                    endswitch;
                    break;
                case 'string':
                    $name = strtolower($field->name);
                    switch ($name) :
                        case 'email':
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'email\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input( $options);';
                            $form_markup .= '\n\t';
                            break;
                        case 'url':
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'url\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input( $options);';
                            $form_markup .= '\n\t';
                            break;
                        case 'password':
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'password\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input( $options);';
                            $form_markup .= '\n\t';

                            $form_markup .= '//reenter password';
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'passconf\',
\'id\' => \'passconf\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'password\',
\'placeholder\' => \'passconf\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input( $options);';
                            $form_markup .= '\n\t';
                            break;
                        case 'phone':
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'tel\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input( $options);';
                            $form_markup .= '\n\t';
                            break;
                        default:
                            $form_markup .= '\n\t';
                            $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'text\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= '\n\t';
                            $form_markup .= 'echo form_input(\'' . $field->name . '\', $options);';
                            $form_markup .= '\n\t';
                            break;
                    endswitch;
                    break;
                case 'text':
                case 'blob':
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'cols\' => $cols,
\'row\' => $rows,
\'style\' => "$style",
\'class\' => "$css-class",
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_textarea($options);';
                    break;
                case 'datetime' :
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'datetime\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_input(\'' . $field->name . '\', $options);';
                    $form_markup .= '\n\t';

                    break;
                case 'boolean':
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '[]\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'true\',),
\'checked\',\'checked\',
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'radio\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_radio(\'' . $field->name . '\', $options);';
                    $form_markup .= '\n\t';

                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '[]\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'false\',),
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'radio\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_radio(\'' . $field->name . '\', $options);';
                    $form_markup .= '\n\t';

                    break;
                default :
                    $form_markup .= '\n\t';
                    $form_markup .= '$options = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',\'\',),
\'maxlength\' => \'' . $field->max_length . '\',
\'size\' => "$size",
\'style\' => "$style",
\'class\' => "$css-class",
\'type\' => \'text\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= '\n\t';
                    $form_markup .= 'echo form_input(\'' . $field->name . '\', $options);';
                    $form_markup .= '\n\t';
                    break;
            }
        }
        return $form_markup;
    }

    /*****                                *****/
    /*****        HELPER FUNCTIONS        *****/
    /*****                                *****/

    function _delete_link($id)
    {
        return anchor($this->base_uri . '/delete/' . $id, 'Delete', "class='btn btn-sm btn-danger'");
    }

    function _edit_link($id)
    {
        return anchor($this->base_uri . '/edit/' . $id, 'Edit', "class='btn btn-sm btn-warning'");
    }

    function _show_link($id)
    {
        return anchor($this->base_uri . '/show/' . $id, 'View', "class='btn btn-sm btn-success'");
    }

    function _insert_link()
    {
        return anchor($this->base_uri . '/add', 'New', "class='btn btn-lg btn-default btn-block'");
    }

    function _back_link()
    {
        return anchor($this->base_uri, 'Back', "class='btn btn-lg btn-default btn-block'");
    }

    function _header()
    {
        echo '<!DOCTYPE html>"
				<html lang="en">
				<head>
				<meta charset=utf-8">
				<meta name="Developer" content="Pascal Kriete" />
				<title>Scaffolding - ' . ucfirst($this->table) . '</title>
				</head>
				<body>
				<p>';
        echo " <?= if( $this->CI->session->flashdata('msg') !='' ) :?>";
        echo '<div class="alert alert-success">' . $this->CI->session->flashdata('msg') . '</div></p>';
        echo "endif;";
    }

    function _footer()
    {
        echo '</body></html>';
    }


    /************************************** * * * * * **************************************/
    /**************************************           **************************************/
    /************************************** GENERATED **************************************/
    /**************************************           **************************************/
    /************************************** * * * * * **************************************/

    /**
     * Main function for the generation process
     *
     * Computes file paths
     * Calls part-generators
     * Creates files
     */
    function _generate()
    {
        /* Make crud model */

        echo "<h3>Running SparkPlug...</h3>";

        $model_path = APPPATH . 'models/' . ucfirst($this->table) . '.php';
        $model_text = $this->_generate_model();

        file_put_contents($model_path, $model_text);
        echo $model_path . ' created<br/>';

        /* Generate views for crud functions in subfolder */

        $view_folder = APPPATH . 'views/' . strtolower($this->model_name);
        $view_text = $this->_generate_views();

        $dir_created = @mkdir($view_folder);
        echo $dir_created ? $view_folder . ' created<br/>' : $view_folder . ' already exists - no need to create<br/>';

        foreach ($view_text as $view_name => $view) {
            $view_path = $view_folder . '/' . $view_name . '.php';

            file_put_contents($view_path, $view);
            echo $view_path . ' created<br/>';
        }

        /* Create the controller to tie it all up */

        $controller_path = APPPATH . 'controllers/' . $this->controller . '.php';
        $controller_text = $this->_generate_controller();
        file_put_contents($controller_path, $controller_text);
        echo $controller_path . ' created<br/>';

        echo '<br/>Scaffold completed.  Click ' . anchor($this->model_name . "/show_list", 'here') . ' to get started.';
    }

    /*****                                *****/
    /*****            MODEL                *****/
    /*****                                *****/

    /**
     * Generates the model code
     *
     * Gets the user defined layout from the template
     * Replaces all tags
     * Calls _fix_indent for multi-line replacements
     */
    function _generate_model()
    {

        $model_text = $this->_model_text();
        $fields = $this->CI->db->list_fields($this->table);

        /* REPLACE TAGS */
        $model_text = str_replace("{model_name}", $this->model_name, $model_text);
        $model_text = str_replace("{table}", $this->table, $model_text);


        /* Replace Variable Initialization */
        list($model_text, $indent) = $this->_fix_indent($model_text, 'variables');

        $var_init = '';
        foreach ($fields as $field) {
            $var_init .= $indent . 'public $' . $field . "	= '';\n";
        }
        $model_text = str_replace("{variables}\n", $var_init, $model_text);


        /* Replace Variable Setters */
        list($model_text, $indent) = $this->_fix_indent($model_text, 'set_variables_from_post');

        $var_set = '';
        foreach ($fields as $field) {
            if ($field == "password") {
                $var_set .= '$password = $this->encrypt->sha1(xss_clean($this->input->post("password",TRUE)));' . "\n";
                $var_set .= $indent . '$this->password	= $password;' . "\n";
            } elseif ($field == "passconf") {
                $var_set .= '$passconf = $this->encrypt->sha1(xss_clean($this->input->post("passconf",TRUE)));' . "\n";
                $var_set .= $indent . '$this->passconf	= $passconf;' . "\n";

            } else {
                $var_set .= $indent . '$this->' . $field . '	= xss_clean($this->input->post(\'' . $field . "',TRUE));" . "\n";
            }
        }
        $model_text = str_replace("{set_variables_from_post}\n", $var_set, $model_text);


        return $model_text;
    }


    /*****                                *****/
    /*****            VIEWS                *****/
    /*****                                *****/

    /**
     * Generates the View Files
     *
     * Grabs all of the view templates as defined in the array
     * Replaces tags
     */
    function _generate_views()
    {

        /* Template function = _<viewname>_view */
        $views = array('index', 'edit', 'list', 'new', 'show');

        $view_text = array();

        foreach ($views as $view) {
            $view_funct = '_' . $view . '_view';

            if (method_exists($this, $view_funct)) {
                //$view_text[$view] = $this->_header();
                $text = $this->$view_funct();
                $text = str_replace('{controller}', $this->controller, $text);
                $text = str_replace('{form_fields_create}', $this->_form_fields('create'), $text);
                $text = str_replace('{form_fields_update}', $this->_form_fields('update'), $text);
                $view_text[$view] = $text;
                //$view_text[$view] .= $this->_footer();
            }
        }

        return $view_text;
    }


    /*****                                *****/
    /*****            CONTROLLER            *****/
    /*****                                *****/

    /**
     * Generates the controller
     *
     * Gets controller template
     * Replaces tags
     */
    function _generate_controller()
    {
        $text = $this->_controller_text();

        $text = str_replace('{ucf_controller}', $this->ucf_controller, $text);
        $text = str_replace('{controller}', substr($this->controller,0,strlen($this->controller)-strlen("Controller")), $text);
        $text = str_replace("{uc_model_name}", ucfirst($this->model_name), $text);

        $text = str_replace('{model}', $this->model_name, $text);
        $text = str_replace('{view_folder}', strtolower($this->model_name), $text);
        $text = str_replace('{set_rules}', $this->_setRules_form_validation(), $text);
        return $text;
    }


    /*****                                *****/
    /*****        HELPER FUNCTIONS        *****/
    /*****                                *****/

    /**
     * Function to fix indentation for multi-line replacements
     *
     * Cuts the indent off the tag and applies to to all lines
     * that replace it.
     */
    function _fix_indent($text, $tag)
    {
        $pattern = '/\n[\t ]*?\{' . $tag . '\}/';
        preg_match($pattern, $text, $matches);
        $indent = str_replace("\n", '', $matches[0]);
        $indent = str_replace('{' . $tag . '}', '', $indent);
        // Remove tag indent to fix first one
        $text = preg_replace($pattern, "\n{" . $tag . "}", $text);

        return array($text, $indent);
    }

    /**
     * Gateway to markup functions
     *
     * Calls markup functions to create meta-type relevant fields
     */
    function _form_fields($action)
    {

        $query = $this->CI->db->get($this->table);
        $fields = $this->CI->db->field_data($this->table);
        $form = '';

        foreach ($fields as $field) {
            if ($action == 'update')
                $form .= $this->_getEditMarkup($field);
            else
                $form .= $this->_getMarkup($field);
        }

        return $form;
    }

    /**
     * Creates form element for a given field
     *
     * Adds *NOW* to datetime field
     * Indents elements for clean html
     */
    function _getMarkup($field)
    {
        $form_markup = '<?php';
        $form_markup .= "\n\t";

        if ($field->primary_key) {
            $form_markup .= '$hidden_' . $field->name . ' = array(
             \'' . $field->name . '\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))));';
            $form_markup .= "\n\t";
            $form_markup .= 'echo form_hidden($hidden_' . $field->name . ');';
            $form_markup .= "\n\t";
        } else {
            if ($field->type != 'boolean') {
                $form_markup .= "\n\t";
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\', \'' . $field->name . '\');';
                $form_markup .= "\n\t";
            } else if ($field->type == 'boolean') {
                $form_markup .= "\n\t";
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\', \'' . $field->name . '\');';
                $form_markup .= "\n\t";
                $form_markup .= 'echo form_label(\'' . ucfirst('true') . '\', \'' . $field->name . '\');';
                $form_markup .= "\n\t";
                $form_markup .= 'echo form_label(\'' . ucfirst('false') . '\', \'' . $field->name . '\');';
                $form_markup .= "\n\t";
            }
            switch ($field->type) {
                case 'int':
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'number\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    switch ($field->primary_key) :
                        case 'id':
                            $form_markup .= 'echo form_input( $options_' . $field->name . ' );';
                            break;
                        default:
                            $form_markup .= 'echo form_input(  $options_' . $field->name . ' );';
                            break;
                    endswitch;
                    break;
                case 'varchar':
                case 'string':
                    $name = strtolower($field->name);
                    switch ($name) :
                        case 'email':
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'email\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= 'echo form_input( $options_' . $field->name . ' );';
                            break;
                        case 'url':
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'url\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required");
$form_markup .= form_input($options_' . $field->name . ');
break;
';
                            $form_markup .= 'echo form_input($options_' . $field->name . ');';
                        case 'password':
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'maxlength\' => ' . $field->max_length . ',
\'size" => \'50\',
\'style" => \'width:100%\',
\'class" => \'form-control\',
\'type" => \'password\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => "required");';
                            $form_markup .= 'echo form_password($options_' . $field->name . ');';

                            $form_markup .= '
$options_' . $field->name . ' = array(
\'name\' => \'passconf\',
\'id\' => \'passconf\',
\'value\' => set_value(\'' . $field->name . '\',\'passconf\'))),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'password\',
\'placeholder\' => \'passconf\',
\'required\' => \'required");
';
                            $form_markup .= 'echo form_password($options_' . $field->name . ');';
                            break;
                        case 'phone':
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'tel\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= 'echo form_input( $options_' . $field->name . ');';
                            break;
                        default:
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'text\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= 'echo form_input($options_' . $field->name . ');';
                            break;
                    endswitch;
                    break;
                case 'text':
                case 'blob':
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'cols\' => 50,
\'row\' => 20,
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= 'echo form_textarea($options_' . $field->name . ')';
                    break;
                case 'datetime' :
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'date\',
\'placeholder\' => \'' . $field->name . '\');
';
                    $form_markup .= 'echo form_input($options_' . $field->name . ');';
                    break;
                case 'boolean' :
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'radio\',
\'checked\' => FALSE,
\'style\' => \'margin:10px\',
\'required\' =>  \'required\');
';
                    $form_markup .= 'echo form_radio($options_' . $field->name . ');';
                    break;
                default :
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\',xss_clean($this->input->post(\'' . $field->name . '\'))),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'text\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= 'echo form_input($options_' . $field->name . ');';
                    break;
            }
        }
        return $form_markup . '?>';
    }

    /**
     * Creates form elements for an existing row
     *
     * Adds existing data to each element
     */
    function _getEditMarkup($field)
    {
        /**
         * Creates form element for a given field
         *
         * Adds *NOW* to datetime field
         * Indents elements for clean html
         */
        /*
        $query = $this->CI->db->get($this->table);
        $fields = $this->CI->db->field_data($this->table);
        $form = '';

        foreach ($fields as $field) {
            if ($action == 'update')
                $form .= $this->_getEditMarkup($field);
            else
                $form .= $this->_getMarkup($field);
        }

        return $form;
        */
        $form_markup = '<?php';
        $form_markup .= "\n\t";

        if ($field->primary_key) {
            $form_markup .= '$hidden_' . $field->name . ' = array(
            \'' . $field->name . '\'=> set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']));';
            $form_markup .= "\n\t";
            $form_markup .= 'echo form_hidden($hidden_' . $field->name . ');';
            $form_markup .= "\n\t";
        } else {
            if ($field->type != 'boolean') {
                $form_markup .= "\n\t";
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\', \'' . $field->name . '\');';
                $form_markup .= "\n\t";
            } else if ($field->type == 'boolean') {
                $form_markup .= "\n\t";
                $form_markup .= 'echo form_label(\'' . ucfirst($field->name) . '\', \'' . $field->name . '\');';
                $form_markup .= "\n\t";
                $form_markup .= 'echo form_label(\'' . ucfirst('true') . '\', \'' . $field->name . '\');';
                $form_markup .= "\n\t";
                $form_markup .= 'echo form_label(\'' . ucfirst('false') . '\', \'' . $field->name . '\');';
                $form_markup .= "\n\t";
            }
            switch ($field->type) {
                case 'int':
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'number\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    switch ($field->primary_key) :
                        case 'id':
                            $form_markup .= 'echo form_input($options_' . $field->name . ');';
                            break;
                        default:
                            $form_markup .= 'echo form_input($options_' . $field->name . ');';
                            break;
                    endswitch;
                    break;
                case 'varchar':
                case 'string':
                    $name = strtolower($field->name);
                    switch ($name) :
                        case 'email':
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'email\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= 'echo form_input($options_' . $field->name . ');';
                            break;
                        case 'url':
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'url\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required");
$form_markup .= form_input($options_' . $field->name . ');
break;
';
                            $form_markup .= 'echo form_input($options_' . $field->name . ');';
                        case 'password':
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'maxlength\' => ' . $field->max_length . ',
\'size" => \'50\',
\'style" => \'width:100%\',
\'class" => \'form-control\',
\'type" => \'password\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => "required");
';
                            $form_markup .= 'echo form_password($options_' . $field->name . ');';
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'passconf\',
\'id\' => \'passconf\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'password\',
\'placeholder\' => \'passconf\',
\'required\' => \'required");
';
                            $form_markup .= 'echo form_password($options_' . $field->name . ');';
                            break;
                        case 'phone':
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'tel\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= 'echo form_input($options_' . $field->name . ');';
                            break;
                        default:
                            $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'text\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                            $form_markup .= 'echo form_input($options_' . $field->name . ');';
                            break;
                    endswitch;
                    break;
                case 'text':
                case 'blob':
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'cols\' => 50,
\'row\' => 20,
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= 'echo form_textarea($options_' . $field->name . ');';
                    break;
                case 'datetime' :
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'date\',
\'placeholder\' => \'' . $field->name . '\');
';
                    $form_markup .= 'echo form_input($options_' . $field->name . ');';
                    break;
                case 'boolean' :
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'radio\',
\'checked\' => FALSE,
\'style\' => \'margin:10px\',
\'required\' =>  \'required\');
';
                    $form_markup .= 'echo form_radio($options_' . $field->name . ');';
                    break;
                default :
                    $form_markup .= '$options_' . $field->name . ' = array(
\'name\' => \'' . $field->name . '\',
\'id\' => \'' . $field->name . '\',
\'value\' => set_value(\'' . $field->name . '\', $result[\'' . $field->name . '\']),
\'maxlength\' => ' . $field->max_length . ',
\'size\' => \'50\',
\'style\' => \'width:100%\',
\'class\' => \'form-control\',
\'type\' => \'text\',
\'placeholder\' => \'' . $field->name . '\',
\'required\' => \'required\');
';
                    $form_markup .= 'echo form_input($options_' . $field->name . ');';
                    break;
            }
        }
        return $form_markup . '?>';

    }

    /*****                                *****/
    /*****            TEMPLATES            *****/
    /*****                                *****/

    function _setRules_form_validation()
    {
        //$query = $this->db->query("Custom query");
        $fields = $this->CI->db->field_data($this->table);

        $html = "";
        $rules = "";
        foreach ($fields as $field) :
            switch ($field->type) :
                case "varchar" :
                    switch ($field->name) :
                        case "email" :
                            $rules .= '$this->form_validation->set_rules(\'' . $field->name . '\', \'' . $field->name . '\', \'valid_email|trim|required|min_length[5]|max_length[' . $field->max_length . ']|xss_clean\');' . "\n";
                            break;
                        case "phone" :
                            $rules .= '$this->form_validation->set_rules(\'' . $field->name . '\', \'' . $field->name . '\', \'trim|required|min_length[5]|max_length[' . $field->max_length . ']|xss_clean\');' . "\n";
                            break;
                        case "password" :
                            $rules .= '$this->form_validation->set_rules(\'' . $field->name . '\', \'' . $field->name . '\', \'matches[passconf]|trim|required|min_length[5]|max_length[' . $field->max_length . ']|xss_clean\');' . "\n";
                            $rules .= '$this->form_validation->set_rules(\'passconf\', \'passconf\', \'trim|required|min_length[5]|max_length[' . $field->max_length . ']|xss_clean\');';
                            break;
                        default:
                            $rules .= '$this->form_validation->set_rules(\'' . $field->name . '\', \'' . $field->name . '\', \'trim|required|min_length[5]|max_length[' . $field->max_length . ']|xss_clean\');' . "\n";
                            break;
                    endswitch;
                    break;
                case "int" :
                    if ($field->primary_key) :
                        $rules .= '$this->form_validation->set_rules(\'' . $field->name . '\', \'' . $field->name . '\', \'is_unique[' . $this->name.']|numeric|trim|min_length[5]|max_length[' . $field->max_length . ']|xss_clean\');' . "\n";
                    else :
                        $rules .= '$this->form_validation->set_rules(\'' . $field->name . '\', \'' . $field->name . '\', \'numeric|trim|required|min_length[5]|max_length[' . $field->max_length . ']|xss_clean\');' . "\n";
                    endif;
                    break;
                case "datetime" :
                    $rules .= '$this->form_validation->set_rules(\'' . $field->name . '\', \'' . $field->name . '\', \'trim|xss_clean\');' . "\n";
                    break;
                case "text" :
                    $rules .= '$this->form_validation->set_rules(\'' . $field->name . '\', \'' . $field->name . '\', \'trim|xss_clean\');' . "\n";
                    break;
            endswitch;
        endforeach;
        return $rules;
    }

    /**
     * Controller Template - Tags:
     *
     * {model}                        = model name
     * {ucf_controller}                = UC controller name
     * {controller}                    = controller name formated for url
     * {view_folder}                = name of the generated view folder
     * {set_rules}                      = formvalidation rules per table
     *
     */

    function _controller_text()
    {

        $html = '<?php if (! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 02.05.14
 * Time: 20:33
 * project: sparkplug
 * file: application/controllers/{ucf_controller}.php
 * adaption to twitter bootstrap 3, html5 form elements, serverside validation and xss sanitize
 */
class {ucf_controller} extends CI_Controller {

    private $table = \'{model}\';
    public function index() {
        redirect(\'{controller}/show_list\');
    }
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->model(\'{uc_model_name}\');
        $this->load->helper(array(\'form\',\'url\',\'security\'));
        $this->load->library(array(\'session\', \'pagination\', \'form_validation\',\'encrypt\'));

    }

    public function show_list() {

        $config[\'base_url\'] = $this->config->item(\'base_url\')."/{controller}/show_list";
        $config[\'total_rows\'] = $this->db->get("{model}")->num_rows();
        $config[\'per_page\'] = 10;
        $config[\'full_tag_open\'] = \'<ul id="pagination">\';
        $config[\'full_tag_close\'] = \'</ul>\';

        $config[\'next_link\'] = \'&gt;\';
        $config[\'prev_link\'] = \'&lt;\';
        //@todo search
        $segments_array = $this->uri->segment_array();//@change

        $filter_by = false;//@change
        $filter_value = false;//@change
        $direction = false;//@change
        switch ($this->uri->total_segments()) {
            case 3:
            case 4:
                $direction = xss_clean($this->input->post(\'direction\',true));//@change
                $filter_by= xss_clean($this->input->post(\'filter_by\',true));//@change
                $filter_value = xss_clean($this->input->post(\'filter_value\',true));//@change
                $offset = xss_clean($segments_array[2]);
                break;
            default:
                $offset = 1;
                break;
        }
        $this->pagination->initialize($config);
        $data[\'results\'] = $this->{uc_model_name}->get_all("{model}",$config[\'per_page\'],$offset, $filter_by, $filter_value, $direction);//@change

        $index = 0;
        if(!isset($data["results"][0]["id"])) {
            foreach($data["results"] as $row) {
                //add record primary key assigned to id
                $data["results"][$index]["id"] = current($row);
                $index++;
            }
        }
        //@todo end search
        $this->load->view(\'header\');
        $this->load->view(\'{view_folder}/list\', $data);
        $this->load->view(\'footer\');
    }

    public function show($id) {
        $data[\'result\'] = $this->{uc_model_name}->get($id);

        if(!isset($data["result"]["id"])) {
            foreach($data["result"] as $row) {
                //add record primary key assigned to id
                $data["result"]["id"] = current($row);
            }
        }

        $this->load->view(\'header\');
        $this->load->view(\'{view_folder}/show\', $data);
        $this->load->view(\'footer\');
    }

    public function new_entry() {

        {set_rules}

        if ($this->form_validation->run() == FALSE) {

                    $this->load->view(\'header\');
                    $this->load->view(\'{view_folder}/new\');
                    $this->load->view(\'footer\');
        } else {
                    redirect(\'{controller}/show_list\');
       }
    }

    public function create() {

        {set_rules}
        if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata(\'msg\', \'Error\');
                $this->load->view(\'header\');
                $this->load->view(\'{view_folder}/new\');
                $this->load->view(\'footer\');
            } else {
                $this->{uc_model_name}->insert();
                $this->session->set_flashdata(\'msg\', \'Entry Created\');
                redirect(\'{controller}/show_list\');
            }
    }

    public function edit($id) {

        $res = $this->{uc_model_name}->get($id);
        $data["result"] = $res[0];
        if(!isset($data["result"]["id"])) {
            foreach($data["result"] as $row) {
                //add record primary key assigned to id
                $data["result"]["id"] = $row[0];
            }
        }
        {set_rules}

        if ($this->form_validation->run() == FALSE) {
                    $this->load->view(\'header\');
                    $this->load->view(\'{view_folder}/edit\', $data);
                    $this->load->view(\'footer\');
        } else {
                    redirect(\'{controller}/show_list\');
        }
    }

    public function update() {
        {set_rules}

        $id = (int) xss_clean($this->input->post(\'id\'));
        if ($this->form_validation->run() == FALSE)
        {
            $res = $this->{uc_model_name}->get($id);
            $data["result"] = $res[0];

            $this->session->set_flashdata(\'msg\', \'Error\');
            $this->load->view(\'header\');
            $this->load->view(\'{view_folder}/edit\', $data);
            $this->load->view(\'footer\');
        }
        else
        {
            $this->{uc_model_name}->update($id);
            $this->session->set_flashdata(\'msg\', \'Entry Updated\');
            redirect(\'{controller}/show_list\');
        }
    }

    public function delete($id) {
        $this->{uc_model_name}->delete($id);

        $this->session->set_flashdata(\'msg\', \'Entry Deleted\');
        redirect(\'{controller}/show_list\');
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
}';

        return $html;
    }

    /**
     * Model Template - Tags:
     *
     * {model_name}                    = $this->model_name (by default: {uc_model_name}
     * {table}                        = table name
     * {variables}                    = variable initilizations
     * {set_variables_from_post}    = all variables set equal to their POST counterparts
     *
     */

    function _model_text()
    {
        return '<?php
     if (! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');
     /*
     * User: ps
     # copyright 2014 keepitnative.ch, io, all rights reserved to the author
     * Date: 02.05.14
     * Time: 20:33
     * project: sparkplug
     * file: application/models/{ucf_controller}.php
     * adaption to twitter bootstrap 3, html5 form elements, serverside validation and xss sanitize
     */

    class {model_name} extends CI_Model {
        {variables}

        public function {model_name}() {
            parent::__construct();
            $this->load->helper(array("security"));
            $this->load->library(array("encrypt"));
        }

        public function getPrimaryKeyFieldName() {
            $fields = $this->db->field_data("' . $this->table . '");

            $primary_key_name = $fields[0]->name;
            return $primary_key_name;
        }

        public function insert() {
            {set_variables_from_post}

            $this->db->insert(\'{table}\', $this);
        }

        public function get($id) {
            $id = (int) $id;
            $primary_key = $this->getPrimaryKeyFieldName();

            $query = $this->db->get_where(\'{table}\', array("$primary_key" => (int) xss_clean($id)));
            return $query->result_array();
        }

        public function get_all($table="{table}", $limit_per_page=10, $offset_limit=1, $filter_by, $filter_value, $direction ) {//@todo search

            $this->db->limit($limit_per_page, $offset_limit);
            //@todo search
            if( $filter_by!=false && $filter_value != false && $direction != false ) {
                $this->db->like($filter_by, strtolower($filter_value));//@change
                $this->db->order_by($filter_by, $direction);//@change
            }
            //@todo search end
            $query = $this->db->get(\'{table}\');
            return $query->result_array();
        }

        public function get_field_data() {
            return $this->db->field_data(\'{table}\');
        }

        public function update() {
            {set_variables_from_post}

            $primary_key = $this->getPrimaryKeyFieldName();

            $this->db->set($this);
            $this->db->where( "$primary_key" ,$this->$primary_key);//@FIMXE sec? $this->$primary_key
            $this->db->update(\'{table}\', $this);
        }

        public function delete($id) {
            $id = (int) $id;
            $primary_key = $this->getPrimaryKeyFieldName();
            $this->db->delete(\'{table}\', array("$primary_key" => xss_clean($id)));
        }
}';
    }
    /**
     * View Templates
     *
     * {controller} = current controller
     * {form_fields_create} = Empty form entry fields for all database fields
     * {form_fields_update} = Filled in form entry fields for all database fields
     */

    /* INDEX */
    function _index_view()
    {

        return "You should not see this after scaffolding - index controller redirect by default.";

    }

    /* LIST */
    function _list_view()
    {
        return
            '<h1>List ' . (string)$this->table . '</h1>
            <p>
            <?php
            if ($this->session->flashdata("msg") != ""):
            ?>
            <div class="alert alert-success has-error has-feedback">
            <?= $this->session->flashdata("msg") ?>
            <span class="alert glyphicon glyphicon-ok"></span>
            </div>
            <?php endif; ?>
            </p>
            <div class="table-responsive">
            <table class="table table table-bordered table-striped table-hover">
                <tr>
            <?php
            $options_select = array();
            if(count($results) != 0) :
            foreach(array_keys($results[0]) as $key):
                $options_select[$key] = ucfirst($key);//@todo search
            ?>
                <th><?= ucfirst($key) ?></th>
            <?php endforeach;
            endif;
            ?>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
            </tr>
                <p>Apply a filter</p>
            <?php
            //@change foreach fields
            $js = \'
                this.onclick = function() {
                    document.searchForm.submit();
                };
            \';
            $options = array(
                \'name\'=> \'searchForm\',
                 \'formnovalidate\'=>\'formnovalidate\'
                 );
            echo form_open(\'{controller}/show_list/10/filter\',$options);
            ?>
            <div class=\'col-lg-2 col-md-2 col-sm-12\'>
            <p>
                <?php
                    echo form_dropdown(\'filter_by\', $options_select, "", \'class="form-control"\');
                ?>
            </p>
                </div>
            <div class="col-lg-2 col-md-2 col-sm-12">
            <p>
            <?php
            //@todo search
            $options_search_field = array(
                \'name\'=>\'filter_value\',
                \'id\'=>\'filter_value\',
                \'value\'=> xss_clean($this->input->post(\'filter_value\')),
                \'maxlength\'=>20,
                \'size\'=>50,
                \'style\'=>\'width:100%\',
                \'class\'=>\'form-control\',
                \'placeholder\'=>\'filter_value\'
            );
            echo form_input($options_search_field);
            ?>
            </p>
                </div>
            <p>
            <div class=\'col-lg-2 col-md-2 col-sm-12\'>
            <div class=\'radio\'>
                <label for=\'direction01\'>
                <?php
                //@todo change
                $options_radio_direction01 = array(
                    \'name\'=>\'direction\',
                    \'id\' =>\'direction01\',
                    \'value\'=>\'ASC\',
                    \'checked\'=>true,
                    \'style\' =>\'margin-right:0px;\'
                );
                    echo form_radio($options_radio_direction01);
                ?>
                order asc.
                </label>
                </div>
                </div>


            <div class=\'col-lg-2 col-md-2 col-sm-12\'>
            <div class=\'radio\'>
                <label for="direction02">
            <?php
            //@todo change
                $options_radio_direction02 = array(
                    \'name\'=>\'direction\',
                    \'id\' =>\'direction02\',
                    \'value\' => \'DESC\',
                    \'checked\' => false,
                    \'style\'=>\'margin-right:0px;\'
                );
            echo form_radio($options_radio_direction02);
            ?>
                    order desc.
                </label>
                </div>
                </div>
            <p>
                <div class=\'col-lg-2 col-md-2 col-sm-12\'\>
                <?php
                    echo form_submit(\'submit\', \'Search\', "formnovalidate  class=\'btn btn-md btn-default btn-block\'");
                ?>
                </div>
            </p>
            <p>
                <div class=\'col-lg-2 col-md-2 col-sm-12\'\>
            <?php
               echo form_submit(\'reset\', \'Reset search\',\'formnovalidate="formnovalidate", id="reset" class="btn btn-md btn-default btn-block"\');
            ?>
                </div>
            </p>
            <?php
            form_close();
            //@todo end search
?>
<?
if(count($results) != 0) :
foreach ($results as $row):
    ?>
    <tr>
    <? foreach ($row as $field_value): ?>
        <td><?= $field_value ?></td>
    <? endforeach; ?>
        <td> <?= anchor("{controller}/show/".$row[\'id\'], \'View\', "class=\'btn btn-sm btn-success\'") ?></td>
        <td> <?= anchor("{controller}/edit/".$row[\'id\'], \'Edit\', "class=\'btn btn-sm btn-warning\'") ?></td>
        <td> <?= anchor("{controller}/delete/".$row[\'id\'], \'Delete\', "class=\'btn btn-sm btn-danger\'") ?></td>
    </tr>
<? endforeach;
endif;
?>
</table>
<br />
    <?= $this->pagination->create_links();?>
    <br />
</div><br />
<div class="col-lg-4 col-md-4 col-sm-12">
<?= anchor("{controller}/new_entry", "New", "class=\'btn btn-lg btn-default btn-block\'") ?>
</div>
';
    }

    /* SHOW */
    function _show_view()
    {
        return
            '<h1>Show ' . (string)$this->table . '</h1>
<? foreach ($result[0] as $field_name => $field_value): ?>
<p>
    <b><?= ucfirst($field_name) ?>:</b> <?= $field_value ?>
</p>
<? endforeach; ?>
<?= anchor("{controller}/show_list", "Back", "class=\'btn btn-lg btn-default btn-block\'") ?>';
    }

    /* EDIT */
    function _edit_view()
    {
        return
            '<h1>Edit ' . (string)$this->table . '</h1>
<? if (validation_errors() != ""): ?>
    <div class="alert alert-danger has-error has-feedback">
        <span class="alert glyphicon glyphicon-warning-sign"></span>
        <?php
        if ($this->session->flashdata("msg") != ""):
            ?>

            <div style="display:block;float: left;width:60%">
                <h3><?= $this->session->flashdata("msg") ?></h3>
            </div>
        <?php endif; ?>
        <div style="display:block;float: left;width:60%">
            <?= validation_errors(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>
<?php echo form_open(\'{controller}/update/\',\'formnovalidate=formnovalidate\'); ?>
{form_fields_update}
<p>
    <?= form_submit(\'submit\', \'Update\', "formnovalidate  class=\'btn btn-lg btn-default btn-block\'") ?>
</p>
<?= form_close() ?>
<?= anchor("{controller}/show_list", "Back", "class=\'btn btn-lg btn-default btn-block\'") ?>';
    }

    /* NEW */
    function _new_view()
    {
        return
            '<h1>New ' . (string)$this->table . '</h1>
 <? if (validation_errors() != ""): ?>
    <div class="alert alert-danger has-error has-feedback">
        <span class="alert glyphicon glyphicon-warning-sign"></span>
        <?php
        if ($this->session->flashdata("msg") != ""):
            ?>

            <div style="display:block;float: left;width:60%">
                <h3><?= $this->session->flashdata("msg") ?></h3>
            </div>
        <?php endif; ?>
        <div style="display:block;float: left;width:60%">
            <?= validation_errors(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>
<?= form_open(\'{controller}/create\',"formnovalidate") ?>
{form_fields_create}
<p>
    <?= form_submit(\'submit\', \'Create\', "formnovalidate  class=\'btn btn-lg btn-default btn-block\'") ?>
</p>
<?= form_close() ?>
<?= anchor("{controller}/show_list", "Back", "class=\'btn btn-lg btn-default btn-block\'") ?>';
    }
}
