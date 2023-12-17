<h1>Список задач</h1>
<?php if (count($tasks)): ?>
    <div class="table-responsive">
        <table class="table my-table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Имя пользователя
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/page/1?orderBy=user_name&direction=ASC">по
                                    возрастанию</a></li>
                            <li><a class="dropdown-item" href="/page/1?orderBy=user_name&direction=DESC">по убыванию</a>
                            </li>
                        </ul>
                    </div>
                </th>
                <th scope="col">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        E-mail
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/page/1?orderBy=email&direction=ASC">по возрастанию</a></li>
                        <li><a class="dropdown-item" href="/page/1?orderBy=email&direction=DESC">по убыванию</a></li>
                    </ul>
                </th>
                <th scope="col">Текст задачи</th>
                <th scope="col">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Статус
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/page/1?orderBy=email&direction=ASC">по возрастанию</a></li>
                        <li><a class="dropdown-item" href="/page/1?orderBy=email&direction=DESC">по убыванию</a></li>
                    </ul>
                </th>
				<?php if ($authorized): ?>
                    <th scope="col"></th>
				<?php endif; ?>
            </tr>
            </thead>
            <tbody>
			<?php foreach ($tasks as $task): ?>
                <tr>
                    <th scope="row"><?= $task['id']; ?></th>
                    <td><?= $task['user_name']; ?></td>
                    <td><?= $task['email']; ?></td>
                    <td><?= $task['description']; ?></td>
                    <td class="text-with-icon">
						<?php if ($task['status'] == 1 || $task['status'] == 2): ?>
                            <i class="bi bi-check-circle-fill text-success"></i><span>Выполнено</span>
						<?php elseif ($authorized): ?>
                            <a href="/task/<?= $task['id'] ?>/completed">
                                <i class="bi bi-check-circle"></i><span>Не выполнено</span>
                            </a>
						<?php else: ?>
                        <i class="bi bi-check-circle"></i><span>Не выполнено<span>
						<?php endif; ?>
                    </td>
					<?php if ($authorized): ?>
                        <td class="text-with-icon">
                            <a href="/task/<?= $task['id'] ?>/edit">
                                <i class="bi bi-pen"></i><span>Изменить</span>
                            </a>
                        </td>
					<?php endif; ?>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>
    </div>
	<?php if ($number_pages > 1): ?>
        <nav>
            <ul class="pagination text-center">
				<?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="/page/<?= $page - 1; ?>">Предыдущая</a>
                    </li>
                    <li class="page-item"><a class="page-link"
                                             href="/page/<?= ($page - 1) . $pageParams; ?>"><?= $page - 1; ?></a></li>
				<?php endif; ?>
                <li class="page-item active" aria-current="page">
                    <a class="page-link"><?= $page; ?></a>
                </li>
				<?php if ($number_pages - $page > 0): ?>
                    <li class="page-item"><a class="page-link"
                                             href="/page/<?= ($page + 1) . $pageParams; ?>"><?= $page + 1; ?></a></li>
				<?php endif; ?>
				<?php if ($number_pages - $page > 0): ?>
                    <li class="page-item">
                        <a class="page-link" href="/page/<?= ($page + 1) . $pageParams;; ?>">Следующая</a>
                    </li>
				<?php endif; ?>
            </ul>
        </nav>
	<?php endif; ?>
<?php endif; ?>
<a type="button" class="btn btn-primary pull-right" href="/task/add">Добавить задачу</a>
