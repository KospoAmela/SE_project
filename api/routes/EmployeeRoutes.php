<?php
/**
 * @OA\Info(title="SE_PROJECT API", version="1.0")
 * @OA\OpenApi(
 *    @OA\Server(url="http://localhost/SE_PROJECT/api/", description="Development Environment" ),
 *    @OA\Server(url="https://", description="Production Environment" )
 * ),
 * @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authentication" )
 */

/**
 * @OA\Post(path="/register", tags={"register"},
 *   @OA\RequestBody(description="Basic employee info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *     				 @OA\Property(property="name", required="true", type="string", example="First Name",	description="Name of the user`" ),
 *             @OA\Property(property="surname", required="true", type="string", example="Surname Name",	description="Surname of the user`" ),
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" ),
 *             @OA\Property(property="phone", required="true", type="string", example="12345",	description="Phone number" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */
Flight::route('POST /register', function(){
      Flight::employeeService()->register(Flight::request()->data->getData());
      Flight::json(["message" => "Confirmation email has been sent, please confirm your account"]);
  });

/**
 * @OA\Post(path="/login", tags={"login"},
 *   @OA\RequestBody(description="Basic employee info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *                   @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been legged in.")
 * )
 */
Flight::route('POST /login', function(){
  Flight::json(Flight::jwt(Flight::employeeService()->login(Flight::request()->data->getData())));
});

/**
 * @OA\Get(path="/employees",
 *  @OA\Response(response="200", description="Get all employees")
 * )
 */
Flight::route('GET /employees', function(){
    Flight::json(Flight::employeeService()->getById(Flight::get('user')['id']));
});


/**
 * @OA\Put(path="/employees",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Update a user in the database corresponding to id")
 * )
 */
Flight::route('PUT /employees', function(){
    $user = Flight::employeeService()->update(Flight::get('user')['id'], Flight::request()->data->getData());
    Flight::json($user);
});

/**
 * @OA\Get(path="/confirm/{token}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="token", example=1),
 *     @OA\Response(response="200", description="Activate a user account")
 * )
 */
Flight::route('GET /confirm/@token', function($token){
    Flight::json(Flight::jwt(Flight::userService()->confirm($token)));
});



/**
 * @OA\Get(path="/forgot",
 *     @OA\Response(response="200", description="Get recovery link for a forgotten password")
 * )
 */
Flight::route('POST /forgot', function(){
    Flight::userService()->forgot(Flight::request()->data->getData());
    Flight::json(["message" => "Recovery link has been sent to your email."]);
});

/**
 * @OA\Get(path="/reset",
 *     @OA\Response(response="200", description="Reset password")
 * )
 */
Flight::route('POST /reset', function(){
    Flight::json(Flight::jwt(Flight::userService()->reset(Flight::request()->data->getData())));
});

*/

?>