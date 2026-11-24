(() => {
    const audio = document.getElementById('musicaFondo');
    if (!audio) return;
    const lista = [
        ['One Piece — We Are!', 'onepiece.mp3'],
        ['Naruto — Blue Bird', 'naruto.mp3'],
        ['Dragon Ball Z — Cha-La Head-Cha-La', 'dragonball.mp3'],
        ['Pokémon — Opening 1', 'pokemon.mp3'],
        ['Kimetsu no Yaiba — Gurenge', 'kimetsu.mp3']
    ];
    const boton = document.getElementById('abrirMusica');
    const panel = document.getElementById('panelMusica');
    const volumen = document.getElementById('volumenMusica');
    const valor = document.getElementById('valorMusica');
    const silencio = document.getElementById('silenciarMusica');
    const play = document.getElementById('reproducirMusica');
    const estado = document.getElementById('estadoMusica');
    const leer = (k, defecto) => { try { return localStorage.getItem(k) ?? defecto; } catch (_) { return defecto; } };
    const guardar = (k,v) => { try { localStorage.setItem(k,v); } catch (_) {} };
    let indice = Math.floor(Math.random()*lista.length);
    let intentado = false;
    volumen.value = leer('preguntadosMusicaVolumen', '30');
    silencio.checked = leer('preguntadosMusicaMute','0') === '1';
    function ajustar() {
        audio.volume = Number(volumen.value)/100;
        audio.muted = silencio.checked;
        valor.textContent = volumen.value + '%';
        guardar('preguntadosMusicaVolumen', volumen.value);
        guardar('preguntadosMusicaMute', silencio.checked ? '1' : '0');
    }
    function cargar(i) {
        indice = i;
        audio.src = 'public/audio/openings/' + lista[i][1];
    }
    async function reproducir() {
        intentado = true;
        try { await audio.play(); estado.textContent = 'Reproduciendo: ' + lista[indice][0]; }
        catch (_) { estado.textContent = audio.error ? 'No se pudo cargar el MP3. Revisá la carpeta openings.' : 'Presioná Reproducir música para iniciar.'; }
    }
    function abrir(visible) { panel.hidden = !visible; boton.setAttribute('aria-expanded', String(visible)); }
    boton.addEventListener('click', () => abrir(panel.hidden));
    document.addEventListener('click', e => { if (!document.getElementById('musicaConfig').contains(e.target)) abrir(false); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && !panel.hidden) { abrir(false); boton.focus(); } });
    volumen.addEventListener('input', ajustar);
    silencio.addEventListener('change', () => { ajustar(); if (!silencio.checked && audio.paused) reproducir(); });
    play.addEventListener('click', () => { if (audio.paused) reproducir(); else audio.pause(); });
    audio.addEventListener('play', () => play.textContent = 'Pausar música');
    audio.addEventListener('pause', () => play.textContent = 'Reproducir música');
    audio.addEventListener('ended', () => { cargar((indice + 1 + Math.floor(Math.random()*(lista.length-1))) % lista.length); reproducir(); });
    ajustar(); cargar(indice);
    if (!silencio.checked) {
        audio.play().catch(() => { if (!intentado) estado.textContent = 'Hacé clic para iniciar la música.'; });
        document.addEventListener('click', e => { if (!intentado && !silencio.checked && audio.paused && !e.target.closest('#musicaConfig')) reproducir(); }, {once:true});
    }
})();
