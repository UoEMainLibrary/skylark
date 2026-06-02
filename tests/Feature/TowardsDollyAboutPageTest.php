<?php

it('renders the towardsdolly about videos', function (): void {
    $html = view('towardsdolly.pages.about')->render();

    expect($html)
        ->toContain('collections/towardsdolly/videos/Towards_Dolly_Wellcome_Trust_showreel.mp4')
        ->and($html)->toContain('collections/towardsdolly/videos/0051021v-001.mp4');
});
