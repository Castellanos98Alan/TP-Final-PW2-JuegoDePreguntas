<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntados Anime</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Roboto', sans-serif;
            color: #F3F5FA;
            background:
                    radial-gradient(ellipse at 15% 20%, rgba(31, 91, 160, 0.45), transparent 38%),
                    radial-gradient(ellipse at 85% 75%, rgba(18, 57, 110, 0.35), transparent 40%),
                    linear-gradient(135deg, #071329, #10294D 55%, #071329);
            background-attachment: fixed;
            overflow-x: hidden;
            position: relative;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            pointer-events: none;
            opacity: 0.5;
            z-index: 0;
        }

        body::before {
            width: 240px;
            height: 240px;
            top: 5%;
            left: -90px;
            border: 1px solid rgba(212, 175, 85, 0.5);
            border-radius: 50%;
            box-shadow: 0 0 0 18px rgba(212, 175, 85, 0.04),
            0 0 0 38px rgba(212, 175, 85, 0.03);
        }

        body::after {
            width: 180px;
            height: 180px;
            bottom: -90px;
            right: -50px;
            border: 1px solid #D4AF55;
            transform: rotate(45deg);
        }

        /* HEADER */
        .site-header {
            width: 100%;
            background: rgba(7, 20, 42, 0.95);
            border-bottom: 1px solid rgba(185, 139, 59, 0.4);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-emblem {
            width: 38px;
            height: 38px;
            border: 2px solid #D4AF55;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #F1CD73;
            font-size: 20px;
        }

        .brand-text h1 {
            font-family: 'Permanent Marker', cursive;
            font-size: 20px;
            color: #F1CD73;
            letter-spacing: 1px;
            line-height: 1;
        }

        .brand-text span {
            font-size: 10px;
            letter-spacing: 2.5px;
            color: #B6C9E6;
            font-weight: 700;
            display: block;
            margin-top: 2px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .user-greeting {
            color: #B6C9E6;
            font-size: 14px;
        }

        .user-greeting strong {
            color: #F1CD73;
        }

        .btn-link {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-outline {
            border: 1px solid #315B91;
            color: #DCE6F8;
            background: rgba(16, 39, 73, 0.4);
        }

        .btn-outline:hover {
            border-color: #D4AF55;
            color: #F1CD73;
        }

        .btn-gold {
            background: linear-gradient(110deg, #F4D47D, #C99A3D);
            color: #0A1A33;
            border: 1px solid #F5D78A;
        }

        .btn-gold:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        /* ÁREA CENTRAL */
        .main-content {
            flex: 1;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>

<header class="site-header">
    <div class="header-container">
        <a href="?controller=lobby&method=show" class="brand-link">
            <div class="brand-emblem" aria-hidden="true">✦</div>
            <div class="brand-text">
                <h1>PREGUNTADOS</h1>
                <span>ANIME EDITION</span>
            </div>
        </a>

        <nav class="nav-actions">
            <?php if (isset($_SESSION['usuario'])): ?>
                <span class="user-greeting">Hola, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong></span>
                <a href="?controller=login&method=logout" class="btn-link btn-outline">Cerrar Sesión</a>
            <?php else: ?>
                <a href="?controller=login&method=show" class="btn-link btn-outline">Ingresar</a>
                <a href="?controller=registro&method=show" class="btn-link btn-gold">Registrarse</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="main-content">