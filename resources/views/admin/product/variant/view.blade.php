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
                        <li><a href="{{ route('admin.product.index') }}">All Product List</a></li>
                        <li class="text-white"><i class="fa fa-chevron-right"></i></li>
                        <li><a href="{{ route('admin.product.show', $product_id) }}">View Product</a></li>
                        <li class="text-white"><i class="fa fa-chevron-right"></i></li>
                        <li><a href="#" class="active">Product Variant</a></li>
                    </ul>
                </div>
                @include('admin.layouts.navbar')
            </div>
            <hr>
            <div class="dashboard-body-content">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Product Variant view</h5>
                    {{-- <a href="{{ route('admin.product.create') }}" class="actionbutton btn btn-sm">ADD PRODUCT</a> --}}
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
                                <th>Size</th>
                                <th>Color</th>
                                <th>MRP(Rs.)</th>
                                <th>Discount(%)</th>
                                <th>Actual Price(Rs.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_variant_details as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    {{-- <td>{{ $product->size_id}}</td> --}}
                                    @php
                                        $productSize = App\Models\ProductSize::find($product->size_id)->size;
                                        $productColor = App\Models\ProductColor::find($product->color_id)->name;
                                    @endphp
                                    <td>{{ $productSize}}</td>
                                    <td>{{ $productColor }}</td>
                                    <td>{{ $product->mrp }}</td>
                                    <th>{{ $product->discount }}</th>
                                    <th>{{ $product->actual_price }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
         $(document).ready(function() {
            $('#product_table').DataTable();
        });
    </script>
@endsection
