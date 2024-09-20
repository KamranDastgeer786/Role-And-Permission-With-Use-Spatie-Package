@extends('layouts.app')

@section('page-title', 'Permissions')

@section('content')

<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
       
        <div class="table-responsive" id="contactList">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="example">
                <thead>
                    <tr>
                        <th scope="col"> ID  </th>
                        <th scope="col"> Module </th>
                        <th scope="col"> Permission </th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    @foreach ($permissions as $index => $permission)
                        @php
                            $parts = explode('_', $permission->name);
                            $operation = ucfirst($parts[0]);
                            $moduleName = ucfirst($parts[1]);
                        @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $moduleName }}</td>
                                <td>{{ $operation }} {{ $moduleName }}</td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Recent Sales End -->
 
@endsection