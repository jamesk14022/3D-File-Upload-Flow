<!DOCTYPE html>
<?php 
	$file_name = $_GET['file'];
	$target_dir = 'stl-uploads/';

	$target_file = $target_dir . basename($file_name); 

	$file_size = fileSizeConvert(fileSize($target_file));
	$file_extension = pathinfo($target_file, PATHINFO_EXTENSION);

	$model_volume = '';

	function fileSizeConvert($bytes){
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem){
        if($bytes >= $arItem["VALUE"]){
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    	return $result;
	}
?>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/86/three.js" type="text/javascript"></script>
	<script src="assets/STLLoader.js" type="text/javascript"></script>
	<script src="assets/OBJLoader2.js" type="text/javascript"></script>
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
<div class="container main">
<div class="row"><div class="col-md-12 top-bar"><button class="btn btn-secondary btn-back"><a href="index.php"><span class="glyphicon glyphicon-chevron-left"></span>Upload a Different Model</a></button></div>
<div class="row form-group">
    <div class="col-xs-12">
        <ul class="nav nav-pills nav-justified thumbnail setup-panel">
            <li class="disabled"><a href="#step-1">
                <h4 class="list-group-item-heading">Step 1</h4>
                <p class="list-group-item-text">Upload a 3D File</p>
            </a></li>
            <li class="active"><a href="#step-2">
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
<div class="col-md-6 col-sm-12 col-left">
<div id="canvas-section">
<canvas id="stl-canvas"></canvas>
</div>
<p id="lbl-unit">Model Unit: </p>
<label class="radio-inline"><input type="radio" name="optradio" value="mm" onchange="changeUnit('mm'); changePrice();" checked>mm</label>
<label class="radio-inline"><input type="radio" name="optradio" value="cm" onchange="changeUnit('cm'); changePrice();">cm</label>
<label class="radio-inline"><input type="radio" name="optradio" value="inches" onchange="changeUnit('inches'); changePrice();">inches</label>
<p id="lbl-controls">Left mouse - orbit / right mouse - pan / scroll wheel - zoom</p>
<script>
	
	function getPrice(units, volume, factor, speedyDelivery, polishing){
		//this method is designed to be quite flexible - for this reason,
		//factor, which volume type to use are both set in changePrice()
		//material type isnt needed as factor is dependant on it

		// units will be mm, cm or i
		//method for determining model price - this will vary between beareuas
		//factor is essentially price per cm^3

		var price;
		var speedyDeliveryPrice = 5;
		var polishingPrice = 5;

		console.log( units );

		//standardise units to cm
		if(units != 'cm'){
			if(units == 'mm'){
				volume = volume * 0.001;	
			}else if(units == 'inches'){
				volume = volume * 16.3871;
			}
		}

		price = volume * factor; 

		if(speedyDelivery){
			price = price + speedyDeliveryPrice;
		}
		if(polishing){
			price = price + polishingPrice;
		}

		return price;
	}	

	function changePrice(){

		var price;
		var polishing = false;
		var speedyDelivery = false;

		if(document.getElementById('checkbox-polished').checked == true){
			polishing = true;
		}
		if(document.getElementById('checkbox-delivery').checked == true){
			speedyDelivery = true;
		}

		var units = document.getElementById('unitField').value;
		//set to use boundingboxvolume
		var volume = document.getElementById('volume-box').innerHTML;


		if(document.getElementById('material-abs').checked == true){
			price = getPrice(units, volume, 1.2, speedyDelivery, polishing);
		}
		if(document.getElementById('material-sls').checked == true){
			price = getPrice(units, volume, 1.4, speedyDelivery, polishing);
		}
		if(document.getElementById('material-resin').checked == true){
			price = getPrice(units, volume, 1.5, speedyDelivery, polishing);
		}

		document.getElementById('price').innerHTML = Math.round(price);
		document.getElementById('priceHiddenField').value = Math.round(price);
	}

	function changeUnit(unit){
		var unitElements = document.getElementsByClassName('units');
		var arLength = unitElements.length;
		for (var i = 0; i < arLength; i++) {
		    unitElements[i].innerHTML = unit;
		}

		document.getElementById('unitField').value = unit;
	}

	function geoFromOBJ(){

		<?php if($file_extension == 'obj'  || $file_extension == 'OBJ'): ?>

		<?php
			include('tools/OBJAnalysis.php');
			$obj = new OBJAnalysis( 'stl-uploads/' . $file_name ); 
			$obj->readOBJGeometry();
		?>

		var geometry = new THREE.Geometry();

		geometry.vertices.push(
			<?php $i = 0; ?>
			<?php foreach($obj->faces() as $array): ?>
				new THREE.Vector3( <?= $array[0] ?>,  <?= $array[1] ?>, <?= $array[2] ?> )
				<?php if($i != count($obj->faces())): ?>
					,
				<?php endif; ?>
			<?php endforeach;?>
		);

		geometry.faces.push(
			<?php $i = 0; ?>
			<?php foreach($obj->faces() as $array): ?>
				new THREE.Face3( <?= $array[0] ?>, <?= $array[1] ?>, <?= $array[2] ?> )
				<?php if($i != count($obj->faces())): ?>
					,
				<?php endif; ?>
			<?php endforeach; ?>
		);

		return geometry;
		<?php endif; ?>
	}

	function volumeOfT(p1, p2, p3){
	    var v321 = p3.x*p2.y*p1.z;
	    var v231 = p2.x*p3.y*p1.z;
	    var v312 = p3.x*p1.y*p2.z;
	    var v132 = p1.x*p3.y*p2.z;
	    var v213 = p2.x*p1.y*p3.z;
	    var v123 = p1.x*p2.y*p3.z;
	    return (-v321 + v231 + v312 - v132 - v213 + v123)/6.0;
	}

	function calculateVolume(geo, type){
	    var volumes = 0.0;

	    for(var i = 0; i < geo.faces.length; i++){
	        var Pi = geo.faces[i].a;
	        var Qi = geo.faces[i].b;
	        var Ri = geo.faces[i].c;

	        var P = new THREE.Vector3(geo.vertices[Pi].x, geo.vertices[Pi].y, geo.vertices[Pi].z);
	        var Q = new THREE.Vector3(geo.vertices[Qi].x, geo.vertices[Qi].y, geo.vertices[Qi].z);
	        var R = new THREE.Vector3(geo.vertices[Ri].x, geo.vertices[Ri].y, geo.vertices[Ri].z);
	        volumes += volumeOfT(P, Q, R);
	    }

	    document.getElementById(type).innerHTML = Math.round(Math.abs(volumes));
	    document.getElementById('volumeField').value = Math.round(Math.abs(volumes));
	}

	function calculateVolumeSphere(radius){
		radius = Math.abs(radius);
		var volume = (4/3) * Math.PI * Math.pow(radius, 3);
		return volume.toFixed(4);
 	} 

	function addShadowedLight(x, y, z, color, intensity ) {
		var directionalLight = new THREE.DirectionalLight( color, intensity );
		directionalLight.position.set( x, y, z );
		scene.add( directionalLight );
		directionalLight.castShadow = true;
		var d = 1;
		directionalLight.shadow.camera.left = -d;
		directionalLight.shadow.camera.right = d;
		directionalLight.shadow.camera.top = d;
		directionalLight.shadow.camera.bottom = -d;
		directionalLight.shadow.camera.near = 1;
		directionalLight.shadow.camera.far = 4;
		directionalLight.shadow.mapSize.width = 1024;
		directionalLight.shadow.mapSize.height = 1024;
		directionalLight.shadow.bias = -0.005;
	}

	function multiply(array) {
	    var sum = 1;
	    for (var i=0; i<array.length; i++) {
	        sum = sum * array[i];
	    } 
	    return sum;
	}

	function changeColour(hex){
		shape.material.color.setHex(hex);
	}

	function onWindowResize(){
		canvasContPos = document.getElementById('canvas-section').getBoundingClientRect();
		var height = canvasContPos.height;
		var width = canvasContPos.width;

		camera.aspect = width / height;
	    camera.updateProjectionMatrix();
		renderer.setSize(width, height);
	}

	function initLights(){
		scene.add( new THREE.HemisphereLight( 0xe0dfce, 0x8e8e8e ) );
		addShadowedLight( 1, 1, 1, 0xc1bfbf, .9 );
	}

	function initMeasure( simpleGeometry ){
        document.getElementById('faces').innerHTML = simpleGeometry.faces.length;
    	simpleGeometry.computeBoundingBox();
    	simpleGeometry.computeBoundingSphere();

    	calculateVolume( simpleGeometry, 'volume' );
    	document.getElementById('volume-box').innerHTML = Math.round(multiply(simpleGeometry.boundingBox.getSize().toArray()));
    	document.getElementById('volume-sphere').innerHTML = Math.round(calculateVolumeSphere(simpleGeometry.boundingSphere.radius));
    }

	function initCamera(shape){
		shape.geometry.computeBoundingBox();
		shape.geometry.computeBoundingSphere();
		var bBox = shape.geometry.boundingBox;
		var bSphere = shape.geometry.boundingSphere;

		camera = new THREE.PerspectiveCamera(50, 1, 0.1, 1000);
		camera.position.y = 30;
		camera.position.x = 10;

		var dist = camera.position.distanceTo( bSphere.center ) - (bSphere.radius);
		var fov = Math.atan( bBox.getSize().y / ( dist ) ) * ( 180 / Math.PI ); // in degrees

		camera.fov = fov + 20;
		camera.updateProjectionMatrix();
	}

	function initCanvas(){
		stlCanvas = document.getElementById('stl-canvas');
		renderer = new THREE.WebGLRenderer({canvas: stlCanvas});
		var canvasContPos = document.getElementById('canvas-section').getBoundingClientRect();
		var height = canvasContPos.height;
		var width = canvasContPos.width;

		renderer.setSize(width, height);
	}

	function animate() {
		requestAnimationFrame( animate );
		renderer.render( scene, camera );
	}

	var shape, controls, camera, stlCanvas, renderer, loader, simpleGEO, fileExtension;
	var scene = new THREE.Scene();

	fileExtension = '<?php echo $file_extension; ?>';

	if(fileExtension == 'stl' || fileExtension == 'STL'){
		var loader = new THREE.STLLoader();

		loader.load( './stl-uploads/<?php echo $file_name; ?>', function ( geometry ) {
			var material = new THREE.MeshPhongMaterial({ color: 0xAAAAAA, specular: 0x111111, shininess: 10 });
	    	shape = new THREE.Mesh( geometry, material);
	    	shape.position = new THREE.Vector3(0, 0, 0);   

	    	simpleGEO = new THREE.Geometry().fromBufferGeometry( geometry );
	    	
	    	console.log( simpleGEO );
	    	initMeasure( simpleGEO );

	    	scene.add( shape );

		    initCanvas();
		    initCamera(shape);
		    initLights();
		    animate();

		    canvas = document.getElementById('canvas-section');
			controls = new THREE.OrbitControls( camera, canvas );
			controls.target = shape.geometry.boundingSphere.center;
			controls.update();

			window.addEventListener( 'resize', onWindowResize, false );
    });
	// }else if(fileExtension == 'obj' || fileExtension == 'OBJ'){
	// 	var loader = new THREE.OBJLoader2();

	// 	loader.load( './stl-uploads/<?php echo $file_name; ?>', function ( group ) {

	// 		group.traverse( function ( child ) {
	// 			if ( child.geometry !== undefined ) {
	// 				console.log( child.geometry.vertices );
	// 			}
	// 			} );

	//     	var material = new THREE.MeshPhongMaterial({ color: 0xAAAAAA, specular: 0x111111, shininess: 10 });
	// 		var GEO = new THREE.BufferGeometry;
	// 		GEO.addAttribute( 'position', new THREE.Float32BufferAttribute( [], 3 ) );
	// 		GEO.setFromObject( group );

	// 		shape = new THREE.Mesh( GEO , material); 

	// 		scene.add( group );

	// 		initMeasure(geoFromOBJ()); 
 
	// 		initCanvas();
	// 	    initCamera( shape );
	// 	    initLights();
	// 	    animate();

	// 	    canvas = document.getElementById('canvas-section');
	// 		controls = new THREE.OrbitControls( camera, canvas );
	// 		controls.target = shape.geometry.boundingSphere.center;
	// 		controls.update;

	// 		window.addEventListener( 'resize', onWindowResize, false );
 //    	});

	}

</script>
</div>
<div class="col-md-6 col-sm-12">
<div id="section-right">
<form action="confirmation.php" method="post">
<table class="table">
	<tr><td>File Name</td><td><?php echo $file_name; ?></td></tr>
	<tr><td>Faces</td><td id="faces"></td></tr>
	<tr><td>File Size</td><td><?php echo $file_size; ?></td></tr>
	<tr><td>Model Volume</td><td><span id="volume"></span> <span class="units">mm</span><sup>3</sup></td></tr>
	<tr><td>Model Volume(bounding box)</td><td><span id="volume-box"></span> <span class="units">mm</span><sup>3</sup></td></tr>
	<tr><td>Model Volume(bouding sphere)</td><td><span id="volume-sphere"></span> <span class="units">mm</span><sup>3</sup></td></tr>
</table>
<hr id="table-divider">
<label>Colour</label>
<div class="btn-group btn-colour" data-toggle="buttons">
	<label class="btn btn-primary btn-option"><input type="radio" name="colour-option" value="blue" onChange="changeColour('0x1313f2');" checked>Blue</label>
	<label class="btn btn-secondary btn-option focus active"><input type="radio" name="colour-option" value="grey" onChange="changeColour('0x686868');" checked="checked">Grey</label>
	<label class="btn btn-success btn-option"><input type="radio" name="colour-option" value="green" onChange="changeColour('0x11af19');">Green</label>
	<label class="btn btn-danger btn-option"><input type="radio" name="colour-option" value="red" onChange="changeColour('0x1c42311');">Red</label>
	<label class="btn btn-warning btn-option"><input type="radio" name="colour-option" value="yellow" onChange="changeColour('0xedd62d');">Yellow</label>
</div>
<hr>
<label>Material</label>
<div class="btn-group" data-toggle="buttons">
	<label class="btn btn-primary btn-option focus active"><input type="radio" name="material-option" value="material-abs" id="material-abs" onchange="changePrice();" checked="checked" />ABS</label>
	<label class="btn btn-primary btn-option"><input type="radio" name="material-option" value="material-sls" id="material-sls" onchange="changePrice();" />SLS Nylon</label>
	<label class="btn btn-primary btn-option"><input type="radio" name="material-option" value="material-resin" id="material-resin" onchange="changePrice();" />High Detail Resin</label>
</div>
<hr>
<div class="row">
<div class="col-md-6  col-sm-6 col-xs-6">
	<div class="[ form-group ]">
	    <input type="checkbox" name="checkbox-polished" id="checkbox-polished" autocomplete="off" onchange="changePrice();" />
	    <div class="[ btn-group ]">
	        <label for="checkbox-polished" class="[ btn btn-default ]">
	            <span class="[ glyphicon glyphicon-ok ]"></span>
	            <span> </span>
	        </label>
	        <label for="checkbox-polished" class="[ btn btn-default active ]">
	            Polishing
	        </label>
	    </div>
	</div>
	<div class="[ form-group ]">
	    <input type="checkbox" name="checkbox-delivery" id="checkbox-delivery" autocomplete="off" onchange="changePrice();"/>
	    <div class="[ btn-group ]">
	        <label for="checkbox-delivery" class="[ btn btn-default ]">
	            <span class="[ glyphicon glyphicon-ok ]"></span>
	            <span> </span>
	        </label>
	        <label for="checkbox-delivery" class="[ btn btn-default active ]">
	            Rushed Delivery
	        </label>
	    </div>
	</div>
</div>
<div class="col-md-6 col-sm-6 col-xs-6 price-box">
	<h2 id="price-tag">£<span id="price">15</span>.00<span id="lbl-vat"> + VAT</span></h2>
</div>
</div>
<input type=hidden id="priceHiddenField" name="price" value="15" />
<input type=hidden id="unitField" name="unit" value="mm" />
<input type=hidden id="nameField" name="name" value="<?php echo $file_name; ?>" />
<input type=hidden id="volumeField" name="volume" value="" />
<button type="submit" class="btn btn-primary btn-lg btn-block">Order a Print</button>
</form>
</div>
</div>
</div>
</div>
</div>
<div class="container">
<hr id="footer-sep">
<ul id="footer-links">
	<li><a href="">PrintWorks</a></li>
	<li><a href="">Contact PrintWorks</a></li>
</ul>
</div>
<script type="text/javascript">
	$(document).ready( function(){
		changePrice();
	});
</script>
</body>
</html>