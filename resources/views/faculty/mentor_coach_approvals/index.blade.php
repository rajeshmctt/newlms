@extends('layouts.faculty')

@section('script')
<script type="text/javascript">
$(function(){
  $('.select_all').click(function(){
    if($(this).prop("checked") == true){
      $('.pending_mcs').find('.approve_action').prop('checked', true);
    }
    else if($(this).prop("checked") == false){
      $('.pending_mcs').find('.approve_action').prop('checked', false);
    }
  });
  $('.approve_all').click(function(){
    var approveIDs = $(".pending_mcs input.approve_action:checked").map(function(){
      return $(this).val();
    }).get();

    if(approveIDs.length > 0){
      if(confirm('Are you sure do you want to approve all selected?')){
        $.ajax({
          type: "POST",
          url: "{{ route(config('app.f_slug').'.mentor-coach-approvals.store') }}",
          data: {"_token": "{{ csrf_token() }}", "approve_ids": approveIDs},
          dataType: "json",
          success: function(response){
            if(response.status == true){
              alert(response.message);
              location.href = "{{ route(config('app.f_slug').'.mentor-coach-approvals.index') }}";
            } else {
              alert(response.message);
              location.reload();
            }
          },
        });
      }
    } else {
      alert('Please select atleast one item.');
    }
  });
});
</script>
@endsection

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
        
            </div>
            <div class="col-md-12">
              <form action="{{ route(config('app.f_slug').'.mentor-coach-approvals.index')}}" method="get" style="display:inline;">
              <ul class="more_options_tt mt-5">
                <li class=""><a href="{{ route(config('app.f_slug').'.mentor-coach-approvals.index')}}"><button type="button" class="more_items_14 {{ $status == 'pending' ? 'active' : '' }}"><i class="fa fa-hourglass-half"></i> Pending ({{ $pendingMentorCoachSessionsCount }})</button></a></li>
                <li class=""><a href="{{ route(config('app.f_slug').'.mentor-coach-approvals.index', ['status' => 'active'])}}"><button type="button" class="more_items_14 {{ $status == 'active' ? 'active' : '' }}"><i class="fa fa-check-circle"></i> Completed ({{ $completedMentorCoachSessionsCount }})</button></a></li>
                
                <li class="float-right"><button type="submit" class="more_items_14"><i class="fas fa-search"></i></button></li>
                <li class="float-right">
                  <div class="explore_search">
                    <div class="ui search focus">
                      <div class="ui left icon input swdh11 swdh15">
                      <input class="prompt srch_explore" type="text" name="search" placeholder="Search" value="{{ $search }}">
                      <input type="hidden" name="status" value="{{ $status }}">
                        <i class="uil uil-search-alt icon icon8"></i>
                      </div>
                    </div>
                  </div>
                </li>
                
              </ul>
              </form>
            </div>

            @if($status == 'pending')
        
            <div class="col-md-12">
              <ul class="more_options_tt mt-3">
                <li class="float-right"><button type="button" class="more_items_14 approve_all active">Approve</button></li>              
                <li class="float-right mr-3" style="font-size:16px;"><label style="line-height:40px;"><input type="checkbox" class="select_all" /> Select All</label></li>              
              </ul>
            </div>

            @endif

            <div class="col-md-12 mt-3">
              <div class="card border-0">
                <div class="card-body p-0">

                <div class="table-responsive border-0">
                      <table class="table ucp-table pending_mcs">
                        <thead class="thead-s">
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">S.No.</th>
                          <th>Name</th>
                          <th>Session No.</th>
                          <th>Feedback</th>
                          <th class="text-center">Date<br><span class="text-secondary">dd/mm/yyyy</span></th>
                          <th class="text-center" scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($mentorCoachSessions) > 0)
                        @foreach($mentorCoachSessions as $mentorCoachSessionKey => $mentorCoachSession)
                        <tr>
                          <td class="text-center">{{ $prevRecords+$mentorCoachSessionKey+1 }}</td>
                          <td>{{ $mentorCoachSession->user->first_name.' '.$mentorCoachSession->user->last_name }}</td>
                          <td>Session {{ $mentorCoachSession->session_no }}</td>
                          <td>{{ $mentorCoachSession->feedback }}</td>
                          <td class="text-center">{{ $mentorCoachSession->created_at->format('d/m/Y H:i A') }}</td>
                          <td class="text-center">
                            @if($mentorCoachSession->status == 'pending')
                              <input type="checkbox" class="approve_action" name="approve[]" value="{{ $mentorCoachSession->id }}" />
                            @endif
                            <a href=""><i class="fa fa-eye"></i></a>
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
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <div class="mt-5">
                    {{ $mentorCoachSessions->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection