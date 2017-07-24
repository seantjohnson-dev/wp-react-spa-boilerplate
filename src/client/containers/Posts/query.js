/**
 * Get the page with slug 'posts' and all Post content items.
 * @param {Object} wpapi WP-API interface
 * @param {Object} props Component's props
 * @returns {Promise}
 */
import {WP_POSTS_PER_PAGE} from '../../constants'

export default function PostsListingQuery(wpapi, props) {
  let page = typeof props.params.page !== 'undefined'
    ? Number(props.params.page)
    : 1

  page = page >= 2 ? page : 1

  const promises = [
    wpapi.pages().slug('posts').embed().get(),
    wpapi.posts().page(page).perPage(Number(WP_POSTS_PER_PAGE)).order('desc').embed().get()
  ]

  return Promise
    .all(promises)
    .then((results) => [].concat(...results))
}
