@if(have_rows('service_status'))
  @while(have_rows('service_status')) @php the_row() @endphp

@php
// Hide element
if(get_sub_field('hide_service_status_element')){
  return;
}
@endphp

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

@php
$scheme = get_sub_field('color_scheme');
@endphp

<section class="service-status-section">
  <div class="container">
    <h2>@php the_sub_field('service_status_title') @endphp</h2>

    @if(!$queues)
      <div class="service-status-list">
        <span>Service statuses not available</span>
      </div>
    @else
    <ul class="service-status-list">
      @if($queues)
        @foreach($queues as $key => $queue)
          @php
          $bc_color = get_sub_field('primary_color');
          $parity = $key+1;
          if($scheme == 'multicolor' && ($parity % 2 == 0)){
            $bc_color = get_sub_field('second_color');
          }
          @endphp
          @if(is_object($queue) )
          <li class="service-status-item" style="background-color: {{ $bc_color }}">
            <div class="service-status-wrap">
              <div class="service-title">
                <h3>{{$queue->serviceName}}</h3>
              </div>
              <div class="service-status-data">
                <div>
                  <div class="label">@php the_sub_field('queue_length_title') @endphp</div>
                  <span class="big">{{$queue->customersWaitingInDefaultQueue}}</span>
                </div>
                <div>
                  <div class="label">@php the_sub_field('queue_time_title') @endphp</div>
                  @if($queue->waitingTimeInDefaultQueue == 0)
                      <span class="big">0</span> <span class="medium">minutes</span>
                  @else
                    <span class="big">{{ round($queue->waitingTimeInDefaultQueue / 60) }}</span> <span class="medium">minutes</span>
                  @endif
                </div>
              </div>
            </div>
          </li>
          @endif
        @endforeach
      @endif
    </ul>

    <div style="text-align: right">
      <p>
        @if($updated === 0)
          Service queue status updated 1 minute ago.
        @else
          Service queue status updated {{ $updated }} minutes ago.
        @endif
      </p>
    </div>


      @if(have_rows('service_status_notice_box'))
        @while(have_rows('service_status_notice_box')) @php the_row() @endphp
        <div class="service-status-section__notice" style="background-color: @php echo the_sub_field('background_color') @endphp">
          <div class="icon">
            <span class="ihh-visually-hidden">Important notice</span>
          </div>
          <div class="text">
            {{ the_sub_field('text')}}
          </div>
          <div class="button" @if(get_sub_field('button_backround_color')) style="background-color: {{the_sub_field('button_backround_color')}}" @endif>
            <a href="{{ the_sub_field('button_link')}}" @if(get_sub_field('open_in_new_tab')) target="_blank" @endif  @if(get_sub_field('text_color')) style="color: {{the_sub_field('text_color')}} !important" @endif>
              {{ the_sub_field('button_text')}}
            </a>
          </div>
        </div>
        @endwhile
      @endif
    @endif
  </div>
</section>
  @endwhile
@endif
