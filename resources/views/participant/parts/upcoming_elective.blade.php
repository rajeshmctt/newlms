
            <div class="item">
                <div class="fcrse_1">
                <a href="{{ route(config('app.p_slug').'.electives.batches.show', [$upcomingElectiveBatch->elective->id, $upcomingElectiveBatch->id]) }}" class="fcrse_img">
                    <img src="{{ asset('storage/electives/'.$upcomingElectiveBatch->elective->image) }}" alt="" style="height:200px;" />
                    <div class="course-overlay">
                    @if($upcomingElectiveBatch->elective->label)
                    <div class="badge_seller">{{ $upcomingElectiveBatch->elective->label->name }}</div>
                    @endif
                    <div class="crse_timer" style="background: #1d3557;">
                        On  {{ $upcomingElectiveBatch->date->format('d M, Y') }}, @if($upcomingElectiveBatch->start_time && $upcomingElectiveBatch->end_time) {{ $upcomingElectiveBatch->start_time.' to '.$upcomingElectiveBatch->end_time.' IST' }} @endif
                    </div>
                    </div>
                </a>
                <div class="fcrse_content">
                    <a href="{{ route(config('app.p_slug').'.electives.batches.show', [$upcomingElectiveBatch->elective->id, $upcomingElectiveBatch->id]) }}" class="crsedt145 mt-15"
                    >{{ $upcomingElectiveBatch->elective->name }}
                    </a>
                    <p class="news_des45">
                        {!! Str::limit($upcomingElectiveBatch->elective->description, 150) !!}
                    </p>
                    <div class="auth1lnkprce">
                    <a href="{{ route(config('app.p_slug').'.electives.batches.show', [$upcomingElectiveBatch->elective->id, $upcomingElectiveBatch->id]) }}" class="cr1fot50">View Details</a>
                    </div>
                </div>
                </div>
            </div>