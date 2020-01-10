import Pinecone from '@platform-coop-toolkit/pinecone';

export default {
  init() {
    // JavaScript to be fired on a single resource page
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
