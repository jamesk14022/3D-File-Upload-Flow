<?php

$target_dir = 'stl-uploads/';
$target_file = $target_dir . basename($_FILES['stlUpload']['name']); 
$uploadOK = 1;
$fileType = pathinfo($target_file, PATHINFO_EXTENSION);

if($fileType != 'stl' && $fileType != 'STL'){
	$uploadOK = 0;
	echo nl2br("Only stl files can be uploaded. ");
}

if($uploadOK == 1){
	if(move_uploaded_file($_FILES['stlUpload']['tmp_name'], $target_file)){
		echo 'uploaded';
	}else{
		echo 'The file has failed to upload';
	}
}else{
	echo 'File has failed to upload.';
}

?>