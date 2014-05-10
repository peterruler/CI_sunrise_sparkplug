<?php

class Directory_helper_test extends CI_TestCase {

	public function set_up()
	{
		$this->helper('directory');

        org\bovigo\vfs\vfsStreamWrapper::register();
        org\bovigo\vfs\vfsStreamWrapper::setRoot(new \org\bovigo\vfs\vfsStreamDirectory('testDir'));

		$this->_test_dir = org\bovigo\vfs\vfsStreamWrapper::getRoot();
	}

	public function test_directory_map()
	{
		$ds = DIRECTORY_SEPARATOR;

		$structure = array(
			'libraries' => array(
				'benchmark.html' => '',
				'database' => array('active_record.html' => '', 'binds.html' => ''),
				'email.html' => '',
				'0' => '',
				'.hiddenfile.txt' => ''
			)
		);

        org\bovigo\vfs\vfsStream::create($structure, $this->_test_dir);

		// is_dir(), opendir(), etc. seem to fail on Windows + org\bovigo\vfs\vfsStream when there are trailing backslashes in directory names
		if ( ! is_dir(org\bovigo\vfs\vfsStream::url('testDir').DIRECTORY_SEPARATOR))
		{
			$this->markTestSkipped("Can't test this under Windows");
			return;
		}

		// test default recursive behavior
		$expected = array(
			'libraries'.$ds => array(
				'benchmark.html',
				'database'.$ds => array('active_record.html', 'binds.html'),
				'email.html',
				'0'
			)
		);

		$this->assertEquals($expected, directory_map(org\bovigo\vfs\vfsStream::url('testDir')));

		// test detection of hidden files
		$expected['libraries'.$ds][] = '.hiddenfile.txt';

		$this->assertEquals($expected, directory_map(org\bovigo\vfs\vfsStream::url('testDir'), 0, TRUE));

		// test recursion depth behavior
		$this->assertEquals(array('libraries'.$ds), directory_map(org\bovigo\vfs\vfsStream::url('testDir'), 1));
	}

}

/* End of file directory_helper_test.php */