<?php
    require_once('../config.php');
    session_start();
    set_time_limit (3600);

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      $bash_install_dir = getenv('BASH_INSTALL_DIR');
      $deploy_command = 'cd ..\jekyll-cms && jekyll build && XCOPY _site\* ..\.. /s /i && rmdir /S /Q _site';
      echo $deploy_command;
      shell_exec($deploy_command);
    } else if (null !== OPENSHIFT_MYSQL_DB_HOST) {
      define('JEKYLL_ROOT', $_SERVER['DOCUMENT_ROOT']."/admin/jekyll-cms/");
      define('ADMIN_ROOT', $_SERVER['DOCUMENT_ROOT']."/admin/");

      $deploy_command = 'export LD_LIBRARY_PATH=/opt/rh/mysql55/root/usr/lib64:/opt/rh/ror40/root/usr/lib64:/opt/rh/ruby200/root/usr/lib64 && export PATH=~/.gem/bin:/opt/rh/ruby200/root/usr/bin:$PATH && gem install bundle && cd '.JEKYLL_ROOT.' && bundle install && bundle exec jekyll build && cp _site/. ../.. -R && rm -rf _site';
      exec($deploy_command);
    } else {
      $deploy_command = './script.sh';
      exec($deploy_command);
    }
    $_SESSION['dirty']=false;
?>
