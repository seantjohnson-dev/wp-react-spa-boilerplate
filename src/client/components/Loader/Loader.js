import React from 'react'
import styles from './Loader.module.scss'

const Loader = (props) => {

  let Tag = (props.tag) ? props.tag : 'div';
  let styles = (props.styles) ? Object.assign({}, props.styles) : {};

  return (
    <Tag styleName="loader" className="loader" style={styles}>
      <div styleName="message">{props.message || "Loading..." }</div>
      <div styleName="spinner"></div>
    </Tag>
  )
}

export default Loader
