<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function aboutUs()
{
    $page_title = "About Us";
    return view('frontend.about-us', compact('page_title'));
}

public function articles()
{
    $page_title = "Articles";
    return view('frontend.articles', compact('page_title'));
}

public function career()
{
    $page_title = "Career";
    return view('frontend.career', compact('page_title'));
}

public function help()
{
    $page_title = "Help";
    return view('frontend.help', compact('page_title'));
}

public function faq()
{
    $page_title = "FAQ";
    return view('frontend.faq', compact('page_title'));
}

public function contactUs()
{
    $page_title = "Contact Us";
    return view('frontend.contact-us', compact('page_title'));
}

public function blog()
{
    $page_title = "Blog";
    return view('frontend.blog', compact('page_title'));
}

public function subscriptions()
{
    $page_title = "Subscriptions";
    return view('frontend.subscriptions', compact('page_title'));
}

public function termsAndConditions()
{
    $page_title = "Terms and Conditions";
    return view('frontend.terms-and-conditions', compact('page_title'));
}

public function privacyPolicy()
{
    $page_title = "Privacy Policy";
    return view('frontend.privacy-policy', compact('page_title'));
}

}
