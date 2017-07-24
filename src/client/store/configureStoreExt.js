import { createStore, applyMiddleware, combineReducers, compose } from 'redux'
// import thunk from 'redux-thunk'
import rootSaga from './sagas'
import createSagaMiddleware from 'redux-saga'
import rootReducers from '../reducers'

export default function configureStoreExt (initialState) {
  let store

  const sagaMiddleware = createSagaMiddleware()

  const createStoreWithMiddleware = applyMiddleware(sagaMiddleware)(createStore)

  const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose
  const enhancer = composeEnhancers(applyMiddleware(sagaMiddleware))
  store = createStore(rootReducers, enhancer)
  sagaMiddleware.run(rootSaga)

  if (module.hot) {
    module.hot.accept('../reducers', () => {
      store.replaceReducer(require('../reducers').default)
    })
  }

  return {
    ...store,
    runSaga: sagaMiddleware.run
  }
}
