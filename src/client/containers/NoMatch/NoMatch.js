import React from 'react'
import { Link } from 'react-router'
import { WP_SITE_TITLE } from '../../constants'
import NotFound from '../../components/NotFound/NotFound'
import styles from '../../components/NotFound/NotFound.module.scss'

const NoMatch = ({ title = 'No Match Found' }) => {
  document.title = title + ' | ' + WP_SITE_TITLE

  return (
    <NotFound title="Error 404">
      <div styleName="not-found-content">
        <h6 styleName="error-code">Error 404</h6>
        <h1 styleName="error-description">Oops, something went wrong.</h1>
        <p styleName="error-help">click the button below to return back to the home page.</p>
        <Link className="btn btn-danger" styleName="not-found-home-button" to="/">Home</Link>
      </div>
    </NotFound>
  );
}

export default NoMatch
