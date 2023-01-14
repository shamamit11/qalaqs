<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title"> {{ ucwords($product->name) }} Images </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="javascript:window.location.reload()"></button>
    </div>
    <div class="modal-body">
        <form enctype="multipart/form-data" method="post" action="{{ route('supplier-product-saveimage') }}"
            id="frm_image">
            @csrf
            <input name="product_id" value="{{ $product->id }}" type="hidden" />
            <div class="mb-3">
                <div class="drag-container">
                    <button type="button" class="btn btn-xs btn-danger d-none" id="btn_image_delete">Remove</button>
                    <div class="drag-area">
                        <div class="dropify-message d-block">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                version="1.1" id="Layer_1" x="0px" y="0px" width="64px" height="64px"
                                viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                                <path fill="none" stroke="#8a8a8a" stroke-width="2" stroke-miterlimit="10"
                                    d="M41,50h14c4.565,0,8-3.582,8-8s-3.435-8-8-8  c0-11.046-9.52-20-20.934-20C23.966,14,14.8,20.732,13,30c0,0-0.831,0-1.667,0C5.626,30,1,34.477,1,40s4.293,10,10,10H41" />
                                <polyline fill="none" stroke="#8a8a8a" stroke-width="2" stroke-linejoin="bevel"
                                    stroke-miterlimit="10" points="23.998,34   31.998,26 39.998,34 " />
                                <g>
                                    <line fill="none" stroke="#8a8a8a" stroke-width="2" stroke-miterlimit="10"
                                        x1="31.998" y1="26" x2="31.998" y2="46" />
                                </g>
                            </svg>
                            <p>Drag and drop a file here or click</p>
                        </div>
                        <input type="file" hidden="" />
                        <input name="image" type="hidden" id="image" />
                        <div class="error" id='error_image'></div>
                        <div class="image-preview"> <img src="" id="displayImg" class="d-none">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-loading">Submit</button>
            </div>
        </form>
        @if(count($product->images) > 0)
        <form enctype="multipart/form-data" method="post" action="{{ route('supplier-product-orderimage') }}"
            id="frm_listimage">
            @csrf
            <table id="tblData">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Image</th>
                        <th>Is Default</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->images as $image) <tr>
                        <td>{{$cnt++}}</td>
                        <td><img src="{{ Storage::disk('public')->url('product/'.$product->folder.'/'.$image->image)}}"
                                height="150"></td>
                        <td><label class="switch">
                                <input class="switch-input switch-is_primary" type="checkbox" data-id="{{ $image->id }}"
                                    data-is_primary-value="{{ $image->is_primary }}" @if($image->is_primary == 1)
                                checked @endif /> <span class="switch-label" data-on="Yes" data-off="No"></span> <span
                                    class="switch-handle"></span> </label> </td>
                        <td><input type="hidden" name="id[]" value="{{$image->id}}"> <button type="button"
                                class="btn btn-sm btn-danger rounded-pill delete-image-btn" data-id="{{ $image->id }}"
                                title="Delete Product" data-bs-toggle="tooltip" data-bs-placement="top"><span
                                    class="icon"><i class='fas fa-trash'></i></span></button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  onclick="javascript:window.location.reload()">Close</button>
    </div>
</div>
@include('supplier.product.js.image')