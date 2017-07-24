import React, { Component } from 'react'
import { Link } from 'react-router'

import classNames from 'classnames'

import styles from './MenuItem.module.scss'

export default function MenuItem ({ item, to, active }) {
  const classes = classNames('nav-item', {
    ['active-nav-item']: active
  })

  return (
    <li key={item.ID} styleName={classes}>
      <Link to={to} styleName="nav-link">{item.title}</Link>
    </li>
  )
}
