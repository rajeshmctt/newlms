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
                <form action="{{ route(config('app.a_slug').'.certification-levels.index')}}" method="get" style="display:inline;">
                  <div class="input-group input-group-sm" style="width: 150px; display: inline-flex;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $search }}">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
                <div class="card-tools">
                    <a href="{{ route(config('app.a_slug').'.certification-levels.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($certificationLevels) > 0)
                    @foreach($certificationLevels as $certificationLevelKey => $certificationLevel)
                    <tr>
                      <td>{{ $prevRecords+$certificationLevelKey+1 }}</td>
                      <td>{{ $certificationLevel->name }}</td>
                      <td><span class="badge bg-{{ $certificationLevel->status == 'active' ? 'success' : 'danger' }}">{{ $certificationLevel->status }}</span></td>
                      <td>
                          {{ Form::open(array('route' => [config('app.a_slug').'.certification-levels.destroy', $certificationLevel->id], 'method' => 'delete')) }}
                            <a href="{{ route(config('app.a_slug').'.certification-levels.edit', $certificationLevel->id) }}" class="btn btn-sm"><i class="fas fa-edit"></i></a>
                            <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fas fa-trash"></i></button>
                          </form>
                      </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="4" class="text-center">No records found</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{ $certificationLevels->withQueryString()->links('vendor.pagination.bootstrap-4') }}
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