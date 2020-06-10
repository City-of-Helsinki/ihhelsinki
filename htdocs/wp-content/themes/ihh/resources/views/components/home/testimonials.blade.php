@php
  $home_id = get_option('page_on_front');
  $post = get_post($home_id);
  $title = $post->post_title;
  $content = $post->post_content;
@endphp


@if(have_rows('testimonial'))
  @while(have_rows('testimonial')) @php the_row() @endphp
  <section class="testimonials">
    <div class="container">
      <div class="testimonial">
        <div class="content">
          <p>{{ the_sub_field('body') }}</p>
        </div>
        <a href="{{ the_sub_field('video_link') }}" class="image venobox" data-autoplay="true" data-vbtype="video">
          <img src="{{ the_sub_field('image') }}" alt="">
        </a>
      </div>
    </div>
  </section>
  @endwhile
@endif
