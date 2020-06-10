<nav class="navbar sticky-top navbar-expand-lg main-nav-container">
  <div class="container">
    <a class="navbar-brand" href="{{ home_url('/') }}">
      <img src="@asset('images/logo_color.svg')" width="175" height="60" class="d-inline-block align-top"
           alt="{{ get_bloginfo('name', 'display') }}">
    </a>
    <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#main-navigation"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="main-navigation">
      @if (has_nav_menu('primary_navigation'))
        <ul id="menu-paavalikko" class="navbar-nav menu">
          {!!
            wp_nav_menu([
              'container' => false,
              'items_wrap' => '%3$s',
              'theme_location' => 'primary_navigation',
              'menu_class' => 'navbar-nav menu',
              'walker' => new App\NavWalker
            ])
          !!}
        </ul>
      @endif
    </div>
  </div>
</nav>
