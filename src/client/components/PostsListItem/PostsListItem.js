import React from 'react'
import { Link } from 'react-router'
import moment from 'moment'
import parse from '../../helpers/htmlParser'
import styles from './PostsListItem.module.scss'

const PostsListItem = ({ id, title, date, excerpt, slug }) => {

  const formatDate = (dateStr, format = 'MMMM DD, YYYY') => {
    let date = new Date(dateStr);
    return moment(date).format(format);
  }

  title = (title.rendered == "") ? 'Empty Title' : title.rendered;

  const url = `/post/${slug}`
  return (
    <li styleName="post-list-item">
      <Link styleName="post-item-link" to={url} key={id}>
        <h2 styleName="post-item-title" dangerouslySetInnerHTML={{__html: title}}/>
      </Link>
      <p>{formatDate(date)}</p>
      <div styleName="post-item-excerpt">
        {parse(excerpt)}
      </div>
    </li>
  )
}

export default PostsListItem
