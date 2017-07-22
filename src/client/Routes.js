import React from 'react'
import { Router, Route, IndexRoute } from 'react-router'
import ReactGA from 'react-ga'
import Root from './containers/Root/Root'
import Archive from './containers/Archive/Archive'
import Single from './containers/Single/Single'
import Page from './containers/Page/Page'
import NoMatch from './containers/NoMatch/NoMatch'

ReactGA.initialize('UA-000000-01')

function logPageView () {
  ReactGA.set({ page: window.location.pathname })
  ReactGA.pageview(window.location.pathname)
}

const Routes = ({ history }) => {
  return (
    <Router history={history} onUpdate={logPageView} key={Math.random()}>
      <Route path='/' component={Root}>
        <IndexRoute component={Page} />
        <Route path='sample-page' component={Page} />
        <Route path='archives' component={Archive} />
        <Route path='archives/:id' component={Single} />
        <Route path='*' component={NoMatch} />
      </Route>
    </Router>
  )
}

export default Routes
