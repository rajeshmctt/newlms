@extends('store.layouts.master')

@section('script')
<script>
  $('#image').on('change',function(){
      var fileName = $(this).val();
      $(this).next('.custom-file-label').html(fileName);
  })
</script>
@endsection

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
              <form method="post" action="{{ route('item-categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="image">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input name="image" type="file" class="custom-file-input" id="image" accept="image/*">
                        <label class="custom-file-label" for="image">Choose image</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="sort_order">Sort Order <span class="text-danger">*</span></label>
                        <input name="sort_order" type="text" class="form-control" id="sort_order" placeholder="Sort Order" value="{{ old('sort_order') }}">
                        @error('sort_order')
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