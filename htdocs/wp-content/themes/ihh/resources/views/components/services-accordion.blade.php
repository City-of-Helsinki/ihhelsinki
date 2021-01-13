@php
  $services = \App::services();

  $background_img = get_field('image') ? get_field('image') : false;
@endphp

<section class="services-list" id="faqs">
    @while($services->have_posts()) @php $services->the_post();
      $logoUrl = '';
      $logoAlt = '';
      if($logoArray = get_field('logo', get_the_ID())){
        $logoUrl = $logoArray['url'];
        $logoAlt = $logoArray['alt'];
      }
    @endphp
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
                $service_provider = get_field('service_provider_logo');
              @endphp
              @if($logoArray)
                <div class="provider">
                  <h3>Service provided by</h3>
                  <div class="service-link">
                    <img src="@php echo $logoUrl @endphp" alt="@php echo $logoAlt @endphp">
                  </div>
                  @if(get_field('link'))
                    @php
                      $parserUrl = parse_url(get_field('link'));
                    @endphp
                    <a href="{{ the_field('link') }}" target="_blank" class="read-more">{!! pll__('Read more from ') !!} @php echo $parserUrl['host']; @endphp <span class="ihh-visually-hidden">this link leads to external webpage</span></a>
                  @endif
                </div>
              @else
                @if(get_field('link'))
                  @php
                    $parserUrl = parse_url(get_field('link'));
                  @endphp
                  <a href="{{ the_field('link') }}" target="_blank" class="read-more">{!! pll__('Read more from ') !!} @php echo $parserUrl['host']; @endphp <span class="ihh-visually-hidden">this link leads to external webpage</span></a>
                @endif
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>

    @endwhile
    @php wp_reset_postdata() @endphp
</section>
