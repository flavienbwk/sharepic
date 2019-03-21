# API Documentation

This document is intended to present the API routes and their description.

## In any case

All queries are `POST` queries.

If no route were matched or a query is malformed, an error `400` is returned. Else, all responses are `200`.

In any case, the response must have theses 3 parameters :

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
| photos | _array<file>_ | optional, 0 by default |
| description | _string_ ||
| geolocation | _string_ | Optional. Place name or geocode |

### Response

| Key name | Value type | Description |
|----------|-------------|-------------|
| ids | _string_ ||

## Publications list

Public list of random last publications.

### Query

| Endpoint | `/api/publications/public` | Description |
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
| photos | _array<string>_ | Array of the `ids` of the publication's photos  |
| created_at | _datetime_ | Publish date |

## Publications list of a user

For the current connected user, list of the publications. Based on its user subscriptions.

### Query

| Endpoint | `/api/publications` | Description |
|----------|-------------|-------------|
| pagination_start | _int_ | Optional, 0 by default |
| interval | _int_ | Optional, 10 by default, 50 maximum |

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| ids | _int_ ||
| description | _string_ ||
| geolocation | _string_ ||
| photos | _array<string>_ | Array of the `ids` of the publication's photos  |
| created_at | _datetime_ | Publish date |

## Publication details

### Query

| Endpoint | `/api/publication` | Description |
|----------|-------------|-------------|
| ids | _string_ ||

### Response

The response will be an array of objects of the following format :

| Key name | Value type | Description |
|----------|-------------|-------------|
| description | _string_ ||
| geolocation | _string_ ||
| photos | _array<string>_ | Array of the `ids` of the publication's photos  |
| created_at | _datetime_ | Publish date |

## Publication reactions

## Publication comments list

## User subscriptions list

## User subscribed list

## User subscription

Route to call when a user attempts to subscribe to another one.

## Is user subscribed

Is the current connected user subscribed to the user given in parameter ?

## Conversation creation

## Conversation adding users

Adding users to conversation.

## Conversation messages

## Conversation users

Returns the list of the users of a conversation/

## User conversations