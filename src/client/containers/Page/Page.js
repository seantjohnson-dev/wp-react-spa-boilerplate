import React, {Component} from 'react'
import {connect} from 'react-redux'
import {getPageBySlug, getPageByID} from '../../actions'
import { WP_SITE_TITLE, WP_PAGE_ON_FRONT, WP_PAGE_FOR_POSTS } from '../../constants'
import PostContent from '../../components/PostContent/PostContent'
import Loader from '../../components/Loader/Loader'
import styles from '../../components/PostContent/PostContent.module.scss'
import parse from '../../helpers/htmlParser'
import { connectWpPost } from 'kasia/connect'
import ContentTypes from 'kasia/types'

@connectWpPost(ContentTypes.Page, (props) => {
  return (props.params.slug || 'homepage');
})
export default class Page extends Component {
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
    const { page } = this.props.kasia

    if (!page) {
      return <Loader />
    }

    var media = (parseInt(page.featured_media) > 0) ? page._embedded['wp:featuredmedia'][0] : false;

    const postProps = {
      id: page.id,
      title: page.title.rendered,
      content: page.content.rendered,
      media: this.getFeatMedia(media)
    };
    const children = parse(postProps.content)
    return (
      <PostContent {...postProps} style={this.props.style}>
        <div className="container">
          <div styleName="post-inner">
            <h2 styleName="post-title" dangerouslySetInnerHTML={{__html: postProps.title}}/>
            <div styleName="post-content" className="post-content">
              {children}
            </div>
          </div>
        </div>
      </PostContent>
    );
  }
}