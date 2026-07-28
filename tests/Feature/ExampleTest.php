<?php

test('redirects the home page to the public FAQ list', function () {
    $response = $this->get(route('home'));

    $response->assertRedirect(route('faqs.index'));

    $this->get(route('faqs.index'))->assertOk();
});
