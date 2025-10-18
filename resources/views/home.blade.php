<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Proyecto Enfermedades</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 40px;
      background: black;
      overflow: hidden;
      position: relative;
      animation: fadeIn 1s ease-in;
      color: white;
    }

    h1 {
      font-size: 2.8em;
      background: linear-gradient(270deg, #ff00cc, #3333ff, #00ffff, #ff00cc);
      background-size: 600% 600%;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: gradientShift 6s ease infinite, slideDown 0.8s ease-out;
      text-align: center;
    }

    .contenido-central {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      margin-top: 40px;
    }

    .contenido-central p {
      font-size: 1.2em;
      margin-bottom: 10px;
    }

    .contenido-central ul {
      list-style: "🌠 ";
      padding-left: 0;
      margin: 0;
    }

    .contenido-central li {
      margin-bottom: 8px;
      font-size: 1.2em;
    }

    .botones-linea {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 40px;
      flex-wrap: wrap;
    }

    .boton-magico {
      padding: 14px 24px;
      background: linear-gradient(135deg, #1d1a40, #3f3fff);
      color: white;
      text-decoration: none;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
      font-size: 1.1em;
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      opacity: 0;
      transform: translateY(30px);
      animation: aparecerBoton 0.8s ease forwards;
    }

    .boton-magico:hover {
      transform: scale(1.08);
      box-shadow: 0 0 25px rgba(0, 255, 255, 0.6);
    }

    .boton-magico:nth-child(1) { animation-delay: 0.3s; }
    .boton-magico:nth-child(2) { animation-delay: 0.6s; }
    .boton-magico:nth-child(3) { animation-delay: 0.9s; }

    #musica-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #1a1a40;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 50px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.5);
      cursor: pointer;
      z-index: 10;
    }

    #avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      margin: 20px auto;
      display: block;
    }

    canvas {
      position: fixed;
      top: 0;
      left: 0;
      z-index: -2;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideDown {
      from { transform: translateY(-30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes aparecerBoton {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <canvas id="galaxia"></canvas>

  <h1>Bienvenido al Proyecto Enfermedades</h1>
  <img id="avatar" src="https://api.dicebear.com/7.x/adventurer/svg?seed=Jean" alt="Avatar animado">

  <div class="contenido-central">
    <p>Este prototipo incluye:</p>
    <ul>
      <li>Gestión de enfermedades</li>
      <li>Historial de accesos (login)</li>
      <li>Usuarios del sistema</li>
    </ul>
  </div>

  <div class="botones-linea">
    <a href="{{ route('enfermedades.index') }}" class="boton-magico">📋 Ver enfermedades</a>
    <a href="{{ route('enfermedades.create') }}" class="boton-magico">➕ Registrar enfermedad</a>
    <a href="{{ route('logins.index') }}" class="boton-magico">🕒 Historial de accesos</a>
  </div>

  <audio id="musica" autoplay loop>
    <source src="musica/magia.mp3" type="audio/mpeg">
    Tu navegador no soporta audio HTML5.
  </audio>
  <button id="musica-btn" onclick="toggleMusica()">🎵</button>

  <script>
    const canvas = document.getElementById('galaxia');
    const ctx = canvas.getContext('2d');
    let w = canvas.width = window.innerWidth;
    let h = canvas.height = window.innerHeight;
    let estrellas = [];

    for (let i = 0; i < 150; i++) {
      estrellas.push({
        x: Math.random() * w,
        y: Math.random() * h,
        r: Math.random() * 1.5 + 0.5,
        dx: (Math.random() - 0.5) * 0.2,
        dy: (Math.random() - 0.5) * 0.2
      });
    }

    function dibujarGalaxia() {
      ctx.clearRect(0, 0, w, h);
      let grad = ctx.createRadialGradient(w/2, h/2, 0, w/2, h/2, w/2);
      grad.addColorStop(0, "#220033");
      grad.addColorStop(1, "#000000");
      ctx.fillStyle = grad;
      ctx.fillRect(0, 0, w, h);

      ctx.fillStyle = "white";
      estrellas.forEach(e => {
        ctx.beginPath();
        ctx.arc(e.x, e.y, e.r, 0, Math.PI * 2);
        ctx.fill();
        e.x += e.dx;
        e.y += e.dy;
        if (e.x < 0 || e.x > w) e.dx *= -1;
        if (e.y < 0 || e.y > h) e.dy *= -1;
      });

      requestAnimationFrame(dibujarGalaxia);
    }
    dibujarGalaxia();

    canvas.addEventListener('click', e => {
      const x = e.clientX;
      const y = e.clientY;
      const nuevas = [];
      for (let i = 0; i < 5; i++) {
        const estrella = {
          x: x + Math.random() * 50 - 25,
          y: y + Math.random() * 50 - 25,
          r: 2,
          dx: 0,
          dy: 0
        };
        estrellas.push(estrella);
        nuevas.push(estrella);
      }
      ctx.strokeStyle = "rgba(255,255,255,0.5)";
      ctx.beginPath();
      ctx.moveTo(nuevas[0].x, nuevas[0].y);
      nuevas.forEach(p => ctx.lineTo(p.x, p.y));
      ctx.stroke();
    });

    const musica = document.getElementById('musica');
    function toggleMusica() {
      musica.paused ? musica.play() : musica.pause();
    }

    function cambiarAvatar() {
      const estilos = ["adventurer", "pixel-art", "bottts", "notionists"];
      const estilo = estilos[Math.floor(Math.random() * estilos.length)];
      document.getElementById("avatar").src = `https://api.dicebear.com/7.x/${estilo}/svg?seed=Jean`;
    }

    function buscarEnfermedad() {
      const nombre = document.getElementById('busqueda').value;
      window.location.href = `/enfermedades?nombre=${encodeURIComponent(nombre)}`;
    }
  </script>

  <input type="text" id="busqueda"