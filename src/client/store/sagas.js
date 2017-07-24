import { wpSagas } from './kasia'

export default function * () {
  yield [
    ...wpSagas
    // your sagas go here, e.g. fork(someSagaGenerator)
  ]
}
