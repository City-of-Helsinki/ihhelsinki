@php
  $title = get_the_title();
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

<section class="content-block container">
  <div class="content-header">
  <h1>{!! $title !!}</h1>
  </div>
  <div class="content-block-content">
    {!! get_post_field('post_content', $content_id) !!}
  </div>
  @if($media_file_link)<a target="_blank" href="{{ $media_file_link }}">@elseif($videourl)<a target="_blank" href="{{ $videourl }}">@endif()
        <div class="media-container">
  @if($mediaUrl) <div class="image-wrap"><img src="{{ $mediaUrl }}" alt="{{ $mediaAlt }}"/></div> @endif
  @if($media_file_link)</a>@elseif($videourl)</a>@endif()


</section>
