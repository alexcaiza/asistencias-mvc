<?php require_once '../app/Views/layouts/header.php'; ?>

<div id="user-create-header" class="glass-card" style="margin-bottom: 1rem;">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="<?php echo URL_BASE; ?>/admin" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <h1 class="text-gradient" style="font-size: 1rem;">Registrar Nuevo Usuario</h1>
        </div>
        <button type="button" class="btn btn-secondary" onclick="resetForm()" title="Limpiar Formulario" style="padding: 0.5rem;">
            <i class="fas fa-eraser"></i>
        </button>
    </div>
</div>

<div id="user-create-container" class="glass-card" style="max-width: 600px; margin: 0 auto; padding: 0.5rem;">
    <?php if (isset($data['error'])): ?>
        <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; border: 1px solid rgba(239, 68, 68, 0.2);">
            <i class="fas fa-exclamation-circle"></i> <?php echo $data['error']; ?>
        </div>
    <?php endif; ?>

    <form id="user-create-form" action="<?php echo URL_BASE; ?>/admin/guardar" method="POST" autocomplete="off">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.3rem;">
            <div class="form-group">
                <label class="form-label">Nombre: <span style="color: var(--danger);">*</span></label>
                <input type="text" name="nombre" class="form-control" value="<?php echo $data['data']['nombre'] ?? ''; ?>" required autocomplete="off">
            </div>
            <div class="form-group">
                <label class="form-label">Apellido: <span style="color: var(--danger);">*</span></label>
                <input type="text" name="apellido" class="form-control" value="<?php echo $data['data']['apellido'] ?? ''; ?>" required autocomplete="off">
            </div>
        </div>

        <div class="form-group">
                <label class="form-label">DNI:</label>
                <input type="text" name="dni" class="form-control" value="<?php echo $data['data']['dni'] ?? ''; ?>" autocomplete="off">
            </div>

        <div class="form-group">
            <label class="form-label">Correo Electrónico: <span style="color: var(--danger);">*</span></label>
            <input type="email" name="email" class="form-control" value="<?php echo $data['data']['email'] ?? ''; ?>" required autocomplete="off">
        </div>

        <div class="form-group">
            <label class="form-label">Contraseña: <span style="color: var(--danger);">*</span></label>
            <div style="position: relative;">
                <input type="password" name="password" id="password" class="form-control" required placeholder="Min. 6 caracteres" autocomplete="new-password" style="padding-right: 2.5rem;">
                <i class="fas fa-eye toggle-pass" data-target="password" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); cursor: pointer;"></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Confirmar Contraseña: <span style="color: var(--danger);">*</span></label>
            <div style="position: relative;">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required placeholder="Repite la contraseña" autocomplete="new-password" style="padding-right: 2.5rem;">
                <i class="fas fa-eye toggle-pass" data-target="confirm_password" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); cursor: pointer;"></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Rol del Usuario: <span style="color: var(--danger);">*</span></label>
            <select name="rol_id" class="form-control" required>
                <option value="" disabled <?php echo !isset($data['data']['rol_id']) ? 'selected' : ''; ?>>Seleccione...</option>
                <option value="1" <?php echo (isset($data['data']['rol_id']) && $data['data']['rol_id'] == 1) ? 'selected' : ''; ?>>Administrador</option>
                <option value="2" <?php echo (isset($data['data']['rol_id']) && $data['data']['rol_id'] == 2) ? 'selected' : ''; ?>>Trabajador</option>
            </select>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-save"></i> Guardar Usuario
            </button>
        </div>
    </form>
</div>

<script>
function resetForm() {
    document.getElementById('user-create-form').reset();
}

document.querySelectorAll('.toggle-pass').forEach(item => {
    item.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
        this.style.color = type === 'text' ? 'var(--primary)' : 'var(--text-muted)';
    });
});
</script>

<?php require_once '../app/Views/layouts/footer.php'; ?>
