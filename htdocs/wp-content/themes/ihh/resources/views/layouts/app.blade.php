<!doctype html>
<html {!! get_language_attributes() !!}>
  <a id="skip-to-main" class="skip-main" href="#main">@php echo pll__('Skip to content'); @endphp</a>
  @include('partials.head')
  <body @php body_class() @endphp>
    @php do_action('get_header') @endphp
    @include('components.navigation')
    @include('partials.header')
    <main id="main" class="wrap main">
      @yield('content')
    </main>
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
  </body>
</html>
