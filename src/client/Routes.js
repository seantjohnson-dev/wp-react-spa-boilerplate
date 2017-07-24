import React from 'react'
import { Router, Route, IndexRoute } from 'react-router'
import ReactGA from 'react-ga'
import Root from './containers/Root/Root'
import Posts from './containers/Posts/Posts'
import Post from './containers/Post/Post'
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
        <Route path='/post/:slug' component={Post} />
        <Route path='/posts(/:page)' component={Posts} />
        <Route path='/:slug' component={Page} />
        <Route path='*' component={NoMatch} />
      </Route>
    </Router>
  )
}

export default Routes
