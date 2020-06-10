<article @php post_class('post-grid-item') @endphp>
  <header>
    <a href="{{the_permalink()}}">
      @if(has_post_thumbnail())
        <img src="{{get_the_post_thumbnail_url(get_the_ID(), 'lift')}}" alt="{{the_title()}}">
      @else
        <img src="{{ \App\get_default_image('lift') }}" alt="">
      @endif
    </a>
  </header>
  <div class="post-content">
    <h2><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h2>

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

    <a href="{{the_permalink()}}" class="read-more">{{pll__('Read more')}}</a>
  </div>
</article>
