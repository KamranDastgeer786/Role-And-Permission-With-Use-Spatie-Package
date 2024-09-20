@extends('layouts.app')

@section('page-title', 'Categories')

@section('content')

<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0"> Show All Category </h6>
            <a href="{{ route('category.create') }}"> Add New Category </a>
        </div>
        <div class="table-responsive" id="contactList">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="example">
                <thead>
                    <tr>
                        <th scope="col"> ID </th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Created_at </th>
                        <th scope="col"> updated_at </th>
                        <th scope="col"> Action </th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    @forelse($categories as $category)
                        <tr>
                            <td data-sort="{{ $category->id }}">
                                {{ $category->id }}
                            </td>

                            <td data-sort="{{ $category->title }}">
                                {{ $category->title }}
                            </td>

                            <td data-sort="{{ $category->created_at }}">
                                {{ $category->created_at->format('Y-m-d H:i:s') }}
                            </td>

                            <td data-sort="{{ $category->updated_at }}">
                                {{ $category->updated_at->format('Y-m-d H:i:s') }}
                            </td>

                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 18px; color: red; font-weight: bold;">
                                        ....
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>

                                            <a href="{{ route('category.edit', $category->id) }}"
                                                class="dropdown-item"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a>
                                        </li>
                                        <li>
                                            <a onclick="deleteCategory('{{ route('category.destroy', $category->id) }}')"
                                                class="dropdown-item" role="button"> <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Remove</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">No Role Found.</td>
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
    function deleteCategory(categorySlug) {
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
                        url: categorySlug,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your items have been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete items. Please try again later.',
                                'error'
                            );
                        }
                    });
                }
        });
    }
</script>

   
@endsection