<?php

function booksValidation($req){
    $msg = [
        'isbn.required' => 'Please input ISBN',
        'isbn.unique' => 'ISBN is already registered',
        'isbn.numeric' => "ISBN must be number",
        'isbn.digits' => "ISBN must be 13 digits",
        'title.required' => 'Please Input your Title',
        'description.required' => 'Please Input Description',
        'published_year.required' => 'Please Input Published Year',
    ];

    $validated = Validator::make($req, [
        'isbn' => 'required|numeric|unique:books|digits:13',
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'published_year' => 'required|integer|min:1900|max:2022',
        'author_id' => 'required|integer'
    ],$msg);
    return $validated;
}

function userValidation($req) {
    $msg = [
        'name.required' => 'Please input your name',
        'email.required' => 'Please Input your email',
        'email.unique' => 'Email is already registered',
        'password.required' => 'Please input your password',
        'password.min' => "Password must be 8 character",
        'password.confirmed' => "Password confirm not be empty please input the password",
        'password.regex' => "Passwords must use numbers and contain capitals"
    ];

    $validated = Validator::make($req, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => [
            'required',
            'confirmed',
            'string',
            'min:8',             // must be at least 10 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
        ]
    ],$msg);
    return $validated;
}

function bookReviewValidation($req){
    $msg = [
        'review.required' => 'Please Input Review',
        'review.max' => 'Review between 1 and 10',
        'comment.required' => 'Please Input Comment',
    ];

    $validated = Validator::make($req, [
        'comment' => 'required|string',
        'review' => 'required|integer|min:1|max:10',
    ],$msg);
    return $validated;
}
