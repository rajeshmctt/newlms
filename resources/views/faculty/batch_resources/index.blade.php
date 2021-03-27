@extends('layouts.faculty')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h3>{{ $title }}</h3>
                
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
        
            <div class="card mt-4 border-0">
              <div class="card-body p-0">

              <div class="table-responsive border-0">


              <table class="table ucp-table">
                    <thead class="thead-s">
                    <tr>
                      <th>#</th>
                      <th>Resource</th>
                      <th>Program</th>
                      <th>Batch</th>
                      <th>View</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($resources) > 0)
                  @foreach($resources as $assignmentKey => $resource)
                    <tr>
                        <td class="text-center">{{ $prevRecords+$assignmentKey+1 }}</td>
                      <td>{{ $resource->name }}</td>
                      <td>{{ $batch->program->name }}</td>
                      <td>{{ $batch->name }}</td>
                      <td><a href="{{ $resource->type == 'link' ? $resource->link : asset('storage/resources/'.$resource->file) }}" target="_blank" class=" text-success">View <i class="fas fa-eye text-success"></i></a></td>
                    </tr>
                  @endforeach
                  @else
                    <tr>
                      <td colspan="8" class="text-center">No assignments found</td>
                    </tr>
                  @endif
                  </tbody>
                </table>

                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <div class="mt-5">
                  {{ $resources->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                </div>
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