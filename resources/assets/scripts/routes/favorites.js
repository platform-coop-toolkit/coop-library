/* global CoopLibrary */

import Pinecone from '@platform-coop-toolkit/pinecone';
import Cookies from 'cookies.js';

export default {
  init() {
    // JavaScript to be fired on the favorites page
    const cards = document.querySelectorAll( '.card' );

    if ( cards ) {
      Array.prototype.forEach.call( cards, card => {
        new Pinecone.Card( card );
      } );
    }

    const buttons = document.querySelectorAll('.remove-favorite');
    Array.prototype.forEach.call(buttons, btn => {
      btn.onclick = () => {
        if (confirm('Remove this resource from your favorites?')) {
          const id = btn.dataset.id;
          let favorites = Cookies.get('favorites');
          favorites = favorites ? favorites.split(',') : [];
          favorites = favorites.filter(item => item !== id);
          Cookies.set('favorites', favorites.toString());

          fetch( CoopLibrary.ajaxurl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: new Headers( {'Content-Type': 'application/x-www-form-urlencoded'} ),
            body: `action=update_favorites&coop_library_nonce=${encodeURIComponent( CoopLibrary.coop_library_nonce )}&post_id=${encodeURIComponent( id )}&operation=decrement`,
          } )
            .then( () => {
              // TODO: Add notification if the favorite was removed successfully.
              btn.parentNode.parentNode.removeChild(btn.parentNode);
            })
            .catch( function() {
              // TODO: Add notification if there's a problem.
            });

        }
      }

    })
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
