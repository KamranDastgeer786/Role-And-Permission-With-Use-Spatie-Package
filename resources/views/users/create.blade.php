@extends('layouts.app')
@section('page-title', 'Add Users')
@section('sub-page-title', 'Add New User')

@section('content')

  {{-- @dd($user) --}}
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
                    
                    <h6 class="mb-4"> Add New User </h6>
                    <form id="userForm" action="{{ isset($user) ? route('users.update', ['user' => $user->id]) : route('users.store') }}" method="POST">
                        @csrf

                        @if (isset($user))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $user->name ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email ?? '' }}">
                        </div>


                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Assign Role</label>
                            <select class="form-control" id="roleSelect2" name="roles[]"  required style="background-color: black">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ isset($user) && $user->hasRole($role) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label"></label>
                            <select class="form-control" id="roleSelect2" name="roles[]" multiple="multiple"  style="background-color: black">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ isset($user) && $user->hasRole($role) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- <div class=" form-check form-switch form-switch-right form-switch-md mb-3">
                            <label for="exampleInputPassword1" class="form-label">Active Status</label>
                            <input  type="hidden" class="form-control" id="active" name="active" value="off">
                            <input class="form-control code-switcher" type="checkbox" name="active" {{ isset($user) && $user->active == true ? 'checked' : '' }}
                            id="tables-small-showcode" {{ !isset($user) ? 'checked' : '' }}>
                        </div> --}}
                        <br>

                        <div class="mb-3">
                            <div class="form-check form-switch ">
                                <label class="form-check-label" for="flexSwitchCheckChecked">  Active Status </label>
                                <input class="form-check-input" type="checkbox" name="active" {{ isset($user) && $user->active == true ? 'checked' : '' }} id="tables-small-showcode" {{ !isset($user) ? 'checked' : '' }}>
                            </div>

                        </div>
                        <br>


                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label"> Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Save' }}</button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Form End -->

    {{-- <div class="modal fade modal-xl" id="mediaUploadModal" tabindex="-1" role="dialog" aria-labelledby="mediaUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               <x-media :modalOpenedFlag=true />
            </div>
        </div>
    </div> --}}

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
                                        '{{ route('users.index') }}';
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