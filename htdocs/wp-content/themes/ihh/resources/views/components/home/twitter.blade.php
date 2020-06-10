@php
  $tweets = \App::tweets();
  $info = \App::tweet_info();
@endphp

<section class="twitter container-wide">
  <div class="container">
    <h2>Our tweets</h2>

    <div class="tweets">
      @foreach($tweets as $tweet)
        <div class="tweet-container">
          <div class="tweet">
            <header class="tweet-header">
              <a href="https://twitter.com/{{ $info->screen_name }}/status/{{ $tweet->id }}" target="_blank">
                <img src="{{$info->profile_image_url_https}}" alt=""> {{ $info->screen_name }}
              </a>
            </header>
            <div class="tweet-content">
              {!! \App\linkify_tweet($tweet->text) !!}
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
