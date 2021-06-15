@php
  $news_page = get_option('page_for_posts');
  $url = get_the_permalink();
  $title = get_the_title();
  $is_event = 'event' === get_post_type();
  $event_url_text = get_field('read_more_text') ?: pll__('Read more');
  $attachment_text = get_field('attachment_text') ?: pll__('Download attachment');
@endphp

<section class="event-container">
  <article @php post_class('content-block content-single') @endphp>
    <a href="{!! get_the_permalink($news_page) !!}" class="go-back"><i class="fa fa-angle-left"></i></a>

    <div class="event-top">
      @if(has_post_thumbnail())
        <div class="event-image" style="background-image: url('{!! get_the_post_thumbnail_url(get_the_ID()) !!}');">
        </div>
      @endif
      <div class="event-details">
        <span class="event-publish-date">
          <time datetime="{!! get_the_date('c') !!}" itemprop="datePublished">{!! get_the_date() !!}</time>
        </span>
        <h1>{!! $title !!}</h1>
        <div class="event-short-description">{!! get_field('event_short_description') !!}</div>
        <div class="event-meta">
          <table>
            <thead></thead>
            <tbody>
              <tr>
                <td>Ajankohta</td>
                <td>{!! \App\format_event_date() !!}</td>
              </tr>

              <tr>
                <td>Paikka</td>
                <td>{!! get_field('location') !!}</td>
              </tr>

              @if($is_event && get_field('attachment'))
              <tr>
                <td>{{ $attachment_text }}</td>
                <td><a href="{!! get_field('attachment') !!}" target="_blank">{{ $attachment_text }}</a></td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <div class="event-body">
      <div class="event-body-content">
        @if($is_event && get_field('description'))
        <a name="description"></a>
        <div class="event-description">  
          <h2>Description</h2>
          {!! get_field('description') !!}
        </div>
        @endif
        @if($is_event && get_field('streaming'))
        <a name="streaming"></a>
        <div class="event-streaming">
          <h2>Streaming</h2>
          {!! get_field('streaming') !!}
        </div>
        @endif
        @if($is_event && get_field('program'))
        <a name="program"></a>
        <div class="event-program">
          <h2>Program</h2>
          {!! get_field('program') !!}
        </div>
        @endif
      </div>
      <div class="event-body-navigation">
        <h3>{!! $title !!}</h3>
        <div class="event-body-navigation-items">
          <a href="#event-info">Event info</a><br>
          @if($is_event && get_field('description'))
          <a href="#description">Description</a><br>
          @endif
          @if($is_event && get_field('streaming'))
          <a href="#streaming">Streaming</a><br>
          @endif
          @if($is_event && get_field('program'))
          <a href="#program">Program</a><br>
          @endif
        </div>
        
      </div>
      <div class="clear"></div>
    </div>
    @if($is_event && get_field('event_url'))
    <div class="event-read-more">
      <div class="event-read-more-cta">
        <a href="{!! get_field('event_url') !!}" class="event-url" target="_blank">{{ $event_url_text }}</a>
      </div>
    </div>
    @endif
  </article>
</section>
