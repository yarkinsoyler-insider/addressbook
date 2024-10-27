<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    public function view(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id; // Kullanıcı yalnızca kendi kontaklarını görüntüleyebilir
    }

    public function update(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id; // Kullanıcı yalnızca kendi kontaklarını güncelleyebilir
    }

    public function delete(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id; // Kullanıcı yalnızca kendi kontaklarını silebilir
    }
}
