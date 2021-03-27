@extends('layouts.admin')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

<style>
  .table th, .table td {
    padding: 10px;
    vertical-align: middle !important;
    border: none;
  }
  .table th, .table td .form-group {
      margin-bottom: 0;
  }
</style>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script type="text/javascript">
  // $('.datepicker').datepicker({'format': 'yyyy-mm-dd'});
  $('.datepicker-new').datepicker({'format': 'yyyy-mm-dd'});

  $('.timepicker').timepicker({
      timeFormat: 'HH:mm',
      interval: 30,
      minTime: '00',
      dynamic: false,
      dropdown: true,
      scrollbar: true
  });


  $(function(){
    $(document).ready(function() {
        $('.js-multiple-select').select2();
    });
    
    $('input[name="start_time"]').change(function(){
      // $('input[name="end_time"]').val(($(this).val()) + $('select[name="duration"]').val());
      $('input[name="end_time"]').val(
        // console.log(moment.duration($(this).val()).asMinutes() + moment.duration($('select[name="duration"]').val()).asMinutes());
      );
    });

    $('.add_session').click(function(){
      $.ajax({
          type:'POST',
          url:"{{ route(config('app.a_slug').'.batches.sessions', $batch->id) }}",
          data: {"_token": "{{ csrf_token() }}"},
          success:function(response) {
            if(response.status == true){
              location.reload();
            }
          }
      });
    });
  });
</script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-12">
          
            @if(session()->get('success'))
                <div class="alert alert-success">
                {{ session()->get('success') }}  
                </div>
            @endif
        
            @if(session()->get('error'))
                <div class="alert alert-danger">
                {{ session()->get('error') }}  
                </div>
            @endif
        
          <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Participant Resources</h3>
              </div>
              <!-- /.card-header -->
                @method('put')
                @csrf
                <div class="card-body">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th><label for="resource">Resource</label></th>
                        <th><label for="participants">Participants</label></th>
                        <th><label for="action">Action</label></th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($resources) > 0)
                      @foreach($resources as $resourceKey => $resource)

              <!-- form start -->
              <form method="post" action="{{ route(config('app.a_slug').'.batches.resources.update', [$batch->id, $resource->resource_id]) }}" >
                        @csrf
                        @method('put')
                        <tr style="height:10px;" class="table-active">
                          <td>
                            {{ $resource->resource->name }}
                          </td>
                          <td>
                            <div class="form-group">
                                {{ Form::select('user_ids[]', $users, old('user_ids', $resource->userIds), ['class' => 'form-control js-multiple-select', 'id' => 'user_ids', 'multiple']) }}
                                @error('user_ids')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                          </td>
                          <td>
                            <button type="submit" class="btn btn-primary">Save</button>
                          </td>
                        </tr>
                               
              </form>           
                      @endforeach
                      @endif
              <!-- form start -->
              <form method="post" action="{{ route(config('app.a_slug').'.batches.resources.store', $batch->id) }}">
                @csrf
                        <tr style="height:10px;" class="table-active">
                          <td>
                            <div class="form-group">
                                {{ Form::select('resource_id', $allResources, old('resource_id'), ['class' => 'form-control', 'id' => 'resource_id', 'placeholder' => 'Select Resource']) }}
                                @error('resource_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                                {{ Form::select('user_ids[]', $users, old('user_ids'), ['class' => 'form-control js-multiple-select', 'id' => 'user_ids', 'multiple']) }}
                                @error('user_ids')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                          </td>
                          <td>
                            <button type="submit" class="btn btn-primary">Save</button>
                          </td>
                        </tr>
                                
              </form>           
                    </tbody>
                  </table>

                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
          
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection