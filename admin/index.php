<?php
    define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST') . ':' . getenv('OPENSHIFT_MYSQL_DB_PORT'));
    define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
    define('DB_PASSWORD',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
    define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

    $db = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    define('ADMIN_ROOT', $_SERVER['DOCUMENT_ROOT']."/admin/");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Jekyll CMS</title>
        <link href='https://fonts.googleapis.com/css?family=Share+Tech+Mono' rel='stylesheet' type='text/css'>
        <link href="_/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="_/lib/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet">
        <link rel="stylesheet" href="_/lib/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="_/lib/sweetalert/dist/sweetalert.css">
        <link rel="stylesheet" href="_/css/index.css">
    </head>
    <body>
        <div id="ajax-loader" class="hidden"></div>
        <?php
            include(ADMIN_ROOT.'details.php');
            include(ADMIN_ROOT.'create.php');
            session_start();

            $user_check = $_SESSION['login_user'];

            $ses_sql = mysqli_query($db,"select admin_email from admin where admin_email = '$user_check' ");
            $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

            $login_session = $row['admin_email'];

            if(!isset($_SESSION['login_user'])){
                header("location: login.php");
            }
        ?>

        <div class="git-status">
            <a href="#" class="logout"><i class="fa fa-2x fa-sign-out"></i></a>
            <button type="button" disabled class="btn btn-default btn-deploy">Deploy</button>
            <div class="status-lights">
                <div><i class="status-green status-on fa fa-2x fa-circle"></i></div>
                <div><i class="status-red status-off fa fa-2x fa-circle"></i></div>
            </div>
        </div>

        <?php
            require ADMIN_ROOT.'_/composer/autoload.php';
            $markdowns=[];
            $parser = new Mni\FrontYAML\Parser();

            $document = $parser->parse(file_get_contents(ADMIN_ROOT.'system.conf'));
            $yaml = $document->getYAML();
            $trimmed = str_replace(' ', '', $yaml['collections']);
            $collections=explode(",", $trimmed);

            foreach($collections as $collection){
                $jekyll_dir = new DirectoryIterator(ADMIN_ROOT.'jekyll-cms/_'.$collection);
        ?>

            <div class="collection container">
                <h1><?php echo $collection?> items
                    <a href="#" data-toggle="modal" data-target="#create-modal" class="new-markdown pull-right">
                        <i class="fa fa-plus"></i>
                    </a>
                </h1>

            <?php
                foreach ($jekyll_dir as $fileinfo) {
                    if($fileinfo->isDot())
                        continue;
                    $jekyll_file = file_get_contents($fileinfo->getPathname());
                    $document = $parser->parse($jekyll_file);
                    $yaml = $document->getYAML();
                    $content = $document->getContent();

                    $markdowns[$fileinfo->getPathname()]=[];
                    $markdowns[$fileinfo->getPathname()]['front-matter']=$yaml;
                    $markdowns[$fileinfo->getPathname()]['content']=$content;
            ?>

                <div class="row" path="<?php echo $fileinfo->getPathname(); ?>">
                    <div class="col-md-6"><?php echo $fileinfo->getFilename(); ?></div>
                    <div class="col-md-6">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            <button type="button" data-toggle="modal" data-target="#markdown-modal" class="btn btn-default">Update</button>
                            <button type="button" class="btn btn-default btn-delete">Delete</button>
                        </div>
                    </div>
                </div>
                <hr>

            <?php
                }
            ?>

            </div>

        <?php
            }
            $_SESSION['markdowns'] = $markdowns;
        ?>

        <script src="_/lib/jquery/dist/jquery.min.js"></script>
        <script src="_/lib/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="_/lib/bootstrap-fileinput/js/fileinput.min.js"></script>
        <script src="_/lib/sweetalert/dist/sweetalert.min.js"></script>
        <script src="_/js/index.js"></script>
    </body>
</html>
