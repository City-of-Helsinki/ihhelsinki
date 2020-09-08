{{--
  Template Name: About
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  <article class="content-block container">
    @include('partials.content.header')
    @include('partials.content.page')
  </article>

  @if(have_rows('links'))
    <section class="about-services">
      <div class="container">
        <div class="row">
          @while(have_rows('links')) @php the_row() @endphp
          <div class="service-link">
            <a href="{{the_sub_field('link')}}" target="_blank">
              @php
                $image = get_sub_field('logo');
              @endphp
              <img src="{{ $image['url'] }}" alt="{{$image['alt']}}" >
            </a>
          </div>
          @endwhile
        </div>
      </div>
    </section>
  @endif
  @endwhile
@endsection
