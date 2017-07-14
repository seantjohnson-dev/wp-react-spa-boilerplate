import React from 'react'
import styles from './Loader.module.scss'

const Loader = (props) => {

  let Tag = (props.tag) ? props.tag : 'div';

  return (
    <Tag styleName="loader">
      <div styleName="spinner"></div>
      <div styleName="message">{props.message || "Loading..." }</div>
    </Tag>
  )
}

export default Loader
