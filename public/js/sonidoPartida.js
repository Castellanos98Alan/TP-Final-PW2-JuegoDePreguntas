(function () {
    const boton = document.getElementById('controlSonido');
    const pregunta = document.getElementById('audioPregunta');
    if (!boton) return;
    let silenciado = false;
    try { silenciado = localStorage.getItem('preguntadosSilenciado') === '1'; } catch (_) {}
    const efecto = new Audio('public/audio/efecto-interfaz.wav');
    function actualizar() {
        boton.textContent = silenciado ? 'Activar sonido' : 'Silenciar sonido';
        boton.setAttribute('aria-pressed', String(silenciado));
        efecto.muted = silenciado;
        if (pregunta) pregunta.muted = silenciado;
    }
    boton.addEventListener('click', function () {
        silenciado = !silenciado;
        try { localStorage.setItem('preguntadosSilenciado', silenciado ? '1' : '0'); } catch (_) {}
        actualizar();
        if (!silenciado) { efecto.currentTime = 0; efecto.play().catch(function () {}); }
    });
    // Reproduce un efecto en una interacción real sin demorar el envío de respuestas.
    document.querySelectorAll('.respuesta-btn').forEach(function (respuesta) {
        respuesta.addEventListener('pointerdown', function () {
            if (!silenciado && !pregunta) { efecto.currentTime = 0; efecto.play().catch(function () {}); }
        });
    });
    actualizar();
})();
