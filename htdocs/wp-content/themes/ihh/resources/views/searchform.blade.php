<form role="search" method="get" class="search-form" action="{{ esc_url( home_url( '/' ) ) }}">
  <label for="search-input">
    <span class="screen-reader-text">{!! pll__('Search for') !!}</span>
  </label>
  <input type="search" id="search-input" class="search-field" placeholder="{{pll__('Search...')}}"
         value="{!! get_search_query() !!}" name="s"/>
  <button type="submit" class="search-submit">{{pll__('Search')}}</button>
</form>
