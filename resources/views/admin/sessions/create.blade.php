@extends('layouts.admin')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-6">
          
          <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Create Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route(config('app.a_slug').'.sessions.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="batch_id" value="{{ $batch->id }}" />
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="session_no">Session No <span class="text-danger">*</span></label>
                        <input name="session_no" type="text" class="form-control" id="session_no" placeholder="Session No" value="{{ old('session_no', $batch->sessions_count+1) }}" readonly>
                        @error('session_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="type">Type <span class="text-danger">*</span></label>
                        {{ Form::select('type', ['in-person' => 'In-Person', 'online' => 'Online'], old('type'), ['class' => 'form-control', 'id' => 'type', 'placeholder' => 'Select Type']) }}
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" id="description" placeholder="Description" rows="5" >{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <label for="date">Date <span class="text-danger">*</span></label>
                        <input name="date" type="text" class="form-control" id="date" placeholder="yyyy-mm-dd" value="{{ old('date') }}">
                        @error('date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="start_time">Start Time <span class="text-danger">*</span></label>
                        <input name="start_time" type="text" class="form-control" id="start_time" placeholder="00:00" value="{{ old('start_time') }}">
                        @error('start_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="end_time">End Time <span class="text-danger">*</span></label>
                        <input name="end_time" type="text" class="form-control" id="end_time" placeholder="00:00" value="{{ old('end_time') }}">
                        @error('end_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection