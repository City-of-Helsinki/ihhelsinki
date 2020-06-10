@php
  $content = get_post(get_option('page_for_posts'))->post_content;
@endphp

@extends('layouts.app')

@section('content')
  <section class="content-block container">
    @include('partials.content.header')
    <div class="content-block-content">
      {!! apply_filters('the_content', $content) !!}
    </div>


    @if (!have_posts())
      <div class="alert alert-warning">
        {{ pll__('Sorry, no news were found.') }}
      </div>
    @endif

    <div class="posts-container">
      @while (have_posts()) @php the_post() @endphp
      @include('partials.content.grid')
      @endwhile
    </div>

    {!! get_the_posts_navigation() !!}
  </section>
@endsection
