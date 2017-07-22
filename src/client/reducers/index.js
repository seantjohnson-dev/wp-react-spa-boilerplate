import { combineReducers } from 'redux'
import { routerReducer } from 'react-router-redux'
import omit from 'lodash/omit'
import {
  REQUEST_API,
  REQUEST_ARCHIVES,
  REQUEST_MENU_BY_ID,
  REQUEST_MENU_BY_LOCATION,
  REQUEST_ARCHIVE_BY_SLUG,
  REQUEST_ARCHIVE_BY_ID,
  REQUEST_PAGE_BY_SLUG,
  REQUEST_PAGE_BY_ID,

  RECEIVE_ARCHIVES,
  RECEIVE_ARCHIVE,
  RECEIVE_PAGE,
  RECEIVE_MENU,
  RECEIVE_MENU_ITEMS
} from '../constants'

function isLoading (state = true, action) {
  switch (action.type) {
    case REQUEST_API:
    case REQUEST_ARCHIVES:
    case REQUEST_MENU_BY_ID:
    case REQUEST_MENU_BY_LOCATION:
    case REQUEST_ARCHIVE_BY_SLUG:
    case REQUEST_ARCHIVE_BY_ID:
    case REQUEST_PAGE_BY_SLUG:
    case REQUEST_PAGE_BY_ID:
      return true
    case RECEIVE_ARCHIVES:
    case RECEIVE_ARCHIVE:
    case RECEIVE_PAGE:
    case RECEIVE_MENU:
    case RECEIVE_MENU_ITEMS:
      return false
    default:
      return state
  }
}

// const app = (state = {
//     loading: false,
//     ready: false,
//     loadingStatus: {
//       page: {
//         loading: false,
//         ready: false
//       },
//       archives: {
//         loading: false,
//         ready: false
//       },,
//       archive: {
//         loading: false,
//         ready: false
//       },,
//       menus: {
//         loading: false,
//         ready: false
//       }
//     }
//   }, action) => {
//   switch (action.type) {
//     case REQUEST_ARCHIVES:
//       const loadingStatus = Object.assign({}, state.loadingStatus, {
//         archives: Object.assign({}, state.loadingStatus.archives, {
//           loading: true
//         });
//       });
//       return Object.assign({}, state, {
//         loading: true,
//         loadingStatus: loadingStatus
//       });
//     case REQUEST_PAGE_BY_ID:
//     case REQUEST_PAGE_BY_SLUG:
//       const loadingStatus = Object.assign({}, state.loadingStatus, {
//         page: Object.assign({}, state.loadingStatus.page, {
//           loading: true
//         });
//       });
//       return Object.assign({}, state, {
//         loading: true,
//         loadingStatus: loadingStatus
//       });
//     case REQUEST_ARCHIVE_BY_ID:
//     case REQUEST_ARCHIVE_BY_SLUG:
//       const loadingStatus = Object.assign({}, state.loadingStatus, {
//         archive: Object.assign({}, state.loadingStatus.archive, {
//           loading: true
//         });
//       });
//       return Object.assign({}, state, {
//         loading: true,
//         loadingStatus: loadingStatus
//       });
//     case REQUEST_MENU_BY_LOCATION:
//     case REQUEST_MENU_BY_ID:
//       const loadingStatus = Object.assign({}, state.loadingStatus, {
//         menus: Object.assign({}, state.loadingStatus.menus, {
//           loading: true
//         });
//       });
//       return Object.assign({}, state, {
//         loading: true,
//         loadingStatus: loadingStatus
//       });
//     case RECEIVE_ARCHIVES:
//       const loadingStatus = Object.assign({}, state.loadingStatus, {
//         archives: Object.assign({}, state.loadingStatus.archives, {
//           loading: false,
//           ready: true
//         });
//       });
//       Object.keys(state.loadingStatus).map((key, value) => {

//       });
//       return Object.assign({}, state, {
//         loading: true,
//         loadingStatus: loadingStatus
//       });
//     case RECEIVE_ARCHIVE:
//     case RECEIVE_PAGE:
//     case RECEIVE_MENU:
//     case RECEIVE_MENU_ITEMS:

//       return Object.assign({}, state, {
//         loading: false,
//         ready: true
//       });
//     default:
//       return state
//   }
// }

const archives = (
  state = {
    loading: false,
    posts: {},
    pagination: {},
    pageNum: 1,
    totalPages: 0
  }, action) => {
  switch (action.type) {
    case REQUEST_ARCHIVES:
      return Object.assign({}, state, {
        loading: true
      });
    case RECEIVE_ARCHIVES:
      let {pageNum, totalPages} = action.payload;
      let origPosts = omit(action.payload.posts, ['_paging']);
      var _post_ids = [];
      let _posts = {};
      Object.keys(origPosts).forEach((key, index) => {
        let id = origPosts[index].id;
        _post_ids.push(id);
        _posts[id] = origPosts[index]
      });
      let pagination = {};
      pagination[pageNum] = _post_ids;
      const pagedObj = Object.assign({}, state.pagination, pagination);
      // pageNum = (pageNum < parseInt(totalPages)) ? pageNum + 1 : pageNum;
      return Object.assign({}, state, {
        loading: false,
        posts: {
          ...state.posts,
          ..._posts
        },
        pagination: pagedObj,
        pageNum: pageNum,
        totalPages: totalPages
      });
    default:
      return state
  }
}

const archive = (
  state = {
    loading: true,
    archive: false
  }, action) => {
  switch(action.type) {
    case REQUEST_ARCHIVE_BY_SLUG:
    case REQUEST_ARCHIVE_BY_ID:
      return Object.assign({}, state, {
        loading: true
      });
    case RECEIVE_ARCHIVE:
      return Object.assign({}, state, {
        loading: false,
        archive: action.payload.archive
      });
    default:
      return state
  }
}

const page = (
  state = {
    loading: false,
    page: false
  }, action) => {
  switch (action.type) {
    case REQUEST_PAGE_BY_SLUG:
    case REQUEST_PAGE_BY_ID:
      return Object.assign({}, state, {
        loading: true
      });
    case RECEIVE_PAGE:
      return Object.assign({}, state, {
        loading: false,
        page: action.payload.page
      })
    default:
      return state
  }
}

const menus = (
  state = {
    loading: false,
    menu: {
      items: []
    }
  }, action ) => {
  switch ( action.type ) {
    case REQUEST_MENU_BY_LOCATION:
    case REQUEST_MENU_BY_ID:
      return Object.assign({}, state, {
        loading: true
      });
    case RECEIVE_MENU:
      return Object.assign({}, state, {
        loading: false,
        menu: action.payload.menu
      })
    case RECEIVE_MENU_ITEMS:
      return Object.assign({}, state, {
        loading: false,
        menu: action.payload.menu
      })
    default:
      return state
  }

  return {...state}
}

const data = combineReducers({
  isLoading,
  menus: menus,
  page: page,
  archives: archives,
  archive: archive
})

const rootReducer = combineReducers({
  data,
  routing: routerReducer
})

export default rootReducer
