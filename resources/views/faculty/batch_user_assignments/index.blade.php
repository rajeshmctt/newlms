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
                      <th>Assignment</th>
                      <th>Program</th>
                      <th>Batch</th>
                      <th>Due Date</th>
                      <th>File(s)</th>
                      <th>Status</th>
                      <th>Download</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($batch->assignments) > 0)
                  @foreach($batch->assignments as $assignmentKey => $assignment)
                    <tr>
                      <td>{{ $assignmentKey+1 }}</td>
                      <td>{{ $assignment->name }}</td>
                      <td>{{ $batch->program->name }}</td>
                      <td>{{ $batch->name }}</td>
                      <td>{{ $assignment->due_date->format('M d, Y') }}</td>
                      <td>
                        @if(count($assignment->assignmentDocuments) > 0)
                        @foreach($assignment->assignmentDocuments as $assignmentDocument)
                          <a href="{{ asset('storage/assignments/'.$assignmentDocument->document) }}" target="_blank" class="badge badge-success">{{ $assignmentDocument->name }}</a>
                        @endforeach
                        @endif
                      </td>
                      <td>{{ $assignment->userAssignment ? ucwords($assignment->userAssignment->status) : 'Pending' }}</td>
                      <td>
                        @if($assignment->userAssignment)
                        @if($assignment->userAssignment->document)
                        <a href="{{ asset('storage/users/assignments/'.$assignment->userAssignment->document) }}" class="ml-3" target="_blank"><i class="fa fa-lg fa-download text-success"></i></a>
                        @endif
                        @endif
                      </td>
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