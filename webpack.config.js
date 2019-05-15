var Encore = require('@symfony/webpack-encore');

Encore
	//the project directory where compile assets will be stored
	.setOutputPath('public/buil')
	//the public path used by the webserver to access the previous directory
	.setPublicPath('/buil')
	.cleanupOutputBeforeBuild()
	.enableSourceMaps(!Encore.isProduction())

	//uncomment to define the assets of the project
	.addEntry('js/app','./assets/js/app.js')
	.addStyleEntry('css/app','./assets/css/global.scss')

	//uncoment if yu use sass/scaa files
	.enableSassLoader()

	//uncoment for legacy applications that require $/jQuery as a global

	.autoProvidejQuery()




;
module.exports = Encore.getWebpackConfig();