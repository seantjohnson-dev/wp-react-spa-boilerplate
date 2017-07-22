import React from 'react'
import { Link } from 'react-router'
import moment from 'moment'
import styles from './PostsList.module.scss'

const PostsList = ({ id, title, date }) => {

  const formatDate = (dateStr, format = 'MMMM DD, YYYY') => {
    let date = new Date(dateStr);
    return moment(date).format(format);
  }

  title = (title.rendered == "") ? 'Empty Title' : title.rendered;

  const url = `archives/${id}`
  return (
    <Link styleName="postsList" to={url} key={id}>
      <h2 styleName="post-item-title" dangerouslySetInnerHTML={{__html: title}}/>
      <p>{formatDate(date)}</p>
    </Link>
  )
}

export default PostsList
