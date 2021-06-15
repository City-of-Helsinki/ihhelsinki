@php
  function media_categories() {
        return new \WP_Query( [
            'post_type'      => 'amb_media_catalogue',
            'posts_per_page' => - 1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ] );
    }
    $media_categories = media_categories();
@endphp

    <?php if ($media_categories):?>
    <section class="media-categories" style="margin-bottom: 0; padding: 0;">
    <div class="container" style="padding: 0px;">
      <h2><?=get_field('media_title', get_the_ID())?></h2>
    <div class="posts-container media-posts-container">
    @while($media_categories->have_posts())
      @php $media_categories->the_post();
        $mediaUrl = '';
        $mediaAlt = '';
        if($logoArray = get_field('media_image', get_the_ID())){
          $mediaUrl = $logoArray['url'];
          $mediaAlt = $logoArray['alt'];
        }
        $media_file = get_field('media_file', get_the_ID());
        $media_file_link = $media_file['url'];
        $videourl = get_field('video_file', get_the_ID());
        $bg_color = get_field('media_category_color', get_the_ID());
        $media_icon = get_field('media_icon', get_the_ID());
      @endphp
      <div class="media-grid-container post-grid-item">
      @if($media_file_link)<a target="_blank" href="{{ the_permalink() }}">@elseif($videourl)<a target="_blank" href="{{ $videourl }}">@endif()
        <div class="media-container">
             @if($mediaUrl) <div class="image-wrap"><img src="{{ $mediaUrl }}" alt="{{ $mediaAlt }}"/></div> @endif
             <div class="title background-{{$bg_color}}">
               @if($media_icon)<i class="icon-{{$media_icon}}"></i>@endif
               <p>{{ the_title() }}</p>
              </div>
        </div>
        </a>
      </div>
    @endwhile @php wp_reset_postdata() @endphp
    </div>
    </div>
    </section>
    <?php endif;?>