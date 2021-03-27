@extends('layouts.participant')

@section('script')
<script>
  $('#photo').on('change',function(){
      var fileName = $(this).val();
      $(this).next('.custom-file-label').html(fileName);
  })
</script>
@endsection

@section('content')

<div class="row justify-content-center">
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
  </div>
</div>
<!-- /.row -->


<div class="row">
  <div class="col-lg-12">
      <h2 class="st_title"><i class='uil uil-cog'></i> Settings</h2>
      
      @include(Config::get('app.p_slug').'.account_menu')
      
      {{ Form::open(array('route' => [Config::get('app.p_slug').'.account.update.photo'], 'method' => 'put', 'files' => true)) }}

      <div class="basic_ptitle">
          <h3>Change Your Photo</h3>
      </div>
      <div class="basic_form">
        
        <div class="row">
          <div class="col-lg-8">
              <div class="mt-3 d-inline-block">						
                  <div class="img148 upload-img text-left">
                  <img src="{{ asset('storage/users/'.$user->photo) }}" alt="">										
                  </div>									
              </div>
              
              <div class="input-group">
                <div class="custom-file">
                  <input name="photo" type="file" class="custom-file-input1" id="photo" accept="image/*">
                </div>
              </div>
              <div class="help-block">(File Formats: jpg, jpeg, png. upto 3MB file size)</div>
              <br>
              <div class="help-block" style="font-size:14px;">Kindly upload a high-resolution formal photo. It shall be used on the e-Certificates issued by CTT.</div>

              
              @error('photo')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>

      </div>
      
      <button class="save_btn" type="submit">Upload</button>

    </form>
  </div>	
</div>

@endsection