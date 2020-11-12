@php
  $services = \App::services()

@endphp


@if(have_rows('services'))
  @while(have_rows('services')) @php the_row() @endphp

  <section class="services">
    <div class="container">
      <div class="services-header">
        <img src="{{ the_sub_field('image') }}" alt="">
      </div>
      <div class="services-content">
        <h2>{{the_sub_field('title')}}</h2>
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
          <li class="services-list-item">
            <a href="{{ the_permalink() }}#{{ sanitize_title(get_the_title()) }}"
            @if(get_sub_field('color')) style="background-color: {{get_sub_field('color')}}" @endif>
              @if($logoUrl) <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}"/> @endif
              <span>{{ the_title() }}</span>
            </a>
          </li>
          @endwhile @php wp_reset_postdata() @endphp
        </ul>
      </div>
    </div>
  </section>
  @endwhile
@endif
