import Pinecone from '@platform-coop-toolkit/pinecone';

export default {
  init() {
    // JavaScript to be fired on all pages
    const toggle = document.querySelector( '.menu-toggle' );
    const menu = document.querySelector( '.menu' );
    new Pinecone.Menu(toggle, menu);

    /* TODO: Resolve icon issues
    const icons = document.querySelectorAll( 'svg' );

    if ( icons.length > 0 ) {
      Array.prototype.forEach.call( icons, icon => {
        new Pinecone.Icon( icon );
      } );
    } */
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
