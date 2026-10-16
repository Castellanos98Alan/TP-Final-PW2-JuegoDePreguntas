</main>

<style>
    .site-footer {
        width: 100%;
        background: rgba(5, 14, 30, 0.95);
        border-top: 1px solid rgba(58, 86, 128, 0.4);
        padding: 20px;
        margin-top: auto;
        position: relative;
        z-index: 10;
    }

    .footer-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        text-align: center;
        color: #86A6D3;
        font-size: 12px;
        letter-spacing: 1px;
    }

    .footer-emblem {
        color: #D4AF55;
        font-size: 15px;
        margin-right: 6px;
    }

    .footer-links {
        display: flex;
        gap: 20px;
        list-style: none;
    }

    .footer-links a {
        color: #B6C9E6;
        text-decoration: none;
        font-size: 12px;
        transition: color 0.2s;
    }

    .footer-links a:hover {
        color: #F1CD73;
    }

    @media (min-width: 600px) {
        .footer-inner {
            flex-direction: row;
            justify-content: space-between;
        }
    }
</style>

<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <span class="footer-emblem" aria-hidden="true">✦</span>
            <span>EL CONOCIMIENTO TAMBIÉN ES PODER</span>
        </div>
        <ul class="footer-links">
            <li><a href="?controller=lobby&method=show">Lobby</a></li>
            <li><a href="?controller=ranking&method=show">Ranking</a></li>
        </ul>
        <div>
            <p>&copy; 2026 Preguntados Anime</p>
        </div>
    </div>
</footer>

</body>
</html>