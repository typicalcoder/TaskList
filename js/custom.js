$(document).ready((keyframes, options) => {
    $('[data-toggle="tooltip"]').tooltip();
    $("#addTask").on("click", (event) => {
        let $email = $("#emailInput");
        let email = $email.val();

        let $name = $("#nameInput");
        let name = $name.val();

        let $text = $("#text");
        let text = $text.val();

        if(checkValidity(
            [
                {$obj: $name, type: "", name: "Имя"},
                {$obj: $email, type: "email", name: "E-mail"},
                {$obj: $text, type: "", name: "Текст задачи"}
            ]
        )) {
            sendForm(
                "POST",
                '/main/addTask',
                {
                    email: email,
                    name: name,
                    text: text
                }
            );
        }
    });

    $('#editModal').on('show.bs.modal', function (e) {
        let formData = new FormData();
        formData.append('task', $(e.relatedTarget).data("task"));
        $.ajax({
            url: '/auth/getTaskInfo',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: "JSON",
            success: function(data) {
                if(data.status !== "ERROR") {
                    if(data.status === "1") {
                        $("#ready_btn").click();
                    } else {
                        $("#inwork_btn").click();
                    }
                    $("#editText").val(data.text_field);
                    $("#editTask").attr("data-task", data.id);
                } else {
                    alert("Системная ошибка, сообщите администратору");
                }
            }
        });
    });


    $("#editTask").on("click", (event) => {
        let $status = $("input[name='status']:checked");
        let status = $status.val();

        let $text = $("#editText");
        let text = $text.val();

        if(checkValidity(
            [
                {$obj: $text, type: "", name: "Текст задачи"}
            ]
        )) {
            sendForm(
                "POST",
                '/auth/editTask',
                {
                    task: $(event.currentTarget).data("task"),
                    status: status,
                    text: text
                }
            );
        }
    });

    $("#logIn").on("click", (event) => {
        let $login = $("#loginInput");
        let login = $login.val();

        let $pass = $("#passInput");
        let pass = $pass.val();

        if(checkValidity(
            [
                {$obj: $login, type: "", name: "Логин"},
                {$obj: $pass, type: "", name: "Пароль"}
            ]
        )) {
            let formData = new FormData();
            formData.append('login', login);
            formData.append('pass', pass);
            $.ajax({
                url: '/auth/start',
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    if(data === "OK") {
                        window.location = "/";
                    } else {
                        alert("Неверный логин/пароль");
                    }
                }
            });
        }
    });

    $("#sort_direction").on("click", (event) => {
        let $direction = $(event.currentTarget);
        if($direction.data("direction") === "desc") {
            // делаем по возрастанию (asc)
            window.location = editUrl(undefined, undefined, 0);
        } else {
            // делаем по убыванию (desc)
            window.location = editUrl(undefined, undefined, 1);
        }
    });

    $("#sorter").on("change", (event) => {
        let $sorter = $(event.currentTarget);
        switch ($sorter.val()) {
            case "0":
                window.location = editUrl(undefined, "timestamp", undefined);
                break;
            case "1":
                window.location = editUrl(undefined, "name_field", undefined);
                break;
            case "2":
                window.location = editUrl(undefined, "email_field", undefined);
                break;
            case "3":
                window.location = editUrl(undefined, "status", undefined);
                break;
        }

    });
    setCurrentSorter();
    setCurrentDirection();
});

function editUrl(newPage, newSorter, newDirection) {
    let page = (newPage !== undefined) ? newPage : (getUrlParam("p") !== undefined) ? getUrlParam("p") : 1;
    let sorter = (newSorter !== undefined) ? newSorter : (getUrlParam("s") !== undefined) ? getUrlParam("s") : null;
    let direction = (newDirection !== undefined) ? newDirection : (getUrlParam("d") !== undefined) ? getUrlParam("d") : 1;

    let newUrl = "?p="+page+"&";
    if(sorter !== null) newUrl += "s="+sorter+"&";
    newUrl += "d="+direction;
    return newUrl;
}

function sendForm(method, url, data) {
    var form = document.createElement('form');
    document.body.appendChild(form);
    form.method = method;
    form.action = url;
    for (var name in data) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = data[name];
        form.appendChild(input);
    }
    form.submit();
}

setCurrentSorter = () => {
    $('#sorter option[data-value='+getUrlParam("s")+']').prop('selected', true);
};

setCurrentDirection = () => {
    if(getUrlParam("d") === "0") setDirectionAsc();
    else setDirectionDesc();
};

setDirectionAsc = () => {
    let $direction = $("#sort_direction");
    $direction.html("<i class=\"fa fa-arrow-down\"></i>");
    $direction.attr("data-direction","asc");
};

setDirectionDesc = () => {
    let $direction = $("#sort_direction");
    $direction.html("<i class=\"fa fa-arrow-up\"></i>");
    $direction.attr("data-direction","desc");
};

getUrlParam = (sParam) => {
    let sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? false : sParameterName[1];
        }
    }
};