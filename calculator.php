<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8">
    <title>Kalkulace 3D tisku</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
      .calc-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
        align-items: flex-start;
        padding: 30px;
      }

      .form-box {
        background-color: #f4f4f4;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 350px;
        width: 100%;
      }

      #viewer {
        width: 600px;
        height: 400px;
        border: 1px solid #ccc;
        background-color: #f0f0f0;
        border-radius: 8px;
      }

      #result {
        background-color: #fff;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
        line-height: 1.6;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      }
    </style>
  </head>
  <body>
  <?php include 'header.php'; ?>
    <main>
      <div class="calc-container">
        <div class="form">
        <h2>Nezávazná kalkulace ceny 3D tisku</h2>
          <form id="calc-form">
            <div class="form-group">
              <label for="model">Model (STL):</label>
              <input type="file" id="model" name="model" accept=".stl,.obj" required>
            </div>
            <div class="form-group">
              <label for="material">Materiál:</label>
              <select name="material" id="material" required>
                <option value="">-- vyberte --</option>
                <option value="PLA">PLA</option>
                <option value="PETG">PETG</option>
                <option value="ASA/ABS">ASA/ABS</option>
              </select>
            </div>
            <button type="submit">Vypočítat cenu</button>
          </form>
          <div id="result"></div>
          </div>
        <div id="viewer"></div>
      </div>
    </main>

  <script src="https://cdn.jsdelivr.net/npm/three@0.138.0/build/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.138.0/examples/js/loaders/STLLoader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.138.0/examples/js/controls/OrbitControls.js"></script>

  <script>
    const viewer = document.getElementById("viewer");
    const input = document.getElementById("model");
    const form = document.getElementById("calc-form");
    const result = document.getElementById("result");

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, viewer.clientWidth / viewer.clientHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(viewer.clientWidth, viewer.clientHeight);
    renderer.setClearColor(0xf0f0f0);
    viewer.appendChild(renderer.domElement);

    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    scene.add(new THREE.AmbientLight(0xffffff, 1.5));
    camera.position.set(0, 0, 100);
    controls.update();

    let mesh = null;

    input.addEventListener('change', function () {
      const file = input.files[0];
      if (!file || !file.name.match(/\.stl$/i)) {
        alert("Vyberte STL soubor.");
        return;
      }
      const reader = new FileReader();
    reader.onload = function (event) {
      if (mesh) scene.remove(mesh);

      const geometry = new THREE.STLLoader().parse(event.target.result);
      mesh = new THREE.Mesh(geometry, new THREE.MeshNormalMaterial());
      mesh.rotation.x = -0.5 * Math.PI;
      scene.add(mesh);
      centerAndZoom(mesh);
    };

    reader.readAsArrayBuffer(file);

    });

    function centerAndZoom(object) {
      const box = new THREE.Box3().setFromObject(object);
      const size = box.getSize(new THREE.Vector3()).length();
      const center = box.getCenter(new THREE.Vector3());
      object.position.sub(center);
      camera.position.set(50, 50, size * 0.5);
      controls.target.set(0, 0, 0);
      controls.update();
    }

    function animate() {
      requestAnimationFrame(animate);
      controls.update();
      renderer.render(scene, camera);
    }
    animate();

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(form);
      fetch("process_calculation.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.text())
      .then(data => {
        try {
          const parsed = JSON.parse(data);
          if (parsed.error) {
            result.innerHTML = `<p class="error">${parsed.error}</p>`;
          } else {
            result.innerHTML = `
              <h3>Výsledek kalkulace</h3>
              <ul>
                <li><strong>Název souboru:</strong> ${input.files[0].name}</li>
                <li>Rozměry: ${parsed.width_mm} x ${parsed.height_mm} x ${parsed.depth_mm} mm</li>
                <li>Objem: ${parsed.volume_cm3} cm³</li>
                <li><strong>Odhadovaná cena: ${parsed.price_estimate} Kč</strong></li>
              </ul>
            `;
          }
        } catch (e) {
          result.innerHTML = `<p class="error">Neplatný výstup serveru:<br><pre>${data}</pre></p>`;
        }
      })
      .catch(err => {
        result.innerHTML = `<p class="error">Chyba komunikace: ${err}</p>`;
      });
    });
  </script>
  <?php include 'footer.php'; ?>
  </body>
</html>
