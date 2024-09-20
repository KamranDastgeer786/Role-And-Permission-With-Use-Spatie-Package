@extends('layouts.app')
@section('page-title', 'Roles')
@section('sub-page-title', 'Add New Role')

@section('content')
    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                 <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <h6 class="mb-4"> Add Role </h6>
                    <form id="userForm" action="{{ isset($role) ? route('roles.update', ['role' => $role->id]) : route('roles.store') }}" method="POST">
                        @csrf

                        @if (isset($role))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $role->name ?? '' }}" required>
                        </div>


                        <label class="form-label">Permissions <span class="text-danger">*</span></label>
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col"> Module </th>
                                        <th scope="col"> Create </th>
                                        <th scope="col"> Show </th>
                                        <th scope="col"> Edit </th>
                                        <th scope="col"> Delete </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $index => $permissionGroup)
                                        <tr>
                                            <td>{{ ucfirst($index) }}</td>

                                            <td>

                                                @if (checkPermission($permissionGroup, 'create_' . strtolower($index)))
                                                    <div class="form-check text-center">
                                                       <input class="form-check-input" type="checkbox" name="permissions[]" value="create_{{ strtolower($index) }}" {{ isset($role) && $role->hasPermissionTo('create_' . strtolower($index)) ? 'checked' : '' }}>
                                                    </div>
                                                @else
                                                    <div class="form-check text-center">-</div>
                                                @endif

                                            </td>

                                            <td>

                                                @if (checkPermission($permissionGroup, 'show_' . strtolower($index)))
                                                    <div class="form-check text-center">
                                                       <input class="form-check-input" type="checkbox" name="permissions[]" value="show_{{ strtolower($index) }}" {{ isset($role) && $role->hasPermissionTo('show_' . strtolower($index)) ? 'checked' : '' }} style="margin-left: 2px;"  >
                                                    </div>
                                                @else
                                                    <div class="form-check text-center">-</div>
                                                @endif

                                            </td>

                                            <td>

                                                @if (checkPermission($permissionGroup, 'edit_' . strtolower($index)))
                                                    <div class="form-check text-center">
                                                       <input class="form-check-input" type="checkbox" name="permissions[]" value="edit_{{ strtolower($index) }}" {{ isset($role) && $role->hasPermissionTo('edit_' . strtolower($index)) ? 'checked' : '' }} style="margin-left: 2px;"  >
                                                    </div>
                                                @else
                                                    <div class="form-check text-center">-</div>
                                                @endif

                                            </td>

                                            <td>
                                                
                                                @if (checkPermission($permissionGroup, 'delete_' . strtolower($index)))
                                                    <div class="form-check text-center">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="delete_{{ strtolower($index) }}" {{ isset($role) && $role->hasPermissionTo('delete_' . strtolower($index)) ? 'checked' : '' }} style="margin-left: 2px;"  >
                                                    </div>
                                                @else
                                                    <div class="form-check text-center">-</div>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-top: 10px; padding-left: 25px; padding-right: 25px;">
                            {{ isset($role) ? 'Update' : 'Save' }}
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Form End -->



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
                $('#userForm').on('submit', function(event) {
                    event.preventDefault();

                    var formData = new FormData($(this)[0]);

                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('roles.index') }}';
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            for (let field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    errorMessage += `${errors[field].join('\n')}\n`;
                                }
                            }

                            Swal.fire(
                                'Error!',
                                errorMessage + '\n',
                                'error'
                            );
                        }

                    });
                });
            });
    </script>

@endsection