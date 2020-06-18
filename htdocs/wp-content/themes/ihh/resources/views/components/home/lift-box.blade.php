@if(have_rows('service_advisor'))
  @while(have_rows('service_advisor')) @php the_row() @endphp
  @if(!get_sub_field('hide_service_advisor'))
    <section class="lift-box container-wide" style="background-image: url({{ the_sub_field('background') }})">
      <div class="container">
        <div class="content"
             @if(get_sub_field('color')) style="background-color: {!! get_sub_field('color') !!}" @endif>
          <h2>{{ the_sub_field('title') }}</h2>
          <p>{{ the_sub_field('body') }}</p>
          <a href="{{ the_sub_field('link') }}" target="_blank" class="cta">{{ the_sub_field('link_text') }}</a>
        </div>
      </div>
    </section>
  @endif
  @endwhile
@endif
