{{--
  Template Name: Employers
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <article class="content-block container">
      @include('partials.content.header')
      @include('partials.content.page')
    </article>

    @include('components.home.testimonials')
    @include('components.employers.employers-contact')
    @include('components.employers.employers-faq')
    @include('components.employers.employers-events')
    @include('components.home.media-category')
    
  @endwhile
@endsection
