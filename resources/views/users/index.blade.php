@extends('layouts.app')

@section('page-title', 'Users')

@section('content')

<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0"> Show All Category </h6>
            <a href="{{ route('users.create') }}"> Add User </a>
        </div>
       
        <div class="table-responsive" id="contactList">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="example">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">
                            <div class="orm-check">
                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                            </div>
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    @forelse ($users as $user)
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input mass-action-checkbox" type="checkbox" name="chk_child" value="{{ $user->id }}">
                                </div>
                            </th>

                            <td>
                                <a href="" class="btn-link">{{ $user->name }}</a>
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                @forelse ($user->roles as $role)
                                    @if ($loop->last)
                                      {{ $role->name }}
                                    @else
                                      {{ $role->name }} ,
                                    @endif

                                    @empty                                
                                @endforelse
                            </td> 
                            
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox" {{ $user->active ? 'checked' : '' }} data-user-id="{{ $user->id }}">
                                </div>
                            </td>

                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 18px; color: red; font-weight: bold;">
                                        ....
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('users.edit', $user->id) }}" class="dropdown-item">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a onclick="deleteUser('{{ route('users.destroy', $user->id) }}')" class="dropdown-item" role="button"> 
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Remove
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">No User Found.</td>
                        </tr>    
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Recent Sales End -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    var checkedIds = [];

    function updateCheckedIds() {
        checkedIds = [];
        $('.mass-action-checkbox:checked').each(function() {
        checkedIds.push($(this).val());
      });
    }

    $('.status-toggle').change(function() {
        var userId = $(this).data('user-id');
            
        var newActiveStatus = $(this).prop('checked') ? 1 : 0;

        $.ajax({
            url: '{{ route('users.update-active-status') }}',
            method: 'POST',
            data: {
                id: userId,
                activeStatus: newActiveStatus
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Updated!',
                        response.message,
                        'success'
                    );
                },
                error: function(xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'Failed To Update Active Status.',
                    'error'
                    ).then(() => {
                    location.reload();
                });
            }
        });

    });


    function deleteUser(slug) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover deleted items!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: slug,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON.message,
                                'error'
                            );
                        }
                    });
                }
            });
        }
</script>
 
@endsection