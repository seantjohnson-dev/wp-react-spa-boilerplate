import React, { Component } from 'react'
import { connect } from 'react-redux'
import { getArchiveByID } from '../../actions'
import { WP_SITE_TITLE } from '../../constants'
import Post from '../../components/Post/Post'
import Loader from '../../components/Loader/Loader'
import styles from '../../components/Post/Post.module.scss'

class Single extends Component {
  componentDidMount () {
    const {
      getArchiveByID,
      params
    } = this.props

    getArchiveByID(params.id)
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
    const { loading, archive } = this.props

    if (!loading && archive) {

      var media = (parseInt(archive.featured_media) > 0) ? archive._embedded['wp:featuredmedia'][0] : false;

      document.title = WP_SITE_TITLE

      if (archive.title && archive.title.rendered) document.title = archive.title.rendered + ' | ' + WP_SITE_TITLE

      const postProps = {
        id: archive.id,
        title: archive.title.rendered,
        content: archive.content.rendered,
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
  const { archive, isLoading } = state.data
  return {
    archive: archive.archive,
    loading: (archive.loading || isLoading)
  }
}

export default connect(mapStateToProps, {getArchiveByID})(Single)
