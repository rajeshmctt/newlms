@extends('layouts.admin')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
<script src="https://cdn.tiny.cloud/1/70tcyjckojbg1tq8fl9xaolxupy5dksuu3u0z2hebshcpu1j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.tiny.cloud/1/70tcyjckojbg1tq8fl9xaolxupy5dksuu3u0z2hebshcpu1j/tinymce/5/jquery.tinymce.min.js" referrerpolicy="origin"></script>
<script>
  $('textarea.tiny').tinymce({
   height: 300
   });
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
  // $('.datepicker').datepicker({'format': 'yyyy-mm-dd'});

  $(function(){
    $(document).ready(function() {
        $('.js-multiple-select').select2();
    });
    
    
    $('#type').change(function(){
      $('.file_div, .link_div').removeClass('d-none').addClass('d-none');
      if($(this).val() == 'file') $('.file_div').removeClass('d-none');
      if($(this).val() == 'link') $('.link_div').removeClass('d-none');
    });
    
  });
</script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-8">
          
          <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Edit Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {{ Form::open(array('route' => [config('app.a_slug').'.resources.update', $resource->id], 'method' => 'put', 'files' => true)) }}
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                          <label for="name">Name <span class="text-danger">*</span></label>
                          <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name', $resource->name) }}">
                          @error('name')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" id="description" placeholder="Description" rows="5" >{{ old('description', $resource->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <label for="visibility">Visibility <span class="text-danger">*</span></label>
                        {{ Form::select('visibility', ['private' => 'Private', 'public' => 'Public'], old('visibility', $resource->visibility), ['class' => 'form-control', 'id' => 'visibility', 'placeholder' => 'Select Visibility']) }}
                        @error('visibility')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="format">Format <span class="text-danger">*</span></label>
                        {{ Form::select('format', ['document' => 'Document', 'video' => 'Video', 'audio' => 'Audio', 'other' => 'Other'], old('format', $resource->format), ['class' => 'form-control', 'id' => 'format', 'placeholder' => 'Select Format']) }}
                        @error('format')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        {{ Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], old('status', $resource->status), ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status']) }}
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