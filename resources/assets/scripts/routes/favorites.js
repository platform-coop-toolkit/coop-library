/* global CoopLibrary */

import Pinecone from '@platform-coop-toolkit/pinecone';
import Cookies from 'cookies.js';
import { __ } from '@wordpress/i18n';

export default {
  init() {
    // JavaScript to be fired on the favorites page
    if (!navigator.cookieEnabled) {
      // TODO: Notify user if cookies are disabled.
      console.error('Cookies disabled.');
    } else {
      const cards = document.querySelectorAll( '.card' );
      if ( cards ) {
        Array.prototype.forEach.call( cards, card => {
          new Pinecone.Card( card );
        } );
      }

      const removeAllButton = document.getElementById('remove-all');
      const removeButtons = document.querySelectorAll('.remove-favorite');
      if (removeAllButton && removeButtons) {
        new Pinecone.Dialog( removeAllButton, {
          title: __('Remove favorites?', 'coop-library'),
          question: __('Are you sure you want to remove all resources from your favorites?', 'coop-library'),
          confirm: __('Yes, remove', 'coop-library'),
          dismiss: __('No, don&rsquo;t remove', 'coop-library'),
          callback: function callback() {
            let favorites = Cookies.get('favorites');
            Cookies.set('favorites', '');
            fetch( CoopLibrary.ajaxurl, {
              method: 'POST',
              credentials: 'same-origin',
              headers: new Headers( {'Content-Type': 'application/x-www-form-urlencoded'} ),
              body: `action=update_favorites&coop_library_nonce=${encodeURIComponent( CoopLibrary.coop_library_nonce )}&post_id=${encodeURIComponent( favorites )}&operation=decrement`,
            } )
            .then( () => {
              // TODO: Add notification if the favorites were removed successfully.
              Array.prototype.forEach.call(removeButtons, btn => {
                btn.parentNode.parentNode.removeChild(btn.parentNode);
              });
              removeAllButton.parentNode.removeChild(removeAllButton);
            })
            .catch( function() {
              // TODO: Add notification if there was a problem.
            });
          },
        });
      }

      if (removeButtons) {
        const length = removeButtons.length;
        Array.prototype.forEach.call(removeButtons, btn => {
          new Pinecone.Dialog( btn, {
            title: __('Remove resource?', 'coop-library'),
            question: __('Are you sure you want to remove this resource from your favorites?', 'coop-library'),
            confirm: __('Yes, remove', 'coop-library'),
            dismiss: __('No, don&rsquo;t remove', 'coop-library'),
            callback: function callback() {
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
                if (length === 1) {
                  removeAllButton.parentNode.removeChild(removeAllButton);
                }
              })
              .catch( function() {
                // TODO: Add notification if there's a problem.
              });
            },
          } );
        });
      }
    }
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
