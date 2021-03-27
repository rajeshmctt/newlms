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
                <form action="{{ route(config('app.a_slug').'.feedbacks.index')}}" method="get" style="display:inline;">
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
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Feedback</th>
                      <th>Emoticon</th>
                      <th>Program</th>
                      <th>Participant</th>
                      <th>&nbsp;</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($programFeedbacks) > 0)
                    @foreach($programFeedbacks as $programFeedbackKey => $programFeedback)
                    <tr>
                      <td>{{ $prevRecords+$programFeedbackKey+1 }}</td>
                      <td>{{ $programFeedback->feedback }}</td>
                      <td>
                        @if($programFeedback->emoticon)
                        <img src="{{ asset('img/feedback-icons/'.$programFeedback->emoticon.'.png') }}" title="{{ $programFeedback->emoticon }}" style="height:25px;" />
                        @endif
                      </td>
                      <td>{{ $programFeedback->program->name }}</td>
                      <td>{{ $programFeedback->user->first_name.' '.$programFeedback->user->last_name }}</td>
                      <td><span class="badge bg-{{ $programFeedback->status == 'pending' ? 'warning' : ($programFeedback->status == 'active' ? 'success' : 'danger') }}">{{ ucfirst($programFeedback->status) }}</span></td>
                      <td>
                        @if($programFeedback->status == 'pending')
                          {{ Form::open(array('route' => [config('app.a_slug').'.feedbacks.update', $programFeedback->id], 'method' => 'put')) }}
                            <input type="hidden" name="status" value="active" />
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to Approve?');"><i class="fas fa-check-circle"></i> Approve</button>
                          </form>
                        @endif
                      </td>
                      <td>
                        @if($programFeedback->status == 'pending')
                          {{ Form::open(array('route' => [config('app.a_slug').'.feedbacks.update', $programFeedback->id], 'method' => 'put')) }}
                            <input type="hidden" name="status" value="inactive" />
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to Reject?');"><i class="fas fa-ban"></i> Reject</button>
                          </form>
                        @endif
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
                {{ $programFeedbacks->withQueryString()->links('vendor.pagination.bootstrap-4') }}
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