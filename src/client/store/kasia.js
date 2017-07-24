import wp from '../api'
import kasia from 'kasia'
import KasiaWpApiAllTermsPlugin from 'kasia-plugin-wp-api-all-terms'
import KasiaWpApiMenusPlugin from 'kasia-plugin-wp-api-menus'
// import KasiaWpApiResponseModifyPlugin from 'kasia-plugin-wp-api-response-modify'

const { kasiaSagas, kasiaReducer } = kasia({
  wpapi: wp,
  debug: true,
  plugins: [
    KasiaWpApiMenusPlugin,
    KasiaWpApiAllTermsPlugin
    // KasiaWpApiResponseModifyPlugin
  ],
  contentTypes: [{
      name: 'Reports',
      plural: 'reports',
      slug: 'reports'
  }]
})

export {
  kasiaSagas as wpSagas,
  kasiaReducer as wpReducer
}
