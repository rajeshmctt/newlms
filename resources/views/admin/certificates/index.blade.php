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
                <form action="{{ route(config('app.a_slug').'.certificates.index')}}" method="get" style="display:inline;">
                  <div class="input-group input-group-sm" style="width: 150px; display: inline-flex;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $search }}">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Program</th>
                      <th>Batch</th>
                      <th>Assignment Completion Status</th>
                      <th>View / Update / Remove Certificate</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($bUsers) > 0)
                    @foreach($bUsers as $userKey => $bUser)
                    <tr>
                      <td>{{ $prevRecords+$userKey+1 }}</td>
                      <td>{{ $bUser->user->first_name.' '.$bUser->user->last_name }}</td>
                      <td>{{ $bUser->batch->program->name }}</td>
                      <td>{{ $bUser->batch->name }}</td>
                      <td class="text-center">
                        <b>{{ $bUser->user->userAssignments()->whereHas('assignment', function($q) use($bUser){ $q->where('batch_id', $bUser->batch->id); })->count() }}/{{ $bUser->batch->assignments_count }}</b>
                      </td>
                      <td>
                        {{ Form::open(array('route' => [config('app.a_slug').'.certificates.destroy', $bUser->id], 'method' => 'delete')) }}

                        <a href="#" data-toggle="modal" data-target="#uploadModal-{{ $userKey }}" class="ml-3"><i class="fa fa-lg fa-upload text-success"></i></a>
                        @if($bUser->certificate)
                          <a href="{{ asset('storage/certificates/'.$bUser->certificate) }}" class="ml-3" target="_blank"><i class="fa fa-lg fa-eye text-secondary"></i></a>
                          <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-lg fa-times text-danger"></i></button>
                        @endif
                        </form>
                      </td>
                      <td><span class="badge bg-{{ $bUser->status == 'completed' ? 'success' : 'secondary' }}">{{ $bUser->status == 'completed' ? 'Completed' : 'Enrolled' }}</span></td>
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
                {{ $bUsers->withQueryString()->links('vendor.pagination.bootstrap-4') }}
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


    @if(count($bUsers) > 0)
    @foreach($bUsers as $userKey => $bUser)

    {{ Form::open(array('route' => [Config::get('app.a_slug').'.certificates.update', [$bUser->id]], 'method' => 'put', 'files' => true)) }}

    <div class="modal fade" id="uploadModal-{{ $userKey }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h3 class="modal-title" id="uploadModalLabel">Upload Certificate</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td><b>Participant:</b><br>{{ $bUser->user->first_name.' '.$bUser->user->last_name }}</td>
                  <td><b>Program:</b><br>{{ $bUser->batch->program->name }}</td>
                  <td><b>Batch:</b><br>{{ $bUser->batch->name }}</td>
                </tr>
                <tr>
                  <td colspan="2">
                    <b>Upload Certificate:</b><br>
                    <input type="file" name="certificate" />
                  </td>
                  <td>
                    <b>Completion Status:</b><br>
                    {{ Form::select('status', ['active' => 'Enrolled', 'completed' => 'Completed'], old('status', $bUser->status), ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status']) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer bg-secondary">
            <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
            <button type="submit" class="btn_adcart">Update</button>
          </div>
        </div>
      </div>
    </div>

    {{ Form::close() }}
    @endforeach
    @endif

@endsection