<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deploy extends CI_Controller {

	public function __construct() {
		parent::__construct();

	}

public function index() {

$LOCAL_ROOT='/var/www/digesis';
$LOCAL_REPO_NAME="digesis";
$LOCAL_REPO="{$LOCAL_ROOT}/{$LOCAL_REPO_NAME}";
$REMOTE_REPO="https://github.com/digesis2017/digesis.git";
$DESIRED_BRANCH="master";

if (file_exists($LOCAL_ROOT)){
	echo 'paso1';
	shell_exec("rm -rf {$LOCAL_REPO_NAME}");
}

if (file_exists($LOCAL_REPO)):
	echo 'paso2';
  echo shell_exec("cd {$LOCAL_REPO} && git pull");

else :  
  echo shell_exec("cd {$LOCAL_ROOT} && git clone {$REMOTE_REPO} {$LOCAL_REPO_NAME} && cd {$LOCAL_REPO} && git checkout {$DESIRED_BRANCH}");
echo 'paso3';
endif;

date_default_timezone_set('America/Lima');
die("done " . date('Y-m-d h:i:s a', time()) . "\n"  ) ;


}
}
