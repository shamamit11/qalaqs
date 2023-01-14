<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title"> {{ ucwords($product->name) }} Specifications </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            onclick="javascript:window.location.reload()"></button>
    </div>
    <div class="modal-body">
        <form enctype="multipart/form-data" method="post" action="{{route('supplier-product-addspecification')}}"
            id="frm_specification">
            @csrf
            <input name="product_id" value="{{ $product->id }}" type="hidden" />
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                        <label class="form-label"> Name</label>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5">
                        <label class="form-label"> Value</label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2"> </div>
                </div>
                <div class="field_wrapper">
                    @if(count($product->specifications) > 0)
                    @foreach($product->specifications as $specification)
                    <div class="row mb-1 input-specification">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <input type="text" name="specification_name[]"
                                value="{{ $specification->specification_name }}" class="form-control">
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <input type="text" name="specification_value[]"
                                value="{{ $specification->specification_value }}" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2"> <span class="input-group-btn input-group-append">
                                <input type="hidden" name="specification_id[]" value="{{ $specification->id }}"
                                    class="form-control">
                                @if($cnt == 1)
                                <button class="btn btn-info bootstrap-touchspin-up add_button" type="button">+</button>
                                @else
                                <button class="btn btn-danger bootstrap-touchspin-up remove_button"
                                    type="button">-</button>
                                @endif
                            </span> </div>
                    </div>
                    @php $cnt++ @endphp
                    @endforeach
                    @else
                    <div class="row mb-1 input-specification">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <input type="text" name="specification_name[]" class="form-control">
                            <div class="error" id='error_specification_name'></div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <input type="text" name="specification_value[]" class="form-control">
                            <div class="error" id='error_specification_value'></div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2"> <span class="input-group-btn input-group-append">
                                <input type="hidden" name="specification_id[]" value="0" class="form-control">
                                <button class="btn btn-info bootstrap-touchspin-up add_button" type="button">+</button>
                            </span> </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-loading">Submit</button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
            onclick="javascript:window.location.reload()">Close</button>
    </div>
</div>
@include('supplier.product.js.specification')