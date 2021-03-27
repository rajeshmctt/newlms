
<tr style="height:10px;" class="table-active">
  <td>
    <div class="form-group">
        <input type="button" value="{{ $session->session_no }}" class="btn btn-default" disabled>
    </div>
  </td>
  <td>
    <div class="form-group">
        {{ Form::select('type['.$session->session_no.']', ['in-person' => 'In-Person', 'online' => 'Online'], old('type.'.$session->session_no, $session->type ?? 'online'), ['class' => 'form-control', 'id' => 'type']) }}
        @error('type.'.$session->session_no)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  </td>
  <td>
    <div class="form-group">
        <input name="date[{{ $session->session_no }}]" type="text" class="form-control datepicker-new" id="date" placeholder="Date" value="{{ old('date.'.$session->session_no, $session->date ? $session->date->format('Y-m-d') : '') }}">
        @error('date.'.$session->session_no)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  </td>
  <td>
    <div class="form-group">
        <input name="start_time[{{ $session->session_no }}]" type="text" class="form-control timepicker" id="start_time" placeholder="Start Time" value="{{ old('start_time.'.$session->session_no, $session->start_time ? ($session->start_time ? $session->start_time->format('H:i') : '') : ($batch->start_time ? $batch->start_time->format('H:i') : '') ) }}">
        @error('start_time.'.$session->session_no)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  </td>
  <td>
    <div class="form-group">
        <input name="end_time[{{ $session->session_no }}]" type="text" class="form-control timepicker" id="end_time" placeholder="End Time" value="{{ old('end_time.'.$session->session_no, $session->end_time ? ($session->end_time ? $session->end_time->format('H:i') : '') : ($batch->end_time ? $batch->end_time->format('H:i') : '') ) }}">
        @error('end_time.'.$session->session_no)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  </td>
  <td>
    <div class="form-group">
        <input name="description[{{ $session->session_no }}]" type="text" class="form-control" id="description" placeholder="Description" value="{{ old('description.'.$session->session_no, $session->description) }}">
        @error('description.'.$session->session_no)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  </td>
  <td>
    <div class="form-group">
      @if(count($sessions) == $sessionKey+1)
        <a href="{{ route(config('app.a_slug').'.batches.sessions.delete', $batch->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this session?');"><i class="fas fa-trash"></i></a>
      @endif
    </div>
  </td>
</tr>
                  