@extends('layouts.admin')

@section('script')
<script src="https://cdn.tiny.cloud/1/70tcyjckojbg1tq8fl9xaolxupy5dksuu3u0z2hebshcpu1j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.tiny.cloud/1/70tcyjckojbg1tq8fl9xaolxupy5dksuu3u0z2hebshcpu1j/tinymce/5/jquery.tinymce.min.js" referrerpolicy="origin"></script>
<script>
  $('textarea#tiny').tinymce({
   height: 500
   });
</script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-12">
          
          <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Edit Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {{ Form::open(array('route' => [config('app.a_slug').'.agreements.update', $agreement->id], 'method' => 'put', 'files' => true)) }}
                <div class="card-body">
                
                <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name', $agreement->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="content">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control" id="tiny" placeholder="Content">{{ old('content', $agreement->content) }}</textarea>
                        @error('content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        {{ Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], old('status', $agreement->status), ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status']) }}
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