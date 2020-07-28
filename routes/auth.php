<?php

use \Bango\Router;

Router::get("/login", "LoginController::index");
Router::get("/register", "RegisterController::index");

Router::post("/login", "LoginController::login");
Router::post("/register", "RegisterController::register");

Router::post("/logout", "LogoutController::logout");
