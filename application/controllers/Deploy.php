<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deploy extends CI_Controller {

	public function __construct() {
		parent::__construct();

	}

public function index() {

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
	echo 'paso2'."cd {$LOCAL_REPO} && git pull";
    echo shell_exec("cd {$LOCAL_REPO}");
    echo shell_exec("git pull");

else :  
  echo shell_exec("cd {$LOCAL_ROOT} && git clone {$REMOTE_REPO} {$LOCAL_REPO_NAME} && cd {$LOCAL_REPO} && git checkout {$DESIRED_BRANCH}");
echo "cd {$LOCAL_ROOT} && git clone {$REMOTE_REPO} {$LOCAL_REPO_NAME} && cd {$LOCAL_REPO} && git checkout {$DESIRED_BRANCH}";
endif;

date_default_timezone_set('America/Lima');
die("done " . date('Y-m-d h:i:s a', time()) . "\n"  );

}
}
