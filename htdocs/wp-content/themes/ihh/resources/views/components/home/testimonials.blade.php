@php
  global $wp_query;
  $home_id = $wp_query->post->ID;
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
          <p>{{ the_sub_field('description')}}</p>
        </div>

        <div class="videos">
          @if(have_rows('testimonial_repeater'))
            @while(have_rows('testimonial_repeater')) @php the_row() @endphp
            <div class="video">
              <a href="{{ the_sub_field('video_link') }}" class="image venobox" data-autoplay="true" data-vbtype="video">
                @php
                  $image = get_sub_field('image');
                @endphp
                <img src="{{ $image['url'] }}" alt="{{$image['alt']}}" >
              </a>
              <p>{{ the_sub_field('body')}}</p>
            </div>
            @endwhile
          @endif
        </div>
      </div>

    </div>
  </section>
  @endwhile
@endif
