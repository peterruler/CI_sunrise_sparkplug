<?php
set_include_path(get_include_path().":/Users/Arbeit/var/www/myProject.01.proto.oauth.my/http_docs/vendor/mikey179/vfsStream/src/main/php/org/bovigo/vfs");
function autoload2($class) {
    $class = str_replace("\\", "/", $class);
    $class = str_replace("org/bovigo/vfs/" , "" , $class);
    $filename = "../vendor/mikey179/vfsStream/src/main/php/org/bovigo/vfs/" . $class . ".php";
    //echo get_include_path(); echo $filename."\n";
    if (file_exists($filename)) {
        require_once($filename);
    }
}
spl_autoload_register('autoload2');

// Errors on full!
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

$dir = realpath(dirname(__FILE__));

// Path constants
defined('PROJECT_BASE') OR define('PROJECT_BASE', realpath($dir.'/../').'/');
defined('SYSTEM_PATH') OR define('SYSTEM_PATH', PROJECT_BASE.'system/');

// Get vfsStream either via PEAR or composer
foreach (explode(PATH_SEPARATOR, get_include_path()) as $path)
{
	if (file_exists($path.DIRECTORY_SEPARATOR.'vfsStream/vfsStream.php'))
	{
		require_once 'vfsStream/vfsStream.php';
		break;
	}


if ( ! class_exists('vfsStream') && file_exists(PROJECT_BASE.'vendor/autoload.php'))
{
	include_once PROJECT_BASE.'vendor/autoload.php';
	class_alias('org\bovigo\vfs\vfsStream', 'vfsStream');
	class_alias('org\bovigo\vfs\vfsStreamDirectory', 'vfsStreamDirectory');
	class_alias('org\bovigo\vfs\vfsStreamWrapper', 'vfsStreamWrapper');
}
}
// Define CI path constants to VFS (filesystem setup in CI_TestCase::setUp)


 defined('BASEPATH') OR define('BASEPATH', org\bovigo\vfs\vfsStream::url('system/'));
 defined('APPPATH') OR define('APPPATH', org\bovigo\vfs\vfsStream::url('application/'));

#defined('SYSDIR') OR define('SYSDIR', org\bovigo\vfs\vfsStream::url('system/'));

defined('VIEWPATH') OR define('VIEWPATH', APPPATH.'views/');
defined('ENVIRONMENT') OR define('ENVIRONMENT', 'development');

// Set localhost "remote" IP
isset($_SERVER['REMOTE_ADDR']) OR $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

// Prep our test environment
include_once $dir.'/mocks/core/common.php';
include_once SYSTEM_PATH.'core/Common.php';


if (extension_loaded('mbstring'))
{
	defined('MB_ENABLED') OR define('MB_ENABLED', TRUE);
	mb_internal_encoding('UTF-8');
	mb_substitute_character('none');
}
else
{
	defined('MB_ENABLED') OR define('MB_ENABLED', FALSE);
}

if (extension_loaded('iconv'))
{
	defined('ICONV_ENABLED') OR define('ICONV_ENABLED', TRUE);
	iconv_set_encoding('internal_encoding', 'UTF-8');
}
else
{
	defined('ICONV_ENABLED') OR define('ICONV_ENABLED', FALSE);
}

include_once SYSTEM_PATH.'core/compat/mbstring.php';
include_once SYSTEM_PATH.'core/compat/hash.php';
include_once SYSTEM_PATH.'core/compat/password.php';
include_once SYSTEM_PATH.'core/compat/array.php';

include_once $dir.'/mocks/autoloader.php';
// Name of the "vendor folder"

define('VENDORSDIR','vendor/');


spl_autoload_register('autoload');

require_once(SYSTEM_PATH.'libraries/Unit_test.php');
unset($dir);