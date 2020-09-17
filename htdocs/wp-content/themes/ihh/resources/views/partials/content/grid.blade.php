<div @php post_class('post-grid-item') @endphp>
  <a href="{{the_permalink()}}">
    <header>
        @if(has_post_thumbnail())
          <img src="{{get_the_post_thumbnail_url(get_the_ID(), 'lift')}}" alt="{{the_title()}}">
        @else
          <img role="presentation" src="{{ \App\get_default_image('lift') }}" alt="">
        @endif
    </header>
    <div class="post-content">
      <h2>{!! get_the_title() !!}</h2>
      @php
        $readmore = get_post_type() == 'event' ? 'View event' : 'Read news content';
      @endphp
      @if('event' === get_post_type())
        <div class="post-content-event-meta">
          @if($date = get_field('start_time'))
            <p class="date"><img src="@asset('images/icons/time.png')" alt=""> {{\App\format_event_date()}}</p>
          @endif
          @if($location = get_field('location'))
            <p class="location"><img src="@asset('images/icons/location.png')" alt=""> {{$location}}</p>
          @endif
        </div>
      @endif
      <span class="read-more">{{pll__($readmore)}}</span>
    </div>
  </a>
</div>
