<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class Controller
{
    protected function currentUser(): User
    {
        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    protected function publicFileResponse(string $path): StreamedResponse
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return $disk->response($path);
    }
}
