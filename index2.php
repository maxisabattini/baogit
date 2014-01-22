<?php

include_once "bao/init.php";

$app = \baobab\App::getInstance();
$app->setPath( dirname(__FILE__) );

\baobab\Log::info("############################################################");
\baobab\Log::info("### Bao Sites Ajax Call");
\baobab\Log::info("############################################################");


$app->get("git-info", function($params){

  $site=$_REQUEST["site"];

  $dir="/var/www/html/$site";
  
  $command = "cd $dir; git config --get remote.origin.url";
  $url = shell_exec($command);  

  $branch="N/A";
  $command="cd $dir; git branch";
  
  $output=shell_exec($command);  
  $output=explode("\n", $output);
  
  $branches = array();
  foreach($output as $b){
  
    if(! $b){
      continue;
    } 
  
    if( substr($b, 0, 1) == "*"){
      $branch=trim(substr($b, 1));
      $branches[]=$branch;
    } else {
      $branches[]=trim($b);
    }
  }  
  
  $status = "clean";
  $status_details = "";
  $command = "cd $dir; git status --porcelain";  
  $output = shell_exec($command);
  if($output){
    $status = "modified";
    $status_details=$output;    
  }
  
  $info = array(
    "url" 		=> $url,
    "branch" 		=> $branch,
    "branches" 		=> $branches,
    "status"		=> $status,
    "status_details"	=> $status_details,
  );
  header('Content-type: application/json');
  echo json_encode($info, true);
  
});

$app->route();