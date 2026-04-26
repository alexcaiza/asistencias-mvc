<?php require_once '../app/Views/layouts/header.php'; ?>

<style>
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.toast {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    animation: slideIn 0.3s ease, fadeOut 0.3s ease 2.7s forwards;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    min-width: 300px;
}

.toast-success {
    background: linear-gradient(135deg, #69db7c, #40c057);
}

.toast-error {
    background: linear-gradient(135deg, #ff8787, #fa5252);
}

.toast-warning {
    background: linear-gradient(135deg, #ffd43b, #fab005);
    color: #333;
}

.toast-info {
    background: linear-gradient(135deg, #74c0fc, #339af0);
}

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}
</style>

<div id="toast-container" class="toast-container"></div>

<div class="glass-card" style="max-width: 500px; margin: 2rem auto; padding: 2rem;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <i class="fas fa-fingerprint" style="font-size: 4rem; color: var(--primary); margin-bottom: 1rem;"></i>
        <h1 class="text-gradient" style="font-size: 1.5rem;">Registro de Asistencia</h1>
        <p style="color: var(--text-muted);">Ingresa tu DNI para registrar tu entrada o salida</p>
    </div>

    <form action="<?php echo URL_BASE; ?>/work/marcar" method="POST" autocomplete="off" id="marcarForm">
        <div class="form-group">
            <label class="form-label" style="text-align: center; display: block;">Número de DNI</label>
            <input type="text" name="dni" id="dniInput" class="form-control" placeholder="Ej: 12345678" required autofocus style="text-align: center; font-size: 1.5rem; padding: 1rem; letter-spacing: 2px;">
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; margin-top: 1rem;">
            <i class="fas fa-check-circle"></i> REGISTRAR ASISTENCIA
        </button>
    </form>

    <div style="margin-top: 2rem; text-align: center; color: var(--text-muted); font-size: 0.85rem;">
        <p><i class="fas fa-clock"></i> Horario de entrada: hasta 08:15 AM</p>
    </div>
</div>

<div style="text-align: center; margin-top: 2rem;">
    <a href="<?php echo URL_BASE; ?>/auth" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
        <i class="fas fa-user"></i> Acceso Administradores
    </a>
</div>

<script>
function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    let icon = '';
    switch(type) {
        case 'success': icon = '<i class="fas fa-check-circle"></i>'; break;
        case 'error': icon = '<i class="fas fa-exclamation-circle"></i>'; break;
        case 'warning': icon = '<i class="fas fa-exclamation-triangle"></i>'; break;
        default: icon = '<i class="fas fa-info-circle"></i>';
    }
    
    toast.innerHTML = `${icon} <span>${message}</span>`;
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

<?php if (isset($data['success']) && $data['success']): ?>
    showToast('¡<?php echo ($data['tipo'] ?? '') == 'entrada' ? 'Entrada' : 'Salida'; ?> registrada correctamente!', 'success');
<?php elseif (isset($data['error'])): ?>
    showToast('<?php echo addslashes($data['error']); ?>', 'error');
<?php elseif (isset($data['warning'])): ?>
    showToast('<?php echo addslashes($data['warning']); ?>', 'warning');
<?php endif; ?>
</script>

<?php require_once '../app/Views/layouts/footer.php'; ?>