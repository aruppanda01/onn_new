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
                        <li><a href="{{ route('admin.product.edit', $product_id) }}">Edit Product</a></li>
                        <li class="text-white"><i class="fa fa-chevron-right"></i></li>
                        <li><a href="#" class="active">Product Variant</a></li>
                    </ul>
                </div>
                @include('admin.layouts.navbar')
            </div>
            <hr>
            <div class="dashboard-body-content">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Product Variant</h5>
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
                                <th>Action</th>
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

                                    <td>
                                        <a href="{{ route('admin.editVariant', $product->id) }}"
                                            class="ml-2"><i class="far fa-edit"></i></a>
                                        <a href="javascript:void(0);" class="ml-2" data-toggle="modal"
                                        data-target="#exampleModal" onclick="deleteForm({{ $product->id }})"><i
                                            class="far fa-trash-alt text-danger"></i></a>
                                    <form id="delete_form_{{ $product->id }}"
                                        action="{{ route('admin.deleteVariant', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                    </form>
                                    </td>
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
        function deleteForm(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            iconHtml: '<img src="{{ asset('admin/img/logo-inverse.png') }}">',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();
                document.getElementById('delete_form_' + id).submit();
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data  is safe :)',
                    'error'
                )
            }
        })
    }
</script>
@endsection
