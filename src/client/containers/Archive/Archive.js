import React, { Component } from 'react'
import { connect } from 'react-redux'
import { getArchives } from '../../actions'
import { WP_SITE_TITLE } from '../../constants'
import Loader from '../../components/Loader/Loader'
import PostsListItem from '../../components/PostsListItem/PostsListItem'
import styles from '../../components/PostsListItem/PostsListItem.module.scss'
import { addUrlProps, UrlQueryParamTypes, subquery } from 'react-url-query'

class Archive extends Component {
  constructor(props) {
    super(props);

    this.handleNextClick = this.handleNextClick.bind(this);
  }
  componentDidMount () {
    this.props.getArchives(this.props.pageNum)
  }
  handleNextClick(e) {
    e.preventDefault()

    const nextPage = this.props.pageNum + 1;
    if (nextPage <= this.props.totalPages) {
      this.props.getArchives(nextPage);
    }
  }
  render () {
    const {posts, pagination, pageNum, totalPages, loading} = this.props;

    document.title = 'Archive | ' + WP_SITE_TITLE

    let btnText = (loading) ? "Fetching..." : "Load More";

    const allFetched = (Object.keys(pagination).length > 0 && Object.keys(pagination).length === totalPages);

    return (
      <section styleName="archive-list-wrap">
        {loading && <Loader/>}
        <div className="container">
          <ul styleName="posts-list" className="posts-list">
            {Object.values(posts).map((post, index) => {
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
        {(!allFetched) &&
          <div styleName="ajax-posts-btn-wrap" className="ajax-posts-btn-wrap">
            <button styleName="ajax-posts-btn" className="ajax-posts-btn" onClick={this.handleNextClick} disabled={(loading)}>{btnText}</button>
          </div>
        }
      </section>
    );
  }
}

function mapStateToProps (state) {
  const { archives } = state.data
  return {...archives}
}

export default connect(mapStateToProps, {getArchives})(Archive)
