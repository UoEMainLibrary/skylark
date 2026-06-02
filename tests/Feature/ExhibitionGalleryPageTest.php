<?php

it('renders the new exhibition gallery video embeds', function (): void {
    $html = view('eerc-v2.pages.exhibition_gallery')->render();

    expect($html)
        ->and($html)->toContain('EH-5%20Haddington%20Voices_EBU%20R128.mp4?sequence=5')
        ->and($html)->toContain('EH-6%20The%20Past%20is%20Still%20with%20Us.mp4?sequence=3')
        ->and($html)->toContain('EH-8%20RESP%20Allinadayswork%20film.mp4?sequence=3')
        ->and($html)->toContain('EH-7%20All%20in%20a%20Days%20Work%20publication.pdf?sequence=1')
        ->and($html)->toContain('Download the publication (PDF)')
        ->and($html)->not->toContain('EH-5%20Haddington%20Voices_-17LUFS.mp4?sequence=4')
        ->and($html)->not->toContain('PDF download will be available when the digital copy is provided.')
        ->and($html)->not->toContain('Video embed will be added when the film file is provided.')
        ->and($html)->not->toContain('The moving image file will be embedded here once it is available on the University digital preservation service; until then, this still and credits introduce the film on the site.');
});
