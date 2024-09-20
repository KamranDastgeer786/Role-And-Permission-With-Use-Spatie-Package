@extends('layouts.app')
@section('page-title', 'Products')
@section('sub-page-title', isset($product) ? 'Edit Product' : 'Create Product')

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
                    
                    <h6 class="mb-4">{{ isset($product) ? 'Edit' : 'Add' }} New Product</h6>
                    <form id="ProductForm" action="{{ isset($product) ? route('products.update', ['product' => $product->id]) : route('products.store') }}" method="POST">
                        
                        @csrf

                        @if (isset($product))
                          @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ isset($product) ? $product->name : '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" id="description" required>{{ isset($product) ? $product->description : '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="quantity" id="quantity" value="{{ isset($product) ? $product->quantity : '' }}" required>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="mb-3">

                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required style="background-color: black">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(isset($product) && $category->id == $product->category_id) selected @endif>
                                      {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">

                            <label for="user_id" class="form-label">User</label>
                            <select class="form-control" id="user_id" name="user_id" required style="background-color: black">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if(isset($product) && $user->id == $product->user_id) selected @endif>
                                       {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" style="margin-top: 10px; padding-left: 25px; padding-right: 25px;" >
                            {{ isset($product) ? 'Update' : 'Save' }}
                        </button>
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
        // $(document).ready(function() {

            $(document).ready(function() {
                $('#ProductForm').submit(function(e) {
                  e.preventDefault();

                  var formData = $(this).serialize();


                    $.ajax({
                     url: $(this).attr('action'),
                     type: $(this).attr('method'),
                     dataType: 'json',
                     data: formData,
                        success: function(response) {
                        console.log(response)
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href =
                                    '{{ route('products.index') }}';
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Operation failed!',
                            'error'
                        );
                    }
                });
            });
          });


        //     document.getElementById('chooseFileBtn').addEventListener('click', function() {
        //         $('#mediaUploadModal').modal('show');
        //     });

        // });
     
    </script>

@endsection