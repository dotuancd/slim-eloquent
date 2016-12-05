<?php

namespace App\Controller;

use App\Models\User;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController
{
    public function show(Request $request, Response $response)
    {
        $user = User::find($request->getAttribute('userId'));
        
        return $response->withJson($user);
    }
}