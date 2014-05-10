<?php
 /*
 * User: ps
 # copyright 2014 keepitnative.ch, io, all rights reserved to the author
 * Date: 10.05.14
 * Time: 06:46
 * project: https_docs
 * file: ControllerTest.php
 */

class Controller_test extends CI_TestCase {

    public function testEmpty()
    {
        $stack = array();
        $this->assertEmpty($stack);
        return $stack;
    }
    /**
     * @depends testEmpty
     */
    public function testPush(array $stack)
    {
        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertNotEmpty($stack);
        return $stack;
    }
    /**
     * @depends testPush
     */
    public function testPop(array $stack)
    {
        $this->assertEquals('foo', array_pop($stack));
    }
}
 