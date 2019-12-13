wp.customize('blogname', (value) => {
  value.bind(to => document.querySelector('.brand').text(to));
});
