<?php require_once '../app/Views/layouts/header.php'; ?>

<div class="glass-card" style="margin-bottom: 1rem; padding: 0.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="<?php echo URL_BASE; ?>/admin" class="btn btn-secondary" style="padding: 0.4rem 0.8rem;" title="Volver al panel">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-gradient" style="font-size: 1.2rem;"><i class="fas fa-users-cog"></i> Gestión de Usuarios</h1>
                <p style="color: var(--text-muted); font-size: 0.8rem;">Administra los usuarios del sistema.</p>
            </div>
        </div>
        <a href="<?php echo URL_BASE; ?>/admin/crear" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Nuevo Usuario
        </a>
    </div>
</div>

<div class="desktop-table" style="padding: 0.3rem;">
    <div style="overflow-x: auto;">
        <table class="usuarios-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nombre Completo</th>
                    <th>DNI</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th style="width: 100px; text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php $rowNum = 1; ?>
            <?php foreach ($data['usuarios'] as $usuario): ?>
                <tr style="<?php echo $usuario['status'] == 0 ? 'opacity: 0.5;' : ''; ?>">
                    <td style="width: 50px;"><?php echo $rowNum++; ?></td>
                    <td>
                        <strong><?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?></strong>
                    </td>
                    <td><?php echo $usuario['dni'] ?? '-'; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td>
                        <span style="text-transform: uppercase; letter-spacing: 0.5px;"><?php echo $usuario['rol_nombre']; ?></span>
                    </td>
                    <td>
                        <span class="badge <?php echo $usuario['status'] == 1 ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo $usuario['status'] == 1 ? 'Activo' : 'Inactivo'; ?>
                        </span>
                    </td>
                    <td style="width: 100px; text-align: right;">
                        <div style="display: flex; gap: 0.3rem; justify-content: flex-end;">
                            <a href="<?php echo URL_BASE; ?>/admin/editar/<?php echo $usuario['id']; ?>" class="btn btn-secondary" style="padding: 0.3rem 0.6rem; font-size: 0.75rem;" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if ($usuario['status'] == 1): ?>
                            <a href="<?php echo URL_BASE; ?>/admin/eliminar/<?php echo $usuario['id']; ?>" class="btn btn-secondary" style="padding: 0.3rem 0.6rem; font-size: 0.75rem; color: var(--danger);" title="Desactivar" onclick="return confirm('¿Estás seguro de desactivar este usuario?')">
                                <i class="fas fa-user-slash"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mobile-cards" style="display: none;">
    <?php foreach ($data['usuarios'] as $usuario): ?>
        <div class="glass-card" style="margin-bottom: 0.75rem; padding: 0.75rem; <?php echo $usuario['status'] == 0 ? 'opacity: 0.5;' : ''; ?>">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--surface); display: flex; align-items: center; justify-content: center; font-size: 1rem; border: 1px solid var(--border); font-weight: bold;">
                        <?php echo strtoupper(substr($usuario['nombre'], 0, 1)); ?>
                    </div>
                    <div>
                        <div style="font-weight: 600;"><?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?></div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo $usuario['email']; ?></div>
                    </div>
                </div>
                <span class="badge <?php echo $usuario['status'] == 1 ? 'badge-success' : 'badge-danger'; ?>">
                    <?php echo $usuario['status'] == 1 ? 'Activo' : 'Inactivo'; ?>
                </span>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.85rem;">
                <div><strong>DNI:</strong> <?php echo $usuario['dni'] ?? '-'; ?></div>
                <div><strong>Rol:</strong> <?php echo strtoupper($usuario['rol_nombre']); ?></div>
            </div>
            <div style="display: flex; gap: 0.5rem; margin-top: 0.75rem; justify-content: flex-end;">
                <a href="<?php echo URL_BASE; ?>/admin/editar/<?php echo $usuario['id']; ?>" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;" title="Editar">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <?php if ($usuario['status'] == 1): ?>
                <a href="<?php echo URL_BASE; ?>/admin/eliminar/<?php echo $usuario['id']; ?>" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; color: var(--danger);" title="Desactivar" onclick="return confirm('¿Estás seguro de desactivar este usuario?')">
                    <i class="fas fa-user-slash"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../app/Views/layouts/footer.php'; ?>