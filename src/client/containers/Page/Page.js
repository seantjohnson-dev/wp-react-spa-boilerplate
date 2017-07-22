import React, {Component} from 'react'
import {connect} from 'react-redux'
import {getPageBySlug, getPageByID} from '../../actions'
import { WP_SITE_TITLE, WP_PAGE_ON_FRONT, WP_PAGE_FOR_POSTS } from '../../constants'
import Post from '../../components/Post/Post'
import Loader from '../../components/Loader/Loader'
import styles from '../../components/Post/Post.module.scss'

class Page extends Component {
  componentDidMount () {
    this.fetchPage(this.props.location.pathname);
  }
  componentWillReceiveProps(nextProps) {
    if (this.props.location.pathname !== nextProps.location.pathname) {
      this.fetchPage(nextProps.location.pathname);
    }
  }
  fetchPage(slug) {
    const {
      getPageByID,
      getPageBySlug
    } = this.props

    if (slug == '/') {
      if (parseInt(WP_PAGE_ON_FRONT) > 0) {
        getPageByID(WP_PAGE_ON_FRONT);
      } else {
        getPageByID(WP_PAGE_FOR_POSTS);
      }
    } else {
      getPageBySlug(slug.replace('/', ''))
    }
  }
  getFeatMedia(obj = {}) {
    if (Object.keys(obj).length) {
      return {
        title: (obj.title.rendered) ? obj.title.rendered : obj.title,
        caption: (obj.caption.rendered) ? obj.caption.rendered : obj.caption,
        alt: obj.alt_text,
        width: obj.media_details.width,
        height: obj.media_details.height,
        file: obj.source_url,
        sizes: obj.media_details.sizes,
        vertical: (obj.media_details.height > obj.media_details.width)
      };
    }
    return false;
  }
  render () {
    const { loading, page } = this.props

    if (!loading && page) {

      document.title = WP_SITE_TITLE

      if (page.title && page.title.rendered) document.title = page.title.rendered + ' | ' + WP_SITE_TITLE

      var media = (parseInt(page.featured_media) > 0) ? page._embedded['wp:featuredmedia'][0] : false;

      const postProps = {
        id: page.id,
        title: page.title.rendered,
        content: page.content.rendered,
        media: this.getFeatMedia(media)
      };
      return (
        <Post {...postProps}>
          <div className="container" styleName="content-wrap">
            <div styleName="post-inner">
              <h2 styleName="post-title" dangerouslySetInnerHTML={{__html: postProps.title}}/>
              <div styleName="post-content" className="post-content" dangerouslySetInnerHTML={{__html: postProps.content}} />
            </div>
          </div>
        </Post>
      );
    }
    return (<Loader />);
  }
}

function mapStateToProps (state) {
  const { page, isLoading } = state.data
  return {
    page:page.page,
    loading: (page.loading || isLoading)
  }
}

export default connect(mapStateToProps, {getPageByID, getPageBySlug})(Page)
