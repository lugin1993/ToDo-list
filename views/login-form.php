<h1>Авторизация</h1>
<form action="/user/login" method="POST">
    <div class="form-group">
        <label for="login">Имя пользователя</label>
        <input name="login" class="form-control" id="login" required
               placeholder="Имя пользователя">
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" name="password" required class="form-control" id="password"
               placeholder="Пароль">
    </div>
    <button type="submit" class="btn btn-primary m-1 pull-right">Войти</button>
</form>