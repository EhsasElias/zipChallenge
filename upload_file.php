<?php


$files_dir = 'public/files/';
// print_r($_FILES);
$name_parts = explode(".",$_FILES['zip']["name"]);
$ext = end($name_parts);
$allwed_ext=array('zip');
if(in_array($ext,$allwed_ext)){
$new_file_name=time().".".$ext;
move_uploaded_file($_FILES['zip']["tmp_name"],$files_dir."/".$new_file_name);
echo "<h3 style='color:green;'> uploaded succefully</h3>";
  
$zip = new ZipArchive;
$res = $zip->open($files_dir."/".$new_file_name);
if ($res === TRUE) {
   $zip->extractTo($files_dir);
   $zip->close();
   echo 'extraction successful';
   unlink($files_dir."/".$new_file_name);
listFolderFiles($files_dir);
  
}

 else {
   echo 'extraction error';
   }
   
}
else{
    echo "<h3 style='color:red;'> file type is not allwed</h3>";
}




function listFolderFiles($dir){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;

    echo '<ol>';
    foreach($ffs as $ff){
        $name_parts = explode(".",$ff);
        $ext = end($name_parts);
        echo '<li>';
        if($ext == "png" || $ext == "jpeg" || $ext == "jpg"){
            echo $ff;

            echo'<img src="'.$dir.'/'.$ff.'" width="150" height="150">';
           
        }
        elseif($ext == "mp4"){
            echo $ff;

            echo '
            <video width="200" height="200" controls autoplay>
            <source src="'.$dir.'/'.$ff.'" type="video/mp4">
            </video>';
        }
        elseif($ext == "mp3" || $ext=="m4a"){
            echo $ff;

            echo '
            <audio controls autoplay>
            <source src="'.$dir.'/'.$ff.'" type="audio/ogg">
            
            </audio>';
        }
     

       elseif($ext == "js" || $ext=="php" || $ext == "ttf" || $ext=="css" || $ext == "pdf" || $ext=="docx"){
        echo $ff;

            $url = $dir.'/'.$ff;
            $file_name = basename($url);
   
    if (file_put_contents($file_name, file_get_contents($url)))
    {
        echo $url."File downloaded successfully";
    }
    else
    {
        echo $url."File downloading failed.";
    }
    }
    else{
        echo $ff;
    }

        if(is_dir($dir.'/'.$ff)) 
        listFolderFiles($dir.'/'.$ff);
        echo '</li>';
  
   }
    echo '</ol>';
}
?>