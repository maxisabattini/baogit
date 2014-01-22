<?php

$pages = array(

	"*"	=> array(
	  "title"     => "BAO Sites",
	  "cache"     => false,
	  "rewrite"   => true,
	  "packed"    =>  true,
	),

	//HOME
	
	"/"	=>	array(
	  "page" => "sites",
	  "title" => "BridgeVirtual - Online TOEFL iBT Prep Course Features",
	  "meta_description"	=> "Master the test with our Online TOEFL iBT Prep Course powered by BridgeVirtual. Sign up today!",
	  "meta_keywords"	=> "online toefl ibt prep course, toefl prep course",
	),
    
);

include_once "bao/init.php";

$app = \baobab\App::getInstance();
$app->setPath( dirname(__FILE__) );

\baobab\Log::info("############################################################");
\baobab\Log::info("### Bao Sites");
\baobab\Log::info("############################################################");
$app->route($pages);

