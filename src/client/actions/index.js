import {
  REQUEST_API,
  RECEIVE_ARCHIVES,
  RECEIVE_PAGE,
  WP_API,
  WP_POSTS_PER_PAGE,
  WP_PAGE_ON_FRONT
} from '../constants'

import Wpapi from 'wpapi'
const wp = new Wpapi({ endpoint: WP_API })

function requestApi (loading) {
  return {
    type: REQUEST_API,
    payload: {
      loading: loading
    }
  }
}

function receiveArchive (pageNum, totalPages, posts) {
  return {
    type: RECEIVE_ARCHIVES,
    payload: {
      pageNum: pageNum,
      totalPages: totalPages,
      posts: posts
    }
  }
}

function receivePage (id, title, content, embedded) {
  return {
    type: RECEIVE_PAGE,
    payload: {
      id: id,
      title: title,
      content: content,
      embedded: embedded
    }
  }
}

export const getArchive = (pageNum = 1, totalPages, posts) => {
  return (dispatch, getState) => {
    if (getState().data.archive.posts.length !== 0) return
    dispatch(requestApi(true))

    return wp.posts().page(pageNum).perPage(WP_POSTS_PER_PAGE).embed().then((res) => {
      const totalPages = res._paging.totalPages
      dispatch(receiveArchive(pageNum, totalPages, res))
    }).catch((err) => console.log(err))
  }
}

export const getSingleByID = (id) => {
  return function (dispatch) {
    dispatch(requestApi(true))

    return wp.posts().id(id).embed().then((res) => {
      dispatch(receivePage(res.id, res.title.rendered, res.content.rendered, res._embedded))
    }).catch((err) => console.log(err))
  }
}

export const getPageBySlug = (slug) => {
  return (dispatch, getState) => {
    dispatch(requestApi(true))

    return wp.pages().slug(slug).embed().then((res) => {
      dispatch(receivePage(res[0].id, res[0].title.rendered, res[0].content.rendered, res._embedded))
    }).catch((err) => console.log(err))
  }
}

export const getPageByID = (id) => {
  return (dispatch, getState) => {
    dispatch(requestApi(true))

    return wp.pages().id(id).embed().then((res) => {
      dispatch(receivePage(res.id, res.title.rendered, res.content.rendered, res._embedded))
    }).catch((err) => console.log(err))
  }
}
