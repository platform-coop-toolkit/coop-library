import { __ } from '@wordpress/i18n';

/**
 * Add a notification.
 *
 * @param {String} title
 * @param {String} content
 * @param {String} type
 */
export default (title, content, type) => {
  const pageHeader = document.querySelector('.page-header');
  let icon;
  switch(type) {
    case 'success':
      icon = '<svg class="icon icon--success" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g id="success" fill="currentColor"><path d="M10,0.9C5,0.9,0.9,5,0.9,10S5,19.1,10,19.1s9.1-4.1,9.1-9.1C19,5,15,1,10,0.9z M10,17.1c-3.9,0-7.1-3.2-7.1-7.1 S6.1,2.9,10,2.9s7.1,3.2,7.1,7.1l0,0C17.1,13.9,13.9,17.1,10,17.1z"/><path d="M14.7,7.3c-0.4-0.4-1-0.4-1.4,0L9,11.6L6.7,9.3c-0.4-0.4-1-0.4-1.4,0c-0.4,0.4-0.4,1,0,1.4c0,0,0,0,0,0l3,3 c0.4,0.4,1,0.4,1.4,0l5-5C15.1,8.3,15.1,7.7,14.7,7.3z"/></g></svg>';
      break;
    case 'warning':
      icon = '<svg class="icon icon--warning" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g id="warning" fill="currentColor"><path d="m10 1a9.05 9.05 0 1 0 9.05 9 9.06 9.06 0 0 0 -9.05-9zm0 16.1a7.05 7.05 0 1 1 7.05-7 7.05 7.05 0 0 1 -7.05 6.95z"/><path d="m10.09 5.59a1 1 0 0 0 -1 1v4a1 1 0 0 0 2 0v-4a1 1 0 0 0 -1-1z"/><path d="m10.11 12.6a1 1 0 1 0 1 1 1 1 0 0 0 -1-1z"/></g></svg>';
      break;
    case 'error':
      icon = '<svg class="icon icon--error" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g id="error" fill="currentColor"><path d="m10.09 1a9 9 0 1 0 9 9 9 9 0 0 0 -9-9zm0 16a7 7 0 1 1 7-7 7 7 0 0 1 -7 7z"/><path d="m12.85 7.18a1 1 0 0 0 -1.41 0l-1.35 1.35-1.35-1.35a1 1 0 0 0 -1.41 0 1 1 0 0 0 0 1.42l1.35 1.4-1.35 1.29a1 1 0 0 0 1.41 1.42l1.35-1.35 1.35 1.35a1 1 0 0 0 1.41-1.42l-1.35-1.29 1.35-1.4a1 1 0 0 0 0-1.42z"/></g></svg>';
      break;
    case 'info':
    default:
      icon = '<svg class="icon icon--info" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g id="info" fill="currentColor"><path d="m10 19.05a9.05 9.05 0 1 0 -9-9 9.06 9.06 0 0 0 9 9zm0-16.05a7.05 7.05 0 1 1 -7 7 7.05 7.05 0 0 1 7-7z"/><path d="m9.91 14.41a1 1 0 0 0 1-1v-4a1 1 0 0 0 -2 0v4a1 1 0 0 0 1 1z"/><path d="m9.89 7.4a1 1 0 1 0 -1-1 1 1 0 0 0 1 1z"/></g></svg>';
  }

  const alert = `
    <div class="notification notification--${type}" role="alert">
      <button class="button button--borderless"><svg class="icon icon--close" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path id="close" d="m11.41 10 4.3-4.29a1 1 0 1 0 -1.42-1.42l-4.29 4.3-4.29-4.3a1 1 0 0 0 -1.42 1.42l4.3 4.29-4.3 4.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4.29-4.3 4.29 4.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z" fill="currentColor"/></svg>
      <span class="screen-reader-text">${__('Close notification', 'coop-library')}</span></button>
      <p class="notification__title">${icon} ${title}</p>
      <div class="notification__content">${content}</div>
    </div>
  `;

  if (pageHeader.nextElementSibling.classList.contains('notification')) {
    pageHeader.nextElementSibling.parentNode.removeChild(pageHeader.nextElementSibling);
  }
  pageHeader.insertAdjacentHTML('afterend', alert);
};
