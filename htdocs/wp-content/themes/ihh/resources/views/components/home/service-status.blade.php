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
    @endif
  </div>
</section>
