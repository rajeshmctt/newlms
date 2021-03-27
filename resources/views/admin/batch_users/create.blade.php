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
              <div class="card-body p-0">

                <div class="row">
                  <div class="col-12 text-center p-5">
                    <form action="{{ route(config('app.a_slug').'.batches.participants.add', $batch->id)}}" method="get" style="display:inline;">
                      <div class="input-group" style="width: 250px; display: inline-flex;">
                        <input type="text" name="search" class="form-control form-control-lg float-right" placeholder="Search Participant" value="{{ $search }}">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Contact No</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($pUsers) > 0)
                    @foreach($pUsers as $userKey => $pUser)
                    <tr>
                      <td>{{ $prevRecords+$userKey+1 }}</td>
                      <td>{{ $pUser->first_name.' '.$pUser->last_name }}</td>
                      <td>{{ $pUser->email }}</td>
                      <td>{{ $pUser->phone }}</td>
                      <td>
                          {{ Form::open(array('route' => [config('app.a_slug').'.batches.participants.store', [$batch->id, $pUser->id]], 'method' => 'post')) }}
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to add this Participant to Batch?');"><i class="fas fa-plus"></i> Add to Batch</button>
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
                {{ $pUsers->withQueryString()->links('vendor.pagination.bootstrap-4') }}
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