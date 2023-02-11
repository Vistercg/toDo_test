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

                    <ul id="save_msgList"></ul>

                    <div class="form-group mb-3">
                        <label for="">Наименование</label>
                        <input type="text" required class="name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Полное описание задачи</label>
                        <input type="text" required class="description form-control">
                    </div>
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

                    <ul id="update_msgList"></ul>

                    <input type="hidden" id="todo_id"/>

                    <div class="form-group mb-3">
                        <label for="">Наименование</label>
                        <input type="text" id="name" required class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Полное описание задачи</label>
                        <input type="text" id="description" required class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Статус</label>
                        <select class="form-select" id="status" aria-label="status">
                            <option selected value="Не выполнена">Не выполнена</option>
                            <option value="Выполнена">Выполнена</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="thumbnail">Изображение</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="thumbnail" id="thumbnail"
                                       class="custom-file-input">
                                <label class="custom-file-label" for="thumbnail">Выберите файл</label>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <img src="https://via.placeholder.com/150x150" alt="" class="img-fluid">
                        </div>
                    </div>
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

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">

                <div id="success_message"></div>

                <div class="card">
                    <div class="card-header">
                        <h4>
                            Список задач
                            @auth
                                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                                        data-bs-target="#AddTodoModal">Добавление задачи
                                </button>
                            @endauth
                        </h4>
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

            fetchtodo();

            function fetchtodo() {
                $.ajax({
                    type: "GET",
                    url: "/fetch-todos",
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        $('tbody').html("");
                        $.each(response.todos, function (key, item) {
                            $('tbody').append('<tr>\
                            <td>' + item.id + '</td>\
                            <td>' + item.name + '</td>\
                            <td>' + item.description + '</td>\
                            <td>' + item.status + '</td>\
                            <td>' + item.tags + '</td>\
                            <td>' + item.image + '</td>\
                            <td>@auth<button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Редактировать</button>\
                                <button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Удалить</button>@endauth</td>\
                        \</tr>');
                        });
                    }
                });
            }

            $(document).on('click', '.add_todo', function (e) {
                e.preventDefault();

                $(this).text('Сохранение..');

                var data = {
                    'name': $('.name').val(),
                    'description': $('.description').val(),
                    'status': $('.status').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/todos",
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
                            $('.add_todo').text('Сохранить');
                        } else {
                            $('#save_msgList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddTodoModal').find('input').val('');
                            $('.add_todo').text('Сохранить');
                            $('#AddTodoModal').modal('hide');
                            fetchtodo();
                        }
                    }
                });

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
                            $('#name').val(response.todo.name);
                            $('#description').val(response.todo.description);
                            $('#status').val(response.todo.status);
                            $('#todo_id').val(todo_id);
                        }
                    }
                });
                $('.btn-close').find('input').val('');

            });

            $(document).on('click', '.update_todo', function (e) {
                e.preventDefault();

                $(this).text('Обновить');
                var id = $('#todo_id').val();
                // alert(id);

                var data = {
                    'name': $('#name').val(),
                    'description': $('#description').val(),
                    'status': $('#status').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/update-todo/" + id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 400) {
                            $('#update_msgList').html("");
                            $('#update_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#update_msgList').append('<li>' + err_value +
                                    '</li>');
                            });
                            $('.update_todo').text('Обновление');
                        } else {
                            $('#update_msgList').html("");

                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').find('input').val('');
                            $('.update_todo').text('Обновление');
                            $('#editModal').modal('hide');
                            fetchtodo();
                        }
                    }
                });

            });

            $(document).on('click', '.deletebtn', function () {
                var todo_id = $(this).val();
                $('#DeleteModal').modal('show');
                $('#deleteing_id').val(todo_id);
            });

            $(document).on('click', '.delete_todo', function (e) {
                e.preventDefault();

                $(this).text('Deleting..');
                var id = $('#deleteing_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/delete-todo/" + id,
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

        });

    </script>

@endsection
