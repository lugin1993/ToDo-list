<h1>Редактирование задачи</h1>
<form action="/task/<?= $task['id'] ?>/update" method="POST">
    <div class="form-group">
        <label for="user_name">Имя пользователя</label>
        <input name="user_name" class="form-control" id="user_name"
               placeholder="Имя пользователя" value="<?= $task['user_name'] ?>" disabled>
    </div>
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" name="email" class="form-control" id="email"
               placeholder="name@example.com" value="<?= $task['email'] ?>" disabled>
    </div>
    <div class="form-group">
        <label for="description">Текст задачи</label>
        <textarea class="form-control" name="description" id="description"
                  rows="3"><?= $task['description'] ?></textarea>
    </div>
    <div class="form-group">
        <input class="form-check-input"
               type="checkbox"
               name="status"
               value="1"
               id="status" <?php if ($task['status']): ?> checked <?php endif; ?>>
        <label class="form-check-label" for="status">
            Выполнена <?php if ($task['status'] == 2): ?>и отредактирована администратором<?php endif; ?>
        </label>
    </div>
    <button type="submit" class="btn btn-primary m-1 pull-right">Сохранить</button>
</form>