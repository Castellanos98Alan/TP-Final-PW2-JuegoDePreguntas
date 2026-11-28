(() => {
    const audio = document.getElementById('musicaFondo');
    if (!audio) return;

    const lista = ['onepiece.mp3', 'naruto.mp3', 'dragonball.mp3', 'pokemon.mp3', 'demonslayer.mp3',
        'jujutsukaisen.mp3'];
    const boton = document.getElementById('abrirMusica');
    const panel = document.getElementById('panelMusica');
    const volumen = document.getElementById('volumenMusica');
    const valor = document.getElementById('valorMusica');
    const silencio = document.getElementById('silenciarMusica');
    const siguiente = document.getElementById('siguienteMusica');
    const estado = document.getElementById('estadoMusica');
    const clave = 'preguntadosMusicaProgreso';

    let guardado = {};
    try { guardado = JSON.parse(sessionStorage.getItem(clave) || '{}') || {}; }
    catch (_) {}
    let indice = lista.indexOf(guardado.archivo);
    if (indice === -1) indice = Math.floor(Math.random() * lista.length);
    let posicion = lista[indice] === guardado.archivo ? Number(guardado.segundo) || 0 : 0;
    let preparado = false;
    let ultimoGuardado = 0;

    volumen.value = localStorage.getItem('preguntadosMusicaVolumen') ?? 30;
    silencio.checked = localStorage.getItem('preguntadosMusicaMute') === '1';

    function ajustar() {
        audio.volume = Number(volumen.value) / 100;
        audio.muted = silencio.checked;
        valor.textContent = volumen.value + '%';
        localStorage.setItem('preguntadosMusicaVolumen', volumen.value);
        localStorage.setItem('preguntadosMusicaMute', silencio.checked ? '1' : '0');
    }

    function guardarProgreso() {
        sessionStorage.setItem(clave, JSON.stringify({
            archivo: lista[indice],
            segundo: preparado ? audio.currentTime : posicion
        }));
    }

    function cargarMusica(segundo = 0) {
        preparado = false;
        posicion = segundo;
        audio.src = 'public/audio/openings/' + lista[indice];
        guardarProgreso();
    }

    audio.addEventListener('loadedmetadata', () => {
        if (posicion > 0 && posicion < audio.duration) audio.currentTime = posicion;
        preparado = true;
    });

    async function reproducir() {
        try {
            await audio.play();
            estado.textContent = '';
        } catch (error) {
            if (error.name === 'AbortError') return;
            console.warn('Música:', error);
            estado.textContent = error.name === 'NotAllowedError'
                ? 'Hacé clic en la página para activar la música.'
                : 'No se pudo reproducir el opening.';
        }
    }

    audio.addEventListener('timeupdate', () => {
        if (Date.now() - ultimoGuardado >= 1000) {
            guardarProgreso();
            ultimoGuardado = Date.now();
        }
    });
    window.addEventListener('pagehide', guardarProgreso);
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) guardarProgreso();
    });

    function siguienteTema() {
        indice = (indice + 1 + Math.floor(Math.random() * (lista.length - 1))) % lista.length;

        cargarMusica();
        reproducir();
    }

    audio.addEventListener('ended', siguienteTema);

    siguiente?.addEventListener('click', siguienteTema);

    function abrir(visible) {
        panel.hidden = !visible;
        boton.setAttribute('aria-expanded', String(visible));
    }
    boton.addEventListener('click', () => abrir(panel.hidden));
    document.addEventListener('click', e => {
        if (!document.getElementById('musicaConfig').contains(e.target)) abrir(false);
        if (audio.paused) reproducir();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') abrir(false);
    });
    volumen.addEventListener('input', ajustar);
    silencio.addEventListener('change', () => {
        ajustar();
        if (!silencio.checked && audio.paused) reproducir();
    });

    ajustar();
    cargarMusica(posicion);
    reproducir();
})();
