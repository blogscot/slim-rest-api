# slim-rest-api
An example Student REST Api using Slim

The example is adapted from http://www.codediesel.com/php/create-a-quick-rest-api-using-slim-framework/

##Testing

To fetch the home route use:

**curl -i http://localhost**

A student's score can be fetched using:

**curl -i http://localhost/getScore/3**

To update the same student's score, use:

**curl -i --data "id=3&score=36"  http://localhost/updateScore**

