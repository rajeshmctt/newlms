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
                <form action="{{ route(config('app.a_slug').'.sessions.index')}}" method="get" style="display:inline;">
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
                    <a href="{{ route(config('app.a_slug').'.sessions.create', ['batch_id' => $batch->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Session No.</th>
                      <th>Type</th>
                      <th>Description</th>
                      <th>Date<br><span class="text-secondary">dd/mm/yyyy</span></th>
                      <th>Time</th>
                      <th>Status</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($sessions) > 0)
                    @foreach($sessions as $userKey => $session)
                    <tr>
                      <td>{{ $prevRecords+$userKey+1 }}</td>
                      <td>{{ $session->session_no }}</td>
                      <td>{{ ucfirst($session->type) }}</td>
                      <td>{{ $session->description }}</td>
                      <td>{{ $session->date ? $session->date->format('d/m/Y') : '-' }}</td>
                      <td>{{ $session->start_time->format('h:i A').' - '.$session->end_time->format('h:i A') }}</td>
                      <td><span class="badge bg-{{ $session->status == 'active' ? 'success' : 'danger' }}">{{ $session->status }}</span></td>
                      <td>
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
                {{ $sessions->withQueryString()->links('vendor.pagination.bootstrap-4') }}
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