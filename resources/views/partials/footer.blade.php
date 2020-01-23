<footer class="content-info">
  <div class="container">
    <div class="columns">
      <div class="column">
        <a class="logo link--inverse" rel="external" href="https://platform.coop/">
          @svg('logo', 'logo__image', ['focusable' => 'false', 'aria-hidden' => 'true'])
          <span class="screen-reader-text">{{ __('Platform Cooperativism Consortium', 'coop-library') }}</span>
        </a>
        <div class="nav">
          <p><a class="link--inverse" rel="external" href="https://platform.coop/open-access-and-privacy-policy/">{{ __('Our open access and privacy policy', 'coop-library') }}</a></p>
          <p><a class="link--inverse" rel="external" href="https://platform.coop/diversity-inclusion/">{{ __('Our commitment to diversity and inclusion', 'coop-library') }}</a></p>
        </div>
      </div>
      <div class="column">
        <div class="h4"><a rel="external" class="link--inverse" href="https://platform.coop/contact-us/">Contact us</a></div>
		    <div>
          <strong>{{ __('Email', 'coop-library') }}</strong><br />
			    <a class="link--inverse" href="mailto:{!! antispambot('info@platform.coop') !!}" rel="external">{!! antispambot('info@platform.coop') !!}</a>
        </div>
      </div>
    </div>
  </div>
</footer>
