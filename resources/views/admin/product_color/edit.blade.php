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
                        <li><a href="{{ route('admin.available-product-color.index') }}">Available Product Colours List</a></li>
                        <li class="text-white"><i class="fa fa-chevron-right"></i></li>
                        <li><a href="#" class="active">Edit Product Colour</a></li>
                    </ul>
                </div>
                @include('admin.layouts.navbar')
            </div>
            <hr>
            <div class="dashboard-body-content">
                <h5>Edit Product Colour</h5>
                <hr>
                <form action="{{ route('admin.available-product-color.update',$product_color->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row m-0 pt-3">
                        <input type="hidden" name="id" value="{{ $product_color->id }}">
                        <div class="col-lg-6">
                            <div class="form-group edit-box">
                                <label for="review">Colour Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $product_color->name ?? old('name') }}">
                                @if ($errors->has('name'))
                                    <span style="color: red;">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group edit-box">
                                <label for="review">Status<span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0" @if ($product_color->status == 0)
                                        selected @endif>Pending</option>
                                    <option value="1" @if ($product_color->status == 1)
                                        selected @endif>Active</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span style="color: red;">{{ $errors->first('status') }}</span>
                                @endif
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
