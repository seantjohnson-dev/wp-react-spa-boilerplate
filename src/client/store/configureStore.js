import { createStore, applyMiddleware, compose } from 'redux'
// import thunk from 'redux-thunk'
import DevTools from '../components/DevTools/DevTools'
import rootSaga from './sagas'
import createSagaMiddleware from 'redux-saga'
import rootReducers from '../reducers'

export default function configureStore (initialState) {
  let store

  const sagaMiddleware = createSagaMiddleware()

  const createStoreWithMiddleware = applyMiddleware(sagaMiddleware)(createStore)

  if (process.env.NODE_ENV === 'production') {
    store = createStoreWithMiddleware(rootReducers, initialState)
  } else {
    const enhancer = compose(DevTools.instrument())
    store = createStoreWithMiddleware(rootReducers, initialState, enhancer)

    if (module.hot) {
      module.hot.accept('../reducers', () => {
        store.replaceReducer(require('../reducers').default)
      })
    }
  }
  sagaMiddleware.run(rootSaga)

  return {
    ...store,
    runSaga: sagaMiddleware.run
  }
}
