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

	CUPONCITY BACKEND ASSETS

*******************************************************************************************/

	// JS
	
	mix.minify('resources/assets/backend/js/chat.js')
	   .minify('resources/assets/backend/js/custom.js')
	   .minify('resources/assets/backend/js/dashboard1.js')
	   .minify('resources/assets/backend/js/dashboard2.js')
	   .minify('resources/assets/backend/js/dashboard3.js')
	   .minify('resources/assets/backend/js/dashboard4.js')
	   .minify('resources/assets/backend/js/flot-data.js')
	   .minify('resources/assets/backend/js/footable-init.js')
	   .minify('resources/assets/backend/js/jasny-bootstrap.js')
	   .minify('resources/assets/backend/js/jquery.PrintArea.js')
	   .minify('resources/assets/backend/js/jquery.slimscroll.js')
	   .minify('resources/assets/backend/js/jsgrid-init.js')
	   .minify('resources/assets/backend/js/mask.js')
	   .minify('resources/assets/backend/js/morris-data.js')
	   .minify('resources/assets/backend/js/sidebarmenu.js')
	   .minify('resources/assets/backend/js/toastr.js')
	   .minify('resources/assets/backend/js/ui-sweetalert.js')
	   .minify('resources/assets/backend/js/validation.js')
	   .minify('resources/assets/backend/js/validator.js')
	   .minify('resources/assets/backend/js/waves.js')
	   .minify('resources/assets/backend/js/widget-charts.js')
	   .minify('resources/assets/backend/js/widget-data.js')
	   .copy('resources/assets/backend/js/chat.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/custom.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/dashboard1.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/dashboard2.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/dashboard3.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/dashboard4.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/flot-data.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/footable-init.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/jasny-bootstrap.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/jquery.PrintArea.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/jquery.slimscroll.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/jsgrid-init.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/mask.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/morris-data.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/perfect-scrollbar.jquery.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/sidebarmenu.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/toastr.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/ui-sweetalert.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/validation.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/validator.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/waves.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/widget-charts.min.js', 'public/backend/assets/js')
	   .copy('resources/assets/backend/js/widget-data.min.js', 'public/backend/assets/js')

	   // PAGES
	   		// Meta Tags
			   	.minify('resources/assets/backend/js/pages/meta-tags-list.js')
			   	.copy('resources/assets/backend/js/pages/meta-tags-list.min.js', 'public/backend/assets/js/pages')
		   // Roles
			   	.minify('resources/assets/backend/js/pages/roles-list.js')
			   	.copy('resources/assets/backend/js/pages/roles-list.min.js', 'public/backend/assets/js/pages')
			// Usuarios
			   	.minify('resources/assets/backend/js/pages/users-list.js')
			   	.copy('resources/assets/backend/js/pages/users-list.min.js', 'public/backend/assets/js/pages')
	   // FORM VALIDATE
	   		// Login
			   	.minify('resources/assets/backend/js/form-validation/form-validation-login.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-login.min.js', 'public/backend/assets/js/form-validate')
			// Profile
			   	.minify('resources/assets/backend/js/form-validation/form-validation-profile.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-profile.min.js', 'public/backend/assets/js/form-validate')
			// Config
			   	.minify('resources/assets/backend/js/form-validation/form-validation-config.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-config.min.js', 'public/backend/assets/js/form-validate')
			// Meta Tags
			   	.minify('resources/assets/backend/js/form-validation/form-validation-meta-tag.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-meta-tag.min.js', 'public/backend/assets/js/form-validate')
			// Roles
			   	.minify('resources/assets/backend/js/form-validation/form-validation-roles.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-roles.min.js', 'public/backend/assets/js/form-validate')
			// Usuarios
			   	.minify('resources/assets/backend/js/form-validation/form-validation-users.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-users.min.js', 'public/backend/assets/js/form-validate')
			// Casos de Corrupcion
				.minify('resources/assets/backend/js/form-validation/form-validation-corruption-case.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-corruption-case.min.js', 'public/backend/assets/js/form-validate')
			// Categorias de Contenido
				.minify('resources/assets/backend/js/form-validation/form-validation-content-category.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-content-category.min.js', 'public/backend/assets/js/form-validate')
			// Articulos de Contenido
				.minify('resources/assets/backend/js/form-validation/form-validation-content-articles.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-content-articles.min.js', 'public/backend/assets/js/form-validate')
			// Items de Menu
				.minify('resources/assets/backend/js/form-validation/form-validation-menu-item.js')
			   	.copy('resources/assets/backend/js/form-validation/form-validation-menu-item.min.js', 'public/backend/assets/js/form-validate');

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

	CUPONCITY FRONTEND ASSETS

*******************************************************************************************/










