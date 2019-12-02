export default {
  init() {
    // JavaScript to be fired on all pages
    window.pinecone.menu();
    window.pinecone.icons();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
