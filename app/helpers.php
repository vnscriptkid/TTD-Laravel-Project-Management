<?php

function produceGravatarLink($user) {
    return "https://www.gravatar.com/avatar/" . md5($user->email);
}