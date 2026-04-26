<?php require_once '../app/Views/layouts/header.php'; ?>

<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="<?php echo URL_BASE; ?>/admin" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-gradient">Editar Usuario</h1>
    </div>
</div>

<div class="glass-card" style="max-width: 600px; margin: 0 auto;">
    <?php if (isset($data['error'])): ?>
        <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; border: 1px solid rgba(239, 68, 68, 0.2);">
            <i class="fas fa-exclamation-circle"></i> <?php echo $data['error']; ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo URL_BASE; ?>/admin/actualizar/<?php echo $data['usuario']['id']; ?>" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo $data['usuario']['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control" value="<?php echo $data['usuario']['apellido']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">DNI</label>
            <input type="text" name="dni" class="form-control" value="<?php echo $data['usuario']['dni'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" value="<?php echo $data['usuario']['email']; ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Nueva Contraseña (Opcional)</label>
            <div style="position: relative;">
                <input type="password" name="password" id="password" class="form-control" placeholder="Dejar en blanco para no cambiar" style="padding-right: 2.5rem;">
                <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); cursor: pointer;"></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Estado de la cuenta</label>
            <select name="status" class="form-control" required>
                <option value="1" <?php echo $data['usuario']['status'] == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $data['usuario']['status'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-sync-alt"></i> Actualizar Usuario
            </button>
        </div>
    </form>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
        this.style.color = type === 'text' ? 'var(--primary)' : 'var(--text-muted)';
    });
</script>

<?php require_once '../app/Views/layouts/footer.php'; ?>
