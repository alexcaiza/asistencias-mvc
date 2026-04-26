<?php require_once '../app/Views/layouts/header.php'; ?>

<div class="glass-card" style="margin-bottom: 1rem; padding: 0.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="<?php echo URL_BASE; ?>/admin" class="btn btn-secondary" style="padding: 0.4rem 0.8rem;" title="Volver al panel">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-gradient" style="font-size: 1.2rem;"><i class="fas fa-clipboard-check"></i> Gestión de Asistencias</h1>
                <p style="color: var(--text-muted); font-size: 0.8rem;">Historial completo de assistencias registradas.</p>
            </div>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button class="btn btn-secondary" onclick="location.reload()"><i class="fas fa-sync-alt"></i> Actualizar</button>
            <button class="btn btn-secondary" onclick="window.print()"><i class="fas fa-print"></i> Imprimir</button>
        </div>
    </div>
</div>

<div class="desktop-table" style="padding: 0.3rem;">
    <div style="overflow-x: auto;">
        <table class="asistencias-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Empleado</th>
                    <th>DNI</th>
                    <th>Fecha</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Estado</th>
                    <th style="width: 100px; text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php $asistNum = 1; ?>
            <?php foreach ($data['asistencias'] as $asistencia): ?>
                <tr>
                    <td style="width: 40px;"><?php echo $asistNum++; ?></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.3rem;">
                            <div style="width: 22px; height: 22px; border-radius: 50%; background: var(--surface); display: flex; align-items: center; justify-content: center; font-size: 0.65rem; border: 1px solid var(--border);">
                                <?php echo strtoupper(substr($asistencia['nombre'], 0, 1)); ?>
                            </div>
                            <?php echo $asistencia['nombre'] . ' ' . $asistencia['apellido']; ?>
                        </div>
                    </td>
                    <td><?php echo $asistencia['dni'] ?? '-'; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($asistencia['fecha'])); ?></td>
                    <td><strong><?php echo $asistencia['hora_entrada']; ?></strong></td>
                    <td><?php echo $asistencia['hora_salida'] ?? '<span style="color: var(--text-muted); font-style: italic;">Pendiente</span>'; ?></td>
                    <td>
                        <span class="badge <?php 
                            echo $asistencia['estado'] == 'A tiempo' ? 'badge-success' : ($asistencia['estado'] == 'Tarde' ? 'badge-danger' : 'badge-warning'); 
                        ?>">
                            <?php echo $asistencia['estado']; ?>
                        </span>
                    </td>
                    <td style="width: 100px; text-align: right;">
                        <div style="display: flex; gap: 0.3rem; justify-content: flex-end;">
                            <a href="<?php echo URL_BASE; ?>/admin/editarAsistencia/<?php echo $asistencia['id']; ?>" class="btn btn-secondary" style="padding: 0.3rem 0.6rem; font-size: 0.75rem;" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo URL_BASE; ?>/admin/eliminarAsistencia/<?php echo $asistencia['id']; ?>" class="btn btn-secondary" style="padding: 0.3rem 0.6rem; font-size: 0.75rem; color: var(--danger);" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($data['asistencias'])): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 2rem; color: var(--text-muted);">No hay registros de asistencia para mostrar.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mobile-cards" style="display: none;">
    <?php if (empty($data['asistencias'])): ?>
        <div class="glass-card" style="padding: 1rem; text-align: center; color: var(--text-muted);">No hay registros de asistencia para mostrar.</div>
    <?php else: ?>
        <?php foreach ($data['asistencias'] as $asistencia): ?>
            <div class="glass-card" style="margin-bottom: 0.75rem; padding: 0.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--surface); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; border: 1px solid var(--border); font-weight: bold;">
                            <?php echo strtoupper(substr($asistencia['nombre'], 0, 1)); ?>
                        </div>
                        <div>
                            <div style="font-weight: 600;"><?php echo $asistencia['nombre'] . ' ' . $asistencia['apellido']; ?></div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">DNI: <?php echo $asistencia['dni'] ?? '-'; ?></div>
                        </div>
                    </div>
                    <span class="badge <?php echo $asistencia['estado'] == 'A tiempo' ? 'badge-success' : ($asistencia['estado'] == 'Tarde' ? 'badge-danger' : 'badge-warning'); ?>">
                        <?php echo $asistencia['estado']; ?>
                    </span>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.85rem;">
                    <div><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($asistencia['fecha'])); ?></div>
                    <div><strong>Entrada:</strong> <?php echo $asistencia['hora_entrada']; ?></div>
                    <div><strong>Salida:</strong> <?php echo $asistencia['hora_salida'] ?? '<span style="color: var(--text-muted); font-style: italic;">Pendiente</span>'; ?></div>
                </div>
                <div style="display: flex; gap: 0.5rem; margin-top: 0.75rem; justify-content: flex-end;">
                    <a href="<?php echo URL_BASE; ?>/admin/editarAsistencia/<?php echo $asistencia['id']; ?>" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;" title="Editar">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="<?php echo URL_BASE; ?>/admin/eliminarAsistencia/<?php echo $asistencia['id']; ?>" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; color: var(--danger);" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once '../app/Views/layouts/footer.php'; ?>