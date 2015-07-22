# API Documentation #

_Last updated: 2015-07-09_


### Table of Contents ###
- [Purpose](#purpose)
- [API security & filters](#security)
- [API specification](#specification)
- [Gameplay flow](#flow)


<a name="purpose"></a>
## Purpose ##

The following document explains how to use the Metadata Games API. The API has
been developed to allow the implementation of HTML(5), CSS, and JavaScript
based games that will make use of the Metadata Games platform and facilitate
research into crowd-sourcing metadata. The goal of the API is to make the use
of Metadata Games independent from the specific implementation of the arcade.


<a name="security"></a>
## API security & filters ##

The API is implemented as a module within the Yii framework that defines its
functionality via controllers and their actions.

To increase security, the API makes use of Yii action filters and other
measures, as described below. When extending the API, be sure to set the
necessary filters or amend the existing controller's filter rules.

All API requests should be made via ```XMLHttpRequest``` objects, and include
the header ```X_REQUESTED_WITH``` set to ```XMLHttpRequest```. We recommend
using jQuery's ```$.ajax()```, which applies this header automatically.

To increase security and make spoofing more complex, any application wishing
to use the API must obtain a shared secret as described
[below](#shared-secret). Any requests made to functions with the
```sharedSecret``` filter must include this shared secret in the
header ```HTTP_X_MG_API_SHARED_SECRET```.

_To simplify development, we have developed a JavaScript module that handles
many of these details internally, including retrieving the shared secret and
signing AJAX requests with the necessary headers. Games and other applications
wishing to use the API should extend this module, which can be found
at ```www/js/mg.api.js```._


### Filters ###

The API implementation makes use of the following filter:

- **throttle:** Limits the rate at which a function can be called.

    _When triggered:_ returns HTTP status 420

- **IPBlock:** Blocks a function for certain IP addresses.

    _When triggered:_ returns HTTP status 403 (Forbidden)

- **APIAjaxOnly:** Requires requests to be made as AJAX requests.

    _When triggered:_ The filter will not return an error status; instead it
        redirects all non-AJAX traffic to the API module's default controller
        which displays a short message that the API can only be accessed via
        AJAX requests.

- **accessControl:** Requires the requestor to be an authenticated user (i.e:
    the requestor must have [logged in](#login) during the current session).

    _When triggered:_ returns HTTP status 403 (Forbidden)

- **sharedSecret:** Requires requests to be signed with the shared secret HTTP
    header.

    _When triggered:_ returns HTTP status 420


<a name="specification"></a>
## API specification ##

The following listing describes all callback functions and their behaviour.
Functions are called by sending GET/POST requests to
```[base_url]/index.php/api/...```. In general, each API callback responds in
JSON or throws exceptions coded with HTTP statuses. Each JSON response
includes a ```status``` field that can either be "ok" or "error". In the case
of an error, additional information may be provided by the ```errors``` or
```responseText``` field.

**[General API](#general-api)**
- [user/sharedSecret](#shared-secret)
- [games](#games)
- [games/scores](#scores)

**[User management API](#user-api)**
- [user/register](#register)
- [user/login](#login)
- [user/logout](#logout)
- [user/update](#update)
- [user/recoveryPassword](#recovery-password)
- [user/socialLogin](#social-login)

**[Gameplay API](#gameplay-api)**
- [games/play](#play)
- [games/abort](#abort)
- [games/abortPartnerSearch](#abort-search)
- [games/messages](#messages)
- [games/postMessage](#post-message)
- [games/gameapi](#gameapi)
- [games/reset](#reset)
- [games/saveLog](#save-log)

---

<a name="general-api"></a>
### General API

The following functions are general functions unassociated with specific usage.

<a name="shared-secret"></a>
#### api/user/sharedSecret

Returns a shared secret for the user that will be saved in the session. Other
API requests should be signed with a shared secret header as described
[above](#security).

**HTTP method:** GET

**Filters:** IPBlock, APIAjaxOnly

**Response:**
```
{
  "status":"ok",
  "shared_secret": <secret>
}
```


<a name="games"></a>
#### api/games

Returns a list of all games available in the system.

**HTTP method:** GET

**Filters:** throttle, IPBlock, APIAjaxOnly, sharedSecret

**Response:**
```
{
  "status": "ok" OR "error",
  "games": [
    {
      "name": "",                 // name of game
      "description": "",          // description of the game
      "arcade_image": "",         // file name of the arcade image
      "gid": "",                  // unique game id (string)
      "url": "",                  // path to the game (from base url)
      "image_url": "",            // path to the arcade image (from base url)
      "api_base_url": "",         // base url of the API
      "arcade_url": "",           // full URL to the ARCADE
      "base_url": "",             // base url
      "game_base_url": "",        // base url of the game (a game can be
                                  //  loaded via game_base_url + gid),
      "user_name": "",                  // name of player if logged in
      "user_num_played": 0,             // number of times the player
                                        //   played the game
      "user_score": 0,                  // score of the authenticated player
      "played_against_computer": false, // true if game is against a computer
      "user_authenticated": false,      // true if user is authenticated

      // may be more fields, dependent on game implementation
    },
    ...
  ]
}
```


<a name="scores"></a>
#### api/games/scores

Returns an array of the 10 users with the highest scores.

**HTTP method:** GET

**Filters:** throttle, IPBlock, APIAjaxOnly, sharedSecret

**Response:**
```
{
  status:"ok" OR "error",
  scores: [
    {
      id: 0,
      username: "",
      score: 0,
      number_played: 0
    },
    ...
  ]
}
```

---

<a name="user-api"></a>
### User Management API

The following functions are associated with authenticating and managing users.

<a name="register"></a>
#### api/user/register
Verifies the request data, and if the data is valid, registers a new user.

**HTTP method:** POST

**Filters:** IPBlock, APIAjaxOnly, sharedSecret

**Request:**
```
{
  username: "",
  password: "",
  email: "",
  verifyPassword: ""
}
```

**Response:**
```
{
  status: "ok" OR "error",
  responseText: ""
}
```


<a name="login"></a>
#### api/user/login

Verifies the password and if valid, logs the given user in.

**HTTP method:** POST

**Filters:** IPBlock, APIAjaxOnly

**Request:**
```
{
  login: "",
  password: "",
}
```

**Response:**
```
{
  status: "ok" OR "error",
  errors: {}                // only defined if status == "error"
}
```


<a name="logout"></a>
#### api/user/logout

Logs out the current user (if any).

**HTTP method:** GET

**Filters:** IPBlock, APIAjaxOnly, accessControl, sharedSecret

**Response:**
```
{status: "ok"}
```


<a name="update"></a>
#### api/user/update

Updates user info. All fields must be included in the request, even if they
are not being updated.

**HTTP method:** POST

**Filters:** IPBlock, APIAjaxOnly, accessControl, sharedSecret

**Request:**
```
{
  username: "",
  password: "",
  email: ""
}
```

**Response:**
```
{
  status: "ok" OR "error",
  responseText: ""
}
```


<a name="recovery-password"></a>
#### api/user/recoveryPassword

Sends a password recovery link to the given email address (if that email has
been registered to a user).

**HTTP method:** POST

**Filters:** IPBlock, APIAjaxOnly, accessControl, sharedSecret

**Request:**
```
{email: ""}
```

**Response:**
```
{
  status: "ok" OR "error",
  responseText: ""
}
```


<a name="social-login"></a>
#### api/user/socialLogin/provider/(PID)/api_key/(KEY)

Initiates login via the given social network provider.

**HTTP method:** GET

**Filters:** throttle, IPBlock, APIAjaxOnly, accessControl, sharedSecret

**Request:** URL parameters:
- PID: The provider ID string. Valid providers ID include ```google```,
```facebook```, ```linkedin```, ```yahoo```, and ```live```
- KEY: the api key for the given provider

**Response:**
```
{
  status: "ok" OR "error",
  responseText: ""
}
```

---

<a name="gameplay-api"></a>
### Gameplay API

The following functions are used within games to send and receive content.

<a name="play"></a>
#### api/games/play/gid/(GID)

Handles play requests and updates to a game. Accepts both GET and POST
requests; GET requests initialize a new game session, while POST requests are
used for sending responses and getting the next round.

Either variety of request may have to be repeated if the game is a two-player
game and the player is forced to wait for a second player.

**HTTP method:** GET/POST

**Filters:** IPBlock, APIAjaxOnly, sharedSecret

**Request:** URL parameters:
- GID: the unique game ID string

Data for POST requests:
```
{
  turn: 2            // the current turn
  played_game_id: 1  // the id in the database representing this played game
  submissions: [     // submission format is game-specific, but includes these:
    {
      image_id: 0    //  - id of the image that has been tagged
      tags: []       //  - string of submitted tags
    }
  ],
  ...                // further fields may be added based on implementation
}
```

**Response:**

When initializing a two-player game (GET) and a second player is not available,
the response status will be "retry". Similarly, when submitting a turn (POST)
in a two-player game, the response status for the first player will be
"waiting".

If the status is "ok", the response will include the full JSON below.

```
{
  status: "ok" OR "error" OR "retry" OR "waiting",
  errors: {},               // if status == error
  game: {
    // The following fields are available in all games.
    unique_id: "",
    played_game_id: "",     // Note: played_game_id is distinct from session_id
    name: "",
    description: "",
    more_info_url: "",
    base_url: '',
    play_once_and_move_on: 0,
    turns: 4,
    user_name: null OR "",
    user_score: 0,
    user_num_played: 0,
    user_authenticated: false,
    ...
    // Additional game fields in are game-specific
  },

  turn: {
    score: 0, // previous turn's score
    tags: {   // previous turn's tags
      "username": [
        {
          tag: "",
          original: "", // set if submitted tag differs from other tags
          score: 1,     // score of this tag
          weight: 1
        },
        ...
      ],
      ...
    },

    images: [
      {
        // all urls are relative to game.base_url
        full_size: "",
        scaled: "",
        thumbnail: "",

        licences: [0, ...] //id(s) of image licences
        id: 1 // the id of the image in the database
      },
      ...
    ],

    // All possible licences
    licences: [
      {
        id: '',
        name: '',
        description: '',
      },
      ...
    ],
    ...
    // turn may have more fields created by plugins or similar, such as:
    wordsToAvoid: ["dog", "house", "car"]
  }
}
```

Throws HTTP 400 exception if the ```played_game_id``` (specified in POST
requests) cannot be found, or if the submission cannot be parsed.


<a name="abort"></a>
#### api/games/abort/played_game_id/(ID)

Aborts the game identified by the ID and notifies the opponent (if one exists)
that the user has left the game.

**HTTP method:** GET

**Filters:** IPBlock, APIAjaxOnly, sharedSecret

**Request:** URL parameters:
- ID: unique played_game ID, used to keep track of the current game session

**Response:**
If successful, returns ```{status:'ok'}```. Throws an HTTP 400 error (Bad
Request) if ```played_game_id``` cannot be found.


<a name="abort-search"></a>
#### api/games/abortPartnerSearch/game_partner_id/(ID)

Aborts the partner search in progress, sending the potential partner (if one
exists) an abort message.

This method is also used to skip the "Waiting for other player" screen and play
instantly against the computer, if the game allows this option.

**HTTP method:** GET

**Filters:** IPBlock, APIAjaxOnly, sharedSecret

**Request:** URL parameters:
- ID: user ID of potential partner

**Response:**
If successful, returns ```{status:'ok'}```. Throws an HTTP 400 error (Bad
Request) if ```played_game_id``` cannot be found.


<a name="messages"></a>
#### api/games/messages/played_game_id/(ID)

Returns messages for the user playing the game identified
by ```played_game_id```.

**HTTP method:** GET

**Filters:** IPBlock, APIAjaxOnly, sharedSecret

**Request:** URL parameters:
- ID: unique played_game ID, used to keep track of the current game session

**Response:**
```
{
  status: "ok" OR "error",
  messages: [
    {message: ""},
    ...
  ]
}
```


<a name="post-message"></a>
#### api/games/postMessage/played_game_id/(ID)

Leaves a message for the opponent. The message may be an object encoded in
JSON.

**HTTP method:** POST

**Filters:** IPBlock, APIAjaxOnly, sharedSecret

**Request:**
```
{message: ""}
```

**Response:** If successful, returns ```{status:'ok'}```. Throws an HTTP 400
error (Bad Request) if ```played_game_id``` cannot be found.


<a name="gameapi"></a>
#### api/games/gameapi/gid/(GID)/played_game_id/(ID)

Calls the specified method within the game engine. The request may include
parameters to be passed to the game engine. This allows games to extend the API
with further game-specific functionality.

**HTTP method:** POST

**Filters:** IPBlock, APIAjaxOnly, sharedSecret

**Request:** URL parameters:
- GID: the unique game ID string
- ID: the played game session ID

POST request data:
```
{
  call: {
    method: ""
  }
  parameter: null OR {}  // this object is passed as an argument to the method
}
```

**Response:**
```
{
  status: "ok" or "error",
  response: {}      // varies based on the method called
}
```

Throws an HTTP 400 exception if the ```played_game_id``` cannot be found.


<a name="reset"></a>
#### api/games/reset/gid/(GID)/played_game_id/(ID)

Resets the game and returns a new played_game_id. *Note:* this only needs to be
called for games that do not reload between game sessions.

**HTTP method:** GET

**Filters:** IPBlock, APIAjaxOnly, sharedSecret

**Request:** URL parameters:
- GID: the unique game ID string
- ID: the played game session ID

**Response:**
```
{
  status: "Score saved successfully",
  played_game_id: 0
}
```


<a name="save-log"></a>
#### api/games/saveLog/gid/(GID)

Saves the included gameplay log to the server.

**HTTP method:** GET

**Filters:** IPBlock, APIAjaxOnly, sharedSecret

**Request:** URL parameters:
- GID: the unique game ID string

POST request data:
```
{
  eventlog: {} // This object will be stored as a JSON file on the server.
}
```

**Response:**
None.


<a name="flow"></a>
## Gameplay flow

### Single-player

- Client initializes game with GET request to games/play.
- Server responds with game and turn data.
- Player completes turn.
- Client sends turn data as POST request to games/play.
- Server responds with next turn data.
- (and so on...)


### Two-player

- Client initializes game with GET request to games/play.
- Server checks status of other players.
- _If a player is waiting:_ Server responds with game and turn data.
- _If no player is waiting:_ Server responds with "retry" status.
- _If client receives "retry" status:_ Send GET request again, with time
  constraint.
- _If time is exceeded:_ Server sets up game with computer and responds with
  turn data.
- Client can also skip the retry cycle and play against computer by calling
  games/abortPartnerSearch.
- Player completes turn
- Client sends turn data as POST request to games/play
- _If other player is waiting:_ Server reponds with next turn data, and sends
  message to waiting player.
- _If other player is not waiting:_ Server responds with a "waiting" status.
