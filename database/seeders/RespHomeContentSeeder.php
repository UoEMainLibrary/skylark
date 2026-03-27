<?php

namespace Database\Seeders;

use App\Models\RespHomeContent;
use Illuminate\Database\Seeder;

class RespHomeContentSeeder extends Seeder
{
    /**
     * Seed the default RESP v2 homepage HTML (previously in eerc-v2/home.blade.php).
     */
    public function run(): void
    {
        $galleryUrl = url('/eerc/exhibition_gallery');

        $body = <<<HTML
<p>The RESP Archive Project was established in 2018 in collaboration with the Centre for Research Collections at the University of Edinburgh. Originally conceived as a cataloguing project to improve the discoverability of hundreds of audio recordings created by the RESP the project has developed through the creation of this website to ensure that the collections are both readily accessible and carefully curated and digitally preserved for future access.</p>

<p>The central ethos of the RESP is to make the collections freely available for study, teaching and community access. The project has achieved this by creating a digital platform that allows users to explore and engage with the collection with full access to audio recordings, photographs, and transcripts all in the one place. We have also provided space to engage with creative output in our <a href="{$galleryUrl}">Exhibition gallery</a>.</p>

<p>Digital materials are often at risk of being lost so through careful curation we can allow all of our content to be open and accessible for research, teaching, and community engagement. Each individual item has been digitally preserved in order to safeguard our collection and with the aim to ensure that the materials and stories within remain available for generations to come.</p>

<p>Over the years, the project has spanned Dumfries &amp; Galloway and East Lothian and also the Western Isles, Tayside, Edinburgh, the Scottish Borders, Argyll and West Lothian creating a geographically and thematically broad collection.</p>

<p>The RESP Archive is managed and maintained as a University of Edinburgh Collection.</p>
HTML;

        RespHomeContent::query()->updateOrCreate(
            ['slug' => RespHomeContent::SLUG],
            [
                'title' => 'Home',
                'body' => trim($body),
            ]
        );
    }
}
