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
                <form action="{{ route(config('app.a_slug').'.reports.list_of_participants')}}" method="get" style="display:inline;">
                  <div class="input-group input-group-sm" style="width: 150px; display: inline-flex;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $search }}">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
                <div class="card-tools">
                  <a href="{{ route(config('app.a_slug').'.reports.list_of_participants.export') }}" class="btn btn-secondary"><i class="fa fa-download"></i> Download</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>@sortablelink('user.first_name', 'Participant Name')</th>
                      <th>Program</th>
                      <th>@sortablelink('batch.name', 'Batch')</th>
                      <th>@sortablelink('user.phone', 'Mobile #')</th>
                      <th>Country</th>
                      <th>Location</th>
                      <th>Current Credentials</th>
                      <th>Role</th>
                      <th>Function</th>
                      <th>Current Org</th>
                      <th>Website</th>
                      <th>Social Media Links</th>
                      <th>Electives</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($pUsers) > 0)
                    @foreach($pUsers as $userKey => $pUser)
                    <tr>
                      <td>{{ $pUser->user->first_name.' '.$pUser->user->last_name }}</td>
                      <td>{{ $pUser->batch->program->name }}</td>
                      <td>{{ $pUser->batch->name }}</td>
                      <td>{{ $pUser->user->phone }}</td>
                      <td>{{ $pUser->user->country->name ?? '' }}</td>
                      <td>{{ $pUser->user->location->name ?? '' }}</td>
                      <td>{{ implode(', ', $pUser->user->currentCredentials()->pluck('current_credential_id')->toArray()) }}</td>
                      <td>{{ $pUser->user->currentRole->name ?? '' }}</td>
                      <td>{{ $pUser->user->currentFunction->name ?? '' }}</td>
                      <td>{{ $pUser->user->current_organisation_name }}</td>
                      <td>{{ $pUser->user->current_organisation_website }}</td>
                      <td>
                        <span class="badge badge-info">{{ $pUser->user->facebook_profile_url }}</span>
                        <span class="badge badge-info">{{ $pUser->user->linkedin_profile_url }}</span>
                        <span class="badge badge-info">{{ $pUser->user->instagram_profile_url }}</span>
                        <span class="badge badge-info">{{ $pUser->user->twitter_profile_url }}</span>
                      </td>
                      <td>
                        @php( $electiveBatchUsers = $pUser->user->electiveBatchUsers()->where('parent_batch_id', $pUser->batch->id)->get() )
                        @if(count($electiveBatchUsers))
                          @foreach($electiveBatchUsers as $electiveBatchUser)
                            <span class="badge badge-primary">{{ $electiveBatchUser->batch->program->name }}</span>
                          @endforeach
                        @else
                        -
                        @endif
                      </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="13" class="text-center">No records found</td>
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