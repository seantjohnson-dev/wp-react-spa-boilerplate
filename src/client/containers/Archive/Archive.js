import React, { Component } from 'react'
import { connect } from 'react-redux'
import { getArchives } from '../../actions'
import { WP_SITE_TITLE } from '../../constants'
import Loader from '../../components/Loader/Loader'
import PostsList from '../../components/PostsList/PostsList'
import styles from '../../components/PostsList/PostsList.module.scss'
import { addUrlProps, UrlQueryParamTypes, subquery } from 'react-url-query'

class Archive extends Component {
  constructor(props) {
    super(props);

    this.handleNextClick = this.handleNextClick.bind(this);
  }
  componentDidMount () {
    this.props.getArchives(this.props.pageNum)
  }
  // componentWillReceiveProps(nextProps, nextState) {
  //   return true;
  // }
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
          {Object.keys(posts).map((id, index) => {
            const obj = posts[id];
            return (
              <PostsList
                key={index}
                id={obj.id}
                title={obj.title}
                date={obj.date}/>
            );
          })}
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
