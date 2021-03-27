
<tr style="height:10px;" class="table-active">
  <td>
    <div class="form-group">
        <input name="session_no" type="text" class="form-control" id="session_no" placeholder="Session No." value="{{ old('session_no', $i) }}" style="width:100px;">
        @error('session_no')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  </td>
  <td>
    <div class="form-group">
        {{ Form::select('type', ['in-person' => 'In-Person', 'online' => 'Online'], old('type', 'online'), ['class' => 'form-control', 'id' => 'type']) }}
        @error('type')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  </td>
  <td>
    <div class="form-group">
        <input name="description" type="text" class="form-control" id="description" placeholder="Description" value="{{ old('description') }}">
        @error('description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  </td>
  <td>
    <div class="form-group">
        <input name="date" type="text" class="form-control" id="date" placeholder="Date" value="{{ old('date') }}">
        @error('date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  </td>
</tr>
                  