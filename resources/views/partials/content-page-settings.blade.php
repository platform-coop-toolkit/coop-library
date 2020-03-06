<form method="post">
  <p><strong>{{ __('Allow the Resource Library to track what resources you’ve viewed.', 'coop-library') }}</strong></p>
  <span class="disclosure-label" hidden>{{ __('How this changes what I see', 'coop-library') }}</span>
  <div class="details">
      <p>{{ __('If you allow the resource library to know this, you would be able to see resources that are recently viewed by you, related to your recently viewed, and contribute your information to create the most viewed resource section seen by the larger community.', 'coop-library') }}</p>
  </div>
  <ul class="input-group">
    <li>
      <input id="allow" type="radio" name="track_viewed_resources" value="on" {{ checked('on', $track_viewed_resources) }}>
      <label for="allow">{!! __('Allow', 'coop-library') !!}</label>
    </li>
    <li>
      <input id="disallow" type="radio" name="track_viewed_resources" value="" {{ checked(false, $track_viewed_resources) }}>
      <label for="disallow">{!! __('Don&rsquo;t allow', 'coop-library') !!}</label>
    </li>
  </ul>
  <div class="input-group">
    <button class="button" type="submit">{{ __('Save', 'coop-library') }}</button>
  </div>
</form>
