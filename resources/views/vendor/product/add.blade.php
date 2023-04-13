@extends('vendor.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ $page_title }}</h3>
                            </div>
                            <div class="card-body">
                                <form enctype="multipart/form-data" method="post" action="{{ $action }}"
                                    id="form">
                                    @csrf
                                    <input type="hidden" class="form-control" name="id" id="id"
                                        value="{{ isset($row->id) ? $row->id : 0 }}">
                                    <div class="mb-3">
                                        <label class="form-label"> Title</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            value="{{ isset($row->title) ? $row->title : '' }}">
                                        <div class="error" id='error_title'></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Make</label>
                                                    <select name="make_id" id="make_id" class="select2 form-control">
                                                        @if ($makes->count() > 0)
                                                            @foreach ($makes as $make)
                                                                <option value="{{ $make->id }}"
                                                                    @if (@$row->make_id == $make->id) selected @endif>
                                                                    {{ $make->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="error" id='error_make_id'></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"> Model Name</label>
                                                    <select name="model_id" id="model_id" class="select2 form-control">
                                                        @if ($models->count() > 0)
                                                            @foreach ($models as $model)
                                                                <option value="{{ $model->id }}"
                                                                    data-chained="{{ $model->make_id }}"
                                                                    @if (@$row->model_id == $model->id) selected @endif>
                                                                    {{ $model->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="error" id='error_model_id'></div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Year</label>
                                                    <select name="year_id" id="year_id" class="select2 form-control">
                                                        @if ($years->count() > 0)
                                                            @foreach ($years as $year)
                                                                <option value="{{ $year->id }}"
                                                                    data-chained="{{ $year->model_id }}"
                                                                    @if (@$row->year_id == $year->id) selected @endif>
                                                                    {{ $year->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="error" id='error_year_id'></div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Engine</label>
                                                    <select name="engine_id" id="engine_id" class="select2 form-control">
                                                        @if ($engines->count() > 0)
                                                            @foreach ($engines as $engine)
                                                                <option value="{{ $engine->id }}"
                                                                    data-chained="{{ $engine->year_id }}"
                                                                    @if (@$row->engine_id == $engine->id) selected @endif>
                                                                    {{ $engine->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="error" id='error_engine_id'></div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Category Name</label>
                                                    <select name="category_id" id="category_id"
                                                        class="select2 form-control">
                                                        @if ($categories->count() > 0)
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    @if (@$row->category_id == $category->id) selected @endif>
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="error" id='error_category_id'></div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Subcategory</label>
                                                    <select name="subcategory_id" id="subcategory_id"
                                                        class="select2 form-control">
                                                        @if ($subcategories->count() > 0)
                                                            @foreach ($subcategories as $subcategory)
                                                                <option value="{{ $subcategory->id }}"
                                                                    data-chained="{{ $subcategory->category_id }}"
                                                                    @if (@$row->sub_category_id == $subcategory->id) selected @endif>
                                                                    {{ $subcategory->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="error" id='error_subcategory_id'></div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label text-danger"> Price (AED)</label>
                                                    <input type="text" class="form-control" name="price" id="price"
                                                        value="{{ old('price', isset($row->price) ? $row->price : '') }}">
                                                    <div class="error" id='error_price'></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-info"> Discount</label>
                                                    <select name="discount" id="discount" class="selectize form-control">
                                                        <option value="0"
                                                            @if (@$row->discount == 0) selected @endif>0%</option>
                                                        <option value="5"
                                                            @if (@$row->discount == 5) selected @endif>5%</option>
                                                        <option value="10"
                                                            @if (@$row->discount == 10) selected @endif>10%</option>
                                                        <option value="15"
                                                            @if (@$row->discount == 15) selected @endif>15%</option>
                                                        <option value="20"
                                                            @if (@$row->discount == 20) selected @endif>20%</option>
                                                        <option value="25"
                                                            @if (@$row->discount == 25) selected @endif>25%</option>
                                                        <option value="30"
                                                            @if (@$row->discount == 30) selected @endif>30%</option>
                                                        <option value="35"
                                                            @if (@$row->discount == 35) selected @endif>35%</option>
                                                        <option value="50"
                                                            @if (@$row->discount == 50) selected @endif>50%</option>
                                                    </select>
                                                    <div class="error" id='error_discount'></div>
                                                </div>

                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label"> Stock</label>
                                                    <input type="text" class="form-control" name="stock"
                                                        id="stock"
                                                        value="{{ old('stock', isset($row->stock) ? $row->stock : '') }}">
                                                    <div class="error" id='error_stock'></div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label"> SKU</label>
                                                    <input type="text" class="form-control" name="sku"
                                                        id="sku" value="{{ isset($row->sku) ? $row->sku : '' }}">
                                                    <div class="error" id='error_sku'></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"> Part Number</label>
                                                    <input type="text" class="form-control" name="part_number"
                                                        id="part_number"
                                                        value="{{ isset($row->part_number) ? $row->part_number : '' }}">
                                                    <div class="error" id='error_part_number'></div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label"> Brand</label>
                                                    <select name="brand_id" id="brand_id" class="select2 form-control">
                                                        @if ($brands->count() > 0)
                                                            @foreach ($brands as $brand)
                                                                <option value="{{ $brand->id }}"
                                                                    @if (@$row->brand_id == $brand->id) selected @endif>
                                                                    {{ $brand->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="error" id='error_brand_id'></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"> Manufacturer</label>
                                                    <input type="text" class="form-control" name="manufacturer"
                                                        value="{{ old('manufacturer', isset($row->manufacturer) ? $row->manufacturer : '') }}">
                                                    <div class="error" id='error_manufacturer'></div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label"> Part Type</label>
                                                    <select name="part_type" id="part_type"
                                                        class="selectize form-control">
                                                        <option value="Used"
                                                            @if (@$row->part_type == 'Used') selected @endif>Used
                                                        </option>
                                                        <option value="New"
                                                            @if (@$row->part_type == 'New') selected @endif>New</option>
                                                    </select>
                                                    <div class="error" id='error_part_type'></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"> Market</label>
                                                    <select name="market" id="market" class="selectize form-control">
                                                        <option value="Genuine"
                                                            @if (@$row->market == 'Genuine') selected @endif>Genuine
                                                        </option>
                                                        <option value="OEM"
                                                            @if (@$row->market == 'OEM') selected @endif>OEM</option>
                                                    </select>
                                                    <div class="error" id='error_market'></div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="warranty" class="form-label"> Warranty</label>
                                                    <select name="warranty" id="warranty" class="selectize form-control"
                                                        placeholder="Select a warranty">
                                                        <option value="No"
                                                            @if (@$row->warranty == 'No') selected @endif>No Warranty
                                                        </option>
                                                        <option value="7"
                                                            @if (@$row->warranty == 7) selected @endif>7 Days
                                                        </option>
                                                        <option value="15"
                                                            @if (@$row->warranty == 15) selected @endif>15 Days
                                                        </option>
                                                        <option value="30"
                                                            @if (@$row->warranty == 30) selected @endif>30 Days
                                                        </option>
                                                        <option value="60"
                                                            @if (@$row->warranty == 60) selected @endif>60 Days
                                                        </option>
                                                        <option value="90"
                                                            @if (@$row->warranty == 90) selected @endif>90 Days
                                                        </option>
                                                    </select>
                                                    <div class="error" id='error_warranty'></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"> Origin</label>
                                                    <input type="text" class="form-control" name="origin" id="origin"
                                                        value="{{ old('origin', isset($row->origin) ? $row->origin : '') }}">
                                                    <div class="error" id='error_origin'></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label"> Weight (g)</label>
                                            <input type="text" class="form-control" name="weight" id="weight"
                                                value="{{ old('weight', isset($row->weight) ? $row->weight : '') }}">
                                            <div class="error" id='error_weight'></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label"> Length (cm)</label>
                                            <input type="text" class="form-control" name="length" id="length"
                                                value="{{ old('length', isset($row->length) ? $row->length : '') }}">
                                            <div class="error" id='error_length'></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label"> Width (cm)</label>
                                            <input type="text" class="form-control" name="width" id="width"
                                                value="{{ old('width', isset($row->width) ? $row->width : '') }}">
                                            <div class="error" id='error_width'></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label"> Height (cm)</label>
                                            <input type="text" class="form-control" name="height" id="height"
                                                value="{{ old('height', isset($row->height) ? $row->height : '') }}">
                                            <div class="error" id='error_height'></div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <hr>
                                        <h4 class="mb-3 header-title">Product Images</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> Main Image</label>
                                                <br>
                                                <input type="file" name="file_main_image" id="file_main_image" class="d-none" onchange="mainImageBrowser(this)">
                                                <label type="button" for="file_main_image" class="btn btn-secondary">Choose File</label>
                                                <input name="main_image" type="hidden" id="main_image" value="{{ old('main_image', isset($row->main_image) ? $row->main_image : '') }}"/>
                                                <div>
                                                    @if(@$row->main_image)
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/storage/product/'.@$row->main_image)}}" id="displayMainImage" class="file-image-preview">
                                                        </div>
                                                    @else
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/assets/admin/images/browser.png')}}" id="displayMainImage" class="file-image-preview">
                                                        </div>
                                                    @endif
                                                    <div style="margin:5px 0 0 0;"
                                                        class="{{ (@$row->main_image) ? 'd-block' : 'd-none' }}"
                                                        id='btn_main_image_delete'>
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            Onclick="confirmDelete('main_image', '{{@$row->main_image}}', 'displayMainImage', 'btn_main_image_delete')">Remove Image</button>
                                                    </div>
                                                </div>
                                                <div class="error" id='error_main_image'></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label"> Image 01</label>
                                                <br>
                                                <input type="file" name="file_image_01" id="file_image_01" class="d-none" onchange="image01ImageBrowser(this)">
                                                <label type="button" for="file_image_01" class="btn btn-secondary">Choose File</label>
                                                <input name="image_01" type="hidden" id="image_01" value="{{ old('image_01', isset($row->image_01) ? $row->image_01 : '') }}"/>
                                                <div>
                                                    @if(@$row->image_01)
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/storage/product/'.@$row->image_01)}}" id="displayImage01" class="file-image-preview">
                                                        </div>
                                                    @else
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/assets/admin/images/browser.png')}}" id="displayImage01" class="file-image-preview">
                                                        </div>
                                                    @endif
                                                    <div style="margin:5px 0 0 0;"
                                                        class="{{ (@$row->image_01) ? 'd-block' : 'd-none' }}"
                                                        id='btn_image_01_delete'>
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            Onclick="confirmDelete('image_01', '{{@$row->image_01}}', 'displayImage01', 'btn_image_01_delete')">Remove Image</button>
                                                    </div>
                                                </div>
                                                <div class="error" id='error_image_01'></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label"> Image 02</label>
                                                <br>
                                                <input type="file" name="file_image_02" id="file_image_02" class="d-none" onchange="image02ImageBrowser(this)">
                                                <label type="button" for="file_image_02" class="btn btn-secondary">Choose File</label>
                                                <input name="image_02" type="hidden" id="image_02" value="{{ old('image_02', isset($row->image_02) ? $row->image_02 : '') }}"/>
                                                <div>
                                                    @if(@$row->image_02)
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/storage/product/'.@$row->image_02)}}" id="displayImage02" class="file-image-preview">
                                                        </div>
                                                    @else
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/assets/admin/images/browser.png')}}" id="displayImage02" class="file-image-preview">
                                                        </div>
                                                    @endif
                                                    <div style="margin:5px 0 0 0;"
                                                        class="{{ (@$row->image_02) ? 'd-block' : 'd-none' }}"
                                                        id='btn_image_02_delete'>
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            Onclick="confirmDelete('image_02', '{{@$row->image_02}}', 'displayImage02', 'btn_image_02_delete')">Remove Image</button>
                                                    </div>
                                                </div>
                                                <div class="error" id='error_image_02'></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label"> Image 03</label>
                                                <br>
                                                <input type="file" name="file_image_03" id="file_image_03" class="d-none" onchange="image03ImageBrowser(this)">
                                                <label type="button" for="file_image_03" class="btn btn-secondary">Choose File</label>
                                                <input name="image_03" type="hidden" id="image_03" value="{{ old('image_03', isset($row->image_03) ? $row->image_03 : '') }}"/>
                                                <div>
                                                    @if(@$row->image_03)
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/storage/product/'.@$row->image_03)}}" id="displayImage03" class="file-image-preview">
                                                        </div>
                                                    @else
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/assets/admin/images/browser.png')}}" id="displayImage03" class="file-image-preview">
                                                        </div>
                                                    @endif
                                                    <div style="margin:5px 0 0 0;"
                                                        class="{{ (@$row->image_03) ? 'd-block' : 'd-none' }}"
                                                        id='btn_image_03_delete'>
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            Onclick="confirmDelete('image_03', '{{@$row->image_03}}', 'displayImage03', 'btn_image_03_delete')">Remove Image</button>
                                                    </div>
                                                </div>
                                                <div class="error" id='error_image_03'></div>
                                            </div>
                                            <div class="col-md-3 mt-3">
                                                <label class="form-label"> Image 04</label>
                                                <br>
                                                <input type="file" name="file_image_04" id="file_image_04" class="d-none" onchange="image04ImageBrowser(this)">
                                                <label type="button" for="file_image_04" class="btn btn-secondary">Choose File</label>
                                                <input name="image_04" type="hidden" id="image_04" value="{{ old('image_04', isset($row->image_04) ? $row->image_04 : '') }}"/>
                                                <div>
                                                    @if(@$row->image_04)
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/storage/product/'.@$row->image_04)}}" id="displayImage04" class="file-image-preview">
                                                        </div>
                                                    @else
                                                        <div style="margin:5px 0 0 0;"> 
                                                            <img src="{{ asset('/assets/admin/images/browser.png')}}" id="displayImage04" class="file-image-preview">
                                                        </div>
                                                    @endif
                                                    <div style="margin:5px 0 0 0;"
                                                        class="{{ (@$row->image_04) ? 'd-block' : 'd-none' }}"
                                                        id='btn_image_04_delete'>
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            Onclick="confirmDelete('image_04', '{{@$row->image_03}}', 'displayImage04', 'btn_image_04_delete')">Remove Image</button>
                                                    </div>
                                                </div>
                                                <div class="error" id='error_image_04'></div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    @if(@$row->id)
                                        <div class="row mt-3">
                                            <hr>
                                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                                <h4 class=" header-title">Suitable For</h4>
                                                <a href="{{ route('vendor-product-addmatch', ['id=' . $row->id]) }}" class="btn btn-secondary my-2 my-sm-0 ms-1">
                                                    +</a>
                                            </div>
                                            @if(count($matches) > 0)
                                            <hr>
                                            <div class="table-responsive table-bordered ">
                                                <table class="table table-striped mb-0 ">
                                                    <thead>
                                                        <tr>
                                                            <th>Make</th>
                                                            <th>Model</th>
                                                            <th>Year</th>
                                                            <th>Engine</th>
                                                            <th style="text-align:center" width="100">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($matches as $val)
                                                            <tr id="tr{{ $val->id }}" style="vertical-align: middle">
                                                                <td>{{ isset($val->make_id) ? $val->make->name : '' }}</td>
                                                                <td>{{ isset($val->model_id) ? $val->model->name : '' }}</td>
                                                                <td>{{ isset($val->year_id) ? $val->year->name : '' }}</td>
                                                                <td>{{ isset($val->engine_id) ? $val->engine->name : '' }}</td>
                                                                <td style="text-align:center">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger rounded-pill delete-match-btn"
                                                                        data-id="{{ $val->id }}"><span class="icon"><i
                                                                    class='fas fa-trash'></i></span></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @endif
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="mt-3 col-3">
                                        <label class="form-label"> Status</label>
                                        <select name="status" id="status" class="selectize form-control">
                                            <option value="1"
                                                @if (@$row->status == '1') selected @endif>Active
                                            </option>
                                            <option value="0"
                                                @if (@$row->status == '0') selected @endif>Inactive</option>
                                        </select>
                                        <div class="error" id='error_status'></div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary  btn-loading">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('vendor.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('vendor.product.js.add')
    @endsection
