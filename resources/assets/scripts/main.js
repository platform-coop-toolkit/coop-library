// import external dependencies

// import local dependencies
import Router from './util/Router';
import {ready} from './util/Ready';
import common from './routes/common';
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
});

// Load Events
ready(() => routes.loadEvents());
