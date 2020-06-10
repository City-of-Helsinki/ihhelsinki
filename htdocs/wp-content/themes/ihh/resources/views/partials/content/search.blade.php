<article @php post_class('search-result') @endphp>
  <h3><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h3>
  <div class="search-result-body">
    @php the_excerpt() @endphp
  </div>
</article>
