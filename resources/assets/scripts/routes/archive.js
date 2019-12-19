import Pinecone from '@platform-coop-toolkit/pinecone';

export default {
  init() {
    // JavaScript to be fired on the Archive page
    const cards = document.querySelectorAll( '.card' );

    if ( cards ) {
      Array.prototype.forEach.call( cards, card => {
        new Pinecone.Card( card );
      } );
    }

    const filterContainer = document.querySelector( '.filters' );
    const showFilters = document.querySelector( '#show-filters' );
    const hideFilters = document.querySelector( '#hide-filters' );

    if ( showFilters && hideFilters && filterContainer ) {
      new Pinecone.FilterList( filterContainer, showFilters, hideFilters );
    }

    const nestedCheckboxContainers = document.querySelectorAll( '.input-group__parent > li' );
    if ( nestedCheckboxContainers ) {
      Array.prototype.forEach.call( nestedCheckboxContainers, container => {
        const input = container.querySelector( 'li > input' );
        const subInputs = container.querySelectorAll( '.input-group__descendant input' );
        if ( 0 < subInputs.length ) {
          new Pinecone.NestedCheckbox( container, input, subInputs );
        }
      } );
    }

    const accordions = document.querySelectorAll('.accordion');
    Array.prototype.forEach.call( accordions, accordion => {
      new Pinecone.Accordion(
        accordion,
        {
          paneSelector: '.accordion__pane',
          controlSelector: '.accordion__control',
        }
      );
    } );
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
