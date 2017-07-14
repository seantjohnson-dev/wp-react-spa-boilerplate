import React from 'react'
import styles from './Post.module.scss'

const Post = (props) => {
  const renderMedia = (media = []) => {
    if (media.length) {
      const imgs = media.map((img, key) => {
        return (<img key={key} src={img.file} alt={img.alt_text} title={img.title} className={(img.vertical) ? "portrait" : "landscape"} styleName="feat-image"/>);
      });
      return (
        <div styleName="post-thumb-wrap">
          {imgs}
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
