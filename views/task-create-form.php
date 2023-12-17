<h1>Добавление задачи</h1>
<form action="/task/create" method="POST">
    <div class="form-group">
        <label for="user_name">Имя пользователя</label>
        <input name="user_name" class="form-control" id="user_name"
               placeholder="Имя пользователя">
    </div>
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" name="email" class="form-control" id="email"
               placeholder="name@example.com">
    </div>
    <div class="form-group">
        <label for="description">Текст задачи</label>
        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary m-1 pull-right">Сохранить</button>
</form>