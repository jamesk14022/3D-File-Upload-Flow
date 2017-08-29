<?php

class OBJAnalysis{
	
	//path from 3d-loader root
	protected $obj_path;
	protected $vertices = [];
	protected $faces = [];
	protected $vertex_normals = [];

		//adds vertice to class given an obj vertice line
	function addVertice( $line ){
		$line = substr(ltrim($line), 2);
		array_push($this->vertices, explode(' ', $line));
	}

	//adds face to class given an obj face line
	function addface( $line ){
		$line = substr(ltrim($line), 2);
		array_push($this->faces, explode(' ', $line));
	}

	function addvertexNormal( $line ){
		$line = substr(ltrim($line), 3);
		array_push($this->vertex_normals, explode(' ', $line));
	}

	function reportShapeProperties(){
		foreach($this->vertices as $array){
			print_r(array_values($array));
		}

		foreach($this->faces as $array){
			print_r(array_values($array));
		}

		foreach($this->vertex_normals as $array){
			print_r(array_values($array));
		}
	}

	function vertices(){
		return $this->vertices;
	}

	function faces(){
		return $this->faces;
	}

	function __construct( $obj_path ){
		$this->obj_path = $obj_path;
	}

	function readOBJGeometry(){
		$handle = fopen( $this->obj_path, 'r' );
		if($handle){
			while(($buffer = fgets($handle)) !== false){
				if( substr(ltrim( $buffer ), 0, 1) == 'v'){
					$this->addVertice( $buffer );
				}else if( substr(ltrim( $buffer ), 0, 1) == 'f' ){
					$this->addFace( $buffer );
				}else if( substr(ltrim( $buffer ), 0, 2) == 'vn' ){
					$this->addVertexNormal( $buffer );
				}
			}
		}else{
			echo 'failed to open .obj file';
		}
	}

}

?>