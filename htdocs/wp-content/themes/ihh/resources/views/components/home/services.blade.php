@php
  $services = \App::services()

@endphp


@if(have_rows('services'))
  @while(have_rows('services')) @php the_row() @endphp
  <section class="services" style="margin-bottom: 0; padding: 0;">
    <div class="container">
      <div class="services-header">
        <img src="{{ the_sub_field('image') }}" alt="">
      </div>
      <h2>{{the_sub_field('title')}}</h2>
    </div>
  </section>
  <section class="services" style="padding-top: 0;">
    <div class="services-background">
      <div class="container">
        <div class="services-content">
          <ul class="home-services-list">
            @while($services->have_posts())
              @php $services->the_post();
            $logoUrl = '';
            $logoAlt = '';
            if($logoArray = get_field('logo', get_the_ID())){
              $logoUrl = $logoArray['url'];
              $logoAlt = $logoArray['alt'];
            }
              @endphp
              <li class="servicelist-item">
                <a href="{{ the_permalink() }}#{{ sanitize_title(get_the_title()) }}"
                   @if(get_sub_field('color')) style="background-color: {{get_sub_field('color')}}" @endif>
                  <div class="title"><p>{{ the_title() }}</p></div>
                  @if($logoUrl) <div class="image-wrap"><img src="{{ $logoUrl }}" alt="{{ $logoAlt }}"/></div> @endif
                  <span class="read-more">{!! pll__('Read more') !!}</span>
                </a>
              </li>
            @endwhile @php wp_reset_postdata() @endphp
          </ul>
        </div>
      </div>
    </div>
  </section>
  @endwhile
@endif
