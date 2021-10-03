<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SpotifyService;
use App\Services\TokenManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SpotifyController extends Controller
{
    private SpotifyService $spotifyService;
    private TokenManager $tokenManager;

    /** @var User */
    private ?Authenticatable $currentUser;

    public function __construct(
        SpotifyService $spotifyService,
        TokenManager $tokenManager,
        ?Authenticatable $currentUser
    ) {
        $this->spotifyService = $spotifyService;
        $this->tokenManager = $tokenManager;
        $this->currentUser = $currentUser;
    }

    public function connect()
    {
        abort_unless(
            $this->spotifyService->enabled(),
            Response::HTTP_NOT_IMPLEMENTED,
            'Koel is not configured to use with Last.fm yet.'
        );

        $session = new SpotifyWebAPI\Session(
            $this->spotifyService->getKey(),
            $this->spotifyService->getSecret(),
            route('spotify.callback')
        );

        $options = [
            'scope' => [
                'user-read-email',
            ],
        ];

        $uri = $session->getAuthorizeUrl($options);
        
        if (!$uri) {
            abort(403, 'Not implemented yet');
        }

        return redirect($uri);
    }

    public function callback(Request $request)
    {
    }
}
