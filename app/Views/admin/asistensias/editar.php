<?php require_once '../app/Views/layouts/header.php'; ?>

<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="<?php echo URL_BASE; ?>/admin" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-gradient">Editar Asistencia</h1>
    </div>
</div>

<div class="glass-card" style="max-width: 600px; margin: 0 auto;">
    <form action="<?php echo URL_BASE; ?>/admin/actualizarAsistencia/<?php echo $data['asistencia']['id']; ?>" method="POST">
        <div class="form-group">
            <label class="form-label">Empleado</label>
            <select name="usuario_id" class="form-control" required>
                <?php foreach ($data['usuarios'] as $usuario): ?>
                    <option value="<?php echo $usuario['id']; ?>" <?php echo ($usuario['id'] == $data['asistencia']['usuario_id']) ? 'selected' : ''; ?>>
                        <?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="<?php echo $data['asistencia']['fecha']; ?>" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label">Hora de Entrada</label>
                <input type="time" name="hora_entrada" class="form-control" value="<?php echo $data['asistencia']['hora_entrada']; ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Hora de Salida</label>
                <input type="time" name="hora_salida" class="form-control" value="<?php echo $data['asistencia']['hora_salida'] ?? ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="A tiempo" <?php echo ($data['asistencia']['estado'] == 'A tiempo') ? 'selected' : ''; ?>>A tiempo</option>
                <option value="Tarde" <?php echo ($data['asistencia']['estado'] == 'Tarde') ? 'selected' : ''; ?>>Tarde</option>
                <option value="Faltó" <?php echo ($data['asistencia']['estado'] == 'Faltó') ? 'selected' : ''; ?>>Faltó</option>
            </select>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-save"></i> Actualizar Asistencia
            </button>
        </div>
    </form>
</div>

<?php require_once '../app/Views/layouts/footer.php'; ?>