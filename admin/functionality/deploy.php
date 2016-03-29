<?php
    session_start();
    set_time_limit (3600);

    define('JEKYLL_ROOT', $_SERVER['DOCUMENT_ROOT']."/admin/jekyll-cms/");
    define('ADMIN_ROOT', $_SERVER['DOCUMENT_ROOT']."/admin/");

    $deploy_command = 'export LD_LIBRARY_PATH=/opt/rh/mysql55/root/usr/lib64:/opt/rh/ror40/root/usr/lib64:/opt/rh/ruby200/root/usr/lib64 && export PATH=~/.gem/bin:/opt/rh/ruby200/root/usr/bin:$PATH && gem install bundle && cd '.JEKYLL_ROOT.' && bundle install && bundle exec jekyll build && cp _site/. ../.. -R && rm -rf _site';

    exec($deploy_command);

    $_SESSION['dirty']=false;
?>
