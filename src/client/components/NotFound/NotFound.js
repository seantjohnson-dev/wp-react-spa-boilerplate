import React from 'react'
import { WP_SITE_TITLE } from '../../constants'
import styles from './NotFound.module.scss'

const NotFound = (props) => {
  document.title = props.title + ' | ' + WP_SITE_TITLE

  return (
    <section styleName="not-found-wrap">
      {props.children}
    </section>
  )
}

export default NotFound
