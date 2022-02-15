<script>
    $(document).ready(function() {
        $('#product_table').DataTable();
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,

        });
    });
    CKEDITOR.replace('description');

    $(document).on("click", ".add_question_section", function() {
        var product_id = $(this).data('id');
        $(".modal-body #product_id").val(product_id);
        // $(".modal-body #exam_total_marks").val(exam_total_marks);
        // $(".modal-header #exam_full_marks").append(exam_full_marks);
    });

    /*
        It's used to validate  product variant
        Like different size, different color and different price
    */
    var i = 0;
    var k = 0;
    $('#add_variant').on('click', function(e) {

        // start
        var errorFlagOne = 0;
        var inputs = document.getElementById('add_multiple_variant').getElementsByTagName('input');
        var selectInputs = document.getElementById('add_multiple_variant').getElementsByTagName('select');

        for (var i = 0; i < inputs.length; ++i) {
            let input_value = inputs[i].value;
            if (inputs[i].type === 'number') {
                if (inputs[i].value === '') {
                    if (k == 0) {
                        setTimeout(() => {
                            $('.discount_err').text('');
                        }, 5000);
                        $('.discount_err').text('This filed can\'t be blank');
                        setTimeout(() => {
                            $('.mrp_err').text('');
                        }, 5000);
                        $('.mrp_err').text('This filed can\'t be blank');;
                    } else {
                        setTimeout(() => {
                            $('.discount_err' + (k)).text('');
                        }, 5000);
                        $('.discount_err' + (k)).text('This filed can\'t be blank');
                        setTimeout(() => {
                            $('.mrp_err' + (k)).text('');
                        }, 5000);
                        $('.mrp_err' + (k)).text('This filed can\'t be blank');
                    }
                    errorFlagOne = 1;
                }
            }
        }
        for (var i = 0; i < selectInputs.length; ++i) {
            let input_value = selectInputs[i].value;
            if (selectInputs[i].value === '') {
                if (k == 0) {
                    setTimeout(() => {
                        $('.size_err').text('');
                    }, 5000);
                    $('.size_err').text('This filed can\'t be blank');
                } else {
                    setTimeout(() => {
                        $('.size_err' + (k)).text('');
                    }, 5000);
                    $('.size_err' + (k)).text('This filed can\'t be blank');
                }
                errorFlagOne = 1;
            }
        }
        // end

        if (errorFlagOne == 1) {
            return false;
        } else {
            $("#add_multiple_variant").append(`<br><hr>
                <div class="col-lg-5">
                    <div class="form-group edit-box">
                        <label for="review">Available Sizes<span class="text-danger">*</span></label>
                        <select class="form-control" name="addMoreInputFields[${i}][sizes]">
                            <option value="">Select Size</option>
                            @foreach ($available_product_sizes as $avl_size)
                                <option value="{{ $avl_size->id }}">{{ $avl_size->size }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger size_err${k+1}"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">Product Colour<span class="text-danger">*</span></label>
                        <select class="form-control" name="addMoreInputFields[${i}][color]">
                            @foreach ($available_colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }} </option>
                            @endforeach

                        </select>
                        <span class="text-danger color_err${k+1}"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">MRP<span class="text-danger">*</span></label>
                        <input type="number" id="mrp" class="form-control"
                            name="addMoreInputFields[${i}][mrp]" value="{{ old('mrp') }}" min="1">
                        <span class="text-danger mrp_err${k+1}"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">Discount(%)<span class="text-danger">*</span></label>
                        <input type="number" id="discount" class="form-control"
                            name="addMoreInputFields[${i}][discount]" value="{{ old('discount') }}" min="1">
                        <span class="text-danger discount_err${k+1}"></span>
                    </div>
                </div>
            `);
            ++i;
            ++k;
        }
    });

    /*
        It's used to store  product variant
        Like different size, different color and different price
    */
    $('#btn_submit').on('click', function(e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "To create this product!",
            iconHtml: '<img src="{{ asset('admin/img/logo-inverse.png') }}">',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();

                // start
                var errorFlagOne = 0;
                var inputs = document.getElementById('add_multiple_variant').getElementsByTagName(
                    'input');
                var selectInputs = document.getElementById('add_multiple_variant').getElementsByTagName(
                    'select');

                for (var i = 0; i < inputs.length; ++i) {
                    let input_value = inputs[i].value;
                    if (inputs[i].type === 'number') {
                        if (inputs[i].value === '') {
                            if (k == 0) {
                                setTimeout(() => {
                                    $('.discount_err').text('');
                                }, 5000);
                                $('.discount_err').text('This filed can\'t be blank');
                                setTimeout(() => {
                                    $('.mrp_err').text('');
                                }, 5000);
                                $('.mrp_err').text('This filed can\'t be blank');;
                            } else {
                                setTimeout(() => {
                                    $('.discount_err' + (k)).text('');
                                }, 5000);
                                $('.discount_err' + (k)).text('This filed can\'t be blank');
                                setTimeout(() => {
                                    $('.mrp_err' + (k)).text('');
                                }, 5000);
                                $('.mrp_err' + (k)).text('This filed can\'t be blank');
                            }
                            errorFlagOne = 1;
                        }
                    }
                }
                for (var i = 0; i < selectInputs.length; ++i) {
                    let input_value = selectInputs[i].value;
                    if (selectInputs[i].value === '') {
                        if (k == 0) {
                            setTimeout(() => {
                                $('.size_err').text('');
                            }, 5000);
                            $('.size_err').text('This filed can\'t be blank');
                        } else {
                            setTimeout(() => {
                                $('.size_err' + (k)).text('');
                            }, 5000);
                            $('.size_err' + (k)).text('This filed can\'t be blank');
                        }
                        errorFlagOne = 1;
                    }
                }
                // end

                if (errorFlagOne == 1) {
                    return false;
                } else {
                    $('.product-form').submit();
                }
            }
        })
    });

    /*
        For Delete a product
    */
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
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
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

    setTimeout(function() {
        $(".alert-success").hide();
    }, 5000);
</script>
