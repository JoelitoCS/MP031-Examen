<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Panel de Veterinario - HappyPets</title>
    <style>
        /* Reset ligero y tipografía */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
          font-family: Inter, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background: linear-gradient(180deg, #f6fbfa 0%, #eef6f4 100%);
          color: #20343a;
          -webkit-font-smoothing:antialiased;
          -moz-osx-font-smoothing:grayscale;
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 30px;
        }

        /* Contenedor principal */
        .admin-container {
          width: 100%;
          max-width: 980px;
          background: #ffffff;
          border-radius: 12px;
          box-shadow: 0 18px 40px rgba(20, 40, 40, 0.06);
          padding: 32px;
          border: 1px solid rgba(32,52,58,0.04);
        }

        /* Cabecera */
        .admin-header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 20px;
          margin-bottom: 8px;
        }

        .admin-title {
          font-size: 1.65rem;
          color: #154f4a; /* verde azulado profesional */
          font-weight: 700;
          letter-spacing: -0.2px;
        }

        .admin-subtitle {
          color: #4b5b59;
          margin-bottom: 20px;
          line-height: 1.45;
        }

        /* Contenedor de acciones (los enlaces) */
        .actions {
          display: flex;
          gap: 12px;
          flex-wrap: wrap;
          margin-top: 18px;
        }

        /* Botones principales */
        .btn {
          display: inline-flex;
          align-items: center;
          gap: 10px;
          padding: 10px 16px;
          text-decoration: none;
          border-radius: 10px;
          font-weight: 600;
          color: #ffffff;
          background: linear-gradient(135deg, #1f6f61 0%, #2a897e 100%);
          box-shadow: 0 8px 20px rgba(30, 110, 100, 0.12);
          transition: transform .12s ease, box-shadow .12s ease, opacity .12s ease;
          border: 1px solid rgba(0,0,0,0.03);
        }

        /* Variante secundaria: fondo claro */
        .btn.secondary {
          background: #ffffff;
          color: #154f4a;
          border: 1px solid rgba(21,79,74,0.08);
          box-shadow: none;
        }

        .btn:hover,
        .btn:focus {
          transform: translateY(-3px);
          box-shadow: 0 12px 30px rgba(30, 110, 100, 0.15);
          opacity: 0.98;
        }

        /* Pequeño bloque de ayuda/descripción */
        .card {
          margin-top: 22px;
          padding: 18px;
          border-radius: 10px;
          background: linear-gradient(180deg, rgba(36,88,80,0.02), rgba(36,88,80,0.01));
          border: 1px solid rgba(20,40,40,0.03);
        }

        .meta {
          color: #6a7b79;
          font-size: 0.95rem;
          margin-top: 6px;
        }

        /* Responsive */
        @media (max-width: 720px) {
          .admin-container { padding: 20px; }
          .admin-title { font-size: 1.35rem; }
          .actions { gap: 10px; }
          .btn { flex: 1 1 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <div>
                <h1 class="admin-title">Panel de Veterinarios</h1>
                <p class="admin-subtitle">Aquí podrás gestionar tu perfil y información de forma segura.</p>
            </div>
            <!-- Espacio para acciones rápidas o info de usuario -->
            <div class="meta">Usuario: <strong>Veterinario</strong></div>
        </div>

        <div class="actions">
            <a class="btn" href="vet_panel.php">Gestiona tu perfil</a>
            <a class="btn secondary" href="index.php">Volver al Panel Público</a>
        </div>

        <div class="card">
            <h2 style="font-size:1.05rem; color:#154f4a; margin-bottom:8px;">Resumen rápido</h2>
            <p class="meta">Desde aquí puedes editar tu perfil, ya sea tu nombre, email y contraseña de forma segura.</p>
        </div>
    </div>
</body>
</html>