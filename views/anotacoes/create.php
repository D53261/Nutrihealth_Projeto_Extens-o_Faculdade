<?php include __DIR__ . '/../partials/header.php'; ?>

<h2>Nova Anotação</h2>

<?php if (!empty($error)): ?>
  <p style="color:#ef4444"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="?action=anotacoes_create" 
      style="max-width:520px;padding:16px;background:var(--surface);border:1px solid var(--border);border-radius:12px">

  <label>Texto da Anotação<br>
    <textarea name="texto" required
              style="width:100%;padding:10px;border-radius:8px;border:1px solid var(--border);
                     background:var(--surface-elev);color:var(--on-surface);min-height:100px"><?= htmlspecialchars($old['texto'] ?? '') ?></textarea>
  </label><br><br>

  <label>ID do Usuário<br>
    <input type="number" name="user_id" required
           value="<?= htmlspecialchars($old['user_id'] ?? '') ?>"
           style="width:100%;padding:10px;border-radius:8px;border:1px solid var(--border);
                  background:var(--surface-elev);color:var(--on-surface)">
  </label><br><br>

  <button type="submit" class="btn btn-primary">Salvar</button>
  <a href="?action=anotacoes_index" class="btn" style="margin-left:8px">Voltar</a>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
