import { Schema, arrayOf } from 'normalizr'

const postSchema = new Schema('posts', { idAttribute: 'id' });
const postAuthorSchema = new Schema('postAuthors', { idAttribute: 'id' });
const commentSchema = new Schema('comments', { idAttribute: 'id' });
const CommentAuthorSchema = new Schema('commentAuthors', { idAttribute: 'id' });

// An Order has an array of line items
postSchema.define({
    author: postAuthorSchema,
    comments: arrayOf(commentSchema)
});

// Each comment has an author
commentSchema.define({
    author: commentAuthorSchema
});

