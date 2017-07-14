import { createStore, applyMiddleware, compose } from 'redux'
import thunk from 'redux-thunk'

export default function configureStoreExt (reducer, initialState) {
  let store

  const createStoreWithMiddleware = applyMiddleware(thunk)(createStore)

  if (process.env.NODE_ENV === 'production') {
    store = createStoreWithMiddleware(reducer, initialState)
  } else {
    const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose
    const enhancer = composeEnhancers(applyMiddleware(thunk))
    store = createStore(reducer, enhancer)

    if (module.hot) {
      module.hot.accept('../reducers', () => {
        store.replaceReducer(require('../reducers').default)
      })
    }
  }

  return store
}
