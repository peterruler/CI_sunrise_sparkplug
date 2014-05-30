<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* User: ps
# copyright 2014 keepitnative.ch, io, all rights reserved to the author
* Date: 29.05.14
* Time: 18:35
* project: https_docs
* file: TestController.php
*/

class TestModelController extends CI_Controller
{
    //test if controllers there first

    //test if controller returns right value

    //test models with fixture data

    //test if sparkplug works right
    public $table = 'fixture_table';
    public $model = null;
    public $last_insert_id = null;
    public $id_field_name = null;
    public $fixture_data = array(
        0 => array(
            'my_id' => '1',
            'foo' => '112345',
            'bar' => 'batbuzbatbarbutfoo',
            'notes' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'is_active' => '0',
            'date01' => '2014:12:24 11:11:2014',
            'time01' => '2014:12:24 11:11:2014',
            'tel' => '+41 56 777 77 77',
            'notes01' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'notes02' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'email' => 'foo@batbar.com',
            'decimalnr' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'select_list' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'filepath1' => '/uploads/img1.jpg',
            'filepath2' => '/uploads/img2.jpg',
            'filepath' => '/uploads/img1.jpg',
            'psychopath' => '/uploads/img1.jpg'
        ),
        1 => array(
            'my_id' => '2',
            'foo' => '212345',
            'bar' => 'batbuzbatbarbutfoo',
            'notes' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'is_active' => '0',
            'date01' => '2014:12:24 11:11:2014',
            'time01' => '2014:12:24 11:11:2014',
            'tel' => '+41 56 777 77 77',
            'notes01' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'notes02' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'email' => 'foobat@bar.com',
            'decimalnr' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'select_list' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'filepath1' => '/uploads/img1.jpg',
            'filepath2' => '/uploads/img2.jpg',
            'filepath' => '/uploads/img1.jpg',
            'psychopath' => '/uploads/img1.jpg'
        ),
        2 => array(
            'my_id' => '3',
            'foo' => '312345',
            'bar' => 'batbuzbatbarbutfoo',
            'notes' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'is_active' => '0',
            'date01' => '2014:12:24 11:11:2014',
            'time01' => '2014:12:24 11:11:2014',
            'tel' => '+41 56 777 77 77',
            'notes01' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'notes02' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'email' => 'foobaz@foo',
            'decimalnr' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'select_list' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            /*'changed'=>'2014:12:24 11:11:2014',*/
            'filepath1' => '/uploads/img1.jpg',
            'filepath2' => '/uploads/img2.jpg',
            'filepath' => '/uploads/img1.jpg',
            'psychopath' => '/uploads/img1.jpg'
        ),
        3 => array(
            'my_id' => '4',
            'foo' => '312345',
            'bar' => 'batbuzbatbarbutfoo',
            'notes' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'is_active' => '0',
            'date01' => '2014:12:24 11:11:2014',
            'time01' => '2014:12:24 11:11:2014',
            'tel' => '+41 56 777 77 77',
            'notes01' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'notes02' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'email' => 'batbatfoo@bar',
            'decimalnr' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            'select_list' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
            /*'changed'=>'2014:12:24 11:11:2014',*/
            'filepath1' => '/uploads/img1.jpg',
            'filepath2' => '/uploads/img2.jpg',
            'filepath' => '/uploads/img1.jpg',
            'psychopath' => '/uploads/img1.jpg'
        ),
    );

    public function __construct($table='fixture_table')
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbutil();
        $this->load->helper(array('file','security'));
        $this->load->library(array('unit_test', 'session'));
        $this->model = new Fixture_table();
        foreach($this->fixture_data as $index => $value) :
            $this->fixture_data[$index]['password'] = $this->encrypt->sha1('12345');
        endforeach;
    }

    public function index($table='fixture_table')
    {
        $this->table = $table;
        /*
        $this->db->select("my_id");
        $query = $this->db->get($this->table);
        foreach ($query->result() as $row) {
            $last_insert_id = $row;
        }
        */
        //perform crud;
        $result = '';
        $result .= $this->setUp();
        $result .= $this->testCreateModel();
        $result .= $this->testReadModelById();
        $result .= $this->testReadModelAll();
        $result .= $this->testUpdateModel();
        $result .= $this->testDeleteModel();
        //$this->tearDown();
        echo $result;
    }

    public function setUp()
    {
        //insert fixture data to db
        $this->db->get('fixture_table');

        //first empty tables
        $this->tearDown();

        foreach ($this->fixture_data as $index => $value) :
            $this->db->insert($this->table, $this->fixture_data[$index]);
        endforeach;

        //scaffold crud logic

        //create fixtures csv
        $fields = $this->db->field_data($this->table);
        $names = array();
        foreach($fields as $field):
            $this->id_field_name = $fields[0]->name;
            $names[$field->name] = $field->name;
        endforeach;
        /*remove because changed field is always different timestamp on db change*/
        unset($names['changed']);

        $field_names = implode(', ',$names);
        $query = $this->db->query("SELECT $field_names FROM {$this->table}");

        $delimiter = ',';
        $newline = '\r\n';
        $test_db_data = /*$csv_data */
        $this->dbutil->csv_from_result($query, $delimiter, $newline);
        //file_put_contents('fixture_table-fixture.csv',$csv_data);
        file_put_contents('fixture_table.csv', $test_db_data);
        $test_data = $this->csv_to_array('fixture_table.csv', $delimiter);
        $expected_result = $this->csv_to_array('fixture_table-fixture.csv', $delimiter);
        $test_name = "check fixtures db table content";
        $result = $this->unit->run($test_data, $expected_result, $test_name);
        return $result;
    }

    function csv_to_array($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }

    public function testCreateModel()
    {
        $this->tearDown();

        foreach ($this->fixture_data as $index => $value) :
            $this->db->insert($this->table, $this->fixture_data[$index]);
        endforeach;

        $id = $this->db->insert_id();

        $table = $this->table;
        $limit_per_page = 10;
        $offset_limit = 1;
        $filter_by = $this->id_field_name;
        $filter_value = FALSE;
        $direction = "ASC";
        $test_data = $this->model->get_all($table, $limit_per_page, $offset_limit, $filter_by, $filter_value, $direction);
        $test = count($test_data);

        $expected_result = count($this->fixture_data)-1;
        $test_name = "Model Test insert id=".$id." expected=".$expected_result." test=".$test;
        $result = $this->unit->run($test, $expected_result, $test_name);
        return $result;
    }

    public function testReadModelById()
    {

        $id = 1;
        $expected_result = $this->model->get($id);

        $query = $this->db->get_where($this->table, array($this->id_field_name  => (int) xss_clean($id)));
        $test = $query->result_array();

        $test_name = "Model Test get($id)/id SELECT WHERE $this->id_field_name =".$id;

        $result = $this->unit->run($test, $expected_result, $test_name);
        return $result;
    }

    public function testReadModelAll()
    {
        $id = $this->last_insert_id;
        $this->model->get($id);

        $table = $this->table;
        $limit_per_page = 10;
        $offset_limit = 1;
        $filter_by = $this->id_field_name;
        $filter_value = FALSE;
        $direction = "ASC";
        $test_data = $this->model->get_all($table, $limit_per_page, $offset_limit, $filter_by, $filter_value, $direction);
        $test = count($test_data);

        $expected_result = count($this->fixture_data)-1;

        $test_name = "Model Test get_all(filter_value=false) SELECT * results: " . $test . " == " . $expected_result;

        $result = $this->unit->run($test, $expected_result, $test_name);
        return $result;
    }

    public function testUpdateModel()
    {
        $name = 'foo';
        $pass = $this->encrypt->sha1('12345');
        $email = 'donjuan@marco.de';
        $id=1;
        $date= '2014:12:12 14:14:14';
        $this->model->setMy_id($id);
        $this->model->setFoo('54321');
        $this->model->setBar($name);
        $this->model->setNotes($name);
        $this->model->setIs_active('1');
        $this->model->setDate01($date);
        $this->model->setTime01($date);
        $this->model->setTel($name);
        $this->model->setNotes01($name);
        $this->model->setNotes02($name);
        $this->model->setEmail($email);
        $this->model->setPassword($pass);
        $this->model->setDecimalnr($name);
        $this->model->setSelect_list($name);

        $this->model->setChanged($date);

        $this->model->setFilepath1($name);
        $this->model->setFilepath2($name);
        $this->model->setFilepath($name);
        $this->model->setPsychopath($name);

        $upload_data = null;

        $this->model->update($upload_data);
        $test = $this->db->affected_rows();
        $query = $this->db->get_where($this->table, array($this->id_field_name  => (int) xss_clean($id)));
        foreach($query->result_array() as $row) {
            $expected_result = $row['notes'];
        }
        if($expected_result =='foo') {
            $expected_result = 1;
        } else {
            $expected_result = 0;
        }
        $msg ="UPDATE ENTRY WHERE id=".$id;
        return $this->unit->run($test,$expected_result,$msg);;
        //$result = $this->db->get(1);//compare result foo
    }

    public function testDeleteModel()
    {

        $data = array(
        'my_id' => '',
        'foo' => '312345',
        'bar' => 'batbuzbatbarbutfoo',
        'notes' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
        'is_active' => '0',
        'date01' => '2014:12:24 11:11:2014',
        'time01' => '2014:12:24 11:11:2014',
        'tel' => '+41 56 777 77 77',
        'notes01' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
        'notes02' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
        'email' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
        'decimalnr' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
        'select_list' => '<foobar>12345</foobar>batbuzbatbarbutfoo',
        /*'changed'=>'2014:12:24 11:11:2014',*/
        'filepath1' => '/uploads/img1.jpg',
        'filepath2' => '/uploads/img2.jpg',
        'filepath' => '/uploads/img1.jpg',
        'psychopath' => '/uploads/img1.jpg'
        );
        $this->db->insert($this->table, $data);
        $id = $this->db->insert_id();
        $this->db->delete('fixture_table', array($this->id_field_name  => xss_clean($id)));

        $query = $this->db->get($this->table);
        $expected = count($query->result_array());
        $test = $this->db->count_all($this->table);
        $msg = "DELETE $this->table WHERE ID=".$id;
        return $this->unit->run($test,$expected,$msg);

    }

    public function tearDown() {
        $this->db->empty_table($this->table);
    }
} 