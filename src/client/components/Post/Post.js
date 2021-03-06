import React from 'react'
import styles from './Post.module.scss'

const Post = (props) => {
  const renderMedia = (media = {}) => {
    if (Object.keys(media).length) {
      return (
        <div styleName="post-thumb-wrap">
          <img src={media.file} alt={media.alt_text} title={media.title.rendered} className={(media.vertical) ? "portrait" : "landscape"} styleName="feat-image"/>
        </div>
      );
    }
    return '';
  }
  return (
    <article styleName="post-detail" key={props.id}>
      {renderMedia(props.media)}
      {props.children}
    </article>
  )
}

export default Post
