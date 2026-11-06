<?php

namespace Database\Seeders;

use App\Models\StceciliasEvent;
use App\Models\StceciliasPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class StceciliasMuseumSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['museum-concert.jpg' => 'concert-room.jpg', 'museum-laigh.jpg' => 'laigh-hall.jpg', 'museum-saltire.jpg' => 'saltire.jpg', 'museum-luke-wright.jpg' => 'luke-wright.jpg', 'museum-cello.jpg' => 'cello.jpg'] as $source => $target) {
            if (! Storage::disk('public')->exists('stcecilias/'.$target)) {
                Storage::disk('public')->put('stcecilias/'.$target, file_get_contents(public_path('collections/stcecilia/images/'.$source)));
            }
        }
        $pages = json_decode(<<<'JSON'
[
    {
        "slug": "home",
        "title": "A living museum of music",
        "intro": "Scotland’s oldest purpose-built concert hall, home to the University of Edinburgh’s collection of historic musical instruments.",
        "body": "<p>Discover the history of musical instruments and music performance in the heart of Edinburgh’s Old Town.</p>",
        "sections": [
            {
                "heading": "Music, history and discovery",
                "content": "<p>St Cecilia’s Hall is an inclusive, welcoming museum and performance space, with a world-class musical instrument collection at the centrepiece of research, teaching and conservation.</p>"
            },
            {
                "heading": "Hear the collection",
                "content": "<p>Hear and see our historic instruments in action with the free Bloomberg Connects digital guide. Explore more than 150 instruments and audio clips, over 50 videos, and guides created by our expert curators.</p><p><a href=\"https://guides.bloombergconnects.org/en-US/guide/stCeciliasHallTheUniversityOfEdinburgh\">Open the free digital guide</a></p>"
            }
        ],
        "navigation_order": 0,
        "image_path": "stcecilias/concert-room.jpg",
        "image_alt": "Musicians in the elliptical Sypert Concert Room. Photograph: Jim Stephenson.",
        "is_visible": true
    },
    {
        "slug": "planning-your-visit",
        "title": "Planning your visit",
        "intro": "Discover the history of musical instruments and music performance with a visit to St Cecilia’s Hall. Located in Edinburgh’s Old Town, right off the Royal Mile, St Cecilia’s Hall is a hidden jewel in the heart of Edinburgh.",
        "body": "",
        "navigation_order": 1,
        "sections": [
            {
                "heading": "Find us",
                "content": "<p>St Cecilia’s Hall, 50 Niddry Street, Edinburgh EH1 1LG.</p><p><a href=\"https://www.google.com/maps?z=16&amp;q=st+cecilia%27s+hall,+niddry+street,+edinburgh\">View location on Google Maps</a></p>"
            },
            {
                "heading": "Our free digital guide",
                "content": "<p>Hear and see our historic instruments in action with the free Bloomberg Connects digital guide. Explore more than 150 instruments and audio clips, over 50 videos, and guides created by our expert curators.</p><p><a href=\"https://guides.bloombergconnects.org/en-US/guide/stCeciliasHallTheUniversityOfEdinburgh\">Open the free digital guide</a></p>"
            },
            {
                "heading": "Travelling to St Cecilia’s Hall",
                "content": "<p><strong>Bus:</strong> St Cecilia’s Hall is located just off Edinburgh’s Royal Mile and is a short walk from a number of bus stops. <a href=\"https://lothianbuses.co.uk/timetables-and-maps/route-maps\">Plan your bus journey</a>.</p><p><strong>Train:</strong> Edinburgh Waverley Train Station is less than a 10 minute walk away. Exit via Market Street and follow the signs to the Royal Mile.</p><p><strong>Coaches:</strong> You can find coach parking on Regent Road and Johnston Terrace. It operates from 8.30am to 6.30pm, Monday to Saturday.</p><p><strong>Car:</strong> Very limited on street parking is available on the Cowgate. The nearest car park is at the Radisson Blu hotel, entrance on Blackfriars Street and the car park for the Travelodge Edinburgh Central on St Mary’s Street. Alternative options include NCP Car Park Edinburgh St John’s Hill and Waverley Station Car Park.</p><p><strong>Cycle:</strong> Edinburgh has many cycle lanes and cycling is a sustainable way to explore the city. We do not have bicycle racks on site, but you may be able to find suitable locations to store your bike nearby. <a href=\"https://you-well.co.uk/hiring-bikes/#Edinburgh\">Find out about hiring a bike</a>.</p>"
            },
            {
                "heading": "Accessibility",
                "content": "<p>St Cecilia’s Hall: Concert Room &amp; Music Museum welcomes visitors with different access requirements.</p><p><a href=\"https://www.euansguide.com/venues/st-cecilias-hall-concert-room-and-music-museum-edinburgh-7153/#page-content\">Read access reviews on Euan’s Guide</a>.</p><p><a href=\"https://www.stcecilias.ed.ac.uk/wp-content/uploads/2024/11/HeritageCollections_StCeciliasHall_VisualGuide_0.docx-1.pdf\">Download the visual guide for visiting St Cecilia’s Hall (PDF)</a>.</p>"
            },
            {
                "heading": "Physical access",
                "content": "<h3>Respite seating</h3><p>Occasional seating is available throughout the galleries. Gallery stools can be borrowed from reception for the duration of your visit.</p><h3>Assistance dogs</h3><p>Assistance dogs are welcome and water is available on request.</p><h3>Toilets</h3><p>Accessible toilets are located on the ground floor.</p><h3>Wheelchairs and lift</h3><p>Mobility scooters and wheelchairs can be accommodated inside provided they are compatible with the lift. The lift has a weight maximum of 1875kg and can accommodate a maximum of 25 people.</p><p>There are stairs up to the first floor galleries and to the Concert Room, though these galleries can also be accessed via the lift.</p><p>The Binks Gallery, 1812 Gallery and Concert Room have polished wooden floors. There is a stone floor in the lobby and Laigh Hall. The Wolfson Gallery is carpeted.</p>"
            },
            {
                "heading": "Hearing and visual access",
                "video_url": "https://www.stcecilias.ed.ac.uk/wp-content/uploads/2024/05/St_Cecilia_s_Hall_Visitor_Info_BSL_HD_1080_-_WEB_H264_4000.mp4",
                "content": "<h3>Deaf or hard of hearing access</h3><p>St Cecilia’s Hall Reception is equipped with induction loops. Hearing aids should be switched to the T position.</p><h3>Blind or partially-sighted access</h3><p>The Visitor Information leaflet and exhibition labels are available in large print.</p>"
            },
            {
                "heading": "Visitors on the Autism Spectrum",
                "content": "<p><a href=\"https://library.ed.ac.uk/accessibility-information\">Find a sensory map and visual guide</a>.</p><p>Sensory Bags are available upon request at reception. A bag contains a sensory map, ear defenders, activity trail, fidget toys, large print label and a self-led activity.</p><p>St Cecilia’s Hall Reception and shop can be found on entry to the museum and is a brightly lit environment that can get very busy.</p><p>A lot of the décor in the main galleries is wooden, with ceiling spot lights causing patterns and shadow.</p><p>Toilet facilities are located on the ground floor. There is fluorescent lighting in the toilets. The male and female toilets do not have hand dryers, however, the accessible toilet has one sensor operated hand dryer.</p>"
            }
        ],
        "image_path": "stcecilias/laigh-hall.jpg",
        "image_alt": "Visitor exploring the ground-floor galleries. Photograph: Jim Stephenson.",
        "is_visible": true
    },
    {
        "slug": "venue-hire",
        "title": "Venue hire",
        "intro": "St Cecilia’s Hall welcomes bookings for events that complement the museum’s core purpose as a concert hall for live music and museum of music and musical instruments.",
        "body": "<p>With a historic charm and excellent acoustics, it is perfect for concerts, music workshops and music and music history related events. We have two main spaces available to suit a range of events, activities and budgets.</p>",
        "navigation_order": 3,
        "image_path": "stcecilias/concert-room.jpg",
        "image_alt": "The Sypert Concert Room, with elliptical seating and historic organ. Photograph: Jim Stephenson.",
        "sections": [
            {
                "heading": "Sypert Concert Room",
                "content": "<p>With its distinctive elliptical shape and excellent acoustic qualities, the Sypert Concert Room is the perfect place for concerts, lectures, workshops and other music-related events.</p><p>The maximum capacity is 180 (including all event staff, performers, ushers, etc.).</p><p>There is strictly no catering permitted in the Concert Room. Hire includes the use of Laigh Hall, which can be used for receptions and refreshments.</p>"
            },
            {
                "heading": "Laigh Hall",
                "content": "<p>Part of the original building, Laigh Hall is located on the ground floor. Surrounded by displays of our unique historical instrument collection, the space offers a wonderful opportunity for smaller music and music history related events and workshops.</p><p>The maximum capacity is 80. Laigh Hall is divided in two by a glass wall; both spaces comprise Laigh Hall.</p><p>Catering is allowed in Laigh Hall and must be arranged separately by the hirer.</p>"
            },
            {
                "heading": "How to book",
                "content": "<p>To make an enquiry about hiring our venue, please email <a href=\"mailto:SCHEvents@ed.ac.uk\">SCHEvents@ed.ac.uk</a>, or call <a href=\"tel:+441316502600\">0131 650 2600</a>.</p><p>Your key point of contact will be a member of the Museum Assistant Team, who can facilitate a viewing of the space prior to the event (which is recommended) and respond to further enquiries. If you are unsure about whether your event would be suited to the space, please get in touch.</p>"
            },
            {
                "heading": "Sypert Concert Room pricing (Laigh Hall included if needed)",
                "content": "<p>August has a separate pricing structure; please contact us for details. All prices include VAT. Cancellation fees apply if cancelled less than a month before the event.</p><table><thead><tr><th>Day</th><th>Time</th><th>Price</th><th>Additional charges</th></tr></thead><tbody><tr><td>Monday</td><td>Full day (09:00–17:00)</td><td>£960</td><td>Out-of-hours staffing £50 per hour (£200 minimum)</td></tr><tr><td>Tuesday–Friday</td><td>Full day (09:00–17:00)</td><td>£960</td><td>None</td></tr><tr><td>Monday</td><td>Half day (09:00–13:00 or 13:00–17:00)</td><td>£510</td><td>Out-of-hours staffing £50 per hour (£200 minimum)</td></tr><tr><td>Tuesday–Friday</td><td>Half day (09:00–13:00 or 13:00–17:00)</td><td>£510</td><td>None</td></tr><tr><td>Saturday</td><td>Full day (09:00–17:00)</td><td>£1050</td><td>None</td></tr><tr><td>Saturday</td><td>Half day (09:00–13:00 or 13:00–17:00)</td><td>£600</td><td>None</td></tr><tr><td>Monday–Saturday</td><td>Evenings (17:00–22:00)</td><td>£660</td><td>Out-of-hours staffing £50 per hour (£200 minimum)</td></tr></tbody></table>"
            },
            {
                "heading": "Laigh Hall pricing",
                "content": "<p>August has a separate pricing structure; please contact us for details. All prices include VAT. Cancellation fees apply if cancelled less than a month before the event.</p><table><thead><tr><th>Day</th><th>Time</th><th>Price</th><th>Additional charges</th></tr></thead><tbody><tr><td>Monday</td><td>Full day (09:00–17:00)</td><td>£390</td><td>Out-of-hours staffing £50 per hour (£200 minimum)</td></tr><tr><td>Tuesday–Friday</td><td>Full day (09:00–17:00)</td><td>£390</td><td>None</td></tr><tr><td>Monday</td><td>Half day (09:00–13:00 or 13:00–17:00)</td><td>£216</td><td>Out-of-hours staffing £50 per hour (£200 minimum)</td></tr><tr><td>Tuesday–Friday</td><td>Half day (09:00–13:00 or 13:00–17:00)</td><td>£216</td><td>None</td></tr><tr><td>Saturday</td><td>Full day (09:00–17:00)</td><td>£420</td><td>None</td></tr><tr><td>Saturday</td><td>Half day (09:00–13:00 or 13:00–17:00)</td><td>£240</td><td>None</td></tr><tr><td>Monday–Saturday</td><td>Evenings (17:00–22:00)</td><td>£360</td><td>Out-of-hours staffing £50 per hour (£200 minimum)</td></tr></tbody></table>"
            },
            {
                "heading": "Important information",
                "content": "<ul><li><strong>Event delivery:</strong> St Cecilia’s Hall does not provide event management support. Staff are on site mainly for health and safety. You must nominate two members of your team to manage the event.</li><li><strong>Audiovisual equipment:</strong> A screen, projector and lectern with built-in microphone are available at no extra cost. Bring your own laptop and any necessary connector. Additional technical support must be arranged by the hirer.</li><li><strong>Piano:</strong> A Yamaha Boudoir Piano is available. Moving and tuning must be arranged in advance by the hirer; the Museum team can provide contact details.</li><li><strong>Catering:</strong> Arrange your own caterer and inform the Museum team in the booking form. Deliveries must take place during opening hours (Tuesday–Saturday, 10:00–17:00) and be agreed in advance.</li><li><strong>Daytime events:</strong> The museum remains open to the public Tuesday–Saturday, 10:00–17:00.</li><li><strong>Timings:</strong> Everyone must leave by the agreed end time. Overruns incur £50 per 15 minutes.</li></ul><p><a href=\"https://www.stcecilias.ed.ac.uk/wp-content/uploads/2025/07/St-Cecilias-Hall-Terms-and-Conditions-Venue-Hire.pdf\">Download Venue Hire Terms and Conditions (PDF)</a>. Please review these before booking.</p>"
            }
        ],
        "gallery": [
            {
                "path": "stcecilias/concert-room.jpg",
                "alt": "Sypert Concert Room",
                "caption": "Sypert Concert Room · Jim Stephenson"
            },
            {
                "path": "stcecilias/laigh-hall.jpg",
                "alt": "Laigh Hall galleries",
                "caption": "Laigh Hall · Jim Stephenson"
            }
        ],
        "is_visible": true
    },
    {
        "slug": "whats-on",
        "title": "What’s on",
        "intro": "Concerts, tours and activities at St Cecilia’s Hall. Discover the instruments, hear their stories and experience live music in a historic setting.",
        "body": "",
        "navigation_order": 2,
        "is_visible": true
    }
]
JSON, true, flags: JSON_THROW_ON_ERROR);
        foreach ($pages as $page) {
            StceciliasPage::query()->firstOrCreate(['slug' => $page['slug']], $page);
        }
        $events = json_decode(<<<'JSON'
[
    {
        "slug": "volunteer-led-tour-7",
        "title": "Volunteer-Led Tour",
        "starts_at": "2026-11-03 14:00",
        "ends_at": "2026-11-03 15:00",
        "category": "Tour",
        "intro": "Join volunteer Claire for a tour of the Binks and 1812 Galleries and learn about all things keyboards.",
        "price": "Free / Donations appreciated",
        "booking_url": "https://www.eventbrite.co.uk/e/november-tours-at-st-cecilias-hall-tickets-2003337255660",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "volunteer-led-tour-8",
        "title": "Volunteer-Led Tour",
        "starts_at": "2026-11-13 14:00",
        "ends_at": "2026-11-13 15:00",
        "category": "Tour",
        "intro": "Join volunteer Dona for a tour of the Binks and 1812 Galleries and learn about some of the oldest keyboard instruments in our collection.",
        "price": "Free / Donations appreciated",
        "booking_url": "https://www.eventbrite.co.uk/e/november-tours-at-st-cecilias-hall-tickets-2003337255660",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "the-saltire-society-90th-anniversary-concert",
        "title": "The Saltire Society 90th Anniversary Concert",
        "starts_at": "2026-11-14 14:00",
        "ends_at": "2026-11-14 16:00",
        "category": "Concert",
        "intro": "This special anniversary concert will feature the world premiere of Gemma McGregor’s composition inspired by the Ness of Brodgar in Orkney. Hosted by the Saltire Society.",
        "price": "£10",
        "booking_url": "https://events.humanitix.com/90th-concert",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "winter-family-trail-2",
        "title": "Winter Family Trail",
        "starts_at": "2026-11-17 10:00",
        "ends_at": "2026-12-19 15:00",
        "category": "Family activity",
        "intro": "Join us this Winter for a free, fun, themed family trail! Spot the eight snow people hidden throughout the galleries and answer their music-related questions.",
        "price": "Free / Donations appreciated",
        "booking_url": "https://www.eventbrite.co.uk/e/winter-family-trail-tickets-2004059840932",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "volunteer-led-tour-9",
        "title": "Volunteer-Led Tour",
        "starts_at": "2026-11-20 14:00",
        "ends_at": "2026-11-20 15:00",
        "category": "Tour",
        "intro": "Join volunteer Sabine for a tour of the brass collection at St Cecilia’s Hall.",
        "price": "Free / Donations appreciated",
        "booking_url": "https://www.eventbrite.co.uk/e/november-tours-at-st-cecilias-hall-tickets-2003337255660",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "luke-wright-later-life-letter",
        "title": "Luke Wright: Later Life Letter",
        "starts_at": "2026-11-26 19:00",
        "ends_at": "2026-11-26 21:00",
        "category": "Concert",
        "intro": "Scottish Adoption and Fostering, in conjunction with Adoption UK, present Luke Wright’s Later Life Letter for one special night in Edinburgh.",
        "price": "£11.55 – £13.70",
        "booking_url": "https://www.eventbrite.co.uk/e/luke-wright-later-life-letter-tickets-2003293521851",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "volunteer-led-tour-10",
        "title": "Volunteer-Led Tour",
        "starts_at": "2026-11-28 14:00",
        "ends_at": "2026-11-28 15:00",
        "category": "Tour",
        "intro": "Join volunteer Jim for a tour of the Wolfson Gallery and learn about the development of instruments over time.",
        "price": "Free / Donations appreciated",
        "booking_url": "https://www.eventbrite.co.uk/e/november-tours-at-st-cecilias-hall-tickets-2003337255660",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "the-georgian-concert-society-bach-cello-suites-nos-4-6",
        "title": "The Georgian Concert Society: Bach Cello Suites Nos 4–6",
        "starts_at": "2026-11-28 16:30",
        "ends_at": "2026-11-28 17:30",
        "category": "Concert",
        "intro": "The Georgian Concert Society welcomes Jonathan Manson back to St Cecilia’s Hall for Bach’s Suites 4, 5 and 6.",
        "price": "£12 – £27",
        "booking_url": "https://www.thequeenshall.net/whats-on/bachs-cello-suites-georgian-concert-society",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "university-of-edinburgh-st-andrews-day-concert",
        "title": "University of Edinburgh St Andrew’s Day Concert",
        "starts_at": "2026-11-30 19:00",
        "ends_at": "2026-11-30 20:30",
        "category": "Concert",
        "intro": "All are welcome to the annual St Andrew’s Day concert, hosted by Celtic and Scottish Studies and the School of Scottish Studies Archive. Tickets are free but registration is required.",
        "price": "Free",
        "booking_url": "https://www.eventbrite.co.uk/e/university-of-edinburgh-st-andrews-day-concert-tickets-2002282597148",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "edinburgh-renaissance-bands-christmas-concert-2026",
        "title": "Edinburgh Renaissance Band’s Christmas Concert 2026",
        "starts_at": "2026-12-13 15:00",
        "ends_at": "2026-12-13 16:00",
        "category": "Concert",
        "intro": "The best of medieval and renaissance festive music, on period instruments of every kind. Friendly presentation. For all the family.",
        "price": "£11.55",
        "booking_url": "https://www.eventbrite.co.uk/e/edinburgh-renaissance-bands-christmas-concert-2026-tickets-2000656591722",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    },
    {
        "slug": "the-georgian-concert-society-devine-fantasias",
        "title": "The Georgian Concert Society: Devine Fantasias",
        "starts_at": "2027-02-20 16:30",
        "ends_at": "2027-02-20 17:30",
        "category": "Concert",
        "intro": "Steven Devine plays works from across the classical period on St Cecilia’s Hall’s collection of historical keyboards.",
        "price": "£12 – £27",
        "booking_url": "https://www.thequeenshall.net/whats-on/devine-fantasias-georgian-concert-society",
        "is_visible": true,
        "venue": "St Cecilia’s Hall"
    }
]
JSON, true, flags: JSON_THROW_ON_ERROR);
        $visitorPage = StceciliasPage::query()->where('slug', 'planning-your-visit')->first();
        if ($visitorPage && $visitorPage->visitor_information === null) {
            $visitorPage->update(['visitor_information' => [
                'opening_hours' => 'Tuesday–Saturday, 10:00–17:00',
                'last_entry' => 'Last entry 16:30',
                'closed_days' => 'Closed Sunday and Monday',
                'admission' => 'Free admission',
                'address' => '50 Niddry Street, Edinburgh EH1 1LG',
            ]]);
        }
        if ($visitorPage) {
            $sections = array_values(array_filter($visitorPage->sections ?? [], fn (array $section): bool => $section !== [
                'heading' => 'Opening hours',
                'content' => '<p>Tuesday–Saturday, 10:00–17:00. Last entry 16:30.</p><p>Closed Sunday and Monday.</p>',
            ]));
            if ($sections !== $visitorPage->sections) {
                $visitorPage->update(['sections' => $sections]);
            }
            if ($visitorPage->body === '<p>Admission to the Museum is free. Donations are appreciated.</p>') {
                $visitorPage->update(['body' => '']);
            }
        }
        $images = ['the-saltire-society-90th-anniversary-concert' => 'saltire', 'luke-wright-later-life-letter' => 'luke-wright', 'the-georgian-concert-society-bach-cello-suites-nos-4-6' => 'cello'];
        foreach ($events as $event) {
            if (isset($images[$event['slug']])) {
                $event['image_path'] = 'stcecilias/'.$images[$event['slug']].'.jpg';
                $event['image_alt'] = $event['title'];
            }
            StceciliasEvent::query()->firstOrCreate(['slug' => $event['slug']], $event);
        }
    }
}
