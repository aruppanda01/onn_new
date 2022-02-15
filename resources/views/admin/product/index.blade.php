@extends('admin.layouts.master')

@section('content')
    <div class="dashboard-body" id="content">
        <div class="dashboard-content">
            <div class="row m-0 dashboard-content-header">
                <div class="col-lg-6 d-flex">
                    <a id="sidebarCollapse" href="javascript:void(0);">
                        <i class="fas fa-bars"></i>
                    </a>
                    <ul class="breadcrumb p-0">
                        <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="text-white"><i class="fa fa-chevron-right"></i></li>
                        <li><a href="#" class="active">All Product List</a></li>

                    </ul>
                </div>
                @include('admin.layouts.navbar')
            </div>
            <hr>
            <div class="dashboard-body-content">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Product List</h5>
                    <a href="{{ route('admin.product.create') }}" class="actionbutton btn btn-sm">ADD PRODUCT</a>
                </div>
                <hr>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table-responsive edit-table">
                    <table class="table table-sm table-hover" id="product_table">
                        <thead>
                            <tr>
                                <th>Serial No</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Range</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ Illuminate\Support\Str::limit($product->name, 20) }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->range->name }}</td>
                                    <td>
                                        @if ($product->status == 1)
                                            <span class="badge badge-primary">Active</span>
                                        @else
                                            <span class="badge badge-primary">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span data-toggle="modal" data-target="#examModal" data-id="{{ $product->id }}"
                                            class="add_question_section">
                                            <a href="#"><i class="fa fa-plus mr-2" data-toggle="tooltip"
                                                    data-placement="top" title="Add Variant"></i></a>
                                        </span>
                                        <a href="{{ route('admin.product.show', $product->id) }}"><i
                                                class="far fa-eye"></i></a>
                                        <a href="{{ route('admin.product.edit', $product->id) }}"
                                            class="ml-2"><i class="far fa-edit"></i></a>
                                        {{-- <a href="javascript:void(0);" class="ml-2" data-toggle="modal"
                                        data-target="#exampleModal" onclick="deleteForm({{ $category->id }})"><i
                                            class="far fa-trash-alt text-danger"></i></a>
                                    <form id="delete_form_{{ $category->id }}"
                                        action="{{ route('admin.category.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.product.modal.add_variant')
    @include('admin.product.product_js')
@endsection
