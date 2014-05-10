<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
echo "<h1>Sparkplug - Codeigniter CRUD scaffolding</h1>";
echo "<dl>";
for($index = 0; $index < count($tables); $index++ ) :
    echo "<dl><h3>";
    echo $tables[$index]->Tables_in_proj01_02;
    echo"</h3>";echo "<dl><dd>";
    echo "<a target='_blank' href='/SparkPlugCtrl/generateController/".$tables[$index]->Tables_in_proj01_02."'><button class='btn btn-warning'>generate!</button></a>";
    echo "<hr>";
    echo"</dd>";
endfor;
echo "</dl>";
?>