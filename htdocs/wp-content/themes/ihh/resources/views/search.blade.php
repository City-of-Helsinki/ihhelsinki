@extends('layouts.app')

@section('content')
  <section class="content-block container">
    <div class="content-header">
      <h1>Search result</h1>
    </div>
    @if (!have_posts())
      <div class="alert alert-warning">
        {{ pll__('Sorry, no results were found.') }}
      </div>
    @endif

    {!! get_search_form(false) !!}

    @if(have_posts())
      <div class="search-results">
        <h2>{!! sprintf(pll__('Search results for <em>%s</em>'), get_search_query()) !!}</h2>
        @while(have_posts()) @php the_post() @endphp
        @include('partials.content.search')
        @endwhile
      </div>
    @endif

    {!! get_the_posts_navigation() !!}
  </section>
@endsection
