{{-- TODO: Show notification when value has been updated. --}}
<form method="post">
  <h2>{{ __('Website language', 'coop-library') }} @svg('language', 'icon--language', ['focusable' => 'false', 'aria-hidden' => 'true'])</h2>
  <p>{{ __('To change the language of this website, use the language menu in the navigation bar at the top of the page.', 'coop-library') }}</p>
  <h2 id="resource-language">{{ __('Resource language', 'coop-library') }}</h2>
  <p>{{ __('Resources that are in this language will be shown first.', 'coop-library') }}</p>
  <div class="input-group">
    <select name="resource_language" aria-labelledby="resource-language">
      @foreach($available_languages as $key => $lang)
      <option
        value="{{ $key }}"
        @if(isset($_POST['resource_language']))
          @if($_POST['resource_language'] === $key)
            selected
          @endif
        @elseif(isset($_COOKIE['resource_language']))
          @if($_COOKIE['resource_language'] === $key)
            selected
          @endif
        @endif
      >{{ $lang }}</option>
      @endforeach
    </select>
  </div>
  <div class="input-group">
    <button class="button" type="submit">{{ __('Save', 'coop-library') }}</button>
  </div>
</form>

