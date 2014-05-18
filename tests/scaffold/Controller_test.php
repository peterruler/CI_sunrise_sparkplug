<?php
ob_start();
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 10.05.14
 * Time: 06:46
 * project: https_docs
 * file: ControllerTest.php
 */
//require_once 'Users/Arbeit/var/www/myProject.01.proto.oauth.my/http_docs/tests/vendor/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStream.php';
define("CONTROLLER",'JobsController');
define("BASE_URL","http://myproject.01.proto.oauth.my/");
define("TABLE",'jobs');

require_once 'application/controllers/'.CONTROLLER.'.php';
require_once 'system/core/Loader.php';

class Controller_test extends CI_TestCase {
    private $base_url = BASE_URL;
    private $load = null;
    private $ci_obj;
    private $controller = null;
    private $db = null;
    private $dbutil = null;
    private $conn = null;
    private static $pdo;
    /**
     * Header Redirect
     *
     * Header redirect in two flavors
     * For very fine grained control over headers, you could use the Output
     * Library's set_header() function.
     *
     * @access  public
     * @param   string  the URL
     * @param   string  the method: location or redirect
     * @return  string
     */
    function redirectNoExit($uri = '', $method = 'location', $http_response_code = 302)
    {

        if ( ! preg_match('#^https?://#i', $uri))
        {
            $uri = site_url($uri);
        }

        switch($method)
        {
            case 'refresh'  : header("Refresh:0;url=".$uri);
                break;
            default         : header("Location: ".$uri, TRUE, $http_response_code);
            break;
        }
    }
    public function set_up()
    {
        ob_start();
        // Set subclass prefix
        $this->prefix = 'MY_';
        $this->base_url = BASE_URL;
        $cfg =& $this->ci_core_class('cfg');
        /**
         * @todo vfc loader...
         */
        $loader = $this->ci_core_class('loader');
        $this->load = new $loader();
        $this->ci_obj = $this->ci_instance();

        //store controllerpath in classvar
        $this->controller = 'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.CONTROLLER.'.php';
        //genertate csv of db jobs table db
        $this->helper('file');
        $this->helper('url');
        $this->dbutil = new CI_DB_utility();
        $this->db = $this->DB_Mock();

        $query = $this->db->query("SELECT * FROM ".TABLE);
        $delimiter = ",";
        $newline = "\r\n";

        //$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        $data = 'foobar';
        $filepath = 'tests/scaffold/fixtures';
        if(!file_exists($filepath)) {
            @delete_files($filepath);
            @mkdir($filepath);
            @chmod($filepath,0777);
        }
        if ( ! file_put_contents($filepath.TABLE.'.csv', 'foobar\n'))
        {
            $this->fail('Unable to write the file') ;
        }
        else
        {
            echo 'File written!';
        }
        ob_end_clean();
        //generate jobs crud
        $this->redirectNoExit( $this->base_url.'SparkPlug/generateController/'.TABLE);

        $this->assertFileExists($this->controller);
    }
    public function JobsProvider()
    {
        return new CsvFileIterator('fixtures/'.TABLE.'.csv');
    }

    public function testControllerExists() {
        $this->assertFileExists('application/controllers'.DIRECTORY_SEPARATOR.CONTROLLER.'.php');
    }

    /**
    * @dataProvider JobsProvider
    */
    public function testList($expected='')
    {

        // Create library and extension in VFS
        $name = 'ext_test_lib';
        $lib = ucfirst($name);
        $class = 'CI_'.$lib;
        $class = CONTROLLER;
        $ext = $this->prefix.$lib;
        $this->ci_vfs_create($lib, '<?php class '.$class.' { }', $this->ci_base_root, 'libraries');
        $this->ci_vfs_create($ext, '<?php class '.$ext.' extends '.$class.' { }', $this->ci_app_root, 'libraries');

        $this->assertTrue(class_exists($class), $class.' does not exist');
        // Test loading as an array.
        //$this->assertInstanceOf('CI_Loader', $this->load->library(array($lib)));
        //$this->assertAttributeInstanceOf($class, $lib, $this->ci_obj);
        // Test a string given to params
        //$this->assertInstanceOf('CI_Controller', $this->load->library($lib));
        //$this->assertInstanceOf('CI_Controller', new JobsController);


        if(file_exists($this->controller)) {
            /*
            require_once( 'application/controllers/' . CONTROLLER . '.php');

            require_once( 'system/core/Loader.php');

            $this->load = new CI_Loader()

            // Instantiate a new loader
            $loader = $this->ci_core_class('loader');
            $this->load = new $loader();
            ;
            $controller = new JobsController();
            $method = 'show_list';
            $data = $controller->$method();

            $this->assertEquals($expected, $data);
            */
        } else {
            $this->fail('jobs controller not generated');
        }

    }
    function &DB_Mock($params = '', $active_record_override = NULL)
    {
            $config = Mock_Database_DB::config('mysqli');
            $connection = new Mock_Database_DB($config);
            $db = Mock_Database_DB::DB($connection->set_dsn('mysqli'), TRUE);

        return $db;
    }
    public function testController() {

        $db =  new PDO('mysql:host=localhost;dbname=proj01_02;unix_socket=/Applications/MAMP/tmp/mysql;charset=utf8', 'root', 'haus78', array(PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $stmt = $db->prepare("select * from jobs");
        $stmt->execute();
        $expected = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $actual = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
    }
    public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO('mysqli:host=127.0.0.1;dbname=proj01_02;unix_socket=/Applications/MAMP/tmp/mysql;charset=utf8', 'root', 'haus78');
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, 'proj01_02');
        }

        return $this->conn;
    }

}
