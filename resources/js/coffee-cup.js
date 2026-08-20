import * as THREE from 'three';

const lerp = THREE.MathUtils.lerp;
const clamp = THREE.MathUtils.clamp;
const TAU = Math.PI * 2;

/* ---------------------------------------------------------------- tiny noise */
function hash3(x, y, z) {
    const s = Math.sin(x * 127.1 + y * 311.7 + z * 74.7) * 43758.5453123;
    return s - Math.floor(s);
}

function fbm(x, y, z) {
    let value = 0;
    let amp = 0.5;
    let freq = 1;
    for (let i = 0; i < 4; i++) {
        value += amp * hash3(x * freq, y * freq, z * freq);
        amp *= 0.5;
        freq *= 2;
    }
    return value;
}

function easeOutExpo(t) {
    return t >= 1 ? 1 : 1 - Math.pow(2, -10 * t);
}

/* ---------------------------------------------------------------- procedural textures */
function makeCremaTexture() {
    const size = 1024;
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');

    const base = ctx.createRadialGradient(size / 2, size / 2, size * 0.04, size / 2, size / 2, size * 0.5);
    base.addColorStop(0, '#e0a86c');
    base.addColorStop(0.4, '#b9794a');
    base.addColorStop(0.78, '#8a5230');
    base.addColorStop(1, '#6b3c20');
    ctx.fillStyle = base;
    ctx.fillRect(0, 0, size, size);

    for (let i = 0; i < 110; i++) {
        const x = Math.random() * size;
        const y = Math.random() * size;
        const r = 10 + Math.random() * 52;
        const g = ctx.createRadialGradient(x, y, 0, x, y, r);
        const light = Math.random() < 0.5;
        g.addColorStop(0, light ? 'rgba(240,200,146,0.32)' : 'rgba(70,40,20,0.3)');
        g.addColorStop(1, 'rgba(0,0,0,0)');
        ctx.fillStyle = g;
        ctx.fillRect(x - r, y - r, r * 2, r * 2);
    }

    for (let i = 0; i < 8000; i++) {
        const x = Math.random() * size;
        const y = Math.random() * size;
        const a = 0.05 + Math.random() * 0.12;
        ctx.fillStyle = Math.random() < 0.5 ? `rgba(58,32,16,${a})` : `rgba(255,226,182,${a})`;
        ctx.fillRect(x, y, 1.6, 1.6);
    }

    for (let i = 0; i < 1700; i++) {
        const x = Math.random() * size;
        const y = Math.random() * size;
        const r = 0.6 + Math.random() * 9;
        const g = ctx.createRadialGradient(x - r * 0.35, y - r * 0.35, 0, x, y, r);
        g.addColorStop(0, 'rgba(252,236,206,0.55)');
        g.addColorStop(0.5, 'rgba(196,136,84,0.3)');
        g.addColorStop(0.82, 'rgba(118,70,36,0.5)');
        g.addColorStop(1, 'rgba(88,48,24,0.95)');
        ctx.fillStyle = g;
        ctx.beginPath();
        ctx.arc(x, y, r, 0, TAU);
        ctx.fill();
    }

    const ring = ctx.createRadialGradient(size / 2, size / 2, size * 0.42, size / 2, size / 2, size * 0.5);
    ring.addColorStop(0, 'rgba(0,0,0,0)');
    ring.addColorStop(1, 'rgba(60,34,18,0.55)');
    ctx.fillStyle = ring;
    ctx.fillRect(0, 0, size, size);

    const texture = new THREE.CanvasTexture(canvas);
    texture.colorSpace = THREE.SRGBColorSpace;
    texture.anisotropy = 8;
    return texture;
}

function makeRadialTexture(stops) {
    const size = 256;
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');
    const g = ctx.createRadialGradient(size / 2, size / 2, 0, size / 2, size / 2, size / 2);
    stops.forEach(([offset, color]) => g.addColorStop(offset, color));
    ctx.fillStyle = g;
    ctx.fillRect(0, 0, size, size);
    return new THREE.CanvasTexture(canvas);
}

function makeBumpTexture() {
    const size = 128;
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#808080';
    ctx.fillRect(0, 0, size, size);
    for (let i = 0; i < 1600; i++) {
        const v = 96 + Math.random() * 96;
        ctx.fillStyle = `rgb(${v},${v},${v})`;
        ctx.fillRect(Math.random() * size, Math.random() * size, 2.4, 2.4);
    }
    const texture = new THREE.CanvasTexture(canvas);
    texture.wrapS = THREE.RepeatWrapping;
    texture.wrapT = THREE.RepeatWrapping;
    texture.repeat.set(3, 3);
    return texture;
}

function makeEnvironment(renderer) {
    const w = 1024;
    const h = 512;
    const canvas = document.createElement('canvas');
    canvas.width = w;
    canvas.height = h;
    const ctx = canvas.getContext('2d');

    const g = ctx.createLinearGradient(0, 0, 0, h);
    g.addColorStop(0, '#fff7eb');
    g.addColorStop(0.3, '#e7c9a2');
    g.addColorStop(0.62, '#b28a63');
    g.addColorStop(0.85, '#5c4230');
    g.addColorStop(1, '#241811');
    ctx.fillStyle = g;
    ctx.fillRect(0, 0, w, h);

    const glow = ctx.createRadialGradient(w * 0.62, h * 0.27, 20, w * 0.62, h * 0.27, h * 0.6);
    glow.addColorStop(0, 'rgba(255,236,206,0.95)');
    glow.addColorStop(1, 'rgba(255,236,206,0)');
    ctx.fillStyle = glow;
    ctx.fillRect(0, 0, w, h);

    const cool = ctx.createRadialGradient(w * 0.2, h * 0.62, 10, w * 0.2, h * 0.62, h * 0.42);
    cool.addColorStop(0, 'rgba(188,202,216,0.5)');
    cool.addColorStop(1, 'rgba(188,202,216,0)');
    ctx.fillStyle = cool;
    ctx.fillRect(0, 0, w, h);

    const texture = new THREE.CanvasTexture(canvas);
    texture.colorSpace = THREE.SRGBColorSpace;
    const pmrem = new THREE.PMREMGenerator(renderer);
    const rt = pmrem.fromEquirectangular(texture);
    texture.dispose();
    pmrem.dispose();
    return rt.texture;
}

/* ---------------------------------------------------------------- objects */
function makeBean(bump) {
    const group = new THREE.Group();

    const geo = new THREE.SphereGeometry(1, 26, 18);
    const pos = geo.attributes.position;
    for (let i = 0; i < pos.count; i++) {
        const x = pos.getX(i);
        const y = pos.getY(i);
        const z = pos.getZ(i);
        const n = fbm(x * 2.6, y * 2.6, z * 2.6);
        const s = 1 + (n - 0.5) * 0.42;
        pos.setXYZ(i, x * s, y * s, z * s);
    }
    geo.computeVertexNormals();

    const body = new THREE.Mesh(
        geo,
        new THREE.MeshPhysicalMaterial({
            color: 0x35200f,
            roughness: 0.5,
            metalness: 0,
            clearcoat: 0.2,
            clearcoatRoughness: 0.35,
            bumpMap: bump,
            bumpScale: 0.05,
        }),
    );
    body.scale.set(0.42, 0.62, 0.26);
    body.castShadow = true;
    group.add(body);

    const crease = new THREE.Mesh(
        new THREE.TorusGeometry(0.52, 0.02, 8, 40),
        new THREE.MeshStandardMaterial({ color: 0x170d05, roughness: 0.9, metalness: 0 }),
    );
    crease.rotation.x = Math.PI / 2;
    crease.position.y = 0.03;
    group.add(crease);

    const sheen = new THREE.Mesh(
        new THREE.SphereGeometry(1, 18, 14),
        new THREE.MeshPhysicalMaterial({
            color: 0xffffff,
            roughness: 0.25,
            clearcoat: 1,
            clearcoatRoughness: 0.18,
            transparent: true,
            opacity: 0.1,
            bumpMap: bump,
            bumpScale: 0.06,
        }),
    );
    sheen.scale.set(0.32, 0.5, 0.2);
    sheen.position.set(-0.08, 0.16, 0.2);
    group.add(sheen);

    return group;
}

function makeSteamSprite() {
    const texture = makeRadialTexture([
        [0, 'rgba(255,250,242,0.42)'],
        [0.4, 'rgba(255,250,242,0.16)'],
        [1, 'rgba(255,250,242,0)'],
    ]);
    const material = new THREE.SpriteMaterial({
        map: texture,
        transparent: true,
        opacity: 0.2,
        depthWrite: false,
    });
    const sprite = new THREE.Sprite(material);
    sprite.scale.setScalar(0.85);
    return sprite;
}

export function initCoffeeHero(heroEl, { getProgress = () => 0 } = {}) {
    if (!heroEl) return;
    const host = heroEl.querySelector('[data-coffee]');
    if (!host) return;

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const finePointer = window.matchMedia('(pointer: fine)').matches;

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    } catch {
        return;
    }

    const width = host.clientWidth || host.getBoundingClientRect().width || 600;
    const height = host.clientHeight || host.getBoundingClientRect().height || 800;
    renderer.setPixelRatio(Math.min(2, window.devicePixelRatio));
    renderer.setSize(width, height, false);
    renderer.setClearColor(0x000000, 0);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.05;
    host.appendChild(renderer.domElement);

    const frame = heroEl.querySelector('.img-frame');
    if (frame) frame.classList.add('is-3d');

    const scene = new THREE.Scene();
    scene.environment = makeEnvironment(renderer);
    scene.environmentIntensity = 0.85;

    const camera = new THREE.PerspectiveCamera(32, width / height, 0.1, 60);
    camera.position.set(0, 0.55, 7.6);
    camera.lookAt(0, 0.45, 0);

    const hemi = new THREE.HemisphereLight(0xfff1e0, 0x554436, 0.5);
    scene.add(hemi);

    const key = new THREE.DirectionalLight(0xfff1dd, 2.5);
    key.position.set(4, 7, 6);
    key.castShadow = true;
    key.shadow.mapSize.set(2048, 2048);
    key.shadow.camera.near = 0.5;
    key.shadow.camera.far = 20;
    key.shadow.camera.left = -4;
    key.shadow.camera.right = 4;
    key.shadow.camera.top = 5;
    key.shadow.camera.bottom = -5;
    key.shadow.bias = -0.0004;
    key.shadow.radius = 7;
    scene.add(key);

    const fill = new THREE.DirectionalLight(0xffc98f, 0.55);
    fill.position.set(-5, 2, 3);
    scene.add(fill);

    const rim = new THREE.DirectionalLight(0x8fa9c4, 0.7);
    rim.position.set(-4, 3, -6);
    scene.add(rim);

    const cremaGlow = new THREE.PointLight(0xffb45a, 0.5, 8);
    cremaGlow.position.set(0, 1.6, 2.8);
    scene.add(cremaGlow);

    /* ------------------------------------------------------------ materials */
    const ceramic = new THREE.MeshPhysicalMaterial({
        color: 0xf2e8d7,
        roughness: 0.34,
        metalness: 0,
        clearcoat: 0.85,
        clearcoatRoughness: 0.12,
        ior: 1.5,
        envMapIntensity: 1.05,
    });
    const innerCeramic = new THREE.MeshPhysicalMaterial({
        color: 0xd2bfa6,
        roughness: 0.4,
        metalness: 0,
        clearcoat: 0.45,
        clearcoatRoughness: 0.22,
        side: THREE.DoubleSide,
    });

    const cremaTexture = makeCremaTexture();
    const coffeeMat = new THREE.MeshPhysicalMaterial({
        map: cremaTexture,
        roughness: 0.4,
        metalness: 0,
        clearcoat: 0.6,
        clearcoatRoughness: 0.18,
        side: THREE.DoubleSide,
    });

    const bump = makeBumpTexture();

    /* ------------------------------------------------------------ cup build */
    const cup = new THREE.Group();

    const cupProfile = [
        new THREE.Vector2(0.5, 0.0),
        new THREE.Vector2(0.56, 0.02),
        new THREE.Vector2(0.58, 0.2),
        new THREE.Vector2(0.66, 0.55),
        new THREE.Vector2(0.76, 0.85),
        new THREE.Vector2(0.87, 1.04),
        new THREE.Vector2(0.89, 1.2),
        new THREE.Vector2(0.84, 1.27),
        new THREE.Vector2(0.78, 1.22),
        new THREE.Vector2(0.72, 1.05),
        new THREE.Vector2(0.63, 0.6),
        new THREE.Vector2(0.56, 0.2),
        new THREE.Vector2(0.53, 0.02),
        new THREE.Vector2(0.5, 0.0),
    ];
    const wall = new THREE.Mesh(new THREE.LatheGeometry(cupProfile, 96), ceramic);
    wall.castShadow = true;
    wall.receiveShadow = true;
    cup.add(wall);

    const lip = new THREE.Mesh(new THREE.TorusGeometry(0.86, 0.018, 10, 96), ceramic);
    lip.rotation.x = Math.PI / 2;
    lip.position.y = 1.27;
    lip.castShadow = true;
    cup.add(lip);

    const coffee = new THREE.Mesh(new THREE.CircleGeometry(0.74, 96), coffeeMat);
    coffee.rotation.x = -Math.PI / 2;
    coffee.position.y = 1.16;
    coffee.rotation.z = Math.random() * TAU;
    cup.add(coffee);

    const handle = new THREE.Mesh(new THREE.TorusGeometry(0.38, 0.075, 16, 48), ceramic);
    handle.rotation.y = Math.PI / 2;
    handle.rotation.z = 0.16;
    handle.position.set(1.06, 0.82, 0);
    handle.castShadow = true;
    cup.add(handle);

    /* saucer */
    const saucerPlate = new THREE.Mesh(new THREE.CylinderGeometry(1.32, 1.12, 0.07, 96), ceramic);
    saucerPlate.position.y = -0.1;
    saucerPlate.castShadow = true;
    saucerPlate.receiveShadow = true;
    cup.add(saucerPlate);

    const saucerRim = new THREE.Mesh(new THREE.TorusGeometry(1.28, 0.03, 10, 80), ceramic);
    saucerRim.rotation.x = Math.PI / 2;
    saucerRim.position.y = -0.06;
    saucerRim.castShadow = true;
    cup.add(saucerRim);

    const saucerWell = new THREE.Mesh(new THREE.CylinderGeometry(0.55, 0.62, 0.03, 72), ceramic);
    saucerWell.position.y = -0.075;
    cup.add(saucerWell);

    /* contact shadow (invisible catcher) */
    const shadowPlane = new THREE.Mesh(
        new THREE.CircleGeometry(2.7, 72),
        new THREE.ShadowMaterial({ opacity: 0.3, transparent: true }),
    );
    shadowPlane.rotation.x = -Math.PI / 2;
    shadowPlane.position.y = -0.16;
    shadowPlane.receiveShadow = true;
    cup.add(shadowPlane);

    /* floating beans */
    const beansGroup = new THREE.Group();
    cup.add(beansGroup);

    const beans = [
        { radius: 2.0, height: 0.3, speed: 0.7, phase: 0.0, spin: 1.1 },
        { radius: 2.45, height: -0.3, speed: 1.05, phase: 2.4, spin: 1.7 },
        { radius: 1.75, height: -0.55, speed: 0.85, phase: 4.1, spin: 0.9 },
        { radius: 2.7, height: 0.5, speed: 0.6, phase: 5.6, spin: 1.4 },
        { radius: 2.15, height: 0.0, speed: 1.3, phase: 1.2, spin: 2.0 },
    ].map((cfg) => {
        const mesh = makeBean(bump);
        beansGroup.add(mesh);
        return { ...cfg, mesh };
    });

    /* steam */
    const steams = [
        { dx: -0.16, baseY: 1.5, speed: 1.0, phase: 0.0 },
        { dx: 0.0, baseY: 1.62, speed: 0.72, phase: 2.1 },
        { dx: 0.16, baseY: 1.46, speed: 0.85, phase: 4.3 },
        { dx: 0.28, baseY: 1.7, speed: 1.15, phase: 1.6 },
    ].map((cfg) => {
        const sprite = makeSteamSprite();
        sprite.position.set(cfg.dx, cfg.baseY, 0);
        cup.add(sprite);
        return { ...cfg, sprite };
    });

    const tiltGroup = new THREE.Group();
    tiltGroup.add(cup);
    scene.add(tiltGroup);

    /* ------------------------------------------------------------ state */
    const SX = -3.6;
    const SY = -2.7;
    const SZ = -1.6;
    let spin = 0.35;
    let splay = 0.15;
    let tx = 0;
    let ty = 0;
    let heroVisible = true;
    let running = true;
    let last = performance.now();
    let tossStart = -1;
    let raf = 0;

    heroEl.addEventListener('pointermove', (e) => {
        if (!finePointer) return;
        const r = heroEl.getBoundingClientRect();
        tx = clamp((e.clientX - r.left) / r.width - 0.5, -0.5, 0.5) * 2;
        ty = clamp((e.clientY - r.top) / r.height - 0.5, -0.5, 0.5) * 2;
    }, { passive: true });

    const io = new IntersectionObserver(
        ([entry]) => { heroVisible = entry.isIntersecting; },
        { threshold: 0 },
    );
    io.observe(host);

    const resize = () => {
        const w = host.clientWidth;
        const h = host.clientHeight;
        if (w === 0 || h === 0) return;
        renderer.setSize(w, h, false);
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
    };
    const ro = new ResizeObserver(resize);
    ro.observe(host);

    const updateSteam = (now) => {
        steams.forEach((s) => {
            const ph = (now * 0.00018 * s.speed + s.phase) % 1;
            const drift = Math.sin(ph * Math.PI * 2 + s.phase) * 0.14;
            s.sprite.position.y = s.baseY + ph * 1.3 + Math.sin(now * 0.0004 + s.phase) * 0.08;
            s.sprite.position.x = s.dx + drift * (1 - ph * 0.5);
            s.sprite.material.opacity = Math.sin(ph * Math.PI) * 0.22;
        });
    };

    const updateBeans = (now, p) => {
        beans.forEach((b) => {
            const t = now * 0.0006 * b.speed + b.phase;
            const rad = b.radius * (0.75 + splay);
            b.mesh.position.set(
                Math.cos(t) * rad,
                b.height + Math.sin(now * 0.001 + b.phase) * 0.16,
                Math.sin(t) * rad,
            );
            b.mesh.rotation.set(now * 0.0009 * b.spin + b.phase, now * 0.0013 * b.spin, 0);
            b.mesh.scale.setScalar(0.62 + splay * 0.4);
        });
    };

    const tick = (now) => {
        const dt = Math.min(0.05, (now - last) / 1000);
        last = now;

        if (heroVisible && !document.hidden) {
            const p = getProgress();

            if (tossStart >= 0) {
                const t = clamp((now - tossStart) / 1500, 0, 1);
                if (t < 1) {
                    const fly = Math.min(1, t / 0.7);
                    const settle = clamp((t - 0.7) / 0.3, 0, 1);
                    const fe = easeOutExpo(fly);
                    const arc = Math.sin(fly * Math.PI);
                    const bounce = Math.sin(settle * Math.PI * 3) * Math.pow(1 - settle, 2) * 0.4;
                    splay = 0.15 + fly * 0.15;

                    cup.position.set(lerp(SX, 0, fe), lerp(SY, 0, fe) + arc * 2.1 + bounce, lerp(SZ, 0, fe));
                    cup.rotation.x = lerp(-1.15, 0.28, fe);
                    cup.rotation.z = lerp(1.7, 0, fe);
                    cup.rotation.y = fly * Math.PI * 2.4 + spin;
                    cup.scale.setScalar(lerp(0.5, 1, fe));
                    beansGroup.rotation.z = -fly * 0.55;
                    beansGroup.rotation.x = fly * 0.2;
                } else {
                    spin = cup.rotation.y;
                    tossStart = -1;
                }
            } else {
                const speed = 0.35 + p * 2.1;
                spin += speed * dt;
                cup.rotation.y = spin;
                cup.rotation.x = lerp(cup.rotation.x, 0.28 - p * 0.55, 0.07);
                cup.rotation.z = lerp(cup.rotation.z, 0, 0.07);
                cup.position.x = lerp(cup.position.x, 0, 0.06);
                cup.position.z = lerp(cup.position.z, p * 0.55, 0.05);
                cup.position.y = lerp(cup.position.y, Math.sin(now * 0.0011) * 0.05 - p * 0.18, 0.06);
                cup.scale.setScalar(lerp(cup.scale.x, 1 - p * 0.05, 0.05));
                beansGroup.rotation.z = lerp(beansGroup.rotation.z, p * 0.25, 0.05);
                beansGroup.rotation.x = lerp(beansGroup.rotation.x, -p * 0.3, 0.05);
                splay = lerp(splay, 0.55 + p * 0.8, 0.05);
                shadowPlane.material.opacity = 0.3 - p * 0.12;
            }

            tiltGroup.rotation.x = lerp(tiltGroup.rotation.x, ty * 0.12, 0.06);
            tiltGroup.rotation.z = lerp(tiltGroup.rotation.z, -tx * 0.15, 0.06);

            cremaTexture.rotation = now * 0.0001;
            updateSteam(now);
            updateBeans(now, p);
        }

        renderer.render(scene, camera);
        if (running) raf = requestAnimationFrame(tick);
    };

    const startToss = () => {
        tossStart = performance.now();
    };

    if (reduced) {
        cup.position.set(0, 0, 0);
        cup.rotation.set(0.28, 0.6, 0);
        cup.scale.setScalar(1);
        splay = 0.5;
        updateBeans(performance.now(), 0);
        steams.forEach((s) => {
            s.sprite.position.y = s.baseY + 0.5;
            s.sprite.material.opacity = 0.12;
        });
        renderer.render(scene, camera);
        running = false;
        host.classList.add('is-ready');
        return;
    }

    const loader = document.querySelector('.loader');
    if (!loader) {
        setTimeout(startToss, 700);
    } else if (loader.classList.contains('is-done')) {
        startToss();
    } else {
        const mo = new MutationObserver(() => {
            if (loader.classList.contains('is-done')) {
                mo.disconnect();
                startToss();
            }
        });
        mo.observe(loader, { attributes: true, attributeFilter: ['class'] });
        setTimeout(() => {
            mo.disconnect();
            if (tossStart < 0) startToss();
        }, 3400);
    }

    document.addEventListener('visibilitychange', () => {
        last = performance.now();
    });

    host.classList.add('is-ready');
    raf = requestAnimationFrame(tick);

    return () => {
        running = false;
        cancelAnimationFrame(raf);
        io.disconnect();
        ro.disconnect();
        renderer.dispose();
    };
}