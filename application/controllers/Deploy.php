<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deploy extends CI_Controller {
<<<<<<< HEAD
public function __construct()
{
	parent::__construct();
}
public function index() {
#$LOCAL_ROOT='/var/www/html';
$LOCAL_ROOT='D:/wamp/www/disgesis'	
$LOCAL_REPO_NAME="digesis.git";
=======

	public function __construct() {
		parent::__construct();

	}

	public function index() {

$LOCAL_ROOT='/var/www/digesis';
$LOCAL_REPO_NAME="digesis";
>>>>>>> a0175e26cc73a92d5376628a4dbf2d650a90e6d9
$LOCAL_REPO="{$LOCAL_ROOT}/$LOCAL_REPO_NAME";
$REMOTE_REPO="https://github.com/digesis2017/digesis.git";
$DESIRED_BRANCH="master";

if (file_exists($LOCAL_ROOT)){
	shell_exec("rm -rf {$LOCAL_REPO_NAME}");
}

if (file_exists($LOCAL_REPO)):
  echo shell_exec("cd {$LOCAL_REPO} && git pull");

else :  
  echo shell_exec("cd {$LOCAL_ROOT} && git clone {$REMOTE_REPO} {$LOCAL_REPO_NAME} && cd {$LOCAL_REPO} && git checkout {$DESIRED_BRANCH}");
endif;

date_default_timezone_set('America/Lima');
die("done " . date('Y-m-d h:i:s a', time()) . "\n"  ) ;


}
}
