<?php


class AllegroApiException extends  Exception {

    const ALLOW_ONLY_OBJECT = 1000;
    const PARAMETER_INCORECT = 1001;

    const NO_LOGIN_PARAMETER_MSG = "Must set login for Allegro API serwer";
}
