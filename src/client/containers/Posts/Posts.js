import React, {Component} from 'react'
import {connect} from 'react-redux'
import PostsListItem from '../../components/PostsListItem/PostsListItem'
import styles from '../../components/PostsListItem/PostsListItem.module.scss'
import Loader from '../../components/Loader/Loader'
import { connectWpQuery } from 'kasia/connect'
import parse from '../../helpers/htmlParser'
import query from './query'
import { Link } from 'react-router'

@connectWpQuery(query, (props, nextProps, state) => {
  if (props.params.page !== nextProps.params.page) {
    return true;
  }
  return false;
})
export default class Posts extends Component {
  constructor(props) {
    super(props);

    this.handleNextClick = this.handleNextClick.bind(this);
    this.state = {
      page: 1
    }
  }
  handleNextClick(e) {
    this.setState({
      page: (this.state.page + 1)
    });
    e.currentTarget.blur();
    document.body.focus();
  }
  render () {

    const { posts, pages } = this.props.kasia.data;

    let loading = (!pages || !posts) ? true : false;
    let btnText = (loading) ? "Fetching..." : "Load More";

    // const allPosts = (loading) ? undefined : this.props.wordpress.entities.posts;
    const page = (loading) ? undefined : Object.values(pages)[0]

    return (
      <section styleName="archive-list-wrap" style={this.props.style}>
        {loading &&
          <Loader />
        }
        <div className="container">
          {page &&
            <h2 className="archive-title">
              {page.title.rendered}
            </h2>
          }
          {page &&
            <div className="post-content">
              {parse(page.content)}
            </div>
          }
          <ul styleName="posts-list" className="posts-list">
            {posts && Object.values(posts).map((post, index) => {
              return (
                <PostsListItem
                  key={index}
                  id={post.id}
                  title={post.title}
                  date={post.date}
                  excerpt={post.excerpt}
                  slug={post.slug}/>
              );
            })}
          </ul>
        </div>
        <div styleName="ajax-posts-btn-wrap" className="ajax-posts-btn-wrap">
          <Link to={"/posts/" + (this.state.page + 1)} styleName="ajax-posts-btn" className="ajax-posts-btn" onClick={this.handleNextClick}>{btnText}</Link>
        </div>
      </section>
    )

  }
}
