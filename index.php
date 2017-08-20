<!DOCTYPE html>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/86/three.js" type="text/javascript"></script>
	<script src="assets/STLLoader.js" type="text/javascript"></script>
	<script src="assets/OrbitControls.js" type="text/javascript"></script>
	<link rel="stylesheet" href="assets/styles.css" type="text/css">
</head>
<body>
<div class="container container-index">
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-3">
	<h2>Upload a file</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
	<label class="btn btn-primary btn-browse" for="stl-input">
    <input id="stl-input" name="stlUpload" type="file" style="display:none" 
    onchange="$('#upload-file-info').html(this.files[0].name)">
    Browse for a File
	</label>
  	<button type="submit" class="btn btn-default">Submit</button>
  	<span class='label label-info' id="upload-file-info"></span>
	</form>
	</div>
	<div class="col-md-1"></div>
	<div class="col-md-4">
	<h2>Use an Existing File</h2>
	<ul>
		<?php $target_dir = 'stl-uploads'; ?>
		<?php foreach(array_slice(scandir($target_dir), 2) as $f): ?>
		<li><a href="view.php?file=<?php echo $f; ?>"><span class="glyphicon glyphicon-folder-open"></span><?php echo $f; ?></a></li>
		<?php endforeach; ?>
	</ul>
	</div>
	<div class="col-md-2"></div>
</div>
</div>
</body>
</html>
