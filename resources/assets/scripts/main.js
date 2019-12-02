// import external dependencies
import 'jquery';
import * as Pinecone from '@platform-coop-toolkit/pinecone';
window.pinecone = Pinecone;

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import archive from './routes/archive';
import aboutUs from './routes/about';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // Archive page
  archive,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
