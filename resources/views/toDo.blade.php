@extends('layouts.app')

@section('content')

    {{-- Add Modal --}}
    <div class="modal fade" id="AddTodoModal" tabindex="-1" aria-labelledby="AddTodoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddTodoModalLabel">Добавление задачи в список</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="formAdd" action="/todos" method="POST">
                        <ul id="save_msgList"></ul>

                        <div class="form-group mb-3">
                            <label for="">Наименование</label>
                            <input name="name" type="text" required class="name form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Полное описание задачи</label>
                            <input name="description" type="text" required class="description form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="tag">Теги</label>
                            <select name="tag[]" id="tag" class="select2" multiple="multiple"
                                    data-placeholder="Выбор тегов" style="width: 100%;">

                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Изображение</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" id="image"
                                           class="custom-file-input">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary add_todo">Сохранить</button>
                </div>

            </div>
        </div>
    </div>


    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Редактирование задачи</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <form id="formUpdate" action="/update-todo/{id}" method="POST">
                        <ul id="update_msgList"></ul>

                        <input type="hidden" name="todo_id" id="todo_id"/>

                        <div class="form-group mb-3">
                            <label for="">Наименование</label>
                            <input name="name" type="text" id="name" required class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Полное описание задачи</label>
                            <input name="description" type="text" id="description" required class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Статус</label>
                            <select class="form-select" name="status" id="status" aria-label="status">
                                <option selected value="Не выполнена">Не выполнена</option>
                                <option value="Выполнена">Выполнена</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tags">Теги</label>
                            <select name="tags[]" id="tags" class="select2" multiple="multiple"
                                    data-placeholder="Выбор тегов" style="width: 100%;">

                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Изображение</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" id="image"
                                           class="custom-file-input">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary update_todo">Обновить</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Edn- Edit Modal --}}


    {{-- Delete Modal --}}
    <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Удаление задачи</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Действительно хотите удалить ?</h4>
                    <input type="hidden" id="deleteing_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary delete_todo">Да, удалить</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End - Delete Modal --}}

    {{-- Tag Modal --}}
    <div class="modal fade" id="AddTagModal" tabindex="-1" aria-labelledby="AddTagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddTagModalLabel">Добавление тэга</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="save_msgList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Наименование</label>
                        <input name="title" type="text" required class="title form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary add_tag">Сохранить</button>
                </div>

            </div>
        </div>
    </div>
    {{-- End - Tag Modal --}}


    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div id="success_message"></div>
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Список задач
                            @auth
                                <div class="flex-box float-end">
                                    <button type="button" class="btn btn-outline-secondary addtagbtn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#AddTagModal">Добавление тэга
                                    </button>
                                    <button type="button" class="btn btn-primary addtodobtn "
                                            data-bs-toggle="modal"
                                            data-bs-target="#AddTodoModal">Добавление задачи
                                    </button>
                                </div>
                            @endauth
                        </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <input type="text" name="search" id="search" class="form-control"
                                               placeholder="Поиск задачи"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Статус</th>
                                    <th>Тэги</th>
                                    <th>Изображение</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection

        @section('scripts')

            <script>
                $(document).ready(function () {

                    $('#AddTodoModal #tag').select2();
                    $('#editModal #tags').select2();

                    fetchtodo();

                    function fetchtodo(query = '') {
                        $.ajax({
                            type: "GET",
                            url: "/fetch-todos",
                            data:{query:query},
                            dataType: "json",
                            success: function (response) {
                                //console.log(response);
                                $('tbody').html("");
                                $.each(response.todos, function (key, item) {
                                    let tagsHtml = ''
                                    for (let i = 0; i < item.tags.length; i++) {
                                        tagsHtml += '<span>' + item.tags[i].title + ', <span>'
                                    }
                                    let image = item.image ? '<a href="storage/app/public/' + item.image + '" target="_blank"><img src="storage/app/public/' + item.image + '" width="150" height="150" /></a>' : '';
                                    $('tbody').append(
                                        '<tr>\
                                        <td>' + item.id + '</td>\
                            <td>' + item.name + '</td>\
                            <td>' + item.description + '</td>\
                            <td>' + item.status + '</td>\
                            <td>' + tagsHtml + '</td>\
                            <td>' + image + '</td>\
                            <td>@auth<button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Редактировать</button>\
                                <button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Удалить</button>@endauth</td>\
                        \</tr>');
                                });
                            }
                        });
                    }

                    $(document).on('keyup', '#search', function(){
                        var query = $(this).val();
                        fetchtodo(query);
                    });

                    $(document).on('click', '.addtodobtn', function (e) {
                        e.preventDefault();
                        $('#AddTodoModal').modal('show');

                        $.ajax({
                            type: "GET",
                            url: "/fetch-tags",
                            success: function (response) {
                                if (response.status == 404) {
                                    $('#success_message').addClass('alert alert-success');
                                    $('#success_message').text(response.message);
                                    $('#AddTodoModal').modal('hide');
                                } else {
                                    let tagsHtml = ''
                                    for (let i = 0; i < response.tags.length; i++) {
                                        let selected = response.tags.indexOf(response.tags[i].id) !== -1;
                                        tagsHtml += '<option ' + selected + ' value="' + response.tags[i].id + '">' + response.tags[i].title + '</option>'
                                    }

                                    $('#AddTodoModal #tag').html(tagsHtml).trigger('change');
                                }
                            }
                        });
                        $('.btn-close').find('input').val('');
                    });

                    $(document).on('click', '.add_todo', function (e) {
                        e.preventDefault();

                        $(this).text('Сохранение..');

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        var options = {
                            success: function (response, statusText) {
                                $('#save_msgList').html("");
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);
                                $('#AddTodoModal').find('input').val('');
                                $('.add_todo').text('Сохранить');
                                $('#AddTodoModal').modal('hide');
                                fetchtodo();
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                $('#save_msgList').html("");
                                $('#save_msgList').addClass('alert alert-danger');
                                $.each(XMLHttpRequest.errors, function (key, err_value) {
                                    $('#save_msgList').append('<li>' + err_value + '</li>');
                                });
                                $('.add_todo').text('Сохранить');
                            },
                            dataType: 'json'
                        };
                        $("#formAdd").ajaxSubmit(options);
                    });

                    $(document).on('click', '.editbtn', function (e) {
                        e.preventDefault();
                        var todo_id = $(this).val();
                        // alert(todo_id);
                        $('#editModal').modal('show');
                        $.ajax({
                            type: "GET",
                            url: "/edit-todo/" + todo_id,
                            success: function (response) {
                                if (response.status == 404) {
                                    $('#success_message').addClass('alert alert-success');
                                    $('#success_message').text(response.message);
                                    $('#editModal').modal('hide');
                                } else {
                                    // console.log(response.todo.name);
                                    $('#editModal #name').val(response.todo.name);
                                    $('#editModal #description').val(response.todo.description);
                                    $('#editModal #status').val(response.todo.status);
                                    $('#editModal #todo_id').val(todo_id);
                                    //$('#tags').val(response.todo.tags);

                                    let tagsHtml = ''
                                    for (let i = 0; i < response.tags.length; i++) {
                                        //alert(response.todo.tags[i].title)
                                        let selected = response.todoIds.indexOf(response.tags[i].id) !== -1 ? 'selected' : '';
                                        tagsHtml += '<option ' + selected + ' value="' + response.tags[i].id + '">' + response.tags[i].title + '</option>'
                                    }
                                    $('#editModal #tags').html(tagsHtml).trigger('change');

                                }
                            }
                        });
                        $('.btn-close').find('input').val('');

                    });

                    $(document).on('click', '.update_todo', function (e) {
                        e.preventDefault();

                        $(this).text('Обновить');
                        var id = $('#editModal #todo_id').val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        var options = {
                            success: function (response, statusText) {
                                $('#update_msgList').html("");
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);
                                $('#editModal').find('input').val('');
                                $('.update_todo').text('Обновление');
                                $('#editModal').modal('hide');
                                fetchtodo();
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                $('#update_msgList').html("");
                                $('#update_msgList').addClass('alert alert-danger');
                                $.each(response.errors, function (key, err_value) {
                                    $('#update_msgList').append('<li>' + err_value +
                                        '</li>');
                                });
                                $('.update_todo').text('Обновление');
                            },
                            dataType: 'json'
                        };
                        $("#formUpdate").ajaxSubmit(options);
                    });

                    $(document).on('click', '.deletebtn', function () {
                        var todo_id = $(this).val();
                        $('#DeleteModal').modal('show');
                        $('#deleteing_id').val(todo_id);
                    });

                    $(document).on('click', '.delete_todo', function (e) {
                        e.preventDefault();

                        $(this).text('Удаление..');
                        var todo_id = $('#deleteing_id').val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: "DELETE",
                            url: "/delete-todo/" + todo_id,
                            dataType: "json",
                            success: function (response) {
                                // console.log(response);
                                if (response.status == 404) {
                                    $('#success_message').addClass('alert alert-success');
                                    $('#success_message').text(response.message);
                                    $('.delete_todo').text('Удалить');
                                } else {
                                    $('#success_message').html("");
                                    $('#success_message').addClass('alert alert-success');
                                    $('#success_message').text(response.message);
                                    $('.delete_todo').text('Удалить');
                                    $('#DeleteModal').modal('hide');
                                    fetchtodo();
                                }
                            }
                        });
                    });

                    $(document).on('click', '.add_tag', function (e) {
                        e.preventDefault();

                        $(this).text('Добавление..');

                        var data = {
                            'title': $('#AddTagModal .title').val(),
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        var options = {
                            success: function (response, statusText) {
                                $('#save_msgList').html("");
                                $('#success_message').addClass('alert alert-success');
                                $('#success_message').text(response.message);
                                $('#AddTagModal').find('input').val('');
                                $('.add_tag').text('Сохранить');
                                $('#AddTag').modal('hide');
                                fetchtodo();
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                $('#save_msgList').html("");
                                $('#save_msgList').addClass('alert alert-danger');
                                $.each(XMLHttpRequest.errors, function (key, err_value) {
                                    $('#save_msgList').append('<li>' + err_value + '</li>');
                                });
                                $('.add_tag').text('Сохранить');
                            },
                            dataType: 'json'
                        };
                        $("#formAdd").ajaxSubmit(options);

                        $.ajax({
                            type: "POST",
                            url: "/tags",
                            data: data,
                            dataType: "json",
                            success: function (response) {
                                // console.log(response);
                                if (response.status == 400) {
                                    $('#save_msgList').html("");
                                    $('#save_msgList').addClass('alert alert-danger');
                                    $.each(response.errors, function (key, err_value) {
                                        $('#save_msgList').append('<li>' + err_value + '</li>');
                                    });
                                    $('.add_tag').text('Сохранить');
                                } else {
                                    $('#save_msgList').html("");
                                    $('#success_message').addClass('alert alert-success');
                                    $('#success_message').text(response.message);
                                    $('#AddTagModal').find('input').val('');
                                    $('.add_tag').text('Сохранить');
                                    $('#AddTagModal').modal('hide');
                                    fetchtodo();
                                }
                            }
                        })
                    })


                })
            </script>
@endsection
