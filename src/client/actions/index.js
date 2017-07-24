
import moment from 'moment';
import {
  WP_API,
  WP_POSTS_PER_PAGE,
  WP_PAGE_ON_FRONT,
  WP_PAGE_FOR_POSTS,
  WP_NONCE,

  REQUEST_API,
  REQUEST_MENU_BY_ID,
  REQUEST_MENU_BY_LOCATION,
  REQUEST_PAGE_BY_ID,
  REQUEST_PAGE_BY_SLUG,
  REQUEST_ARCHIVE_BY_SLUG,
  REQUEST_ARCHIVE_BY_ID,
  REQUEST_ARCHIVES,

  RECEIVE_MENU,
  RECEIVE_MENU_ITEMS,
  RECEIVE_PAGE,
  RECEIVE_ARCHIVE,
  RECEIVE_ARCHIVES
} from '../constants'

import wp from '../api'


function requestApi (loading) {
  return {
    type: REQUEST_API,
    payload: {
      loading: loading
    }
  }
}


function receivePage (page) {
  return {
    type: RECEIVE_PAGE,
    payload: {
      page: page
    }
  }
}

function requestPageBySlug(slug) {
  return {
    type: REQUEST_PAGE_BY_SLUG,
    payload: {
      slug: slug
    }
  }
}

function requestPageByID(id) {
  return {
    type: REQUEST_PAGE_BY_ID,
    payload: {
      id: id
    }
  }
}

function receiveArchive (archive) {
  return {
    type: RECEIVE_ARCHIVE,
    payload: {
      archive: archive
    }
  }
}

function requestArchiveBySlug(slug) {
  return {
    type: REQUEST_ARCHIVE_BY_SLUG,
    payload: {
      slug: slug
    }
  }
}

function requestArchiveByID(id) {
  return {
    type: REQUEST_ARCHIVE_BY_ID,
    payload: {
      id: id
    }
  }
}

function requestArchives(state = {
  pageNum: 1
}) {
  return {
    type: REQUEST_ARCHIVES,
    payload: {
      ...state
    }
  }
}

function receiveArchives(state = {
    pageNum: 1,
    totalPages: 0,
    posts: {}
  }) {
  return {
    type: RECEIVE_ARCHIVES,
    payload: {
      ...state
    }
  }
}

function receiveMenu (menu = {}) {
  return {
    type: RECEIVE_MENU,
    payload: {
      menu: menu
    }
  }
}

function receiveMenuItems(items) {
  return {
    type: RECEIVE_MENU_ITEMS,
    payload: {
      menu: {
        items: items
      }
    }
  }
}

function requestMenuByLocation(state = {
    loading: true,
    items: []
  }) {
  return {
    type: REQUEST_MENU_BY_LOCATION,
    payload: {
      ...state
    }
  }
}

function requestMenuByID(state = {
    loading: true,
    menu: false
  }) {
  return {
    type: REQUEST_MENU_BY_ID,
    payload: {
      ...state
    }
  }
}

export const getArchives = (pageNum = 1) => {
  return (dispatch, getState) => {
    const state = getState().data.archives;
    const fetchedPage = (state.pagination.hasOwnProperty(pageNum));
    if (fetchedPage) return;

    dispatch(requestArchives(Object.assign({}, state, {pageNum})));

    return wp.posts()
    .page(pageNum)
    .perPage(WP_POSTS_PER_PAGE)
    .order('desc')
    .embed().then((res) => {
      let totalPages = 0;
      if (res && res._paging && res._paging.totalPages) {
        totalPages = parseInt(res._paging.totalPages);
      }
      dispatch(receiveArchives(Object.assign({}, state, {totalPages, pageNum, posts: res})))
    }).catch((err) => console.log(err));
  }
}

export const getArchiveBySlug = (slug) => {
  return (dispatch, getState) => {
    dispatch(requestArchiveBySlug(slug));

    return wp.posts().slug(slug).embed().then((res) => {
      dispatch(receiveArchive(res[0]))
    }).catch((err) => console.log(err));
  }
}

export const getArchiveByID = (id) => {
  return function (dispatch) {
    dispatch(requestArchiveByID(id))

    return wp.posts().id(id).embed().then((res) => {
      dispatch(receiveArchive(res))
    }).catch((err) => console.log(err))
  }
}

export const getPageBySlug = (slug) => {
  return (dispatch, getState) => {
    dispatch(requestPageBySlug(slug))

    return wp.pages().slug(slug).embed().then((res) => {
      dispatch(receivePage(res[0]))
    }).catch((err) => console.log(err))
  }
}

export const getPageByID = (id) => {
  return (dispatch, getState) => {
    dispatch(requestPageByID(id))

    return wp.pages().id(id).embed().then((res) => {
      dispatch(receivePage(res))
    }).catch((err) => console.log(err))
  }
}

export function getMenuByLocation( location = 'primary_navigation' ) {
  return ( dispatch, getState ) => {
    dispatch(requestMenuByLocation(location))

    return wp.menus().location(location).embed().then((res) => {
      dispatch(receiveMenu(res))
    }).catch((err) => console.log(err))
  }
}

// export function fetchAppRouteData() {
//   return ( dispatch, getState ) => {
//     dispatch(requestMenuByLocation(location))

//     return wp.menus().location(location).embed().then((res) => {
//       dispatch(receiveMenu(res))
//     }).catch((err) => console.log(err))
//   }
// }
