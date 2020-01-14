<div class="sort-wrapper">
  <div class="sort">
      <div class="menu-button">
          <h2 class="h3 menu-button__label">@svg('sort', 'icon--sort', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ __('Sort by', 'coop-library') }}</h2>
          <ul class="link-list">
              <li class="link-list__item"><a href="{{ App::sortUrl('added') }}"{{ ($_GET['order_by']==='added') ? ' aria-current="true"' : '' }}>{{ __('Date added', 'coop-library') }}</a></li>
              <li class="link-list__item"><a href="{{ App::sortUrl('published') }}"{{ ($_GET['order_by']==='published') ? ' aria-current="true"' : '' }}>{{ __('Date published', 'coop-library') }}</a></li>
              <li class="link-list__item"><a href="{{ App::sortUrl('favorited') }}"{{ ($_GET['order_by']==='favorited') ? ' aria-current="true"' : '' }}>{{ __('Most favorited', 'coop-library') }}</a></li>
          </ul>
      </div>
  </div>
</div>
