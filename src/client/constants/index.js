const WP_PARAMS = global.WP_PARAMETERS

export const WP_URL = WP_PARAMS.API
export const WP_SITE_TITLE = WP_PARAMS.SITE_TITLE
export const WP_SITE_DESCRIPTION = WP_PARAMS.SITE_DESCRIPTION
export const WP_API = WP_PARAMS.API
export const WP_PAGE_FOR_POSTS = WP_PARAMS.PAGE_FOR_POSTS
export const WP_PAGE_ON_FRONT = WP_PARAMS.PAGE_ON_FRONT
export const WP_POSTS_PER_PAGE = WP_PARAMS.POSTS_PER_PAGE
export const GMAPS_API_KEY = WP_PARAMS.GMAPS_API_KEY
export const WP_NONCE = WP_PARAMS.NONCE

export const REQUEST_API = 'REQUEST_API'
export const REQUEST_ARCHIVES = 'REQUEST_ARCHIVES'
export const REQUEST_PAGE_BY_SLUG = 'REQUEST_PAGE_BY_SLUG'
export const REQUEST_PAGE_BY_ID = 'REQUEST_PAGE_BY_ID'
export const REQUEST_ARCHIVE_BY_ID = 'REQUEST_ARCHIVE_BY_ID'
export const REQUEST_ARCHIVE_BY_SLUG = 'REQUEST_ARCHIVE_BY_SLUG'
export const REQUEST_MENU_BY_LOCATION = 'REQUEST_MENU_BY_LOCATION'
export const REQUEST_MENU_BY_ID = 'REQUEST_MENU_BY_ID'

export const RECEIVE_ARCHIVES = 'RECEIVE_ARCHIVES'
export const RECEIVE_ARCHIVE = 'RECEIVE_ARCHIVE'
export const RECEIVE_PAGE = 'RECEIVE_PAGE'
export const RECEIVE_MENU = 'RECEIVE_MENU'
export const RECEIVE_MENU_ITEMS = 'RECEIVE_MENU_ITEMS'


export const ContentTypes = {
  Category: 'category',
  Comment: 'comment',
  Media: 'media',
  Page: 'page',
  Post: 'post',
  PostStatus: 'status',
  PostType: 'type',
  PostRevision: 'revision',
  Tag: 'tag',
  Taxonomy: 'taxonomy',
  User: 'user'
}

// Plural names of the built-in content types. These are used in determining the
// wpapi method to call when fetching a content type's respective data.
export const ContentTypesPlural = {
  [ContentTypes.Category]: 'categories',
  [ContentTypes.Comment]: 'comments',
  [ContentTypes.Media]: 'media',
  [ContentTypes.Page]: 'pages',
  [ContentTypes.Post]: 'posts',
  [ContentTypes.PostStatus]: 'statuses',
  [ContentTypes.PostType]: 'types',
  [ContentTypes.PostRevision]: 'revisions',
  [ContentTypes.Tag]: 'tags',
  [ContentTypes.Taxonomy]: 'taxonomies',
  [ContentTypes.User]: 'users'
}

// These content types do not have `id` properties.
export const ContentTypesWithoutId = [
  ContentTypes.Category,
  ContentTypes.PostType,
  ContentTypes.PostStatus,
  ContentTypes.Taxonomy
]
