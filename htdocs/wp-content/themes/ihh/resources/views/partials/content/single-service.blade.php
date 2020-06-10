@php
  $service_main_id = get_page_by_path('services');
  $content_id = pll_get_post($service_main_id->ID);
@endphp

<section class="content-block container">
  <div class="content-header">
    <h1>{{ pll__('Services') }}</h1>
  </div>

  <div class="content-block-content">
    {!! get_post_field('post_content', $content_id) !!}
  </div>

  @include('components.services-list')
</section>
