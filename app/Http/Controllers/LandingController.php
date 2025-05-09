<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJetNotification;
use App\Jobs\SendTelegramNotification;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\JsonLd;


class LandingController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Laravel Support & Maintenance Services');
        SEOMeta::setDescription('We provide expert Laravel maintenance, security, and development support.');

        OpenGraph::setTitle('Laravel Support & Maintenance Services')
            ->setDescription('We provide expert Laravel maintenance, security, and development support.')
            ->setUrl(url()->current())
            ->addProperty('type', 'website');

        JsonLd::setTitle('Laravel Support & Maintenance Services');
        JsonLd::setDescription('We provide expert Laravel maintenance, security, and development support.');

        return view('landing.landing');
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        dispatch(new \App\Jobs\TestJob());
//        dispatch(new SendTelegramNotification($data));
//        dispatch(new SendMailJetNotification($data));

        return back()->with('success', 'Message was sent!');
    }

}


