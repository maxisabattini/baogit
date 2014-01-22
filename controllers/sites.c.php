<?php

use \baobab\Controller;
use \baobab\Log;
use \baobab\App;

class SitesController extends Controller {

    public function __construct( $view, $params = array() ) {
        parent::__construct($view, $params);

	$path = realpath("/var/www/html") ;
	$path = realpath($path);

	$banned = array(
	".",
	"..",
	"tests",
	"temp",
	"bao",
	"tools",
	"bridge_common",
	"myadmin",
	"toefl.bridge.edu.max",
	"bridge.edu-max",
	);


	$sites=array();

	$dh = opendir($path);
	while( ( $file = readdir($dh) ) !== false ) {
	    $dir = "$path/$file";
	    
	    //if (  $file != "." &&  $file != ".." &&  $file != "tests" &&  $file != "temp" &&  $file != "bao" &&  $file != "bridge_common" && is_dir($dir)) {
	    
	    if( is_dir($dir) && ! in_array($file, $banned ) ) {    

		$entry = new stdClass();
		$entry->folder=$file;

		/*
		if($show_branch) {
		    $command = "cd $dir; git status | grep 'On branch' | cut -d ' ' -f 4";
		    $branch = shell_exec($command);
		    $entry->branch=$branch;        
		}
		*/

		$sites[]=$entry;
	    }
	}
	closedir($dh);
	
	usort($sites, function($a, $b){
		return strcmp($a->folder, $b->folder);
	});        
        
        $this->setVar("sites", $sites );
    }
}
