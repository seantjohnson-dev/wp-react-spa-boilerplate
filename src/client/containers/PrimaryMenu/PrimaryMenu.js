/**
 * # Primary Menu Component
 */

import React, { Component } from 'react'
import PropTypes from 'prop-types'
import { connect } from 'react-redux'

import MenuItem from '../../components/MenuItem/MenuItem'
import {SITE_URL, MAIN_MENU} from '../../constants'

import styles from './PrimaryMenu.module.scss'
// import {fetchThemeLocation} from 'kasia-plugin-wp-api-menus'

const getSlug = (url) => {
  return url.replace(SITE_URL, '')
}

// function mapStateToProps (state) {
//   const { menuLocations } = state.wordpress
//   return {
//     menu: (
//     menuLocations
//       && menuLocations.primary_navigation
//       || MAIN_MENU
//     )
//   }
// }

// function mapDispatchToProps (dispatch) {
//   return {
//     fetchMenu: (location) => dispatch(fetchThemeLocation(location))
//   }
// }

// @connect(mapStateToProps, mapDispatchToProps)
export default class PrimaryMenu extends Component {
  static propTypes = {
    activePathName: PropTypes.string.isRequired
  }
  // componentDidMount() {
  //   let {menu} = this.props;
  //   if (!menu) {
  //     this.props.fetchMenu('primary_navigation');
  //   }
  // }
  render () {
    let { activePathName } = this.props;

    // if (!menu) {
    //   menu = MAIN_MENU;
    // }
    return (
      <ul styleName="nav-list">
        {MAIN_MENU && MAIN_MENU.map((item, index) => {
          const slug = getSlug(item.url)
          const active = slug === activePathName
          return <MenuItem key={slug} item={item} active={active} to={slug} />
        })}
      </ul>
    )
  }
}
