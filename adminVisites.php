<?php
session_start();
require 'config.php';
if ($_SESSION['user_rol'] !== 'admin') exit("Sense permisos");
$result = $mysqli->query("SELECT * FROM visitas");
$visitas = $result->fetch_all(MYSQLI_ASSOC);
?>
<style>
    /* adminVisites - CSS limpio, moderno y profesional */
*{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;font-family:Inter, "Segoe UI", Roboto, Arial, sans-serif;background:#f6fbfa;color:#123;}

/* Layout general */
body{
  padding:28px;
  display:flex;
  justify-content:center;
}
.table-container{
  width:100%;
  max-width:1100px;
  margin:18px auto;
  background:#ffffff;
  border-radius:10px;
  padding:20px;
  border:1px solid rgba(16,40,36,0.04);
  box-shadow:0 14px 34px rgba(16,40,36,0.06);
}

/* Título */
h1{
  text-align:center;
  margin:12px 0 18px;
  font-size:1.6rem;
  color:#114a44;
  font-weight:700;
}

/* Botón "añadir" */
.add-btn{
  display:block;
  width:220px;
  margin:12px auto 18px;
  padding:10px 14px;
  background:linear-gradient(90deg,#1f6f61,#2a897e);
  color:#fff;
  text-align:center;
  text-decoration:none;
  font-weight:700;
  border-radius:8px;
  transition:transform .12s ease, box-shadow .12s ease;
  box-shadow:0 8px 20px rgba(42,137,126,0.08);
}
.add-btn:hover{ transform:translateY(-3px); box-shadow:0 14px 36px rgba(42,137,126,0.12); }

/* Tabla */
.table-container .table{
  width:100%;
  border-collapse:collapse;
  min-width:760px; /* permite scroll horizontal en móviles */
}
.table-container th,
.table-container td{
  padding:12px 14px;
  text-align:left;
  font-size:0.98rem;
  border-bottom:1px solid #eef3f2;
  vertical-align:middle;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}
.table-container thead th{
  background:#f0fbfa;
  color:#154f4a;
  font-weight:700;
  position:sticky;
  top:0;
  z-index:1;
}

/* Resaltado de fila al pasar el ratón */
.table-container tbody tr:hover{
  background:#f7fffd;
}

/* Mantener tus clases */
td.cuerpo{ max-width:220px; }
td.imagen{ max-width:180px; }
td.subtitulo{ max-width:140px; }

/* Enlaces / acciones */
a{ color:#0f766e; text-decoration:none; font-weight:600; }
a:hover{ color:#0b5e58; text-decoration:underline; }

/* Acciones en celda */
.actions-cell a{ margin-right:8px; }

/* Mensajes y texto secundario */
.muted{ color:#6b7a79; font-size:0.95rem; }

/* Responsive */
@media (max-width:900px){
  .table-container{ padding:14px; }
  .table-container .table{ min-width:640px; font-size:0.95rem; }
  .add-btn{ width:180px; }
}
@media (max-width:640px){
  h1{ font-size:1.25rem; }
  .table-container{ margin:12px; padding:12px; }
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