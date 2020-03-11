/* global CoopLibrary */

import addNotification from '../util/addNotification';
import Pinecone from '@platform-coop-toolkit/pinecone';
import Cookies from 'cookies.js';
import { __ } from '@wordpress/i18n';

export default {
  init() {
    // JavaScript to be fired on the favorites page
    if (!navigator.cookieEnabled) {
      addNotification(__('Favorites not supported', 'coop-library'), __('Your favorites are stored in your browser\'s cookies. To add favorites, please enable cookies for this website.', 'coop-library'), 'error');
    } else {
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
            fetch( CoopLibrary.ajaxurl, {
              method: 'POST',
              credentials: 'same-origin',
              headers: new Headers( {'Content-Type': 'application/x-www-form-urlencoded'} ),
              body: `action=update_favorites&coop_library_nonce=${encodeURIComponent( CoopLibrary.coop_library_nonce )}&post_id=${encodeURIComponent( favorites )}&operation=decrement`,
            } )
            .then( () => {
              Cookies.set('favorites', '');
              const resourceList = document.getElementById('favorites');
              removeAllButton.parentNode.removeChild(removeAllButton);
              resourceList.parentNode.removeChild(resourceList);
              addNotification(__('Favorites removed', 'coop-library'), __('The resources have been removed from your favorites.', 'coop-library'), 'success');
            })
            .catch( function() {
              addNotification(__('Favorites not removed', 'coop-library'), __('The resources could not be removed from your favorites.', 'coop-library'), 'error');
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
              fetch( CoopLibrary.ajaxurl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: new Headers( {'Content-Type': 'application/x-www-form-urlencoded'} ),
                body: `action=update_favorites&coop_library_nonce=${encodeURIComponent( CoopLibrary.coop_library_nonce )}&post_id=${encodeURIComponent( id )}&operation=decrement`,
              } )
              .then( () => {
                Cookies.set('favorites', favorites.toString());
                btn.parentNode.parentNode.parentNode.removeChild(btn.parentNode.parentNode);
                if (length === 1) {
                  removeAllButton.parentNode.removeChild(removeAllButton);
                }
                addNotification(__('Favorite removed', 'coop-library'), __('The resource has been removed from your favorites.', 'coop-library'), 'success');
              })
              .catch( function() {
                addNotification(__('Favorite not removed', 'coop-library'), __('The resource could not be removed from your favorites.', 'coop-library'), 'error');
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
