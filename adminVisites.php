<?php
session_start();
require 'config.php';
if ($_SESSION['user_rol'] !== 'admin') exit("Sense permisos");
$result = $mysqli->query("SELECT * FROM visitas");
$visitas = $result->fetch_all(MYSQLI_ASSOC);
?>
<style>
   /* Ajuste de paleta y formato para adminAnimales.php */
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; font-family: 'Segoe UI', Roboto, Arial, sans-serif; background: linear-gradient(135deg,#eaf6f5 0%,#d8eef8 100%); color: #123; }

/* Mantengo la disposición original pero con card clara */
.table-container {
  max-width: 1100px;
  margin: 28px auto 60px;
  background: #ffffff;
  border-radius: 12px;
  padding: 28px;
  box-shadow: 0 12px 28px rgba(16,36,42,0.06);
  border: 1px solid rgba(16,36,42,0.04);
  overflow-x: auto;
}

/* Título */
h1 {
  text-align: center;
  margin-top: 28px;
  margin-bottom: 8px;
  font-size: 2rem;
  color: #0b5560; /* verde/azulado más serio */
  letter-spacing: 0.5px;
  font-weight: 700;
}

/* Botón "añadir" */
.add-btn {
  display: block;
  width: 220px;
  margin: 18px auto 26px;
  padding: 12px 0;
  background: linear-gradient(90deg, #0b5560 0%, #2b8f95 100%);
  color: #fff;
  text-align: center;
  text-decoration: none;
  font-size: 1rem;
  font-weight: 600;
  border-radius: 10px;
  box-shadow: 0 8px 20px rgba(43,143,149,0.12);
  transition: transform .14s ease, box-shadow .14s ease;
}
.add-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 14px 32px rgba(43,143,149,0.16);
}

/* Tabla */
table {
  width: 100%;
  border-collapse: collapse;
  color: #233a39;
  font-size: 0.98rem;
  table-layout: auto;
  min-width: 720px;
}

th, td {
  padding: 12px 14px;
  text-align: left;
  vertical-align: middle;
  border-bottom: 1px solid #eef6f6;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Cabeceras */
th {
  background: linear-gradient(180deg,#f3faf9,#e9f6f6);
  color: #0b5560;
  font-weight: 700;
  position: sticky;
  top: 0;
  z-index: 2;
}

/* Filas */
tr:hover {
  background: rgba(43,143,149,0.05);
}

/* Anchos respetando tus clases */
td.cuerpo { max-width: 220px; }
td.imagen { max-width: 180px; }
td.subtitulo { max-width: 140px; }

/* Enlaces / acciones con acento coral verde-azulado */
a {
  color: #1f6f6b;
  text-decoration: none;
  font-weight: 600;
}
a:hover {
  color: #0b4b47;
  text-decoration: underline;
}

/* Texto secundario */
.muted { color: #6b7b7a; font-size: 0.95rem; }

/* Responsiveness */
@media (max-width: 900px) {
  .table-container { padding: 18px; }
  table { min-width: 600px; font-size: 0.95rem; }
  .add-btn { width: 180px; }
}
@media (max-width: 640px) {
  body { padding: 12px; }
  h1 { font-size: 1.4rem; margin-top: 18px; }
  .table-container { margin: 12px; padding: 12px; }
  table { min-width: 520px; }
}
</style>
<h1>Visitas</h1>
<a class="add-btn" href="addAnimales.php">+ Añadir Visitas</a>
<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>ID Animal</th>
            <th>ID Veterinario</th>
            <th>Fecha</th>
            <th>Diagnóstico</th>
            <th>Tratamiento</th>
            <th>Fecha de publicación</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($visitas as $v): ?>
            <tr>
                <td><?= $v['id'] ?></td>
                <td><?= $v['animal_id'] ?></td>
                <td class="subtitulo"><?= $v['veterinario_id'] ?></td>
                <td class="cuerpo"><?= $v['fecha'] ?></td>
                <td><?= $v['diagnostico'] ?></td>
                <td class="imagen"><?= $v['tratamiento'] ?></td>
                <td><?= $v['created_at'] ?></td>
                <td>
                    <a href="editVisitas.php?id=<?= $v['id'] ?>">Editar</a> |
                    <a onclick="return confirm('¿Seguro que quieres eliminar este registro?')" href="deleteVisitas.php?id=<?= $v['id'] ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>