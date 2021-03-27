<style>
  body {
    margin-bottom: 70px; /* Margin bottom by footer height */
  }
  .footer {
     /* position: fixed; */
     bottom: 0;
     z-index: 999;
     margin-top:70px;
  }
</style>
<footer class="footer mt-40">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="footer_bottm">
          <div class="row">
            <div class="col-md-6">
              <ul class="fotb_left">
                <li>
                  <a href="{{ route('dashboard') }}">
                    <div class="footer_logo">
                      <img src="{{ asset('assets/images/footer-logo-icon.png') }}" alt="" />
                    </div>
                  </a>
                </li>
                <li>
                  <p>
                    © 2020 <strong>{{ config('app.name') }}</strong>. All
                    Rights Reserved.
                  </p>
                </li>
              </ul>
            </div>
            <div class="col-md-6">
              <div class="edu_social_links">
                <a href="https://www.linkedin.com/company/coach-to-transformation/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://www.facebook.com/Coach2Transform/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/_CTT_" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/coach.to.transformation/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/c/Coach2transform/featured" target="_blank"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>