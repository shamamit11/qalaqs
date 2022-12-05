<div class="mb-3">
    <div class="table-responsive">  
        @csrf
        <input name="product_id" type="hidden" value="{{ $product_id }}" >
        <table id="specificationTable" width="100%" class="table table-bordered">
            <tr>
                <th width="2%"></th>
                <th width="49%">Name</th>
                <th width="49%">Value</th>
            </tr>
            @if($specifications->count() > 0)
            @foreach($specifications as $specification)
            <tr>
                <td><input type="checkbox" name="chk" /></td>
                <td><input name="specification_name[]" value="{{ $specification->specification_name }}" type="text" class="form-control" /></td>
                <td><input name="specification_value[]" value="{{ $specification->specification_value }}"  type="text" class="form-control" /></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td><input type="checkbox" name="chk" /></td>
                <td><input name="specification_name[]" type="text" class="form-control" /></td>
                <td><input name="specification_value[]" type="text" class="form-control" /></td>
            </tr>
            @endif
        </table>
        <button type="button" class="btn btn-primary" onclick="addRow('specificationTable')">
            <i class="fa fa-plus fa-lg"></i>
        </button>
        <button type="button" class="btn btn-danger" onclick="deleteRow('specificationTable')">
            <i class="fa fa-trash fa-lg"></i>
        </button>
    </div>
</div>