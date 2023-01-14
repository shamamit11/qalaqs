<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title"> {{ ucwords($product->name) }} Matches </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            onclick="javascript:window.location.reload()"></button>
    </div>
    <div class="modal-body">
        <form enctype="multipart/form-data" method="post" action="{{route('supplier-product-addmatch')}}"
            id="frm_match">
            @csrf
            <input name="product_id" value="{{ $product->id }}" type="hidden" />
            <div class="mb-3">

                <label class="form-label"> Engine</label>
                <div class="field_wrapper">
                    @if(count($product->matches) > 0)
                    @foreach($product->matches as $match)
                    <div class="mb-1 input-group input-match input-group-merge">
                        
                        <select name="engine_id[]" class="select2 form-control">
                            @if ($engines->count() > 0)
                            @foreach ($engines as $engine)
                            <option value="{{ $engine->id }}" @if (@$match->product_engine_id == $engine->id) selected
                                @endif>{{ $engine->make->name }} / {{ $engine->model->name }} /
                                {{ $engine->year->name }} / {{ $engine->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        <span class="input-group-btn input-group-append">
                        <input type="hidden" name="match_id[]" value="{{ $match->id }}" class="form-control">
                        @if($cnt == 1)
                            <button class="btn btn-info bootstrap-touchspin-up add_button" type="button">+</button>
                            @else
                            <button class="btn btn-danger bootstrap-touchspin-up remove_button" type="button">-</button>
                            @endif
                        </span>
                    </div>
                    @php $cnt++ @endphp
                    @endforeach
                    @else
                    <div class="mb-1 input-group input-match input-group-merge">
                        <input type="hidden" name="match_id[]" value="0" class="form-control">
                        <select name="engine_id[]" class="select2 form-control">
                            @if ($engines->count() > 0)
                            @foreach ($engines as $engine)
                            <option value="{{ $engine->id }}">{{ $engine->make->name }} / {{ $engine->model->name }} /
                                {{ $engine->year->name }} / {{ $engine->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        <span class="input-group-btn input-group-append"><button
                                class="btn btn-info bootstrap-touchspin-up add_button" type="button">+</button></span>
                    </div>

                    <!-- <select name="engine_id[]" class="select2 form-control">
                        @if ($engines->count() > 0)
                        @foreach ($engines as $engine)
                        <option value="{{ $engine->id }}" @if (@$match->product_engine_id == $engine->id) selected @endif>{{ $engine->make->name }} / {{ $engine->model->name }} / {{ $engine->year->name }} / {{ $engine->name }}</option>
                        @endforeach
                        @endif
                    </select>

                  <span class="input-group-btn input-group-append">
                            <input type="hidden" name="match_id[]" value="0" class="form-control">
                            <button class="btn btn-info bootstrap-touchspin-up add_button" type="button">+</button>
                        </span>  -->
                    @endif
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
@include('supplier.product.js.match')