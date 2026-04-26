<?php require_once '../app/Views/layouts/header.php'; ?>

<!-- Stats Cards -->
<div class="dashboard-grid" style="margin-bottom: 1rem;">
    <div class="glass-card stats-card">
        <span class="stats-label"><i class="fas fa-users"></i> Total Empleados</span>
        <span class="stats-value text-gradient"><?php echo count($data['usuarios'] ?? []); ?></span>
    </div>
    <div class="glass-card stats-card">
        <span class="stats-label"><i class="fas fa-clipboard-check"></i> Registros Totales</span>
        <span class="stats-value" style="color: var(--primary);"><?php echo count($data['asistencias'] ?? []); ?></span>
    </div>
    <div class="glass-card stats-card">
        <span class="stats-label"><i class="fas fa-calendar-day"></i> Fecha Actual</span>
        <span class="stats-value"><?php echo date('d/m/Y'); ?></span>
    </div>
</div>

<!-- Panel de Administración -->
<div class="glass-card" style="padding: 1rem;">
    <h2 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--text);">
        <i class="fas fa-cog"></i> Panel de Administración
    </h2>
    
    <div class="admin-modules">
        <a href="<?php echo URL_BASE; ?>/admin/asistensias" class="admin-module-btn">
            <div class="admin-module-icon" style="background: linear-gradient(135deg, #69db7c, #40c057);">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <span>Asistencias</span>
        </a>

        <a href="<?php echo URL_BASE; ?>/admin/usuarios" class="admin-module-btn">
            <div class="admin-module-icon" style="background: linear-gradient(135deg, #74c0fc, #339af0);">
                <i class="fas fa-users-cog"></i>
            </div>
            <span>Usuarios</span>
        </a>
    </div>
</div>

<style>
.admin-modules {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.admin-module-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 120px;
    height: 120px;
    background: var(--glass);
    border: 1px solid var(--border);
    border-radius: 1rem;
    text-decoration: none;
    color: var(--text);
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px var(--shadow-color);
}

.admin-module-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px var(--shadow-color);
    border-color: var(--primary);
}

.admin-module-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

.admin-module-btn span {
    font-size: 0.9rem;
    font-weight: 600;
    margin-top: 0.3rem;
}
</style>

<?php require_once '../app/Views/layouts/footer.php'; ?>