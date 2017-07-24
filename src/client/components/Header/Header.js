import React from 'react'
import { Link } from 'react-router'
import { WP_SITE_TITLE } from '../../constants'
import styles from './Header.module.scss'
import PrimaryMenu from '../../containers/PrimaryMenu/PrimaryMenu'

const Header = (props) => {
  const {pathname} = props.location
  return (
    <header id="header" styleName="header">
      <div className="container">
        <h1 styleName="header-logo">
          <Link styleName="logo-link" to='/'>{WP_SITE_TITLE}</Link>
        </h1>
        <nav styleName="main-nav">
          <PrimaryMenu activePathName={pathname} />
        </nav>
      </div>
    </header>
  )
}

export default Header
