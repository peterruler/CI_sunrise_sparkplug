# Codeigniter crud/mvc generation

A changed version of the ci sunrise  (Codeigniter and twitter bootstrap 3)
and a changed version of the sparkplug, rails inspired crud scaffolding.


## DEPENDENCIES
* nodejs.org win/mac installer, [nodejs server](http://nodejs.org)
* run npm init
* run npm install
* run npm install -g bower --save-dev
* grunt: npm install -g grunt  --save-dev
* grunt: npm install -g grunt-cli  --save-dev
* or install with the sunrise script via ../shell.sh, to get grunt and bower installed
* compile the webpage via 'grunt' command

* composer, see [composer dependency manager](https://getcomposer.org/) for installation notes
* to install phpunit, run $php composer.phar install
* then for testing, run script via $php tests/run
* alternatively usage of [sparks Codeigniter package manager](http://getsparks.org/)

## Changes are
* ***[NEW]*** listview added per column ordering
* ***[COMMING SOON]*** hopefully some missing features,you're invited to contact me for help
* ***[BUGFIX]*** layout: fileupload success msg, layout escaping
* ***[BUGFIX]*** multi file upload something like file or path
* ***[BUGFIX]*** robust filefield recognition instead of non sanitized post filename and setter call construction
* ***[NEW]*** Fileupload for multiple files (plain old html fileupload), naming convention something like my%fileANDOR%path%NR
* ***[NEW]*** type tinyint for boolean radio buttons
* ***[NEW]*** On demand password reset with or without password hashing, fieldname must exactly be 'password'
* ***[NEW]*** hardcoded ID and use of getters and setters in model
* ***[BUGFIX]*** edit view update not working, post var not set
* twitter bootstrap 3 markup (buttons, alerts, tables, flashmessages, fixed navtop layout sample by twitter bootstrap)
* html5 form elements markup
* serverside validation
* xss cleanup
* simple header footer inclusion templating, (@todo using theme)
* dependency of fontawesome included

For the usage of getting the needed dependencies for CI_Sunrise see:
* see [CI_sunrise installatoin notes](https://github.com/sjlu/CodeIgniter-Sunrise/blob/master/README.md)

For the usage use of the generator see the original page:
* see [sparkplug documentation](https://code.google.com/p/sparkplug/wiki/Usage)

## License
### CodeIgniter Sunrise :
* MIT
* see [license agreement](https://github.com/peterruler/CI_sunrise_sparkplug/blob/master/MIT.txt)

## License
### Sparkplug :

* GNU/GPL v3
* see [license agreement](https://github.com/peterruler/CI_sunrise_sparkplug/blob/master/scaffolding/gpl-3.0.txt)

## License
### Codeigniter :
* Open Software License ("OSL") v 3.0
* see [license agreement](https://github.com/peterruler/CI_sunrise_sparkplug/blob/master/oslicense.txt)

## copyright to the original creators

* see [sparkplug src on google code](https://code.google.com/p/sparkplug/)
* see [CI_sunrise, installation src](https://github.com/sjlu/CodeIgniter-Sunrise)
* see [Codeigniter on github, dev version](https://github.com/EllisLab/CodeIgniter/)

##For writing unittests
* see [original codeigniter unittests](https://github.com/peterruler/CI_sunrise_sparkplug/blob/master/tests/README.md)

Many thanks to the original creators of codeigniter, sparkplug and ci sunrise

