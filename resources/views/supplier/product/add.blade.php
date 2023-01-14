@extends('supplier.layout')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form enctype="multipart/form-data" method="post" action="{{$action}}" id="form">
                                    @csrf
                                    <input type="hidden" class="form-control" name="id"
                                        value="{{ isset($row->id)? $row->id : '' }}">
                                    <input type="hidden" class="form-control" name="folder"
                                        value="{{ isset($row->folder)? $row->folder : '' }}">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="mb-3">
                                                <label class="form-label">Make Name</label>
                                                <select name="make_id" id="make_id" class="select2 form-control">
                                                    @if ($makes->count() > 0)
                                                    @foreach ($makes as $make)
                                                    <option value="{{ $make->id }}" @if (@$row->product_make_id ==
                                                        $make->id) selected @endif>{{ $make->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_make_id'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="mb-3">
                                                <label class="form-label"> Model Name</label>
                                                <select name="model_id" id="model_id" class="select2 form-control">
                                                    @if ($models->count() > 0)
                                                    @foreach ($models as $model)
                                                    <option value="{{ $model->id }}"
                                                        data-chained="{{ $model->product_make_id }}" @if (@$row->
                                                        product_model_id ==
                                                        $model->id) selected @endif>{{ $model->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_model_id'></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="mb-3">
                                                <label class="form-label">Year</label>
                                                <select name="year_id" id="year_id" class="select2 form-control">
                                                    @if ($years->count() > 0)
                                                    @foreach ($years as $year)
                                                    <option value="{{ $year->id }}"
                                                        data-chained="{{ $year->product_model_id }}" @if (@$row->
                                                        product_year_id ==
                                                        $year->id) selected @endif>{{ $year->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_year_id'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="mb-3">
                                                <label class="form-label">Engine</label>
                                                <select name="engine_id" id="engine_id" class="select2 form-control">
                                                    @if ($engines->count() > 0)
                                                    @foreach ($engines as $engine)
                                                    <option value="{{ $engine->id }}"
                                                        data-chained="{{ $engine->product_year_id }}" @if (@$row->
                                                        product_engine_id ==
                                                        $engine->id) selected @endif>{{ $engine->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_engine_id'></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="mb-3">
                                                <label class="form-label">Category Name</label>
                                                <select name="category_id" id="category_id"
                                                    class="select2 form-control">
                                                    @if ($categories->count() > 0)
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @if (@$row->product_category_id
                                                        ==
                                                        $category->id) selected @endif>{{ $category->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_category_id'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="mb-3">
                                                <label class="form-label">Subcategory</label>
                                                <select name="subcategory_id" id="subcategory_id"
                                                    class="select2 form-control">
                                                    @if ($subcategories->count() > 0)
                                                    @foreach ($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}"
                                                        data-chained="{{ $subcategory->product_category_id }}"
                                                        @if(@$row->product_sub_category_id == $subcategory->id )
                                                        selected @endif>{{ $subcategory->name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_subcategory_id'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="mb-3">
                                                <label class="form-label"> Brand</label>
                                                <select name="brand_id" id="brand_id" class="select2 form-control">
                                                    @if ($brands->count() > 0)
                                                    @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}" @if (@$row->product_brand_id ==
                                                        $brand->id) selected @endif>{{ $brand->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_brand_id'></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="mb-3">
                                                <label class="form-label">Product Type</label>
                                                <select name="product_type" class="form-control">
                                                    @if ($product_types->count() > 0)
                                                    @foreach ($product_types as $product_type)
                                                    <option value="{{ $product_type->name }}" @if (@$row->product_type
                                                        ==
                                                        $product_type->name) selected @endif>{{ $product_type->name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_product_type'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="mb-3">
                                                <label class="form-label"> SKU</label>
                                                <input type="text" class="form-control" name="sku"
                                                    value="{{old('sku' , isset($row->sku)? $row->sku : '' )}}">
                                                <div class="error" id='error_sku'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="mb-3">
                                                <label class="form-label"> Product Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{old('name' , isset($row->name)? $row->name : '' )}}">
                                                <div class="error" id='error_name'></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="mb-3">
                                                <label class="form-label"> Part Number</label>
                                                <input type="text" class="form-control" name="part_number"
                                                    value="{{old('part_number' , isset($row->part_number)? $row->part_number : '' )}}">
                                                <div class="error" id='error_part_number'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="mb-3">
                                                <label class="form-label">Part Type</label>
                                                <select name="part_type" class="form-control">
                                                    @if ($parts->count() > 0)
                                                    @foreach ($parts as $part)
                                                    <option value="{{ $part->name }}" @if (@$row->part_type ==
                                                        $part->name) selected @endif>{{ $part->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_part_type'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="mb-3">
                                                <label class="form-label"> Manufacturer</label>
                                                <input type="text" class="form-control" name="manufacturer"
                                                    value="{{old('manufacturer' , isset($row->manufacturer)? $row->manufacturer : '' )}}">
                                                <div class="error" id='error_manufacturer'></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="mb-3">
                                                <label class="form-label"> Warranty</label>
                                                <input type="text" class="form-control" name="warranty"
                                                    value="{{old('warranty' , isset($row->warranty)? $row->warranty : '' )}}">
                                                <div class="error" id='error_warranty'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="mb-3">
                                                <label class="form-label"> Product Price</label>
                                                <input type="text" class="form-control digits" name="price"
                                                    value="{{old('price' , isset($row->price)? $row->price : '' )}}">
                                                <div class="error" id='error_price'></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="mb-3">
                                                <label class="form-label"> Stock</label>
                                                <input type="text" class="form-control digits" name="stock"
                                                    value="{{old('stock' , isset($row->stock)? $row->stock : '' )}}">
                                                <div class="error" id='error_stock'></div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <label class="switch">
                                            <input type="checkbox" class="switch-input" name="status" value="1" {{ ((isset($row->
                status) && $row->status == 1) ||  !isset($row->status))? 'checked' : '' }} /> <span
                                                class="switch-label" data-on="Show" data-off="Hide"></span>
                                            <span class="switch-handle"></span> </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary  btn-loading">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('supplier.includes.footer')
    </div>
    @endsection
    @section('footer-scripts')
    @include('supplier.product.js.add')
    @endsection