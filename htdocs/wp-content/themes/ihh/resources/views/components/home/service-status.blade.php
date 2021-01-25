@php
  $queues = \App::service_status();
  if(isset($queues['timestamp'])){
    $timestamp = $queues['timestamp'];
    $updated = round((time() - $timestamp) / 60);
    if($updated < 2){
      $updated = 0;
    }
  } else {
    $updated = 0;
  }

@endphp

<section class="service-status-section">
  <div class="container">
    <h2>Service queue status</h2>

    @if(!$queues)
      <div class="service-status-list">
        <span>Service statuses not available</span>
      </div>
    @else
    <ul class="service-status-list">
      @if($queues)
        @foreach($queues as $queue)
          @if(is_object($queue) )
          <li class="service-status-item">
            <div class="service-status-wrap">
              <div class="service-title">
                <h3>{{$queue->serviceName}}</h3>
              </div>
              <div class="service-status-data">
                <div>
                  <div class="label">People in queue</div>
                  <span class="big">{{$queue->customersWaitingInDefaultQueue}}</span>
                </div>
                <div>
                  <div class="label">Estimated waiting time</div>
                  @if($queue->waitingTimeInDefaultQueue == 0)
                      <span class="big">0</span> <span class="medium">minutes</span>
                  @else
                    <span class="big">{{ round($queue->waitingTimeInDefaultQueue / 60) }}</span> <span class="medium">minutes</span>
                  @endif
                </div>
              </div>
              <div class="service-status-misc">
                <p>
                @if($updated === 0)
                  Updated 1 minute ago.
                @else
                  Updated {{ $updated }} minutes ago.
                @endif
                </p>
              </div>
            </div>
          </li>
          @endif
        @endforeach
      @endif
    </ul>
      @if(have_rows('service_status_notice_box'))
        @while(have_rows('service_status_notice_box')) @php the_row() @endphp
        <div class="service-status-section__notice">
          <div class="icon">
            <span class="ihh-visually-hidden">Important notice</span>
          </div>
          <div class="text">
            {{ the_sub_field('text')}}
          </div>
          <div class="button">
            <a href="{{ the_sub_field('button_link')}}" @if(get_sub_field('open_in_new_tab')) target="_blank" @endif>
              {{ the_sub_field('button_text')}}
            </a>
          </div>
        </div>
        @endwhile
      @endif
    @endif
  </div>
</section>
