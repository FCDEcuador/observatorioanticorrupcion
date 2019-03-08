let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |


/******************************************************************************************

	BLAUDCMS BACKEND ASSETS

*******************************************************************************************/

	// JS
	
	mix.copy('resources/assets/backend/js/chat.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/custom.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/dashboard1.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/dashboard2.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/dashboard3.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/dashboard4.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/flot-data.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/footable-init.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/jasny-bootstrap.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/jquery.PrintArea.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/jquery.slimscroll.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/jsgrid-init.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/mask.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/morris-data.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/perfect-scrollbar.jquery.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/sidebarmenu.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/toastr.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/ui-sweetalert.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/validation.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/validator.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/waves.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/widget-charts.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/widget-data.js', 'public/backend/assets/js')
	   .minify('public/backend/assets/js/chat.js')
	   .minify('public/backend/assets/js/custom.js')
	   .minify('public/backend/assets/js/dashboard1.js')
	   .minify('public/backend/assets/js/dashboard2.js')
	   .minify('public/backend/assets/js/dashboard3.js')
	   .minify('public/backend/assets/js/dashboard4.js')
	   .minify('public/backend/assets/js/flot-data.js')
	   .minify('public/backend/assets/js/footable-init.js')
	   .minify('public/backend/assets/js/jasny-bootstrap.js')
	   .minify('public/backend/assets/js/jquery.PrintArea.js')
	   .minify('public/backend/assets/js/jquery.slimscroll.js')
	   .minify('public/backend/assets/js/jsgrid-init.js')
	   .minify('public/backend/assets/js/mask.js')
	   .minify('public/backend/assets/js/morris-data.js')
	   .minify('public/backend/assets/js/sidebarmenu.js')
	   .minify('public/backend/assets/js/toastr.js')
	   .minify('public/backend/assets/js/ui-sweetalert.js')
	   .minify('public/backend/assets/js/validation.js')
	   .minify('public/backend/assets/js/validator.js')
	   .minify('public/backend/assets/js/waves.js')
	   .minify('public/backend/assets/js/widget-charts.js')
	   .minify('public/backend/assets/js/widget-data.js')
	   

	   // PAGES
	   		// Meta Tags
			   	.copy('resources/assets/backend/js/pages/meta-tags-list.js', 'public/backend/assets/js/pages')
			   	.minify('public/backend/assets/js/pages/meta-tags-list.js')
		   // Roles
			   	.copy('resources/assets/backend/js/pages/roles-list.js', 'public/backend/assets/js/pages')
			   	.minify('public/backend/assets/js/pages/roles-list.js')
			// Usuarios
			   	.copy('resources/assets/backend/js/pages/users-list.js', 'public/backend/assets/js/pages')
			   	.minify('public/backend/assets/js/pages/users-list.js')
	   // FORM VALIDATE
	   		// Login
			   	.copy('resources/assets/backend/js/form-validation/form-validation-login.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-login.js')
			// Profile
			   	.copy('resources/assets/backend/js/form-validation/form-validation-profile.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-profile.js')
			// Config
			   	.copy('resources/assets/backend/js/form-validation/form-validation-config.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-config.js')
			// Meta Tags
			   	.copy('resources/assets/backend/js/form-validation/form-validation-meta-tag.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-meta-tag.js')
			// Provincias
			   	.copy('resources/assets/backend/js/form-validation/form-validation-province.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-province.js')
			// Roles
			   	.copy('resources/assets/backend/js/form-validation/form-validation-roles.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-roles.js')
			// Usuarios
			   	.copy('resources/assets/backend/js/form-validation/form-validation-users.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-users.js')
			// Casos de Corrupcion
			   	.copy('resources/assets/backend/js/form-validation/form-validation-corruption-case.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-corruption-case.js')
			// Historias de Exito
			   	.copy('resources/assets/backend/js/form-validation/form-validation-success-story.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-success-story.js')
			// Biblioteca Legal
			   	.copy('resources/assets/backend/js/form-validation/form-validation-legal-library.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-legal-library.js')
			// Categorias de Contenido
			   	.copy('resources/assets/backend/js/form-validation/form-validation-content-category.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-content-category.js')
			// Articulos de Contenido
			   	.copy('resources/assets/backend/js/form-validation/form-validation-content-articles.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-content-articles.js')
			// Items de Menu
			   	.copy('resources/assets/backend/js/form-validation/form-validation-menu-item.js', 'public/backend/assets/js/form-validate')
			   	.minify('public/backend/assets/js/form-validate/form-validation-menu-item.js');

	// SASS

		// Colors
	mix.sass('resources/assets/backend/scss/colors/blue-dark.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/blue.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/default-dark.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/default.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/green-dark.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/green.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/megna-dark.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/megna.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/purple-dark.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/purple.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/red-dark.scss', 'public/backend/assets/css/colors')
	   .sass('resources/assets/backend/scss/colors/red.scss', 'public/backend/assets/css/colors')
	   
	   // Pages
	   .sass('resources/assets/backend/scss/pages/bootstrap-switch.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/breadcrumb-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/card-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/chat-app-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/contact-app-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/dashboard1.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/dashboard2.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/dashboard3.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/dashboard4.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/easy-pie-chart.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/error-pages.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/file-upload.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/float-chart.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/floating-label.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/footable-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/form-icheck.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/google-vector-map.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/icon-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/inbox.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/login-register-lock.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/other-pages.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/pages.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/pricing-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/progressbar-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/ribbon-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/stylish-tooltip.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/tab-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/timeline-vertical-horizontal.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/ui-bootstrap-page.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/user-card.scss', 'public/backend/assets/css/pages')
	   .sass('resources/assets/backend/scss/pages/widget-page.scss', 'public/backend/assets/css/pages')

	   // Styles
	   .sass('resources/assets/backend/scss/style.scss', 'public/backend/assets/css');


/******************************************************************************************

	BLAUD FRONTEND ASSETS

*******************************************************************************************/
	// Items de Menu
	   	mix.copy('resources/assets/frontend/js/form-validation/form-validation-contact-form.js', 'public/frontend/js/form-validate')
	   	.minify('public/frontend/js/form-validate/form-validation-contact-form.js')

	// Detalle de Caso de Corrupcion
	   	.copy('resources/assets/frontend/js/pages/corruption-cases.js', 'public/frontend/js/pages')
	   	.minify('public/frontend/js/pages/corruption-cases.js');









