export default {
  init() {
    // JavaScript to be fired on the home page
    window.pinecone.cards();
    window.pinecone.accordions();
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
