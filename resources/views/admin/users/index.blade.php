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
                <form action="{{ route(config('app.a_slug').'.participants.index')}}" method="get" style="display:inline;">
                  @if($program)
                  <input type="hidden" name="program_id" value="{{ $program->id }}" /> 
                  @endif
                  @if($batch)
                  <input type="hidden" name="batch_id" value="{{ $batch->id }}" /> 
                  @endif
                  <div class="input-group input-group-sm" style="width: 150px; display: inline-flex;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $search }}">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
                <div class="card-tools">
                    <a href="{{ route(config('app.a_slug').'.participants.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>@sortablelink('first_name', 'Name')</th>
                      <th>@sortablelink('email', 'Email')</th>
                      <th>@sortablelink('phone', 'Contact No')</th>
                      <th>@sortablelink('status', 'Status')</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($users) > 0)
                    @foreach($users as $userKey => $user)
                    <tr>
                      <td>{{ $prevRecords+$userKey+1 }}</td>
                      <td>{{ $user->first_name.' '.$user->last_name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->phone }}</td>
                      <td><span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }}">{{ $user->status }}</span></td>
                      <td>
                          {{ Form::open(array('route' => [config('app.a_slug').'.participants.destroy', $user->id], 'method' => 'delete')) }}
                            <a href="{{ route(config('app.a_slug').'.participants.edit', $user->id) }}" class="btn btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fas fa-trash"></i> Delete</button>
                          </form>
                      </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="6" class="text-center">No records found</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{ $users->withQueryString()->links('vendor.pagination.bootstrap-4') }}
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