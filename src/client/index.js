import React from 'react'
import { render } from 'react-dom'
import { Provider } from 'react-redux'
import { browserHistory } from 'react-router'
import { syncHistoryWithStore } from 'react-router-redux'
import { AppContainer } from 'react-hot-loader'
import rootReducer from './reducers'
import configureStore from './store/configureStore'
import configureStoreExt from './store/configureStoreExt'
import Routes from './Routes'
import styles from './styles/global.scss'

const reduxExtension = false
const store = (reduxExtension) ? configureStoreExt(rootReducer) : configureStore(rootReducer)
const history = syncHistoryWithStore(browserHistory, store)
const rootElm = document.getElementById('root')

render(
  <AppContainer>
    <Provider store={store}>
      <Routes history={history} />
    </Provider>
  </AppContainer>,
  rootElm
)

if (module.hot) {
  module.hot.accept('./Routes', () => {
    const HotRoutes = require('./Routes').default
    render(
      <AppContainer>
        <Provider store={store}>
          <HotRoutes history={history} />
        </Provider>
      </AppContainer>,
      rootElm
    )
  })
}
