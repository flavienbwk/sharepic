# API Documentation

This document is intended to present the API routes and their description.

You can get the PostMan version here : [https://documenter.getpostman.com/view/782336/S17ruTKA](https://documenter.getpostman.com/view/782336/S17ruTKA).

## In any case

All queries are `POST` queries.

If no route were matched or a query is malformed, an error `400` is returned. Else, all responses are `200`.

If a query requires authentication and the authentication fails, a `503` error is returned.

In any case, the response will have theses 3 parameters :

| Key name | Value type | Description |
|----------|-------------|---------|
| error | _boolean_ | True or False depending on if the route returned an error. |
| message | _string_ | Returns an informative message (can be the error or any message to display). |
| data | _string_ | This column will contain the following `Response` data if there's no error. This column is generally empty when an error occured. |

For all routes expect the `Authentication` and `Registration` ones, the queries must contain in their header the token received when authenticated. The header parameter name must be `X-Ov-Token`.

## Registration

### Query

| Endpoint | `/api/auth/register` | Description |
|----------|-------------|-------------|
| email | _string_ ||
| password | _string_ ||
| first_name | _string_ | Optional |
| last_name | _string_ | Optional |

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| token | _string_ ||
| expires_at | _datetime_ ||
| ids | _string_ ||
| first_name | _string_ ||
| last_name | _string_ ||
| email | _string_ ||
| username | _string_ ||

## Authentication

### Query

| Endpoint | `/api/auth/login` | Description |
|----------|-------------|-------------|
| username | _string_ | E-mail or username |
| password | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| token | _string_ ||
| expires_at | _datetime_ ||
| ids | _string_ ||
| first_name | _string_ ||
| last_name | _string_ ||
| email | _string_ ||
| username | _string_ ||

## User information

### Query

| Endpoint | `/api/auth/info` | Description |
|----------|-------------|-------------|
| _Nothing to provide_ |||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| ids | _string_ ||
| first_name | _string_ ||
| last_name | _string_ ||
| email | _string_ ||
| username | _string_ ||

## Get expiration date

### Query

| Endpoint | `/api/auth/expiration` | Description |
|----------|-------------|-------------|
| _Nothing sent_ |||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| expires_at | _datetime_ ||

## Adding an avatar to current user

### Query

| Endpoint | `/api/account/avatar/add` | Description |
|----------|-------------|-------------|
| avatar | _file_ | Image |

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| uri | _string_ | Link to the image |

## User last avatar

### Query

| Endpoint | `/api/account/avatar` | Description |
|----------|-------------|-------------|
| ids | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| uri | _string_ | Link to the image |
| added_at | _datetime_ ||

## User notifications

Returns the list of notifications of the currently connected user.

### Query

| Endpoint | `/api/account/notifications` | Description |
|----------|-------------|-------------|
| pagination_start | _int_ | optional, 0 by default |
| interval | _int_ | optional, 10 by default, 50 maximum |

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| id | _int_ ||
| message | _string_ ||
| seen | _int_ | 0 = no, 1 = yes |
| target_type | _string_ | "publication" or "user" |
| target_ids | _string_ | "publication" or "user" |
| expires_at | _datetime_ ||

## User notification seen

Sets the notification `seen` state to `1` if seen or `0`.

### Query

| Endpoint | `/api/account/notification/seen` | Description |
|----------|-------------|-------------|
| id | _string_ ||
| seen | _int_ | 1 if seen, 0 if not seen |

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| _No response_ |||

## Adding a publication

### Query

| Endpoint | `/api/publications/add` | Description |
|----------|-------------|-------------|
| photos | _array<file>_ ||
| description | _string_ ||
| geolocation | _string_ | Optional. Place name or geocode |

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| ids | _string_ ||

## Removing a publication

### Query

| Endpoint | `/api/publications/remove` | Description |
|----------|-------------|-------------|
| ids | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| _No response_ |||

## Publications list

Public list of random last publications.

### Query

| Endpoint | `/api/publications` | Description |
|----------|-------------|-------------|
| pagination_start | _int_ | optional, 0 by default |
| interval | _int_ | optional, 10 by default, 50 maximum |

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| ids | _int_ ||
| description | _string_ ||
| geolocation | _string_ ||
| photos | _array<string>_ | Array of the `local_uri` of the publication's photos  |
| created_at | _datetime_ | Publish date |

## Publication details

### Query

| Endpoint | `/api/publication` | Description |
|----------|-------------|-------------|
| ids | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| description | _string_ ||
| geolocation | _string_ ||
| photos | _array<string>_ | Array of the `ids` of the publication's photos  |
| created_at | _datetime_ | Publish date |

## React to publication

If the same reaction is sent after being already sent, it will unreact.
If another reaction is sent, it will modify the reaction (remove the last one, and add the new one).

### Query

| Endpoint | `/api/publication/react` | Description |
|----------|-------------|-------------|
| ids | _string_ ||
| id_reaction | _string_ ||

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| _No data_ |||

## Publication reactions

### Query

| Endpoint | `/api/publication/reactions` | Description |
|----------|-------------|-------------|
| ids | _string_ ||

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| User_ids | _string_ ||
| Reaction_id | _string_ ||
| reacted_at | _datetime_ ||

## Reaction details

### Query

| Endpoint | `/api/reaction` | Description |
|----------|-------------|-------------|
| id | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| name | _string_ ||
| image_uri | _string_ ||

## Reactions list

### Query

| Endpoint | `/api/reactions` | Description |
|----------|-------------|-------------|
| _No data_ |||

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| name | _string_ ||
| image_uri | _string_ ||

## Publication comments list

### Query

| Endpoint | `/api/publication/comments` | Description |
|----------|-------------|-------------|
| ids | _string_ ||
| pagination_start | _int_ | Optional, 0 by default |
| interval | _int_ | Optional, 5 by default, 50 maximum |

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| text | _string_ ||
| added_at | _datetime_ ||
| User_ids | _string_ ||

## Publication add comment

### Query

| Endpoint | `/api/publication/comment` | Description |
|----------|-------------|-------------|
| ids | _string_ | ids of the publication|
| text | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| _No response_ |||

## User subscriptions list

List of the subscriptions for the currently connected user.

### Query

| Endpoint | `/api/account/subscriptions` | Description |
|----------|-------------|-------------|
| ids | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| ids | _array<string>_ ||

## User subscribed list

### Query

| Endpoint | `/api/account/subscribed` | Description |
|----------|-------------|-------------|
| ids | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| ids | _array<string>_ ||

## User subscription

Route to call when a user attempts to subscribe to another one.

### Query

| Endpoint | `/api/account/subscription` | Description |
|----------|-------------|-------------|
| ids | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| _No response_ |||

## Is a user subscribed

### Query

| Endpoint | `/api/account/issubscribed` | Description |
|----------|-------------|-------------|
| ids | _string_ ||
| direction | _int_ | 1 = Is the currently connected user subscribed to the user given in parameter ? 2 = Is the given user subscribed to the currently connected user ? |

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| subscribed | _int_ | 1 for yes, 0 for no |

## List users by username

Performs a "LIKE" SQL query to find a username. Returns the 6 most pertinents results.

### Query

| Endpoint | `/api/account/search` | Description |
|----------|-------------|-------------|
| username | _string_ | Username or part of a username to search. | 

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| ids | _string_ ||
| username | _string_ ||

## Conversation creation

### Query

| Endpoint | `/api/conversations/add` | Description |
|----------|-------------|-------------|
| name | _string_ ||

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| id | _int_ | Identifier of the created conversation |

## Conversation adding users

Adding users to conversation.

### Query

| Endpoint | `/api/conversation/add_user` | Description |
|----------|-------------|-------------|
| conversation_id | _string_ || 
| User_ids | _string_ ||

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| _No response_ |||

## Conversation message

Send message to a conversation.

### Query

| Endpoint | `/api/conversation/message` | Description |
|----------|-------------|-------------|
| conversation_id | _int_ ||
| value | _string_ | Message |

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| _No data_ |||

## Conversation messages

Messages of the current connected user.

### Query

| Endpoint | `/api/conversation/messages` | Description |
|----------|-------------|-------------|
| conversation_id | _int_ ||

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| value | _string_ ||
| User_ids | _string_ | ids of the user sending the message |

## Conversation users

Returns the list of the users of a conversation if the currently connected user is part of the conversation.

### Query

| Endpoint | `/api/conversation/users` | Description |
|----------|-------------|-------------|
| conversation_id | _string_ ||

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| ids | _array<string>_ | ids of the users |

## User conversations

### Query

| Endpoint | `/api/conversations` | Description |
|----------|-------------|-------------|
| _No data_ |||

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| id | _int_ ||
| name | _string_ ||
| User_ids | _string_ | The person who has created the conversation. |