/* global CoopLibrary */

import Pinecone from '@platform-coop-toolkit/pinecone';
import Cookies from 'cookies.js';

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
          // TODO: Add notification if the favorite was added successfully.
        })
        .catch( function() {
          // TODO: Add notification if there's a problem.
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
