import { Link } from 'react-router'
import React from 'react'
import entities from 'entities'
import HtmlToReact from 'html-to-react'
import voidElements from 'void-elements'
import classNames from 'classnames'

import {SITE_URL} from '../constants'

const parser = new HtmlToReact.Parser(React)
const processNodeDefinitions = new HtmlToReact.ProcessNodeDefinitions(React)

/**
 * Convert common Elements to their React equivalent.
 * @param {String} html HTML string
 * @returns {Object} HtmlToReact parser
 */
export default function parse (html) {
  const counts = {}
  const imageContainers = ['div', 'p', 'figure']

  if (typeof html === 'object' && html.hasOwnProperty('rendered')) {
    html = html.rendered;
  }

  const processingInstructions = [{
    shouldProcessNode: (node) => true,
    processNode: (node, children) => {
      const nodeName = (node.name === undefined) ? node.type : node.name;
      if (!counts[nodeName]) {
        counts[nodeName] = 0
      }

      counts[nodeName]++

      const attrs = {
        key: nodeName + '-' + counts[nodeName],
        ...node.attribs
      }

      if (attrs.class) {
        attrs.className = attrs.class;
        delete attrs.class;
      }
      if (attrs.srcset) {
        attrs.srcSet = attrs.srcset;
        delete attrs.srcset;
      }
      if (attrs.allowfullscreen) {
        attrs.allowFullScreen = attrs.allowfullscreen;
        delete attrs.allowfullscreen;
      }
      if (attrs.frameborder) {
        attrs.frameBorder = attrs.frameborder;
        delete attrs.frameborder;
      }

      if (
        imageContainers.indexOf(nodeName) !== -1 &&
        children && children.length
      ) {
        const img = children.find(child => child.type === 'img')
        const iframe = children.find(child => child.type === 'iframe')
        const index = children.indexOf(img)
        const iframeIndex = children.indexOf(iframe)

        if (index !== -1) {
          return createImageContainer(node, attrs, children, index)
        }
        if (iframeIndex !== -1) {
          return createIframeContainer(node, attrs, children, iframeIndex)
        }
      }

      if (node.type === 'text') {
        return entities.decodeHTML(node.data)
      }

      if (
        nodeName == 'a' &&
        // Ignore `mailto:` links
        attrs.href.indexOf('mailto') === -1 &&
        // Ignore any href that is not pointing to our WP instance
        attrs.href.indexOf(SITE_URL) === 0
      ) {
        attrs.href = ''
        return <Link to={node.attribs.href} {...attrs}>{children}</Link>
      }

      if (Object.keys(voidElements).indexOf(nodeName) !== -1) {
        return React.createElement(nodeName, attrs, node.data)
      }

      return processNodeDefinitions.processDefaultNode(node, children)
    }
  }]

  return parser.parseWithInstructions(
    `<div>${html}</div>`,
    (node) => true,
    processingInstructions
  )
}

/**
 * Replace an image with a React component, excluding
 * most of the attributes set by WordPress.
 * @returns {Element}
 */
function createImageContainer (container, containerAttrs, children, index) {
  const img = children[index]

  const containerName = (container.name === undefined) ? container.type : container.name

  let finalChildren = React.Children.map(children, (child, i) => {
    let newChild
    if (index === i) {
      newChild = React.createElement('img', {
        key: containerName + '-' + Math.random() + '-' + i,
        title: img.props.title,
        alt: img.props.alt,
        src: img.props.src,
        srcSet: img.props.srcSet,
        className: img.props.className,
        style: {maxWidth: img.props.width + 'px'}
      })
    } else {
      newChild = React.cloneElement(child, {key: Math.random() + '-' + i});
    }
    return newChild
  });

  containerAttrs.key = (containerAttrs.key || (containerName + '-' + Math.random()))
  containerAttrs.className = (containerAttrs.className || '')
  containerAttrs.className = classNames(containerAttrs.className, img.props.className, 'contains-img')
  delete containerAttrs.style

  return React.createElement(containerName, containerAttrs, finalChildren)
}

function createIframeContainer (container, containerAttrs, children, index) {
  const iframe = children[index]

  let finalChildren = React.Children.map(children, (child, i) => {
    let newChild
    if (index === i) {
      newChild = React.createElement('iframe', {
        key: 'div-' + Math.random() + '-' + i,
        frameBorder: iframe.props.frameBorder,
        allowFullScreen: iframe.props.allowFullScreen,
        src: iframe.props.src
      })
    } else {
      newChild = React.cloneElement(child, {key: Math.random() + '-' + i});
    }
    return newChild
  });

  containerAttrs.key = (containerAttrs.key || ('div-' + Math.random()))
  containerAttrs.className = (containerAttrs.className || '')
  containerAttrs.className += ' video-wrap'
  delete containerAttrs.style;

  return React.createElement('div', containerAttrs, children)
}
