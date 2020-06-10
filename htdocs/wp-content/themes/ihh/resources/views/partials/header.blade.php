@php wp_reset_postdata() @endphp

@php
  $id = is_home() ? get_option('page_for_posts') : get_the_ID();
  $header_img = has_post_thumbnail($id) ? get_the_post_thumbnail_url($id) : \App\get_default_image();
  if(is_search()){
    $search_main_id = get_page_by_path('search');
    $content_id = pll_get_post($search_main_id->ID);
    $header_img = get_the_post_thumbnail_url($search_main_id);
  }
@endphp

@if(is_front_page())
  @include('components.notifications')
@endif

@if(!is_singular(['post', 'event']))
  <header class="header-area container-wide">
    <img src="{{ $header_img }}" alt="">
    @include('components.wave')
  </header>
@endif
