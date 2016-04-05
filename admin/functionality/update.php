<?php
    session_start();

    $filepath=$_POST['filepath'];
    $markdown = fopen("$filepath", "w");

    fwrite($markdown, "---\n");
    foreach($_POST as $key => $value){
        if((strcmp($key,'current-image')!=0) && (strcmp($key,'image')!=0) && (strcmp($key,'filepath')!=0) && (strcmp($key,'content')!=0)){
            fwrite($markdown, $key.": ".$value."\n");
        }
    }

    if(isset($_FILES["image"])){
        move_uploaded_file($_FILES["image"]["tmp_name"],
        "../jekyll-cms/assets/img/" . $_FILES["image"]["name"]);
        $image_path = "assets/img/".$_FILES["image"]["name"];

        fwrite($markdown, "image: ".$image_path."\n");
    }else{
        fwrite($markdown, "image: ".$_POST['current-image']."\n");
    }

    fwrite($markdown, "---\n\n");

    if(isset($_POST['content'])){
        fwrite($markdown, $_POST['content']);
    }

    fclose($markdown);

    $_SESSION['dirty']=true;
?>
