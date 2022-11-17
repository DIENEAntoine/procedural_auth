<?php


    get("/", ["welcomeController", "index"]);

    get("/edit/{id}", ["welcomeController", "edit"]);

    get("/create", ["welcomeController", "create"]);