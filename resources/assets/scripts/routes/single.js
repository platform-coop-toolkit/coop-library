import Pinecone from '@platform-coop-toolkit/pinecone';
import Cookies from 'cookies.js';

export default {
  init() {
    // JavaScript to be fired on a single resource page
    const favorite = document.getElementById('favorite');
    const id = favorite.dataset.id;
    let favorites = Cookies.get('favorites');
    favorites = favorites ? favorites.split(',') : [];
    if (favorites) {
      if (favorites.includes(id)) {
        favorite.dataset.favorite = true;
      }
    }

    favorite.onclick = () => {
      const state = 'true' === favorite.dataset.favorite || false;
      if (favorites) {
        if (!state) {
          favorites.push(id);
        } else {
          favorites = favorites.filter(item => item !== id);
        }

        Cookies.set('favorites', favorites.toString());
      } else {
        Cookies.set('favorites', [id].toString());
      }
      // TODO: Process ID on backend.
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
