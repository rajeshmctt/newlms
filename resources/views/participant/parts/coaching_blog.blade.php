<style type="text/css">
.crse-cate{
  height: 100px;
}
</style>
        <div class="col-lg-3 col-md-3 mb-3">
            <div class="fcrse_1">
            <a href="{!! $blogPost['link'] !!}" target="_blank" class="fcrse_img">
                <img src="{!! $blogPost['image'] ?? asset('img/default-blog.png') !!}" alt="{!! $blogPost['title'] !!}" style="height:200px;" />
                <div class="course-overlay">
                    @if($blogPost['new'])
                    <div class="badge_seller">New</div>
                    @endif
                </div>
            </a>
            <div class="fcrse_content">
                <div class="vdtodt">
                <span class="vdt14">
                    <i class="fa fa-user"></i> {!! $blogPost['author'] !!}</span>
                    <i class="fa fa-clock"></i> {!! $blogPost['date'] !!}</span>
                </div>
                <a href="#" class="crse14s">{!! $blogPost['title'] !!}</a>
                <a href="#" class="crse-cate">{!! $blogPost['excerpt'] !!}</a>
            </div>
            </div>
        </div>