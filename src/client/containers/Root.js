import React from 'react'
import Header from '../components/Header/Header'
import Footer from '../components/Footer/Footer'
import DevTools from '../components/DevTools/DevTools'
const config = require('../../../config.json')

const Root = ({ children }) => {
  let tool = ''

  if (process.env.NODE_ENV !== 'production' && !config.reduxExtension) {
    tool = <DevTools />
  }

  return (
    <div className='app-wrapper'>
      <Header />
      <div className="page-wrapper">
        {children}
      </div>
      <Footer />
      {tool}
    </div>
  )
}

export default Root
