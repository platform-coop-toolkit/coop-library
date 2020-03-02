// import external dependencies
import 'wicg-inert';

// import local dependencies
import Router from './util/Router';
import {ready} from './util/Ready';
import common from './routes/common';
import pageTemplatePageFavorites from './routes/favorites';
import pageTemplatePageSavedSearches from './routes/saved-searches';
import home from './routes/home';
import archive from './routes/archive';
import single from './routes/single';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // Archive page
  archive,
  // Single resource
  single,
  // Favorites page
  pageTemplatePageFavorites,
  // Saved Searches page
  pageTemplatePageSavedSearches,
});

// Load Events
ready(() => routes.loadEvents());
