<div class="mb-3">
    <div class="table-responsive">
        @csrf
        <input name="product_id" type="hidden" value="{{ $product_id }}">
        <table id="matchTable" width="100%" class="table table-bordered">
            <tr>
                <th width="2%"></th>
                <th width="98%">Engine</th>
            </tr>
            @if($matches->count() > 0)
            @foreach($matches as $match)
            <tr>
                <td><input type="checkbox" name="chk" /></td>
                <td><select name="engine_id[]" class="select2 form-control">
                        @if ($engines->count() > 0)
                        @foreach ($engines as $engine)
                        <option value="{{ $engine->id }}" @if (@$match->product_engine_id == $engine->id) selected @endif>{{ $engine->make->name }} / {{ $engine->model->name }} / {{ $engine->year->name }} / {{ $engine->name }}</option>
                        @endforeach
                        @endif
                    </select></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td><input type="checkbox" name="chk" /></td>
                <td> <select name="engine_id[]" class="select2 form-control">
                        @if ($engines->count() > 0)
                        @foreach ($engines as $engine)
                        <option value="{{ $engine->id }}">{{ $engine->make->name }} / {{ $engine->model->name }} / {{ $engine->year->name }} / {{ $engine->name }}</option>
                        @endforeach
                        @endif
                    </select></td>
            </tr>
            @endif
        </table>
        <button type="button" class="btn btn-primary" onclick="addRow('matchTable')">
            <i class="fa fa-plus fa-lg"></i>
        </button>
        <button type="button" class="btn btn-danger" onclick="deleteRow('matchTable')">
            <i class="fa fa-trash fa-lg"></i>
        </button>
    </div>
</div>