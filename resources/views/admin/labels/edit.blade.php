@extends('layouts.admin')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-6">
          
          <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Edit Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {{ Form::open(array('route' => [config('app.a_slug').'.labels.update', $label->id], 'method' => 'put', 'files' => true)) }}
                <div class="card-body">
                
                <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name', $label->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        {{ Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], old('status', $label->status), ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status']) }}
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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