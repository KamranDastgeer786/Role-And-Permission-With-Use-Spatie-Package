@extends('layouts.app')
@section('page-title', 'Categories')
@section('sub-page-title', 'Create Category')

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
                    
                    <h6 class="mb-4"> {{ isset($category) ? 'Edit' : 'Add' }} Add New Category</h6>
                    <form id="CategoryForm" action="{{ isset($category) ? route('category.update', ['category' => $category->id]) : route('category.store') }}" method="POST">
                        @csrf

                        @if (isset($category))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="	title" value="{{ isset($category) ? $category->title : '' }}"  required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update' : 'Save' }}</button>
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
            $('#CategoryForm').submit(function(e) {
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
                                    '{{ route('category.index') }}';
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
     
    </script>

@endsection