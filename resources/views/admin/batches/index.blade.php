@extends('layouts.admin')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript">
  $(function(){
    $(document).ready(function() {
        $('.js-multiple-select').select2();
    });
    $('.datepicker-new').datepicker({'format': 'yyyy-mm-dd', 'orientation': 'bottom', 'autoclose': true});
  });
</script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
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
        
            <div class="card">
              <div class="card-header">
                <form action="{{ route(config('app.a_slug').'.batches.index')}}" method="get" style="display:inline;">
                  @if($program)
                  <input type="hidden" name="program_id" value="{{ $program->id }}" /> 
                  @endif
                  <div class="input-group input-group-sm" style="width: 50%; display: inline-flex;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $search }}">
                    <input type="text" name="start_date" class="form-control float-right datepicker-new" placeholder="Start Date" value="{{ $startDate }}" autocomplete="off">
                    <input type="text" name="end_date" class="form-control float-right datepicker-new" placeholder="End Date" value="{{ $endDate }}" autocomplete="off">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
                <div class="card-tools">
                    <!-- <a href="{{ route(config('app.a_slug').'.batches.create', $program ? ['program_id' => $program->id] : null) }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a> -->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>@sortablelink('name', 'Name')</th>
                      <th>Program</th>
                      <th>Faculty</th>
                      <th>Mentor Coaches</th>
                      <th>Sessions</th>
                      <th>Participants</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($batches) > 0)
                    @foreach($batches as $batchKey => $batch)
                    <tr>
                      <td>{{ $prevRecords+$batchKey+1 }}</td>
                      <td>{{ $batch->name }}</td>
                      <td>{{ $batch->program->name }}</td>
                      <td>
                      @if(count($batch->faculties) > 0)
                      @foreach($batch->faculties as $facultyKey => $faculty){{ ($facultyKey > 0 ? ', ' : '').$faculty->first_name }}@endforeach
                      @endif
                      </td>
                      <td>
                      @if(count($batch->mentorCoaches) > 0)
                      @foreach($batch->mentorCoaches as $facultyKey => $mentorCoach){{ ($facultyKey > 0 ? ', ' : '').$mentorCoach->first_name }}@endforeach
                      @endif
                      </td>
                      <td><a href="{{ route(config('app.a_slug').'.batches.sessions', $batch->id) }}" class="btn btn-sm btn-primary">{{ $batch->sessions_count }}</a></td>
                      <td><a href="{{ route(config('app.a_slug').'.batches.participants', $batch->id) }}" class="btn btn-sm btn-primary">{{ $batch->users_count }}</a></td>
                      <td>
                          {{ Form::open(array('route' => [config('app.a_slug').'.batches.destroy', $batch->id], 'method' => 'delete')) }}
                            <a href="{{ route(config('app.a_slug').'.batches.edit', $batch->id) }}" class="btn btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <a href="{{ route(config('app.a_slug').'.batches.sessions', $batch->id) }}" class="btn btn-sm"><i class="fas fa-edit"></i> Sessions</a>
                            <a href="{{ route(config('app.a_slug').'.batches.resources', $batch->id) }}" class="btn btn-sm"><i class="fas fa-edit"></i> Participant Resources</a>
                            <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fas fa-trash"></i> Delete</button>
                          </form>
                      </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="8" class="text-center">No records found</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{ $batches->withQueryString()->links('vendor.pagination.bootstrap-4') }}
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection