import * as THREE from 'https://cdn.skypack.dev/three@0.129.0/build/three.module.js';
import { GLTFLoader } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js';
import { gsap } from 'https://cdn.skypack.dev/gsap';

const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(10, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.z = 13;

const renderer = new THREE.WebGLRenderer({ alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.shadowMap.enabled = true;
document.getElementById('container3D').appendChild(renderer.domElement);

const ambientLight = new THREE.AmbientLight(0xffffff, 0.2);
scene.add(ambientLight);

const sunLight = new THREE.DirectionalLight(0xffffff, 1.2);
sunLight.position.set(50, 30, 100);
sunLight.castShadow = true;
scene.add(sunLight);

const rimLight = new THREE.DirectionalLight(0x8888ff, 0.3);
rimLight.position.set(-50, -40, -80);
scene.add(rimLight);


const loader = new GLTFLoader();
const planetGroup = new THREE.Group();
scene.add(planetGroup);

const planets = [];
const positions = [];
let mainPlanet = null;

const raycaster = new THREE.Raycaster();
const mouse = new THREE.Vector2();

fetch(jsonUrl)
    .then(res => res.json())
    .then(json => {
        const promises = json.map(data => loadPlanet(data));
        return Promise.all(promises).then(loadedPlanets => {
        loadedPlanets.forEach(({ planet, position }, i) => {
            planets[i] = planet;
            positions[i] = position;
            planetGroup.add(planet);
        });

        mainPlanet = planets[1];
        document.querySelectorAll('.main-title').forEach(el => {
            el.textContent = mainPlanet.userData.name;
        });
        document.getElementById('main-description').textContent = json[1].description;
        document.getElementById('detail-description').textContent = mainPlanet.userData.detailDescription;
        document.getElementById('distance-planet').textContent = mainPlanet.userData.distance;
        document.getElementById('estimate-planet').textContent = mainPlanet.userData.estimasi;
        document.getElementById('cost-travel').textContent = mainPlanet.userData.cost;
        document.getElementsByClassName('planet-id')[0].id = mainPlanet.userData.planet_id;

        arrPositionModel[0].position = {
            x: positions[1].x,
            y: positions[1].y,
            z: positions[1].z
        };

        animate();
        window.addEventListener('click', onClick);
        window.addEventListener('scroll', modelMove());
        });
    });

function loadPlanet(data) {
    return new Promise((resolve) => {
        loader.load(`./asset/${data.file}`, (gltf) => {
            
        const planet = gltf.scene;
        planet.scale.setScalar(data.scale);
        planet.position.set(data.position.x, data.position.y, data.position.z);
        planet.userData.planet_id = data.planet_id;
        planet.userData.name = data.name;
        planet.userData.description = data.description;
        planet.userData.detailDescription = data.detailDescription;
        planet.userData.distance = data.distance;
        planet.userData.estimasi = data.estimasi;
        planet.userData.cost = data.cost;

        planet.traverse(child => {
            if (child.isMesh) {
                const oldMap = child.material.map;

                child.material = new THREE.MeshStandardMaterial({
                    map: oldMap,
                    roughness: 1.0,
                    metalness: 0.0,
                    emissive: new THREE.Color(0x000000),
                    emissiveIntensity: 0.1
                });

                child.castShadow = true;
                child.receiveShadow = true;
            }
        });

        resolve({
            planet,
            position: new THREE.Vector3().copy(planet.position)
        });
        });
    });
}

function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
    planets.forEach(planet => {
        planet.rotation.y += 0.003;
    });
}

function onClick(event) {
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    raycaster.setFromCamera(mouse, camera);
    const intersects = raycaster.intersectObjects(planets, true);

    if (!intersects.length) return;

    const clicked = intersects[0].object;
    const rootPlanet = planets.find(p => p.getObjectById(clicked.id));
    const index = planets.indexOf(rootPlanet);

    if (rootPlanet) {
        mainPlanet = rootPlanet;
        document.querySelectorAll('.main-title').forEach(el => {
            el.textContent = mainPlanet.userData.name;
        });
        document.getElementById('main-description').textContent = rootPlanet.userData.description;
        document.getElementById('detail-description').textContent = rootPlanet.userData.detailDescription;
        document.getElementById('distance-planet').textContent = rootPlanet.userData.distance;
        document.getElementById('estimate-planet').textContent = rootPlanet.userData.estimasi;
        document.getElementById('cost-travel').textContent = rootPlanet.userData.cost;
        document.getElementsByClassName('planet-id')[0].id = rootPlanet.userData.planet_id;
    }

    if (index === 0) {
        planets.unshift(planets.pop());
    } else if (index === 2) {
        planets.push(planets.shift());
    } else {
        return;
    }

    planets.forEach((planet, i) => {
        gsap.to(planet.position, {
            ...positions[i],
            duration: 1,
            ease: "power2.inOut"
        });
    });
}

let arrPositionModel = [
    {
        id: 'main-page',
        position: {x: 0, y: -1.8, z: 0},
    },
    {
        id: "description-planet",
        position: { x: -1.8, y: 0, z: -1 },
    },
    {
        id: "booking-planet",
        position: { x: -0, y: 0, z: 7 },
    }
];

const modelMove = () => {
    const sections = document.querySelectorAll('section');
    let currentSection = null;

    sections.forEach((section) => {
        const rect = section.getBoundingClientRect();
        if (rect.top <= window.innerHeight / 3) {
            currentSection = section.id;
        }
    });

    const position_active = arrPositionModel.findIndex(
        val => val.id === currentSection
    );
    
    if (mainPlanet) {
        if (position_active !== -1) {
            const new_coordinates = arrPositionModel[position_active];
            gsap.to(mainPlanet.position, {
                x: new_coordinates.position.x,
                y: new_coordinates.position.y,
                z: new_coordinates.position.z,
                duration: 1,
                ease: "power1.out"
            });
        }

        const isHome = currentSection === 'main-page';
        planets.forEach((planet, i) => {
            if (planet !== mainPlanet) {
                gsap.to(planet.position, {
                    x: positions[i].x,
                    y: isHome ? positions[i].y : 100,
                    z: positions[i].z,
                    duration: 1,
                    ease: "power1.out"
                });
            }
        });
    }
};

window.addEventListener('scroll', () => {
    modelMove();
}, true);

window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});
