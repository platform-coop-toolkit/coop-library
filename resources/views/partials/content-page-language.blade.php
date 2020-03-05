<form method="post">
  {{-- <h2 id="website-language">{{ __('Website language', 'coop-library') }}</h2>
  <p>{{ __('The website will be shown in this language.', 'coop-library') }}</p>
  <div class="input-group">
    <select name="pll_language" aria-labelledby="website-language">
      @foreach($available_languages as $key => $lang)
      <option
        value="{{ $key }}"
        @if(isset($_COOKIE['pll_language']))
          @if($_COOKIE['pll_language'] === $key)
            selected
          @endif
        @endif
      >{{ $lang }}</option>
      @endforeach
    </select>
  </div> --}}
  <h2 id="resource-language">{{ __('Resource language', 'coop-library') }}</h2>
  <p>{{ __('Resources that are in this language will be shown first.', 'coop-library') }}</p>
  <div class="input-group">
    <select name="resource_language" aria-labelledby="resource-language">
      @foreach($available_languages as $key => $lang)
      <option
        value="{{ $key }}"
        @if(isset($_COOKIE['resource_language']))
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
