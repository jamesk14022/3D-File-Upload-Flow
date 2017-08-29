<?php
	include('tools/OBJAnalysis.php');
	$obj = new OBJAnalysis( 'stl-uploads/magnolia.obj' ); 
	$obj->readOBJGeometry();
	$obj->reportShapeProperties();
?>