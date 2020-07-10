<div class="container mt-5">
    <div class="row justify-content-center mb-2">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">
            Добавить
        </button>
        <? if(!Session::get("loggedIn")){ ?>
        <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#logInModal">
            Авторизоваться
        </button>
        <? } else { ?>
        <a type="button" class="btn btn-primary ml-2" href="/auth/logout">
            Выйти
        </a>
        <? } ?>
    </div>

    <div class="row justify-content-center mb-4 form-inline">
        <button type="button" class="btn btn-success mr-2" id="sort_direction" data-direction="desc">
            <i class="fa fa-arrow-down"></i>
        </button>
        <select class="form-control form-control-sm" id="sorter">
            <option value="0" data-value="timestamp">по-умолчанию</option>
            <option value="1" data-value="name_field">имя пользователя</option>
            <option value="2" data-value="email_field">e-mail</option>
            <option value="3" data-value="status">статус</option>
        </select>
    </div>

    <div class="row justify-content-center align-self-center">
        <? if (isset($tasks) && count($tasks) > 0)
         foreach ( $tasks as $task ) { ?>
        <div class="col-md-4">
            <div class="card w-100 mt-2" style="width: 18rem;">
                <? if(Session::get("loggedIn")){ ?>
                <a class="btn btn-secondary" data-toggle="modal" data-target="#editModal" data-task="<?=$task['id']?>">
                    <i class="fa fa-pencil-alt text-white"></i>
                </a>
                <? } ?>
                <div class="card-body">
                    <h5 class="card-title d-inline-block"><?=$task["name_field"]?></h5>
                    <h6 class="card-subtitle mb-2 text-muted d-inline-block"><?=$task["email_field"]?></h6>
                    <p class="card-text mb-0">
                        <?=$task["text_field"]?>
                        <? if($task["modified"] == 1) { ?>
                        <sup data-toggle="tooltip" data-placement="top" title="отредактировано администратором"><i class="fa fa-pen text-muted"></i></sup>
                        <? } ?>
                    </p>
                </div>
                <? if($task["status"] == 1) { ?>
                    <sup class="badge badge-success d-block card-link mb-2 status-mark">ВЫПОЛНЕНО</sup>
                <? } ?>
            </div>
        </div>
        <? } else {?>
            <span>Ни одной задачи нет</span>
        <? }?>

    </div>

    <? if (isset($params) && $params['max_page'] > 1) {?>
        <div class="row justify-content-center align-self-center mt-3">
            <nav aria-label="Pagination">
                <ul class="pagination pagination-sm">
                    <? for($i = 1; $i <= $params['max_page']; $i++) {?>
                        <li class="page-item<?=($i == $params["page"]) ? " active" : ""?>" aria-current="page">
                          <a class="page-link" href=<?=("'/?p=$i&d=".$params["direction"].( ($params["sorter"] != NULL) ? "&s=".$params["sorter"]."'" : "'"));?>>
                            <?=$i?>
                          </a>
                        </li>
                    <? }?>
                </ul>
            </nav>
        </div>
    <? } ?>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Добавить задачу</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nameInput">Имя</label>
                        <input type="text" class="form-control" id="nameInput">
                    </div>
                    <div class="form-group">
                        <label for="emailInput">Email</label>
                        <input type="email" class="form-control" id="emailInput">
                    </div>
                    <div class="form-group">
                        <label for="text">Текст задачи</label>
                        <textarea class="form-control" id="text" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" id="addTask">Добавить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Изменить задачу</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Статус задачи</label>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary btn-toggler active">
                                <input type="radio" name="status" id="inwork_btn" value="0" checked> В работе
                            </label>
                            <label class="btn btn-success btn-toggler">
                                <input type="radio" name="status" id="ready_btn" value="1"> Выполнен
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="text">Текст задачи</label>
                        <textarea class="form-control" id="editText" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" data-task="" id="editTask">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="logInModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logInModalLabel">Авторизация</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="loginInput">Логин</label>
                        <input type="text" class="form-control" id="loginInput">
                    </div>
                    <div class="form-group">
                        <label for="passInput">Пароль</label>
                        <input type="password" class="form-control" id="passInput">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" id="logIn">Войти</button>
                </div>
            </div>
        </div>
    </div>
</div>
}