<?php
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 17.05.14
 * Time: 12:39
 * project: https_docs
 * file: ListTest.php
 */

abstract class List_test extends PHPUnit_Extensions_Database_TestCase {
    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;
    function writeCSV() {
        $db =  $this->getConnection();
        $stmt = $db->prepare("select * from jobs");
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //$fp = fopen('fixtures/jobs.csv', 'w');

        foreach ($list as $fields) {
            //$success = fputcsv($fp, $fields);
        }
/*
        if($success == FALSE) {
            $this->fail("CSV couldn't be written");
        }
        fclose($fp);
        */
    }
    public function testController() {
        //require_once 'application/controllers/JobsController.php';
        //include_once 'system/core/Common.php';
        //include_once '/Users/Arbeit/var/www/myProject.01.proto.oauth.my/https_docs/system/core/Loader.php';
        //$this->loader = new CI_Loader();
        //$ctrl = new JobsController();
        //$actual = $ctrl->show_list();


        $db =  $this->getConnection();
        $stmt = $db->prepare("select * from jobs");
        $stmt->execute();
        $expected = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $actual = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
    }
    public function testCalculate()
    {
        $this->assertEquals(2, 1 + 1);
    }
    public function testDatabase()
    {
        $this->writeCSV();
        $this->assertEquals(2, 1 + 1);
        $this->assertEquals(2, 1 + 1);
    }
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        echo dirname(__FILE__).'/_files/guestbook-seed.xml';
        return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/guestbook-seed.xml');
    }
    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }
}