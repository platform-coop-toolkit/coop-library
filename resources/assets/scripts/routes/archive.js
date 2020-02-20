import addNotification from '../util/addNotification';
import Pinecone from '@platform-coop-toolkit/pinecone';
import { __, sprintf } from '@wordpress/i18n';

export default {
  init() {
    // JavaScript to be fired on the Archive page
    const filterContainer = document.querySelector( '.filters' );
    const showFilters = document.querySelector( '#show-filters' );
    const hideFilters = document.querySelector( '#hide-filters' );

    if ( showFilters && hideFilters && filterContainer ) {
      new Pinecone.FilterList( filterContainer, showFilters, hideFilters );
    }

    const deselectButtons = document.querySelectorAll( 'button[id^="deselect-"]' );
    if ( 0 < deselectButtons.length ) {
      Array.prototype.forEach.call( deselectButtons, btn => {
        new Pinecone.DeselectAll( btn );
      } );
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
          headingSelector: '.accordion__heading',
        }
      );
    } );

    const filterDisclosureLabels = document.querySelectorAll( '.filter-disclosure-label' );

    if ( filterDisclosureLabels ) {
      Array.prototype.forEach.call( filterDisclosureLabels, label => {
        new Pinecone.DisclosureButton( label, { buttonVariant: 'button--disc', visuallyHiddenLabel: true } );
      } );
    }

    const sortMenuButtonContainer = document.querySelector( '.sort .menu-button' );
    if ( sortMenuButtonContainer ) {
      new Pinecone.MenuButton( sortMenuButtonContainer, { placement: 'bottom' } );
    }

    const clearFilterBtns = document.querySelectorAll('.current-filters button');
    Array.prototype.forEach.call( clearFilterBtns, btn => {
      btn.onclick = () => {
        const id = btn.getAttribute('data-checkbox');
        const checkbox = document.getElementById(id);
        checkbox.checked = false;
        document.forms.filters.submit();
      };
    });

    // Save search
    const saveSearchButton = document.getElementById('save-search');

    if (saveSearchButton) {
      new Pinecone.Dialog( saveSearchButton, {
        title: __('Save search', 'coop-library'),
        question: __('To save your search, please give it a name so you can identify it later.', 'coop-library'),
        input: 'name',
        inputLabel: __('Name of saved search:', 'coop-library'),
        confirm: __('Save', 'coop-library'),
        dismiss: __('Don&rsquo;t save', 'coop-library'),
        callback: function callback(input) {
          try {
            const tags = document.querySelectorAll('.filters input:checked');
            let savedSearches = localStorage.getItem('saved-searches');
            savedSearches = savedSearches ? JSON.parse(savedSearches) : {};
            const now = Date.now();
            const term = document.querySelector('.filters input[name="s"]').value;
            const name = input ? input : sprintf(__('Saved search for “%s”', 'coop-library'), term);
            const url = window.location.href;
            const filters = [];
            Array.prototype.forEach.call(tags, tag => {
              const label = document.querySelector(`[for="${tag.id}"]`);
              filters.push(label.innerText);
            });
            savedSearches[now] = {name, term, url, filters};
            localStorage.setItem('saved-searches', JSON.stringify(savedSearches));
            addNotification(__('Search saved', 'coop-library'), sprintf( __('Your search “%s” has been saved.', 'coop-library'), name), 'success');
          } catch(error) {
            addNotification(__('Search not saved', 'coop-library'), __('Your search could not be saved.', 'coop-library'), 'error');
          }
        },
      });
    }
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
