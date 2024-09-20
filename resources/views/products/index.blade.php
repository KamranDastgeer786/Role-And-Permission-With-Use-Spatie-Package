@extends('layouts.app')

@section('page-title', 'Products')

@section('content')

<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0"> Product List </h6>
            <a href="{{ route('products.create') }}">Add New Products</a>
        </div>
        <div class="table-responsive" id="contactList">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="example">
                <thead>
                    <tr>
                        {{-- <th scope="col" style="width: 50px;">
                            <div class="orm-check">
                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                            </div>
                        </th> --}}
                        <th scope="col"> ID </th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Description </th>
                        <th scope="col"> Quantity </th>
                        <th scope="col"> Category </th>
                        <th scope="col"> User </th>
                        <th scope="col"> Actions </th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    @forelse($products as $product)
                        <tr>
                            
                            <td data-sort="{{ $product->id }}">
                                {{ $product->id }}
                            </td>

                            <td data-sort="{{ $product->name }}">
                                {{ $product->name }}
                            </td>

                            <td data-sort="{{ $product->description }}">
                                {{ $product->description }}
                            </td>

                            <td data-sort="{{ $product->quantity }}">
                                {{ $product->quantity }}
                            </td>

                            <td data-sort="{{ $product->category_id }}">
                                {{ $product->category->title ?? 'N/A' }}
                            </td>

                            <td data-sort="{{ $product->user_id }}">
                                {{ $product->user->name ?? 'N/A' }}
                            </td>

                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 18px; color: red; font-weight: bold;">
                                        ....
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('products.edit', $product->id) }}" class="dropdown-item">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a onclick="deleteProduct('{{ route('products.destroy', $product->id) }}')"
                                                class="dropdown-item" role="button"> <i
                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Remove</a>
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
    function deleteProduct(productSlug) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this product!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: productSlug,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The product has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete the product. Please try again later.',
                                'error'
                            );
                        }
                    });
                }
        });
    }
</script>

   
@endsection