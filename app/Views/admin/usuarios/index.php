<?php require_once '../app/Views/layouts/header.php'; ?>

<div class="admin-layout">
    <div class="sidebar-trigger" id="sidebarTrigger" onclick="toggleSidebar()">
        <i class="fas fa-chevron-right"></i>
    </div>
    
    <aside class="sidebar panel-filtros" id="sidebar" name="panelFiltros" style="display: flex; flex-direction: column;">
        <div class="sidebar-content" id="sidebarContent" style="flex: 1;">
            <h3 style="display: flex; justify-content: space-between; align-items: center;">
                <span><i class="fas fa-filter"></i> Filtros</span>
                <a href="<?php echo URL_BASE; ?>/admin/usuarios" class="btn btn-secondary" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;" title="Limpiar">
                    <i class="fas fa-eraser"></i>
                </a>
            </h3>
            <form method="GET" action="<?php echo URL_BASE; ?>/admin/usuarios" id="filterForm">
                <div class="filter-group" style="margin-bottom: 1rem;">
                    <label for="search" style="display: block; margin-bottom: 0.3rem; font-size: 0.8rem; font-weight: 500;">Nombre</label>
                    <input type="text" id="search" name="search" class="form-input" placeholder="Buscar por nombre..." value="<?php echo $data['filters']['search'] ?? ''; ?>" style="width: 100%; padding: 0.4rem; border: 1px solid var(--border); border-radius: 0.3rem;">
                </div>
                <div class="filter-group" style="margin-bottom: 1rem;">
                    <label for="dni" style="display: block; margin-bottom: 0.3rem; font-size: 0.8rem; font-weight: 500;">DNI</label>
                    <input type="text" id="dni" name="dni" class="form-input" placeholder="Buscar por DNI..." value="<?php echo $data['filters']['dni'] ?? ''; ?>" style="width: 100%; padding: 0.4rem; border: 1px solid var(--border); border-radius: 0.3rem;">
                </div>
                <div class="filter-group" style="margin-bottom: 1rem;">
                    <label for="email" style="display: block; margin-bottom: 0.3rem; font-size: 0.8rem; font-weight: 500;">Email</label>
                    <input type="text" id="email" name="email" class="form-input" placeholder="Buscar por email..." value="<?php echo $data['filters']['email'] ?? ''; ?>" style="width: 100%; padding: 0.4rem; border: 1px solid var(--border); border-radius: 0.3rem;">
                </div>
                <?php if (!empty($data['roles'])): ?>
                <div class="filter-group" style="margin-bottom: 1rem;">
                    <label for="rol" style="display: block; margin-bottom: 0.3rem; font-size: 0.8rem; font-weight: 500;">Rol</label>
                    <select id="rol" name="rol" class="form-input" style="width: 100%; padding: 0.4rem; border: 1px solid var(--border); border-radius: 0.3rem;">
                        <option value="">Seleccione</option>
                        <?php foreach ($data['roles'] as $rol): ?>
                            <option value="<?php echo $rol['id']; ?>" <?php echo ($data['filters']['rol'] ?? '') == $rol['id'] ? 'selected' : ''; ?>><?php echo $rol['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
            </form>
        </div>
        <div style="text-align: right; padding: 0.5rem; margin-top: auto;">
            <button type="submit" class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </aside>
    
    <div class="main-content">

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

<?php 
function buildFilterUrl($page, $filters) {
    $params = [];
    if (!empty($filters['search'])) $params[] = 'search=' . urlencode($filters['search']);
    if (!empty($filters['dni'])) $params[] = 'dni=' . urlencode($filters['dni']);
    if (!empty($filters['email'])) $params[] = 'email=' . urlencode($filters['email']);
    if (!empty($filters['rol'])) $params[] = 'rol=' . urlencode($filters['rol']);
    $params[] = 'page=' . $page;
    return URL_BASE . '/admin/usuarios?' . implode('&', $params);
}
?>

<div class="pagination" style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 1rem; flex-wrap: wrap;">
    <?php if ($data['currentPage'] > 1): ?>
        <a href="<?php echo buildFilterUrl($data['currentPage'] - 1, $data['filters']); ?>" class="btn btn-secondary" style="padding: 0.4rem 0.8rem;">
            <i class="fas fa-chevron-left"></i> Anterior
        </a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
        <a href="<?php echo buildFilterUrl($i, $data['filters']); ?>" 
           class="btn <?php echo $i == $data['currentPage'] ? 'btn-primary' : 'btn-secondary'; ?>" 
           style="padding: 0.4rem 0.8rem; <?php echo $i == $data['currentPage'] ? 'pointer-events: none;' : ''; ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    
    <?php if ($data['currentPage'] < $data['totalPages']): ?>
        <a href="<?php echo buildFilterUrl($data['currentPage'] + 1, $data['filters']); ?>" class="btn btn-secondary" style="padding: 0.4rem 0.8rem;">
            Siguiente <i class="fas fa-chevron-right"></i>
        </a>
    <?php endif; ?>
    
    <span style="margin-left: 1rem; font-size: 0.8rem; color: var(--text-muted);">(<?php echo $data['total']; ?>)</span>
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