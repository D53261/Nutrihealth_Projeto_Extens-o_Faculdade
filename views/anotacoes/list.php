<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="page-head"><i data-lucide="book-open-text"></i><div><div class="page-title">Anotações</div><div class="page-sub">Anotações feitas para os Usuários</div></div></div>

<h2 style="margin-top:8px">Lista de Anotações</h2>

<table style="border-collapse:collapse;width:100%;background:var(--surface);border:1px solid var(--border)">
  <tr style="background:var(--surface-elev)">
    <th style="padding:10px;border-bottom:1px solid var(--border);text-align:left">ID</th>
    <th style="padding:10px;border-bottom:1px solid var(--border);text-align:left">Texto</th>
    <th style="padding:10px;border-bottom:1px solid var(--border);text-align:left">Usuário</th>
    <th style="padding:10px;border-bottom:1px solid var(--border);text-align:left">Data</th>
    <th style="padding:10px;border-bottom:1px solid var(--border);text-align:left">Ações</th>
  </tr>

  <?php foreach ($anotacoes as $a): ?>
    <tr>
      <td style="padding:10px;border-bottom:1px solid var(--border)">
        <?= htmlspecialchars((string)$a->id) ?>
      </td>
      <td style="padding:10px; border-bottom:1px solid var(--border); vertical-align: top; width: 40%;">
        <div class="note-box" style="max-width: 90%; margin-right: auto;">
          <?= nl2br(htmlspecialchars(ltrim(mb_strimwidth($a->texto, 0, 1000, '...')))) ?>
        </div>
      </td>
      <td style="padding:10px;border-bottom:1px solid var(--border)">
        <?= htmlspecialchars($a->user_nome ?? 'Desconhecido') ?>
      </td>
      <td style="padding:10px;border-bottom:1px solid var(--border)">
        <?= htmlspecialchars($a->created_at ?? '-') ?>
      </td>
      <td style="padding:10px;border-bottom:1px solid var(--border);">
        <div style="display: flex; gap: 8px;">
          <a href="?action=anotacoes_edit&id=<?= (int)$a->id ?>" class="btn btn-primary">
            <i data-lucide="edit-3"></i> Editar
          </a>
          <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= (int)$a->id ?>)">
            <i data-lucide="trash-2"></i> Excluir
          </button>
        </div>
      </td>

    </tr>
  <?php endforeach; ?>
</table>

<div style="margin-top:12px;">
  <a href="?action=anotacoes_create" class="btn btn-success">
    <i data-lucide="plus-circle"></i> Criar Nova Anotação
  </a>
</div>

<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Tem certeza?',
    text: 'Esta ação não poderá ser desfeita!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sim, excluir!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `?action=anotacoes_delete&id=${id}`;
    }
  });
}
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
