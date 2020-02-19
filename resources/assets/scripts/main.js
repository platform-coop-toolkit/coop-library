// import external dependencies
import 'wicg-inert';

// import local dependencies
import Router from './util/Router';
import {ready} from './util/Ready';
import common from './routes/common';
import pageFavorites from './routes/favorites';
import home from './routes/home';
import archive from './routes/archive';
import search from './routes/archive';
import single from './routes/single';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // Archive page
  archive,
  // Search results page
  search,
  // Single resource
  single,
  // Favorites page
  pageFavorites,
});

// Load Events
ready(() => routes.loadEvents());
