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
        
              <div class="row">
                <div class="col-12">
                  <form action="{{ route(config('app.f_slug').'.faculty-resources.index')}}" method="get" style="display:inline;">
                  <ul class="more_options_tt mt-5">
                    <li class=""><a href="{{ route(config('app.f_slug').'.faculty-resources.index')}}"><button type="button" class="more_items_14 {{ $status == 'active' ? 'active' : '' }}"><i class="fa fa-hourglass-half"></i> Active ({{ $activeBatchesCount }})</button></a></li>
                    <li class=""><a href="{{ route(config('app.f_slug').'.faculty-resources.index', ['status' => 'completed'])}}"><button type="button" class="more_items_14 {{ $status == 'completed' ? 'active' : '' }}"><i class="fa fa-check-circle"></i> Completed ({{ $completedBatchesCount }})</button></a></li>
                    
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
              </div>

              <div class="row">
                <div class="col-12">

                  <div class="card mt-4 border-0">
                    <div class="card-body p-0">

                    <div class="table-responsive border-0">
                        <table class="table ucp-table">
                          <thead class="thead-s">
                            <tr>
                              <th class="text-center" scope="col">S.No.</th>
                              <th>Batch Name</th>
                              <th>Program Name</th>
                              <th class="text-center" scope="col">Start Date<br><span class="text-secondary">dd/mm/yyyy</span></th>
                              <th class="text-center" scope="col">Resources</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if(count($batches) > 0)
                            @foreach($batches as $batchKey => $batch)
                            <tr>
                              <td class="text-center">{{ $prevRecords+$batchKey+1 }}</td>
                              <td>{{ $batch->name }}</td>
                              <td>{{ $batch->program->name }}</td>
                              <td class="text-center">{{ $batch->start_date->format('d/m/Y') }}</td>
                              <td class="text-center"><a href="{{ route(config('app.f_slug').'.faculty-resources.show', $batch->id) }}" class="btn btn-primary bg-theme2 border-0">{{ $batch->program->resources_count }}</a></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                              <td colspan="5" class="text-center">No records found</td>
                            </tr>
                            @endif
                          </tbody>
                        </table>
                      </div>
                      
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                      <div class="mt-5">
                        {{ $batches->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
              </div>
            </div>
            
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection