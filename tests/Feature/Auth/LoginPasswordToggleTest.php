<?php

test('login form provides a show password toggle', function () {
    $html = $this->get('/login')->getContent();

    expect($html)
        ->toContain('x-data="{ show: false }"')
        ->toContain('x-on:click="show = ! show"')
        ->toContain('Tampilkan password')
        ->toContain('Sembunyikan password')
        ->toContain('name="password"')
        ->toContain('autocomplete="current-password"');
});
