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
                <h3 class="card-title">Sessions</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route(config('app.a_slug').'.batches.sessions.update', $batch->id) }}" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="card-body">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th><label for="session_no">S.No.</label></th>
                        <th><label for="type">Type <span class="text-danger">*</span></label></th>
                        <th><label for="date">Date <span class="text-danger">*</span></label></th>
                        <th><label for="start_time">Start Time <span class="text-danger">*</span></label></th>
                        <th><label for="end_time">End Time <span class="text-danger">*</span></label></th>
                        <th><label for="description">Description</label></th>
                        <th><label for="action">Action</label></th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($sessions) > 0)
                      @foreach($sessions as $sessionKey => $session)
                      @include('admin.sessions.session_row')
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                  <br>
                  <div class="text-center">
                    <button type="button" class="btn btn-primary add_session"><i class="fa fa-plus"></i> Add Session</button>
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