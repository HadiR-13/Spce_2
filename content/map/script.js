function createStars() {
  const container = document.querySelector("body");
  for (let i = 0; i < 1000; i++) {
    // Increase the number of stars to 1000
    const star = document.createElement("div");
    star.className = "star";
    star.style.width = ".1px";
    star.style.height = ".1px";
    star.style.top = Math.random() * 100 + "%";
    star.style.left = Math.random() * 100 + "%";
    container.appendChild(star);
  }
}
createStars();

function launchSpaceship() {
  const earthIcon = document.querySelector(".earth-body");
  const moonIcon = document.querySelector(".moon-body");
  const container = document.querySelector(".container");

  const spaceship = document.createElement("div");
  spaceship.className = "spaceship";

  const earthRect = earthIcon.getBoundingClientRect();
  const moonRect = moonIcon.getBoundingClientRect();
  const containerRect = container.getBoundingClientRect();

  // Ambil skala transform dari container
  const style = window.getComputedStyle(container);
  const matrix = new DOMMatrixReadOnly(style.transform);
  const scale = matrix.a;

  // Hitung posisi pusat Earth dan Moon relatif terhadap container (tanpa skala)
  const startX = (earthRect.left + earthRect.width / 2 - containerRect.left) / scale;
  const startY = (earthRect.top + earthRect.height / 2 - containerRect.top) / scale;

  const targetX = (moonRect.left + moonRect.width / 2 - containerRect.left) / scale;
  const targetY = (moonRect.top + moonRect.height / 2 - containerRect.top) / scale;

  // Set posisi awal spaceship
  spaceship.style.left = `${startX}px`;
  spaceship.style.top = `${startY}px`;

  container.appendChild(spaceship);

  // Hitung arah pergerakan menggunakan vektor
  let dx = targetX - startX;
  let dy = targetY - startY;
  const distance = Math.sqrt(dx * dx + dy * dy);

  // Normalisasi dan beri kecepatan
  dx /= distance;
  dy /= distance;
  const speed = 0.1;
  dx *= speed;
  dy *= speed;

  let posX = startX;
  let posY = startY;

  function move() {
    posX += dx;
    posY += dy;

    spaceship.style.left = `${posX}px`;
    spaceship.style.top = `${posY}px`;

    createSmoke(posX, posY);

    // Jika sudah dekat dengan bulan, hentikan
    if (Math.abs(posX - targetX) < 2 && Math.abs(posY - targetY) < 2) {
      spaceship.remove();
      clearInterval(fly);
    }
  }

  function createSmoke(x, y) {
    const smoke = document.createElement("div");
    smoke.className = "smoke";
    smoke.style.left = `${x}px`;
    smoke.style.top = `${y}px`;
    container.appendChild(smoke);
    setTimeout(() => smoke.remove(), 500);
  }

  const fly = setInterval(move, 16);
}

window.addEventListener("load", () => {
  setTimeout(launchSpaceship, 1000);
});

function launchToMercury() {
  const earthIcon = document.querySelector(".earth-body");
  const mercuryIcon = document.querySelector(".mercury-body");
  const container = document.querySelector(".container");

  const spaceship = document.createElement("div");
  spaceship.className = "spaceship";

  const earthRect = earthIcon.getBoundingClientRect();
  const mercuryRect = mercuryIcon.getBoundingClientRect();
  const containerRect = container.getBoundingClientRect();

  const style = window.getComputedStyle(container);
  const matrix = new DOMMatrixReadOnly(style.transform);
  const scale = matrix.a;

  const startX = (earthRect.left + earthRect.width / 2 - containerRect.left) / scale;
  const startY = (earthRect.top + earthRect.height / 2 - containerRect.top) / scale;

  const targetX = (mercuryRect.left + mercuryRect.width / 2 - containerRect.left) / scale;
  const targetY = (mercuryRect.top + mercuryRect.height / 2 - containerRect.top) / scale;

  // Titik kontrol untuk membuat lengkungan (bezier), ditarik ke atas agar tidak nabrak matahari
  const controlX = (startX + targetX) / 1.7;
  const controlY = Math.min(startY, targetY) - 10 * scale; // Naikkan lintasan

  let t = 0; // parameter untuk animasi bezier (0..1)

  container.appendChild(spaceship);

  function bezier(t, p0, p1, p2) {
    return (1 - t) * (1 - t) * p0 + 2 * (1 - t) * t * p1 + t * t * p2;
  }

  function move() {
    if (t >= 1) {
      spaceship.remove();
      clearInterval(fly);
      return;
    }

    const x = bezier(t, startX, controlX, targetX);
    const y = bezier(t, startY, controlY, targetY);

    spaceship.style.left = `${x}px`;
    spaceship.style.top = `${y}px`;

    createSmoke(x, y);

    t += 0.005; // kecepatan
  }

  function createSmoke(x, y) {
    const smoke = document.createElement("div");
    smoke.className = "smoke";
    smoke.style.left = `${x}px`;
    smoke.style.top = `${y}px`;
    container.appendChild(smoke);
    setTimeout(() => smoke.remove(), 500);
  }

  const fly = setInterval(move, 16);
}
window.addEventListener("load", () => {
  setTimeout(launchToMercury, 1000); // ke Merkurius, delay dikit biar jelas
});

function launchToVenus() {
  const earthIcon = document.querySelector(".earth-body");
  const venusIcon = document.querySelector(".venus-body");
  const container = document.querySelector(".container");

  const spaceship = document.createElement("div");
  spaceship.className = "spaceship";

  const earthRect = earthIcon.getBoundingClientRect();
  const venusRect = venusIcon.getBoundingClientRect();
  const containerRect = container.getBoundingClientRect();

  const style = window.getComputedStyle(container);
  const matrix = new DOMMatrixReadOnly(style.transform);
  const scale = matrix.a;

  const startX = (earthRect.left + earthRect.width / 2 - containerRect.left) / scale;
  const startY = (earthRect.top + earthRect.height / 2 - containerRect.top) / scale;

  const targetX = (venusRect.left + venusRect.width / 2 - containerRect.left) / scale;
  const targetY = (venusRect.top + venusRect.height / 2 - containerRect.top) / scale;

  // --- Dua control point agar curve smooth dari awal sampai akhir ---
  const controlOffsetX = 80; // Semakin besar semakin melengkung
  const controlOffsetY = 5; // Semakin besar semakin melengkung ke atas

  const controlX1 = startX - controlOffsetX;
  const controlY1 = startY - controlOffsetY;

  const controlX2 = targetX - controlOffsetX;
  const controlY2 = targetY - controlOffsetY;

  let t = 0;

  container.appendChild(spaceship);

  // Cubic bezier dengan 2 control points
  function cubicBezier(t, p0, p1, p2, p3) {
    const u = 1 - t;
    return u ** 3 * p0 + 3 * u ** 2 * t * p1 + 3 * u * t ** 2 * p2 + t ** 3 * p3;
  }

  function move() {
    if (t >= 1) {
      spaceship.remove();
      clearInterval(fly);
      return;
    }

    const x = cubicBezier(t, startX, controlX1, controlX2, targetX);
    const y = cubicBezier(t, startY, controlY1, controlY2, targetY);

    spaceship.style.left = `${x}px`;
    spaceship.style.top = `${y}px`;

    createSmoke(x, y);

    t += 0.004; // kecepatan
  }

  function createSmoke(x, y) {
    const smoke = document.createElement("div");
    smoke.className = "smoke";
    smoke.style.left = `${x}px`;
    smoke.style.top = `${y}px`;
    container.appendChild(smoke);
    setTimeout(() => smoke.remove(), 500);
  }

  const fly = setInterval(move, 16);
}

window.addEventListener("load", () => {
  setTimeout(launchToVenus, 1000);
});

function launchToMars() {
  const earthIcon = document.querySelector(".earth-body");
  const marsIcon = document.querySelector(".mars-body");
  const container = document.querySelector(".container");

  const spaceship = document.createElement("div");
  spaceship.className = "spaceship";

  const earthRect = earthIcon.getBoundingClientRect();
  const marsRect = marsIcon.getBoundingClientRect();
  const containerRect = container.getBoundingClientRect();

  const style = window.getComputedStyle(container);
  const matrix = new DOMMatrixReadOnly(style.transform);
  const scale = matrix.a;

  const startX = (earthRect.left + earthRect.width / 2 - containerRect.left) / scale;
  const startY = (earthRect.top + earthRect.height / 2 - containerRect.top) / scale;

  const targetX = (marsRect.left + marsRect.width / 2 - containerRect.left) / scale;
  const targetY = (marsRect.top + marsRect.height / 2 - containerRect.top) / scale;

  // --- Dua control point agar curve smooth dari awal sampai akhir ---
  const controlOffsetX = 20; // Semakin besar semakin melengkung
  const controlOffsetY = 2; // Semakin besar semakin melengkung ke atas

  const controlX1 = startX - controlOffsetX;
  const controlY1 = startY - controlOffsetY;

  const controlX2 = targetX - controlOffsetX;
  const controlY2 = targetY - controlOffsetY;

  let t = 0;

  container.appendChild(spaceship);

  // Cubic bezier dengan 2 control points
  function cubicBezier(t, p0, p1, p2, p3) {
    const u = 1 - t;
    return u ** 3 * p0 + 3 * u ** 2 * t * p1 + 3 * u * t ** 2 * p2 + t ** 3 * p3;
  }

  function move() {
    if (t >= 1) {
      spaceship.remove();
      clearInterval(fly);
      return;
    }

    const x = cubicBezier(t, startX, controlX1, controlX2, targetX);
    const y = cubicBezier(t, startY, controlY1, controlY2, targetY);

    spaceship.style.left = `${x}px`;
    spaceship.style.top = `${y}px`;

    createSmoke(x, y);

    t += 0.004; // kecepatan
  }

  function createSmoke(x, y) {
    const smoke = document.createElement("div");
    smoke.className = "smoke";
    smoke.style.left = `${x}px`;
    smoke.style.top = `${y}px`;
    container.appendChild(smoke);
    setTimeout(() => smoke.remove(), 500);
  }

  const fly = setInterval(move, 16);
}

window.addEventListener("load", () => {
  setTimeout(launchToMars, 1000);
});
