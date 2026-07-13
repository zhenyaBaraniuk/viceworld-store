<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscriberRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterSubscriberController extends Controller
{
    public function store(NewsletterSubscriberRequest $request): RedirectResponse
    {
        NewsletterSubscriber::query()->create($request->validated());

        return back();
    }
}
