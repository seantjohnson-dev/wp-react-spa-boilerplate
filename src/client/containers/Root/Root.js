import React, { Component } from 'react'
import { connect } from 'react-redux'
import Header from '../../components/Header/Header'
import Footer from '../../components/Footer/Footer'
import DevTools from '../../components/DevTools/DevTools'
import Loader from 'react-loader-advanced'

class Root extends Component {
  constructor(props) {
    super(props);

    this.state = {
      menuLoader: false,
      footerLoader: false
    };
  }
  componentDidMount() {
    this.load();
  }
  load = () => {
    this.setState({
      menuLoader: true,
      footerLoader: true
    });

    setTimeout(() => {
      this.setState({ menuLoader: false });
    }, 3000);

    setTimeout(() => {
      this.setState({ footerLoader: false });
    }, 5000);

  }
  getLoaderConfig(config = {}) {
    return Object.assign({}, {
      show: 'rootLoader',
      priority: 10,
      contentBlur: 0,
      message: 'Loading...',
      hideContentOnLoad: false,
      backgroundStyle: {
        display: 'block',
        position: 'absolute',
        top: 0,
        left: 0,
        width: '100%',
        height: '100%',
        backgroundColor: 'rgba(41, 43, 44, 0.6)',
        zIndex: 10
      },
      foregroundStyle: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        width: '100%',
        height: '100%',
        textAlign: 'center',
        zIndex: 20,
        color: 'white'
      },
      messageStyle: {
        flex: '1 1 auto',
        display: 'block',
        textAlign: 'center'
      },
      transConfig: {
        transitionName: 'loader',
        transitionEnterTimeout: 300,
        transitionLeaveTimeout: 300
      }
    }, config);
  }
  render() {

    let tool = ''

    if (process.env.NODE_ENV !== 'production' && !window.useReduxExtension) {
      tool = <DevTools />
    }

    const {
      menuLoader,
      footerLoader
    } = this.state;

    const menuConfig = this.getLoaderConfig({
      show: menuLoader,
      priority: 75
    });

    const footerConfig = this.getLoaderConfig({
      show: footerLoader,
      priority: 25
    });

    return (
      <div className='app-wrapper'>
        <Header />
        <div className="page-wrapper">
          {this.props.children}
        </div>
        <Footer />
        {tool}
      </div>
    )
  }
}

function mapStateToProps (state) {
  const { isLoading, page, archive, archives, menus } = state.data
  return {
    loading: isLoading
  }
}

export default connect(mapStateToProps, {})(Root)
