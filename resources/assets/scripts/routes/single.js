/* global CoopLibrary */

import addNotification from '../util/addNotification';
import Pinecone from '@platform-coop-toolkit/pinecone';
import Cookies from 'cookies.js';
import { __ } from '@wordpress/i18n';

export default {
  init() {
    // JavaScript to be fired on a single resource page
    const favorite = document.getElementById('favorite');
    const id = favorite.dataset.id;
    let favorites = Cookies.get('favorites');
    let operation;
    favorites = favorites ? favorites.split(',') : [];
    if (favorites.includes(id)) {
      favorite.dataset.favorite = true;
    }

    favorite.onclick = () => {
      const state = 'true' === favorite.dataset.favorite || false;
      if (!state) {
        favorites.push(id);
        operation = 'increment';
      } else {
        favorites = favorites.filter(item => item !== id);
        operation = 'decrement';
      }

      Cookies.set('favorites', favorites.toString());

      fetch( CoopLibrary.ajaxurl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: new Headers( {'Content-Type': 'application/x-www-form-urlencoded'} ),
        body: `action=update_favorites&coop_library_nonce=${encodeURIComponent( CoopLibrary.coop_library_nonce )}&post_id=${encodeURIComponent( id )}&operation=${encodeURIComponent( operation )}`,
      } )
        .then( () => {
          if (operation === 'decrement') {
            addNotification(__('Favorite removed', 'coop-library'), __('The resource has been removed from your favorites.', 'coop-library'), 'success');
          } else {
            addNotification(__('Favorite added', 'coop-library'), __('The resource has been added to your favorites.', 'coop-library'), 'success');
          }
        })
        .catch( function() {
          if (operation === 'decrement') {
            addNotification(__('Favorite not removed', 'coop-library'), __('The resource could not be removed from your favorites.', 'coop-library'), 'error');
          } else {
            addNotification(__('Favorite not added', 'coop-library'), __('The resource could not be added to your favorites.', 'coop-library'), 'error');
          }
        });

      favorite.dataset.favorite = !state;
    }

    const share = document.querySelector( '.share' );
    if ( share ) {
      new Pinecone.MenuButton( share );
    }
    const alternateLinks = document.querySelector( '.alternate-links' );
    if ( alternateLinks ) {
      new Pinecone.MenuButton( alternateLinks );
    }
  },
  finalize() {
    // JavaScript to be fired on a single resource page, after the init JS
  },
};
