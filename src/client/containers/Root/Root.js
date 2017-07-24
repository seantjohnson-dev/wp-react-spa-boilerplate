import React, { Component } from 'react'
import { connect } from 'react-redux'
import Header from '../../components/Header/Header'
import Footer from '../../components/Footer/Footer'
import DevTools from '../../components/DevTools/DevTools'
import {Transition, TransitionGroup} from 'react-transition-group'

const duration = 300;

const defaultStyle = {
  transition: `opacity ${duration}ms ease-in-out`,
  opacity: 0
}

const transitionStyles = {
  entering: { opacity: 1 },
  entered:  { opacity: 1 },
  exiting:  { opacity: 0 },
  exited:  { opacity: 0 }
};

class Root extends Component {
  render() {

    const {location} = this.props

    let tool = ''

    if (process.env.NODE_ENV !== 'production' && !window.useReduxExtension) {
      tool = <DevTools />
    }

    const children = React.Children.map(this.props.children, (child, i) => {
      return (
        <Transition key={i} in={true} timeout={duration}>
          {(state) => (
             React.cloneElement(child, {location: location, style: {
              ...defaultStyle,
              ...transitionStyles[state]
            }})
          )}
        </Transition>
      )
    });

    return (
      <div className='app-wrapper'>
        <Header location={location}/>
        <div className="page-wrapper">
          <TransitionGroup appear={true}>
            {children}
          </TransitionGroup>
        </div>
        <Footer />
        {tool}
      </div>
    )
  }
}

function mapStateToProps (state) {
  const { isLoading } = state.data
  return {
    loading: isLoading
  }
}

export default Root
