
<?php 


$LOCAL_ROOT='/var/www/html';
$LOCAL_REPO_NAME="digesis.git";
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
?>
