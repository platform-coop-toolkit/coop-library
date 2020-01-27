import Pinecone from '@platform-coop-toolkit/pinecone';
import Client from '@wp-headless/client';

/**
 * @param {integer} id The resource ID.
 *
 * @returns {Promise}
 */
let getResource = async function(id) {
  const client = new Client('http://commons.platform.coop.test/wp-json');
  client.resources = () => client.namespace('wp/v2').resource('resources');
  const resource = await client.resources().get(id);
  return resource;
};

export default {
  init() {
    // JavaScript to be fired on the favorites page
    const app = document.getElementById('favorites');
    let favorites = localStorage.getItem('favorites');
    favorites = favorites ? favorites.split(',') : [];
    if (favorites) {
      Array.prototype.forEach.call(favorites, id => {
        getResource(id).then(resource => {
          const el = document.createElement('div');
          el.innerHTML = `<a href="${resource.link}">${resource.title.rendered}</a>`;
          app.appendChild(el);
        });
      });
    }

    const cards = document.querySelectorAll( '.card' );

    if ( cards ) {
      Array.prototype.forEach.call( cards, card => {
        new Pinecone.Card( card );
      } );
    }
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
