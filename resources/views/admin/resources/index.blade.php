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
                <form action="{{ route(config('app.a_slug').'.resources.index')}}" method="get" style="display:inline;">
                  <div class="input-group input-group-sm" style="width: 150px; display: inline-flex;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $search }}">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
                <div class="card-tools">
                    <a href="{{ route(config('app.a_slug').'.resources.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>@sortablelink('name', 'Name')</th>
                      <th>@sortablelink('description', 'Description')</th>
                      <th>@sortablelink('format', 'Format')</th>
                      <th>Resource</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($resources) > 0)
                    @foreach($resources as $resourceKey => $resource)
                    <tr>
                      <td>{{ $prevRecords+$resourceKey+1 }}</td>
                      <td>{{ $resource->name }}</td>
                      <td>{!! Str::limit($resource->description, 80) !!}</td>
                      <td><span class="badge badge-primary">{{ $resource->format }}</span></td>
                      <td>
                        @if($resource->type == 'file')
                        <a href="{{ asset('storage/resources/'.$resource->file) }}" target="_blank">{{ $resource->file_name }} <i class="fa fa-xs fa-external-link-alt text-secondary"></i></a>
                        @elseif($resource->type == 'link')
                        <a href="{{ route(config('app.a_slug').'.resources.link', $resource->id) }}" target="_blank">Link <i class="fa fa-xs fa-external-link-alt text-secondary"></i></a>
                        @endif
                      </td>
                      <td>
                          {{ Form::open(array('route' => [config('app.a_slug').'.resources.destroy', $resource->id], 'method' => 'delete')) }}
                            <a href="{{ route(config('app.a_slug').'.resources.edit', $resource->id) }}" class="btn btn-sm"><i class="fas fa-edit"></i> Edit</a>
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
                {{ $resources->withQueryString()->links('vendor.pagination.bootstrap-4') }}
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