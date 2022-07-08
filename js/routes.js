(function (window , document) {
	
	spa.getId('view').router()
		.route('/','views/home.html', function(){
			setParallax(".welcome p");
		})
		.route('/gallery','views/gallery.html', function(){
			createProducts("js/info.json",'products',template);
		})
		.route('/blog', 'views/blog.html', function(){
			createProducts("blog/data_query.php",'post-container',template_blog);
		});	

})(window,document);




// Generating content based on the template
var template = "<div class='prod'>\n\
					<div class='con1'>\n\
					<h3>INFO</h3>\n\
						<img class='image' src='img/placeholder.png' data-src='SLUG' alt='NAME'>\n\
					</div>\n\
				</div>";

var template_blog = "<div class='post'>\n\
					<h3 class='title'>NAME</h3>\n\
					<img src='img/placeholder.png' data-src='SLUG' alt='NAME'>\n\
					<pre>INFO</pre>\n\
				</div>";


function createProducts(db,el,tem){
	let content = '';

	let href = window.location.origin + window.location.pathname;
	fetch(href+db).then(function(response) {
		return response.json();
	  })
	  .then(function(response){
		createProduct(response,tem);
	  })
	  .then(function(){
		document.getElementById(el).innerHTML = content;
		
		render();
	  });

	  async function createProduct(data,template) {
		await data.forEach(el => {

			var entry =  template.replace(/SLUG/g,el.img)
			.replace(/NAME/g,el.name)
			.replace(/INFO/g,el.datos);
			
			content += entry;
		});
		
	}

}

function render(){
	var imagesToLoad = document.querySelectorAll('img[data-src]');
	var loadImages = function(image) {
		image.setAttribute('src', image.getAttribute('data-src'));
		image.onload = function() {
			image.removeAttribute('data-src');
		};
	};

	if('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function(items, observer) {
			items.forEach(function(item) { 
				if(item.isIntersecting) {
					loadImages(item.target);
					observer.unobserve(item.target);
				}
			});
		});
		imagesToLoad.forEach(function(img) {
			observer.observe(img); 
		});
	}
	else {
		imagesToLoad.forEach(function(img) {
			loadImages(img);
		});
	}

}

function setParallax(element){

	window.addEventListener("scroll",()=>{
		
		var scrollval= window.pageYOffset;
		let elWithParallax = document.querySelector(element);
		if (isInPage(elWithParallax)) {
			elWithParallax.style.transform="translateY(-"+scrollval/1.5+"%)";
		}
	});
};

function isInPage(node){
	return (node === document.body) ? false : document.body.contains(node);
};
