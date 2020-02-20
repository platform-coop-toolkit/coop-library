import addNotification from '../util/addNotification';
import Pinecone from '@platform-coop-toolkit/pinecone';
import { __ } from '@wordpress/i18n';

export default {
  init() {
    // JavaScript to be fired on the Saved Searches page
    const savedSearchContainer = document.getElementById('saved-searches');
    let savedSearches = localStorage.getItem('saved-searches');
    savedSearches = savedSearches ? JSON.parse(savedSearches) : {};
    savedSearches = Object.entries(savedSearches);

    if (savedSearches.length > 0) {
      savedSearchContainer.previousElementSibling.removeAttribute('hidden');
      Array.prototype.forEach.call(savedSearches, i => {
        let [key, item] = i;
        let tags = '';
        let tagsList = '';
        if (item.filters) {
          Array.prototype.forEach.call(item.filters, tag => {
            tags += `<span class="badge">${tag}</span>`;
          });
        }
        if (tags) {
          tagsList = `
            <p>
              <strong>${__('Tags', 'coop-library')}</strong>
            </p>
            <div class="tags">${tags}</div>
          </div>
          `;
        }
        const savedSearch = document.createElement('div');
        savedSearch.className = 'saved-search';
        savedSearch.innerHTML = `
          <p class="h4"><a href="${item.url}">${item.name}</a></p>
          <span class="disclosure-label" hidden>
            ${__('Show details', 'coop-library')}
          </span>
          <div class="saved-search__details">
          <p>
            <strong>${__('Search term', 'coop-library')}</strong><br />
            “${item.term}”
          </p>
          ${tagsList}
          </div>
          <div class="align-right"><button class="button button--borderless button--destructive remove-saved-search" type="button" data-key="${key}"><svg viewBox="0 0 20 20" class="icon icon--delete" xmlns="http://www.w3.org/2000/svg"><path id="delete" d="m17 4h-3a3.14 3.14 0 0 0 -3.13-3h-1.73a3.14 3.14 0 0 0 -3.14 3h-3a1 1 0 0 0 0 2h.07l.93 12.08a1 1 0 0 0 1 .92h10a1 1 0 0 0 1-.92l.93-12.08h.07a1 1 0 0 0 0-2zm-7.86-1h1.72a1.12 1.12 0 0 1 1.14 1h-4a1.12 1.12 0 0 1 1.14-1zm4.93 14h-8.14l-.85-11h9.84z" fill="currentColor"/></svg> ${__('Remove', 'coop-library')}</button></div>
        `;

        savedSearchContainer.appendChild(savedSearch);

        const disclosureLabels = document.querySelectorAll( '.disclosure-label' );

        if ( disclosureLabels ) {
          Array.prototype.forEach.call( disclosureLabels, label => {
            new Pinecone.DisclosureButton( label );
          } );
        }
      });
    }
    const removeAllButton = document.getElementById('remove-all');
    if(removeAllButton) {
      new Pinecone.Dialog( removeAllButton, {
        title: __('Remove saved searches?', 'coop-library'),
        question: __('Are you sure you want to remove all of your saved searches?', 'coop-library'),
        confirm: __('Yes, remove', 'coop-library'),
        dismiss: __('No, don&rsquo;t remove', 'coop-library'),
        callback: function callback() {
          try {
            localStorage.setItem('saved-searches', '');
            savedSearchContainer.innerHTML = '';
            removeAllButton.parentNode.removeChild(removeAllButton);
            addNotification(__('Saved searches removed', 'coop-library'), __('Your saved searches have been removed.', 'coop-library'), 'success');
          } catch(error) {
            addNotification(__('Saved searches not removed', 'coop-library'), __('Your saved searches could not be removed.', 'coop-library'), 'error');
          }
        },
      });
    }
    document.addEventListener('click', (event) => {
      if (!event.target.classList.contains('remove-saved-search')) return;
      try {
        const length = document.querySelectorAll('.saved-search').length;
        const key = event.target.dataset.key;
        let savedSearches = localStorage.getItem('saved-searches');
        savedSearches = savedSearches ? JSON.parse(savedSearches) : {};
        delete savedSearches[key];
        localStorage.setItem('saved-searches', JSON.stringify(savedSearches));
        event.target.parentNode.parentNode.parentNode.removeChild(event.target.parentNode.parentNode);
        if (length === 1) {
          removeAllButton.parentNode.removeChild(removeAllButton);
        }
        addNotification(__('Saved search removed', 'coop-library'), __('Your saved search has been removed.', 'coop-library'), 'success');
      } catch(error) {
        addNotification(__('Saved search not removed', 'coop-library'), __('Your saved search could not be removed.', 'coop-library'), 'error');
      }
    });
  },
  finalize() {
    // JavaScript to be fired on the Saved Searches page, after the init JS
  },
};
