<form method="post">
  <p><strong>{{ __('Allow the Resource Library to track what resources you’ve viewed.', 'coop-library') }}</strong></p>
  <span class="disclosure-label" hidden>{{ __('How resource tracking changes what you see', 'coop-library') }}</span>
  <div class="details">
      <p>{!! __('By choosing ‘Allow’, the Resource Library will be able to track the resources you view, letting you:', 'coop-library') !!}</p>
      <ul>
        <li>{!! __('see a list of your recently viewed resources on the home page,', 'coop-library') !!}</li>
        <li>{!! __('see related resources, and', 'coop-library') !!}</li>
        <li>{!! __('contribute to the most viewed articles seen on the home page.', 'coop-library') !!}</li>
      </ul>
      <p>{!! __('The Resource Library will only use this information for these features, and does not collect any personally identifiable information.', 'coop-library') !!}</p>
      <p>{!! __('By choosing ‘Don’t allow’, you will be able to continue to use the Resource Library fully, with the exception of the features mentioned previously.', 'coop-library') !!}</p>
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
