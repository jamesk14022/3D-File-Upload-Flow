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
<div class="container">
<div class="row">
	<div class="col-md-3"><img src="assets/v3d.png" class="img-responsive img-branding" /></div>
	<div class="col-md-9"></div>
</div>
<hr>
</div>
<div class="container container-index main">
<div class="row form-group index-steps">
    <div class="col-xs-12">
        <ul class="nav nav-pills nav-justified thumbnail setup-panel">
            <li class="active"><a href="#step-1">
                <h4 class="list-group-item-heading">Step 1</h4>
                <p class="list-group-item-text">Upload a 3D File</p>
            </a></li>
            <li class="disabled"><a href="#step-2">
                <h4 class="list-group-item-heading">Step 2</h4>
                <p class="list-group-item-text">Select Print Options</p>
            </a></li>
            <li class="disabled"><a href="#step-3">
                <h4 class="list-group-item-heading">Step 3</h4>
                <p class="list-group-item-text">Enter Your Details</p>
            </a></li>
        </ul>
    </div>
</div>
  
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-3 upload-box">
		<div id="upload">
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
			<p>We accept .stl and .obj file types, <a>contact us</a> for a quote otherwise.</p> 
		</div>
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

<div class="container container-tabs">
<!-- information tabs --> 
<div class="row">
	<ul class="nav nav-tabs" role="tablist" id="myTabs">
		<li role="presentation" class="active"><a href="#quote-tab" aria-controls="printability" role="tab" data-toggle="tab">Quoting</a></li>
	    <li role="presentation"><a href="#materials-tab" aria-controls="materials" role="tab" data-toggle="tab">Materials</a></li>
	    <li role="presentation"><a href="#printability-tab" aria-controls="printability" role="tab" data-toggle="tab">Printability</a></li>
  	</ul>

  	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="quote-tab">
			<div class="row quote">
			<div class="col-md-5 col-md-offset-1"><img src="assets/quote-vector.png" class="img-responsive"></div>
			<div class="col-md-5">
				<h2>Your 3D Printing Quote</h2>
				<ul>
					<li><span class="glyphicon glyphicon-check"></span>Based on Bounding Box Volume</li>
					<li><span class="glyphicon glyphicon-check"></span>Select Material Type and Colour</li>
					<li><span class="glyphicon glyphicon-check"></span>Extras such as Smoothing, Polishing</li>
					<li><span class="glyphicon glyphicon-check"></span>True to Style Colour Simulation</li>
				</ul>
			</div>
			<div class="col-md-1"></div>
		</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="materials-tab">
			<div class="row">
				<div class="col-md-3 col-xs-4">
					<div class="material-pane">
						<h3>ABS</h3><img src="assets/abs.png" class="img-responsive">
						<ul>
							<li>Petroleum-­based Polymer</li>
							<li>Available in a large array of colours</li>
							<li>Mechanically strong</li>
							<li>Long lifespan</li>
						</ul>
					</div>
				</div>
				<div class="col-md-3 col-xs-4">
					<div class="material-pane">
						<h3>PLA</h3><img src="assets/pla.png" class="img-responsive">
						<ul>
							<li>Made from renewable resources</li>
							<li>Slightly flexible</li>
							<li>Smoother Surface</li>
							<li>Not as sturdy</li>
						</ul>
					</div>
				</div>
				<div class="col-md-3 col-xs-4">
					<div class="material-pane">
						<h3>Nylon</h3><img src="assets/nylon.png" class="img-responsive">
						<ul>
							<li>Strong and Flexible Plastic</li>
							<li>UV and chemical resistance</li>
							<li>Produces smooth prints</li>
							<li>Needs to be kept dry</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="printability-tab">Printability</div>
	</div>
</div>

<!-- end information tabs  -->

<!-- footer -->
<hr id="footer-sep">
<ul id="footer-links">
	<li><a href="">PrintWorks</a></li>
	<li><a href="">Contact PrintWorks</a></li>
</ul>
</div>
<script type="text/javascript">
	$(document).ready( function(){
		$('#myTabs a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	})
	});
</script
</body>
</html>

