<!-- Modal -->
<div class="modal fade" id="examModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Variant</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.addVariant') }}" method="POST">
            @csrf
          <div class="col-lg-12">
            <div class="row align-items-center" id="add_multiple_variant">
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">Available Sizes<span class="text-danger">*</span></label>
                        <select class="form-control"
                            name="addMoreInputFields[0][sizes]">
                            <option value="">Select Size</option>
                            @foreach ($available_product_sizes as $avl_size)
                                <option value="{{ $avl_size->id }}">{{ $avl_size->size }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger size_err"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">Product Colour<span class="text-danger">*</span></label>
                        <select class="form-control" name="addMoreInputFields[0][color]">
                            @foreach($available_colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }} </option>
                            @endforeach

                        </select>
                        <span class="text-danger color_err"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">MRP<span class="text-danger">*</span></label>
                        <input type="number" id="mrp" class="form-control"
                            name="addMoreInputFields[0][mrp]" value="{{ old('mrp') }}" min="1">
                        <span class="text-danger mrp_err"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">Discount(%)<span class="text-danger">*</span></label>
                        <input type="number" id="discount" class="form-control"
                            name="addMoreInputFields[0][discount]" value="{{ old('discount') }}" min="1">
                        <span class="text-danger discount_err"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">FInal Price<span class="text-danger">*</span></label>
                        <input type="number" id="price" class="form-control"
                            name="addMoreInputFields[0][price]" value="{{ old('price') }}" min="1">
                        <span class="text-danger price_err"></span>
                    </div>
                </div>
            </div>
        </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="add_variant"><i class="fa fa-plus"></i> Add</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
      </div>
    </div>
  </div>