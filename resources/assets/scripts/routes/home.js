import Pinecone from '@platform-coop-toolkit/pinecone';

export default {
  init() {
    // JavaScript to be fired on the home page
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
