import React from 'react'
import { Link } from 'react-router'
import { WP_SITE_TITLE } from '../../constants'
import styles from './Header.module.scss'

const Header = () => {
  return (
    <header id="header" styleName="header">
      <div className="container">
        <h1 styleName="header-logo">
          <Link styleName="logo-link" to='/'>{WP_SITE_TITLE}</Link>
        </h1>
        <nav styleName="main-nav">
          <ul styleName='nav-list'>
            <li styleName="nav-item">
              <Link styleName="nav-link" to='/archives'>Posts</Link>
            </li>
            <li styleName="nav-item">
              <Link styleName="nav-link" to='/sample-page'>Sample page</Link>
            </li>
          </ul>
        </nav>
      </div>
    </header>
  )
}

export default Header
