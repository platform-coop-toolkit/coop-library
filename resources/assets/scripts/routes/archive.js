import { Accordion } from '@platform-coop-toolkit/pinecone';

export default {
  init() {
    // JavaScript to be fired on the Archive page
    const accordions = document.querySelectorAll('.accordions');
    Array.prototype.forEach.call( accordions, accordion => {
      new Accordion(
        accordion,
        {
          paneSelector: '.accordion',
          controlSelector: '.accordion__control',
        }
      );
    } );
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
