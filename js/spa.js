/*
--------------------
Se crea una funcion auto invocada
--------------------
*/
(function (window,document) {
	"use strict";
	var start = () =>{ 
		var element = null, 
			frame = null,
			routes = {},

			spa = { 
				getId : function(id){
					element = document.getElementById(id);
					return this;
				},

				router : function () {
					frame = element;
					return this;
				},

				route : function (route,template,action) {
					routes[route] = {
						'template' : template,
						'action' : action //Esta accion se carga una vez
											// sehaya cagado la vista
					};
					return this;
				},

				routesHandler : function () {
					let index = window.location.href.substring().lastIndexOf('/');
					let hash = window.location.href.substring(index), 

					source = routes[hash];

					if (source && source.template) {


						let href = window.location.origin + window.location.pathname;
						href =source.template;

						let myHeaders = new Headers({'Content-Type' : 'text/html'});
						fetch(href,{ mode: 'no-cors', method: 'get', headers: myHeaders })
						.then(response => { response.text().then(text => { 
							frame.innerHTML = text; 

								if (typeof(source.action)==='function') {
									source.action();
								}

						}) })
						.catch(err => { console.log(err) });

					}else{
						window.location.hash = '/'; // Crear pagina 404
					}
				}

		 	};
		return spa;
	}

	if (typeof window.spa === 'undefined') {
		window.spa = start();
		window.addEventListener('load', spa.routesHandler, false);
		window.addEventListener('hashchange', spa.routesHandler, false);
		window.addEventListener('beforeunload', spa.routesHandler, false);
	}else{
		console.log("Ya se llamó a spa.js");
	}

})(window,document);
