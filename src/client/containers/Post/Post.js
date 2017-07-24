import React, { Component } from 'react'
import { connectWpPost } from 'kasia/connect'
import ContentTypes from 'kasia/types'

import Loader from '../../components/Loader/Loader'
import PostContent from '../../components/PostContent/PostContent'
import parse from '../../helpers/htmlParser'

import styles from '../../components/PostContent/PostContent.module.scss'

@connectWpPost(ContentTypes.Post, (props) => {
  return props.params.slug;
})
export default class Post extends Component {
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
    const { post } = this.props.kasia

    if (!post) {
      return <Loader />
    }

    var media = (parseInt(post.featured_media) > 0) ? post._embedded['wp:featuredmedia'][0] : false;

    const postProps = {
      id: post.id,
      title: post.title.rendered,
      content: post.content.rendered,
      media: this.getFeatMedia(media)
    };
    const children = parse(postProps.content)
    return (
      <PostContent {...postProps}>
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
