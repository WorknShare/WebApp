var camera, scene, renderer, controls;
var geometry, material, mesh, light;
var cpt;

var angles = Array();
var speed = 0.01;
var range = 90;

var container = document.getElementById("wave-container");

function init() {

	
	camera = new THREE.PerspectiveCamera( 70, container.offsetWidth / container.offsetHeight, 5, 2000 );
	camera.position.x = 114;
	camera.position.y = -300;
	camera.position.z = 487;

	controls = new THREE.OrbitControls( camera );
	
	scene = new THREE.Scene();
	geometry = new THREE.PlaneGeometry(2250, 900, 12, 12);

	material = new THREE.MeshPhongMaterial( { color:0xffffff, wireframe:true, opacity: 0.5, transparent: true, depthWrite: false } );
	
	mesh = new THREE.Mesh( geometry, material );
	mesh.rotation.x = -0.5;
	scene.add( mesh );

	var light = new THREE.AmbientLight( 0xffffff ); // soft white light
	scene.add( light );
	
	
	for(var i in geometry.vertices)
	{
		angles.push( i * 0.45 );
	}

	renderer = new THREE.CanvasRenderer( { antialias: false } );
	renderer.setSize( container.offsetWidth, container.offsetHeight );
	renderer.domElement.setAttribute("id", "wave");

	container.appendChild( renderer.domElement );

	window.addEventListener( 'resize', onWindowResize, false );
	controls.update();

}


function animate() {


	requestAnimationFrame( animate );

	for(var i in geometry.vertices)
	{

		mesh.geometry.vertices[i].z = 100 + Math.sin(angles[i])*range; 
		angles[i] += speed;

	}
		
	renderer.render( scene, camera );

}



function onWindowResize() {

	camera.aspect = container.offsetWidth / container.offsetHeight;
	camera.updateProjectionMatrix();
	renderer.setSize( container.offsetWidth, container.offsetHeight );
}


window.onload = function()
{

	init();
	animate();

};