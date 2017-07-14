import React, {Component} from 'react'
import {connect} from 'react-redux'
import {getPageBySlug, getPageByID} from '../actions'
import { WP_SITE_TITLE, WP_PAGE_ON_FRONT, WP_PAGE_FOR_POSTS } from '../constants'
import Post from '../components/Post/Post'
import Loader from '../components/Loader/Loader'
import styles from '../components/Post/Post.module.scss'

class Page extends Component {
  componentWillMount () {
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
  getFeatMedia(featMedia = []) {
    var media = [];
    if (featMedia.length) {
      media = featMedia.map((obj, key) => {
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
      });
    }
    return media;
  }
  render () {
    const { loading, id, title, content, embedded } = this.props

    document.title = WP_SITE_TITLE

    if (title) document.title = title + ' | ' + WP_SITE_TITLE

    if (loading) {
      return (<Loader />);
    } else {
      const mediaArray = (embedded && Array.isArray(embedded['wp:featuredmedia']) && embedded['wp:featuredmedia'].length) ? embedded['wp:featuredmedia'] : [];
      const media = this.getFeatMedia(mediaArray);

      const postProps = {
        id,
        title,
        content,
        media
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
  }
}

function mapStateToProps (state) {
  const { page, isLoading } = state.data
  return {
    id: page.id,
    title: page.title,
    content: page.content,
    embedded: page.embedded,
    loading: isLoading
  }
}

export default connect(mapStateToProps, {getPageByID, getPageBySlug})(Page)
