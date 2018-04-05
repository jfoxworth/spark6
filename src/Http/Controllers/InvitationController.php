<?php

namespace Laravel\Spark\Http\Controllers;

use Laravel\Spark\Invitation;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class InvitationController extends Controller
{
    /**
     * Get the given invitation.
     *
     * This is used during registration to show the invitation.
     *
     * @param  string  $token
     * @return Response
     */
    public function show($token)
    {
        $invitation = Invitation::with('team')->where('token', $token)->firstOrFail();

        if ($invitation->isExpired()) {
            $invitation->delete();

            abort(404);
        }

        return $invitation;
    }

    public function __construct(NotificationRepository $notifications)
    {
        $this->notifications = $notifications;
    }
    
}
