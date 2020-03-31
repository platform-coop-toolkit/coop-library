/* global CoopLibrary */

import addNotification from '../util/addNotification';
import Cookies from 'cookies.js';
import Pinecone from '@platform-coop-toolkit/pinecone';
import { __, _n, sprintf } from '@wordpress/i18n';
import { speak } from '@wordpress/a11y';

export default {
  init() {
    // JavaScript to be fired on the Archive page
    const filterContainer = document.querySelector( '.filters' );
    const showFilters = document.querySelector( '#show-filters' );
    const hideFilters = document.querySelector( '#hide-filters' );

    if (document.body.classList.contains('filtered')) {
      const currentFilterCount = document.body.dataset.filters;
      if ( currentFilterCount ) {
        setTimeout(function() {
          speak(sprintf(_n('%s filter applied. Resource list updated.', '%s filters applied. Resource list updated.', parseInt(currentFilterCount), 'coop-library'), currentFilterCount), 'assertive');
        }, 1000);
      }
    }

    if ( showFilters && hideFilters && filterContainer ) {
      new Pinecone.FilterList( filterContainer, showFilters, hideFilters );
    }

    const deselectButtons = document.querySelectorAll( 'button[id^="deselect-"]' );
    if ( 0 < deselectButtons.length ) {
      Array.prototype.forEach.call( deselectButtons, btn => {
        new Pinecone.DeselectAll( btn );
        const filterGroup = btn.parentNode.parentNode;
        const filterGroupLabel = filterGroup.firstElementChild.textContent;
        btn.onclick = () => {
          speak(sprintf(__('All %s have been deselected', 'coop-library'), filterGroupLabel));
        }
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
      const expandedAlready = document.querySelectorAll('.accordion__pane--expanded');
      Array.prototype.forEach.call( expandedAlready, pane => {
        pane.querySelector('.accordion__control').setAttribute('aria-expanded', true);
      });
    } );

    document.addEventListener('click', (event) => {
      if (!event.target.matches('.accordion__control')) return;
      const id = event.target.parentNode.id;
      const expanded = 'true' == event.target.getAttribute('aria-expanded') || false;
      if (expanded) {
        Cookies.set('filters-expanded', id);
      } else {
        Cookies.remove('filters-expanded');
      }
    });

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
      let savedSearches = localStorage.getItem('saved-searches');
      savedSearches = savedSearches ? JSON.parse(savedSearches) : {};

      if (Object.entries(savedSearches).length === 50) {
        saveSearchButton.onclick = () => {
          addNotification(
            __('Maximum number of saved searches reached', 'coop-library'),
            sprintf(__('You have reached the maximum amount of saved searches (50). To save more, you must <a href="%s">delete some saved searches</a>.', 'coop-library'), CoopLibrary.savedSearchesLink),
            'error'
          );
        };
      } else {
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
              if (Object.keys(savedSearches).length === 50) {
                addNotification(
                  __('Search not saved', 'coop-library'),
                  __('You have reached the maximum amount of saved searches (50). To save more, you must delete some saved searches.', 'coop-library'),
                  'error'
                );
                return false;
              }
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
              const remaining = 50 - Object.keys(savedSearches).length;
              if (remaining > 10) {
                addNotification(
                  __('Search saved', 'coop-library'),
                  sprintf(
                    __('You have successfully saved this search. You can save <strong>%1$d</strong> more. You can see this search on your <a href="%2$s">saved searches page</a>.', 'coop-library'),
                    remaining,
                    CoopLibrary.savedSearchesLink
                  ),
                  'success'
                );
              } else if (remaining > 1) {
                addNotification(
                  __('Search saved', 'coop-library'),
                  sprintf(
                    __('You have successfully saved this search. <strong>You can only save %1$d more.</strong> You can see this search and manage saved searches on your <a href="%2$s">saved searches page</a>.', 'coop-library'),
                    remaining,
                    CoopLibrary.savedSearchesLink
                  ),
                  'warning'
                );
              } else {
                addNotification(
                  __('Search saved', 'coop-library'),
                  sprintf(
                    __('You have successfully saved this search. <strong>You have reached the maximum number of saved searches (50).</strong> You can see this search and manage saved searches on your <a href="%2$s">saved searches page</a>.', 'coop-library'),
                    remaining,
                    CoopLibrary.savedSearchesLink
                  ),
                  'warning'
                );
              }
            } catch(error) {
              addNotification(__('Search not saved', 'coop-library'), __('Your search could not be saved.', 'coop-library'), 'error');
            }
          },
        });
      }
    }
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
