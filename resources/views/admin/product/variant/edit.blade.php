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
                        <li><a href="#">Edit Product</a></li>
                        <li class="text-white"><i class="fa fa-chevron-right"></i></li>
                        <li><a href="{{ route('admin.getAllProductVariantById',$product_variant_details->product_id) }}">Product Variant</a></li>
                        <li class="text-white"><i class="fa fa-chevron-right"></i></li>
                        <li><a href="#" class="active">Edit Variant</a></li>
                    </ul>
                </div>
                @include('admin.layouts.navbar')
            </div>
            <hr>
            <div class="dashboard-body-content">
                <h5>Edit variant</h5>
                <hr>
                <form action="{{ route('admin.updateVariant',$variant_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $variant_id }}">
                    <div class="col-lg-12">
                        <div class="row align-items-center" id="add_multiple_variant">
                            <div class="col-lg-4">
                                <div class="form-group edit-box">
                                    <label for="review">Available Sizes<span class="text-danger">*</span></label>
                                    <select class="form-control" name="sizes">
                                        <option value="">Select Size</option>
                                        @foreach ($available_product_sizes as $avl_size)
                                            <option value="{{ $avl_size->id }}" @if ($product_variant_details->size_id == $avl_size->id)
                                                selected
                                            @endif>{{ $avl_size->size }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('sizes'))
                                        <span style="color: red;">{{ $errors->first('sizes') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group edit-box">
                                    <label for="review">Product Colour<span class="text-danger">*</span></label>
                                    <select class="form-control" name="color">
                                        @foreach($available_colors as $color)
                                                <option value="{{ $color->id }}" @if ($product_variant_details->color_id == $color->id)
                                                    selected
                                                @endif>{{ $color->name }} </option>
                                        @endforeach
            
                                    </select>
                                    @if ($errors->has('color'))
                                        <span style="color: red;">{{ $errors->first('color') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group edit-box">
                                    <label for="review">MRP<span class="text-danger">*</span></label>
                                    <input type="number" id="mrp" class="form-control"
                                        name="mrp" value="{{ $product_variant_details->mrp ?? old('mrp') }}" min="1">
                                    @if ($errors->has('mrp'))
                                        <span style="color: red;">{{ $errors->first('mrp') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group edit-box">
                                    <label for="review">Discount(%)<span class="text-danger">*</span></label>
                                    <input type="number" id="discount" class="form-control"
                                        name="discount" value="{{ $product_variant_details->discount ?? old('discount') }}" min="1">
                                    @if ($errors->has('description'))
                                        <span style="color: red;">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="actionbutton">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
