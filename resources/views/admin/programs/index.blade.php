@extends('layouts.admin')

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
                <form action="{{ route(config('app.a_slug').'.programs.index')}}" method="get" style="display:inline;">
                  <div class="input-group input-group-sm" style="width: 50%; display: inline-flex;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $search }}">
                    {{ Form::select('type', ['program' => 'Program', 'elective' => 'Elective'], old('type', $type), ['class' => 'form-control', 'id' => 'type', 'placeholder' => 'Select Type']) }}
                    {{ Form::select('certification_level', $certificationLevels, old('certification_level', $certificationLevel), ['class' => 'form-control', 'id' => 'certification_level', 'placeholder' => 'Select Certification Level']) }}
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
                <div class="card-tools">
                    <a href="{{ route(config('app.a_slug').'.programs.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>@sortablelink('name', 'Name')</th>
                      <th>@sortablelink('type', 'Type')</th>
                      <th>Faculty</th>
                      <th>Mentor Coaches</th>
                      <th>Batches</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($programs) > 0)
                    @foreach($programs as $programKey => $program)
                    <tr>
                      <td>{{ $prevRecords+$programKey+1 }}</td>
                      <td>{{ $program->name }}</td>
                      <td>{{ ucfirst($program->type) }}</td>
                      <td>
                      @if(count($program->faculties) > 0)
                      @foreach($program->faculties as $facultyKey => $faculty){{ ($facultyKey > 0 ? ', ' : '').$faculty->first_name }}@endforeach
                      @endif
                      </td>
                      <td>
                      @if(count($program->mentorCoaches) > 0)
                      @foreach($program->mentorCoaches as $facultyKey => $mentorCoach){{ ($facultyKey > 0 ? ', ' : '').$mentorCoach->first_name }}@endforeach
                      @endif
                      </td>
                      <td><a href="{{ route(config('app.a_slug').'.batches.index', ['program_id' => $program->id]) }}" class="btn btn-sm btn-primary">{{ $program->batches_count }}</a></td>
                      <td>
                          {{ Form::open(array('route' => [config('app.a_slug').'.programs.destroy', $program->id], 'method' => 'delete')) }}
                            <a href="{{ route(config('app.a_slug').'.programs.edit', $program->id) }}" class="btn btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fas fa-trash"></i> Delete</button>
                            <a href="{{ route(config('app.a_slug').'.batches.create', ['program_id' => $program->id]) }}" class="btn btn-sm"><i class="fas fa-plus"></i> Create Batch</a>
                          </form>
                      </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="7" class="text-center">No records found</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{ $programs->withQueryString()->links('vendor.pagination.bootstrap-4') }}
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