@extends('store.layouts.master')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-6">
          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  View Details
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Name</dt>
                  <dd class="col-sm-8">{{ $itemCategory->name }}</dd>
                  <dt class="col-sm-4">Image</dt>
                  <dd class="col-sm-8"><img src="{{ asset('storage/item-categories/'.$itemCategory->image) }}" width="200" /></dd>
                  <dt class="col-sm-4">Created At</dt>
                  <dd class="col-sm-8">{{ $itemCategory->created_at->format('d/m/Y h:i A') }}</dd>
                  <dt class="col-sm-4">Modified At</dt>
                  <dd class="col-sm-8">{{ $itemCategory->updated_at ? $itemCategory->updated_at->format('d/m/Y h:i A') : '-' }}</dd>
                  <dt class="col-sm-4">Status</dt>
                  <dd class="col-sm-8">{{ $itemCategory->status }}</dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection