<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    public function view(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id;
    }

    public function update(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id;
    }

    public function delete(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id;
    }
}
