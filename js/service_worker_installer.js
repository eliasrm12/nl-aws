//Localizacion de la pagina
let href = window.location.origin + window.location.pathname;


  // Register Service Worker
  if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register(href + "sw.js",{scope: './'})
  .then((reg) => {
    // registration worked
    console.log('Registration Service Worker succeeded.');
  }).catch((error) => {
    // registration failed
    console.log('Registration failed with ' + error);
  });
}


/*
  Se crea la funcion para mostrar/ocultar el boton de pwa
*/
const Installer = function(root) {
  let promptEvent;

  const install = function(e) {
    if(promptEvent) {
    promptEvent.prompt();
    promptEvent.userChoice
      .then(function(choiceResult) {
      // The user actioned the prompt (good or bad).
      // good is handled in
      promptEvent = null;
      root.classList.remove('available');
      })
      .catch(function(installError) {
      // Boo. update the UI.
      promptEvent = null;
      root.classList.remove('available');
      });
    }
  };

  const installed = function(e) {
    promptEvent = null;
    // This fires after onbeforinstallprompt OR after manual add to homescreen.
    root.classList.remove('available');
  };

  const beforeinstallprompt = function(e) {
    promptEvent = e;
    promptEvent.preventDefault();
    root.classList.add('available');
    return false;
  };

  // Se ponen a la escucha los eventos 

  window.addEventListener('beforeinstallprompt', beforeinstallprompt);
  window.addEventListener('appinstalled', installed);

  // El .bind() especifica que sera el this
  root.addEventListener('click', install.bind(this)); 
  root.addEventListener('touchend', install.bind(this));
};

window.addEventListener('load', function() {
const installEl = document.getElementById('install');
const installer = new Installer(installEl);



});