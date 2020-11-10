@php
  $services = \App::services();

  $background_img = get_field('image') ? get_field('image') : false
@endphp

<section class="services-list" id="faqs">
    @while($services->have_posts()) @php $services->the_post() @endphp
    <div class="question" id="service_{{the_ID()}}">
      <button class="question-header collapsed"
              data-toggle="collapse"
              data-target="#service_content_{{the_ID()}}"
              aria-expanded="false"
              aria-controls="service_content_{{the_ID()}}"
              aria-owns="service_content_{{the_ID()}}">
        <span>@php the_title(); @endphp</span>
      </button>
      <div id="service_content_{{the_ID()}}"
           class="collapse service-content"
           data-parent="#faqs">
        @php $background_img = get_field('image');@endphp
        <div class="services-list-content" @if($background_img) style="background-image: url({{$background_img}})" @endif>
          <div class="services-list-body">
            <div class="services-list-body-text" @if(get_field('color')) style="background-color: {!! get_field('color') !!}" @endif>
              <h2>{{ the_title() }}</h2>
              {{ the_content() }}
              @php
                $parserUrl = parse_url(get_field('link'));
              @endphp

              @if(get_field('link'))
                <a href="{{ the_field('link') }}" target="_blank" class="read-more">{!! pll__('Read more from ') !!} @php echo $parserUrl['host']; @endphp</a>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>

    @endwhile
    @php wp_reset_postdata() @endphp
</section>
