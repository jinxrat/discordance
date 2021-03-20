module.exports = {
	entry: {
		'/': './discordance.js'
	},
	output: {
		path: __dirname,
		filename: 'js/discordance.min.js',
	},
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				use: { 
					loader: "babel-loader",
				},
				exclude: /(node_modules|bower_components)/,
			},
			{ test: /\.svg$/, loader: 'svg-react-loader' }
		]
	}
};