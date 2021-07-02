<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Show Beacon">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCis0s71mPE0AuOdGdlWcn_Qw5610aWZu0"></script>
        <!-- https://cyphercodes.github.io/location-picker/docs/ -->
        <script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>

        <style>
            #header {
                height: 55px;
                z-index: 1;
            }

            #header h1 {
                padding-left: 10px;
            }

            #header button {
                width: 190px;
                height: 100%;
                border-left: 3px solid #1C1F23;
            }

            #container {
                position: absolute;
                height: calc(100vh - 55px);
                top: 55px;
            }

            #div-container {
                width: 67%;
            }

            #beacon-div {
                height: 63%;
                padding: 40px;
                font-size: 20px;
            }

            #map {
                height: 37%;
            }

            #scene-div {
                width: 100%;
                height: 100%;
            }

            .field {
                font-weight: 500;
            }

            .value {
                background-color: #2C3034;
                margin-bottom: 10px;
            }

            label {
                overflow: hidden;
            }
        </style>

        <title>Beacons</title>
    </head>

    <body class="overflow-hidden">
        <div class="w-100 vh-100 d-flex flex-row" id="main-div">
            <div class="bg-dark w-100 d-flex flex-row justify-content-between text-white position-fixed" id="header">
                <h1>Beacon</h1>
                <div>
                    <a href="{{ route('beacons.edit', $beacon) }}"><button type="button" class="btn btn-dark">Edit Beacon</button></a>
                    <a href="{{ route('beacons.index') }}"><button type="button" class="btn btn-dark">View Beacons</button></a>
                    <a href="{{ route('beacons.create') }}"><button type="button" class="btn btn-dark">Create Beacon</button></a>
                </div>
            </div>
            <div class="w-100 v-100 d-flex" id="container">
                <div class="h-100" id="div-container">
                    <div class="bg-dark w-100 text-white" id="beacon-div">
                        <div class="d-flex flex-column">
                            <label class="field">Name</label>
                            <label class="value">{{ $beacon->name }}</label>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="field">Description</label>
                            <label class="value">{{ $beacon->description ?? 'none' }}</label>
                        </div>
                        <div class="d-flex flex-column w-100" id="coords-div">
                            <label class="field">Position</label>
                            <div class="d-flex flex-row justify-content-around text-center w-100">
                                <div class="d-flex flex-column flex-grow-1">
                                    <label>Latitude</label>
                                    <label class="value">{{ $beacon->lat }}</label>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <label>Longitude</label>
                                    <label class="value">{{ $beacon->lng }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="field">Rotation</label>
                            <div class="d-flex flex-row justify-content-around text-center w-100">
                                <div class="d-flex flex-column flex-grow-1">
                                    <label class="subfield">X</label>
                                    <label class="value" id="rotationX">{{ json_decode($beacon->rotation)->x }}</label>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <label class="subfield">Y</label>
                                    <label class="value" id="rotationY">{{ json_decode($beacon->rotation)->y }}</label>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <label class="subfield">Z</label>
                                    <label class="value" id="rotationZ">{{ json_decode($beacon->rotation)->z }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="field">Model</label>
                            <div class="d-flex flex-row justify-content-around text-center w-100">
                                <div class="d-flex flex-column flex-grow-1">
                                    <label class="subfield">OBJ</label>
                                    <label class="value">{{ $beacon->icon ? substr($beacon->icon, strpos($beacon->icon, '-') + 1) : 'none' }}</label>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <label class="subfield">MTL</label>
                                    <label class="value">{{ $beacon->mtl ? substr($beacon->mtl, strpos($beacon->mtl, '-') + 1) : 'none' }}</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-dark w-100" id="reset-camera-btn">Reset Camera</button>
                    </div>
                    <div class="w-100" id="map"></div>
                </div>
                <div id="scene-div"></div>
            </div>
        </div>

        <script>
			var locationPicker = new locationPicker('map', {
				lat: {{ $beacon->lat }},
                lng: {{ $beacon->lng }},
			}, {
				zoom: 18,
                draggable: false,
                zoomControl: true,
                scrollwheel: false,
                disableDoubleClickZoom: true,
            });
		</script>

        <script type="module">
            import * as THREE from 'https://cdn.skypack.dev/three@0.130.0';
            import { OrbitControls } from "https://threejs.org/examples/jsm/controls/OrbitControls.js";
            import { OBJLoader } from "https://threejs.org/examples/jsm/loaders/OBJLoader.js";
            import { MTLLoader } from "https://threejs.org/examples/jsm/loaders/MTLLoader.js";
            let scene, camera, renderer, controls;

            let sceneDiv = document.getElementById('scene-div');
            let isOBJPresent = '{{ $beacon->icon }}' ? true : false;
            let isMTLPresent = '{{ $beacon->mtl }}' ? true : false;
            var model, models;

            function init() {
              scene = new THREE.Scene();
              scene.background = new THREE.Color(0xdddddd);

              camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 1, 5000);
              camera.position.x = 0;
              camera.position.y = 0;
              camera.position.z = 5;
              camera.aspect = sceneDiv.clientWidth / sceneDiv.clientHeight;
              camera.updateProjectionMatrix();

              // Light
              let hlight = new THREE.AmbientLight(0x404040, 100);
              scene.add(hlight);

              // Load Texture
              let textureLoader = new THREE.TextureLoader();
              let map = textureLoader.load("http://localhost/storage/textures/wood.jpeg");
              let material = new THREE.MeshBasicMaterial({map: map});

              renderer = new THREE.WebGLRenderer({antialias:true});
              renderer.setSize(sceneDiv.clientWidth, sceneDiv.clientHeight);
              sceneDiv.appendChild(renderer.domElement);

              // Mouse controllable camera
              controls = new OrbitControls(camera, renderer.domElement);

              // Load OBJ if present
              if (isOBJPresent) {
                let loader = new OBJLoader();
                loader.load("http://localhost/storage/{{ $beacon->icon }}", function(obj) {
                    models = obj.children;
                    model = obj.children[0];
                    model.geometry.center();
                    model.scale.set(1, 1, 1);
                    rotateModels();

                    obj.traverse(function(node) {
                        if (node.isMesh) {
                            node.material = material;
                        }
                    });

                    scene.add(obj);
                    animate();
                });
              }
            }

            function animate() {
              controls.update();
              renderer.render(scene, camera);
              requestAnimationFrame(animate);
            }

            init();

            document.getElementById('reset-camera-btn').addEventListener('click', function() {
                controls.reset();
            });

            function rotateModels() {
                if (!isOBJPresent)
                    return;

                models.forEach(element => {
                    element.rotation.x = parseFloat(rotationX.innerHTML) * Math.PI / 180;
                    element.rotation.y = parseFloat(rotationY.innerHTML) * Math.PI / 180;
                    element.rotation.z = parseFloat(rotationZ.innerHTML) * Math.PI / 180;
                });
            }

            /*
            * Function that resize
            * the 3D scene on window's
            * resize event
            */

            window.addEventListener("resize", () => {
                camera.aspect = sceneDiv.clientWidth / sceneDiv.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(sceneDiv.clientWidth, sceneDiv.clientHeight);
            });
        </script>
    </body>
</html>
