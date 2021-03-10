@php
  $services = \App::services();
  $background_img = get_field('image') ? get_field('image') : false;
  $service_provider = get_field('service_provider_logo');
@endphp

<section class="services-list">
  <select id="services-select" class="form-control">
    <option value="">{!! pll__('Select a service') !!} <i class="fa fa-angle-down"></i></option>
    @while($services->have_posts()) @php $services->the_post() @endphp
    <option value="{{the_permalink()}}">{{the_title()}}</option>
    @endwhile
    @php wp_reset_postdata() @endphp
  </select>

  @if(is_singular(['service']))
    <div class="services-list-content" @if($background_img) style="background-image: url({{$background_img}})" @endif>
      <div class="services-list-body">
        <div class="services-list-body-text" @if(get_field('color')) style="background-color: {!! get_field('color') !!}" @endif>
          <h2>{{ the_title() }}</h2>
          {{ the_content() }}
          @if(get_field('link'))
            @php
              $parsedUrl = parse_url(get_field('link'));
            @endphp
            <a href="{{ the_field('link') }}" target="_blank" class="read-more">{!! pll__('Read more from') !!} @php echo $parsedUrl['host']; @endphp <span class="ihh-visually-hidden">This link leads to external webpage</span></a>
          @endif
        </div>

      </div>
    </div>
  @endif
</section>
