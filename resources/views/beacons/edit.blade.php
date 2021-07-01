<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Edit Beacon">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCis0s71mPE0AuOdGdlWcn_Qw5610aWZu0"></script>
        <!-- https://cyphercodes.github.io/location-picker/docs/ -->
        <script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>

        <style>
            #header {
                position: fixed;
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
                width: 50%;
                display: flex;
                flex-direction: column;
            }

            #beacon-div {
                height: 63%;
                padding: 40px;
                font-size: 20px;
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

            #map {
                height: 37%;
            }

            #scene-div {
                width: 100%;
                height: 100%;
            }
        </style>

        <title>Beacons</title>
    </head>

    <body class="overflow-hidden">
        <div class="w-100 vh-100 d-flex flex-row" id="main-div">
            <div class="bg-dark w-100 d-flex flex-row justify-content-between text-white" id="header">
                <h1>Beacon</h1>
                <div>
                    <a href="{{ route('beacons.show', $beacon) }}"><button type="button" class="btn btn-dark">View Beacon</button></a>
                    <a href="{{ route('beacons.index') }}"><button type="button" class="btn btn-dark">View Beacons</button></a>
                    <a href="{{ route('beacons.create') }}"><button type="button" class="btn btn-dark">Create Beacon</button></a>
                </div>
            </div>
            <div class="w-100 v-100 d-flex" id="container">
                <div class="h-100" id="div-container">
                    <div class="bg-dark w-100 text-white" id="beacon-div">
                        <form enctype="multipart/form-data" method="POST" action="{{ route("beacons.update", $beacon) }}">
                            @csrf
                            @method('PUT')

                            <div class="d-flex flex-column">
                                <label id="name" class="field">Name</label>
                                <input type="text" class="value text-white" value="{{ $beacon->name }}" placeholder="{{ $beacon->name }}" name="name" id="name" required>
                            </div>
                            <div class="d-flex flex-column">
                                <label for="description" class="field">Description</label>
                                <input type="text" class="value text-white" value="{{ $beacon->description ?? '' }}" placeholder="{{ $beacon->description ?? '' }}" name="description" id="description">
                            </div>
                            <div class="d-flex flex-column w-100" id="coords-div">
                                <label class="field">Position</label>
                                <div class="d-flex flex-row justify-content-around text-center w-100">
                                    <div class="col-6 d-flex flex-column flex-grow-1">
                                        <label for="lat">Latitude</label>
                                        <input type="number" step="any" oninput="updatePosition();" class="value text-white" id="lat" value="{{ $beacon->lat }}" placeholder="{{ $beacon->lat }}" name="lat" required>
                                    </div>
                                    <div class="col-6 d-flex flex-column flex-grow-1">
                                        <label for="lng">Longitude</label>
                                        <input type="number" step="any" oninput="updatePosition();" class="value text-white" id="lng" value="{{ $beacon->lng }}" placeholder="{{ $beacon->lng }}" name="lng" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="field">Rotation</label>
                                <div class="d-flex flex-row justify-content-around text-center w-100">
                                    <div class="col-3 d-flex flex-column flex-grow-1">
                                        <label for="rotationX" class="subfield">X</label>
                                        <input type="number" step="any" min=0 max=360 class="value text-white" value="{{ json_decode($beacon->rotation)->x }}" placeholder="{{ json_decode($beacon->rotation)->x }}" name="rotationX" id="rotationX" required>
                                    </div>
                                    <div class="col-3 d-flex flex-column flex-grow-1">
                                        <label for="rotationY" class="subfield">Y</label>
                                        <input type="number" step="any" min=0 max=360 class="value text-white" value="{{ json_decode($beacon->rotation)->y }}" placeholder="{{ json_decode($beacon->rotation)->y }}" name="rotationY" id="rotationY" required>
                                    </div>
                                    <div class="col-3 d-flex flex-column flex-grow-1">
                                        <label for="rotationZ" class="subfield">Z</label>
                                        <input type="number" step="any" min=0 max=360 class="value text-white" value="{{ json_decode($beacon->rotation)->z }}" placeholder="{{ json_decode($beacon->rotation)->z }}" name="rotationZ" id="rotationZ" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row justify-content-between">
                                    <label for="input-model" class="field">Model: {{ $beacon->icon ? substr($beacon->icon, strpos($beacon->icon, '-') + 1) : 'none' }}</label>
                                    <div class="d-flex flex-row">
                                        @isset($beacon->icon)
                                            <label for="remove-model" style="padding-right: 10px;">Delete Model</label>
                                            <input type="checkbox" class="h-100" id="remove-model" name="removeModel">
                                        @endisset
                                    </div>
                                </div>
                                <input type="file" accept=".obj" class="value" id="input-model" name="icon">
                            </div>
                            <div class="d-flex flex-row">
                                <button type="button" class="btn btn-dark flex-grow-1" onClick="getMarkerPosition();">Get Marker Position</button>
                                <button type="button" class="btn btn-dark flex-grow-1" id="reset-camera-btn">Reset Camera</button>
                                <button type="submit" class="btn btn-dark flex-grow-1">Update Beacon</button>
                            </div>
                        </form>
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
                draggable: true,
                zoomControl: true,
                scrollwheel: true,
                disableDoubleClickZoom: true,
            });

            function getMarkerPosition() {
                let latInput = document.getElementById('lat');
                let lngInput = document.getElementById('lng');
                let responseCoords = locationPicker.getMarkerPosition();

                latInput.value = responseCoords.lat;
                lngInput.value = responseCoords.lng;
            }

            function updatePosition() {
                let lat = parseFloat(document.getElementById('lat').value);
                let lng = parseFloat(document.getElementById('lng').value);

                locationPicker.map.setCenter({lat: lat, lng: lng});
            }
		</script>

        <script type="module">
            import * as THREE from 'https://cdn.skypack.dev/three@0.130.0';
            import { OrbitControls } from "https://threejs.org/examples/jsm/controls/OrbitControls.js";
            import { OBJLoader } from "https://threejs.org/examples/jsm/loaders/OBJLoader.js";
            let scene, camera, renderer, controls;

            let sceneDiv = document.getElementById('scene-div');
            let model;

            function init() {
              scene = new THREE.Scene();
              scene.background = new THREE.Color(0xdddddd);

              camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 1, 5000);
              camera.position.x = 0;
              camera.position.y = 1;
              camera.position.z = 5;
              camera.aspect = sceneDiv.clientWidth / sceneDiv.clientHeight;
              camera.updateProjectionMatrix();

              let hlight = new THREE.AmbientLight(0x404040, 100);
              scene.add(hlight);

              let directionalLight = new THREE.DirectionalLight(0xffffff, 100);
              directionalLight.position.set(0, 1, 0);
              directionalLight.castShadow = true;
              scene.add(directionalLight);
              let light = new THREE.PointLight(0xc4c4c4, 10);
              light.position.set(0, 300, 500);
              scene.add(light);
              let light2 = new THREE.PointLight(0xc4c4c4, 10);
              light2.position.set(500, 100, 0);
              scene.add(light2);
              let light3 = new THREE.PointLight(0xc4c4c4, 10);
              light3.position.set(0, 100, -500);
              scene.add(light3);
              let light4 = new THREE.PointLight(0xc4c4c4, 10);
              light4.position.set(-500, 300, 500);
              scene.add(light4);

              // Texture
              let textureLoader = new THREE.TextureLoader();
              let map = textureLoader.load("http://localhost/storage/textures/wood.jpeg");
              let material = new THREE.MeshBasicMaterial({map: map});

              renderer = new THREE.WebGLRenderer({antialias:true});
              renderer.setSize(sceneDiv.clientWidth, sceneDiv.clientHeight);
              sceneDiv.appendChild(renderer.domElement);

              controls = new OrbitControls(camera, renderer.domElement);

              let loader = new OBJLoader();
              loader.load("http://localhost/storage/{{ $beacon->icon }}", function(obj) {
                model = obj.children[0];
                model.geometry.center();
                model.scale.set(1, 1, 1);
                rotateModel();

                obj.traverse(function(node) {
                    if (node.isMesh) {
                        console.log(node.material);
                        node.material = material;
                        console.log(node.material);
                    }
                });

                scene.add(obj);
                animate();
              });
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

            let rotationXInput = document.getElementById('rotationX');
            let rotationYInput = document.getElementById('rotationY');
            let rotationZInput = document.getElementById('rotationZ');

            rotationXInput.addEventListener('input', rotateModel);
            rotationYInput.addEventListener('input', rotateModel);
            rotationZInput.addEventListener('input', rotateModel);


            function rotateModel() {
                model.rotation.x = parseFloat(rotationXInput.value) * Math.PI / 180;
                model.rotation.y = parseFloat(rotationYInput.value) * Math.PI / 180;
                model.rotation.z = parseFloat(rotationZInput.value) * Math.PI / 180;
            }

            window.addEventListener("resize", () => {
                camera.aspect = sceneDiv.clientWidth / sceneDiv.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(sceneDiv.clientWidth, sceneDiv.clientHeight);
            });
          </script>
    </body>
</html>
