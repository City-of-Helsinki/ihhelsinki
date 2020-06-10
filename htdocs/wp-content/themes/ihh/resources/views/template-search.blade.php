{{--
  Template Name: Search
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  <section class="content-block container">
    @include('partials.content.page')
    {!! get_search_form(false) !!}
  </section>

  @endwhile
@endsection
