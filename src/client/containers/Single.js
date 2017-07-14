import React, { Component } from 'react'
import { connect } from 'react-redux'
import { getSingleByID } from '../actions'
import { WP_SITE_TITLE } from '../constants'
import Post from '../components/Post/Post'
import Loader from '../components/Loader/Loader'
import styles from '../components/Post/Post.module.scss'

class Single extends Component {
  componentWillMount () {
    const {
      getSingleByID,
      params
    } = this.props

    getSingleByID(params.id)
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
  const { single, isLoading } = state.data
  return {
    id: single.id,
    title: single.title,
    content: single.content,
    embedded: single.embedded,
    loading: isLoading
  }
}

export default connect(mapStateToProps, {getSingleByID})(Single)
