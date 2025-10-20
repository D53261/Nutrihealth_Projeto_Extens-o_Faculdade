<?php include __DIR__ . '/../partials/header.php'; ?>

<h2>Editar Usuário</h2>
<?php if (!empty($error)): ?><p style="color:#ef4444"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" action="?action=edit&id=<?= (int)$user->id ?>" style="max-width:520px;padding:16px;background:var(--surface);border:1px solid var(--border);border-radius:12px">
  <label>Nome<br>
    <input type="text" name="name" required value="<?= htmlspecialchars($user->name) ?>" style="width:100%;padding:10px;border-radius:8px;border:1px solid var(--border);background:var(--surface-elev);color:var(--on-surface)">
  </label><br><br>
  <label>Email<br>
    <input type="email" name="email" required value="<?= htmlspecialchars($user->email) ?>" style="width:100%;padding:10px;border-radius:8px;border:1px solid var(--border);background:var(--surface-elev);color:var(--on-surface)">
  </label><br><br>
  <label>Tipo de Usuário<br>
    <select name="typeUser" required style="width:100%;padding:10px;border-radius:8px;border:1px solid var(--border);background:var(--surface-elev);color:var(--on-surface)">
      <option value="A" <?= $user->typeUser === 'A' ? 'selected' : '' ?>>Administrador</option>
      <option value="N" <?= $user->typeUser === 'N' ? 'selected' : '' ?>>Nutricionista</option>
      <option value="U" <?= $user->typeUser === 'U' ? 'selected' : '' ?>>Usuário Comum</option>
    </select>
  </label><br><br>
  <button type="submit" class="btn btn-primary">Salvar</button>
  <a href="?action=index" class="btn" style="margin-left:8px">Voltar</a>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
